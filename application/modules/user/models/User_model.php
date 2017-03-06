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

}