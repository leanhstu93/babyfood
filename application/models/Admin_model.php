<?php 
class Admin_model extends CI_Model {
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
		$query = $this->db->get('mn_admin',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_admin');	

	}
	public function get_where($id)
	{
		$query = $this->db->get_where('mn_admin',array("Id"=>$id));
		return $query->result_array();
	}
	public function get_Arr($arr)
	{
		$query = $this->db->get_where('mn_admin',$arr);
		return $query->result_array();
	}
	public function add(){
		$data['username'] = $this->input->post('username');
		$data['password'] = $this->page->gen_pass($this->input->post('password'));
		$data['email'] = $this->input->post('email');
		$data['level'] = $this->input->post('level');
		$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['time'] = time();
		$data['fullname'] = $this->input->post('fullname');
		$data['address'] = $this->input->post('address');
		$data['note'] = $this->input->post('note');
		return $this->db->insert('mn_admin', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_admin', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['username'] = $this->input->post('username');
			if($this->input->post('password')){
				$data['password'] = $this->page->gen_pass($this->input->post('password'));
			}
			$data['email'] = $this->input->post('email');
			$data['level'] = $this->input->post('level');
			$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['time'] = time();
			$data['fullname'] = $this->input->post('fullname');
			$data['address'] = $this->input->post('address');
			$data['note'] = $this->input->post('note');
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_admin', $data); 
		return $result;
	}
}