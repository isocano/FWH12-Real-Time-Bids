<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auction extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('user_model', 'auction_model'));
		$this->load->helper(array('url'));
		$this->load->library(array(''));
	}
	
	public function push ($msg)
	{
		require('/var/www/html/application/libraries/Pusher/lib/Pusher.php');

		$key = '131de32e0bed65790199';
		$secret = '69d5b8a4d4f0696b3c7a';
		$app_id = '27903';
	
		$pusher = new Pusher($key, $secret, $app_id);
		$pusher->trigger('my-channel', 'my-event', array('message' => "$msg") );
	}
	
	public function add ()
	{
		$data ['title'] = 'live bidr | Auction';
		$data ['description'] = '';
		
		$this->load->view('templates/head', $data);
		$this->load->view('templates/header');
		$this->load->view('add_auction_view.php');
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