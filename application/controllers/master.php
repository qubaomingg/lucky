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
	public function write() 
	{
		$tags = $this->back_model->get_tags();
		$data['tags'] = $tags;
		$data['isWrite'] = true;
		
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
		if($detailid)
		{
			$this->show_tips($str1,$url1);
		}else {
			$this->show_tips($str2,$url2);
		}
	}
	public function delete($detailid) 
	{
		
		$url2 = "javascript:history.go(-1)";
		$str1 = "删除成功！";
		$str2 = "删除失败！";
		$detailid = $this->back_model->delete_by_title($detailid);
		
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

		$tags = $this->back_model->get_tags();
		$data['tags'] = $tags;
		$data['update_title'] = $title;
		$data['update_type'] = $type;
		$data['update_tag'] = $tag_str;
		$data['update_content'] = $content;
		$data['isUpdate'] = true;
		$this->load->view('master',$data);

	}

	public function article($detailid)
	{
		$article = $this->article_model->get_article_detailid($detailid);
		$data = array();
		$data['article'] = $article;
		$this->load->view('master', $data);
	}
	public function update_article()
	{
		$url2 = "javascript:history.go(-1)";
		$str1 = "更新成功.";
		$str2 = "更新失败，请重试~";
		
		$add_title = $this->input->post("add_title",TRUE);
		$add_achieve = $this->input->post("add_achieve",TRUE);
		$add_tags = $this->input->post('add_tag', TRUE);
		$content = $this->input->post('content');
				
		$array_tag = explode(',', $add_tags);
		
		$detailid = $this->back_model->update($add_title, $add_achieve, $array_tag, $content);

		$url1 = base_url("master/article/$detailid");
		if($detailid)
		{
			$this->show_tips($str1,$url1);
		}else {
			$this->show_tips($str2,$url2);
		}
	}
}
