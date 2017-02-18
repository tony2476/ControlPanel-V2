<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class is an interface to the Saleforce library.  
 * 
 * There are 3 layers to the Saleforce code in this application.
 * 
 * 1.  The Salesforce provided API Code.
 * 2.  Our Salesforce libary which connects to the Salesforce API
 * 3.  Our Salesforce Model which provides the functionality that we need.
 * 
 * We should never call either the API or Library directly,  but add functionality 
 * centrally to this model codebase.
 * 
 * The return values are always the return value or FALSE except where there are no return value.
 * In which case TRUE or FALSE is returned.
 * 
 * In the case of an error,  the error messages are stored in $this->errors[] array.
 * They can be retrieved using $this->geterrors();  Obviously replace $this with the name of the instantiated class.
 * For example if you do a $sf = new Salesforce_model;
 * Use $sf->geterrors();
 *
 * 
 * @author Karl Gray
 * @copyright  2016 Advisornet / Tony Richardson
 * @package    Advisornet Control Panel
 */

class Salesforce_model extends CI_Model 
{
	private $errors = array();
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('salesforce_library');
	}


	/**
	 * Gets a list of accounts and formats them for a drop down box.
	 * @return array
	 */
	public function get_all_account_id()
	{
		$response = $this->salesforce_library->query("
			SELECT Id, Company_Name__c, Name
			FROM Account
			ORDER BY Name ASC
			");
		$queryResult = new QueryResult($response);
		// If no results present return false, fail early.
		if ($queryResult->size == 0)
		{

			return(FALSE);
		}
		$results = array();
		for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {
			$record = $queryResult->current();
		    // Id is on the $record, but other fields are accessed via
		    // the fields object
			$results[$record->Id] = $record->fields->Name;
		}
		return ($results);
	}

	public function get_all_company_records($sf_account_id) 
	{
		
		$response = $this->salesforce_library->query("
			SELECT 
			Drupal_Site_Status__c, 
			Name, 
			Domain_Name__c, 
			Website, 
			Company_Name__c,
			BillingCity,
			BillingState,
			BillingStreet,
			BillingPostalCode,
			Phone,
			AccountStatus__c,
			Web_Package__c,
			Website_Live_Date__c,
			Development_Site__c,
			Theme_Name__c,
			Theme_Color__c,
			Client_Website_Access__c,
			Domain_Expiry__c,
			AdvisorNet_DNS__c,
			Photo_Provided__c,
			Profile_Provided__c,
			Dealership__c,
			Branding__c,
			Secure_Forms_Email__c,
			E_News_From_Address__c,
			Business_Logo__c,
			Footer_Disclaimer__c,
			Web_Disclaimer__c,
			Web_Privacy__c,
			CASL_Consent__c,
			E_News_Template__c,
			Quarterly_E_Newsletter__c,
			E_Newsletter_Disclaimer__c,
			Drupal_Domain_ID__c,
			E_News_Custom_Comments_Title__c,
			E_News_Custom_Comments__c


			FROM Account
			WHERE Id = '$sf_account_id'
			");

			#e_Card_Data__c,   ->In Contact not Account
			#Drupal_E_news_Current__c, 
			#E_News_Sample__c,
			#
		$queryResult = new QueryResult($response);
		// If no results present return false, fail early.
		if ($queryResult->size == 0)
		{
			echo "No results";
			return(FALSE);
		}
		
		for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {
			$record = $queryResult->current();
			$account = $record->Id;
			$results = new stdClass;
			$results = $record->fields;
		}
		return ($results);
	}

}