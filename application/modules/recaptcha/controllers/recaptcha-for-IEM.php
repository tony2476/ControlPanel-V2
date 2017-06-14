<?php
/*
 *      This is code is to provide The ReCaptcha checking facility to IEM
 *      It is a temporary system adapted from our CP2 code until we can
 *      move away from IEM to a proper modern mail manager.
 *      
 *      Excuse the hackiness.
 */

const   BASEPATH = '/var/www/vhosts/financialwisdom.ca';
include ('../central-libraries/vendor/autoload.php');
include ('../central-libraries/Salesforce/salesforce_library.php');
include ('../central-libraries/Salesforce/Salesforce_model.php');

// Get the referrer,  make sure we are not being injected.
$url = $_SERVER['HTTP_REFERER'];
if ($url =='')
{
	echo "Invalid Form";
	exit;
}

// Extract the domain so we can retrieve settings from Salesforce.
$bang = explode("/", $url);
$domain = $bang[2];
$domain = str_replace('www.','',$domain);

// Check with salesforce if this domain has ReCaptcha Enabled?
$sf = new Salesforce_Model;
$sf_account_id          = $sf->get_account_id_by_domain($domain);
$records                = $sf->get_all_company_records($sf_account_id);
$secret_key             = $records->reCaptcha_Secret_Key__c;
$site_key               = $records->reCaptcha_Site_Key__c;
$captcha_enabled        = $records->IEM_reCaptcha_Enabled__c;

if ($captcha_enabled == 'true')
{
	if ($secret_key == '')
	{
		echo "Invalid Form";
		exit;
	}
        // Setup variable for ReCaptcha call
	$gRecaptchaResponse     = (isset($_POST['g-recaptcha-response'])) ? $_POST['g-recaptcha-response'] : false;
	$remoteIp               = $_SERVER['REMOTE_ADDR'];

        // Build recaptcha class and call verify.
	$recaptcha              = new \ReCaptcha\ReCaptcha($secret_key);
	$resp                   = $recaptcha->verify($gRecaptchaResponse, $remoteIp);

        // If success do nothing (currently).   We could have done !$resp->isSuccess()  but we may need this in future for logging purposes etc.
	if ($resp->isSuccess()) {
                // Success stuff here if required?
	}
	else {
                // Bug out.
		$errors = $resp->getErrorCodes();
		echo "Invalid Form";
		exit;
	}
}