<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* user_info
*/
class User_model  extends LUCKY_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
		现在只是简单默认密码，以后需要用户名和密码存数据库了再用。
	*/
	function login($data)
	{
		//检查用户名、密码是否一致
		if(is_array($data))
		{
			$query = $this->db->where("uname",$data["username"])
							  ->where("upassword",$data["password"])
							  ->get("user");

			return ($query->num_rows() > 0) ? 
				$query->result_array() : FALSE;
		}
		else
		{
			return NULL;
		}
	}

	
}
?>
