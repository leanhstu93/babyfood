<?php 
class Color_model extends CI_Model {

	public function __construct()
	{
		 //parent::__construct();
		$this->load->database();
	}
	
	public function list_data($limit,$skip)
	{
		//$this->db->cache_on();
		$query = $this->db->get('mn_color',$limit,$skip);
		return $query->result();
	}
	public function list_where($where)
	{
		$query = $this->db->get_where('mn_color',$where);
		return $query->result_array();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_color');	

	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_color',array("Id"=>$id));
		return $query->result_array();
	}
	public function add(){
		
		$data['title_vn'] = $this->input->post('title_vn');
		$data['color'] = $this->input->post('color');
		$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		return $this->db->insert('mn_color', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_color', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['title_vn'] = $this->input->post('title_vn');
			$data['color'] = $this->input->post('color');
			$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_color', $data); 
		return $result;
	}
	
}