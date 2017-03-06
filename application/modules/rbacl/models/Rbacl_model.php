<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Rbacl_model extends CI_Model {
	/**
	 * Constructor
	 */

	private $user;

	function __construct()
	{
		parent::__construct();
		$this->template_module_path = APPPATH.'modules/'.$this->router->fetch_module() . "/views/";
		// Load the module config file.
		$this->load->config('config');
		$this->user = $this->ion_auth->user()->row();

	}

	public function is_authorised($path)
	{
		/* For any functionality where we need to know whether we are authorised or not we can pass the class and method.
		 * If we want to know if we are authorised for the current class/method we don't need to pass it.
		 *In which case we pick it up here. 
		 */
		
		if (!$this->ion_auth->logged_in()) 
		{
			return (FALSE);
		}
		$user_id = $this->user->id;
		/*
		 * We need to lookup the current class/method parameters in the rb table and see if we have belong to the group in ion auth groups.
		 */
		$sql = "
		SELECT users.username, users.id 
		FROM users, users_groups, groups, rb 
		WHERE users.id = users_groups.user_id 
		AND users_groups.group_id = groups.id 
		AND rb.group_id = groups.id 
		AND users.id = $user_id 
		AND rb.path = '$path'
		";
		$query = $this->db->query($sql);
		//log_message ('debug', $sql);
		
		$count = $query->num_rows();
		log_message ('debug', "count = $count" );

		if ($count > 0) {
			log_message ('debug', "RBACL: Returning TRUE for $path for user $user_id count = $count");
			return (TRUE);
		} else {
			log_message ('debug', "RBACL: Returning FALSE for $path for user $user_id count = $count");
			return (FALSE);
		}
	}

	public function list_all()
	{
		$query = $this->db->query("SELECT * from rb");
		$list = $query->result_array();
		return $list;
	}

	public function delete($id)
	{
		$query = $this->db->query("delete from rb where ID='$id'");
		if ($this->db->affected_rows() == 0) return (FALSE);
		return (TRUE);
	}

	public function add($data)
	{
		$groups = $this->ion_auth->groups()->result();
		extract ($data);
		foreach ($groups as $group)
		{
			if ($group_name == $group->name)
			{
				$group_id = $group->id;
			}
		}
		if (!$group_id)
		{
			$group = $this->ion_auth->create_group($group_name, '');
		}
		$sql = "insert into rb (role_name, path, group_name, group_id, description) values ('$role_name', '$path', '$group_name', '$group_id', '$description')";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() == 0) return (FALSE);
		return (TRUE);
	}

	public function get_roles()
	{
		$query = $this->db->query("
			SELECT groups.name, rb.group_id, rb.description 
			FROM groups, rb 
			WHERE rb.group_id = groups.id 
			AND group.id > 3"
			);
		$list = $query->result_array();
		return $list;
	}

}
