<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *  NOT A PART OF THE CONTROL PANEL FINAL AREA
 *
 * This is just a testing ground for new SF API functionality.
 *
 *  It is hacky and horrible and should not be used for production purposes. EVER!!!!
 *
 * @author Karl Gray
 * @copyright  2016 Advisornet / Tony Richardson
 * @package    Advisornet Control Panel
 *
 */

class Import extends Admin_Controller
{

	private	$sfresult='';
	private $sf;

	function __construct()
	{

		parent::__construct();
		
		if (!$this->session->is_admin)
		{
			$this->session->set_flashdata('error', 'You need to be logged in as an administrator to access that feature.');
			redirect('/', 'refresh');
		}
		$this->load->model('salesforce/salesforce_model');
		$this->sf = new Salesforce_model;

		$this->load->model('plesk/plesk_model');
		$this->plesk = New Plesk_model;
	}

/*
	get all ID's and required user data to create a new user for each one.
	first_name
	last_name
	username (domain)
	password
	Company Name
	email
	sf_account_id
	sf_contact_id
	plesk_email
	plesk_site_id
	plesk_mailbox_id
	sendy_app
	owner (boolean)

 */
	public function index()
	{

	}


	public function populate_province()
	{
		$list = $this->sf->get_all_account_provinces();
		foreach ($list as &$item)
		{
			if (strlen ( $item->BillingState ) == 2)
			{
				//echo "GOOD: Province $item->BillingState<br />";
			}
			else
			{
				//echo "BAD: Province $item->BillingState<br />";
				switch ($item->BillingState) {
					case "Ontario":
						$item->BillingState = "ON";
					break;
					case "Alberta":
						$item->BillingState = "AB";
					break;
					case "UAE":
						$item->BillingState = "";
					break;
					case "Greater London":
						$item->BillingState = "";
					break;
				}	
				//echo "BAD: Province replaced with $item->BillingState <br />";
			}
		}
		

		foreach ($list as $item)
		{
			if ($item->BillingState !='')
			{
				$data = array 
					(
						'province' => $item->BillingState,
						);
					$this->db->where('sf_account_id', $item->Id);
					$this->db->update('users', $data);
			}
		}
		
	}

	public function populate_recaptcha_cache()
	{
		$list = $this->sf->get_all_recaptchas();
		/*(echo "<pre>";
		echo "list <br />";
		print_r ($list);
		echo "</pre>";*/
		
		
		foreach ($list as $user) 
		{
			$sf_account_id = $user->Id;
			$domain = $user->Domain_Name__c;
			$reCaptcha_Secret_Key = $user->reCaptcha_Secret_Key__c;
			$reCaptcha_Site_Key = $user->reCaptcha_Site_Key__c;


			$this->db->select('u.id');
			$this->db->from('users u, users_groups g');
			$this->db->where('g.user_id = u.id');
			$this->db->where('g.group_id = 2');
			$this->db->where("u.sf_account_id = '$sf_account_id'");
			$query = $this->db->get();
			$result = $query->row_array();
			$id = $result['id'];

			$data = array 
			(
				'reCaptcha_Secret_Key' => $reCaptcha_Secret_Key,
				'reCaptcha_Site_Key' => $reCaptcha_Site_Key,
				'primary_domain' => $domain,
				);
			
			$this->db->where('id', $id);
			$this->db->update('users', $data);
			

		}
	}

	/* This routine is used to import a single company into the system */
	public function import_company()
	{
		if ($this->form_validation->run('company_name') == TRUE) {
			$company_name = $this->input->post('company');
			$this->session->set_flashdata('message',"Company name $company_name was imported succesfully.");


			/* Import the contact records from SF for this company */
			$error_text = '';
			$list = $this->sf->importer_get_contact_record($company_name);
			foreach ($list as $user) 
			{
				$username = str_replace(' ','',$user->Name);
				$password = $user->Email_Password__c;
				$email = $user->Email;
				if ($password=='none')
				{
					$password = $this->generateStrongPassword();
				}

				if ($user->Web_Agreement__c == 'Received') {
					$group = array(2);
				} 
				else
				{
					$group = array(3);
				}

				$sf_contact_id = $user->Id;
				$sf_account_id = $user->AccountId;

				$additional_data = array(
					'first_name' => $user->FirstName,
					'last_name' => $user->LastName,
					'sf_contact_id' => $user->Id,
					'sf_account_id' => $user->AccountId,
					'company' => $user->Account->fields->Company_Name__c,

					);


				if (!$saved = $this->ion_auth->register($username, $password, $email, $additional_data, $group))
				{
					$error_text .= "Failed for $username <br />";
					continue;
				} 
				
				if ($this->sf->is_plesk_enabled($email))
				{
					$data = array 
					(
						'plesk_email' => $email,
						);
					$this->db->where('id', $saved);
					$this->db->update('users', $data);

					$username = $this->plesk->get_username_from_email($email);
					$domain = $this->plesk->get_domain_from_email($email);
					if (!$plesk_mailbox_id = $this->plesk->get_mailbox_id($username, $domain))
					{
						echo "Failed mailbox id $email<br />";
						echo $this->plesk->errcode;
						echo $this->plesk->errtext;
						continue;

					}

					if (!$plesk_site_id = (string) $this->plesk->get_site_id($domain))
					{
						echo "Failed site id $email<br />";
						flush();
						continue;
					}
					
					$data = array 
					(
						'plesk_site_id' => $plesk_site_id,
						'plesk_mailbox_id' => $plesk_mailbox_id,
						);

					$this->db->where('plesk_email', $email);
					$this->db->update('users', $data);
				}
			}
		}

		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-signin')),
			'form_close' => form_close(),
			);

		if (validation_errors()) {
			$this->session->set_flashdata('message',validation_errors());
		}
		$page_data = $this->parser->parse('import/import_company_form_view', $form, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}


	/*  THIS IS THE BULK IMPORT ROUTINES.  They should not be used */

	public function populate_plesk_cache()
	{
		$this->load->model('plesk/plesk_model');
		$this->plesk = New Plesk_model;
		$query = $this->db->where('plesk_email !=', '')->group_start()->where('plesk_mailbox_id','')->or_where('plesk_site_id','')->group_end()->get('users');

		echo "found: " . $query->num_rows();
		foreach ($query->result() as $row)
		{
			echo $row->username . "<br />";
			$email = $row->plesk_email;
			$username = $this->plesk->get_username_from_email($email);
			$domain = $this->plesk->get_domain_from_email($email);
			if (!$plesk_mailbox_id = $this->plesk->get_mailbox_id($username, $domain))
			{
				echo "Failed mailbox id $email<br />";
				flush();
				continue;

			}

			if (!$plesk_site_id = (string) $this->plesk->get_site_id($domain))
			{
				echo "Failed site id $email<br />";
				flush();
				continue;
			}
			echo $plesk_mailbox_id . "<br />
			$plesk_site_id<br />";


			$data = array 
			(
				'plesk_site_id' => $plesk_site_id,
				'plesk_mailbox_id' => $plesk_mailbox_id,
				);
			echo "<pre>";
			echo "plesk <br />";
			echo "$email <br />";
			print_r ($data);
			echo "</pre>";



			$this->db->where('plesk_email', $email);
			$this->db->update('users', $data);

		}
	}

	public function add_plesk_email()
	{
		$list = $this->sf->importer_get_plesk_enabled();
		foreach ($list as $item)
		{
			$id = $item->Id;
			$email = $item->Email;
			$user_id = "not found";
			$query = $this->db->where('sf_contact_id', $id)->get('users');
			$result = $query->row();
			if ($query->num_rows() > 0)
			{
				$user_id = $result->id;
			}
			//echo "SFid: $id, $user_id<br />";
			$data = array 
			(

				'plesk_email' => $email,
				);
			$this->db->where('id', $user_id);
			$this->db->update('users', $data);
		}
	}

	public function primary_import()
	{
		echo "Getting required contact records";
		$list = $this->sf->importer_get_contact_records();
		foreach ($list as $user) 
		{


			$username = str_replace(' ','',$user->Name);
			$password = $user->Email_Password__c;
			$email = $user->Email;
			if ($password=='none')
			{
				$password = $this->generateStrongPassword();
			}

			if ($user->Web_Agreement__c == 'Received') {
				$group = array(2);
			} 
			else
			{
				$group = array(3);
			}

			$additional_data = array(
				'first_name' => $user->FirstName,
				'last_name' => $user->LastName,
				'sf_contact_id' => $user->Id,
				'sf_account_id' => $user->AccountId,
				'company' => $user->Account->fields->Company_Name__c,

				);


			if (!$saved = $this->ion_auth->register($username, $password, $email, $additional_data, $group))
			{
				echo "Failed for $username <br />";
			}
		}
	}


	/**
	 * Source: https://gist.github.com/tylerhall/521810
	 * @param type $length 
	 * @param type|bool $add_dashes 
	 * @param type|string $available_sets 
	 * @return type
	 */
	public function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
	{
		$sets = array();
		if(strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if(strpos($available_sets, 's') !== false)
			$sets[] = '!#$%*';
		$all = '';
		$password = '';
		foreach($sets as $set)
		{
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}
		$all = str_split($all);

		for($i = 0; $i < $length - count($sets); $i++)
			$password .= $all[array_rand($all)];

		$password = str_shuffle($password);

		if(!$add_dashes)
			return $password;

		$dash_len = floor(sqrt($length));
		$dash_str = '';

		while(strlen($password) > $dash_len)
		{
			$dash_str .= substr($password, 0, $dash_len) . '-';
			$password = substr($password, $dash_len);
		}
		$dash_str .= $password;
		return $dash_str;
	}

}