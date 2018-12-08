<?php


class Error_model extends CI_Model{
	
	function dbError($force = false, $file = "", $line ="", $function = "", $qry = "", $data = "")
	{
 		$error = $this->db->error();
		if(empty($error['message']))
		{
			return false;
		}
        $qry = false;
		if(!empty($error['message']))
		{
			$qry = $this->db->last_query();
			mail('christian@cgnewyork.com','SS error',$error['message'].' '.$qry);
		}

		$this->logError( $file, $line, $function, $error, $qry, $data);

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

	function logError( $file, $line, $function, $error, $query, $data ="")
	{

		$data =  json_encode( $data );

		$this->sendError($file,$line,$error);
		$arr = array(
			'e_file'	=> $file,
			'e_line'	=> $line,
			'e_function'=> $function,
			'e_error'	=> $error,
			'e_query'	=> $query,
			'e_data'	=> $data,
		);
		$this->db->insert('ss_error', $arr );
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
