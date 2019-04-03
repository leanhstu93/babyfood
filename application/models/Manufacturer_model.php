<?php 
class Manufacturer_model extends CI_Model {
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
		$query = $this->db->get('mn_manufacturer',$limit,$skip);
		return $query->result();
	}
	public function get_query($sql,$limit = 1,$skip = 0)
	{
		if($skip=="") $skip = 0;
		$sql  .=" LIMIT ".$skip.",".$limit;
		$query = $this->db->query($sql);
		return $query->result();	
	}
	public function count_all()
	{
		return $this->db->count_all('mn_manufacturer');	

	}
	public function get_list($id=0,$limit=1)
	{

		$query = $this->db->get_where('mn_manufacturer',array('ticlock'=>0,"idcat"=>$id),$limit,0);
		$result =  $query->result_array();
		return $result;
	}
	public function get_where($id)
	{
		$query = $this->db->get_where('mn_manufacturer',array("Id"=>$id));
		return $query->result_array();
	}
	public function get_Arr($arr)
	{
		$query = $this->db->get_where('mn_manufacturer',$arr);
		return $query->result_array();
	}
	public function add($data){
		$data['title_vn'] = $this->input->post('title_vn');
		if(empty($this->input->post('alias'))){
			$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
		}else{
			$data['alias'] = $this->input->post('alias');
		}
		$data['idcat'] = $this->input->post('idcat');
		$data['description_vn'] = $this->input->post('description_vn');
		$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['sort'] = (int)$this->input->post('sort');
		$data['date'] =  time();
		return $this->db->insert('mn_manufacturer', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_manufacturer', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['title_vn'] = $this->input->post('title_vn'); 
			if(empty($this->input->post('alias'))){
				$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
			}else{
				$data['alias'] = $this->input->post('alias');
			}
			$data['idcat'] = $this->input->post('idcat');
			$data['description_vn'] = $this->input->post('description_vn');
			$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['sort'] = (int)$this->input->post('sort');
			$data['date'] =  time();
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_manufacturer', $data); 
		return $result;
	}
}