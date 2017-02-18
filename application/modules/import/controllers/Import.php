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
		
		if(!$this->ion_auth->in_group('admin'))
		{
			$this->session->set_flashdata('message','You are not allowed to visit the Groups page');
			redirect('/','refresh');
		}
		$this->load->model('salesforce/salesforce_model');
		$this->sf = new Salesforce_model;
	}

	public function index()
	{
		echo "Getting All ID's for all accounts<br />";
		$list = $this->sf->get_all_account_id();
				
		foreach ($list as $account_id => $data)
		{
			
			echo $account_id . " : " . $data . "<br />";
			
		}

		

	}
}