<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trash extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('product_model');
		 $this->load->model('catelog_model');
		 $this->load->model('user_model');
		 $this->load->model('adminmenu_model');
		 $this->load->library('mgallery');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['data']['act'] = $this->router->fetch_method();
		$temp['template']='admincp/trash/index'; 
		$temp['idmenu']=3;
		$this->session->unset_tempdata('sort');
		//***-----------------sort---------------
		if($this->input->post('sortitem')){
			$sortitem = $this->input->post('sortitem');
			$sorvalue = $this->input->post('sorvalue');
			if($sorvalue=='0'){
				$sorvalue = 'asc';
			}else $sorvalue = 'desc';
			$val = $sortitem." ".$sorvalue;
			$this->session->set_userdata('sort',$val);
		}
		if($this->session->userdata('sort')){
			$order = $this->session->userdata('sort');
		}else{
			$order  = "mn_product.Id DESC";
		}
		//$order  = "mn_product.Id DESC";
		$temp['data']['tukhoa'] = $tukhoa =$this->input->get('tukhoa', TRUE)?$this->input->get('tukhoa', TRUE):-1;
		$temp['data']['status_check'] =  $status_check = $this->input->get('status_check', TRUE)?$this->input->get('status_check', TRUE):-1;
		$temp['data']['ticlock'] =  $ticlock = $this->input->get('ticlock', TRUE)?$this->input->get('ticlock', TRUE):-1;
		$temp['data']['iduser'] = $iduser =$this->input->get('iduser', TRUE)?$this->input->get('iduser', TRUE):-1;
		$temp['data']['catelog'] = $catelog =$this->input->get('catelog', TRUE)?$this->input->get('catelog', TRUE):-1;
		$tukhoa = $this->page->escape_str($tukhoa);
		if(!isset($status_check)) $status_check  = '-1';
	   $sql = "SELECT *,(SELECT username FROM mn_user WHERE mn_user.id = mn_product.iduser) AS username,(SELECT title_vn FROM mn_catelog WHERE mn_catelog.Id = mn_product.idcat) AS catelog FROM mn_product  WHERE (( title_vn like  '%".$tukhoa."%') OR ( content_vn like  '%".$tukhoa."%') OR ( codepro like  '%".$tukhoa."%') OR ('".$tukhoa."' = -1 )) AND  ((idcat='".$catelog."') OR ".$catelog." = -1) AND (ticlock='".$ticlock."' OR ".$ticlock." = '-1') AND trash=1  ORDER BY ".$order; 
	    
		$sql_toal = "SELECT COUNT(mn_product.Id) AS total FROM mn_product   WHERE (( title_vn like  '%".$tukhoa."%') OR ( codepro like  '%".$tukhoa."%') OR ( content_vn like  '%".$tukhoa."%') OR ('".$tukhoa."' = -1 )) AND  ((idcat='".$catelog."') OR ".$catelog." = -1)  AND (ticlock='".$ticlock."' OR ".$ticlock." = '-1') AND trash=1 "; 
		
		$link	=	base_url('admincp/trash/index?iduser='.$iduser.'&tukhoa='.$tukhoa.'&catelog='.$catelog.'&status_check='.$status_check.'&ticlock='.$ticlock.'&p=');
		//*---------------pagination------------------
		$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
		$numrow = 50;
		$div = 10;
		$skip = $p * $numrow;
		$temp['data']['info'] = $this->product_model->get_query($sql,$numrow,$skip);
		$temp['data']['total'] = $this->product_model->count_query($sql_toal); 
		$temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
		$temp['data']['listcat'] = $this->pagehtml_model->get_catelog(0);  
		$arr_query = array("tukhoa"=>$tukhoa,"status_check"=>$status_check,"iduser"=>$iduser,"catelog"=>$catelog,"page"=>$p);
		$temp["data"]['arr_query'] = base64_encode(json_encode($arr_query));
		
	    $this->load->view("admincp/layout",$temp); 
	}
	public function restore($id){
		$q  = $this->input->get('q', TRUE); 
		$query =json_decode(base64_decode($q),TRUE);
		$link = BASE_URL.'admincp/trash/index?tukhoa='.$query['tukhoa']."&status_check=".$query['status_check']."&iduser=".$query['iduser']."&catelog=".$query['catelog']."&p=".$query['page']; 
		$this->product_model->update($id,array('trash'=>0),false);
		redirect($link); 
	}
	public function delete()
	{
		$q  = $this->input->get('q', TRUE); 
		$query =json_decode(base64_decode($q),TRUE);
		$link = BASE_URL.'admincp/trash/index?tukhoa='.$query['tukhoa']."&status_check=".$query['status_check']."&iduser=".$query['iduser']."&catelog=".$query['catelog']."&p=".$query['page']; 
		
		$id = $this->uri->segment(4);
		if($id>0){
			$this->product_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->product_model->delete($v);
				}
			}
		}
		redirect($link);
	}

	public function save()
	{
		
	
		if($this->input->post('price_sale')) {
			$price_sale = $this->input->post("price_sale");
			if(!empty($price_sale)){
				foreach($price_sale as $k=>$v){
					$data['sale_price'] = str_replace(".","",$v);
					$this->product_model->update($k,$data,false);
				}
			}
		}
		unset($data);
		if($this->input->post('catelog')) {
			$checked = $this->input->post("catelog");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['idcat'] = (int)$v;
					$this->product_model->update($k,$data);
				}
			}
		}
		$q  = $this->input->get('q', TRUE); 
		$query =json_decode(base64_decode($q),TRUE);
		$link = BASE_URL.'admincp/trash/index?tukhoa='.$query['tukhoa']."&status_check=".$query['status_check']."&iduser=".$query['iduser']."&catelog=".$query['catelog']."&p=".$query['page']; 
		redirect($link);
	}
	
}

