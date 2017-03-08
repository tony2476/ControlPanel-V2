<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Plesk API key;
 * Use this command to generate a key.
 * /usr/local/psa/bin/secret_key --create -ip-address xxx.xxx.xxx.xxx
 *
 * Also add the servers IP to 
 *
 * /usr/local/psa/admin/conf/panel.ini
 * 
 */

// database table (not currently used)
$config['dbtable'] = 'plesk';

// plesk server port number
$config['port'] = '8443';

// plesk server protocol http or https
$config['protocol'] = 'https';

if ($_SERVER['HTTP_HOST'] == 'cp2.local') {

	// Plesk servers hostname
	$config['host'] = 'localhost';
	// advisor plesk server
	$config['secret_key'] = 'bd237d7f-c9a9-9dab-c60d-548d76b71b19';
}
else {
	// Plesk servers hostname
	$config['host'] = 'webmail.advisornet.ca';
	// advisor plesk server
	$config['secret_key'] = 'a39aa624-f647-311c-fc79-9b472b24e499';
	#$config['secret_key'] = 'fd55cdb9-7e74-0f4b-b87b-e9118d0c812f';
}