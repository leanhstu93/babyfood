<?php 
class Catelog_model extends CI_Model {
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
		$this->db->order_by("sort ASC, Id DESC"); 
		$query = $this->db->get('mn_catelog',$limit,$skip);
		return $query->result_array();
	}
	
	public function count_all()
	{
		return $this->db->count_all('mn_catelog');	

	}
	function Get_details($alias){
		$this->db->select('Id');
		$this->db->from('mn_catelog');
		$this->db->where('alias',$alias);
		$query = $this->db->get();
		return $query->row();
	}
	function get_sub_menu($id){
		$this->db->select('title_vn,alias,parentid,Id');
		$this->db->from('mn_catelog');
		$this->db->where('parentid',$id);
		$query = $this->db->get();
		return $query ->result_array();
	}
	public function get_list($where,$order = "sort ASC",$limit=1,$skip=0)
	{
		//$this->db->cache_on();
		$this->db->order_by($order);
		$query = $this->db->get_where('mn_catelog',$where,$limit,$skip);
		return $query->result_array();
	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_catelog',array("Id"=>$id));
		return $query->result_array();
	}
	public function add($data){
		
		$data['parentid'] = $this->input->post('parentid');
		$data['title_vn'] = $this->input->post('title_vn');
			$data['meta_title'] = $this->input->post('meta_title');
		$data['short_title'] = $this->input->post('short_title');
		$data['alias'] = $this->input->post('alias');
		if(empty($data['alias'])){
			$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
		}else{
			$data['alias'] = $this->input->post('alias');
		}
		$data['tag'] = $this->input->post('tag');
		$data['style'] = $this->input->post('style');
		$data['title'] = $this->input->post('title');
		$data['meta_keyword'] = $this->input->post('meta_keyword');
		$data['meta_description'] = $this->input->post('meta_description');
		$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['date'] = time(); 
		$data['description_vn'] = $this->input->post('description_vn');
		$data['content'] = $this->input->post('content');

		return $this->db->insert('mn_catelog', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_catelog', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['parentid'] = $this->input->post('parentid');
			$data['title_vn'] = $this->input->post('title_vn');
			$data['meta_title'] = $this->input->post('meta_title');
			$data['alias'] = $this->input->post('alias');
			$data['short_title'] = $this->input->post('short_title');
			if(empty($data['alias'])){
				$data['alias'] = $this->page->strtoseo($this->input->post('title_vn'));
			}else{
				$data['alias'] = $this->input->post('alias');
			}
			$data['style'] = $this->input->post('style');
			$data['tag'] = $this->input->post('tag');
			$data['title'] = $this->input->post('title');
			$data['meta_keyword'] = $this->input->post('meta_keyword');
			$data['meta_description'] = $this->input->post('meta_description');
			$data['sort'] = $this->input->post('sort')?$this->input->post('sort'):0;
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['description_vn'] = $this->input->post('description_vn');
			$data['content'] = $this->input->post('content');
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_catelog', $data); 
		return $result;
		
	}
	
}