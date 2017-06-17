<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Taxes_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
	}

	public function list_taxes()
	{

		$query = $this->db->get('taxes');

		$list = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0) {
			return ($list);
		} else {
			$this->error = "We could not retrieve the taxes list";
			return (FALSE);
		}
	}

	public function get_tax_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('taxes');
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We couldn't find a tax rate with id $id";
			
			return (FALSE);
		}

		return  ((array) $query->result()[0]);

	}

	public function delete_tax($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('taxes');
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to delete the tax rate from the database";
			
			return (FALSE);
		}
		return (TRUE);
	}

	public function add_tax($data)
	{
		// Do error checking here.
		
		$this->db->insert('taxes', $data);
		$id = $this->db->insert_id();

		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to add the new tax";
			return (FALSE);
		}
		return ($id);
	}

	public function change_status($tax_id, $new_status)
	{
		$data = array (
			'status' =>	$new_status,
			);

		$this->db->where('id', $tax_id);
		$this->db->update('taxes', $data);
		
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to change the status of the tax entry";
			return (FALSE);
		}
		return (TRUE);
	}

	public function update_tax($tax_id, $data)
	{
		$this->db->where('id', $tax_id);
		$this->db->update('taxes', $data);
		
		if ($this->db->affected_rows() == 0) 
		{

			$this->error = "We failed to update the tax rate.";
			return (FALSE);
		}
		return (TRUE);
	}

	public function calculate_tax($amount, $province)
	{
		$this->db->where('province', $province);
		$query = $this->db->get('taxes');
		$taxes = $query->result_array();
		$rate = $taxes[0]['rate'];
		if ($amount >0) 
		{
			$tax = round(($amount/100) * $rate, 2);
			return ($tax);
		}
		$this->error = "We could not calculate the rate, please check your province is valid and amount is not zero?";
		return (FALSE);
	}
}

/* Provinces of Canada
ON 		Ontario
QC 		Quebec
NS 		Nova Scotia
NB 		New Brunswick
MB 		Manitoba
BC 		British Columbia
PE 		Prince Edward Island
SK 		Saskatchewan
AB 		Alberta
NL 		Newfoundland and Labrador

BC = 5% GST
ON = 13% HST
*/