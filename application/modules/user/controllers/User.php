<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User extends Public_Controller {
	private $data;
	private $user;

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('parser');
		$this->load->model('user/user_model');
		$this->user = New User_model;
	}



	public function index()
	{
	}

	public function login()
	{
		if ($this->form_validation->run('login') == TRUE) {
			$remember = (bool) $this->input->post('remember');
			$username = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
			{

				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->session->set_userdata('logged_in', TRUE);

				if($this->ion_auth->is_admin()) {
					$this->session->set_userdata('is_admin', TRUE);
					redirect('/');
				} 	else {
					redirect('/', 'refresh');
				}
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('user/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}

		else 
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['username'] = array('name' => 'username',
				'id' => 'username',
				'type' => 'text',
				'placeholder' => 'email address / username',
				'value' => $this->form_validation->set_value('username'),
				);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				);

			$this->template->set_title("Login Page");

			$form = array 
			(
				'form_open' => form_open('', array('class'=>'form-signin')),
				'form_close' => form_close(),
				);
			$page_data = $this->parser->parse('user/login_form_view', $form, TRUE);

			$this->template->set_page_data($page_data);
			$this->template->display_page();
		}
	}

	public function user_list()
	{
		if (!$this->session->is_admin)
		{
			redirect('/', 'refresh');
		}
		$user_list = array(
			'list' => $this->user->list_all_users(),
			);

		$this->template->set_title("Client List");

		$page_data = $this->parser->parse('user/user_list_view', $user_list	, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	/**
	 * Logout
	 */
	function logout()
	{
		$this->session->unset_userdata('logged_in');
		if ($this->session->userdata('is_admin')) {
			$this->session->unset_userdata('is_admin');
		}
		$this->session->sess_destroy();
		$this->ion_auth->logout();
		redirect('user/login');
	}



}