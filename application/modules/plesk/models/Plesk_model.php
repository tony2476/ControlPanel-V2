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

	public function delete_alias($site_id, $username, $alias)
	{
		$request = '
		<packet>
			<mail>
				<update>
					<remove>
						<filter>
							<site-id>' . $site_id . '</site-id>
							<mailname>
								<name>' . $username . '</name>
								<alias>' . $alias . '</alias>
							</mailname>
						</filter>
					</remove>
				</update>
			</mail>
		</packet>';
		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			return(TRUE);
		}
		return (FALSE);
	}

	public function add_alias($site_id, $username, $alias)
	{
		$request = '
		<packet>
			<mail>
				<update>
					<add>
						<filter>
							<site-id>' . $site_id . '</site-id>
							<mailname>
								<name>' . $username . '</name>
								<alias>' . $alias . '</alias>
							</mailname>
						</filter>
					</add>
				</update>
			</mail>
		</packet>';
		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			return(TRUE);
		}
		return (FALSE);
	}

	public function get_mailbox_id($username, $domain) 
	{
		$site_id = $this->get_site_id($domain);
		if (!$site_id) {
			return (FALSE);
		}

		$request = '
		<packet version="1.6.3.0">
			<mail>
				<get_info>
				<filter>
					<site-id>' . $site_id . '</site-id>
					<name>' . $username . '</name>
					
				</filter>
				</get_info>
			</mail>
		</packet>';
		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			return((string) $this->xml->mail->get_info->result->mailname->id)					;
		}
		return (FALSE);

	}
	public function get_mailbox_by_id ($site_id, $mailbox_id)
	{
		$request = '
		<packet>
			<mail>
				<get_info>
				<filter>
					<site-id>' . $site_id . '</site-id>
				</filter>
				<mailbox/>
				</get_info>
			</mail>
		</packet>';
		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			$mailboxes = $this->xml->mail->get_info;
			$boxlist = new stdClass;
			foreach ($mailboxes->result as $mailbox) {
				if ($mailbox->mailname->id == $mailbox_id)
				{
					$mailname = (string) $mailbox->mailname->name;
				}
			}
			return ($mailname);
			
		}
		return (FALSE);
	}

	public function get_mailboxes($site_id)
	{
		if ($site_id == '' || (!is_numeric($site_id)) )
		{
			log_message('error', "get_mailboxes called with $site_id which is not a positive integer.");
			return FALSE;
		}
		$request = '
		<packet>
			<mail>
				<get_info>
				<filter>
					<site-id>' . $site_id . '</site-id>
				</filter>
				<mailbox/>
				</get_info>
			</mail>
		</packet>';
		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		
		if ($this->parse_response($response))
		{
			$mailboxes = $this->xml->mail->get_info;
			$boxlist = new stdClass;
			foreach ($mailboxes->result as $mailbox) {
				$id = $mailbox->mailname->id;
				$boxlist->$id = new stdClass;
				$boxlist->$id->id = (string) $id;
				$boxlist->$id->name = (string) $mailbox->mailname->name;
				$boxlist->$id->status = (string) $mailbox->mailname->mailbox->enabled;
			}
			return ($boxlist);
			
		}
		return (FALSE);
	}
	/**
	 * Removes a single forwarding address.
	 * @param type $site_id 
	 * @param type $name 
	 * @param type $enabled 
	 * @param type $forward 
	 * @return type
	 */
	public function remove_forwarding ($site_id, $username, $delete_address)
	{
		if ($delete_address == '') {
			return (FALSE);
		}

		$request = '
		<packet>
			<mail>
				<update>
					<remove>
						<filter>
							<site-id>' . $site_id . '</site-id>
							<mailname>
								<name>' . $username . '</name>
								<forwarding>
									<address>' . $delete_address . '</address>
								</forwarding>
							</mailname>
						</filter>
					</remove>
				</update>
			</mail>
		</packet>';

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			// Returns True or FALSE,  no data returned.
			return (TRUE);
		}
		return (FALSE);
	}

	public function toggle_forwarding ($site_id, $username, $status)
	{
		if ($status !== 'true'  && $status !== 'false') 
		{
			return (FALSE);
		}

		#Get existing forwarding addresses;
		$request = '
		<packet>
			<mail>
				<get_info>
				<filter>
					<site-id>' . $site_id . '</site-id>
					<name>' . $username . '</name>
				</filter>
				<mailbox/>
				<forwarding/>
				<aliases/>
				<autoresponder/>
				</get_info>
			</mail>
		</packet>';

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			$this->forwarding = $this->xml->mail->get_info->result->mailname->forwarding;
		}
		$forwards=$this->forwarding->address;
		if (is_array($forwards)) {
			foreach ($forwards as $address) 
			{
				$addresses .= "<address>$address</address>\n";
			}
		} 
		else
		{
			$addresses = "<address>$forwards</address>";
		}

		$request = '
		<packet>
			<mail>
				<update>
					<add>
						<filter>
							<site-id>' . $site_id . '</site-id>
							<mailname>
								<name>' . $username . '</name>
								<forwarding>
									<enabled>' . $status . '</enabled>
									' . $addresses . '
								</forwarding>
							</mailname>
						</filter>
					</add>
				</update>
			</mail>
		</packet>';

		echo "<pre>";
		echo "forwarding <br />";
		print_r ($request);
		echo "</pre>";
		exit;

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			// Returns True or FALSE,  no data returned.
			return (TRUE);
		}
		return (FALSE);
	}

	public function add_forwarding ($site_id, $username, $add_address)
	{
		if ($add_address == '') {
			return (FALSE);
		};

		$request = '
		<packet>
			<mail>
				<update>
					<add>
						<filter>
							<site-id>' . $site_id . '</site-id>
							<mailname>
								<name>' . $username . '</name>
								<forwarding>
									<address>' . $add_address . '</address>
								</forwarding>
							</mailname>
						</filter>
					</add>
				</update>
			</mail>
		</packet>';

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			// Returns True or FALSE,  no data returned.
			return (TRUE);
		}
		return (FALSE);
	}

	public function update_forwarding ($site_id, $name ,$enabled, $forward)
	{
		$addresses = '';

		// Handle multiple forwarding addresses or just 1.
		if (is_array($forward)) {
			foreach ($forward as $address) 
			{
				$addresses .= "<address>$address</address>\n";
			}
		}
		$request = '
		<packet>
			<mail>
				<update>
					<set>
						<filter>
							<site-id>' . $site_id . '</site-id>
							<mailname>
								<name>' . $name . '</name>
								<forwarding>
									<enabled>' . $enabled . '</enabled>
									' . $addresses . '
								</forwarding>
							</mailname>
						</filter>
					</set>
				</update>
			</mail>
		</packet>';

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			// Returns True or FALSE,  no data returned.
			return (TRUE);
		}
		return (FALSE);
	}

	public function update_autoresponder ($site_id, $data)
	{
		//$name ,$enabled, $type = '', $subject, $text, $forward, $end_date
		$name = $data['username'];
		$text = $data['responder_text'];
		$subject = $data['responder_subject'];
		$end_date = $data['responder_end_date'];
		$forward = $data['responder_forward'];

		if (NULL !== $this->input->post('autoresponder_enabled')) {
			$enabled = 'true';
		}
		else
		{
			$enabled = 'false';
		}

		#if ($type == 'html') {
		$content_type = 'text/html';
		#}
		#else 
		#{
		$content_type = 'text/plain';
		#}
		
		
		$request = '
		<packet>
			<mail>
				<update>
					<set>
						<filter>
							<site-id>' . $site_id . '</site-id>
							<mailname>
								<name>' . $name . '</name>
								<autoresponder>
									<enabled>' . $enabled . '</enabled>
									<subject><![CDATA[' . $subject . ']]></subject>
									<content_type>' . $content_type . '</content_type>
									<text>' . $text . '</text>
									<forward>' . $forward . '</forward>
									<end_date>' . $end_date . '</end_date>
								</autoresponder>
							</mailname>
						</filter>
					</set>
				</update>
			</mail>
		</packet>';
		echo "<pre>";
		echo "request <br />";
		print_r (htmlentities($request));
		echo "</pre>";
		
		

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			// Returns True or FALSE,  no data returned.
			return (TRUE);
		}
		return (FALSE);
	}

	public function create_mail_account($site_id, $name, $password)
	{
		$request = '
		<packet>
			<mail>
				<create>
					<filter>
						<site-id>' . $site_id . '</site-id>
						<mailname>
							<name>' . $name . '</name>
							<mailbox>
								<enabled>true</enabled>
							</mailbox>
							<password>
								<value>' . $password . '</value>
								<type>plain</type>
							</password>
						</mailname>
					</filter>
				</create>
			</mail>
		</packet>';

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			$this->mailbox_id = $this->xml->mail->create->result->mailname->id;
			return (TRUE);
		}
		return (FALSE);
	}

	public function create_webspace($domain, $ip) 
	{
		$request = '
		<packet>
			<webspace>
				<add>
					<gen_setup>
					<name>' . $domain . '</name>
					<ip_address>' . $ip . '</ip_address>
					</gen_setup>
				</add>
			</webspace>
		</packet>';

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			$this->webspace_id = $this->xml->webspace->add->result->id;
			return (TRUE);
		}
		return (FALSE);
	}

	public function add_domain($domain, $webspace_id) 
	{
		$request = '
		<packet>
			<site>
				<add>
					<gen_setup>
					<name>' . $domain . '</name>
					<webspace-id>' . $webspace_id . '</webspace-id>
					</gen_setup>
				</add>
			</site>
		</packet> ';

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			$this->domain_id = $this->xml->site->add->result->id;
			return (TRUE);
		}
		return (FALSE);
	}

	public function get_autoresponder ($email) {
		return ($this->get_email_settings($email));
	}

	public function get_forwarding($email){
		return ($this->get_email_settings($email));	
	}

	public function get_email_settings($email)
	{
		$username = $this->get_username_from_email($email);
		$domain = $this->get_domain_from_email($email);

		if (!$site_id = $this->get_site_id($domain))
		{
			return (FALSE);
		}

		$request = '
		<packet>
			<mail>
				<get_info>
				<filter>
					<site-id>' . $site_id . '</site-id>
					<name>' . $username . '</name>
				</filter>
				<mailbox/>
				<forwarding/>
				<aliases/>
				<autoresponder/>
				</get_info>
			</mail>
		</packet>';

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			$this->data = $this->xml->mail->get_info->result->mailname;
			$this->mailbox = $this->xml->mail->get_info->result->mailname->mailbox;
			$this->forwarding = $this->xml->mail->get_info->result->mailname->forwarding;
			$this->alias = $this->xml->mail->get_info->result->mailname->alias;
			$this->autoresponder = $this->xml->mail->get_info->result->mailname->autoresponder;
			$this->format_data();
			return (TRUE);
		}
		return (FALSE);
	}

	private function format_data() {
		// Aliases
		$count = 0;
		$result = array();
		foreach ($this->alias as $alias)
		{
			$result[$count] = array('alias' => (string) $alias);
			$count++;
		}
		$this->alias = $result;

		// Do enabled checkboxes, convert true to checked and false to '';
		$this->forwarding = (object)(array) $this->forwarding;
		$this->autoresponder = (object)(array) $this->autoresponder;

		// Do enabled checkboxes, convert true to checked and false to '';
		// And set any unused fields so that parser can replace.
		if ($this->forwarding->enabled == 'true')
		{
			$this->forwarding->enabled = 'checked="enabled"';
		}
		else
		{
			$this->forwarding->enabled = '';
			$this->forwarding->address = '';	
		}

		if ($this->autoresponder->enabled == 'true')
		{
			$this->autoresponder->enabled = 'checked="enabled"';
		}
		else
		{
			$this->autoresponder->enabled = '';	
		}
		$this->autoresponder->enabled =  $this->autoresponder->enabled;
	}


	public function get_site_domain($site_id)
	{
		$request = '
		<packet>
			<site>
				<get>
					<filter>
						<id>' . $site_id .'</id>
					</filter>
					<dataset>
						<hosting/>
					</dataset>
				</get>
			</site>
		</packet>';

		if (!$response = $this->request($request))
		{
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			return ($this->xml->site->get->result->data->gen_info->name);
		}
		return (FALSE);
	}

	public function get_site_id($domain)
	{
		$request = '
		<packet>
			<site>
				<get>
					<filter>
						<name>' . $domain .'</name>
					</filter>
					<dataset>
						<hosting/>
					</dataset>
				</get>
			</site>
		</packet>';

		if (!$response = $this->request($request))
		{
			
			return(FALSE);
		}
		if ($this->parse_response($response))
		{
			return ($this->xml->site->get->result->id);
		}

		return (FALSE);
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