<?php 
class Discount_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
	}
	
	public function get_one_user($id)
	{
		$sql = "SELECT mn_user.*,(SELECT COUNT(mn_product.Id) FROM mn_product WHERE mn_product.iduser = mn_user.id) AS total FROM mn_user WHERE  id ='".$id."'";
		$query = $this->db->query($sql);
		$result =  $query->result_array();
		return $result;
	}
	public function check_code($id, $code)
	{	
		$this->db->select('mn_discount.voucher, mn_discount.value, mn_discount.user_id, mn_voucher.code, mn_voucher.status, mn_voucher.start_day, mn_voucher.end_day, mn_voucher.price');
		$this->db->from('mn_discount');
		$this->db->join('mn_voucher', 'mn_discount.code = mn_voucher.code');
		$this->db->where('mn_discount.user_id', $id);
		$this->db->where('mn_voucher.code', $code);
		$query = $this->db->get();
		return  $query->row_array();
	}
	public function update_status_voucher($code,$data)
	{
		$this->db->where('code', $code);
		$result = $this->db->update('mn_voucher', $data); 
		return $result;
	}
	public function get_code($code)
	{
		$this->db->where('code', $code);
		$result = $this->db->get('mn_voucher'); 
		return $result->row_array();
	}
	public function count_query($sql)
	{
		$query = $this->db->query($sql);
		return $query->row_array();	
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
	public function get_voucher_type_by_id($id){
		$query = $this->db->get_where('mn_voucher_type', array('id' => $id, 'status'=>1));
		return $query->row_array();
		
	}
	
	public function insert_voucher($data){
		$this->db->insert('mn_voucher', $data);
		return $this->db->insert_id();
	}
 	public function add($data){
		$this->db->insert('mn_discount', $data);
		return $this->db->insert_id();
	}
	public function update($id,$data)
	{
		$this->db->where('id', $id);
		$result = $this->db->update('mn_discount', $data); 
		return $result;
	}

	public function get_by_value($value){
		$start_day = strtotime(date('Y-m-d 00:00:00', time()));
		$end_day = strtotime(date('Y-m-d 23:59:59', time()));
		$this->db->select('id');
		$this->db->where('value',$value);
		$this->db->where("( created >= $start_day AND `created` <= $end_day )");
		$this->db->from('mn_discount');
		$query = $this->db->get();
		return $query->num_rows();
	}
}

       