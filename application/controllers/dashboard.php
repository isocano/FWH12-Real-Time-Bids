<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('', ''));
		$this->load->helper(array('url'));
		$this->load->library(array(''));
	}
	
	/**
	 * Index Page for Storefront controller.
	 *
	 * Redirect to the following URL
	 * 		http://www.saldum.com/user
	 *
	 */
	public function index() 
	{
		$data ['title'] = 'live bidr | Dashboard';
		$data ['description'] = '';
		
		$user_data = $this->user_model->get_user($this->config->item('fb_id'));
		
		$dash_data['first_name'] = $user_data->NAME;
		$dash_data['last_name'] = $user_data->LAST_NAME;
		$dash_data['username'] = $this->config->item('fb_username');
		
				
		$this->load->view('templates/head', $data);
		$this->load->view('templates/header');
		$this->load->view('dashboard_view.php', $dash_data);
	}
}

/* End of file dashboard.php */
/* Location: ./controllers/dashboard.php */