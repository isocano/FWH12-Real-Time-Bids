<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auction extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('user_model', 'auction_model'));
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
		$data ['title'] = 'live bidr | Auction';
		$data ['description'] = '';
		
		$this->load->view('templates/head', $data);
		$this->load->view('templates/header');
		$this->load->view('auction_view.php');
		$this->load->view('templates/footer');
	}
}

/* End of file auction.php */
/* Location: ./controllers/auction.php */