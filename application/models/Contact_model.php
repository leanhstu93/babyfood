<?php 
class Contact_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
		
	}
	
	public function get_where($where,$limit = 10,$skip=0)
	{
		$this->db->cache_off();
		$query = $this->db->get_where('mn_contact',$where,$limit,$skip);
		$result =  $query->result_array();	
		return $result;
	}
  	public function get_query($sql,$limit = 0,$skip)
	{
		if($skip=="") $skip = 0;
		$sql  .=" LIMIT ".$skip.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	public function get_Id($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_contact',array("Id"=>$id));
		return $query->result_array();
	}
	public function count_query($sql)
	{
		$query = $this->db->query($sql);
		$result = $query->result_array();	
		return $result[0]['total'];
	}
	public function count_all()
	{
		return $this->db->count_all('mn_contact');	

	}
	public function delete($id){
		
		return $this->db->delete('mn_contact', array('Id' => $id)); 
	}
	
    public function update($id,$data,$option = false)
	{
	
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_contact', $data); 
		return $result;
	 }
	 public function add($data){
		return $this->db->insert('mn_contact', $data);
	}

}

       