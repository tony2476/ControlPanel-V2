<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Order Processing Class for logged in clients.
// 
// To see the order lists for admin and managing orders please see the orders module.

class Addons extends Private_Controller {

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

	
	public function form()
	{
		
		$url = $this->uri->segment(3);
		if ($url == '')
		{
			$this->session->set_flashdata('message', "No order form specified");
			redirect('/', 'refresh');
		}

		if (!$form = $this->forms->load_form($url))
		{
			$this->session->set_flashdata('message', $this->forms->error);
			redirect('/', 'refresh');
		}

		$this->template->set_title($form['header_title']);

		$form_open_data = array(
			'form_open' => form_open('/addons/confirm', array('class'=>'form-horizontal')),
			);
		$page_data = $this->parser->parse('addons/form_open', $form_open_data, TRUE);

		if ($form['header_enable'])
		{
			$header = array
			(
				'header_title' => $form['header_title'],
				'header_text' => $form['header_text'],
				);
			$page_data .= $this->parser->parse('addons/header', $header, TRUE);
		}

		if (!$services = $this->services->get_services_by_group($form['service_group']))
		{
			$this->session->set_flashdata('message', "There are no add on services currently available to order.");
			redirect('/', 'refresh');
		}

		// Services here
		$services_data = array 
		(
			'services' => $this->services->get_services_by_group($form['service_group']),
			);
		$page_data .= $this->parser->parse('addons/services', $services_data, TRUE);

		// promo code here (not needed for special offers form)
		if ($form['promo_code_enable'])
		{
			$promo_data = array();			
			$page_data .= $this->parser->parse('addons/promo', $promo_data, TRUE);
		}
		
		// Domain name here (not necessarily needed for add ons)
		if ($form['domain_enable'])
		{
			$domain_data = array();
			$page_data .= $this->parser->parse('addons/domain', $domain_data, TRUE);
		}
		
		
		$form_close_data = array(
			'form_close' => form_close(),
			);
		$page_data .= $this->parser->parse('addons/form_close', $form_close_data, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	function confirm()
	{

		$confirmation_data = $this->input->post();
	
		//Get the service name from code
		$confirmation_data['product_description'] = $this->services->get_service_name_order_code($confirmation_data['service']);



		// Calculate prices and charges etc.
		$confirmation_data['price_data'] = $this->services->get_service_costs($confirmation_data['service']);
		$prices = $confirmation_data['price_data'];
		$total = $prices['setup'];
		$pre_pay = $prices['pre_paid'] / $prices['period'] * $prices['price'];
		if ($prices['discount'] >0) {
			$discount_rate = $prices['discount'];
			$discount_value = ($pre_pay/100) * $discount_rate;
			$pre_pay = $pre_pay - $discount_value;
		}

		$total = $total + $pre_pay;

		$confirmation_data['setup'] = $prices['setup'];
		$confirmation_data['pre_pay'] = $pre_pay;
		$confirmation_data['total'] = $total;

		if (!array_key_exists ( 'domain_name' , $confirmation_data ))
		{
			$confirmation_data['domain_name'] = 'N/A';
		}

		
		$confirmation_data['form_open'] = form_open('/addons/payment', array('class'=>'form-horizontal'));
		$confirmation_data['form_close'] = form_close();
		
		//Save the order data for later processing
		$this->session->set_userdata('order_data', $confirmation_data);
		
		$page_data = $this->parser->parse('addons/confirmation', $confirmation_data, TRUE);
		
		$this->template->set_page_data($page_data);
		$this->template->display_page();	
	}

	function payment()
	{
		$order_data = $this->session->userdata('order_data');

		// calculate taxes
		// Load tax model
		$this->load->model('taxes/taxes_model');
		$this->taxes = New Taxes_model;

		$subtotal = $order_data['total'];
		$taxes = $this->taxes->calculate_tax($subtotal, $this->user->province);
		$total = $subtotal + $taxes;

		// Configure form
		$this->template->set_title('Payment');
		$payment_data = array(
			'form_open' 	=> form_open('/addons/complete', array('class'=>'form-horizontal')),
			'form_close' 	=> form_close(),
			'subtotal'		=> money_format('$%i', $subtotal),
			'taxes'			=> money_format('$%i', $taxes),
			'total'			=> money_format('$%i', $total),
			);

		
		$page_data = $this->parser->parse('addons/payment', $payment_data, TRUE);
		$this->template->set_page_data($page_data);
		$this->template->display_page();	
	}

	function complete()
	{
		// get order_data from session.
		$order_data = $this->session->userdata('order_data');
		
	
		// Load order model
		$this->load->model('order/order_model');
		$this->order_model = New Order_model;

		// Load the Beanstream module
		$this->load->model('beanstream/beanstream_model');
		$this->beanstream = New Beanstream_model;


		// Save the order to the database.
		$data['user_id'] = $this->user->id;
		// status 1 = pending.
		$data['status'] = '1';
		$data['fullname'] = $this->user->first_name . " " . $this->user->last_name;
		$data['order_data'] = json_encode($order_data);
		$order_id = $this->order_model->save_order($data);

		
		// Send email to Tony (have a look at this routine and tidy up formatting once tony is happy).
		$this->order_model->mail_order_details_unformated($order_id);

		$profile_id = $this->user->beanstream_id;
		if ($profile_id == '')
		{
			$this->session->set_flashdata('warning', "You have no payment method set.");
			redirect('/billing/card_profile', 'refresh');

		}

		// take payment using profile. 
		if (!$payment_id = $this->beanstream->take_payment_using_profile($profile_id, '1', $order_id, $order_data['total']))
		{
			// Payment failed Let Tony know.
			$this->order_model->payment_failed($order_id, $this->beanstream->error); 
			redirect('/addons/payment_failed', 'refresh');
		}
		
		// Mark order as paid.
		$this->order_model->mark_paid($order_id);

		// Send success email to Tony.
		$this->order_model->payment_succeeded($order_id, $payment_id);

		// Display page.
		$this->template->set_title("Thank You:");
		
		$success = array 
		(
			'order_id' => $order_id,
			);
		$page_data = $this->parser->parse('addons/success', $success, TRUE);
		
		$this->template->disable_help();
		$this->template->set_page_data($page_data);
		$this->template->display_page();

	}

	public function payment_failed()
	{
		$this->template->set_title("Information:");
		
		$failed = array();
		$page_data = $this->parser->parse('addons/payment_failed', $failed, TRUE);
		
		$this->template->disable_help();
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function existing_client()
	{
		$this->template->set_title("Information:");
		
		$email = $this->session->userdata('email');
		$exists = array 
		(
			'email' => $email,
			);
		$page_data = $this->parser->parse('addons/existing_client', $exists, TRUE);
		
		$this->template->disable_help();
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

		/**
	 * Source: https://gist.github.com/tylerhall/521810
	 * @param type $length 
	 * @param type|bool $add_dashes 
	 * @param type|string $available_sets 
	 * @return type
	 */
		public function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
		{
			$sets = array();
			if(strpos($available_sets, 'l') !== false)
				$sets[] = 'abcdefghjkmnpqrstuvwxyz';
			if(strpos($available_sets, 'u') !== false)
				$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
			if(strpos($available_sets, 'd') !== false)
				$sets[] = '23456789';
			if(strpos($available_sets, 's') !== false)
				$sets[] = '!#$%*';
			$all = '';
			$password = '';
			foreach($sets as $set)
			{
				$password .= $set[array_rand(str_split($set))];
				$all .= $set;
			}
			$all = str_split($all);

			for($i = 0; $i < $length - count($sets); $i++)
				$password .= $all[array_rand($all)];

			$password = str_shuffle($password);

			if(!$add_dashes)
				return $password;

			$dash_len = floor(sqrt($length));
			$dash_str = '';

			while(strlen($password) > $dash_len)
			{
				$dash_str .= substr($password, 0, $dash_len) . '-';
				$password = substr($password, $dash_len);
			}
			$dash_str .= $password;
			return $dash_str;
		}
	}