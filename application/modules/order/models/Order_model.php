<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model 
{

	public function __construct()
	{
		parent::__construct();
		$this->config->load('order/config');
		$this->mail_settings = $this->config->item('mail_settings');
		// configure mail model
		$this->load->model('mail/mail_model');
		$this->mail = New Mail_model;

		$this->load->config('order/constants');
		$this->order_status_codes = $this->config->item('order_status_codes');

	}

	public function save_order($data)
	{
		unset($data['form_open']);
		unset($data['form_close']);
		$this->db->insert('orders', $data);
		$id = $this->db->insert_id();

		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "Sorry, We failed to save the order.";
			return (FALSE);
		}
		return ($id);
	}

	public function mark_paid($order_id)
	{
		$data = array
		(
			// status 2 = paid
			'status' => '2',
			);
		$this->db->where('id', $order_id);
		$this->db->update('orders', $data);
		if ($this->db->affected_rows() == 0) 
		{
			$this->error = "We failed to mark order as paid";
			return (FALSE);
		}
		return (TRUE);
	}

	public function mail_order_details_unformated($order_id)
	{

		$this->db->where('id', $order_id);
		$query = $this->db->get('orders');
		$row = $query->row();
		$order_data = json_decode($row->order_data, TRUE);

		unset($order_data['form_open']);
		unset($order_data['form_close']);		
		
		$body = '';
		foreach ($order_data as $key => $value)
		{
			if (is_array($value))
			{
				$body.= $key . "\n";
				foreach ($value as $subkey => $subvalue)
				{
					$body .= "\t$subkey: $subvalue\n";
				}

			}
			else 
			{
				$body .= "$key: $value\n";
			}
		}
		// Send the email.
		$this->mail->send_email($this->mail_settings['to'] , $this->mail_settings['from'], $this->mail_settings['admin_order_notification_email_subject'], $body);
	}

	public function payment_failed($order_id, $message)
	{
		$body = "A client tried to order but their payment failed.  Their order ID was $order_id\n
		The error was: \n
		$message";
		$this->mail->send_email($this->mail_settings['to'] , $this->mail_settings['from'], "Payment Failed", $body);
	}

	public function payment_succeeded($order_id, $payment_id)
	{
		$payment_details = print_r($payment_id, TRUE);
		$body = "A client has paid for their order.  Their order ID was $order_id\n

		Payment Details: $payment_details
		";
		
		$this->mail->send_email($this->mail_settings['to'] , $this->mail_settings['from'], "Payment Suceeded", $body);
	}
}