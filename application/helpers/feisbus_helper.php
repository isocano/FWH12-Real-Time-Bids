<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	// Get the basic info of FB user
	function get_user_register_info($fb)
	{
		$result = NULL;
		
		if ($fb->get_user_id())
			$result = $fb->execute_fql("select username, first_name, last_name, current_location, 
										  sex, relationship_status, birthday_date,
										  email, hometown_location from user where uid=" . $fb->get_user_id());
				
		return $result;
	}
	
	// Transform the obtained data from a user of FB
	function parse_facebook_register_data($userdata)
	{
		$userdata = $userdata[0];		
		
		$userdata['user_location'] = array (
			'city'	=> $userdata['current_location']['city'],
			'state' => $userdata['current_location']['state'],
			'country' => $userdata['current_location']['country'],
			'zip_code' => $userdata['current_location']['zip'],
			'address' => ''
		);
		
		if($userdata['user_location']['city'] == NULL && $userdata['hometown_location']['city'] != NULL)
			$userdata['user_location']['city'] = $userdata['hometown_location']['city'];
		//else //por IP
			 
		
		$userdata['user_location'] = json_encode($userdata['user_location']);
		
		$date_aux = explode("/", $userdata['birthday_date']);
		$userdata['birthday'] = $date_aux[2] . '-' . $date_aux[0] . '-' . $date_aux[1];
		
		if ($userdata['sex'] == 'male')
			$userdata['sex'] = 'M';
		else 
			$userdata['sex'] = 'F';
		
		return $userdata;
	}
	
	// Get the basic info of the friends
	function get_basic_info_friends($fb)
	{
		$result = NULL;
		
		if ($fb->get_user_id())
			$result = $fb->execute_fql("SELECT uid, username, first_name, last_name FROM user
     								    WHERE uid in (SELECT uid2 FROM friend where uid1 = " . 
     								    $fb->get_user_id() . ")");
				
		return $result;
	}

/* End of file feisbus_helper.php */
/* Location: ./helpers/feisbus_helper.php */
