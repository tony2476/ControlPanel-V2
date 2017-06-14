<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Diagnostics extends Public_Controller {

	
	public function test_api()
	{


		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, 'http://cp2.local/api/recaptcha/domain/ondaedge.ca');
		curl_setopt($curl_handle, CURLOPT_USERPWD, 'admin' . ':' . '1234');
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		$buffer = curl_exec($curl_handle);
		$result = json_decode($buffer);
		curl_close($curl_handle);

		
		echo "<pre>";
		echo "result <br />";
		print_r ($result);
		echo "</pre>";
		
		

		
	}

	public function sf_cache()
	{

		$this->template->set_title("SF Cache data");

		$page_data = "<pre>SF Cache <br />" . print_r($this->session->userdata('sf_cache') , TRUE) . "<br />";
		
		

		$this->template->set_page_data($page_data);
		$this->template->display_page();
		
	}

	public function ion_auth()
	{
		$user = $this->ion_auth->user()->row();
		$this->template->set_title("Ion Auth Data");

		$page_data = "<pre>Ion Auth <br />" . print_r($user , TRUE) . "<br />";
		
		

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function reload_sf_cache()
	{

		$this->template->set_title("Reload SF Cache data");
		$this->load->model('salesforce/salesforce_model');
		$this->salesforce = New Salesforce_model;
		$this->user = $this->ion_auth->user()->row();
		$sf_contact_id = $this->user->sf_contact_id;
		$this->salesforce->populate_cache($sf_contact_id);

		$page_data = "<pre>SF Cache <br />" . print_r($this->session->userdata('sf_cache') , TRUE) . "<br />";
		
		

		$this->template->set_page_data($page_data);
		$this->template->display_page();
		
	}

	public function php_info()
	{
		echo phpinfo();
	}

	// This gets the order from session.
	public function display_order()
	{
		$order_data = $this->session->userdata('order_data');
		echo "<pre>";
		echo "order data <br />";
		print_r ($order_data);
		echo "</pre>";

		$card_data = $this->session->userdata('card_data');
		echo "<pre>";
		echo "card data <br />";
		print_r ($card_data);
		echo "</pre>";
	}

	public function decode_json()
	{
		$order_id = 4;

		$this->db->where('id', $order_id);
		$query = $this->db->get('orders');
		$row = $query->row();
		$order_data = json_decode($row->order_data, TRUE);
		

		
		unset($order_data['form_open']);
		unset($order_data['form_close']);

		$output = '';
		foreach ($order_data as $key => $value)
		{
			if (is_array($value))
			{
				$output.= $key . "\n";
				foreach ($value as $subkey => $subvalue)
				{
					$output .= "\t$subkey: $subvalue\n";
				}
				
			}
			else
			{
				$output .= "$key: $value\n";
			}
		}
		echo "<pre>";
		
		print_r ($output);
		echo "</pre>";
	}


	public function test_email()
	{

		echo "testing email";
		$this->load->library('email');
		
		$this->email->initialize();

		$this->email->from('karl@gray.me.uk');
		$this->email->to('karl@gray.me.uk');
		
		$this->email->subject("test");
		$this->email->message("test body");

		if ($this->email->send(FALSE))
		{
			echo "OK";
		}
		else
		{
			echo "NOT SENT";
			$this->email->print_debugger();
		}
	}


}

