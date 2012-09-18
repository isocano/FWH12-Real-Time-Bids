<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auction_model extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	/*------------------------------ CREATE FUNCTIONS ---------------------------*/
	
	// Insert an auction in the DB
	function insert_auction($user, $initial_date)
	{
		$data = array(
			'USER'			=>	$USER,
			'INITIAL_DATE'	=>	$initial_date,
		);
		
		$this->db->insert ('auction', $data);
		return $this->db->insert_id();
	}
	
	/*------------------------------ READ FUNCTIONS ---------------------------*/
	
	// Check that used is registered in the DB
	function get_auction($id)
	{
		$this->db->select('ID', 'INITIAL_DATE');
		$this->db->where('ID', $id);
		$query = $this->db->get('auction');
		
		return $query->row();
	}
	
}

/* End of file auction_model.php */
/* Location: ./models/auction_model.php */