<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	/*------------------------------ CREATE FUNCTIONS ---------------------------*/
	
	// Insert an lot in the DB
	function insert_lot($price, $description, $auction)
	{
		$data = array(
			'PRICE'			=>	$price,
			'DESCRIPTION'		=>	$description,
			'AUCTION'		=>	$auction, 
		);
		
		$this->db->insert ('lot', $data);
		return $this->db->insert_id();
	}
	
	/*------------------------------ READ FUNCTIONS ---------------------------*/
	
	// Get lot
	function get_lot ($id)
	{
		$this->db->select('PRICE', 'DESCRIPTION', 'AUCTION');
		$this->db->where('ID', $id);
		$query = $this->db->get('lot');
		
		return $query->row();
	}
	
	function get_lots ($auction)
	{
		$this->db->select('PRICE', 'DESCRIPTION', 'AUCTION');
		$this->db->where('AUCTION', $auction);
		$query = $this->db->get('lot');
		 
		return $query->result();
	}
	
	function get_winner_bid ($lot)
	{
		$this->db->select('AMOUNT', 'b.USER', 'NAME', 'LASTNAME', 'FB_ID', 'PRICE');
		$this->db->from('lot l');
		$this->db->where('ID', $lot);
		$this->db->join('bid b', 'b.LOT = l.ID');
		$this->db->join('user u', 'u.ID = b.USER');
		$query = $this->db->get();
		
		return $query->row();
	}
	
}

/* End of file lot_model.php */
/* Location: ./models/lot_model.php */