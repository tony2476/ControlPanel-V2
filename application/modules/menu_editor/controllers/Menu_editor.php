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
			echo '<ul id="rootul"><li id="Item_1"><a href="#"><i class="fa fa-home fa-fw" ></i>Home</a><span onmouseover=""  class="button-span pointer pull-right" onclick="Delete(this);"><i class="colorblue fa fa-trash fa-fw"></i></span><span onmouseover=""  class="button-span pointer pull-right" onclick="Edit(this);"><i class="colorblue fa fa-edit fa-fw"></i></span> <ul></ul></li><div id="menuend"></div></ul>';
		}
	}

	public function ajax_save() {
		$html='';
		if ($this->input->post('menu')) 
		{
			$html= $this->input->post('menu');
			$dom = new DOMDocument;
			$dom->loadHTML($html);

			$menuname = $dom->getElementsByTagName('ul')->item(0)->getAttribute('id');
			$html = str_replace( 'class="ui-sortable"', "", $html);
			$html = str_replace( 'class="ui-sortable-handle"', "", $html);

			echo "Menu was saved with name: $menuname <br />";
			echo $html;
		}
		else
		{
			return FALSE;
		}




	}
}
