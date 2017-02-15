<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User extends Public_Controller {
	private $data;

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('parser');

	}



	public function index()
	{
	}

	public function login()
	{
		//$this->form_validation->set_rules('username', 'email', 'required|trim|max_length[256]');
		//$this->form_validation->set_rules('password', 'Password', 'required|trim|max_length[72]');
		if ($this->form_validation->run('login') == TRUE) {
			$remember = (bool) $this->input->post('remember');
			$username = $this->input->post('email');
			$password = $this->input->post('password');
			log_message('error', "KG - Attempting login");
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
				log_message('error', "KG- $username and $password could not login");
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('user/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}

		}

		else 
		{
			log_message('error', "KG- Didn't pass Validation");
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
			// setup page header data
			

			/*$data = $this->includes;
			// set content data

			$ok_to_login = TRUE;
			$content_data = array(
				'ok_to_login' => $ok_to_login
				);*/

				$this->template->set_title("Login Page");
				
				
				$form = array 
				(
					'form_open' => form_open('', array('class'=>'form-signin')),
					'form_close' => form_close(),
					);
				$page_data = $this->parser->parse('user/login_form_view', $form, TRUE);
				//$page_data = $this->load->view("user/login_form_view", '', TRUE);

				$this->template->set_page_data($page_data);
				$this->template->display_page();

				
				//$this->load->view($this->template, $data);
			}
		}

		public function logout()
		{

		}




	}