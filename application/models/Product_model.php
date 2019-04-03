<?php 
class Product_model extends CI_Model {
	public $title;
	public $content;
	public $date;

	public function __construct()
	{
		 parent::__construct();
		$this->load->database();
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
  	public function get_query($sql,$limit  = NULL,$skip  = NULL)
	{
		if($limit>0)
			$sql  .=" LIMIT ".$skip.",".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	public function get_product($id,$sale_price = '', $toprice = ''){
		$this->db->select('*');
		$this->db->from('mn_product');
		$this->db->where_in('idcat',$id);
		$this->db->where('ticlock',0);
		$this->db->where('trash',0);
		$this->db->where('status',0);
		$this->db->where('sale_price >=',$sale_price);
		$this->db->where('sale_price<=',$toprice);
		$this->db->order_by('sort','ASC');
		$this->db->order_by('Id','DESC');
		$query = $this->db->get();
		return $query -> result_array();
		
	}
	public function cout_product($id,$sale_price = '', $toprice = ''){
		$this->db->select('*');
		$this->db->from('mn_product');
		$this->db->where_in('idcat',$id);
		$this->db->where('ticlock',0);
		$this->db->where('trash',0);
		$this->db->where('status',0);
		$this->db->where('sale_price >=',$sale_price);
		$this->db->where('sale_price<=',$toprice);
		$query = $this->db->get();
		return $query -> num_rows();
	}
	/*
	function get_all_product($limit, $start){
		$this->db->select('*');
		$this->db->from('mn_product');
		$this->db->limit($limit, $start);
        $query = $this->db->get();
		return $query->result_array();	
	}*/
	public function check_price_sales($id){
		$this->db->select('id, hot, sale_price');
		$this->db->where('id', $id);
		$quyery = $this->db->get('mn_product');
		return $quyery->result_array();	
	}
	public function check_price_deal_sales($id){
		$this->db->select('id, hot, sale_price');
		$this->db->where('id', $id);
		$quyery = $this->db->get('mn_deal');
		return $quyery->result_array();	
	}
	
	public function count_where($where)
	{
		$query = $this->db->get_where('mn_product',$where);
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
		return $this->db->count_all('mn_product');	

	}
	public function update_user($id,$iduser,$data)
	{
		$this->db->where('iduser', $iduser);
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_product', $data); 
		return $result;
	 }
	public function count_user($id){
		$this->db->where("iduser",$id);
		$this->db->where("trash",0);
		$this->db->from('mn_product');
		$result = $this->db->count_all_results();
		return $result;	
	}
	public function rand_product($iduser,$limit)
	{
		$idcache = md5('rand_product_'.$iduser."_".$limit);
		$result = $this->cache->get($idcache);
		if(!$result){
			$this->db->order_by("rand()");
			$query = $this->db->get_where('mn_product',array('ticlock'=>'0','iduser'=>$iduser),$limit,0);
			$result =  $query->result_array();
			$this->cache->save($idcache, $result, 60*60*4);
		}
		return $result;
	}
	public function get_Id($id)
	{
		//$this->db->cache_off();
		$query = $this->db->get_where('mn_product',array("Id"=>$id));
		return $query->result_array();
	}
	public function getAlias($id)
	{
		$query = $this->db->get_where('mn_product',array("alias"=>$id),1,0);
		return $query->result_array();
	}
	public function list_data($where,$limit=50,$skip = 0,$orderby = "Id DESC")
	{
		if(!empty($where))
			$this->db->order_by($orderby);
		$query = $this->db->get_where('mn_product',$where,$limit,$skip);
		$result =  $query->result_array();
		return $result;
	}
	
	public function add($data,$task = false){
		if($task==true){
			$data['title_vn'] = $this->input->post('title_vn');
			$data['meta_title'] = $this->input->post('meta_title');
			if(!$this->input->post('alias')){
				$data['alias'] = $this->page->strtoseo($data['title_vn']);
			}else{
				$data['alias'] = $this->input->post('alias');
			}
			if($this->input->post('idmanufacturer')==0){
				$data['idmanufacturer'] = '-1';
			}else{
				$data['idmanufacturer'] = $this->input->post('idmanufacturer');
			}
			$data['idcat'] = (int)$this->input->post('idcat');
			$data['sale_price'] = (int)str_replace(".", "",$this->input->post('sale_price'));
			$data['price'] =(int)str_replace(".", "",$this->input->post('price'));
			$data['description_vn'] = $this->page->replace_script($this->input->post('description_vn'));
			$data['content_vn'] = $this->page->replace_script($this->input->post('content_vn'));
			$data['digital'] = $this->page->replace_script($this->input->post('digital'));
			$data['hot'] = (int)$this->input->post('hot');	
			$data['view'] = (int)0;
			$data['tag'] = $this->input->post('tag');	
			$data['date'] = time();	
			$data['meta_keyword'] = $this->input->post('meta_keyword');	
			$data['meta_description'] = $this->input->post('meta_description');			
		}
		$this->db->insert('mn_product', $data);
		return $this->db->insert_id();
	}
	public function update($id,$data,$task = false)
	{
		if($task==true){
			$data['title_vn'] = $this->input->post('title_vn');
			$data['meta_title'] = $this->input->post('meta_title');
			if(!$this->input->post('alias')){
				$data['alias'] = $this->page->strtoseo($data['title_vn']);
			}else{
				$data['alias'] = $this->input->post('alias');
			}
			$data['idcat'] = (int)$this->input->post('idcat');
			$data['codepro'] = $this->input->post('codepro');
			if($this->input->post('idmanufacturer')==0){
				$data['idmanufacturer'] = '-1';
			}else{
				$data['idmanufacturer'] = $this->input->post('idmanufacturer');
			}
			$data['sale_price'] = (int)str_replace(".", "",$this->input->post('sale_price'));
			$data['price'] =(int)str_replace(".", "",$this->input->post('price'));
			$data['description_vn'] = $this->page->replace_script($this->input->post('description_vn'));
			$data['content_vn'] = $this->page->replace_script($this->input->post('content_vn'));
			$data['digital'] = $this->page->replace_script($this->input->post('digital'));
			$data['hot'] = (int)$this->input->post('hot');	
			$data['titlepage'] = $this->input->post('titlepage');
			$data['tag'] = $this->input->post('tag');	
			$data['ticlock'] =  $this->input->post('ticlock')?$this->input->post('ticlock'):'0';
			$data['meta_keyword'] = $this->input->post('meta_keyword');	
			$data['meta_description'] = $this->input->post('meta_description');	
		}
		$this->db->where('Id', $id);
		$result = $this->db->update('mn_product', $data); 
		 
		return $result;
	}
	public function countview($id){
		$this->db->where('Id', $id);
		$this->db->set('view', '`view`+1', FALSE);
		$kq = $this->db->update('mn_product'); 
		return $kq;
	}
	public function countorder($id){
		$this->db->where('Id', $id);
		$this->db->set('oder', '`oder`+1', FALSE);
		$kq = $this->db->update('mn_deal'); 
		return $kq;
	}
	public function delete($id){
		return $this->db->delete('mn_product', array('Id' => $id)); 
	}
	public function delete_user($id){
		$iduser = $this->session->userdata('login_user_id');
		return $this->db->delete('mn_product', array('Id' => $id,"iduser" =>$iduser)); 
	}
	public function sumview($id){
		$this->db->select_sum('click');
		$query = $this->db->get_where('mn_product',array('iduser'=>$id));
		$result =  $query->result_array();
		return $result;
	}
	public function addColor($data){
		$this->db->insert('pro_color', $data);
		return $this->db->insert_id();
	}
	public function addSize($data){
		$this->db->insert('pro_size', $data);
		return $this->db->insert_id();
	}
	public function get_pro_size($where)
	{
		$query = $this->db->get_where('pro_size',$where);
		$result =  $query->result_array();
		return $result;
	}
	public function get_pro_color($where)
	{
		$query = $this->db->get_where('pro_color',$where);
		$result =  $query->result_array();
		return $result;
	}
	public function deleteColor($where){
		return $this->db->delete('pro_color', $where); 
	}
	public function deleteSize($where){
		return $this->db->delete('pro_size',$where); 
	}
	public function getMostView($limit = 2) {
		return $this->db->select('id,title_vn,alias,images')->from('mn_product')->where('ticlock', '0')->order_by('view DESC')->limit($limit)
		->get()->result_array();
	}
	public function updateView($id, $view) {
		$this->db->query("UPDATE `mn_product` SET `view`= '".($view+1)."' WHERE `mn_product`.`Id`=".$id);
	}
}

       