<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_editor_model extends CI_Model 
{

		// Default table name,  can be modified using constructor call.
	private 	$dbtable = 'menus';

	public function __construct($dbtablename = null)
	{
		parent::__construct();
		//$this->load->library('ion_auth');

		// Set tablename if passed.  Default is 'owners'
		if ($dbtablename) {
			$this->dbtable = $dbtablename;
		}
	}

	public function load_menu($menu_name)
	{
		$query = $this->db->where('menu_name', $menu_name)->get($this->dbtable);
		$result = $query->row();
		
		return ($result->menu_data);
	}

	public function save_menu($menu_name, $menu_data)
	{
		$data = array 
		(
			'menu_name' => $menu_name,
			'menu_data' => $menu_data,
			);
		//print_r($data);
		$this->db->replace($this->dbtable, $data);
	}

	public function list_menus()
	{
		$this->db->select('menu_name');
		$query = $this->db->get($this->dbtable);
		return ($query->result_array());
	}

}
