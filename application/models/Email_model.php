<?php 
class Email_model extends CI_Model {
	public function __construct()
	{
		 //parent::__construct();
		$this->load->database();
	}
	public function get_list($where,$order = "Id DESC",$limit=1,$skip=0)   
	{
		//$this->db->cache_on();
		$this->db->order_by($order);
		$query = $this->db->get_where('mn_email',$where,$limit,$skip);
		return $query->result_array();
	}
	public function get_like($tukhoa)
	{
		//$this->db->cache_on();
		$this->db->like('email', $tukhoa);
		$this->db->order_by("Id DESC");
		$this->db->limit(100); 
		$query = $this->db->get('mn_email'); 
		return $query->result_array();
	}
	public function list_data($limit,$skip)
	{
		//$this->db->cache_on();
		$this->db->order_by('Id',"DESC"); 
		$query = $this->db->get('mn_email',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_email');	

	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_email',array("Id"=>$id));
		return $query->result_array();
	}
	public function add($data){
		return $this->db->insert('mn_email', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_email', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_email', $data); 
		return $result;
	}	
}
?>