<?php 
class Payment_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
	}
	public function get_query($sql,$limit = 1,$skip = 0)
	{
		if($skip=="") $skip = 0;
		$sql  .=" LIMIT ".$skip.",".$limit;

		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	public function count_query($sql)
	{
		$query = $this->db->query($sql);
		$result = $query->result_array();	
		return $result[0]['total'];
	}

	public function list_data($limit,$skip)
	{
		$query = $this->db->get('mn_customer',$limit,$skip);
		return $query->result();
	}
	
	public function get_id_customer($id)
	{	$this->db->where('Id', $id);
		$query = $this->db->get('mn_customer');
		return $query->row_array();
	}
	public function check_code_voucher($oder_id)
	{	$this->db->where('order_id', $oder_id);
		$query = $this->db->get('mn_voucher');
		return $query->row_array();
	}
	public function count_all()
	{
		return $this->db->count_all('mn_customer');	

	}
	public function get_list($where)
	{
		$query = $this->db->get_where('mn_customer',$where);
		return $query->result_array();
	}
	public function get_list_cart($where)
	{
		$query = $this->db->get_where('mn_customer_cart',$where);
		return $query->result_array();
	}
	public function get_where($id)
	{
		$query = $this->db->get_where('mn_customer',array("Id"=>$id));
		return $query->result_array();
	}
	public function add($data){
		 $this->db->insert('mn_customer', $data);
		 return $this->db->insert_id();
	}
	public function addcart($data){
		 $this->db->insert('mn_customer_cart', $data);
		 return $this->db->insert_id();
	}
	public function delete($id){
		
		$this->db->delete('mn_customer', array('Id' => $id)); 
		$this->db->delete('mn_customer_cart', array('idcustomer' => $id)); 
	}
	public function update($id,$data)
	{
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_customer', $data); 
		return $result;
	}
	public function addreasoncancel($data){
		 $this->db->insert('mn_customer_reasoncancel', $data);
		 return $this->db->insert_id();
	}
}