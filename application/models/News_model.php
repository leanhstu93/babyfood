<?php 
class News_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 //parent::__construct();
		$this->load->database();
	}
	public function get_query($sql,$limit = 1,$skip = 0)
	{
		if($skip=="") $skip = 0;
		$sql  .=" LIMIT ".$skip.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	public function get_query2($sql,$limit = 1,$skip = 0)
	{
		if($skip=="") $skip = 0;
		$sql  .=" LIMIT ".$skip.",".$limit;
		$query = $this->db->query($sql);
		return $query->result();	
	}
	public function get_list($where,$order = "sort ASC, Id DESC",$limit=1,$skip=0)
	{
		//$this->db->cache_on();
		$this->db->order_by($order);
		$query = $this->db->get_where('mn_news',$where,$limit,$skip);
		return $query->result_array();
	}
	public function list_data($limit,$skip)
	{
		$this->db->order_by("sort ASC, Id DESC"); 
		$query = $this->db->get('mn_news',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_news');	

	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_news',array("Id"=>$id));
		return $query->result_array();
	}
	
	public function count_where($where)
	{
		$query = $this->db->get_where('mn_news',$where);
		$result = $query->num_rows();
		return $result;
	}
	public function add($data){
		
		$data['title_vn'] = $this->input->post('title_vn');
		$data['meta_title'] = $this->input->post('meta_title');
			$data['meta_description'] = $this->input->post('meta_description');
			$data['meta_keyword'] = $this->input->post('meta_keyword');
		if(empty($data['alias'])){
			$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
		}else{
			$data['alias'] = $this->input->post('alias');
		}
		$data['idcat'] = $this->input->post('idcat')?$this->input->post('idcat'):0;
		$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['date'] = time(); 
		$data['content_vn'] = $this->input->post('content_vn');
		$data['description_vn'] = $this->input->post('description_vn');
        $data['tag'] = $this->input->post('tag');
        
		return $this->db->insert('mn_news', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_news', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['title_vn'] = $this->input->post('title_vn');
			$data['meta_title'] = $this->input->post('meta_title');
			$data['meta_description'] = $this->input->post('meta_description');
			$data['meta_keyword'] = $this->input->post('meta_keyword');
			if(empty($data['alias'])){
				$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
			}else{
				$data['alias'] = $this->input->post('alias');
			}
			$data['idcat'] = $this->input->post('idcat')?$this->input->post('idcat'):0;
			$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			//$data['date'] = time(); 
			$data['content_vn'] = $this->input->post('content_vn');
			$data['description_vn'] = $this->input->post('description_vn');
            $data['tag'] = $this->input->post('tag');
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_news', $data); 
		return $result;
	}
	
}