<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mailinglist extends Private_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('salesforce/salesforce_model');
		$this->salesforce = New Salesforce_model;
		$this->fullname = $this->user->first_name . " " . $this->user->last_name;
		
	}

	public function index ()
	{

	}
	
	function _remap()
	{
		$this->session->set_flashdata('message', "That functionality has not been implemented yet.");
			redirect('/', 'refresh');
	}

}