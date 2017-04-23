<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  This class handles functionality related to logged in users.  
 *  It cannot access any other system or modules except for ion_auth
 *  ion_auth is a requirement.
 */

class Dev extends Admin_Controller {

	private $result;

	function __construct()
	{
		parent::__construct();
		$this->load->model('dev/dev_model');
		$this->dev = New Dev_model;

		$this->config->load('dev/form_validation');
		$this->config->load('dev/config');
		$this->cert_path = $this->config->item('cert_path');
		$this->uploads_path = $this->config->item('uploads_path');

	}

	public function test()
	{
		$this->dev->delete_vhost(1);
	}

	public function status()
	{
		$vhost_id = $this->uri->segment(3);
		if (!$username = $this->dev->get_vhost_by_id($vhost_id))
		{
			$this->session->set_flashdata('message',"We couldn't get the hostname for vhost with id $vhost_id.");
			redirect('/dev/', 'refresh');
		}
		$hostname = $username . ".dpsys.ca";
		$status = ($this->dev->get_vhost_status_by_id($vhost_id) == "enabled" ?  TRUE : FALSE );
		if ($status)
		{
			$this->vhost_suspend($hostname);
			$this->session->set_flashdata('message', "Vhost with ID $vhost_id was suspended");
			redirect('/dev/', 'refresh');
		}
		else
		{
			$this->vhost_enable($hostname);
			$this->session->set_flashdata('message', "Vhost with ID $vhost_id was activated.");
			redirect('/dev/', 'refresh');
		}


	}

	public function index()
	{

		$dev_list = array(
			'list' => $this->dev->list_all_dev_hosts(),
			'form_open' => form_open('/dev/vhost_create', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);

		$this->template->set_title("Development vhosts");
		$this->template->disable_help();
		$page_data = $this->parser->parse('dev/dev_hosts_list_view', $dev_list	, TRUE);

		$this->template->set_page_data($page_data);
		$this->template->display_page();
	}
	
	public function vhost_create()
	{
		if ($this->form_validation->run('vhost_user') == TRUE)
		{
			
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			$this->create_setup_file($username, $password);
			$this->create_fpm_file($username);
			$this->create_nginx_file($username);

			$this->dev->add_database($username, $password);
			
		}

		if (validation_errors())
		{
			$this->session->set_flashdata('message', validation_errors());
		}
		
		redirect('/dev/','refresh');
	}

	private function create_setup_file($username, $password)
	{
		$hostname = $username . ".dpsys.ca";

		$setup_file = file_get_contents(APPPATH . 'modules/dev/config/setup_script_template.sh');
		
		$setup_file = str_replace('#hostname#', $hostname, $setup_file);
		$setup_file = str_replace('#username#', $username, $setup_file);
		$setup_file = str_replace('#password#', $password, $setup_file);

		$filename = $hostname . '.setup.sh';
		file_put_contents('/tmp/' . $filename, $setup_file);

		$cmd = 'scp -o StrictHostKeyChecking=no -i ' . $this->cert_path  . ' /tmp/' . $filename . ' root@dpsys.ca:/root/scripts/';
		exec($cmd, $result, $code);
		
		$cmd = "chmod u+x /root/scripts/$filename";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed to chmod script<br />";
			echo $cmd;
			exit;
		}

		$cmd = "/root/scripts/$filename";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed to execute setup script<br />";
			echo $cmd;
			exit;
		}
	}
	
	private function create_fpm_file($username)
	{
		// /etc/php5/fpm/pool.d/username.dpsys.ca.conf
		
		$setup_file = file_get_contents(APPPATH . 'modules/dev/config/fpm_setup_template.tmpl');
		
		$setup_file = str_replace('#username#', $username, $setup_file);
		
		$filename = $username . '.dpsys.ca.conf';
		file_put_contents('/tmp/' . $filename, $setup_file);

		$cmd = 'scp -o StrictHostKeyChecking=no -i ' . $this->cert_path  . ' /tmp/' . $filename . ' root@dpsys.ca:/etc/php5/fpm/pool.d/';
		exec($cmd, $result);

		$cmd = "service php5-fpm restart";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed to restart php5-fpm<br />";
			echo $cmd;
			exit;
		}
	}

	private function create_nginx_file($username)
	{
		// /etc/nginx/sites-available/username.dpsys.ca.conf
		
		$setup_file = file_get_contents(APPPATH . 'modules/dev/config/nginx_setup_template.tmpl');
		
		$setup_file = str_replace('#username#', $username, $setup_file);
		
		$filename = $username . '.dpsys.ca.conf';
		file_put_contents('/tmp/' . $filename, $setup_file);

		$cmd = 'scp -o StrictHostKeyChecking=no -i ' . $this->cert_path  . ' /tmp/' . $filename . ' root@dpsys.ca:/etc/nginx/sites-available/';
		exec($cmd, $result);

		$cmd = "ln -s /etc/nginx/sites-available/$username.dpsys.ca.conf /etc/nginx/sites-enabled/$username.dpsys.ca.conf";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed to link sites-available file to sites-enabled file for nginx<br />";
			echo $cmd;
			exit;
		}

		$cmd = "service nginx restart";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed to restart nginx<br />";
			echo $cmd;
			exit;
		}
	}
	
	public function vhost_delete()
	{
		$id = $this->uri->segment(3);

		$username = $this->dev->get_vhost_by_id($id);
		$hostname = $username . ".dpsys.ca";

		$cmd = "rm /etc/nginx/sites-available/$hostname.conf";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "rm -fr /etc/php5/fpm/pool.d/$hostname.conf";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "rm -fr /var/www/vhosts/$hostname";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "service nginx restart";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "service php5-fpm restart";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "userdel $username";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$this->dev->delete_vhost($id);

		$this->session->set_flashdata('message', "Vhost with username $username was delete");
			redirect('/dev/', 'refresh');
	}

	public function vhost_suspend($hostname)
	{

		$cmd = "rm -f /etc/nginx/sites-enabled/$hostname.conf";
		
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "mv /etc/php5/fpm/pool.d/$hostname.conf /etc/php5/fpm/pool.d/$hostname.orig";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "service nginx restart";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "service php5-fpm restart";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}
		$id = $this->dev->get_vhost_id_by_hostname($hostname);
		$this->dev->set_vhost_status($id, 'suspended');
	}

	public function vhost_enable($hostname)
	{

		$cmd = "ln -s /etc/nginx/sites-available/$hostname.conf /etc/nginx/sites-enabled/$hostname.conf";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "mv /etc/php5/fpm/pool.d/$hostname.orig /etc/php5/fpm/pool.d/$hostname.conf";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "service nginx restart";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}

		$cmd = "service php5-fpm restart";
		if (!$this->send_command($cmd, $this->cert_path))
		{
			echo "Failed <br />";
			echo $cmd;
			exit;
		}
		$id = $this->dev->get_vhost_id_by_hostname($hostname);
		$this->dev->set_vhost_status($id, 'enabled');

	}

	private function send_command($command, $cert)
	{
		unset ($this->result);
		$this->result = array();
		exec ("ssh -o StrictHostKeyChecking=no -i " . $cert  . " root@dpsys.ca " . $command, $this->result, $code);
		foreach ($this->result as $result)
		{
			log_message ("info", "SSH Command Response:  " . $result);
		}

		if ($code == '0'){
			return (TRUE);
		}
		return (FALSE);

	}
}