<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plesk extends Public_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('plesk/plesk_model');
		$this->plesk = New Plesk_model;

		$email = 'karl@gray.me.uk';
		echo $this->plesk->get_username_from_email($email);
		echo "<br />" . $this->plesk->get_domain_from_email($email);
	}
}