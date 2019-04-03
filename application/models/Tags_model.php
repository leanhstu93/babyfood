<?php 
class Tags_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 //parent::__construct();
		$this->load->database();
	}
	public function get_list($where,$order = "sort ASC, Id DESC",$limit=1,$skip=0)   
	{
		//$this->db->cache_on();
		$this->db->order_by($order);
		$query = $this->db->get_where('mn_tags',$where,$limit,$skip);
		return $query->result_array();
	}
	public function get_like($tukhoa)
	{
		//$this->db->cache_on();
		$this->db->like('title_vn', $tukhoa);
		$this->db->order_by("views DESC");
		$this->db->limit(100); 
		$query = $this->db->get('mn_tags'); 
		return $query->result_array();
	}
	public function list_data($limit,$skip)
	{
		//$this->db->cache_on();
		$this->db->order_by('views',"DESC"); 
		$query = $this->db->get('mn_tags',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_tags');	

	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_tags',array("Id"=>$id));
		return $query->result_array();
	}
	public function add($data){
		return $this->db->insert('mn_tags', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_tags', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_tags', $data); 
		return $result;
	}
	public function countview($id){
		$this->db->where('Id', $id);
		$this->db->set('views', '`views`+1', FALSE);
		$kq = $this->db->update('mn_tags'); 
		return $kq;
	}
	
	
}
?>