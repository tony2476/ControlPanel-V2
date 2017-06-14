<?php
// rest config
// 
$config['rest_auth'] = 'basic';
$config['rest_default_format'] = 'json';
$config['rest_status_field_name'] = 'status';
$config['rest_message_field_name'] = 'error';

// We need to add the white list here.
$config['rest_ip_whitelist_enabled'] = FALSE;
$config['rest_ip_whitelist'] = '';


// Only support English for now;
$config['rest_language'] = 'english';


// Set a different login for each each server so we can monitor usage etc.
$config['rest_valid_logins'] = ['admin' => '1234'];