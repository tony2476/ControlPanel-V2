<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends Private_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		// Load the Beanstream module
		$this->load->model('beanstream/beanstream_model');
		$this->beanstream = New Beanstream_model;
	}

	public function index()
	{
	}

	public function card_profile()
	{

		if ($this->form_validation->run('card_profile') == TRUE)
		{
			extract($this->input->post());
			$this->beanstream->set_profile_address($cardname, $email, $phone, $address, $city, $province, $postal_code, 'CA');
			if (!$result = $this->beanstream->update_profile($this->user->beanstream_id))
			{
				$this->session->set_flashdata('message', "We were not able to save your new card profile data at this time.");
				redirect('/', 'refresh');
			}
		}

		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);

		if ($this->user->beanstream_id)
		{
			$profile = $this->beanstream->get_profile($this->user->beanstream_id);	
			$form['cardname'] = $profile['billing']['name'];
			$form['address'] = $profile['billing']['address_line1'];
			$form['city'] = $profile['billing']['city'];
			$form['province'] = $profile['billing']['province'];
			$form['postal_code'] = $profile['billing']['postal_code'];
			$form['address'] = $profile['billing']['address_line1'];
			$form['phone'] = $profile['billing']['phone_number'];
			$form['email'] = $profile['billing']['email_address'];
		}

		$dropdown = array(
			''         => '-- Please select your province --',
			'AB'		=>	'Alberta',
			'BC'		=>	'British Columbia',
			'MT'		=>	'Manitoba',
			'NB'		=>	'New Brunswick',
			'NL'		=>	'Newfoundland and Labrador',
			'NT'		=>	'Northwest Territories',
			'NS'		=>	'Nova Scotia',
			'NV'		=>	'Nunavut',
			'ON'		=>	'Ontario',
			'PE'		=>	'Prince Edward Island',
			'QB'		=>	'Quebec',
			'SK'		=>	'Saskatchewan',
			'YT'		=>	'Yukon Territory',
			);
		
		$attributes = 'class="form-control" autofocus required';
		$form['province_dropdown'] = form_dropdown('province', $dropdown, $form['province'], $attributes);

		$form = $form + $profile['billing'];

		$this->template->set_title("Card Address.");
		$page_data = $this->parser->parse('billing/card_profile', $form, TRUE);
		if (validation_errors())
		{
			$this->session->set_flashdata('message', validation_errors());
		}
		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}

	public function my_card()
	{
		if ($this->form_validation->run('card_data') == TRUE)
		{
			extract($this->input->post());
			
			//Get card expiry
			$bang = explode("/", $cardExpiry);
			$expiry_month = $bang[0];
			$expiry_year = $bang[1];

			$this->beanstream->set_card_details($cardname, $cardNumber, $expiry_month, $expiry_year, $cardCVC);
			if (!$result = $this->beanstream->add_card_to_profile($profile_id))
			{
				$this->session->set_flashdata('message', "We were not able to save your new card details at this time.");
				redirect('/', 'refresh');
			}
		}

		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);



		$this->template->set_title("Your Card.");
		$page_data = $this->parser->parse('billing/card_data', $form, TRUE);
		if (validation_errors())
		{
			$this->session->set_flashdata('message', validation_errors());
		}
		$this->template->set_page_data($page_data);
		$this->template->display_page();

	}

}