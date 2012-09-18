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
	 * Maps to the following URL
	 * 		http://sldm.co/dashboard
	 *
	 * @access	public
	 * @param	string
	 */
	public function view () 
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
		// Load Dashboard view
		$this->load->view('templates/head', $data);
		$this->load->view('templates/header');
		$this->load->view('dashboard_view', $data_dashboard);
		$this->load->view('templates/footer');
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

/* End of file dashboard.php */
/* Location: ./controllers/dashboard.php */