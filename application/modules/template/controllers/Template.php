<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends Public_Controller {

	private 	$template_name = "default";
	private 	$template_module_path;
	private 	$template_module_dir;
	private 	$page_title = "Default Title";

	private 	$menu_data = array ( 
		'menu_data' => ''
		);

	private 	$page_data = array ( 
		'page_data' => ''
		);		

	private 	$header_data = array (
		'title'		=>	"Default Title",
		);


	/**
	 * Constructor
	 */

	function __construct()
	{
		parent::__construct();
		$this->template_module_path = APPPATH.'modules/'.$this->router->fetch_module() . "/views/";
	}

	/*
	 * This function sets the template name to be used to display this page.
	 */

	public function set_template($template_name)
	{
		if ($template_name == '')
		{
			return (FALSE);
		}
		$this->template_name = $template_name;
		$this->template_module_dir = $this->template_module_path . "$this->template_name";
		if (!file_exists($this->template_module_dir))
		{
			throw new Exception("Template Directory specified does not exist.");
		}

		if (is_file($this->template_module_dir))  
		{
			throw new Exception("Template Directory specified does not exist. You specified a filename not a directory name.");
		}
		return (TRUE);
	}

	public function set_title($title)
	{
		$this->header_data['title'] = $title;
	}

	public function set_menu_data($data) {
		$this->menu_data['menu_data'] = $data;
	}

	public function set_page_data($data) {
		$this->page_data['page_data'] = $data;
	}

	public function load_page()
	{
		$this->load->view("$this->template_name/header", $this->header_data);
		$this->load->view("$this->template_name/menu", $this->menu_data);
		$this->load->view("$this->template_name/main", $this->page_data);
		$this->load->view("$this->template_name/footer");
	}

	public function template($template_name, $view_file, $data) 
	{
		
	}

}