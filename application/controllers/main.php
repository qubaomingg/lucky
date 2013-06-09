<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Lucky_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->model('article_model');
	}		
	public function index()
	{	
		



		$recently_des = $this->article_model->get_recently_des(1);
		$welcomelist = $this->get_welcome_list($recently_des);
		$data['welcomelist'] = $welcomelist;
		
		$init_num = $this->get_articlenum_type(1);//type = 1 article num;
		$data['onenum'] = $init_num;
		
		$article_list = $this->get_list_type_init();
		
		$data['article_list'] = $article_list;
		$this->load->view('main', $data);
	}

	//每一个函数都根据view的需要吧查询的数据进行封装。
	//get once title describe image
	private function get_welcome_list($result) 
	{
		$out = array();
		foreach ($result as $article) 
		{
			foreach ($article as $key => $value) 
			{
				if($key == 'abody')	
				{
					$describe = substr($value, 0, 320);
					//获取文章body里面的images的src,存放在$matches
					preg_match("/(?<=<img src=\").*?(?=\">)/i",$value,$matches);
					$out['describe'] = $describe;
					$out['img'] = $matches[0];
				}
				if($key == 'atitle')
				{
					$out['title'] = $value;
				}
			}
		}
		return $out;
	}
	//get article list by type.1:design  2:persion 3:read 
	//get loop img  title num time describe
	private function get_articlenum_type($type) 
	{
		$num = $this->article_model->get_articlenum_type($type);
		return $num;

	}
	private function get_list_type_init()
	{
		$res = $this->article_model->get_article_list(1, 0, 2);
		$out = array();
		foreach ($res as $num => $article) {
			foreach ($article as $key => $value) {
				if($key == 'abody')
				{
					$describe = $this->split_a_pagraph($value);
					//获取文章body里面的images的src,存放在$matches
					preg_match("/(?<=<img src=\").*?(?=\">)/i",$value,$matches);
					$out[$num]['describe'] = $describe;
					if($matches) 
					{
						$out[$num]['img'] = $matches[0];	
					}
					
				}
				if($key == 'atitle') 
				{
					$out[$num]['title'] = $value;
				}
				if($key == 'atime')
				{
					$out[$num]['time'] = $value;
				}
				if($key == 'anum')
				{
					$out[$num]['num'] = $value;
				}
			}
		}
		return $out;
	}

	private function split_a_pagraph($str) 
	{
		$matches = array();
		preg_match("/(?<=<p>).*?(?=<\/p>)/",$str,$matches);
		return $matches[0];
	}
	
}
