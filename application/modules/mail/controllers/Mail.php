<?php defined('BASEPATH') OR exit('No direct script access allowed');

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

	public function mymailbox()
	{
		if (!$mailbox_id = $this->user->plesk_mailbox_id)
		{
			$this->session->set_flashdata('error', "We cannot locate your mail account, please contact support.");
			//redirect('/','refresh');
		}

		$email = $this->user->plesk_email;

		if (!$this->plesk->get_email_settings($email)) {
			$this->session->set_flashdata('error', "We could not load your settings, please contact support.");
			//redirect('/','refresh');
		}

		$this->template->set_title("Mail Box Settings.");

		$form_data = array 
		(
			'autoresponder_form_open' => form_open('', array('class'=>'form-horizontal')),
			'autoresponder_form_close' => form_close(),
			'alias_form_open' => form_open('', array('class'=>'form-horizontal')),
			'alias_form_close' => form_close(),
			'forwarding_form_open' => form_open('', array('class'=>'form-horizontal')),
			'forwarding_form_close' => form_close(),
			);


		$plesk_data = array(
			'forwarding'		=> array ((array) $this->plesk->forwarding),
			'aliases'			=> (array) $this->plesk->alias,
			'autoresponder'		=> array ((array) $this->plesk->autoresponder),
			'username'			=> $this->user->plesk_email
			);

		$data = $plesk_data + (array) $form_data;

		$page_data = $this->parser->parse('mail/mail_manage_my_mailbox_view', $data, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function manage()
	{
		if ($this->user->plesk_email == '')
		{
			$this->session->set_flashdata('error', "We cannot locate any data for this user.  If you have only recently been added to the system please try logging out and logging back in again.");
			redirect('/','refresh');	
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
		$page_data = $this->parser->parse('mail/mail_manage_mailboxes_view', $data, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}
}