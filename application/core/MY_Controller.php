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
		
		
		/*  DELETE THIS !!
		// Set container variable
		//$this->_container = $this->config->item('my_application_admin_template_dir_public') . "layout.php";
		//$this->_modules = $this->config->item('modules_locations');

		*/

		log_message('debug', 'CI My Admin : MY_Controller class loaded');
		
		// Load the ion_auth library from the third_party folder.  Use add_package_path() so that all future calls to that library prepend the path.
		// I kept the entire ion_auth library in it's own folder to make updates easier and for encapsulation.  Everything relating to ion_auth is in that directory.
		$this->load->add_package_path(APPPATH.'third_party/ion_auth') -> library('ion_auth');

		// Load Globally Required Modules.
		$this->load->module('template');
		$this->load->module('menu');
		
		
		// Load Globally Required Libraries.
		$this->load->library('parser');

		// Load Globally Required Helpers.
		$this->load->helper('url');

		// Load Application Config.  This contains configuration data that is Global but is not directly related to the configuration of codeigniter itself.
		$this->config->load('application');

		// Set the default template, from the config file.
		$this->template->set_template($this->config->item('default_template'));

	}
}