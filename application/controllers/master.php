<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends Lucky_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->model('user_model');
	}		
	public function index()
	{
		$data['title'] = 'lucky';
		$this->load->view('master');

		/*
			现在只是简单默认密码，以后需要用户名和密码存数据库了再用。
		*/

		/*
		$in_data['username'] = $PHP_AUTH_USER;
		$in_data['password'] = $PHP_AUTH_PW;

		$result = $this->user_model->login($in_data);

		if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || $result !== FALSE || $result !== NULL)
		{
			
		}
		else 
		{
			header('HTTP/1.1 401 Unauthorized');
		    header('WWW-Authenticate: Basic realm="lucky_pixeldot"');
		    exit('Sorry, you must enter a valid user name and password to access this manage pages!');
		}
		*/
	}
}
