<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Public_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	
		$this->template->set_title("Welcome Page");
						
		
		//$page_data = $this->load->view("user/login_form_view", '', TRUE);
		$page_data = '';
		$this->template->set_page_data($page_data);
		$this->template->display_page();
		#$this->menu->test();
		ChromePhp::log('Hello console!');
		

	}
}
