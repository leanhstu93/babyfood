<?php 
class Discount_code_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
	}
	public function check_code_discount($code){
		
		$query = $this->db->get_where('mn_code_discount', array('code' => $code));
		return $query->row_array();
	}
	public function check_code($code)
	{	
		$this->db->select('mn_deal.discount_code, mn_code_discount.start_day, mn_code_discount.end_day, mn_code_discount.type, mn_code_discount.ticlock');
		$this->db->from('mn_deal');
		$this->db->join('mn_code_discount', 'mn_deal.discount_code = mn_code_discount.code');
		$this->db->where('mn_deal.discount_code', $code);
		$query = $this->db->get();
		return  $query->row_array();
	}
	
	public function update_code_type($id,$data)
	{
		$this->db->where('id', $id);
		$result = $this->db->update('mn_deal', $data); 
		return $result;
	}
	public function update_code_type_product($id,$data)
	{
		$this->db->where('id', $id);
		$result = $this->db->update('mn_product', $data); 
		return $result;
	}
	public function get_query($sql,$limit = 1,$skip = 0)
	{
		if($skip=="") $skip = 0;
		$sql  .=" LIMIT ".$skip.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	public function count_where($where)
	{
		$query = $this->db->get_where('mn_code_discount',$where);
		$result = $query->num_rows();
		return $result;
	}
	
	public function count_query($sql)
	{
		$query = $this->db->query($sql);
		$result = $query->result_array();	
		if(empty($result)) return 0;
		return $result[0]['total'];
	}
	public function count_all()
	{
		return $this->db->count_all('mn_user');	

	}
	
	public function get_where($id)
	{	
		$query = $this->db->get_where('mn_code_discount',array("id"=>$id));
		return $query->row_array();
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
		$data['code'] = $this->input->post('code');
		$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):'0';
		$data['type'] = $this->input->post('type');
		$data['created'] = time();
		$data['start_day'] = $this->input->post('start_day');
		$data['end_day'] = $this->input->post('end_day');
		$this->db->insert('mn_code_discount', $data);
		return $this->db->insert_id();
	}
	public function update($id,$data, $option = false)
	{
		if($option==true){
			$data['code'] = $this->input->post('code');
			$data['type'] = $this->input->post('type');
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):0;
			$data['start_day'] = $this->input->post('start_day');
			$data['end_day'] = $this->input->post('end_day');
		}
		$this->db->where('id', $id);
		$result = $this->db->update('mn_code_discount', $data); 
		return $result;
	}
	
	public function delete($id){
		
		return $this->db->delete('mn_code_discount', array('Id' => $id)); 
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

       