<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends Private_Controller {
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('invoices/invoices_model');
		$this->invoices = New Invoices_model;

		$this->config->load('invoices/config');
		$this->status = $this->config->item('status');
	}

	public function index()
	{
		$filter = new stdClass;

		// If the user is not admin, then only let them view their own invoices.
		if (!$this->session->is_admin)
		{
			$filter->user_id = $this->user->id;
		}

		// Build the invoice list.
		$invoices = array(
			'invoices' => $this->invoices->list_invoices($filter),
			);

		$page_data = $this->parser->parse('invoices/list_invoices_view', $invoices, TRUE);
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function view()
	{
		$invoice_id = $this->uri->segment(3);

		// If we can't retrieve a specific invoice id then redirect with error.
		if (!$invoice_details = $this->invoices->get_invoice_by_id($invoice_id))
		{
			$this->session->set_flashdata('message','We could not find the invoice with invoice id $invoice_id.');
			redirect('/invoices/', 'refresh');
		}
	
		$invoice = array(
			'invoice_items' => array ($this->invoices->get_invoice_items($invoice_id),),
			);
		$invoice = $invoice + $invoice_details;

		$this->template->set_title("AdvisorNet.");
		$this->template->disable_help();
		$page_data = $this->parser->parse('invoices/view_invoice2_view', $invoice, TRUE);

		
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}
}