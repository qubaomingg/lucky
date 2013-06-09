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
}

?>