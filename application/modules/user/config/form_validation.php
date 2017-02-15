<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config = array 
(
	'login' => array 
	(
		array 
		(
			'field' => 'password', 
			'label' => 'Password', 
			'rules' => 'required|min_length[5]'
			),
		array 
		(
			'field' => 'email', 
			'label' => 'Email', 
			'rules' => 'required|trim|max_length[128]'
			),
		),
	);
