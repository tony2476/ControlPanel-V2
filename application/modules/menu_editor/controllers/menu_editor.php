<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends Public_Controller {
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
}
