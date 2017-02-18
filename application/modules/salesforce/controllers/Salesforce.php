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

class Salesforce extends Admin_Controller
{

	private	$sfresult='';
	private $sf;

	function __construct()
	{

		parent::__construct();
		
		$this->load->model('salesforce_model');
		$this->sf = new Salesforce_model;
		if(!$this->ion_auth->in_group('admin'))
		{
			$this->session->set_flashdata('message','You are not allowed to visit the Groups page');
			redirect('/','refresh');
		}

		
	}

	public function index()
	{
		
		$sfresult = '';
		$sf_account_id = '0014000000s14fyAAA';
		$sfresult = $this->sf->get_all_company_records($sf_account_id);

		
		$this->template->set_title("Dashboard");

		
		$page_data = "<pre>" . print_r ($sfresult, TRUE) . "</pre>";

		$this->template->set_page_data($page_data);
		$this->template->display_page();
		
	}

}