<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Storefront extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('user_model', 'product_model'));
		$this->load->helper(array('url'));
		$this->load->library(array('memcached_library'));
	}
	
	/**
	 * Return array with user info
	 *
	 * @access private
	 * @param object
	 */
	private function _get_user ($user)
	{
		$user_ubication = json_decode($user->UBICATION, TRUE);
		
		return array(
			'user_username'			=>	$user->USERNAME,
			'user_name'				=>	$user->NAME,
			'user_surname'			=> 	$user->SURNAME,
			'user_ubication'		=>	$user_ubication['city'],
			'user_products_bought'	=>  $user->PRODUCTS_BOUGHT,
			'user_products_sold'	=>	$user->PRODUCTS_SOLD,
			'user_score'			=>  $user->SCORE
		);
	}
	
	/**
	 * Index Page for Storefront controller.
	 *
	 * Maps to the following URL
	 * 		http://www.saldum.com/user
	 *
	 * @access	public
	 * @param	string
	 */
	public function view ($username) 
	{
		// Check param
		if ($username == "") 
			header('location: ' . $this->config->item('base_url') . $this->session->userdata('user_name'));

		// Lets try to get the key in memcached
		$data_user = $this->memcached_library->get($username);
		
		if (! $data_user) // User is not in memcached
		{
			// Load data user from db
			$data_user = $this->user_model->get_user($username);
			
			// If user exist load storefront with user data
			if ($data_user != NULL) 
			{
				// Load user data
				$data_storefront = $this->_get_user($data_user);
				
				// Lets store the results
				$this->memcached_library->add($username, $data_user);
			}  
			else 
			{ // User not exist
				header('location: ' . base_url() . 'user404');
			}
		}
		else // User in memcached
		{
			// Parse caché to view
			$data_storefront = $this->_get_user($data_user);
		}
		
		// Load user products for sale
		$data_storefront ['user_products'] = $this->product_model->get_user_products_for_sale($username);
		
		// Max height to images
		$data_storefront ['max_height'] = 250;
		
		// Data for load Storefront view
		$data ['title'] = 'Saldum | ' . $data_storefront ['user_name'] . ' ' . $data_storefront ['user_surname'];
		$data ['description'] = 'Escaparate de ' . $data_storefront ['user_name'] . ' ' . $data_storefront ['user_surname'] . ' en Saldum.'; //TODO Marketing team
		$data ['label_active'] = 'storefront';
		
		$data ['css_headers'] = create_css_headers(array($this->config->item('res_css_basics')),
												   			$this->config->item('resources'));
		$data ['js_headers'] = create_js_headers(array($this->config->item('res_js_basics'),
														$this->config->item('res_google_maps'),
														$this->config->item('res_gmaps')),
													  		$this->config->item('resources'));
		// Load Storefront view
		$this->load->view('templates/head', $data);
		$this->load->view('templates/header');
		$this->load->view('storefront/storefront_view', $data_storefront);
		$this->load->view('templates/footer', $data);
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
		header('location: ' . base_url() . $this->session->userdata('user_name'));
	}
}

/* End of file storefront.php */
/* Location: ./controllers/storefront.php */