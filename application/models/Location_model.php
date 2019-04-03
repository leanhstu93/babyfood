<?php 
class Location_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 //parent::__construct();
		$this->load->database();
	}
	
	public function list_data($limit,$skip)
	{
		//$this->db->cache_on();
		$query = $this->db->get('mn_location',$limit,$skip);
		return $query->result();
	}
	public function getdata($where)
	{
		$query = $this->db->get_where('mn_location',$where);
		return $query->result_array();
	}
	public function list_district($where)
	{
		$query = $this->db->get_where('mn_district',$where);
		return $query->result_array();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_location');	

	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_location',array("Id"=>$id));
		return $query->result_array();
	}
	public function add(){
		$data['title'] = $this->input->post('title');
		$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['created'] = time();
		return $this->db->insert('mn_location', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_location', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
		$data['title'] = $this->input->post('title');
		$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['modified'] = time();
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_location', $data); 
		return $result;
	}
	
}