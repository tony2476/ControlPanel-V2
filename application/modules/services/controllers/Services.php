<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends Private_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('services/services_model');
		$this->services = New Services_model;
	}

	public function index()
	{
	}

	public function list_services()
	{
		$this->template->set_title("Services.");
		//$help_data = $this->display_help->display_help();

		$services = array 
		(
			'services' => $this->services->list_all(),
			);

		$page_data = $this->parser->parse('services/services_list_view', $services, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();

	}
}