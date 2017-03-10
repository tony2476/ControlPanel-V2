<?php defined('BASEPATH') OR exit('No direct script access allowed');



/**
 *  This class handles functionality related to logged in users.  
 *  It cannot access any other system or modules except for ion_auth
 *  ion_auth is a requirement.
 */

class Mail extends Private_Controller {


	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('plesk/plesk_model');
		$this->plesk = New Plesk_model;
	}

	public function manage()
	{
		if ($this->user->plesk_email == '')
		{
			if (!is_object($this->session->userdata('sf_cache')))
			{
				$this->session->set_flashdata('error', "We cannot locate any data for this user.");
				redirect('/','refresh');	
			}

			$sf_data = clone $this->session->userdata('sf_cache');
			unset ($sf_data->Account->fields->Web_Disclaimer__c);
			unset ($sf_data->Account->fields->Web_Privacy__c);
			echo "Plesk_email not found<br>";
			

		}
		if (!$site_id = $this->user->plesk_site_id) 
		{
			$this->session->set_flashdata('error', "We cannot locate your plesk account, please contact support");
			redirect('/','refresh');
		}
		if ($mailboxes = $this->plesk->get_mailboxes($site_id))
		{
			foreach ($mailboxes as &$mailbox)
			{
				
				if ($mailbox->status == 'false')
				{
					$mailbox->color = 'btn-danger';
					$mailbox->icon = 'glyphicon-play';
					$mailbox->status = 'disabled';
				}
				else
				{
					$mailbox->status = 'enabled';
					$mailbox->colour = 'btn-success';
					$mailbox->icon = 'glyphicon-pause';
				}
				$mailbox = (array) $mailbox;

			}
		}
		$data = array(
			'mailboxes' => (array) $mailboxes,
			);

		$this->template->set_title("Mail Boxes.");
		$page_data = $this->parser->parse('mail/mail_mymailbox_view', $data, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}
}