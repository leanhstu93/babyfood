<?php 
class Tvuser_model extends CI_Model {
	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
	}
	public function get_user($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('tv_user',array("id"=>$id),1,0);
		$result =  $query->result_array();
		return $result;

	}
	public function get_one_user($id)
	{
		$sql = "SELECT tv_user.*,(SELECT COUNT(mn_product.Id) FROM mn_product WHERE mn_product.iduser = tv_user.id) AS total FROM tv_user WHERE  id ='".$id."'";
		$query = $this->db->query($sql);
		$result =  $query->result_array();
		return $result;
	}

  	public function get_query($sql)
	{
		$query = $this->db->query($sql);
		return $query->result_array(); 
	}
	public function count_all()
	{
		return $this->db->count_all('tv_user');	
	}
	
	public function get_where($where)
	{	
		$query = $this->db->get_where('tv_user',$where);
		$result =  $query->result_array();
		return $result;
	}
	public function get_once_percent($id)
	{	
		$query = $this->db->get_where('mn_catpercent',array('Id'=>$id));
		$result =  $query->result_array();
		return $result;
	}
	public function count_where($where)
	{
		$this->db->where($where);
		$this->db->from('tv_user');
		return $this->db->count_all_results();
	}
	public function update($id,$data)
	{
		
		$this->db->where('id', $id);
		$result = $this->db->update('tv_user', $data); 
		return $result;
	}
	public function delete($id){
		
		return $this->db->delete('tv_user', array('id' => $id)); 
	}
	public function update_thunhap($id,$thunhap,$task=true){
		$this->db->where('id', $id);
		if($task==true){
			$this->db->set('tongthunhap', '`tongthunhap`+'.$thunhap, FALSE); 
			$this->db->set('thunhap', '`thunhap`+'.$thunhap, FALSE); 
		}else{
			$this->db->set('tongthunhap', '`tongthunhap`-'.$thunhap, FALSE); 
			$this->db->set('thunhap', '`thunhap`-'.$thunhap, FALSE); 
		}
		$kq = $this->db->update('tv_user'); 
		return $kq;
	}
	public function update_hoahong($id,$hoahong,$task=true){
		$this->db->where('id', $id);
		if($task==true){
			$this->db->set('tongthunhap', '`tongthunhap`+'.$hoahong, FALSE); 
			$this->db->set('hoahong', '`hoahong`+'.$hoahong, FALSE); 
		}else{
			$this->db->set('tongthunhap', '`tongthunhap`-'.$hoahong, FALSE); 
			$this->db->set('hoahong', '`hoahong`-'.$hoahong, FALSE); 
		}
		$kq = $this->db->update('tv_user'); 
		return $kq;
	}
	public function update_tongdonhang($id,$task=true){
		$this->db->where('id', $id);
		if($task==true){
			$this->db->set('tongdonhang', '`tongdonhang`+1', FALSE);
		}else{
			$this->db->set('tongdonhang', '`tongdonhang`-1', FALSE);
		}
		$kq = $this->db->update('tv_user'); 
		return $kq;
	}
}

       