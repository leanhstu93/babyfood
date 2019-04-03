<?php 
class User_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
	}
	public function get_user_pass($user,$pass)
	{
		$pass = md5($pass);
		$query = $this->db->get_where('mn_user',array('email'=>$user,"password"=>$pass));
		$result =  $query->result_array();
		return $result;
	}
	public function get_user($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_user',array("id"=>$id),1,0);
		$result =  $query->result_array();
		
		if(empty($result)) return $result;
		return $result[0];
	}
	public function get_one_user($id)
	{
		$sql = "SELECT mn_user.*,(SELECT COUNT(mn_product.Id) FROM mn_product WHERE mn_product.iduser = mn_user.id) AS total FROM mn_user WHERE  id ='".$id."'";
		$query = $this->db->query($sql);
		$result =  $query->result_array();
		return $result;
	}
	public function checkEmail($id)
	{
		$query = $this->db->get_where('mn_user',array("email"=>$id),1,0);
		$result =  $query->result_array();
		return $result;
	}
  	public function get_query($sql,$limit = 0,$skip,$task=FALSE,$arr = FALSE)
	{
		if($skip=="") $skip = 0; 
		if($task==FALSE){
			$sql  .=" LIMIT ".$skip.",".$limit;
		}
		$query = $this->db->query($sql);
		//echo $this->output->enable_profiler(TRUE); 
		if($arr == true) return $query->result_array(); 
		return $query->result();	
	}
	public function count_query($sql)
	{
		$query = $this->db->query($sql);
		$result = $query->result_array();	
		return $result[0]['total'];
	}
	public function count_all()
	{
		return $this->db->count_all('mn_user');	

	}
	public function sum_user($column,$where)
	{
		$this->db->select_sum($column);
		$this->db->where($where); 
		$query = $this->db->get('mn_user');
		$result = $query->result_array();	
		return $result;
	}
	public function get_where($where,$limit = 10,$skip=0,$order=false)
	{	
		if($order!=false){
			$this->db->order_by($order);
		}
		$query = $this->db->get_where('mn_user',$where,$limit,$skip);
		$result =  $query->result_array();
		return $result;
	}
	public function count_where($where)
	{
		$this->db->where($where);
		$this->db->from('mn_user');
		return $this->db->count_all_results();
	}
 	public function add($data){
		$this->db->insert('mn_user', $data);
		return $this->db->insert_id();
	}
	public function update($id,$data,$option = false)
	{
		if($option==true){
			$data['address'] = $this->input->post('address');
			$data['phone'] = $this->input->post('phone');
			$data['username'] = $this->input->post('username');
			$data['iddistrict'] = $this->input->post('iddistrict');
			$data['fullname'] = $this->input->post('fullname');
			$data['gender']	= $this->input->post('gioitinh');
			$data['idtinh']	= $this->input->post('idtinh');
			$data['level']	= $this->input->post('level');
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['lock'] =  $this->input->post('lock')?$this->input->post('lock'):0;
		}
		$this->db->where('id', $id);
		$result = $this->db->update('mn_user', $data); 
		return $result;
	}
	public function delete($id){
		
		return $this->db->delete('mn_user', array('id' => $id)); 
	}
	public function countview($id){
		$this->db->where('id', $id);
		$this->db->set('views', '`views`+1', FALSE);
		$kq = $this->db->update('mn_user'); 
		return $kq;
	}
	public function countup($id,$time){
		$this->db->where('id', $id);
		$this->db->set('up', '`up`+1', FALSE); 
		$this->db->set('date_up', $time, FALSE);
		$kq = $this->db->update('mn_user'); 
		return $kq;
	}
}

       