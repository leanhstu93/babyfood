<?php 
class Commentpayment_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 //parent::__construct();
		$this->load->database();
	}
	public function get_list($where,$order = "Id ASC",$limit=1,$skip=0)   
	{
		//$this->db->cache_on();
		$this->db->order_by($order);
		$query = $this->db->get_where('mn_comment_payment',$where,$limit,$skip);
		return $query->result_array();
	}
	public function get_like($tukhoa)
	{
		//$this->db->cache_on();
		$this->db->like('title_vn', $tukhoa);
		$this->db->order_by("views DESC");
		$this->db->limit(100); 
		$query = $this->db->get('mn_comment_payment'); 
		return $query->result_array();
	}
	public function list_data($limit,$skip)
	{
		//$this->db->cache_on();
		$this->db->order_by('views',"DESC"); 
		$query = $this->db->get('mn_comment_payment',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_comment_payment');	

	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_comment_payment',array("Id"=>$id));
		return $query->result_array();
	}
	public function add($data){
		return $this->db->insert('mn_comment_payment', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_comment_payment', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_comment_payment', $data); 
		return $result;
	}
	public function countview($id){
		$this->db->where('Id', $id);
		$this->db->set('views', '`views`+1', FALSE);
		$kq = $this->db->update('mn_comment_payment'); 
		return $kq;
	}
	
	
}
?>