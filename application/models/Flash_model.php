<?php 
class Flash_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
	}


	public function list_data($limit,$skip,$where = "")
	{
		if(!empty($where)){
			$this->db->where($where);
		}
		$this->db->order_by("sort ASC, Id DESC"); 
		$query = $this->db->get('mn_flash',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_flash');	

	}
	public function get_where($id)
	{
		$this->db->order_by("sort ASC, Id DESC"); 
		$query = $this->db->get_where('mn_flash',array("Id"=>$id));
		return $query->result_array();
	}
	
	public function add($data = null){
		$data['location'] = $this->input->post('location');
		$data['link'] = $this->input->post('link');
		$data['width'] = $this->input->post('width');
		$data['height'] = $this->input->post('height');
		$data['sort'] =$this->input->post('sort');
		$data['style'] = $this->input->post('style');
		$data['position'] = $this->input->post('position');
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		return $this->db->insert('mn_flash', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_flash', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['location'] = $this->input->post('location');
			$data['link'] = $this->input->post('link');
			$data['width'] = $this->input->post('width');
			$data['height'] = $this->input->post('height');
			$data['sort'] =$this->input->post('sort');
			$data['style'] = $this->input->post('style');
			$data['position'] = $this->input->post('position');
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_flash', $data); 
		return $result;
	}
}