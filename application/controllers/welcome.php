<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('user_model'));
		$this->load->helper(array('url'));
		$this->load->library(array('feisbus'));
	}
	
	private function _access()
	{
		// Checks if the user is logged in Facebook
		if ($this->feisbus->get_user_id())
		{
			// If the user is not registered is inserted in the DB
			if ( ! $this->user_model->is_user_registered($this->feisbus->get_user_id()))
			{
				$user_data = get_user_register_info($this->feisbus);
							
				if ($user_data != NULL)
				{
					$user_id = $this->user_model->insert_user($user_data['first_name'], 
															  $user_data['last_name'],
															  $this->feisbus->get_user_id(), 
															  $user_data['username']);
															  
					header('location: ' . $this->config->item('base_url') . 'dashboard');
				}
			}
		}
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$data ['title'] = 'live bidr';
		$data ['description'] = '';
		
		$this->load->view('templates/head', $data);
		
		$this->_access();
		
		$this->load->view('templates/header');
		$this->load->view('welcome_message_view.php');
		$this->load->view('templates/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */