<?php 
class Voucher_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
	}
	public function get_all_data( $limit =0, $skin){
		
		$sql="SELECT *, (SELECT user_id FROM mn_discount WHERE mn_discount.code = mn_voucher.code) AS userid, (SELECT username FROM mn_user WHERE mn_user.id = userid) as username, (SELECT email FROM mn_user WHERE mn_user.id = userid) as email, (SELECT fullname FROM mn_user WHERE mn_user.id = userid) as fullname FROM mn_voucher limit ".$limit.", ".$skin." ";
		$query = $this->db->query($sql);	
		return $query->result_array();
	}
	
  	public function get_query($sql, $limit = 0,$skip, $task=FALSE,$arr = FALSE)
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
	
	public function get_where($where,$limit = 10,$skip=0,$order=false)
	{	
		if($order!=false){
			$this->db->order_by($order);
		}
		$query = $this->db->get_where('mn_voucher',$where,$limit,$skip);
		$result =  $query->result_array();
		return $result;
	}
    public function get_voucher_type($id) {
        return $this->db->where('id', $id)->get('mn_voucher_type')->row_array();
    }
	public function get_id_edit($id){
		$sql = 'SELECT *, (SELECT user_id FROM mn_discount WHERE mn_discount.code = mn_voucher.code) AS userid, (SELECT username FROM mn_user WHERE mn_user.id = userid) as username, (SELECT email FROM mn_user WHERE mn_user.id = userid) as email FROM mn_voucher WHERE id="'.$id.'"';
		$query = $this->db->query($sql);
		return $query->row_array();	
	}
	public function count_where($where)
	{
		$this->db->where($where);
		$this->db->from('mn_user');
		return $this->db->count_all_results();
	}
 	public function add($data){
		$this->db->insert('mn_voucher', $data);
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
		
		return $this->db->delete('mn_voucher', array('id' => $id)); 
	}
	
}

       