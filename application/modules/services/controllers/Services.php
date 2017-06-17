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

		$this->config->load('services/form_validation');
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
		if ($this->form_validation->run('service_group') == TRUE)
		{
			$this->services->add_service_group($this->input->post());
			$this->session->set_flashdata('info', "Service Group Created.");
			redirect('/services/list_service_groups','refresh');
		}

		$form = array 
		(
			'form_open' => form_open('/services/add_service_group', array ('class'=>'form-horizontal')),
			'form_close' => form_close(),
			'service_groups' => $this->services->get_service_groups(),
			);
		
		$this->template->set_title("Add Service Group.");
		$page_data = $this->parser->parse('services/add_service_group_form_view', $form, TRUE);
		if (validation_errors())
		{
			$this->session->set_flashdata('message', validation_errors());
		}
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function add_service()
	{
		if ($this->form_validation->run('services') == TRUE)
		{
			$this->services->add_service($this->input->post());
			$this->session->set_flashdata('info', "Service Created.");
			redirect('/services/list_services','refresh');
		}

		$form = array 
		(
			'form_open' => form_open('/services/add_service', array ('class'=>'form-horizontal')),
			'form_close' => form_close(),
			'service_groups' => $this->services->get_service_groups(),

			);
		if ($this->input->post())
		{
			$form = $form + $this->input->post();
		}
		else
		{
			$blank = array 
			(
				'short_code'		=>	'',
				'description'		=>	'',
				'price'				=>	'',
				'setup'				=>	'',
				'period'			=>	'',
				'cycle'				=>	'',
				'pre_paid'			=>	'',
				'discount'			=>	'',
				'discount_period'	=>	''
				);
			$form = $form + $blank;
		}
		
		$this->template->set_title("Add Service.");
		$page_data = $this->parser->parse('services/add_service_form_view', $form, TRUE);
		if (validation_errors())
		{
			$this->session->set_flashdata('message', validation_errors());
		}
		$this->template->set_page_data($page_data);
		$this->template->display_page();

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
