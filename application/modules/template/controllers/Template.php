<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends MY_Controller {

	// Template configuration variables
	private 	$template_name = "default";
	private 	$template_module_path;
	private 	$template_module_dir;
	private 	$page_title = "Default Title";

	// Template Data (To insert into the page)
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
		$this->load->config('config');
		$this->template_module_path = APPPATH.'modules/'.$this->router->fetch_module() . "/views/";
		$this->load->library('form_validation');
	}


	public function index()
	{

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

	// Set the Title for this page.
	public function set_title($title)
	{
		$this->header_data['title'] = $title;
	}

	// Load the menu data
	public function set_menu_data($data) {
		$this->menu_data['menu_data'] = $data;
	}

	// Load the Page Data
	public function set_page_data($data) {
		$this->page_data['page_data'] = $data;
	}

	// Display the Page.
	public function display_page()
	{

		if ($this->session->flashdata('message')) 
		{
			$message = array 
			(
				'message' => $this->session->flashdata('message'),
				);
			$message = $this->parser->parse("template/$this->template_name/messages/flash_message", $message, TRUE);
			
		}
		elseif ($this->session->flashdata('error')) 
		{
			$message = array 
			(
				'message' => $this->session->flashdata('error'),
				);
			$message = $this->parser->parse("template/$this->template_name/messages/flash_error", $message, TRUE);
		}
		/*elseif ($this->session->flashdata('validation_error'))
		{
			echo "Validation error";
			$message = array 
			(
				'message' => $this->session->flashdata('validation_error'),
				);
			$message = $this->parser->parse("template/$this->template_name/messages/flash_error", $message, TRUE);	
		}*/
		

		if (isset($message)) 
		{
			$this->page_data['page_data'] = $message . $this->page_data['page_data'];

		}
		$help_data = $this->display_help->display_help();
		$this->page_data['page_data'] = $this->parser->parse_string($this->page_data['page_data'], $help_data, TRUE);

		$this->load->view("$this->template_name/header", $this->header_data);
		$this->load->view("$this->template_name/menu", $this->menu_data);
		$this->parser->parse("template/$this->template_name/title", $this->header_data);
		$this->load->view("$this->template_name/main", $this->page_data);
		$this->load->view("$this->template_name/footer");


	}

	public function template($template_name, $view_file, $data) 
	{
		
	}

}