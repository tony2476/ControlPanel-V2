<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->config('order/constants');
		$this->orders_status_codes = $this->config->item('order_status_codes');
	}


	public function list_orders($filter_object = null)
	{
		if (is_object($filter_object))
		{
			if (isset($filter_object->user_id))
			{
				$this->db->where('user_id', $filter_object->user_id);
			}
		}

		$query = $this->db->get('orders');

		$list = $query->result_array();
		
		if ($query->num_rows() > 0) {
			foreach ($list as &$item)
			{
				$item['status'] = $this->orders_status_codes[$item['status']];
			}

			return ($list);
		} else {
			$this->error = "We could not retrieve the Orders list";
			return (FALSE);
		}
	}

}