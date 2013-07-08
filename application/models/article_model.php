<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* user_info
*/
class Article_model  extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		
	}

	public function save_msg($nickname, $email, $blog, $message_content)
	{
		$data = array(
			'mnickname' => $nickname,
			'mbody' => $message_content,
			'memail' => $email,
			'mblog' => $blog,
			'mtime' => date('Y.m.d H:i')
		);
		$res = $this->db->insert('msg', $data);
		return $res;

	}
	public function save_msg_res($nickname, $email, $blog, $message_content, $response_toname,$response_belongname,$response_time)
	{
		$mid = $this->get_mid($response_belongname, $response_time);
		$mid = $mid[0]['mid'];
		$data = array(
			'mrnickname' => $nickname,
			'mrbody' => $message_content,
			'mremail' => $email,
			'mrblog' => $blog,
			'mrtime' => date('Y.m.d H:i'),
			'mrto' => $response_toname,
			'mrbelong' => $response_belongname,
			'mid' => $mid
		);
		$res = $this->db->insert('msg_response', $data);
		return $res;
	}


	public function get_mid($response_name, $response_time)
	{
		$res = $this->db->query('select mid from msg where mnickname = "'.$response_name.'" and mtime = "'.$response_time.'"');
		/* select mid from msg where mnickname = 'sam' and mtime = '2013-07-08 00:44:00'; */
		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;
	}
	public function get_msg() 
	{
		$this->db->select('*');
		$res = $this->db->get('msg');
		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;	
	}
	public function get_msgresponse() 
	{
		$this->db->select('*');
		$res = $this->db->get('msg_response');
		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;	
	}
	public function get_num_title($title)
	{
		$this->db->select('anum');
		$this->db->where('atitle', $title);
		$query = $this->db->get('article_detail');
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;	
	}
	public function set_num_title($title,$num)
	{
		$num = $num + 1;
		$res = $this->db->query("update article_detail set anum = ".$num." where atitle = '".$title."'");
		return $res;
	}
	public function get_time()
	{
		$query = $this->db->query('select atime from article_detail');
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;
	}
	public function get_master_article($type, $time, $skip, $per_page_num) 
	{
		
		$res = $this->db->query('select ad.atitle, ad.atime, ad.anum, ad.abody, ad.detailid from article_detail as ad inner join article as a using(detailid) where a.atype = '.$type.' and ad.atime like "'.$time.'%" order by ad.atime desc  limit '.$skip.','.$per_page_num);

		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;	
	}
	public function get_num_type($num)
	{
		$res = $this->db->query('select * from article where atype ='.$num);
		return $res->num_rows();
	}
	public function get_recently_des($num) 
	{

		$res = $this->db->query('select ad.atitle,ad.atime, ad.anum, ad.time,ad.abody,ad.detailid from article_detail as ad order by ad.time desc limit '.$num);

		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;
	}

	//$res = $this->db->query('select ad.atitle,ad.abody, ad.atime, ad.anum from article as a inner join article_detail as ad using(detailid) order by ad.atime desc limit '.$num);
	public function get_article_list($type, $skip, $per_page_num) 
	{	
		$res = $this->db->query('select ad.atitle,ad.abody, ad.atime, ad.anum from article_detail as ad inner join article as a using(detailid) where a.atype = '.$type.' order by ad.atime desc  limit '.$skip.','.$per_page_num);

		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;	
	}

	public function get_article_list_time($time, $skip, $per_page_num) 
	{
		$res = $this->db->query('select atitle,abody,atime,anum from article_detail  where atime like "'.$time.'%" order by atime desc  limit '.$skip.','.$per_page_num);

		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;	
	}
	public function get_num_type_time($type, $time) 
	{
		$res = $this->db->query('select ad.anum from article_detail as ad inner join article as a using(detailid) where a.atype = '.$type.' and ad.atime like "'.$time.'%"');
		$num = $res->num_rows();
		return $num;		
	}
	
	public function get_articlenum_type($type)
	{
		$this->db->select('*');
		$this->db->where('atype', $type);
		$query = $this->db->get('article');
		$num = $query->num_rows();
		return $num;
	}
	public function get_articlenum_time($time)
	{
		$this->db->select('*');
		$this->db->like('atime',$time);
		$query = $this->db->get('article_detail');
		$num = $query->num_rows();
		return $num;
	}
	public function get_article_title($title) 
	{
		$this->db->select('*');
		$this->db->where('atitle', $title);
		$query = $this->db->get('article_detail');
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;	
	}
	public function get_article_detailid($detailid)
	{
		$this->db->select('*');
		$this->db->where('detailid', $detailid);
		$query = $this->db->get('article_detail');
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;	
	}
	public function get_type($detailid)
	{
		$res = $this->db->query('select atype from article where detailid ='.$detailid);
		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;	
	}

	// relative to tag
	public function  get_articlenum_tag($tagid) 
	{
		$this->db->select('aid');
		$this->db->where('tagid', $tagid);
		$query = $this->db->get('article_tag');
		return $query->num_rows();
	}
	public function get_article_tag($tagid, $skip, $per_page_num)
	{
		$res = $this->db->query('select atitle, abody, atime, anum from article_detail where detailid in (select detailid from article where aid in (select aid from article_tag where tagid = '.$tagid.')) order by atime desc  limit '.$skip.','.$per_page_num);

		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;	
	}
	public function get_tagbody_tag($tagid) 
	{
		$this->db->select('tagbody');
		$this->db->where('tagid', $tagid);
		$query = $this->db->get('tag');
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;	
	}

	
}
?>