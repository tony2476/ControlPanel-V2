<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RBACL:
 * 
 * Please see the documentation for what Role Based Access Control Lists are.
 * 
 * 
 */

class rbacl extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		
		// Load the module config file.
		$this->load->config('config');
	}

}