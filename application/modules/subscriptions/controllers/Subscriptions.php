<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriptions extends Public_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('subscriptions/subscriptions_model');
		$this->subscriptions = New Subscriptions_model;
		$this->config->load('subscriptions/config');
		$this->status = $this->config->item('status');
	}

	public function test()
	{
		echo "tests <br />";
		
		echo "<pre>";
		echo "Status <br />";
		print_r ($this->status);
		echo "</pre>";
		
		
		$data = array(
			'status'		=> 		$this->status['active'],
			'service_id'	=>		2,
			'user_id'		=>		1,
			'price'			=>		10.00,
			'period'		=>		12,
			'cycle'			=>		12,
			'expires'		=>		'2017-06-01',
			);

		//$this->subscriptions->add_subscription($data);

		//$result = $this->subscriptions->list_all();
		$result = $this->subscriptions->list_all_by_user_id(1);

		echo "<pre>";
		echo "result <br />";
		print_r ($result);
		echo "</pre>";

		$this->subscriptions->advance_expiry_date(1);

		$result = $this->subscriptions->list_all_by_user_id(1);

		echo "<pre>";
		echo "result <br />";
		print_r ($result);
		echo "</pre>";


		
		
		
		
	}
}