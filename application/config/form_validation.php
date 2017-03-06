<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config = array 
(
	'rbacl' => array 
	(
		array 
		(
			'field' => 'role_name', 
			'label' => 'role_name', 
			'rules' => 'required'
			),
		array 
		(
			'field' => 'path', 
			'label' => 'path', 
			'rules' => 'required'
			),
		array 
		(
			'field' => 'group_name', 
			'label' => 'group_name', 
			'rules' => 'required'
			),
		array 
		(
			'field' => 'description', 
			'label' => 'description', 
			'rules' => 'required'
			),
		
		),
	'personal' => array
	(
		array 
		(
			'field' => 'first_name', 
			'label' => 'first_name', 
			'rules' => 'required'
			),
		array 
		(
			'field' => 'last_name', 
			'label' => 'last_name', 
			'rules' => 'required'
			),
		),
	'login' => array 
	(
		array 
		(
			'field' => 'password', 
			'label' => 'Password', 
			'rules' => 'required'
			),
		array 
		(
			'field' => 'email', 
			'label' => 'Email', 
			'rules' => 'required|trim|max_length[128]'
			),
		),
	
	'contact' => array 
	(
		array 
		(
			'field' => 'username', 
			'label' => 'Username', 
			'rules' => 'required|trim|min_length[5]|max_length[30]|check_username'
			),

		array 
		(
			'field' => 'first_name', 
			'label' => 'first_name', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'last_name', 
			'label' => 'last_name', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'email', 
			'label' => 'email', 
			'rules' => 'required|trim|max_length[128]|valid_email|check_email'
			),

		array 
		(
			'field' => 'password', 
			'label' => 'password', 
			'rules' => 'min_length[8]|matches[password_repeat]'
			),

		array 
		(
			'field' => 'password_repeat', 
			'label' => 'password_repeat', 
			'rules' => 'matches[password]'
			),

		array 
		(
			'field' => 'MailingStreet', 
			'label' => 'MailingStreet', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'MailingCity', 
			'label' => 'MailingCity', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'MailingState', 
			'label' => 'MailingState', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'MailingPostalCode', 
			'label' => 'MailingPostalCode', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'MailingCountry', 
			'label' => 'MailingCountry', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'Phone', 
			'label' => 'Phone', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'MobilePhone', 
			'label' => 'MobilePhone', 
			'rules' => 'trim|min_length[2]|max_length[32]'
			),
		),


	'ion_contact_edit' => array 
	(
		array 
		(
			'field' => 'username', 
			'label' => 'Username', 
			'rules' => 'required|trim|min_length[5]|max_length[30]'
			),

		array 
		(
			'field' => 'first_name', 
			'label' => 'first_name', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'last_name', 
			'label' => 'last_name', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'email', 
			'label' => 'email', 
			'rules' => 'required|trim|max_length[128]|valid_email'
			),

		array 
		(
			'field' => 'password', 
			'label' => 'password', 
			'rules' => 'min_length[5]|matches[password_repeat]'
			),

		array 
		(
			'field' => 'password_repeat', 
			'label' => 'password_repeat', 
			'rules' => 'matches[password]'
			),
		),

	'ion_contact_create' => array 
	(
		array 
		(
			'field' => 'username', 
			'label' => 'Username', 
			'rules' => 'required|trim|min_length[5]|max_length[30]'
			),

		array 
		(
			'field' => 'first_name', 
			'label' => 'first_name', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'last_name', 
			'label' => 'last_name', 
			'rules' => 'required|trim|min_length[2]|max_length[32]'
			),

		array 
		(
			'field' => 'email', 
			'label' => 'email', 
			'rules' => 'required|trim|max_length[128]|valid_email'
			),

		array 
		(
			'field' => 'password', 
			'label' => 'password', 
			'rules' => 'min_length[5]|matches[password_repeat]'
			),

		array 
		(
			'field' => 'password_repeat', 
			'label' => 'password_repeat', 
			'rules' => 'matches[password]'
			),
		),

	);
