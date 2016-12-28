<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Core Class all other classes extend
 */
class MY_Controller extends CI_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/ion_auth') -> library('ion_auth');

	}
}