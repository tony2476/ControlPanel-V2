<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model 
{

	// Default table name,  can be modified using constructor call.
	private 	$dbtable = 'users';
	public function __construct($dbtablename = null)
	{
		parent::__construct();
		//$this->load->library('ion_auth');

		// Set tablename if passed.  Default is 'owners'
		if ($dbtablename) {
			$this->dbtable = $dbtablename;
		}
	}

	public function list_all_users()
	{
		$query = $this->db->get($this->dbtable);
		$results = $query->result();

		foreach ($results as $result) {
			$id = $result->id;
			if ($result->active) {
				$result->colour = 'btn-success';
				$result->icon = 'glyphicon-pause';
			}
			else 
			{
				$result->colour = 'btn-warning';	
				$result->icon = 'glyphicon-play';
			}
		}
		return ($results);
	}

	public function is_assistant($assistant_id)
	{
		// Make sure this user is an account owner.
		if (!$this->ion_auth->in_group('owner'))
		{
			$this->session->set_flashdata('error', 'You are not an account owner and cannot access this feature.');
		}
		// First get the assistant records.
		if (!$this->assistant = $this->ion_auth->user($assistant_id)->row())
		{
			$this->session->set_flashdata('error', "Error: Couldn't retrieve any details for assistant ID $assistant_id");
			return FALSE;
		}

		// Get this users records.
		$this->user = $this->ion_auth->user()->row();
				
		// Are they from the same SF_Account?
		if ($this->user->sf_account_id != $this->assistant->sf_account_id)
		{
			$this->session->set_flashdata('error', "Error: That user does not appear to belong to your account.");
			return FALSE;
		}
		return TRUE;
	}

	public function list_all_assistants()
	{
		$this->user = $this->ion_auth->user()->row();
		$user_id = $this->user->id;
		$sf_account_id = $this->user->sf_account_id;

		$sql = "
		SELECT * 
		FROM users
		WHERE sf_account_id = '$sf_account_id'
		AND id != '$user_id' 
		";

		$query = $this->db->query($sql);

		$results = $query->result();
		foreach ($results as $result) {
			$id = $result->id;
			if ($result->active) {
				$result->colour = 'btn-success';
				$result->icon = 'glyphicon-pause';
			}
			else 
			{
				$result->colour = 'btn-warning';	
				$result->icon = 'glyphicon-play';
			}
		}
		return ($results);
	}

	// Creates a user.  This will be a owner account.  Do not use this to create admins or assistants.
	public function create_user($email, $firstname, $lastname)
	{

		$username = $firstname . $lastname;
		$password = $this->generateStrongPassword();
		$additional_data = array(
								'first_name' => $firstname,
								'last_name' => $lastname,
								);
		$group = array('2'); // Sets user to admin.

		if (!$result = $this->ion_auth->register($username, $password, $email, $additional_data, $group))
		{
			return FALSE;
		}
		return ($result);
	}

	public function update_beanstream_profile_id($user_id, $profile_id)
	{
		$sql = "update users set beanstream_id = '$profile_id' where id = '$user_id'";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to set the beanstream id";
			return (FALSE);
		}
		return (TRUE);
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