<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('user_model'));
		$this->load->helper(array('url'));
		$this->load->library(array('feisbus'));
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$data ['title'] = 'live bidr';
		$data ['description'] = '';
		
		$this->load->view('templates/head', $data);
		$this->load->view('templates/header');
		$this->load->view('welcome_message_view.php');
		$this->load->view('templates/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */