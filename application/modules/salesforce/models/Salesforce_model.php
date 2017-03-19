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

	/**
	 * This is called when a user logs in.  It loads all relevent information in one shot from Salesforce and stores it in the session.
	 * This will speed up page loads on profiles etc.
	 * @return type
	 */
	public function populate_cache($sf_contact_id) 
	{
		$response = $this->salesforce_library->query("
			SELECT 
			AccountId, 
			Id,
			Salutation,
			Name,
			MailingStreet,
			MailingCity,
			MailingState,
			MailingPostalCode,
			MailingCountry,
			MobilePhone,
			FirstName,
			LastName,
			Email,
			Phone,
			e_Card_Data__c,
			Drupal_E_news_Current__c, 
			E_News_Sample__c,
			Email_User__c,
			Account.Drupal_Site_Status__c,
			Account.Name, 
			Account.Domain_Name__c, 
			Account.Website, 
			Account.Company_Name__c,
			Account.BillingCity,
			Account.BillingState,
			Account.BillingStreet,
			Account.BillingPostalCode,
			Account.Phone,
			Account.AccountStatus__c,
			Account.Web_Package__c,
			Account.Website_Live_Date__c,
			Account.Development_Site__c,
			Account.Theme_Name__c,
			Account.Theme_Color__c,
			Account.Client_Website_Access__c,
			Account.Domain_Registrar__c,
			Account.Domain_Expiry__c,
			Account.AdvisorNet_DNS__c,
			Account.Photo_Provided__c,
			Account.Profile_Provided__c,
			Account.Dealership__c,
			Account.Branding__c,
			Account.Secure_Forms_Email__c,
			Account.E_News_From_Address__c,
			Account.Business_Logo__c,
			Account.Footer_Disclaimer__c,
			Account.Web_Disclaimer__c,
			Account.Web_Privacy__c,
			Account.CASL_Consent__c,
			Account.E_News_Template__c,
			Account.Quarterly_E_Newsletter__c,
			Account.E_Newsletter_Disclaimer__c,
			Account.Drupal_Domain_ID__c,
			Account.E_News_Custom_Comments_Title__c,
			Account.E_News_Custom_Comments__c,
			Account.Email_Server__c
			FROM 
			Contact
			WHERE Id = '$sf_contact_id'
			
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
			$results[$record->Id] = $record->fields;
		}

		//Using double cast to get rid of SObject which caused __PHP_Incomplete_Class errors.
		$record->fields->Account->fields = (object)(array) $record->fields->Account->fields;
		$record->fields->Account = (object)(array) $record->fields->Account;

		//return ($results);
		$sf_account_data = $record->fields->Account->fields;
		unset ($record->fields->Account);

		$this->session->set_userdata('sf_contact_cache', (object)(array) $record->fields);
		$this->session->set_userdata('sf_account_cache', (object)(array) $sf_account_data);
	}

	/* CASE HANDLING */


	/**
	 * This function gets all the parts of a case, formats the data and returns a complex structure containing all the data.
	 * @param type $sf_case_id 
	 * @return type
	 */
	public function get_case_by_case_id($sf_case_id, $sf_contact_id, $fullname)
	{
		if ($sf_case_id == '') {
			return FALSE;
		}
		$results = new stdClass;
		$results->header = $this->get_case_header_by_case_id($sf_case_id);
		$results->responses = $this->get_case_comments_by_case_id($sf_case_id);

		$key = key($results->header);
		$results->header[0]['CreatedDate'] = $this->convert_date($results->header[0]['CreatedDate']);

		foreach ($results->responses as &$response)
		{
			$response->CreatedDate = $this->convert_date($response->CreatedDate);
			if (substr( $response->CommentBody, 0, 3 ) === "==:")
			{
				$created_by_string = explode(":", strtok($response->CommentBody, "\n"));
				if ($created_by_string[1] == $sf_contact_id) {
					$created_by_string = $fullname;
				}
				else
				{
					$created_by_string = "Advisornet";
				}
				$response->CreatedById = $created_by_string;
				$response->CommentBody = preg_replace('/^.+\n/', '', $response->CommentBody);
			}
		}
		return $results;
	}

	public function get_case_header_by_case_id($sf_case_parent_id)
	{
		$response = $this->salesforce_library->query("
			SELECT CaseNumber, Description, Subject, CreatedDate, Status 
			FROM Case 
			WHERE Id = '$sf_case_parent_id'
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
			$this_id = $record->Id;
			foreach ($record->fields as $fieldname => $value)
			{
				$results[$this_id][$fieldname] = $value;
			}
		}
		return ($results);
	}

	public function get_case_comments_by_case_id($sf_case_parent_id)
	{

		$response = $this->salesforce_library->query("
			SELECT Id, CommentBody,CreatedDate, CreatedById, ParentId 
			FROM CaseComment 
			WHERE ParentId = '$sf_case_parent_id'
			ORDER BY CreatedDate DESC NULLS FIRST
			");


		$queryResult = new QueryResult($response);
		// If no results present return false, fail early.
		if ($queryResult->size == 0)
		{
			echo "Nothing found";
			return(FALSE);
		}
		$results = new stdClass;



		for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {
			$record = $queryResult->current();
		    // Id is on the $record, but other fields are accessed via
		    // the fields object
			$this_id = $record->Id;
			#echo "Processing $this_id";
			$results->$this_id = new stdClass;

			$results->$this_id->Id = $record->Id;
			foreach ($record->fields as $fieldname => $value)
			{
				$results->$this_id->$fieldname = $value;
			}
		}
		return ($results);
	}

	public function create_case ($sf_contact_id, $subject, $comment, $name)
	{
		if ($sf_contact_id == '' || $subject == '' || $comment == '') {
			return FALSE;
		}

		$records[0] = new SObject();
		$records[0]->fields = new stdClass;
		$records[0]->fields->Subject = $subject;
		$records[0]->fields->Description = $comment;
		$records[0]->fields->ContactId = $sf_contact_id;
		$records[0]->type = 'Case';

		$response = $this->salesforce_library->create($records);

		if (!$response[0]->success='1') 
		{
			log_message ('info', "Create SF Case Failed.");
			$this->session->set_flashdata('error', "Create SF Case Failed.");
			return (FALSE);
		}
		return ($response[0]->id);
	}

	public function add_case_comment($sf_case_parent_id,$sf_case_comment)
	{
		$records[0] = new SObject();
		$records[0]->fields->CommentBody = $sf_case_comment;
		$records[0]->fields->IsPublished = TRUE;
		$records[0]->fields->ParentId = $sf_case_parent_id;
		$records[0]->type = 'CaseComment';

		$response = $this->salesforce_library->create($records);

		if (!$response[0]->success='1') 
		{
			log_message ('info', "Create SF Case Comment Failed.");
			$this->session->set_flashdata('error', "Create SF Case Comment Failed.");
			return (FALSE);
		}

		return ($response[0]->id);
	}

	private function convert_date($date)
	{
		return (date('m/d/Y - H:i:s', strtotime($date)));
	}

	public function get_case_list_by_contact_id($sf_contact_id)
	{
		$response = $this->salesforce_library->query("
			SELECT Id, CaseNumber,CreatedDate,Subject,Status 
			FROM case 
			WHERE ContactId = '$sf_contact_id' 
			");
		$queryResult = new QueryResult($response);
		// If no results present return false, fail early.
		if ($queryResult->size == 0)
		{
			return(FALSE);
		}
		$results = new stdClass;
		for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {
			$record = $queryResult->current();
		    // Id is on the $record, but other fields are accessed via
		    // the fields object
			$this_id = $record->Id;
			$results->$this_id = new stdClass;
			$results->$this_id->Id = $record->Id;
			foreach ($record->fields as $fieldname => $value)
			{

				$results->$this_id->$fieldname = $value;
			}
		}
		return ($results);
	}


	/**
 	* ======== ROUTINES USED FOR IMPORTING - DO NOT USE IN PRODUCTION. ========
 	*/

	public function is_plesk_enabled($email)
	{
		$response = $this->salesforce_library->query("
			SELECT 
			Email,
			Id 
			FROM 
			Contact 
			WHERE 
			Email_User__c = true
			AND
			Email = '$email'
			");

		$queryResult = new QueryResult($response);
		// If no results present return false, fail early.
		if ($queryResult->size == 0)
		{

			return FALSE;
		}
		return TRUE;
	}


	public function importer_get_plesk_enabled()
	{
		$response = $this->salesforce_library->query("
			SELECT 
			Email,
			Id 
			FROM 
			Contact 
			WHERE 
			Email_User__c = true
			AND
			Email != 'info@financialwisdom.ca'
			AND
			Email != 'pedro@advisornet.ca'
			AND
			Email != 'aegir@advisornet.ca'
			AND
			(Web_Agreement__c = 'Received' OR Web_Agreement__c = 'None')
			AND
			Account.AccountStatus__c != 'Prospecting' 
			AND
			Account.AccountStatus__c != 'Former Client'
			AND
			Account.AccountStatus__c != ''
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
			$results[$record->Id] = $record->fields;
		}
		return ($results);
	}

		/**
	 * Get the primary contact records required for import.
	 * @param type $sf_account_id 
	 * @return type
	 */
		public function importer_get_all_contact_records() 
		{

			$response = $this->salesforce_library->query("
				SELECT 
				FirstName,
				LastName,
				Id,
				AccountId,
				Email,
				Email_Password__c,
				Name,
				Website__c,
				Web_Agreement__c,
				Account.Company_Name__c,
				Account.Name, 
				Account.Domain_Name__c, 
				Account.Website
				FROM 
				Contact
				WHERE
				Email != 'info@financialwisdom.ca'
				AND
				Email != 'pedro@advisornet.ca'
				AND
				Email != 'aegir@advisornet.ca'
				AND
				(Web_Agreement__c = 'Received' OR Web_Agreement__c = 'None')
				AND
				Account.AccountStatus__c != 'Prospecting' 
				AND
				Account.AccountStatus__c != 'Former Client'

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
				$results[$record->Id] = $record->fields;
			}
			return ($results);
		}


		/**
	 * Get the primary contact records required for import.
	 * @param type $sf_account_id 
	 * @return type
	 */
		public function importer_get_contact_record($account_name) 
		{

			$response = $this->salesforce_library->query("
				SELECT 
				FirstName,
				LastName,
				Id,
				AccountId,
				Email,
				Email_Password__c,
				Name,
				Website__c,
				Web_Agreement__c,
				Account.Company_Name__c,
				Account.Name, 
				Account.Domain_Name__c, 
				Account.Website
				FROM 
				Contact
				WHERE
				Account.Name = '$account_name'
				AND
				Email != 'info@financialwisdom.ca'
				AND
				Email != 'pedro@advisornet.ca'
				AND
				Email != 'aegir@advisornet.ca'
				AND
				(Web_Agreement__c = 'Received' OR Web_Agreement__c = 'None')
				AND
				Account.AccountStatus__c != 'Prospecting' 
				AND
				Account.AccountStatus__c != 'Former Client'


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
				$results[$record->Id] = $record->fields;
			}
			return ($results);
		}

	}

