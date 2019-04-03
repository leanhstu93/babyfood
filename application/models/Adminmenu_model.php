<?php 
class Adminmenu_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
	}

	public function get_list($id)
	{
		$idcache = md5('admin_menu_'.$id);
		$result = $this->cache->get($idcache);
		if(!$result){
			$this->db->order_by('parentid ASC, sort ASC');
			$query = $this->db->get_where('mn_adminmenu',array("parentid"=>$id,"ticlock"=>0));
			$result =  $query->result();
			$this->cache->save($idcache, $result, 60*60*24*7);
		}
		return $result;
	}
	public function list_data($limit,$skip)
	{
		//$this->db->cache_on();
		$this->db->order_by('parentid ASC, sort ASC');
		$query = $this->db->get('mn_adminmenu',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_adminmenu');	

	}
	public function get_where($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_adminmenu',array("Id"=>$id));
		return $query->result_array();
	}
	public function add(){
		$data['title_vn'] = $this->input->post('title_vn');
		$data['route'] = $this->input->post('route');
		$data['parentid'] = $this->input->post('parentid');
		$data['sort'] = $this->input->post('sort');
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['images'] = $this->input->post('images');
		return $this->db->insert('mn_adminmenu', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_adminmenu', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['title_vn'] = $this->input->post('title_vn');
			$data['route'] = $this->input->post('route');
			$data['parentid'] = $this->input->post('parentid');
			$data['sort'] = $this->input->post('sort');
			$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['images'] = $this->input->post('images');
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_adminmenu', $data); 
		return $result;
	}
}