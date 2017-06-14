<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Recaptcha_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_secret_by_domain($domain)
	{
		$this->db->select('u.reCaptcha_Secret_Key');
		$this->db->from('users u');
		$this->db->where("u.primary_domain = '$domain'");
		$query = $this->db->get();
		$result = $query->row_array();
		return ($result['reCaptcha_Secret_Key']);
	}

	public function get_site_key_by_domain($domain)
	{
		$this->db->select('u.reCaptcha_Site_Key');
		$this->db->from('users u');
		$this->db->where("u.primary_domain = '$domain'");
		$query = $this->db->get();
		$result = $query->row_array();
		return ($result['reCaptcha_Site_Key']);
	}
}