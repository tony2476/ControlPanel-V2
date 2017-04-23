<?php defined('BASEPATH') OR exit('No direct script access allowed');

// configuration specific to the user module.
 
$db['vhosts'] = array(
		'dsn'   => '',
		'hostname' => 'localhost',
		'username' => 'vhosts',
		'password' => 'uhEaks$12',
		'database' => 'vhosts',
		'dbdriver' => 'mysqli',
		'dbprefix' => '',
		'pconnect' => TRUE,
		'db_debug' => TRUE,
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'encrypt' => FALSE,
		'compress' => FALSE,
		'stricton' => FALSE,
		'failover' => array()
);

$db['dev_server'] = array(
		'dsn'   => '',
		'hostname' => 'dpsys.ca',
		'username' => 'root',
		'password' => 'uhEaks$12',
		'database' => 'mysql',
		'dbdriver' => 'mysqli',
		'dbprefix' => '',
		'pconnect' => TRUE,
		'db_debug' => TRUE,
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'encrypt' => FALSE,
		'compress' => FALSE,
		'stricton' => FALSE,
		'failover' => array()
);
