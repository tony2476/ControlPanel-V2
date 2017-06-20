<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Orders Class.
// 
// This is for admins to view, edit, delete orders.  
// 
// To see the order process see the order module.

class Orders extends Admin_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('services/services_model');
		$this->services = New Services_model;

		$this->load->model('orders/orders_model');
		$this->orders = New Orders_model;

		$this->load->config('orders/constants');
		$this->orders_status_codes = $this->config->item('orders_status_codes');
		$this->orders_status_names = array_flip($this->orders_status_codes);
	}

	public function index()
	{

	}

	public function all()
	{
		$status = $this->uri->segment(3);
		$filter = new stdClass;
		if ($status != '')
		{
			$filter->status = $this->orders_status_names[$status];
		}

		if (!$orders_list = $this->orders->list_orders($filter))
		{
			$orders_list = array
			(
				array ('ID'	=> '',
					'fullname' => 'No orders found with this status, Sorry.',
					'date'		=>	'',
					'status'	=>	$status,
					),
				);
		}
		// Build the orders list.
		$orders = array(
			'orders' => $orders_list,
			);


		$this->template->set_title("Orders.");
		$page_data = $this->parser->parse('orders/list_orders_view', $orders, TRUE);
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}




	public function view()
	{
		echo "Temporarily unavailable, please contact support";
	}

}
