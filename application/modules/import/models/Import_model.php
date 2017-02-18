<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * 
 * @author Karl Gray
 * @copyright  2016 Advisornet / Tony Richardson
 * @package    Advisornet Control Panel
 */

class Import_model extends CI_Model 
{
	private $errors = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('salesforce_library');
	}
}