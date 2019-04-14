<?php 
class Pagehtml_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 //parent::__construct();
		$this->load->database();
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
	public function get_public($id)
	{
		$idcache = md5('page_html_'.$id);
		$result = $this->cache->get($idcache);
		if(!$result){
			$query = $this->db->get_where('mn_pagehtml',array("Id"=>$id));
			$result =  $query->result_array();
			$this->cache->save($idcache, $result, 60*60*2);
		}
		return $result;
	}
	
	public function get_banner($id)
	{	
		$this->db->order_by("id ASC"); 
		$query = $this->db->get_where('mn_flash',array("location"=>$id,"ticlock"=>"0", "position"=>'1'),3,0);
		return $result =  $query->result_array();
		
	}
	public function get_baner_hot($id)
	{	
		$this->db->order_by("id ASC"); 
		$query = $this->db->get_where('mn_flash',array("location"=>$id,"ticlock"=>"0", "position"=>'2'),1,0);
		return $result =  $query->row_array();
		
	}
	public function getListProuctHot($arr,$limit=0)
	{	
		$sql = "SELECT * FROM mn_product WHERE idcat IN (".$arr.") AND status = 0 AND ticlock=0 AND xh=1 AND trash=0 ORDER BY Id DESC ";
		if($limit>0) 
			$sql .= " LIMIT 0,".$limit;
		$query = $this->db->query($sql);
		$result =  $query->result_array();
		return $result;
	}
    public function getListProuct()
    {
        $sql = "SELECT * FROM mn_product WHERE ticlock=0 ORDER BY Id DESC ";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result;
    }
	public function get_on_location($id)
	{
		$idcache = md5('flash_location_'.$id);
		$result = $this->cache->get($idcache);
		if(!$result){
			$query = $this->db->get_where('mn_flash',array("location"=>$id,"ticlock"=>"0"),1,0);
			$result =  $query->result_array();
			$this->cache->save($idcache, $result, 60*60*2);
		}
		if(empty($result)) return $result;
		
		return $result[0];
	}
	public function get_on_list_location($id,$limit) 
	{
		$idcache = md5('flash_list_location_'.$id);
		$result = $this->cache->get($idcache);
		if(!$result){
			$this->db->order_by("sort ASC, Id DESC"); 
			$query = $this->db->get_where('mn_flash',array("location"=>$id,"ticlock"=>"0"),$limit,0);
			$result =  $query->result_array();
			$this->cache->save($idcache, $result, 60*60*2);
		}
		return $result;
	}
	public function get_on_list_weblink($where,$limit) 
	{
		
		$idcache = md5('list_on_weblink_'.json_encode($where)."_".$limit);
		$result = $this->cache->get($idcache);
		if(!$result){
			$this->db->order_by("sort ASC, Id ASC"); 
			$query = $this->db->get_where('mn_weblink',$where,$limit,0);
			$result =  $query->result_array();
			$this->cache->save($idcache, $result, 60*60*2);
		}
		return $result;
	}
	public function get_once_catelog($id=0)
	{	
		$idcache = md5('catelog_'.$id);
		$this->db->order_by("sort ASC, Id DESC"); 
		$query = $this->db->get_where('mn_catelog',array("Id"=>$id, ),1,0);
		$result =  $query->result_array();
		return $result;
	}
	
	public function get_code_discount_all()
	{	
		$this->db->order_by("id ASC"); 
		$query = $this->db->get_where('mn_code_discount',array("ticlock"=>0));
		$result =  $query->result_array();
		return $result;
	}
	
	public function get_location_all()
	{	
		$this->db->order_by("id ASC"); 
		$query = $this->db->get_where('mn_location',array("ticlock"=>0));
		$result =  $query->result_array();
		return $result;
	}
	public function get_once_location($id)
	{	
		$query = $this->db->get_where('mn_location',array("id"=>$id, "ticlock"=>0));
		$result =  $query->row_array();
		return $result;
	}
	
	
	public function get_provinces()
	{
		$idcache = md5('provinces_list_all');
		$result = $this->cache->get($idcache);
		if(!$result){
			$this->db->order_by("sort ASC, Id DESC"); 
			$query = $this->db->get_where('mn_provinces',array('ticlock'=>'0'));
			$result =  $query->result_array();
			$this->cache->save($idcache, $result, 60*60*2);
		}
		if(empty($result)) return $result;
		return $result;
	}
	public function get_one_provinces($id=0)
	{	
		$idcache = md5('get_one_provinces_'.$id);
		$result = $this->cache->get($idcache);
		if(!$result){
			$this->db->order_by("sort ASC, Id DESC"); 
			$query = $this->db->get_where('mn_provinces',array("Id"=>$id, "ticlock"=>0));
			$result =  $query->result_array();
			$this->cache->save($idcache, $result, 60*60*2);
		}
		return $result;
	}
	
	public function get_website($id)
	{
		$idcache = md5('website_'.$id);
		$result = $this->cache->get($idcache);
		if(!$result){
			$query = $this->db->get_where('mn_website',array("Id"=>$id),1,0);
			$result =  $query->result_array();
			$this->cache->save($idcache, $result, 60*60*2);
		}
		if(empty($result)) return $result;
		return $result[0];
	}
	public function get_catelog($id=0,$limit=10000)
	{	
		$idcache = md5('list_sub_catelog_'.$id.'_'.$limit);
		$result = $this->cache->get($idcache);
		if(!$result){	
			$this->db->order_by("sort ASC, Id DESC"); 
			$query = $this->db->get_where('mn_catelog',array("parentid"=>$id, "ticlock"=>0),$limit,0);
			$result =  $query->result_array();
			$this->cache->save($idcache, $result, 60*60*2);
		}
		return $result;
	}
	public function get_catdeal($id=0,$limit=10000)
	{	

		$this->db->order_by("sort ASC, Id DESC"); 
		$query = $this->db->get_where('mn_catdeal',array("parentid"=>$id, "ticlock"=>0),$limit,0);
		$result =  $query->result_array();
		return $result;
	}
	public function mb_cate($id=0,$limit=10000)
	{	
		$this->db->order_by("sort ASC, Id DESC"); 
		$query = $this->db->get_where('mn_catelog',array("parentid"=>$id, "ticlock"=>0, 'home ' =>1),$limit,0);
		$result =  $query->result_array();
		return $result;
	}
	public function get_menu($id=0,$limit= 0)
	{	
		if($limit>0)
			$this->db->limit($limit, 0);
		$this->db->order_by("sort ASC, Id DESC"); 
		$query = $this->db->get_where('mn_menu',array("parentid"=>$id, "ticlock"=>0));
		$result =  $query->result_array();
		return $result;
	}
	public function get_catnews($where,$limit=3)
	{	
		
		$this->db->order_by("sort ASC, Id DESC"); 
		$this->db->order_by("sort ASC, Id DESC");
		$query = $this->db->get_where('mn_catnews',$where,$limit,0);
		$result =  $query->result_array();
		return $result;
	}
	public function get_newsidcat($id=0,$limit =10,$skip = 0)
	{	
		$query = $this->db->get_where('mn_news',array("idcat"=>$id,"ticlock"=>"0"),$limit,$skip);
		$result =  $query->result_array();
		return $result;
	}
	
	public function list_data($limit,$skip)
	{
		//$this->db->cache_on();
	
		$query = $this->db->get('mn_pagehtml',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_pagehtml');	

	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_pagehtml',array("Id"=>$id));
		return $query->result_array();
	}
	
	public function add($data){
		
		$data['title_vn'] = $this->input->post('title_vn');
		if($alias == ""){
			$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
		}else{
			$data['alias'] = $this->input->post('alias');
		}
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['content_vn'] = $this->input->post('content_vn');
		
		return $this->db->insert('mn_pagehtml', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_pagehtml', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$alias =  $this->input->post('alias');
			$data['title_vn'] = $this->input->post('title_vn');
			if($alias == ""){
				$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
			}else{
				$data['alias'] = $this->input->post('alias');
			}
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['content_vn'] = $this->input->post('content_vn');
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_pagehtml', $data); 
		return $result;
	}
	public function get_tv_user($id){
		$query = $this->db->get_where('tv_user',array("id"=>$id));
		return $query->result_array();
	}
	public function setcookieAbout($id){
		$idab=  (int)key($id);
		if($idab>0){
			$user = $this->get_tv_user($idab);
			if(!empty($user)){
				set_cookie('idgioithieu',$idab,60*60*24*30);
				return true;
			}else{
				return false;
			}
		}
	}
	public function get_news_most_view($limit = 10) {
		$this->db->order_by('view', 'desc');
		$query = $this->db->get_where('mn_news',array("ticlock"=>"0", 'idcat' => 10),$limit,0);
		$result =  $query->result_array();
		return $result;
	}
	public function update_news_view($news) {
		$this->db->where('Id', $news['Id'])->update('mn_news', array('view' => $news['view'] + 1));
	}
}