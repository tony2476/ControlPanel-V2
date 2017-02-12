<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_editor extends Public_Controller {
	function __construct()
	{
		parent::__construct();
		$this->template_module_path = APPPATH.'modules/'.$this->router->fetch_module() . "/views/";
	// Load the module config file.
		$this->load->config('config');
	}

	public function menu_edit($menu) {
		$menu_data = $this->load->view("menu_editor/main", $menu, TRUE);
	}

	public function index() {
		$this->template->set_title("Menu Editor.");
		$menu = array();
		$page_data = '';
		$page_data = $this->load->view("menu_editor/menu_editor_view", $menu, TRUE);
		$this->template->set_page_data($page_data);
		$this->template->display_page();
		
	}

	public function ajax_load() {
		if ($this->input->post('menu'))
		{
			// Load it here.
		}
	}

	public function ajax_save() {
		$html='';
		if ($this->input->post('menu')) 
		{
			$html= $this->input->post('menu');
			// Save it here.
			//echo $html;
			echo "OK";
			return;

		}
		else
		{
			echo "failed";
			return FALSE;
		}
	}



}
