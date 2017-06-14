<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_model extends CI_Model 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
	}
	public function send_email($to, $from, $subject, $body)
	{

		$this->email->initialize();


		$this->email->from($from);
		$this->email->to($to);
		
		$this->email->subject($subject);
		$this->email->message($body);

		if ($this->email->send(FALSE))
		{
			
		}
		else
		{
			echo "NOT SENT";
			$this->email->print_debugger(array('headers'));
		}
	}

}