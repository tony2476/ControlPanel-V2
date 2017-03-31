<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Subscriptions_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
	}

	public function list_all()
	{
		$query = $this->db->query("SELECT * from subscriptions");
		$list = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0) {
			return ($list);
		} else {
			$this->error = "We could not retrieve the subscriptions list";
			return (FALSE);
		}
	}

	public function add_subscription($data)
	{
		extract ($data);
		
		$sql = "insert into subscriptions (status, service_id, user_id, price, period, expires) values ('$status', '$service_id', $user_id', '$price', '$period', '$expires')";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to add the new subscription";
			return (FALSE);
		}
		return (TRUE);
	}

	public function change_status($id, $new_status)
	{
		$sql = "updates subscriptions set status = '$new_status' where id = '$id'";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to change the status";
			return (FALSE);
		}
		return (TRUE);
	}

}