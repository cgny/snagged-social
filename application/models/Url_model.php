<?php


class Url_model extends CI_Model{
	
	function requestToken($code)
	{
		$post = array(
			"client_id" => IG_CLIENT_ID,
			"client_secret" => IG_CLIENT_SECRET,
			"grant_type" => 'authorization_code',
			"redirect_uri" => IG_REDIRECT,
			"code" => $code,
		);
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => IG_TOKEN_URL,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $post
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		$data = json_decode($resp);
		curl_close($curl);
		return $data;
	}

	function buildRequest($url,$max_id=null,$count=false)
	{
		$URL = $url .'/?access_token='.  $_SESSION['token'];
		if($max_id)
		{
			$URL .= "&max_id=$max_id";
		}
		if($count)
		{
			$URL .= "&count=" . IG_PG_LIMIT;
		}
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $URL
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		if($info['http_code'] == 200)
		{
			return json_decode($resp);
		}
		return false;
	}
	
	function hitURL($url)
	{
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
		if($info['http_code'] == 200)
		{
			return json_decode($resp);
		}
		return false;
	}

	function buildLinks($media_id='')
	{
		$user_id = $this->session->userdata['user']->id;
		return array(
			"Profile" => IG_API_URL . '/users/' . $user_id,
			"RecentMedia" => IG_API_URL . '/users/' . $user_id .'/media/recent',
			"Media" => IG_API_URL . '/media/' . $media_id,
		);
	}

	function buildUserLinks()
	{
		if($this->session->userdata['user']->admin == 1)
		{
			$build["Admin"] = site_url('/admin');
		}
		$build["My-Account"] = '#user-account';
		$build["My-Sales"] = '#user-sales';
		$build["My-Gallery"] = '#user-gallery';
		$build["My-Purchases"] = '#user-orders';
		$build["My-Instagram"] = '#instagram';
		$build["Add-Debit-Card"] = '#add-card';
		$build["Logout"] = site_url('/user/logout');
		return $build;
	}

	function getURLAssets($type,$file)
	{
		switch ($type){
			case "js":
				return '<script src="'. base_url('/assets/js/'.$file) .'"></script>';
				break;
			case "css":
				return '<link rel="stylesheet" href="'. base_url('/assets/css/'.$file) .'" >';
				break;
		}
	}

	function generateAssets($array = array())
	{
		foreach($array as $type)
		{
			$links = scandir("./assets/".$type);
			foreach($links as $file)
			{
				if(strpos($file,"css") != false || strpos($file,"js") != false)
				{
					echo $this->getURLAssets($type,$file);
				}
			}
		}
	}


   

}



?>
