<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lot_model extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	/*------------------------------ CREATE FUNCTIONS ---------------------------*/
	
	// Insert an lot in the DB
	function insert_lot($name, $price, $description, $user)
	{
		$data = array(
			'NAME'			=>	$name,
			'PRICE'			=>	$price,
			'DESCRIPTION'	=>	$description,
			'USER'			=>	$user
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
	
	/*------------------------------ UPDATE FUNCTIONS ---------------------------*/
	
	function update_lot ($user_id, $user_data)
	{
		$this->db->where('USER', $user_id);
		$this->db->update('user', $user_data);
	}
}

/* End of file lot_model.php */
/* Location: ./models/lot_model.php */