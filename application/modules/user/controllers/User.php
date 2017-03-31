<?php defined('BASEPATH') OR exit('No direct script access allowed');



/**
 *  This class handles functionality related to logged in users.  
 *  It cannot access any other system or modules except for ion_auth
 *  ion_auth is a requirement.
 */

class User extends Public_Controller {
	private $data;
	public $user;
	private $user_list_url;
	private $default_user_url;
	private $default_admin_url;

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('parser');
		$this->load->model('user/user_model');
		$this->load->helper('form');
		$this->user = New User_model;

		$this->load->config('ion_auth', TRUE);
		$this->identity_column = $this->config->item('identity', 'ion_auth');
		$this->config->load('user/config');
		
		$this->user_list_url = $this->config->item('user_list_url');
		$this->default_user_url = $this->config->item('default_user_url');
		$this->default_admin_url = $this->config->item('default_admin_url');
		$this->sf_cache_enabled = $this->config->item('sf_cache_enabled');
		
		


	}

	public function set_default_list_url($url)
	{
		//If you create a new user class to handle functions this one doesn't
		//and you want functionality such as create user to return to your list rather than this one.
		//use this.
		$this->user_list_url = $url;
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

				if ($this->sf_cache_enabled == 'TRUE') 
				{
					$this->load_sf_cache();
				}
				if($this->ion_auth->is_admin()) {
					$this->session->set_userdata('is_admin', TRUE);
					redirect($this->default_admin_url);
				} 	else {
					redirect($this->default_user_url, 'refresh');
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
			//the user is not logging in or has failed, display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->session->set_flashdata('message', $this->data['message']);
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

			$this->template->set_title("");

			$form = array 
			(
				'form_open' => form_open('', array('class'=>'form-signin')),
				'form_close' => form_close(),
				);
			$page_data = $this->parser->parse('user/login_form_view', $form, TRUE);
			$this->template->disable_help();
			$this->template->set_page_data($page_data);
			$this->template->display_page();
		}
	}

	public function load_sf_cache()
	{
		$this->load->model('salesforce/salesforce_model');
		$this->salesforce = New Salesforce_model;
		$this->user = $this->ion_auth->user()->row();
		$sf_contact_id = $this->user->sf_contact_id;
		$this->salesforce->populate_cache($sf_contact_id);
	}

	/**
 	* Use Harold for testing.
 	* @return type
 	*/
 	public function assistants()
 	{
 		$assistant_list = array(
 			'list' => $this->user->list_all_assistants(),
 			);
 		$this->template->set_title("Assistant List");

 		$page_data = $this->parser->parse('user/assistant_list_view', $assistant_list	, TRUE);

 		$this->template->set_page_data($page_data);
 		$this->template->display_page();
 	}

 	public function assistant_status()
 	{
 		$assistant_id = $this->uri->segment(3);
 		if (!$this->user->is_assistant($assistant_id))
 		{
 			redirect('/user/assistants', 'refresh');
 		}

 		$user_id = $this->uri->segment(3);
 		$current_user = $this->ion_auth->get_user_id();
 		if ($current_user == $user_id) {
 			$this->session->set_flashdata('message','You are not allowed to suspend/resume Yourself.');
 			redirect('/user/assistants', 'refresh');
 		}

 		$user = $this->ion_auth->user($assistant_id)->row();
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
 		redirect('/user/assistants', 'refresh');

 	}

 	public function assistant_edit()
 	{

 	}

 	public function assistant_delete()
 	{

 	}

 	public function user_list()
 	{
 		if (!$this->session->is_admin)
 		{
 			$this->session->set_flashdata('error', 'You need to be logged in as an administrator to access that feature.');
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
			$this->session->set_flashdata('error', 'You need to be logged in as an administrator to access that feature.');
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

		// Load sf cache if enabled.
		if ($this->sf_cache_enabled == 'TRUE') 
		{
			$this->load_sf_cache();
		}

		//Set the new users admin status.
		if($this->ion_auth->is_admin()) 
		{
			$this->session->set_userdata('is_admin', TRUE);
			redirect($user_list_url,'refresh');
		} 	else {
			$this->session->set_userdata('is_admin', FALSE);
			redirect('/' , 'refresh');
		}
	}

	/**
	 * Allows an admin user to toggle the status of a user from suspend to active and visa versa
	 * @return type
	 */
	public function toggle_status()
	{
		if (!$this->session->is_admin)
		{
			$this->session->set_flashdata('error', 'You need to be logged in as an administrator to access that feature.');
			redirect('/', 'refresh');
		}
		$user_id = $this->uri->segment(3);
		$current_user = $this->ion_auth->get_user_id();
		
		if ($current_user == $user_id) {
			$this->session->set_flashdata('message','You are not allowed to suspend/resume Yourself.');
			redirect($this->user_list_url,'refresh');
		}

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
		redirect($this->user_list_url,'refresh');
	}

	/**
	 * Create a new user
	 * @return type
	 */
	public function create()
	{
		if (!$this->session->is_admin)
		{
			$this->session->set_flashdata('error', 'You need to be logged in as an administrator to access that feature.');
			redirect('/', 'refresh');
		}
		// validators
		$this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
		$this->form_validation->set_rules('username', 'Username', 'check_username');
		$this->form_validation->set_rules('email', 'Email', 'check_email');
		// Is form Validated
		if ($this->form_validation->run('contact') == TRUE)
		{
			// Set user to admin?
			if ($this->input->post('is_admin') == 'yes') 
			{
				$group = array('1');
			} 
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$email = $this->input->post('email');
			
			
			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				);
			
			// save the new user in ion auth.
			if (!$saved = $this->ion_auth->register($username, $password, $email, $additional_data, $group))
			{
			// Log any errors.
				$errors = $this->ion_auth->errors_array();
				foreach ($errors as $error)
				{
					log_message ('error', "ion_auth->register Error: $error");
				}

				// Set message and redirect.
				$this->session->set_flashdata('error',  "We were note able to create the user " . $this->input->post('first_name') . " " . $this->input->post('last_name'));
				$this->session->set_flashdata('message', $this->ion_auth->messages());
			}
			redirect($this->user_list_url); 
		} 

		$this->template->set_title("Create a new user.");

		$form = array 
		(
			'form_open' => form_open('/user/create', array ('class'=>'form-signin')),
			'form_close' => form_close(),
			);
		$page_data = $this->parser->parse('user/create_user_form_view', $form, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	/**
	 * Delete a User
	 * @return type
	 */
	public function delete()
	{
		if (!$this->session->is_admin)
		{
			$this->session->set_flashdata('message','You Do not have permission to access that feature.');
			redirect('/', 'refresh');
		}
		$user_id = $this->uri->segment(3);
		# You are not allowed to delete yourself.
		$current_user = $this->ion_auth->get_user_id();
		
		if ($current_user == $user_id) {
			$this->session->set_flashdata('message','You are not allowed to Delete Yourself.');
			redirect('admin/clients','refresh');
		}

		if(is_null($user_id))
		{
			$this->session->set_flashdata('message','This user does not appear to exist, We cannot delete a non existent user.');
		}
		else
		{
			$this->ion_auth->delete_user($user_id);
			$this->session->set_flashdata('message',$this->ion_auth->messages());
		}

		
		redirect($this->user_list_url,'refresh');
	}

	/**
	 * Allows an admin user to edit any user on the system.
	 * @return type
	 */
	public function user_edit()
	{
		if (!$this->session->is_admin)
		{
			$this->session->set_flashdata('error', 'You need to be logged in as an administrator to access that feature.');
			redirect('/', 'refresh');
		}
		
		// Get user ID from URL
		$user_id = $this->uri->segment(3);

		// make sure we have a numeric id
		if (is_null($user_id) OR ! is_numeric($user_id))
		{
			$this->session->set_flashdata('error', "$user_id is either missing or not numeric");
			redirect($this->user_list_url,'refresh');
		}
		$this->user = $this->ion_auth->user($user_id)->row();

		if (!isset($this->user->id)) {
			$this->session->set_flashdata('error', "$user_id is not a valid user id.");
			redirect($this->user_list_url,'refresh');	
		}

		// Save the original username and email in case the user changes it.
		$this->session->set_userdata('original_username', $this->user->username);
		$this->session->set_userdata('original_email', $this->user->email); 

		// Validate the Form
		$this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
		
		// If the form validated
		if ($this->form_validation->run('ion_contact_edit'))
		{

			// save the changes
			$this->ion_auth->update($user_id, $this->input->post());

			// return to list and display message
			redirect($this->user_list_url,'refresh');
		}
		
		if ($this->form_validation->run('ion_contact_edit') === FALSE) {
			$this->session->set_flashdata('validation_error', validation_errors());
			
		}

		// Set is_admin for form.		
		if ($this->ion_auth->is_admin($user_id)) 
		{
			$this->user->is_admin = 'checked'; 
			
		} 
		else 
		{
			$this->user->is_admin = '';
		}

		$this->template->set_title("Edit User.");

		$form_headers = array 
		(
			'form_open' => form_open("/user/user_edit/$user_id", array ('class'=>'form-signin')),
			'form_close' => form_close(),
			);
		$form = array_merge ($form_headers, (array) $this->user);

		$page_data = $this->parser->parse('user/edit_user_form_view', $form, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();

	}

		/**
	 * Registration Form
	 */
		public function register()
		{
		// validators
			$this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));


			if ($this->form_validation->run('ion_contact_create') == TRUE)
			{
				$username = $this->input->post('username');
				$first_name = $this->input->post('first_name');
				$last_name = $this->input->post('last_name');
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$additional_data = array(
					'first_name' => $first_name,
					'last_name' => $last_name
					);

				if($this->ion_auth->register($username,$password,$email,$additional_data, $group ))
				{
					$this->session->set_flashdata('message', sprintf(lang('users msg register_success'), $this->input->post('first_name', TRUE)));
				}
				else
				{
					log_message('debug', "REGISTER USER FAILED: " . $this->ion_auth->errors());
					$this->session->set_flashdata('error', 'User registration failed');
					redirect('/user/register', 'refresh');
				}

			// redirect home and display message
				redirect(base_url());
			}

			$this->template->set_title("Create Account.");

			$form = array 
			(
				'form_open' => form_open("/user/register", array ('class'=>'form-signin')),
				'form_close' => form_close(),
				);


			$page_data = $this->parser->parse('user/register_user_form_view', $form, TRUE);

			$this->template->set_page_data($page_data);
			$this->template->display_page();
		}
	}