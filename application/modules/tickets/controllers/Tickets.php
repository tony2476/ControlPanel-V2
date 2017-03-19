<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends Private_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('salesforce/salesforce_model');
		$this->salesforce = New Salesforce_model;
		$this->fullname = $this->user->first_name . " " . $this->user->last_name;
		
	}

	public function index ()
	{

	}

	public function tickets_list()
	{

		$this->template->set_title("Your tickets.");
		$tickets = $this->salesforce->get_case_list_by_contact_id($this->user->sf_contact_id);

		$data = array ('tickets' => (array) $tickets);


		if ($tickets !='') {
			$page_data = $this->parser->parse('tickets/tickets_list_view', $data, TRUE);
		}
		else {

			$this->session->set_flashdata('message', "You don't have any tickets.  You need to create a ticket before you can view any.");
			redirect('tickets/ticket_create', 'refresh'); 
		}

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function ticket_create()
	{
		if ($this->form_validation->run('create_ticket') == TRUE)
		{
			$sf_contact_id = $this->user->sf_contact_id;
			$subject = $this->input->post('subject');
			$comment = $this->input->post('comment');
			$name = $this->user->first_name . " " . $this->user->last_name . "\n";
			
			if ($this->salesforce->create_case ($sf_contact_id, $subject, $comment, $name))
			{
				$this->session->set_flashdata('message', "Ticket Created.");
				redirect('tickets/tickets_list', 'refresh'); 
			}
			$this->session->set_flashdata('error', "Failed to create ticket.");
		}
		
		$this->template->set_title("Create a new ticket.");

	
		
		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);

		$page_data = $this->parser->parse('tickets/create_ticket_form_view', $form, TRUE);
		if (validation_errors())
		{
			$this->session->set_flashdata('message', validation_errors());
		}
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function ticket_view()
	{
		$ticket_id = $this->uri->segment(3);
		$ticket = $this->salesforce->get_case_by_case_id($ticket_id, $this->user->sf_contact_id ,$this->fullname);

		$this->template->set_title("View ticket details.");
		$data = array 
		(
			'CaseNumber' => $ticket->header[0]['CaseNumber'],
			'Subject' => $ticket->header[0]['Subject'],
			'CreatedDate' => $ticket->header[0]['CreatedDate'],
			'Status' => $ticket->header[0]['Status'],
			'Description' => $ticket->header[0]['Description'],
			'ticket_comments' => (array) $ticket->responses,
			);
		
		$page_data = $this->parser->parse('tickets/view_ticket_details_view', $data, TRUE);
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}
}
