<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//$config['setting_name'] = 'example_result';

if ($_SERVER['HTTP_HOST'] == 'cp2.local'){

	$config['mail_settings']['to'] = 'karl@gray.me.uk';
	$config['mail_settings']['from'] = 'cp@advisornet.ca';
	$config['mail_settings']['admin_order_notification_email_subject'] = "Order Received";

} 

else

{
	$config['mail_settings']['to'] = 'tony@advisornet.ca';
	$config['mail_settings']['from'] = 'cp@advisornet.ca';
	$config['mail_settings']['admin_order_notification_email_subject'] = "Order Received";	
}

