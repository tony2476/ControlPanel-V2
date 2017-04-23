<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config = array 
(
	'tax_by_province' => array 
	(
		array 
		(
			'field' => 'province', 
			'label' => 'province', 
			'rules' => 'required'
			),
		array 
		(
			'field' => 'description', 
			'label' => 'description', 
			'rules' => 'required'
			),
		array 
		(
			'field' => 'rate', 
			'label' => 'rate', 
			'rules' => 'required'
			),
		),
	);


