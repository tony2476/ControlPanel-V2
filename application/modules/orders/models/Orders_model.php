<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
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
			/*foreach ($list as &$item)
			{
				$status = $item['status'];
				$item['status'] = $this->reverse_status[$status];
				$item['date'] = $this->mysql_date_to_display($item['date']);
				$item['due'] = $this->mysql_date_to_display($item['due']);
			}*/

			return ($list);
		} else {
			$this->error = "We could not retrieve the Orders list";
			return (FALSE);
		}
	}

}