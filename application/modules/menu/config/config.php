<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config['top_menu'] = array (
			'menu' => array (
				array (
					'title' => 'Home',
					'href'	=>	"#",
					'sort_order' =>	"0",
					'ul_class'			=>	'',
					'required_group'	=>	FALSE,
					),
				array (
					'title' => '<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>',
					'href'	=>	"#",
					'sort_order' =>	"1",
					'ul_class'	=>	'dropdown-menu settings-messages',
					'submenu'	=>	array (
					// Use index => array to create a new menu and set it's sort order.
						0 => array (
							'title' => '<i class="fa fa-user fa-fw"></i> User Profile</a>',
							'href'	=>	"#",
							'footer' =>	FALSE,
							'required_group'	=>	FALSE,
							),
						2 => array (
							'title' => '<i class="fa fa-gear fa-fw"></i> Settings</a>',
							'href'	=>	"#",
							'footer' =>	TRUE,
							'required_group'	=>	FALSE,
							),
						1 => array (
							'title' => '<i class="fa fa-sign-out fa-fw"></i> Logout</a>',
							'href'	=>	"#",
							'footer' =>	FALSE,
							'required_group'	=>	FALSE,
							),
						),
					),
				)
			);
