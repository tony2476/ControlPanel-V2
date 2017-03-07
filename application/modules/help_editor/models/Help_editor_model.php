<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Help_editor_model extends CI_Model 
{
	private $dbtable = 'help';

	public function __construct($dbtablename = null)
	{
		parent::__construct();

	}

	public function load_help($id)
	{
		$query = $this->db->where('id', $id)->get($this->dbtable);
		$result = $query->row();
		
		return (array) ($result);
	}

	public function save_help($id, $content)
	{
		$data = array 
		(
			'id' => $id,
			'content' => $content,
			);
		//print_r($data);
		$this->db->replace($this->dbtable, $data);
	}

	// Get a list of all help articles,  get first line of article not full body content.
	public function list_help()
	{
		//$this->db->select('title');
		$query = $this->db->get($this->dbtable);
		$list = $query->result_array();
		foreach ($list as &$item)
		{
			$content = $item['content'];
			$bang = explode("\n" , $content);
			$content = strip_tags($bang[0]);
			$item['content'] = $content;
		}
		return ($list);
	}

	public function delete_help($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('help');
		if ($this->db->affected_rows() == 0) {
			return FALSE;
		}
		return TRUE;
	}

}