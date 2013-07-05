<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* user_info
*/
class Back_model  extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		
	}

	public function get_tags() 
	{
		$query = $this->db->query("select tagbody from tag order by tagid asc limit 5");
		
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;
	}
	public function is_tag_exist($tagbody)
	{
		$this->db->select('tagid');
		$this->db->where('tagbody', $tagbody);
		$query = $this->db->get('tag');
		return ($query->num_rows() > 0) ?
					TRUE : FALSE;
	}
	public function has_tagid($aid)
	{
		$this->db->select('tagid');
		$this->db->where('aid', $aid);
		$query = $this->db->get('article_tag');
		return ($query->num_rows() > 0) ?
					TRUE : FALSE;
	}
	public function update($add_title, $add_achieve, $array_tag, $content, $detailid)
	{
	
		$aid = $this->get_aid($detailid);

		$aid = $aid[0]['aid'];
		
		//$this->db->trans_start();
		
		// update table article_detailid.
		$this->db->query("update article_detail set atitle ='".$add_title."'where detailid = '".$detailid."'");
		
		$this->db->query("update article_detail set abody ='".$content."' where detailid = '".$detailid."'");

		// update table article.
		$this->db->query("update article set atype ='".$add_achieve."' where detailid = '".$detailid."'");


		// update table tag.r
		foreach ($array_tag as $key => $value) {
			// delete that not use.

			$tagid = $this->get_tagid($value);	

			$tagid = $tagid[0]['tagid'];
			if($tagid)
			{
				$res = $this->db->query('select aid from article_tag where tagid ='.$tagid);
				$aids = ($res->num_rows() > 0) ? $res->result_array() : FALSE;	
				if(count($aids) > 1) {
					$this->db->query('delete from tag where tagid='.$tagid);
				}
			}
			// insert new.
			$has_tag = $this->is_tag_exist($value);
			if(!$has_tag)
			{
				$data1 = array('tagbody' => $value);
				$this->db->insert('tag',$data1);
			}
		}

		// update table article_tag
		
		$this->db->query('delete from article_tag where aid = '.$aid);
		foreach ($array_tag as $key => $value) {
			$tagid = $this->get_tagid($value);	
			$tagid = $tagid[0]['tagid'];
			$this->db->query('insert into article_tag(tagid, aid) values('.$tagid.','.$aid.')');	
		}
		
		//$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		return $detailid;
	}
	public function save($add_title, $add_achieve, $array_tag, $content)
	{
		//$this->db->trans_start();
		// if the tag is existed then do not save.
		// save table tag.
		foreach ($array_tag as $key => $value) {
			$has_tag = $this->is_tag_exist($value);
			if(!$has_tag)
			{
				$data1 = array('tagbody' => $value);	
				$this->db->insert('tag',$data1);
			}
						
		}
		
		// save table article_detail.
		$data2 = array(
			'atitle' => $add_title,
			'abody' => $content,
			'atime' => date('Y-m-d')
		);
	   	$res =  $this->db->insert('article_detail',$data2);

	   	// save table article.
	    $detailids = $this->get_detailid($add_title);
		$data3 = array(
			'atype' => $add_achieve,
			'detailid' => $detailids[0]['detailid']
		);
		$this->db->insert('article', $data3);
		
		//save table article_tag.

		$aid = $this->get_aid($data3['detailid']);
		foreach ($array_tag as $key => $value) {
			$tagid = $this->get_tagid($value);

			$data4 = array(
				'tagid' => $tagid[0]['tagid'],
				'aid' => $aid[0]['aid']
			);
			$res = $this->db->insert('article_tag', $data4);
		}
	    //$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		return $data3['detailid'];

	}

	public function delete_by_detailid($detailid)
	{

		$title = $this->get_title($detailid);
		$title = $title[0]['atitle'];

		$aid = $this->get_aid($detailid);
		$aid = $aid[0]['aid'];

		$tagid = $this->get_tagid_by_aid($aid);
		$tagid = $tagid[0]['tagid'];

		$this->db->trans_start();

		$test = $this->db->delete('article_detail', array('atitle' => $title));
		
		$this->db->delete('article', array('aid' => $aid));

		$this->db->delete('article_tag', array('aid' => $aid));

		// 如果没有其他的文章在用这个ｔａｇ，则删除.
		if(!$this->has_tagid($aid))
		{
			$this->db->delete('tag', array('tagid' => $tagid));
		}

		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}

		$last_detailid = $this->get_last_detailid();
		
		return $last_detailid;

	}
	public function get_content($detailid)
	{
		$res = $this->db->query('select abody from article_detail where detailid = '. $detailid);
		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;	
	}
	public function get_tag($detailid)
	{
		$res = $this->db->query('select tagbody from tag where tagid in (select tagid from article_tag where aid in (select aid from article where detailid ='.$detailid.'))');
		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;
	}
	public function get_type($detailid)
	{	
		$res = $this->db->query('select a.atype from article as a inner join article_detail as ad  using(detailid) where ad.detailid = '.$detailid);
		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;	
	}

	public function get_title($detailid)
	{
		$this->db->select('atitle');
		$this->db->where('detailid', $detailid);
		$query = $this->db->get('article_detail');
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;	
	}
	private function get_last_detailid()
	{
		$res = $this->db->query('select detailid from article_detail order by atime desc  limit 1');
		return ($res->num_rows() > 0) ?
					$res->result_array() : FALSE;	
	}
	
	private function get_detailid($title)
	{

	    $this->db->select('detailid');
		$this->db->where('atitle', $title);
		$query = $this->db->get('article_detail');
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;	
	}
	private function get_tagid($tagbody)
	{

	    $this->db->select('tagid');
		$this->db->where('tagbody', $tagbody);
		$query = $this->db->get('tag');
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;	
	}
	private function get_tagid_by_aid($aid)
	{
		$this->db->select('tagid');
		$this->db->where('aid', $aid);
		$query = $this->db->get('article_tag');
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;	
	}
	
	private function get_aid($detailid)
	{

	    $this->db->select('aid');
		$this->db->where('detailid', $detailid);
		$query = $this->db->get('article');
		return ($query->num_rows() > 0) ?
					$query->result_array() : FALSE;	
	}

}
?>