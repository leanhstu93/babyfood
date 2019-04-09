<?php 
class Bmenu_model extends CI_Model {
	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
	}


	public function list_data($limit,$skip)
	{
		$query = $this->db->get('mn_bmenu',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_bmenu');	

	}
	public function get_list()
	{
		$query = $this->db->get_where('mn_bmenu',array('ticlock'=>'0'));
		$result =  $query->result_array();
		return $result;
	}
	public function get_where($id)
	{
		$query = $this->db->get_where('mn_bmenu',array("Id"=>$id));
		return $query->result_array();
	}
	public function get_Arr($arr)
	{
		$this->db->order_by("sort ASC, Id ASC"); 
		$query = $this->db->get_where('mn_bmenu',$arr);
		return $query->result_array();
	}
	public function add($data){
		$data['parentid'] = $this->input->post('parentid');
		$data['style'] = $this->input->post('style');
		$data['sort'] = (int)$this->input->post('sort');
		$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['link'] = $this->input->post('link');
		return $this->db->insert('mn_bmenu', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_bmenu', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['parentid'] = $this->input->post('parentid');
			$data['style'] = $this->input->post('style');
			$data['sort'] = (int)$this->input->post('sort');
			$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['link'] = $this->input->post('link');
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_bmenu', $data); 
		return $result;
	}
}