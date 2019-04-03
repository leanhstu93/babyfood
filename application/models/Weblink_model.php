<?php 
class Weblink_model extends CI_Model {
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
		$query = $this->db->get('mn_weblink',$limit,$skip);
		return $query->result();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_weblink');	

	}
	public function get_list()
	{
		$idcache = md5('weblink_home');
		$result = $this->cache->get($idcache);
		if(!$result){
			$query = $this->db->get_where('mn_weblink',array('ticlock'=>'0'));
			$result =  $query->result_array();
			$this->cache->save($idcache, $result, 60*60*2);
		}
		return $result;
	}
	public function get_where($id)
	{
		$query = $this->db->get_where('mn_weblink',array("Id"=>$id));
		return $query->result_array();
	}
	public function get_Arr($arr)
	{
		$query = $this->db->get_where('mn_weblink',$arr);
		return $query->result_array();
	}
	public function add($data){
		$data['parentid'] = $this->input->post('parentid');
		$data['style'] = $this->input->post('style');
		$data['layout'] = $this->input->post('layout');
		$data['iddeal'] = (int)$this->input->post('iddeal');
		$data['sort'] = (int)$this->input->post('sort');
		$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
		$data['link'] = $this->input->post('link');
		return $this->db->insert('mn_weblink', $data);
	}
	public function delete($id){
		
		return $this->db->delete('mn_weblink', array('Id' => $id)); 
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['parentid'] = $this->input->post('parentid');
			$data['style'] = $this->input->post('style');
			$data['iddeal'] = (int)$this->input->post('iddeal');
			$data['sort'] = (int)$this->input->post('sort');
			$data['layout'] = $this->input->post('layout');
			$data['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['link'] = $this->input->post('link');
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_weblink', $data); 
		return $result;
	}
}