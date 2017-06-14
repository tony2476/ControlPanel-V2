<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->config->load('invoices/config');
		$this->status = $this->config->item('status');
		$this->reverse_status = array_flip($this->status);
	}

	public function index()
	{
	}

	/**
	 * This gets a list of all invoices.
	 * 
	 * The filter_object contains filters and can be extended to allow for sort orders and sort by. 
	 * 
	 * @param type|null $filter_object 
	 * @return type
	 */
	public function list_invoices($filter_object = null)
	{
		if (is_object($filter_object))
		{
			if (isset($filter_object->user_id))
			{
				$this->db->where('user_id', $filter_object->user_id);
			}
		}

		$query = $this->db->get('invoices');

		$list = $query->result_array();
		
		if ($query->num_rows() > 0) {
			foreach ($list as &$item)
			{
				$status = $item['status'];
				$item['status'] = $this->reverse_status[$status];
				$item['date'] = $this->mysql_date_to_display($item['date']);
				$item['due'] = $this->mysql_date_to_display($item['due']);
			}

			return ($list);
		} else {
			$this->error = "We could not retrieve the Invoices list";
			return (FALSE);
		}
	}

	public function add_invoice($data)
	{
		// Do error checking here.
		
		$this->db->insert('invoices', $data);
		$id = $this->db->insert_id();

		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to add the new subscription";
			return (FALSE);
		}
		return ($id);
	}

	public function add_invoice_item($invoice_id, $data)
	{
		// Do error checking here.
		
		$this->db->insert('invoice_items', $data);
		$id = $this->db->insert_id();

		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to add the new subscription";
			return (FALSE);
		}
		return ($id);
	}

	public function get_invoice_items($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$query = $this->db->get('invoice_items');
		return ((array) $query->row());
	}

	public function get_invoice_by_id($invoice_id)
	{
		$this->db->where('id', $invoice_id);
		$query = $this->db->get('invoices');
		if ($query->num_rows() > 0 )
		{
			$invoice = ((array) $query->row());
				$status = $invoice['status'];
				$invoice['status'] = $this->reverse_status[$status];
				$invoice['date'] = $this->mysql_date_to_display($invoice['date']);
				$invoice['due'] = $this->mysql_date_to_display($invoice['due']);
			return ($invoice);
		}
		return (FALSE);
	}

	public function mysql_date_to_display($mysql_date)
	{
		return (date( 'd/M/Y', strtotime($mysql_date)));
	}

	public function mark_invoice_paid($invoice_id)
	{

	}

	public function generate_pdf($invoice_id)
	{

	}
}