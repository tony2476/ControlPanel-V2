<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Private_Controller {
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('parser');
		$this->load->helper('form');

		//$this->load->model('user/user_model');
		//$this->user = New User_model;

		$this->load->model('salesforce/salesforce_model');
		$this->salesforce = New Salesforce_model;

		$this->load->config('ion_auth', TRUE);
		$this->identity_column = $this->config->item('identity', 'ion_auth');
		//$this->config->load('user/config');

		
		
	}

	public function index()
	{
		echo "Nothing here!";
	}

	public function personal()
	{
		if ($this->form_validation->run('personal') == TRUE)
		{

		}

		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);
		$this->user = $this->ion_auth->user()->row();

		if (!is_object($this->session->userdata('sf_cache')))
		{
			$this->session->set_flashdata('error', "We cannot locate any data for this user.");
			redirect('/','refresh');	
		}

		$sf_contact_data = clone $this->session->userdata('sf_cache');

		$sf_contact_data = (object) (array) $sf_contact_data;
		unset ($sf_contact_data->Account);

		$help_data = $this->display_help->display_help();

		$form = $form + (array) $help_data + (array) $sf_contact_data;
		

		$this->template->set_title("");
		$page_data = $this->parser->parse('profile/edit_personal_profile_view', $form, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function company()
	{
		if ($this->form_validation->run('company') == TRUE)
		{

		}

		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);
		$this->user = $this->ion_auth->user()->row();
		
		$sf_data = $this->session->userdata('sf_cache');

		if (!is_object($sf_data))
		{
			$this->session->set_flashdata('error', "We cannot locate any data for this user.");
			redirect('/','refresh');	
		}

		$help_data = $this->display_help->display_help();


		$sf_account_data = $sf_data->Account->fields;
		$form = $form + (array) $sf_account_data + $help_data;

		$this->template->set_title("");
		$page_data = $this->parser->parse('profile/edit_company_profile_view', $form, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function package()
	{
		if ($this->form_validation->run('company') == TRUE)
		{

		}
		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);
		$this->user = $this->ion_auth->user()->row();

		$sf_data = $this->session->userdata('sf_cache');
		if (!is_object($sf_data))
		{
			$this->session->set_flashdata('error', "We cannot locate any data for this user.");
			redirect('/','refresh');	
		}
		$sf_account_data = $sf_data->Account->fields;
		
		$form = $form + (array) $sf_account_data;

		$this->template->set_title("");
		$page_data = $this->parser->parse('profile/edit_website_package_details_view', $form, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function personalization()
	{
		if ($this->form_validation->run('company') == TRUE)
		{

		}
		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);
		$this->user = $this->ion_auth->user()->row();

		$sf_data = $this->session->userdata('sf_cache');
		if (!is_object($sf_data))
		{
			$this->session->set_flashdata('error', "We cannot locate any data for this user.");
			redirect('/','refresh');	
		}
		$sf_account_data = $sf_data->Account->fields;

		
		$form = $form + (array) $sf_account_data;

		$this->template->set_title("");
		$page_data = $this->parser->parse('profile/edit_website_personalization_view', $form, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

}