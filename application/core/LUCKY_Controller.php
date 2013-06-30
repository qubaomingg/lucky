<?php
/*
basic controller, fs21 07/06/2013
*/
class LUCKY_Controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->title = 'lucky_pixeldot';
		$this->load->helper('url');
	}
	function show_tips($str,$url)
	{
		header('Content-Type: text/html; charset=utf-8');
		echo ($url === "document.referrer" ) ?
			"<script>alert('$str');location.href=$url;</script>" :
			"<script>alert('$str');location.href='$url';</script>";
	}
}

?>