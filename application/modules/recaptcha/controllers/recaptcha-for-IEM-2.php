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


$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, 'http://cp2.advisornet.ca/api/recaptcha/domain/' . $domain);
curl_setopt($curl_handle, CURLOPT_USERPWD, 'admin' . ':' . '1234');
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
$buffer = curl_exec($curl_handle);
$result = json_decode($buffer);
$http_status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
curl_close($curl_handle);


extract($result);

$recaptcha_secret_key;
$recaptcha_site_key;


// Check with salesforce if this domain has ReCaptcha Enabled?

if ($http_status == '200')
{
	if ($recaptcha_secret_key == '')
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