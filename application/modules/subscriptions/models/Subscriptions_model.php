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
		$query = $this->db->get('subscriptions');
		
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
		//extract ($data);
		
		$this->db->insert('subscriptions', $data);

		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to add the new subscription";
			return (FALSE);
		}
		return (TRUE);
	}

	public function change_status($subscription_id, $new_status)
	{
		$data = array (
			'status' =>	$new_status,
			);

		$this->db->where('id', $subscription_id);
		$this->db->update('subscriptions', $data);
		
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to change the status";
			return (FALSE);
		}
		return (TRUE);
	}

	public function list_all_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->from('subscriptions');
		$query = $this->db->get();
		$list = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0) {
			return ($list);
		} else {
			$this->error = "We could not retrieve the subscriptions list for this user.";
			return (FALSE);
		}
	}

	public function list_all_by_service_id($service_id)
	{
		$this->db->where('service_id', $service_id);
		$this->db->from('subscriptions');
		$query = $this->db->get();

		$list = $query->result_array();
		$count = $query->num_rows();
		if ($count > 0) {
			return ($list);
		} else {
			$this->error = "We could not retrieve any subscriptions for this service id";
			return (FALSE);
		}
	}

	public function get_subscription_by_id($subscription_id)
	{
		$this->db->where('id', $subscription_id);
		$this->db->from('subscriptions');
		$query = $this->db->get();

		$list = $query->result_array();
		$list = $list[0];
		$count = $query->num_rows();
		if ($count > 0) {
			return ($list);
		} else {
			$this->error = "We could not retrieve any subscriptions for this service id";
			return (FALSE);
		}
	}

	public function advance_expiry_date($subscription_id)
	{
		if (!$subscription = $this->get_subscription_by_id($subscription_id))
		{
			$this->error = "We could not retrieve this subscription id to advance the expiry date";
			return (FALSE);
		}
		$date = $subscription['expires'];
		$period = $subscription['cycle'];
		$new_date = date('Y-m-d', strtotime("+$period months", strtotime($date)));
		
		if (!$this->set_expiry_date($subscription_id, $new_date)) 
		{
			$this->error = "We found the subscription but failed to update it.";
			return (FALSE);
		}
	}

	public function set_expiry_date($subscription_id, $new_date)
	{
		$data = array(
			'expires'	=>	$new_date,
			);

		$this->db->where('id', $subscription_id);
		$this->db->update('subscriptions', $data);
		
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to change the status";
			return (FALSE);
		}
		return (TRUE);

	}

}