<?php 
class Provinces_model extends CI_Model {
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
		$query = $this->db->get('mn_provinces',$limit,$skip);
		return $query->result();
	}
	public function getdata($where)
	{
		$query = $this->db->get_where('mn_provinces',$where);
		return $query->result_array();
	}
	public function list_district($where)
	{
		$query = $this->db->get_where('mn_district',$where);
		return $query->result_array();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_provinces');	

	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_provinces',array("Id"=>$id));
		return $query->result_array();
	}
	public function add(){
		if($data['alias'] == ""){
			$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
		}else{
			$data['alias'] = $this->input->post('alias');
		}
		$data['title_vn'] = $this->input->post('title_vn');
		$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		return $this->db->insert('mn_provinces', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_provinces', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['title_vn'] = $this->input->post('title_vn');
		$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_provinces', $data); 
		return $result;
	}
	
}