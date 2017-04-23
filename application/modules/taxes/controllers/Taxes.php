<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Taxes extends Private_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('taxes/taxes_model');
		$this->taxes = New Taxes_model;
		$this->config->load('taxes/form_validation');
	}

	public function index()
	{
		$taxes_list = array (
			'taxes' => $this->taxes->list_taxes(),
			'form_open' => form_open('/taxes/create', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);

		$this->template->set_title("Tax Rates By Province");
		$this->template->disable_help();
		$page_data = $this->parser->parse('taxes/taxes_list_view', $taxes_list	, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function create()
	{
		if ($this->form_validation->run('tax_by_province') == TRUE)
		{
			
			$province = $this->input->post('province');
			$description = $this->input->post('description');
			$rate = $this->input->post('rate');
			$data = $this->input->post();
			$this->taxes->add_tax($data);
			
			$this->session->set_flashdata('message','New Tax Rate Created.');
			redirect('/taxes/', 'refresh');
		}

		$this->session->set_flashdata('message','We failed to create the tax rate.  Any unknown error ocurred.');
		redirect('/taxes/', 'refresh');
	}

	public function delete()
	{
		$id = $this->uri->segment(3);
		if ($this->taxes->delete_tax($id))
		{
			$this->session->set_flashdata('message','Tax Rate Deleted Successfully.');
			redirect('/taxes/', 'refresh');
		}

		$this->session->set_flashdata('message','We failed to delete the tax rate.  Any unknown error ocurred.');
		redirect('/taxes/', 'refresh');
	}

	public function edit()
	{
		if ($this->form_validation->run('tax_by_province') == TRUE)
		{
			$tax_id = $this->input->post('ID');
			if ($this->taxes->update_tax($tax_id, $this->input->post()))
			{
				$this->session->set_flashdata('message','Tax Rate Updated Successfully.');
				redirect('/taxes/', 'refresh');
			}
			else 
			{
				$this->session->set_flashdata('message','We failed to update the tax rate.  Any unknown error ocurred.');
				redirect('/taxes/', 'refresh');	
			}
		}

		$id = $this->uri->segment(3);
		$tax_rate = $this->taxes->get_tax_by_id($id);
		extract($tax_rate);
		$tax_rate = array (
			'ID' => $ID,
			'province' => $province,
			'description' => $description,
			'rate' => $rate,
			'form_open' => form_open('/taxes/edit', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);

		$this->template->set_title("Edit Tax Rate");
		$this->template->disable_help();
		$page_data = $this->parser->parse('taxes/tax_edit_view', $tax_rate	, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}
}