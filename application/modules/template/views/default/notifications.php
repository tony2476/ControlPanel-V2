<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


		<?php
		if ($this->session->flashdata('message')) 
		{
			$message = array 
			(
				'message' => $this->session->flashdata('message'),
				);
			$this->parser->parse('messages/flash_message', $message);
			
		}
		elseif ($this->session->flashdata('error')) 
		{
			$message = array 
			(
				'message' => $this->session->flashdata('error'),
				);
			$this->parser->parse('messages/flash_error', $message);

		}
		?>
