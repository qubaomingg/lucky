<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends Lucky_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->model('back_model');
		$this->load->model('article_model');
	}		
	public function index()
	{
		$data['title'] = 'lucky';
		// num of type
		$num_design = $this->article_model->get_num_type(1);
		
		$num_person = $this->article_model->get_num_type(2);
		$num_read = $this->article_model->get_num_type(3);

		$data['num_design'] = $num_design;
		$data['num_person'] = $num_person;
		$data['num_read'] = $num_read;

		$article = $this->article_model->get_recently_des(1);
		
		$data['article'] = $article;
		$this->load->view('master', $data);
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
	private function get_num_type_time($type, $time) 
	{
		$num = $this->article_model->get_num_type_time($type, $time);
		return $num;

	}
	public function get_master_article() 
	{
		$out = array();
		$time = stripcslashes(trim($_POST['time']));
		$type = stripcslashes(trim($_POST['type']));
		$current = stripslashes(trim($_POST['current']));
		/*$time = '2013';
		$type = 2;
		$current = 1;*/

		$sum = $this->get_num_type_time($type, $time);
		
		$article = $this->article_model->get_master_article($type, $time, 2*($current-1), 2);
		$out = $this->save_from_res($article);

		$out['sum'] = $sum;
		$out['year'] = $time;
		
		
		/*echo '<pre>';
		var_dump($out);
		die;*/
		echo json_encode($out);

	}
	private function save_from_res($res) 
	{
		$out = array();
		if(!$res) return false;
		foreach ($res as $num => $article) {
			foreach ($article as $key => $value) {
				if($key == 'abody')
				{
					$describe = $this->split_a_pagraph($value);
					$out[$num]['describe'] = $describe;
					$out[$num]['body'] = $value;
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
		if(!$matches){
			$matches[0] = $str;
		}
		return $matches[0];
	}
	public function write() 
	{
		$tags = $this->back_model->get_tags();
		$data['tags'] = $tags;
		$data['isWrite'] = true;
		// num of type
		$num_design = $this->article_model->get_num_type(1);
		
		$num_person = $this->article_model->get_num_type(2);
		$num_read = $this->article_model->get_num_type(3);

		$data['num_design'] = $num_design;
		$data['num_person'] = $num_person;
		$data['num_read'] = $num_read;
		
		$this->load->view('master', $data);
	}

	public function save() 
	{	
		$url2 = "javascript:history.go(-1)";
		$str1 = "成功发布一条文章。";
		$str2 = "发布文章失败，请重试~";
		$add_title = $this->input->post("add_title",TRUE);
		$add_achieve = $this->input->post("add_achieve",TRUE);
		$add_tags = $this->input->post('add_tag', TRUE);
		$content = $this->input->post('content');
				
		$array_tag = explode(',', $add_tags);
		
		$detailid = $this->back_model->save($add_title, $add_achieve, $array_tag, $content);
		
		$url1 = base_url("master/article/$detailid");
		$this->show_tips($str1,$url1);
	}
	public function delete($detailid) 
	{
		
		$url2 = "javascript:history.go(-1)";
		$str1 = "删除成功！";
		$str2 = "删除失败！";
		$detailid = $this->back_model->delete_by_detailid($detailid);
		
		$detailid = $detailid[0]['detailid'];
		$url1 = base_url("master/article/$detailid");
		if($detailid)
		{
			$this->show_tips($str1,$url1);
		}
		else 
		{
			$this->show_tips($str2,$url2);
		}
	}
	public function update($detailid)
	{
		$data = array();

		$title = $this->back_model->get_title($detailid);
		$title = $title[0]['atitle'];


		$type = $this->back_model->get_type($detailid);
		$type = $type[0]['atype'];


		$tag = $this->back_model->get_tag($detailid);
		$tag_str = "";
		
		foreach ($tag as $key => $value) {
			if($tag_str == "") {
				$tag_str = $tag_str . $value['tagbody'];
			} else {
				$tag_str = $tag_str. ','.$value['tagbody'];	
			}
		}
		
		$content = $this->back_model->get_content($detailid);
		$content = $content[0]['abody'];
		// num of type
		$num_design = $this->article_model->get_num_type(1);
		
		$num_person = $this->article_model->get_num_type(2);
		$num_read = $this->article_model->get_num_type(3);

		$data['num_design'] = $num_design;
		$data['num_person'] = $num_person;
		$data['num_read'] = $num_read;
		
		$tags = $this->back_model->get_tags();


		
		$data['tags'] = $tags;
		$data['update_title'] = $title;
		$data['update_type'] = $type;
		$data['update_tag'] = $tag_str;
		$data['update_content'] = $content;
		$data['isUpdate'] = true;
		$data['detailid'] = $detailid;

		$this->load->view('master',$data);	

	}

	public function article($detailid)
	{
		$article = $this->article_model->get_article_detailid($detailid);
		$data = array();
		// num of type
		$num_design = $this->article_model->get_num_type(1);
		
		$num_person = $this->article_model->get_num_type(2);
		$num_read = $this->article_model->get_num_type(3);

		$data['num_design'] = $num_design;
		$data['num_person'] = $num_person;
		$data['num_read'] = $num_read;
		$data['article'] = $article;
		$this->load->view('master', $data);
	}
	public function update_article($detailid)
	{

		$url2 = "javascript:history.go(-1)";
		$str1 = "更新成功.";
		$str2 = "更新失败，请重试~";
		

		$add_title = $this->input->post("add_title",TRUE);
		$add_achieve = $this->input->post("add_achieve",TRUE);
		$add_tags = $this->input->post('add_tag', TRUE);
		$content = $this->input->post('content');


		$array_tag = explode(',', $add_tags);

		$detailid = $this->back_model->update($add_title, $add_achieve, $array_tag, $content, $detailid);
		$url1 = base_url("master/article/$detailid");

		if($detailid)
		{
			$this->show_tips($str1,$url1);
		}else {
			$this->show_tips($str2,$url2);
		}
	}
}
