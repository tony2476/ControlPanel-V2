<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class is an interface to the Saleforce API.  
 * 
 * There are 3 layers to the Saleforce code in this application.
 * 
 * 1.  The Salesforce provided API Code.
 * 2.  Our Salesforce libary which connects to the Salesforce API (This)
 * 3.  Our Salesforce Model which provides the functionality that we need.
 * 
 * We should not call either the API or Library directly,  but add functionality 
 * centrally to the model codebase.
 * 
 * @author Karl Gray
 * @copyright  2016 Advisornet / Tony Richardson
 * @package    Advisornet Control Panel
 *
 */

class Salesforce_library
{
	private $sforce_username = 'dev@advisornet.ca';
	private $sforce_password = 'z*B=u5vv7bqW37C';
	private $sforce_token = 'DlrdRKpEwAnhxE24FZIUZ1R80';
	private $sforce_type  = 'partner';
	private $sforce_sandbox  = false;
	private $conn;

	/**
	 * The constructor will load the config from /config/salesforce.php
	 * @param array $config 
	 * @return null
	 */

	public function __construct($config = array())
	{
		
		$wsdl  = APPPATH . 'third_party/salesforce/' . strtolower($this->sforce_type) . ($this->sforce_sandbox ? '.sandbox' : '') . '.wsdl.xml';

		// Define our class
		$class = 'Sforce' . ucfirst(strtolower($this->sforce_type)) . 'Client';
		
		// load our class
		require_once(APPPATH . 'third_party/salesforce/' . $class . '.php');
		
		// Create a new connection
		$this->conn = new $class();
		$this->conn->createConnection($wsdl);

		// And Login
		$result = $this->conn->login($this->sforce_username, $this->sforce_password . $this->sforce_token);
	}
	
	/**
	 * This is a bit complicated.  We are not defining our methods in this file.  The __call method is one of php's magic methods.
	 * It allows us to call a function in the provided salesforce library.
	 * 
	 * @param type $method 
	 * @param type $args 
	 * @return type
	 */ 
	public function __call($method, $args)
	{
		return call_user_func_array(array($this->conn, $method), $args);
	}
}