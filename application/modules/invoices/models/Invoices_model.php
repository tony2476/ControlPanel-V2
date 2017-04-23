<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
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
		$count = $query->num_rows();
		if ($count > 0) {
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

	public function get_invoice($invoice_id)
	{

	}

	public function mark_invoice_paid($invoice_id)
	{

	}

	public function generate_pdf($invoice_id)
	{

	}
}