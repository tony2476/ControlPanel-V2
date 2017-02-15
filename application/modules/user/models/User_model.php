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
		$result = $query->result();
		
		
		return ($result);
		
	}
}