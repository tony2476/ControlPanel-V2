<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Services_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->config('services/constants');
		$this->services_status_codes = $this->config->item('services_status_codes');
	}

	public function index()
	{
	}

	public function get_services_by_group($group_id)
	{
		$query = $this->db->query("SELECT * from services where service_group='$group_id'");
		$list = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0) {
			foreach ($list as &$item)
			{
				$item['status'] = $this->services_status_codes[$item['status']];
			}
			return ($list);
		} else {
			$this->error = "There could not retrieve the services list";
			return (FALSE);
		}
	}

	public function get_service_costs($order_code)
	{
		$query = $this->db->query("SELECT price, setup, period, cycle, pre_paid, discount, discount_period from services where short_code='$order_code'");
		$list = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0) {
			foreach ($list as $item)
			{
				return ($item);
			}
			
		} else {
			$this->error = "We could not retrieve the service costs";
			return (FALSE);
		}	
	}

	public function get_service_name_order_code($order_code)
	{
		$query = $this->db->query("SELECT description from services where short_code='$order_code'");
		$list = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0) {
			foreach ($list as $item)
			{
				return ($item['description']);
			}
			
		} else {
			$this->error = "There could not retrieve the services list";
			return (FALSE);
		}
	}

	public function list_all()
	{
		$query = $this->db->query("SELECT * from services");
		$list = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0) {
			foreach ($list as &$item)
			{
				$item['status'] = $this->services_status_codes[$item['status']];
			}
			return ($list);
		} else {
			$this->error = "There could not retrieve the services list";
			return (FALSE);
		}
	}

	public function get_service_groups()
	{
		$query = $this->db->query("SELECT * from service_groups");
		$list = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0) {
			
			return ($list);
		} else {
			$this->error = "There could not retrieve the service groups list";
			return (FALSE);
		}
	}

	public function add_service_group($data)
	{
		extract ($data);
		
		$sql = "insert into service_groups (name, description) values ('$group_name', '$group_description')";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to add the new group";
			return (FALSE);
		}
		return (TRUE);
	}

	public function add_service($data)
	{
		extract ($data);
		$status = '0';
		$sql = "insert into services (status, service_group, short_code, description, price, period, cycle, pre_paid, discount, discount_period) values ('$status', '$service_group','$short_code', '$description', '$price', '$period','$cycle', '$pre_paid', '$discount', '$discount_period')";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to add the new service";
			return (FALSE);
		}
		return (TRUE);
	}

	public function change_status($id, $new_status)
	{
		$sql = "updates services set status = '$new_status' where id = '$id'";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to change the status";
			return (FALSE);
		}
		return (TRUE);
	}

	public function toggle_group_status($id)
	{
		$query = $this->db->query("SELECT status from service_groups where ID = '$id'");
		$group = $query->result_array();
		if ($group['status'] == 'enabled') {
			$new_status = 'disabled';
		}
		else
		{
			$new_status = 'enabled';
		}

		$sql = "updates service_groups set status = '$new_status' where ID = '$id'";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to change the status";
			return (FALSE);
		}
		return (TRUE);
	}

	public function clone_service ($id, $data)
	{
		if (!is_int($id)  || !is_array($data))
		{
			$this->error = "Either ID is invalid or $data is not an array";
			return (FALSE);
		}

		// Get the service data of the service to be cloned.
		$query = $this->db->query("SELECT * from services where id = '$id'");
		$service = $query->result_array();

		// Could we find that service id?
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We could not find a service with id $id to clone";
			return (FALSE);
		} 

		// extract the array into individual variables for sql statement.
		extract ($service);

		// create new service with identical data.
		$sql = "insert into services (status, short_code, description, price, period) values ('$status', '$short_code', '$description', '$price', '$period')";
		$query = $this->db->query($sql);
		// Did we create a new row?
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to clone service with id $id";
			return (FALSE);
		} 

		// Get new service id.
		$new_id = $this->db->insert_id();

		// Replace only the fields that are passed in the $data array.
		foreach ($data as $key => $value)
		{
			$sql = "update services set $key = '$value' where id = $new_id";
			if ($this->db->affected_rows() == 0) 
			{
				$this->error = "We tried to update field $key with data $value and failed";
				return (FALSE);
			} 
		}
	}
}