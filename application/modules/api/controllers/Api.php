<?php defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/third_party/restserver/libraries/REST_Controller.php');
class Api extends REST_Controller
{

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('api/api_model');
		$this->api = New Api_model;

		$this->load->model('recaptcha/recaptcha_model');
		$this->recaptcha = New Recaptcha_model;

	}

	public function recaptcha_get()
	{
		if(!$this->get('domain'))
		{
			$this->response(NULL, 400);
		}

		$response['recaptcha_secret_key'] = $this->recaptcha->get_secret_by_domain($this->get('domain'));
		$response['recaptcha_site_key'] = $this->recaptcha->get_site_key_by_domain($this->get('domain'));

		if ($response['recaptcha_site_key'] == '' || $response['recaptcha_secret_key'] == '')
		{
			$this->response(NULL, 400);
		}

		$this->response($response, 200); // 200 being the HTTP response code
	}

	public function recaptcha_validate_get()
	{
		if(!$this->get('g-recaptcha-response'))
		{
			$this->response(NULL, 400);
		}
		$gRecaptchaResponse = $this->get('g-recaptcha-response');
		$secret_key 		= $this->get('public_key');
		$site_key 			= $this->get('site_key');
		$remoteIp			= $this->get('remoteIp');

		$recaptcha = new \ReCaptcha\ReCaptcha($this->secret_key);
		$resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);
		if ($resp->isSuccess()) {
			$this->response($response, 200); 
		} else {
			$this->response(NULL, 400);
		}
	}

//$recaptcha = new \ReCaptcha\ReCaptcha($this->secret_key);
	public function test_get()
	{
		$json = '{"secret_key":"6Ldk8xAUAAAAAG_98puXPyx5MxdFRIMKkckMtHhX","site_key":"6Ldk8xAUAAAAAG_98puXPyx5MxdFRIMKkckMtHhX"}';
		echo $json;
		$output = json_decode($json, true);
		echo "<pre>";
		echo "output <br />";
		print_r ($output);
		echo "</pre>";
		
		
	}
}