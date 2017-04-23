<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends Admin_Controller {

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
		
		$services = array 
		(
			'services' => $this->services->list_all(),
			);
		
		$this->template->disable_help();
		$page_data = $this->parser->parse('services/services_list_view', $services, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}


	public function list_service_groups()
	{
		$this->template->set_title("Services.");
		
		$service_groups = array 
		(
			'service_groups' => $this->services->get_service_groups(),
			);

		$this->template->disable_help();
		$page_data = $this->parser->parse('services/service_groups_list_view', $service_groups, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function add_service_group()
	{
		$service_group_id = $this->uri->segment(3);

	}

	public function toggle_service_group()
	{
		$service_group_id = $this->uri->segment(3);
		
		if ($this->services->toggle_group_status($service_group_id))
		{
			$this->session->set_flashdata('message', "Service group status toggled ok.");
		}
		else
		{
			$this->session->set_flashdata('error', "Failed to toggle service group status");
		}

		redirect('services/list_service_groups', 'refresh'); 
	}


}
