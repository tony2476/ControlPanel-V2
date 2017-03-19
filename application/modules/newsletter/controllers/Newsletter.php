<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter extends Private_Controller {

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

	public function index()
	{

	}

	public function settings()
	{


		$this->template->set_title("E-Newsletter Settings.");
		$help_data = $this->display_help->display_help();

		//Process cached SF Data
		$this->salesforce->populate_cache($this->user->sf_contact_id);
		$sf_data = clone $this->session->userdata('sf_cache');

		if (!is_object($sf_data))
		{
			$this->session->set_flashdata('error', "We cannot locate any data for this user.");
			redirect('/','refresh');	
		}		

		$banner_image = (intval($sf_data->Account->fields->Drupal_Domain_ID__c) !== 0 ? "<img src = \"https://www.financialwisdom.ca/data/e-newsletter/" . intval($sf_data->Account->fields->Drupal_Domain_ID__c) . "/images/banner.png\">" : '');


		$birthday_card = form_input(array('name'=>'e_Card_Data__c', 'value'=>set_value('e_Card_Data__c', (isset($contact_details['e_Card_Data__c']) ? $contact_details['e_Card_Data__c'] : '')), 'class'=>'form-control', 'readonly'=>'true'));
		

		
		$sf_account_data = $sf_data->Account->fields;
		unset ($sf_data->Account);

		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			'banner_image' => $banner_image,
			);
		
		$form = $form + (array) $sf_account_data + (array) $sf_data + $help_data;

		$page_data = $this->parser->parse('newsletter/newsletter_settings_form_view', $form, TRUE);

		if (validation_errors())
		{
			$this->session->set_flashdata('message', validation_errors());
		}
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}
}