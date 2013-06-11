<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* user_info
*/
class Article_model  extends LUCKY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_recently_des($num) {

		$res = $this->db->query('select ad.atitle,ad.atime, ad.anum, ad.abody from article_detail as ad order by ad.atime desc limit '.$num);

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