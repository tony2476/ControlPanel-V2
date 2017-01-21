<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Core Class all other classes extend
 */
class MY_Controller extends MX_Controller {

	var $_container;
	var $_modules;

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		
		// Set container variable
		$this->_container = $this->config->item('my_application_admin_template_dir_public') . "layout.php";
		$this->_modules = $this->config->item('modules_locations');

		log_message('debug', 'CI My Admin : MY_Controller class loaded');
		
		$this->load->add_package_path(APPPATH.'third_party/ion_auth') -> library('ion_auth');

	}
}