<?php defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Form_validation extends CI_Form_validation{    
	function __construct($config = array()){
		parent::__construct($config);
		$this->CI =& get_instance();

	}

	function check_username($username, $current)
	{
		//$this->ion_auth->identity_check($username)
		if (trim($username) != trim($current) && $this->CI->ion_auth->identity_check($username))
		{
			$this->CI->form_validation->set_message('_check_username', "Username $username already exists");
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

	function check_email($email, $current)
	{
		if (trim($email) != trim($current) && $this->CI->ion_auth->email_check($email))
		{
			$this->CI->form_validation->set_message('_check_email', "The email address $email already exists on this system, we can't add again");
			return FALSE;
		}
		else
		{
			return $email;
		}
	}

}