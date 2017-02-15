<?php defined('BASEPATH') OR exit('No direct script access allowed');



/**
 *  This class handles functionality related to logged in users.  
 *  It cannot access any other system or modules except for ion_auth
 *  ion_auth is a requirement.
 */

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

		$this->load->config('ion_auth', TRUE);
		$this->identity_column = $this->config->item('identity', 'ion_auth');
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

	/**
	 * Allows an admin user to login as another user.
	 * @return type
	 */
	public function login_as_user()
	{
		// Only Admins can acccess this function.
		if (!$this->session->is_admin)
		{
			redirect('/', 'refresh');
		}
		
		// Get the user_id from the URL
		$user_id = $this->uri->segment(3);

		// Get the user record from ion_auth
		$user = $this->ion_auth->user($user_id)->row();

		// If we don't have a valid $user redirect back to client list
		if (!$user) {
			redirect('/user/user_list','refresh');
		}

		// If the user you are trying to login as is not active abort.
		if ($user->active == 0)
		{
			$this->session->set_flashdata('error', 'That user is not active,  you cannot login is an inactive user.');
			redirect('/user/user_list','refresh');
		}
		//Store the new users data.
		$session_data = array(
			'identity'				=> $user->{$this->identity_column},
			$this->identity_column	=> $user->{$this->identity_column},
			'email'					=> $user->email,
			'user_id'				=> $user->id, //everyone likes to overwrite id so we'll use user_id
			'old_last_login'		=> $user->last_login
			);

		$this->session->set_userdata($session_data);

		//Set the new users admin status.
		if($this->ion_auth->is_admin()) 
		{
			$this->session->set_userdata('is_admin', TRUE);
			redirect('/user/user_list','refresh');
		} 	else {
			$this->session->set_userdata('is_admin', FALSE);
			redirect('/user/user_list','refresh');
		}

		echo "Logging in as $user->first_name";

	}

	/**
	 * Allows an admin user to toggle the status of a user from suspend to active and visa versa
	 * @return type
	 */
	public function toggle_status()
	{
		if (!$this->session->is_admin)
		{
			redirect('/', 'refresh');
		}

		$user_id = $this->uri->segment(3);
		$user = $this->ion_auth->user($user_id)->row();
		$status = $user->active;
		
		if ($status) {
			$status = 0;
		} else
		{
			$status = 1;
		}

		$data = array(
			'active' => $status,
			);
		
		$this->ion_auth->update($user_id, $data);

		/* CONVERT THIS ONCE ASSISTANT MODULE IN PLACE.
		//  If status is 0 then suspend all assistants also.
		if (!$status) {
			# Acccess assistant model
			$assistant = new Assistant_model;
			// Get all Assistants belonging to the suspended user
			// If user we are suspending is not an owner then the return will be false.
			$result = $assistant->get_all($user_id);
			$users = $result['results'];

			if ($users) 
			{
				foreach ($users as $user) 
				{
					$user_id = $user['user_id'];
					$this->ion_auth->update($user_id, $data);
				}
			}
		} */

		redirect('/user/user_list','refresh');
	}

	/**
	 * Allows an admin user to edit any user on the system.
	 * @return type
	 */
	public function user_edit()
	{
		if (!$this->session->is_admin)
		{
			redirect('/', 'refresh');
		}
	}

	public function display_session()
	{
		if (!$this->session->is_admin)
		{
			redirect('/', 'refresh');
		}
		echo "<pre>";
		echo "Session data <br />";
		print_r ($this->session->all_userdata());
		echo "</pre>";
		
		
	}


}