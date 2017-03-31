<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_forms extends Admin_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('order_forms/order_forms_model');
		$this->order_forms = New Order_forms_model;

		$this->load->model('services/services_model');
		$this->services = New Services_model;
	}

	public function index()
	{
	}

	public function list_order_forms()
	{
		$forms = array 
		(
			'forms' => $this->order_forms->list_all(),
			);

		$this->template->set_title("Order Forms.");
		$page_data = $this->parser->parse('order_forms/order_forms_list_view', $forms, TRUE);
		
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function order_form_create()
	{
		if ($this->form_validation->run('order_form') == TRUE)
		{
			$this->order_forms->add_form($this->input->post());
			$this->session->set_flashdata('info', "Order Form Created.");
			redirect('/order_forms/list_order_forms','refresh');
		}

		$form = array 
		(
			'form_open' => form_open('/order_forms/order_form_create', array ('class'=>'form-horizontal')),
			'form_close' => form_close(),
			'service_groups' => $this->services->get_service_groups(),
			);
		
		$this->template->set_title("Order Forms.");
		$page_data = $this->parser->parse('order_forms/add_order_form_form_view', $form, TRUE);
		if (validation_errors())
		{
			$this->session->set_flashdata('message', validation_errors());
		}
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function toggle_status()
	{
		$id = $this->uri->segment(3);
		$this->order_forms->toggle_status($id);
		$this->session->set_flashdata('message', "toggled status on $id");
		redirect('/order_forms/list_order_forms','refresh');
	}

	public function delete_form()
	{
		$id = $this->uri->segment(3);
		if (!$this->order_forms->delete_form($id))
		{
			$this->session->set_flashdata('error', "We couldn't delete the form with ID $id\n" . $this->order_forms->error);
		}
		redirect('/order_forms/list_order_forms','refresh');
	}
}