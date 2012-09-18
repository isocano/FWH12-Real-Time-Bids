<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	/*------------------------------ CREATE FUNCTIONS ---------------------------*/
	
	// Insert an user in the DB
	function insert_user($name, $last_name, $phone, $fb_id, $username)
	{
		$data = array(
			'NAME'		=>	$name,
			'LAST_NAME'	=>	$last_name,
			'PHONE'		=>	$phone, 
			'FB_ID'		=> 	$fb_id,
			'FB_USERNAME'	=>	$username,
		);
		
		$this->db->insert ('user', $data);
		return $this->db->insert_id();
	}
	
	/*------------------------------ READ FUNCTIONS ---------------------------*/
	
	// Get user
	function get_user($fb_id)
	{
		$this->db->select('NAME', 'LAST_NAME', 'PHONE', 'FB_ID', 'FB_USERNAME');
		$this->db->where('FB_ID', $fb_id);
		$query = $this->db->get('user');
		
		return $query->row();
	}
	
	function is_user_registered($fb_id)
	{
		$this->db->select('FB_ID');
		$this->db->where('FB_ID', $fb_id);
		$query = $this->db->get('user');
		
		if ($query->row() != NULL)
			return TRUE;
		
		return FALSE;
	}
	
}

/* End of file user_model.php */
/* Location: ./models/user_model.php */