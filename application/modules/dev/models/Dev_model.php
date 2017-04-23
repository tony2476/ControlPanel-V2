<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dev_model extends CI_Model 
{
	private 	$dbtable = 'vhosts';


	public function __construct()
	{
		parent::__construct();
		//$this->config->load('dev/config');
		$this->vhost_db = $this->load->database('vhosts', TRUE);
		$this->dev_server = $this->load->database('dev_server', TRUE);
	}

	public function list_all_dev_hosts()
	{
		$query = $this->vhost_db->get($this->dbtable);
		$results = $query->result();

		foreach ($results as $result) {
			$id = $result->ID;
			if ($result->status == 'enabled') {
				$result->colour = 'btn-success';
				$result->icon = 'glyphicon-pause';
			}
			else 
			{
				$result->colour = 'btn-warning';	
				$result->icon = 'glyphicon-play';
			}
		}
		return ($results);
	}

	public function get_vhost_by_id($id)
	{
		$query = $this->vhost_db->query("SELECT username FROM vhosts where ID = '$id';");
		return ($query->result()[0]->username);
		
	}

	public function get_vhost_id_by_hostname($hostname)
	{
		$username = str_replace('.dpsys.ca', '', $hostname);
		$query = $this->vhost_db->query("SELECT id FROM vhosts where username = '$username';");
		return ($query->result()[0]->id);
		
	}

	public function get_vhost_status_by_id($vhost_id)
	{
		$this->vhost_db->select('status');
		$this->vhost_db->from('vhosts');
		$this->vhost_db->where('id', $vhost_id);
		$query = $this->vhost_db->get();
		foreach ($query->result() as $row)
		{
			return ($row->status);
		}

		return (FALSE);
	}

	public function set_vhost_status($vhost_id, $new_status)
	{
		$data = array (
			'status' =>	$new_status,
			);

		$this->vhost_db->where('id', $vhost_id);
		$this->vhost_db->update('vhosts', $data);
		
		if ($this->vhost_db->affected_rows() == 0) 
		{
			$this->error = "We failed to change the status of the vhost";
			return (FALSE);
		}
		return (TRUE);
	}

	public function delete_vhost($id)
	{
		$this->vhost_db->where('id', $id);
		$this->vhost_db->delete('vhosts');
		if ($this->vhost_db->affected_rows() == 0) 
		{
			$this->error = "We failed to delete the vhost from the database";
			echo $this->error;
			return (FALSE);
		}
		return (TRUE);
	}

	public function add_database($username, $password)
	{
		
		$query = $this->dev_server->query("CREATE DATABASE $username");
		
		$query = $this->dev_server->query("CREATE USER '$username'@'localhost' IDENTIFIED BY '$password';");

		
		$query = $this->dev_server->query("GRANT ALL PRIVILEGES ON $username.* TO '$username'@'localhost';");

		
		$query = $this->dev_server->query("FLUSH PRIVILEGES;");

		
		$query = $this->vhost_db->query("INSERT INTO vhosts (username, password, status) values ('$username', '$password', 'enabled');");
	}
}