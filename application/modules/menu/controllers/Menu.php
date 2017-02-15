<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Menu extends MX_Controller {
	/**
	 * Constructor
	 */

	private 	$top_menu;
	private 	$side_menu;
	private 	$menu;
	function __construct()
	{
		parent::__construct();
		$this->template_module_path = APPPATH.'modules/'.$this->router->fetch_module() . "/views/";
		// Load the module config file.
		$this->load->config('config');
		$this->load->model('menu/menu_model');
		$this->menu = New Menu_model;
	}

	public function test()
	{
		$top_data = $this->config->item($this->top_menu);
		
		echo "<pre>";
		echo "top menu array\n <br />";
		print_r ($top_data);
		

		$data = json_encode($top_data);
		echo "json data \n<br />";
		print_r ($data);

		$data = json_decode($data, TRUE);
		echo "json decoded data \n<br />";
		print_r ($data);


		echo "</pre>";
	}

	public function index()
	{
		echo "Working, but nothing here";
	}



	public function display_menu()
	{
		//Get the top menu data, then remove any items this user does not RBACL access rights to.
		#$top_data = $this->config->item($this->top_menu);
		$username = '';
		if ($user = $this->ion_auth->user()->row())
		{
			$username = "$user->first_name  $user->last_name";
		}


		$top_data = array 
		(
			'menu' => $this->menu->load_menu('Top_Menu', 'horizontal'),
			'username' => $username,
			);
		
		#$top_data = $this->check_item_permissions($top_data);

		//Get the left menu data, then remove any items this user does not RBACL access rights to.
		$left_data = array(
			'menu' => $this->menu->load_menu('Left_Menu', 'vertical'),

		);  // Temporary holding data until we implement it.

		
		# build the menu,  get the header, the top menu and the left menu and return the whole menu structure.
		$menu_data = $this->load->view("menu/default_menu_header_view", '', TRUE);

		$menu_data .= $this->parser->parse('menu/default_top_menu_template_view', $top_data, TRUE);
		$menu_data .= $this->parser->parse("menu/default_left_menu_view", $left_data, TRUE);

		
		#$menu_data .= $this->load->view("menu/default_left_menu_view", $left_data, TRUE);
		return ($menu_data);
	}

	public function load_menu($menu_name)
	{
		$sql = "select ID from menus where menu_name = '$menu_name'";
		return (json_decode($result['menu_data']));

	}

	/**
	 * Set the name of the top menu
	 * @param type $menuname 
	 * @return type
	 */
	public function set_top_menu($menuname)
	{
		$this->top_menu = $menuname;
		return TRUE;
	}

	/**
	 * Set the name of the left menu.
	 * @param type $menuname 
	 * @return type
	 */
	public function set_side_menu($menuname) 
	{
		$this->side_menu = $menuname;
		return TRUE;
	}

	/*
	 * This sets the roles this user has access to.
	 * Using this list we can determine which menu items to display.
	 */
	public function set_roles($roles)
	{

	}

	/**
	 * Checks each menu item against the RBACL list to see if access is allowed.
	 * It will remove any menuitem that isn't accessible by the currently logged in user.
	 * 
	 * Orthogonal ???  Calling the RBACL module from here is NOT GOOD!  So we pass the roles for the currently logged in user via set_roles.
	 * Then in this function we check each item against each role the user is allowed access to and remove prohibited items from the menu to avoid confusion.
	 * 
	 * returns the edited menu.
	 * 
	 * @param type $menu 
	 * @return type
	 */
	private function check_item_permissions($menu) {
		//ChromePhp::log($menu);
		foreach ($menu['menu'] as $primarykey => $primary)
		{
			if (isset($primary['submenu'])) 
			{
				foreach ($primary['submenu'] as $itemkey => $item) 
				{
					if ($item['required_group'] != FALSE) 
					{
						unset($menu['menu'][$primarykey]['submenu'][$itemkey]);
					}
				}
			}
		}
		return $menu;
	}

	function _remap()
	{
		echo 'No direct access allowed';
	}
}