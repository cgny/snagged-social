<?php


class Media_model extends CI_Model{

	function getId($data)
	{
		return $data->id;
	}

	function getPhotoURL($data,$size = "standard_resolution", $large = false)
	{
		if($large)
		{
			
		}
		return $data->images->$size->url;
	}

	function getLink($data)
	{
		return $data->link;
	}

	function getCaption($data)
	{
		return isset($data->caption->text) ? $data->caption->text : "No caption provided";
	}

	function getTags($data)
	{
		return json_encode($data->tags);
	}
	
	function tagFilters($media)
	{
		$tags = $media->tags;
		$bads = array(
			"sex","porn","nude","naked","nigger","fag","kkk","chink","spic","bitch","dick","pussy","gook","faggot","shit",
			"asshole","fucker","fuck"
		);
		foreach($tags as $tag)
		{
			foreach($bads as $bad)
			{
				if(stristr($tag,$bad))
				{
					return false;
				}
			}
		}
		return true;
	}

	function getSSMedia($user_id = null,$price_set = true, $limit = 200, $show_all = false)
	{
		if($user_id)
		{
			$this->db->where('p_a_id',$user_id);
		}
		else
		{
			$this->db->limit($limit);		
		}
        if($show_all == false)
        {
            $this->db->where('p_deleted',0);
        }
        if($price_set == true)
        {
            $this->db->where('p_price > ',0);
        }
		$this->db->join("ss_accounts","ss_accounts.a_id = ss_photos.p_a_id");
		$this->db->order_by('p_created','DESC');
		return $this->db->get('ss_photos')->result();
	}

	function saveMedia($data)
	{
		if(!empty($account_id = $this->account->isLogged()))
		{
			$replace = array(
				"p_a_id"     => $account_id,
				"p_ig_id"    => $data->id,
				"p_url"      => $this->getPhotoURL($data),
				"p_high_url" => $this->getPhotoURL($data, 'standard_resolution', true),
				"p_tags"     => $this->getTags($data),
				"p_caption"  => $this->getCaption($data)
			);
			return $this->db->replace('ss_photos', $replace);
		}
		return "not saved";
	}

	function removeMedia($p_ig_id)
	{
		if(!empty($account_id = $this->account->isLogged()))
		{
			$this->db->where('p_ig_id',$p_ig_id);
			$this->db->where('p_a_id',$account_id);
			return $this->db->update('ss_photos',array('p_deleted' => 1));
		}
	}

	function updateMedia($p_id,$data)
	{
		$update = array(
			"p_ig_id" => $data->id,
			"p_url" => $this->getPhotoURL($data),
			"p_url" => $this->getPhotoURL($data,'standard_resolution',true),
			"p_tags" => $this->getTags($data),
			"p_caption" => $this->getCaption($data)
		);
		if(!empty($account_id = $this->account->isLogged()))
		{
			$this->db->where('p_id', $p_id);
			$this->db->where('p_a_id', $account_id);
			return $this->db->update('ss_photos', $update);
		}
	}

	function updatePrice($p_id,$price)
	{
		$data = array(
			"p_price" => $price
		);
		$this->db->where('p_id',$p_id);
		return $this->db->update('ss_photos',$data);
	}

	function search($p_tags=array(),$a_ig_username=array())
	{
		$fields = array("p_tags","a_ig_username");
		$c = 0;
		foreach($fields as $k => $field)
		{
			$search = $$field;
			if(!is_array($search) || empty($search))
			{
				continue;
			}
			foreach ($search as $like)
			{
				if(empty($like))
				{
					continue;
				}
				else
				{
					$c++;
				}
				if($c > 0)
				{
					$this->db->or_like($field, $this->db->escape_str($like));
				}
				else
				{
					$this->db->or_like($field, $this->db->escape_str($like));
				}
			}
		}
                $this->db->where('p_price > ',0);
                $this->db->where('p_deleted',0);
		$this->db->join("ss_accounts","ss_accounts.a_id = ss_photos.p_a_id");
		$this->db->order_by('p_created','DESC');
		return $this->db->get("ss_photos")
				->result();
	}
	
	function getMedia($id)
	{
                $this->db->where('p_deleted',0);
		$this->db->where('p_id', $this->db->escape_str($id));
		$this->db->join("ss_accounts","ss_accounts.a_id = ss_photos.p_a_id");
		$result = $this->db->get("ss_photos");
		if($result->num_rows() == 1)
		{
			return $result->row();
		}
		return false;
	}

	function getPhotoSizes($size_id = "")
	{
            if($size_id)
            {
                $this->db->where('ps_id',$size_id);
            }
            $this->db->order_by('ps_id');
                
            if($size_id)
            {
                $this->db->where('ps_id',$size_id);
                return $this->db->get('ss_photo_sizes')->row();
            }
            return $this->db->get('ss_photo_sizes')->result();
	}

	function checkValidMedia()
    {
        $medias = $this->getSSMedia();

        $imgs = [];
        foreach($medias as $media)
        {
            $response = $this->CurlFetchMedia($media->p_url);
            $imgs[$media->p_id] = $response;
            /*
            if($response == false)
            {
                $this->updateMedia($media->p_id,array('p_deleted' => 1));
            }
            */
        }
        print_r($imgs);
    }

    function curlFetchMedia($url)
    {
        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $info = curl_getinfo($ch);
        if(!isset($info['http_code']))
        {
            return false;
        }
        elseif(isset($info['http_code']) && $info['http_code'] != 200)
        {
            return false;
        }
        elseif(isset($info['http_code']) && $info['http_code'] == 200)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
