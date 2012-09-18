<?php
require_once 'facebook.php';

/**
 * Clase para facilitar el trabajo con Facebook. 
 */
class Feisbus {
    const APP_ID   = '295932183816944';
    const SECRET   = 'f828abc43d7ae756af359767200a4dac';
	const BASE_URL = 'http://www.saldum.net/';
	const APP_NAMESPACE = 'saldumapp';	 
		 
    private $fb;			//Instancia de la clase oficial de Facebook
	private $user;			//Usuario logueado en la aplicación

	public  $debug = FALSE;
    /**
     * Constructor de la clase. Crea el objeto Facebook que utilizaremos
     * en los métodos que interactúan con la red social
     */
    function __construct() 
    {
        $this->fb = new Facebook(array(
        	'appId'  => self::APP_ID,
        	'secret' => self::SECRET,
        ));
		
		$this->user = $this->fb->getUser();				
    }
	
	function get_app_id()
	{
		return self::APP_ID;
	}
	
	function get_app_namespace()
	{
		return self::APP_NAMESPACE;
	}
	
	function get_user_id()
	{
		return $this->fb->getUser();
	}
	
	function get_access_token()
	{
		return $this->fb->getAccessToken();
	}
	
	function get_login_button($login, $size = NULL) 
	{
		if ($size == NULL)
			$size = "small";
		
		//TODO volver a poner el mensaje en inglés
        $scope = 'offline_access,
                  publish_stream,
                  read_friendlists,
	              user_checkins,
				  email, 
	              user_birthday,
	              user_location,
	              user_about_me,
	              user_hometown,
	              user_education_history,
	              user_likes,
	              user_activities,
	              user_interests,
	              friends_likes,
	              friends_about_me,
	              friends_birthday,
	              friends_hometown,
	              friends_relationships,
	              friends_activities,
	              friends_interests,
	              friends_location,
	              friends_checkins';
		
		if ($login)	
			return 
				'<fb:login-button size="' . $size . '" scope="' . $scope . '">
			    	Entrar con Facebook
			    </fb:login-button>';
		else  
			return 		
				'<fb:login-button autologoutlink="true">
				</fb:login-button>';
	}
	
	/*function get_logout_button() 
	{
		return 
				'<div class="fb-login-button" autologoutlink="true" onclick="FB.logout();">
			    	Salir
			    </div>';
	}*/

	function get_login_url($params = NULL) 
	{
		if ($params != NULL)
			return $this->fb->getLoginUrl($params);
		else
			return $this->fb->getLoginUrl();
	}
	
	function get_logout_url($next = NULL) 
	{
		if ($next != NULL)
			return $this->fb->getLogoutUrl($next);
		else
			return $this->fb->getLogoutUrl();
	}
	
	function load_javascript_SDK()
	{
		return 
				"<div id='fb-root'></div>
				<script>               
	      			window.fbAsyncInit = function() {
		        		FB.init({
		          			appId  : '" . self::APP_ID . "',
					        cookie : true,
					        channelUrl : '". self::BASE_URL . "assets/facebook/channel.php', 
		          			xfbml  : true,
		          			oauth  : true,
		          			viewMode: 'website'
		        		});
		        		FB.Event.subscribe('auth.login', function(response) {
			          		window.location.reload();
		        		});
		        		
		        		FB.Event.subscribe('auth.logout', function(response) {
		          			window.location.reload();
		        		});
	     	 		};
			      	(function() {
			        	var e = document.createElement('script'); e.async = true;
			        	e.src = document.location.protocol +
			          	'//connect.facebook.net/en_US/all.js';
			        	document.getElementById('fb-root').appendChild(e);
			      	}());
					
		            function newInvite(){
		                 var receiverUserIds = FB.ui({ 
		                        method : 'apprequests',
		                        message: '¡Compra, vende y gana dinero compartiendo productos entre tus contactos!',
		                 });
		            }
		    	</script>";
	}
	
	function send_message_javascript()
	{
		return 
				"<script>
					function sendMessage(to, name, link, description, picture)
					{
						FB.ui({
	          				method: 		'send',
	          				to: 			to,
	          				name: 			name,
	          				link: 			link,
	          				description: 	description,
	          				picture:		picture
			          	})
					}
		         </script>";
	}
	
	function publish_action ($action, $object, $object_url) 
	{
		$url = 'https://graph.facebook.com/'. $this->fb->getUser(). '/' . self::APP_NAMESPACE . ":$action";     
		$ch = curl_init();   
		$attachment = array('access_token' => $this->get_access_token(), $object => $object_url);     
		curl_setopt($ch, CURLOPT_URL, $url);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);        
		curl_setopt($ch, CURLOPT_POST, true);     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);     
		$result= curl_exec($ch);
		curl_close ($ch); 
	}
	
	function basic_operation($fb_command)
	{
		$data = NULL;
		
		if ($this->user) 
		{
			try 
			{
		    	$data = $this->fb->api("/$fb_command");
			} 
			catch (FacebookApiException $e) 
			{
				if ($this->debug)
					echo $e;
				
		        $this->user = NULL;
		    }
		}
		
		return $data;
	}
	
	function execute_fql($query)
	{
		$data = NULL;
		try 
		{
            $params  =   array(
                'method'    => 'fql.query',
                'query'     => $query,
                'callback'  => ''
            );
			
            $data   =   $this->fb->api($params);
		} 
		catch (FacebookApiException $e) 
		{
			echo $e;
			
			if ($this->debug)
				echo $e;
	    }
		
		return $data;
	}
	
	function get_user_info()
	{
		return $this->basic_operation('/me');
	}
	
	function get_basic_user_info()
	{
		return $this->basic_operation("/$this->user");	
	}
	
	function get_user_movies()
	{
		return $this->basic_operation("/$this->user/movies");
	}
	
	//update user's status using graph api
	function update_user_status($message, $link, $picture_url, $name, $description)
	{
    	try 
    	{
        	$this->fb->api("/$this->user/feed", 'POST', array(
	                    'message'    => $message,
	                    'link'       => $link,
	                    'picture'    => $picture_url,
	                    'name'       => $name,
	                    'description'=> $description
            	    )
        	); 
       	} 
       	catch (FacebookApiException $e) 
       	{
        	if ($this->debug)
				echo $e;
     	}
	}
	
	function is_user_logged()
	{
		if ($this->user != 0)
			return TRUE;
		
		return FALSE;
	}
}