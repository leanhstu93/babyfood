<?php 
class Catdeal_model extends CI_Model {
	
	public function __construct()
	{
		 //parent::__construct();
		$this->load->database();
	}
	
	public function list_data($limit,$skip)
	{
		//$this->db->cache_on();
		$this->db->order_by('Id',"DESC"); 
		$query = $this->db->get('mn_catdeal',$limit,$skip);
		return $query->result_array();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_catdeal');	

	}
	public function get_list($where,$order = "sort ASC, Id DESC",$limit=1,$skip=0)
	{
		//$this->db->cache_on();
		$this->db->order_by($order);
		$query = $this->db->get_where('mn_catdeal',$where,$limit,$skip);
		return $query->result_array();
	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_catdeal',array("Id"=>$id));
		return $query->result_array();
	}
	public function add($data){
		
		$data['parentid'] = $this->input->post('parentid');
		$data['title_vn'] = $this->input->post('title_vn');
		$data['alias'] = $this->input->post('alias');
		if(empty($data['alias'])){
			$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
		}else{
			$data['alias'] = $this->input->post('alias');
		}
		$data['tag'] = $this->input->post('tag');
		$data['title'] = $this->input->post('title');
		$data['meta_keyword'] = $this->input->post('meta_keyword');
		$data['meta_description'] = $this->input->post('meta_description');
		$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['date'] = time(); 
		$data['description_vn'] = $this->input->post('description_vn');

		return $this->db->insert('mn_catdeal', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_catdeal', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['parentid'] = $this->input->post('parentid');
			$data['title_vn'] = $this->input->post('title_vn');
			$data['alias'] = $this->input->post('alias');
			if(empty($data['alias'])){
				$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
			}else{
				$data['alias'] = $this->input->post('alias');
			}
			$data['tag'] = $this->input->post('tag');
			$data['title'] = $this->input->post('title');
			$data['meta_keyword'] = $this->input->post('meta_keyword');
			$data['meta_description'] = $this->input->post('meta_description');
			$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['description_vn'] = $this->input->post('description_vn');
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_catdeal', $data); 
		return $result;
		
	}
	
}