<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends Public_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		//$this->load->model('help/help_model');
		//$this->help = New Help_model;
	}

	public function index()
	{
	}

	public function get_help()
	{
		echo "/" . $this->router->class ."/" . $this->router->method;
	}
}