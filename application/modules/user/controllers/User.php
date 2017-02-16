<?php defined('BASEPATH') OR exit('No direct script access allowed');



/**
 *  This class handles functionality related to logged in users.  
 *  It cannot access any other system or modules except for ion_auth
 *  ion_auth is a requirement.
 */

class User extends Public_Controller {
	private $data;
	private $user;
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
		$this->user = New User_model;

		$this->load->config('ion_auth', TRUE);
		$this->identity_column = $this->config->item('identity', 'ion_auth');
		$this->config->load('user/config');
		$this->user_list_url = $this->config->item('user_list_url');
		$this->default_user_url = $this->config->item('default_user_url', 'user');
		$this->default_admin_url = $this->config->item('default_admin_url', 'user');
		
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

				if($this->ion_auth->is_admin()) {
					$this->session->set_userdata('is_admin', TRUE);
					redirect($default_admin_url);
				} 	else {
					redirect($default_user_url, 'refresh');
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
		redirect($user_list_url,'refresh');
	}

	/**
	 * Create a new user
	 * @return type
	 */
	public function create()
	{
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
			'form_open' => form_open('/user/create', array('class'=>'form-signin')),
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

		
		redirect('admin/clients','refresh');
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



	/**
	 * Activate Account,  from email link.
	 * link looks like this;
	 * http://cp.advisornet.ca/user/activate/$id/$auth_code
	 */
	function activate()
	{
		$user_id = $this->uri->segment(3);
		$auth_code = $this->uri->segment(4);

		if ($auth_code !== false)
		{
			$activation = $this->ion_auth->activate($user_id, $auth_code);
		}
		
		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("/", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("user/forgot", 'refresh');
		}
	}

	/**
	 * Forgot password
	 */
	function forgot()
	{
		// validators
		$this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
		$this->form_validation->set_rules('email', lang('users input email'), 'required|trim|max_length[256]|valid_email|callback__check_email_exists');

		if ($this->form_validation->run() == TRUE)
		{
			// Set filter by email with XSS protection.
			$filters['email'] = $this->input->post('email', TRUE);
			$user = $this->ion_auth->where($filters)->users()->result();
			$username = $user[0]->username;

			// send the email
			$result = $this->ion_auth->forgotten_password($username);
			// Set the message and redirect to the appropriate page..
			if ($result)
			{
				
				$this->session->set_flashdata('message', sprintf(lang('users msg password_reset_success'), $this->ion_auth->messages()));
				redirect("user/login", 'refresh'); //we should display a confirmation page here instead of the login page?
			}
			else
			{
				
				$this->session->set_flashdata('message', sprintf(lang('users error password_reset_failed'), $this->ion_auth->messages()));
			}

			// redirect home and display message
			redirect(base_url());
		}

		// setup page header data
		$this->set_title( lang('users title forgot') );

		$data = $this->includes;

		// set content data
		$content_data = array(
			'cancel_url' => base_url(),
			'user'       => NULL
			);

		// load views
		$data['content'] = $this->load->view('user/forgot_form', $content_data, TRUE);
		$this->load->view($this->template, $data);
	}

	// reset password - final step for forgotten password
	public function reset($code = NULL)
	{
		$code = $this->uri->segment(3);
		//echo $code;
		if (!$code)
		{
			show_404();
		}
		$user = $this->ion_auth->forgotten_password_check($code);
		if ($user)
		{
			log_message ('debug', "Got user");
			// if the code is valid then display the password reset form
			$this->form_validation->set_rules('password', lang('users input password'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_repeat]');
			$this->form_validation->set_rules('password_repeat', lang('users input password_repeat'), 'required|trim|matches[password]');
			if ($this->form_validation->run() == false)
			{
				
				$csrf = $this->_get_csrf_nonce();
				$this->set_title( lang('users title forgot') );

				$data = $this->includes;

				// set content data
				$content_data = array(
					'cancel_url' 	=> base_url(),
					'user'       	=> NULL,
					'csrf'			=> $csrf
					);

				// load views
				$data['content'] = $this->load->view('ion/password_reset_form', $content_data, TRUE);
				$this->load->view($this->template, $data);

			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					// nonce doesn't match
					$this->ion_auth->clear_forgotten_password_code($code);
					$this->session->set_flashdata('message', sprintf(lang('users error password_reset_failed'), $this->ion_auth->messages()));
					log_message ('debug', "Nonce didn't match.");
					redirect("user/login", 'refresh');

				}
				else  // Nonce matches - reset the password.
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};
					$change = $this->ion_auth->reset_password($identity, $this->input->post('password'));
					if ($change)
					{
						// if the password was successfully changed
						
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("user/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('user/login/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("user/forgot", 'refresh');
		}
	}

	function _check_username($username, $current)
	{
		//$this->ion_auth->identity_check($username)
		if (trim($username) != trim($current) && $this->ion_auth->identity_check($username))
		{
			$this->form_validation->set_message('_check_username', "Username $username already exists");
			return FALSE;
		}
		else
		{
			return $username;
		}
	}

	/* 
	 * Check if the email address already exists.
	 * 
	 * We can't have duplicate accounts.
	 * Callback for forms.
	 */

	function _check_email($email, $current)
	{
		if (trim($email) != trim($current) && $this->ion_auth->email_check($email))
		{
			$this->form_validation->set_message('_check_email', "The email address $email already exists on this system, we can't add again");
			return FALSE;
		}
		else
		{
			return $email;
		}
	}
}