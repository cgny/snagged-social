<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller
{

	public $links, $token, $user, $user_id;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
	}

	function index()
	{
		if($this->account->isLogged() == false)
		{
			//redirect('/user/logout');
			exit;
		}

		$user_id = $this->session->userdata['user_id'];
		$result = $this->media->getSSMedia($user_id,false);

		if($this->error->dbError() == true)
		{
			$error = "An error has occurred!";
			$success = false;
		}
		else
		{
			$success = true;
			$error = false;
			if(empty($result))
			{
				$result = array();
			}
			
		}
		$data['errors']['message'] = $error;
		$data['success'] = $success;
		$data['photos'] = $result;
		echo json_encode($data);
	}
        
	function getGallery()
	{
		header('Access-Control-Allow-Origin: http://www.snaggedsocial.com');

        $error = false;
		$result = $this->media->getSSMedia();
		$data['errors']['message'] = $error;
		$data['success'] = true;
		$data['photos'] = $result;
		echo json_encode($data);
	}

	function recentMedia()
	{
		if($this->account->isLogged() == false)
		{
			//redirect('/user/logout');
			exit;
		}
		$back_id = $max_id = $this->input->get('max_id');
		$media = $this->url->buildRequest(
			$this->url->buildLinks()['RecentMedia'],$max_id,IG_PG_LIMIT
		);
		$images = $media->data;
		
		$photos = array();
		foreach($images as $image)
		{
			$photos[] = array(
			"p_ig_id" => $image->id,
			"p_url" => $this->media->getPhotoURL($image),
			"p_url" => $this->media->getPhotoURL($image,'standard_resolution',true),
			"p_tags" => $this->media->getTags($image),
			);
		}


		$next_id = null;
		if(isset($media->pagination->next_max_id))
		{
			$next_id = $media->pagination->next_max_id;
		}

		$data['photos'] = $photos;
		$data['errors']['message'] = false;
		$data['success'] = true;
		
		echo json_encode($data);

		foreach($images as $image)
		{
			//$this->media->saveMedia($image);
		}
		
		//echo "<a id='next_img' href='" . site_url("media/recentMedia/?max_id=$back_id") ."'>Back</a>";
		if($next_id)
		{
			//echo "<a id='next_img' href='" . site_url("media/recentMedia/?max_id=$next_id") ."'>Next</a>";
		}
	}

	function fetchMedia()
	{
		if($this->account->isLogged() == false)
		{
			//redirect('/user/logout');
			exit;
		}
		$media_id = $this->input->get('media_id');
		$media = $this->url->buildRequest(
			$this->url->buildLinks($media_id)['Media']
		);
	}

	function saveMedia()
	{
            if($this->account->isLogged() == false)
            {
                    //redirect('/user/logout');
                    exit;
            }

            $save = false;
            $msg = "Please add a debit card before adding media";

            if(!empty($this->account->checkForCard()))
            {                    

                $p_ig_id = $this->input->post('p_ig_id');
                $media = $this->url->buildRequest(
                        $this->url->buildLinks($p_ig_id)['Media']
                );

                if($this->media->tagFilters($media->data))
                {
                        $save = $this->media->saveMedia($media->data);
                        $msg = false;
                }
                else
                {
                        $save = false;
                        $msg = "Your image violates the user agreement.";
                }	

            }

            $data['save'] = $save;
            $data['errors']['message'] = $msg;
            $data['success'] = ($msg == false);
            echo json_encode($data);
		
	}

	function removeMedia()
	{
		if($this->account->isLogged() == false)
		{
			//redirect('/user/logout');
			exit;
		}
		$p_ig_id = $this->input->post('p_ig_id');
		$save = $this->media->removeMedia($p_ig_id);

		$data['save'] = $save;
		$data['errors']['message'] = false;
		$data['success'] = true;
		echo json_encode($data);
		
	}

	function search()
	{
		$tags = !empty( $this->input->get_post('tags') ) ? $this->input->get_post('tags') : array();
		$user = !empty( $this->input->get_post('users') ) ? $this->input->get_post('users') : array();
		$result = $this->media->search($tags,$user);
		
		if($this->error->dbError() == true)
		{
			$error = "An error has occurred!";
			$success = false;
		}
		else
		{
			$success = true;
			$error = false;
			if(empty($result))
			{
				$result = array();
			}
			
		}
		$data['errors']['message'] = $error;
		$data['success'] = $success;
		$data['photos'] = $result;
		echo json_encode($data);
	}
	
	function imgDetails()
	{
		$id = $this->input->post('p_id');
		$result = false;
		$success = false;
		$error = true;
		if(!empty($id))
		{
			if($img = $this->media->getMedia($id))
			{
				$result = $img;
				$success = true;
				$error = false;
			}
			else
			{
				$error = "img not found";
			}
		}
		$data['errors']['message'] = $error;
		$data['success'] = $success;
		$data['photo'] = $result;
		echo json_encode($data);
	}

	function updatePrice()
	{
		if($this->account->isLogged() == false)
		{
			//redirect('/user/logout');
			exit;
		}
		$p_id = $this->input->post('p_id');
		$p_price = $this->input->post('p_price');
		$update = $this->media->updatePrice($p_id,$p_price);
		$data['errors']['message'] = false;
		$data['success'] = true;
		echo json_encode($data);
	}

	function resyncPhoto()
	{
		if($this->account->isLogged() == false)
		{
			//redirect('/user/logout');
			exit;
		}
		$media_id = $this->input->post('p_ig_id');
		$media = $this->url->buildRequest(
			$this->url->buildLinks($media_id)['Media']
		);
		if($this->media->tagFilters($media->data))
		{
			$save = $this->media->saveMedia($media->data);
			$msg = false;
		}
		else
		{
			$save = false;
			$msg = "Your image violates the user agreement.";
		}

		$data['save'] = $save;
		$data['errors']['message'] = $msg;
		$data['success'] = ($msg == false);
		echo json_encode($data);
	}

}
