<?php 
class Follow_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		$this->load->database();
	}
	public function get_list($where,$order = "idpro DESC",$limit=1,$skip=0)
	{
		$this->db->order_by($order);
		$query = $this->db->get_where('mn_follow',$where,$limit,$skip);
		return $query->result_array();
	}
	public function list_data($limit,$skip)
	{
		$this->db->order_by("idpro DESC"); 
		$query = $this->db->get('mn_follow',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_follow');	

	}
	public function get_where($where)
	{
		$query = $this->db->get_where('mn_follow',$where);
		return $query->result_array();
	}
	public function add($data){
		return $this->db->insert('mn_follow', $data);
	}
	public function delete($where){
		
		return $this->db->delete('mn_follow', $where); 
	}
	public function update($where,$data)
	{
		$this->db->where($where);
		$result = $this->db->update('mn_follow', $data); 
		return $result;
	}
	public function count_where($where)
	{
		$this->db->where($where);
		$this->db->from('mn_follow');
		return $this->db->count_all_results();
	}
	
}