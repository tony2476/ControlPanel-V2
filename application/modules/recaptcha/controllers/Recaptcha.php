<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Recaptcha extends Admin_Controller {

	private $result;
	private $site_key = '6LdhFB8UAAAAACZZtL9ojPQyTUE2xwtCR_x61nJx';
	private $secret_key = '6LdhFB8UAAAAAH-gSL_To-YXU5YUvaqAXN4GAeQt';

	function __construct()
	{
		parent::__construct();
		$this->load->model('recaptcha/recaptcha_model');
		$this->recaptcha = New Recaptcha_model;

		$this->load->model('salesforce/salesforce_model');
		$this->salesforce = New Salesforce_model;



	}

	public function test()
	{
		$sf_account_id = '0014000000fpCt1AAE';
		$records = $this->salesforce->get_all_company_records($sf_account_id);
		$page_data = "company: $records->Company_Name__c <br />";
		$page_data .= "Secret Key: $records->reCaptcha_Secret_Key__c <br />";
		$page_data .= "Site Key: $records->reCaptcha_Site_Key__c <br />";
		$page_data .= "Recaptcha Enabled: $records->IEM_reCaptcha_Enabled__c<br />";

		$page_data .= "<br />";
		
		$sf_account_id = '0014000000cfGo4AAE';
		$records = $this->salesforce->get_all_company_records($sf_account_id);
		$page_data .= "company: $records->Company_Name__c <br />";
		$page_data .= "Secret Key: $records->reCaptcha_Secret_Key__c <br />";
		$page_data .= "Site Key: $records->reCaptcha_Site_Key__c <br />";
		$page_data .= "Recaptcha Enabled: $records->IEM_reCaptcha_Enabled__c<br />";	

		$this->template->disable_help();
		$this->template->set_page_data($page_data);
		$this->template->display_page();	
	}

	public function test_form()
	{
		$form_data = array(
			'google_site_key' => $this->site_key,
			'form_open' => form_open('/recaptcha/test_form_submit', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);

		$this->template->set_title("Recaptcha test form");
		$this->template->disable_help();
		$page_data = $this->parser->parse('recaptcha/test_form_view', $form_data	, TRUE);
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function test_form_submit()
	{
		$confirmation_data = $this->input->post();
		echo "<pre>";
		echo "confirmation data <br />";
		print_r ($confirmation_data);
		echo "</pre>";
		
		$this->load->library('user_agent');
		$url = $this->agent->referrer();
		$bang = explode("/", $url);
		$domain = $bang[2];
		echo $domain;

		#Temporary hardwire domain.
		$domain = "summit1.advisornet.ca";
		$sf_account_id = $this->salesforce->get_account_id_by_domain($domain);
		$records = $this->salesforce->get_all_company_records($sf_account_id);
		$gRecaptchaResponse = $this->input->post('g-recaptcha-response');

		$secret_key 		= $records->reCaptcha_Secret_Key__c;
		$site_key 			= $records->reCaptcha_Site_Key__c;
		$captcha_enabled 	= $records->IEM_reCaptcha_Enabled__c;
		$remoteIp			= $_SERVER['REMOTE_ADDR'];

		$recaptcha = new \ReCaptcha\ReCaptcha($this->secret_key);
		$resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);
		if ($resp->isSuccess()) {
   		// verified!
   		// if Domain Name Validation turned off don't forget to check hostname field
   		// if($resp->getHostName() === $_SERVER['SERVER_NAME']) {  }
   		echo "SUCCESS";
		} else {
			$errors = $resp->getErrorCodes();
			
		}

	}
}