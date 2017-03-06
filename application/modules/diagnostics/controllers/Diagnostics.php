<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Diagnostics extends Public_Controller {

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
	public function sf_cache()
	{

		$this->template->set_title("SF Cache data");

		$page_data = "<pre>SF Cache <br />" . print_r($this->session->userdata('sf_cache') , TRUE) . "<br />";
		
		

		$this->template->set_page_data($page_data);
		$this->template->display_page();
		
	}

	public function ion_auth()
	{
		$user = $this->ion_auth->user()->row();
		$this->template->set_title("Ion Auth Data");

		$page_data = "<pre>Ion Auth <br />" . print_r($user , TRUE) . "<br />";
		
		

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function reload_sf_cache()
	{

		$this->template->set_title("Reload SF Cache data");
		$this->load->model('salesforce/salesforce_model');
		$this->salesforce = New Salesforce_model;
		$this->user = $this->ion_auth->user()->row();
		$sf_contact_id = $this->user->sf_contact_id;
		$this->salesforce->populate_cache($sf_contact_id);

		$page_data = "<pre>SF Cache <br />" . print_r($this->session->userdata('sf_cache') , TRUE) . "<br />";
		
		

		$this->template->set_page_data($page_data);
		$this->template->display_page();
		
	}
}

