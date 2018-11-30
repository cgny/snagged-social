<?php


class Error_model extends CI_Model{
	
	function dbError($force = false)
	{
 		$error = $this->db->error();
		if(empty($error['message']))
		{
			return false;
		}
		if(!empty($error['message']))
		{
			$qry = $this->db->last_query();
			mail('christian@cgnewyork.com','SS error',$error['message'].' '.$qry);
		}
		if(ENVIRONMENT == 'development' || $force == true)
		{
			echo $error['message'];
            $qry = $this->db->last_query();
            mail('christian@cgnewyork.com','SS error',$error['message'].' '.$qry);
		}
		return true;
	}
	
	function sendError($file,$line,$error)
	{
		mail('contact@snaggedsocial.com','SS error',$error);
	}

	function scrubSQL($string)
	{
		$string = $this->db->escape_str($string);
		$string = htmlspecialchars(strip_tags(trim($string)));
		$string = str_replace("'", "", $string);
		$string = str_replace(",", "", $string);
		return $string;
	}

}

?>
