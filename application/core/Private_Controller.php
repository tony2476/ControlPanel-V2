<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Public Class - used for all pages where the user doesn't need to be logged in.
 * 
 *  @author Karl Gray
 *  @copyright  2016 Advisornet / Tony Richardson 
 */

class Private_Controller extends MY_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// Set menu
		$this->menu->set_top_menu($this->config->item('private_top_menu_name'));
		$this->menu->set_side_menu($this->config->item('private_left_menu_name'));
		$menu_data = $this->menu->display_menu();
		$this->template->set_menu_data($menu_data);

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message', "You must be logged in to access this feature.");
			redirect('/user/login', 'refresh'); 
		}
		
	}

}