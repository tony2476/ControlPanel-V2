<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config = array 
(
	'service_group' => array 
	(
		array 
		(
			'field' => 'group_name', 
			'label' => 'group_name', 
			'rules' => 'required'
			),
		array 
		(
			'field' => 'group_description', 
			'label' => 'group_description', 
			'rules' => 'required'
			),
		),

	'services' => array 
	(
		array 
		(
			'field' => 'short_code', 
			'label' => 'short_code', 
			'rules' => 'required|alpha_dash'
			),
		array 
		(
			'field' => 'description', 
			'label' => 'description', 
			'rules' => 'required'
			),
		array 
		(
			'field' => 'service_group', 
			'label' => 'service_group', 
			'rules' => 'required'
			),
		array 
		(
			'field' => 'price', 
			'label' => 'price', 
			'rules' => 'required|decimal'
			),
		array 
		(
			'field' => 'setup', 
			'label' => 'setup', 
			'rules' => 'required|decimal'
			),
		array 
		(
			'field' => 'period', 
			'label' => 'period', 
			'rules' => 'required|integer|is_natural_no_zero'
			),
		array 
		(
			'field' => 'cycle', 
			'label' => 'cycle', 
			'rules' => 'required|integer|is_natural_no_zero'
			),
		array 
		(
			'field' => 'pre_paid', 
			'label' => 'pre_paid', 
			'rules' => 'required|decimal'
			),
		array 
		(
			'field' => 'discount', 
			'label' => 'discount', 
			'rules' => 'required|integer|is_natural'
			),
		array 
		(
			'field' => 'discount_period', 
			'label' => 'discount_period', 
			'rules' => 'required|integer|is_natural'
			),
		),

	);




