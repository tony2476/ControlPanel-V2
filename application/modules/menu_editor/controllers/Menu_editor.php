<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_editor extends Public_Controller {
	function __construct()
	{
		parent::__construct();
		$this->template_module_path = APPPATH.'modules/'.$this->router->fetch_module() . "/views/";

		//load the editor model
		$this->load->model('menu_editor/menu_editor_model');
		
	}

	public function menu_edit($menu) {
		$menu_data = $this->load->view("menu_editor/main", $menu, TRUE);
	}

	public function index() {
		$this->template->set_title("Menu Editor.");
		$menu = array();
		$editor = New Menu_editor_model;
		$menu_list = array(
			'menu_list' => $editor->list_menus()
			);
		

		$page_data = $this->parser->parse('menu_editor/menu_editor_view', $menu_list, TRUE);
		#$page_data = $this->load->view("menu_editor/menu_editor_view", $menu_list, TRUE);
		$this->template->set_page_data($page_data);
		$this->template->display_page();
		
	}

	public function ajax_load() {
		if ($this->input->post('menu'))
		{
			$editor = New Menu_editor_model;
			echo ($editor->load_menu($this->input->post('menu')));
			
		}
	}

	public function ajax_save() {
		$html='';
		if ($this->input->post('menu')) 
		{
			$html= $this->input->post('menu');
			$html = str_replace( 'class="ui-sortable"', "", $html);
			$html = str_replace( 'class="ui-sortable-handle"', "", $html);
			
			// Get the name of the menu.
			$dom = new DOMDocument;
			$dom->loadHTML($html);
			echo $html;
			$menu_name = $dom->getElementsByTagName('ul')->item(0)->getAttribute('id');
			$editor = New Menu_editor_model;
			$editor->save_menu($menu_name, $html);


		}
		else
		{
			echo "failed";
			return FALSE;
		}
	}



}
