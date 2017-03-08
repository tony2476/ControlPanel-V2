<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class handles communication with your plesk server.
 *
 * By default permissions should be denied.
 * 
 * TODO:  Please add error message before each return (FALSE)
 * 
 *  @author Karl Gray
 *  @copyright  2016 Advisornet / Tony Richardson / Karl Gray
 */

class Plesk_model extends CI_Model 
{
	/**
	 * @var string  Default table name,  It can be modified using constructor call.
	 */
	private 	$dbtable = 'plesk';
	private 	$secret_key;
	private 	$host;
	private 	$port = '8443';
	private 	$protocol = 'https';
	private 	$login;
	private 	$password;
	public  	$xml; # CHANGE THIS TO PRIVATE AFTER MODULE COMPLETED.
	public  	$data;
	public 		$mailbox;
	public 		$forwarding;
	public 		$alias;
	public 		$autoresponder;
	public 		$webspace_id;
	public 		$error;
	
	public function __construct()
	{
		parent::__construct();

		$plesk_config = $this->load->config('plesk/config', TRUE);
		
		// Store each config item in private vars for later use.
		foreach($plesk_config as $key => $value){
			$this->$key = $value;
		}

	}

	/*
	 * This is the start of the shared functions.
	 */
	
	public function get_username_from_email($email) 
	{
		$bang = explode ('@',$email);
		return ($bang[0]);
	}

	public function get_domain_from_email($email)
	{
		$bang = explode ('@',$email);
		return ($bang[1]);
	}

	public function parse_response($response)
	{
		$this->xml = simplexml_load_string($response);

		// get xml loading errors, log them and return FALSE.  		 
		if ($this->xml === false) {
			foreach(libxml_get_errors() as $error) {
				log_message ('error', $error->message);
				return (FALSE);
			}
		} 
		if ($this->xml->system->status == 'error') {
			echo "<pre>";
			echo "XML Error <br />";
			print_r ($this->xml->system);
			echo "</pre>";

		}
		
		// Get results only.
		$result=$this->xml->xpath('//result');
		$result=$result[0];

		// Did we get a good result?
		if ($result->status != 'ok') {
			$this->errcode = $result->errcode;
			$this->errtext = $result->errtext;
			return (FALSE);
		}

		// Return TRUE.
		return (TRUE);
	}

	
	/*
	 * SETTERS:-  only used if multiple Plesk servers needed in the future.
	 *
	 * The primary/Default plesk server is loaded from the config file.
	 */
	public function set_host ($host)
	{
		$this->host = $host;
	}

	public function set_key ($key)
	{
		$this->secret_key = $key;
	}

	public function set_port ($port)
	{
		$this->port = $port;
	}

	public function set_protocol ($protocol)
	{
		$this->protocol = $protocol;
	}

	public function set_webspace_id ($webspace_id)
	{
		$this->webspace_id = $webspace_id;
	}

	public function request($request)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "$this->protocol://$this->host:$this->port/enterprise/control/agent.php");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->_getHeaders());
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
		$result = curl_exec($curl);

		
		if($errno = curl_errno($curl)) {
			$error_message = curl_strerror($errno);
			$this->error = "Sorry,  I couldn't communicate with the plesk server,  Please try again.  If this continues please contact support";
			//$this->error .= "cURL error ({$errno}):\n {$error_message}";
			return (FALSE);
		}
		
		curl_close($curl);
		return $result;
	}

	/**
	 * Retrieve list of headers needed for request
	 *
	 * @return array
	 */
	private function _getHeaders()
	{
		$headers = array(
			"Content-Type: text/xml",
			"HTTP_PRETTY_PRINT: TRUE",
			);
		if ($this->secret_key) {
			$headers[] = "KEY: $this->secret_key";
		} else {
			$headers[] = "HTTP_AUTH_LOGIN: $this->login";
			$headers[] = "HTTP_AUTH_PASSWD: $this->password";
		}
		return $headers;
	}
}