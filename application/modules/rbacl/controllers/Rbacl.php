<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rbacl extends Admin_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('parser');
		$this->load->helper('form');

		$this->load->config('ion_auth', TRUE);
		$this->identity_column = $this->config->item('identity', 'ion_auth');

		$this->load->model('rbacl_model');
		$this->rbacl = New Rbacl_model;

		// Only Admin users can access this functionality
		if (!$this->session->is_admin)
		{
			$this->session->set_flashdata('error', 'You need to be logged in as an administrator to access that feature.');
			redirect('/', 'refresh');
		}

	}

	public function index()
	{
	}

	public function view()
	{
		$rbacl_list = array(
			'list' => $this->rbacl->list_all(),
			);
		$this->template->set_title("Access Control List");

		$page_data = $this->parser->parse('rbacl/rbacl_list_view', $rbacl_list	, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function delete($id)
	{
		if (!$this->rbacl->delete($id)) {
			$this->session->set_flashdata('error', "We couldn't delete that entry, sorry.");
			redirect('/rbacl/view', 'refresh');
		}
		$this->session->set_flashdata('message', "Entry Deleted Successfully.");
		redirect('/rbacl/view', 'refresh');

	}

	public function add()
	{
		if ($this->form_validation->run('rbacl') == TRUE)
		{
			if (!$this->rbacl->add($this->input->post()))
			{
				$this->session->set_flashdata('error', "We weren't able to add that rbacl.");
				redirect('/rbacl/add', 'refresh');
			}
			$this->session->set_flashdata('Message', "RBACL added.");
			redirect('/rbacl/add', 'refresh');
		}

		$this->template->set_title("Create New Access Control List Entry");
		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-signin')),
			'form_close' => form_close(),
			);
		
		$page_data = $this->parser->parse('rbacl/rbacl_add_entry_view', $form	, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}
}