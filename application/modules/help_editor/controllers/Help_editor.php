<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Help_editor extends Admin_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('help_editor/help_editor_model');
		$this->help = New Help_editor_model;
		if (!$this->session->is_admin)
		{
			$this->session->set_flashdata('error', 'You need to be logged in as an administrator to access that feature.');
			redirect('/', 'refresh');
		}

	}

	public function index()
	{

	}

	public function help_list()
	{
		$id = $this->uri->segment(3);
		$list = $this->help->list_help();
		
		$this->template->set_title("");

		$form = array(
			'list' => $list,
			);
		$page_data = $this->parser->parse('help_editor/help_editor_list_view', $form, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function ajax_save()
	{
		$html='';
		if ($this->input->post('content')) 
		{
			$content = $this->input->post('content');
			$id = $this->input->post('id');
			$this->help->save_help($id, $content);
		}
	}

	public function help_delete()
	{
		$id = $this->uri->segment(3);

		if (!$this->help->delete_help($id))
		{
		$this->session->set_flashdata('error', 'Delete Failed');
		}
		else
		{
			$this->session->set_flashdata('message', "Succesfully deleted help item with id $id");
		}

		redirect('/help_editor/help_list', 'refresh');

	}

	public function help_edit()
	{
		$id = $this->uri->segment(3);
		$content = $this->help->load_help($id);
		
		$this->template->set_title("");

		$form = array(
			'content' => $content['content'],
			'path' => $content['path'],
			);
		$page_data = $this->parser->parse('help_editor/help_editor_view', $form, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}
}