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

	public function ajax() {
		$value='';
		if ($this->input->post('menu')) {
			$value= $this->input->post('menu');

		}

		//$value =  ($_POST['menu']);
		//$file = "/tmp/json.log";


		if ($value!='') {
			echo $value;
		} else {
			echo json_encode("error: OOPS!");
		}

//		$post= print_r($_POST, true);
//		file_put_contents($file, $post . "\n\n", FILE_APPEND | LOCK_EX);
//		file_put_contents($file, $json . "\n\n", FILE_APPEND | LOCK_EX);
	}
}
