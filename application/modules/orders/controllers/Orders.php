<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Public_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('services/services_model');
		$this->services = New Services_model;

		$this->load->model('order_forms/order_forms_model');
		$this->forms = New Order_forms_model;
	}

	
	public function order()
	{
		
		$url = $this->uri->segment(3);
		$form = $this->forms->load_form($url);

		$this->template->set_title($form['header_title']); 

		if ($form['header_enable'])
		{
			$header = array
			(
				'header_title' => $form['header_title'],
				'header_text' => $form['header_text'],
				);
			$page_data = $this->parser->parse('orders/header', $header, TRUE);
		}

		// Services here
		$services_data = array 
		(
			'services' => $this->services->get_services_by_group($form['service_group']),
			);
		$page_data .= $this->parser->parse('orders/services', $services_data, TRUE);

		//>>> promo code here
		if ($form['promo_code_enable'])
		{
			$promo_data = array();			
			$page_data .= $this->parser->parse('orders/promo', $promo_data, TRUE);
		}
		
		//>>> Domain name here
		if ($form['domain_enable'])
		{
			$domain_data = array();
			$page_data .= $this->parser->parse('orders/domain', $domain_data, TRUE);
		}
		
		if ($form['contact_enable'])
		{
			$contact_data = array();
			$page_data .= $this->parser->parse('orders/details', $contact_data, TRUE);
		}

		//Payment details here.
		$payment_data = array();
		$page_data .= $this->parser->parse('orders/payment', $payment_data, TRUE);



		$form_data = array 
		(
			'form_open' => form_open('', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			'services' => $this->services->list_all(),
			);

		
		//$page_data = $this->parser->parse('orders/step_one_form_view', $form_data, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();

	}
}