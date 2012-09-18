<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auction extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('user_model', 'lot_model'));
		$this->load->helper(array('url'));
		$this->load->library(array(''));
	}
	
	public function push ($msg, $user)
	{
		require('/var/www/html/application/libraries/Pusher/lib/Pusher.php');

		$key = '131de32e0bed65790199';
		$secret = '69d5b8a4d4f0696b3c7a';
		$app_id = '27903';
	
		$pusher = new Pusher($key, $secret, $app_id);
		$pusher->trigger('my-channel', 'my-event', array('message' => "$msg", 'user' => "$user") );
	}
	
	public function delete_temporal_images()
	{
		delete_files($this->config->item('upload_user_photo') . $this->session->userdata('user_id') . '/tmp/');
		delete_files($this->config->item('upload_user_photo') . $this->session->userdata('user_id') . '/tmp/thumbnails');
	}
	
	public function add ()
	{
		// Comprueba si el visitante está logueado
		if ($this->session->userdata('user_id') != NULL) 
		{
			// Input validation rules
			$this->form_validation->set_rules('lot_name', 'lot_name', 'required');
			$this->form_validation->set_rules('price', 'price', 'required|is_numeric');
			
			// User execute form and check values
			if ($this->form_validation->run() == TRUE)
			{
				$lot_name = $this->input->post('lot_name');							
				$price = $this->input->post('price');
				$description = $this->input->post('description');
				
				$lot_id = $this->lot_model->insert_lot($lot_name, $price, $description, $this->config->item('user_id'));
				
				mkdir($this->config->item('upload_lot_photo') . $lot_id, 0777);
				
				$max = 1500000;
				$uploaddir = $this->config->item('upload_product_photo') . $lot_id . '/';
				
				if($filesize < $max)
				{
					if($filesize > 0)
					{ 
						if((ereg(".jpg", $filename)) || (ereg(".gif", $filename)) || (ereg(".JPG", $filename))|| (ereg(".GIF", $filename)))
						{
							$uploadfile = $uploaddir . $filename;
							if (move_uploaded_file($_FILES['upfile']['tmp_name'], $uploadfile)) 
							{
								$ok = TRUE;
							}
						}
					}
				}

				if ($ok)
				{
					$image = array('IMAGE' => $filename);
					
					$this->lot_model->update_lot($lot_id, $image);
				}
			}
			else 
			{
				$this->delete_temporal_images();					// Delete temporal files
			}
		}
		
		
		
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
		$data_auction['image'] = "http://sldm.co/data/lot/1/globe.png";
		$data_auction['description'] = "Awesome World Globe that will look great in your office. What a better proof that these to show your colleagues and clients that you were Hacking in Barcelona?";
		
		$data ['title'] = 'live bidr | Auction';
		$data ['description'] = '';
		
		$this->load->view('templates/head', $data);
		$this->load->view('templates/header');
		$this->load->view('auction_view.php', $data_auction);
		$this->load->view('templates/footer');
	}
}

/* End of file auction.php */
/* Location: ./controllers/auction.php */