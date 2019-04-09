<?php 
class Partners_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
	}


	public function list_data($limit,$skip)
	{
		$query = $this->db->get('mn_partners',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_partners');	

	}
	public function get_query($sql,$limit = 0,$skip)
	{
		if($skip=="") $skip = 0;
		$sql  .=" LIMIT ".$skip.",".$limit;
		$query = $this->db->query($sql);
		return $query->result();	
	}
	public function count_query($sql)
	{
		$query = $this->db->query($sql);
		$result = $query->result_array();	
		return $result[0]['total'];
	}
	public function get_where($id)
	{
		$query = $this->db->get_where('mn_partners',array("Id"=>$id));
		return $query->result_array();
	}
	public function get_Arr($arr)
	{
		$query = $this->db->get_where('mn_partners',$arr);
		return $query->result_array();
	}
	public function add(){
		$data['title_vn'] = $this->input->post('title_vn');
		$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['sort'] = (int)$this->input->post('sort');
		return $this->db->insert('mn_partners', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_partners', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['title_vn'] = $this->input->post('title_vn');
			$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['sort'] = (int)$this->input->post('sort');
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_partners', $data); 
		return $result;
	}
}