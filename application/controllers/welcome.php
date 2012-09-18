<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('user_model'));
		$this->load->helper(array('url', 'feisbus'));
		$this->load->library(array('feisbus'));
	}
	
	private function _create_session_variables ($user_id, $fb_id, $fb_username)
	{
		$this->session->set_userdata('user_id', $user_id);
		$this->session->set_userdata('fb_id', $fb_id);
		$this->session->set_userdata('fb_username', $fb_username);
	}
	
	private function _access()
	{
		$user_data = NULL;
		
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
															  
					// Create the folder to the user images for products
					mkdir($this->config->item('upload_user_photo') . $user_id, 0777);
					mkdir($this->config->item('upload_user_photo') . $user_id . '/tmp', 0777);
					mkdir($this->config->item('upload_user_photo') . $user_id . '/tmp/thumbnails', 0777);
															  
					$this->_create_session_variables($user_id, $this->feisbus->get_user_id(), $user_data['username']);
				}
			}
			else 
			{
				$user_data = $this->user_model->get_user($this->feisbus->get_user_id());
				$this->_create_session_variables($user_data->ID, $this->feisbus->get_user_id(), $user_data->FB_USERNAME);
			}
			
			header('location: ' . $this->config->item('base_url') . 'dashboard/' . $user_data->FB_USERNAME);
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
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */