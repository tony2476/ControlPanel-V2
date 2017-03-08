<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Display_help_model extends CI_Model 
{
	private $dbtable = 'help';

	public function __construct($dbtablename = null)
	{
		parent::__construct();

	}

	public function index()
	{

	}

	public function display_help()
	{
		$path = "/" . $this->router->class ."/" . $this->router->method;
		$this->db->select('title, content');
		$query = $this->db->where('path', $path)->get($this->dbtable);
		$result = (array) $query->row();
		$result['help_content'] = $result['content'];
		$result['help_title'] = $result['title'];
		unset ($result['content']);
		unset ($result['title']);
		return ($result);
	}

}