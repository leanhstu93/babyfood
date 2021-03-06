<?php 
class District_model extends CI_Model {

	public function __construct()
	{
		 //parent::__construct();
		$this->load->database();
	}
	
	public function list_data($limit,$skip)
	{
		//$this->db->cache_on();
		$query = $this->db->get('mn_district',$limit,$skip);
		return $query->result();
	}
	public function list_district($where)
	{
		$query = $this->db->get_where('mn_district',$where);
		return $query->result_array();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_district');	

	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_district',array("Id"=>$id));
		return $query->result_array();
	}
	public function add(){
		
		$data['idcat'] = $this->input->post('idcat');
		$data['title_vn'] = $this->input->post('title_vn');
		$data['ship'] = str_replace(".","",$this->input->post('ship'));
		$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		return $this->db->insert('mn_district', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_district', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['title_vn'] = $this->input->post('title_vn');
			$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
			$data['idcat'] = $this->input->post('idcat');
			$data['ship'] = str_replace(".","",$this->input->post('ship'));
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_district', $data); 
		return $result;
	}
	
}