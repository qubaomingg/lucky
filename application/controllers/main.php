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
		
		// the nearst aricle info.
		$nearst_list = $this->get_nearst_list();
		$data['nearst_list'] = $nearst_list;
		
		// type num
		$init_num = $this->get_articlenum_type(1);//type = 1 article num;
		$data['onenum'] = $init_num;
		
		//article list
		$article_list = $this->get_list_type_init();
		$data['article_list'] = $article_list;
		$this->load->view('main', $data);
	}

	//每一个函数都根据view的需要吧查询的数据进行封装。
	//return nearst article:title time nun body describe 
	private function get_nearst_list() 
	{
		$recently_des = $this->article_model->get_recently_des(1);
		$out = array();
		$out = $this->save_from_res($recently_des);
		return $out;
	}
	// save data from model into array.
	private function save_from_res($res) 
	{
		foreach ($res as $num => $article) {
			foreach ($article as $key => $value) {
				if($key == 'abody')
				{
					$describe = $this->split_a_pagraph($value);
					//获取文章body里面的images的src,存放在$matches
					preg_match("/(?<=<img src=\").*?(?=\">)/i",$value,$matches);
					$out[$num]['describe'] = $describe;
					$out[$num]['body'] = $value;
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
		$out = $this->save_from_res($res);
		return $out;
	}

	private function split_a_pagraph($str) 
	{
		$matches = array();
		preg_match("/(?<=<p>).*?(?=<\/p>)/",$str,$matches);
		return $matches[0];
	}

	// when user click the nav li.respone with $num, two article.
	public function response_type_ajax() 
	{
		$out = array();
		$type = stripslashes(trim($_POST['type']));
		$current = stripslashes(trim($_POST['current']));
		$sum = $this->get_articlenum_type($type);

		$article = $this->article_model->get_article_list($type, 2*($current-1), 2);
		$out = $this->save_from_res($article);
		$out['sum'] = $sum;
		echo json_encode($out);//change array into json.
	}
	
}
