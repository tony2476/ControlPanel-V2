<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Core Class all other classes extend
 */
class MY_Controller extends MX_Controller {

	var $_container;
	var $_modules;
	var $user;

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Load the ion_auth library from the third_party folder.  Use add_package_path() so that all future calls to that library prepend the path.
		// I kept the entire ion_auth library in it's own folder to make updates easier and for encapsulation.  Everything relating to ion_auth is in that directory.
		$this->load->add_package_path(APPPATH.'third_party/ion_auth') -> library('ion_auth');

		// This is for debugging and should be removed when we go live.
		$this->load->add_package_path(APPPATH.'third_party/chromephp') -> library('chromephp');


		
		// Form Validation
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;


		// Load Globally Required Modules.
		$this->load->model('display_help/display_help_model');
		$this->load->module('template');
		$this->load->module('menu');
		

		// Load Globally Required Libraries.
		$this->load->library('parser');
		$this->load->library('ion_auth');
		

		// Load Globally Required Helpers.
		$this->load->helper('url', 'form');

		// Load Application Config.  This contains configuration data that is Global but is not directly related to the configuration of codeigniter itself.
		$this->config->load('application');

		// Set the default template, from the config file.
		$this->template->set_template($this->config->item('default_template'));

		$this->display_help = New Display_help_model;

		//Load user data (if logged in)
		if ($this->ion_auth->logged_in()) {
	
			$this->user = $this->ion_auth->user()->row();
		}

	}
}