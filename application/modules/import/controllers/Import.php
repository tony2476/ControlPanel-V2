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
		echo "Getting required contact records";
		$list = $this->sf->importer_get_contact_records();
		/*foreach ($list as $user) 
		{
			echo $user->Account->fields->Name;
			echo "<br />";
		}

		echo "<pre>";
		echo "list <br />";
		print_r ($list);
		echo "</pre>";
		return; */

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
			
			/*echo "$username, $password, $email";
			echo "<pre>";
			echo "additional data <br />";
			print_r ($additional_data);
			echo "</pre>";
			*/
			
			
			// save the new user in ion auth.
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