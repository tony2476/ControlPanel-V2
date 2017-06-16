<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Order_forms_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function load_form($url)
	{
		$query = $this->db->query("SELECT * from order_forms where url = '$url'");
		$order_form = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0 )
		{
			return $order_form[0];
		}
		else
		{
			$this->error = "We couldn't find that form sorry.  Please contact support.";
			return FALSE;
		}
	}

	public function list_all()
	{
		$query = $this->db->query("SELECT * from order_forms");
		$order_forms = $query->result_array();
		$count = $query->num_rows();

		if ($count > 0) {
			foreach ($order_forms as &$form)
			{
				if ($form['status'] == '0')
				{
					$form['icon'] = 'play';
					$form['colour'] = 'btn-success';
					$form['status'] = 'disabled';
				}
				else
				{
					$form['colour'] = 'btn-danger';	
					$form['icon'] = 'pause';
					$form['status'] = 'enabled';
				}

				$form['header_enable'] = TRUE ? 'Enabled' : 'Disabled'; 
				$form['promo_code_enable'] = TRUE ? 'Enabled' : 'Disabled';
				$form['domain_enable'] = TRUE ? 'Enabled' : 'Disabled';
				$form['contact_enable'] = TRUE ? 'Enabled' : 'Disabled';
			}

			return ($order_forms);

		} else {
			$this->error = "There could not retrieve the order forms list";
			return (FALSE);
		}
	}

	public function add_form($data)
	{
		
		extract($data);
		$sql_data = array
		(
			$url, 
			$status, 
			$header_title, 
			$header_text, 
			$service_group, 
			$header_enable, 
			$promo_code_enable, 
			$domain_enable, 
			$contact_enable
			);

		$sql = "INSERT INTO order_forms (url, status, header_title, header_text, service_group, header_enable, promo_code_enable, domain_enable, contact_enable) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		

		$query = $this->db->query($sql, $sql_data);
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to add the new order form";
			return (FALSE);
		}
		return (TRUE);
	}

	public function toggle_status($id)
	{
		$query = $this->db->query("SELECT * from order_forms where id = '$id'");
		$order_forms = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0) {

			if ($order_forms[0]['status']) {
				$status = 0;
			} else
			{
				$status = 1;
			}
			
			$query = $this->db->query("UPDATE order_forms SET status='$status' WHERE id='$id'");

			if ($query) 
			{
				return TRUE;
			}
			else
			{
				echo $this->db->_error_message();
				$this->error = "Could not toggle status of form with id $id";
			}
			
		} else {
			$this->error = "Could not find an order form with id $id";
			return (FALSE);
		}
	}

	public function delete_form($id)
	{
		if(!is_numeric ($id))
		{
			$this->error = "id $id not valid";
			return FALSE;
		}
		$query = $this->db->query("DELETE FROM order_forms where id = '$id'");
		if (!$query)
		{
			return FALSE;
		}
		return TRUE;
	}
}