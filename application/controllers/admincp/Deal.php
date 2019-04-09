<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deal extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('deal_model');
		 $this->load->model('catdeal_model');
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
		$temp['template']='admincp/deal/index'; 
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
			$order  = "mn_deal.Id DESC";
		}
		//$order  = "mn_deal.Id DESC";
		$temp['data']['tukhoa'] = $tukhoa =$this->input->get('tukhoa', TRUE)?$this->input->get('tukhoa', TRUE):-1;
		$temp['data']['status_check'] =  $status_check = $this->input->get('status_check', TRUE)?$this->input->get('status_check', TRUE):-1;
		$temp['data']['ticlock'] =  $ticlock = $this->input->get('ticlock', TRUE)?$this->input->get('ticlock', TRUE):-1;
		$temp['data']['iduser'] = $iduser =$this->input->get('iduser', TRUE)?$this->input->get('iduser', TRUE):-1;
		$temp['data']['catelog'] = $catelog =$this->input->get('catelog', TRUE)?$this->input->get('catelog', TRUE):-1;
		$tukhoa = $this->page->escape_str($tukhoa);
		if(!isset($status_check)) $status_check  = '-1';
	   $sql = "SELECT *,(SELECT title_vn FROM mn_catdeal WHERE mn_catdeal.Id = mn_deal.idcat) AS catelog FROM mn_deal  WHERE (( title_vn like  '%".$tukhoa."%') OR ( content_vn like  '%".$tukhoa."%') OR ( codepro like  '%".$tukhoa."%') OR ('".$tukhoa."' = -1 ))  AND   ((idcat='".$catelog."') OR ".$catelog." = -1)  AND (ticlock='".$ticlock."' OR ".$ticlock." = '-1') AND trash = 0  ORDER BY ".$order; 
	   
		$sql_toal = "SELECT COUNT(mn_deal.Id) AS total FROM mn_deal   WHERE (( title_vn like  '%".$tukhoa."%') OR ( codepro like  '%".$tukhoa."%') OR ( content_vn like  '%".$tukhoa."%') OR ('".$tukhoa."' = -1 ))   AND ((idcat='".$catelog."') OR ".$catelog." = -1)  AND (ticlock='".$ticlock."' OR ".$ticlock." = '-1') AND trash = 0 "; 
		
		$link	=	base_url('admincp/deal/index?iduser='.$iduser.'&tukhoa='.$tukhoa.'&catelog='.$catelog.'&status_check='.$status_check.'&ticlock='.$ticlock.'&p=');
		//*---------------pagination------------------
		$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
		$numrow = 50;
		$div = 10;
		$skip = $p * $numrow;
		$temp['data']['info'] = $this->deal_model->get_query($sql,$numrow,$skip);
		$temp['data']['total'] = $this->deal_model->count_query($sql_toal); 
		$temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
		$temp['data']['listcat'] = $this->pagehtml_model->get_catdeal(0);  
		$arr_query = array("tukhoa"=>$tukhoa,"status_check"=>$status_check,"iduser"=>$iduser,"catelog"=>$catelog,"page"=>$p);
		$temp["data"]['arr_query'] = base64_encode(json_encode($arr_query));
		
	    $this->load->view("admincp/layout",$temp); 
	}
	
	public function add()
	{
		
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Thêm mới";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('title_vn','Tiêu đề','required');
		$this->form_validation->set_rules('idcat','Danh mục','required|is_natural_no_zero');
		$this->form_validation->set_rules('price','Giá gốc','required');
		$this->form_validation->set_rules('sale_price','Giá bán','required');
		$this->form_validation->set_rules('content_vn','Nội dung','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$dir = './data/Product/';
				$data['images'] = $this->uploadimages("images",$tenhinh,true);
				$data['images1'] = $this->uploadimages("images1",$tenhinh."-1",false);	
				$data['images2'] = $this->uploadimages("images2",$tenhinh."-2",false);
				$data['images3'] = $this->uploadimages("images3",$tenhinh."-3",false);
				$data['images4'] = $this->uploadimages("images4",$tenhinh."-4",false);
				$data['admin'] = $this->session->userdata('login_admin_username');
				$id = $this->deal_model->add($data,true);
				$url = base_url('admincp/deal');
				$this->page->redirect($url);
			}
		}
		$temp['data']['discount_code']= $this->pagehtml_model->get_code_discount_all(); 
		$temp['data']['location']= $this->pagehtml_model->get_location_all(); 
		$temp['data']['listcat']= $this->catdeal_model->get_list(array('ticlock'=>0),'sort ASC, Id DESC',500,0); 
		$temp['template']='admincp/deal/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$q  = $this->input->get('q', TRUE); 
		$query =json_decode(base64_decode($q),TRUE);
		$link = BASE_URL.'admincp/deal/index?tukhoa='.$query['tukhoa']."&status_check=".$query['status_check']."&iduser=".$query['iduser']."&catelog=".$query['catelog']."&p=".$query['page']; 
		
		$id = $this->uri->segment(4);
		$info = $this->deal_model->get_Id($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('title_vn','Tiêu đề','required');
		$this->form_validation->set_rules('price','Giá gốc','required');
		$this->form_validation->set_rules('idcat','Chủ đề','required|is_natural_no_zero');
		$this->form_validation->set_rules('content_vn','Nội dung','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$data  =array();
				$dir = './data/Product/';
				$tenhinh = $this->page->strtoseo($this->input->post('title_vn'));
				
				if($_FILES['images']['name'] != ''){
					$data['images'] = $this->uploadimages("images",$tenhinh,true);
				}
				if($_FILES['images1']['name'] != ''){
					$data['images1'] = $this->uploadimages("images1",$tenhinh."-1",false);
				}
				if($_FILES['images2']['name'] != ''){
					$data['images2'] = $this->uploadimages("images2",$tenhinh."-2",false);
				}
				if($_FILES['images3']['name'] != ''){
					$data['images3'] = $this->uploadimages("images3",$tenhinh."-3",false);
				}
				if($_FILES['images4']['name'] != ''){
					$data['images4'] = $this->uploadimages("images4",$tenhinh."-4",false);
				}
				$result = $this->deal_model->update($id,$data,true); 
				
				redirect($link);
			}
		}
		$temp['data']['listcat']= $this->pagehtml_model->get_catdeal(0);
		$temp['data']['discount_code']= $this->pagehtml_model->get_code_discount_all(); 
		$temp['data']['location']= $this->pagehtml_model->get_location_all(); 
		$temp['template']='admincp/deal/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$q  = $this->input->get('q', TRUE); 
		$query =json_decode(base64_decode($q),TRUE);
		$link = BASE_URL.'admincp/deal/index?tukhoa='.$query['tukhoa']."&status_check=".$query['status_check']."&iduser=".$query['iduser']."&catelog=".$query['catelog']."&p=".$query['page']; 
		
		$id = $this->uri->segment(4);
		if($id>0){
			//$this->deal_model->delete($id);
			$this->deal_model->update($id,array('trash'=>1),false); 
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					//$this->deal_model->delete($v);
					 $this->deal_model->update($v,array('trash'=>1),false); 
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
					$this->deal_model->update($k,$data,false);
				}
			}
		}
		unset($data);
		if($this->input->post('price')) {
			$price = $this->input->post("price");
			if(!empty($price)){
				foreach($price as $k=>$v){
					$data['price'] = str_replace(".","",$v);
					$this->deal_model->update($k,$data, false);
				}
			}
		}
		$q  = $this->input->get('q', TRUE); 
		$query =json_decode(base64_decode($q),TRUE);
		$link = BASE_URL.'admincp/deal/index?tukhoa='.$query['tukhoa']."&status_check=".$query['status_check']."&iduser=".$query['iduser']."&catelog=".$query['catelog']."&p=".$query['page']; 
		redirect($link);
	}
	public function uploadimages($file,$tenhinh,$crop= false){
		$this->load->library('image_lib');
		$dir = './data/Product/';
		$dirthumbs = './data/Product/thumbs/';
		
		$config = array(
			'allowed_types'     => 'jpg|jpeg|gif|png', 
			'overwrite'			=> TRUE,
			'max_size'          => 0,//2048000, //2MB max
			'max_width'			=> 0,
			'max_height'		=> 0,
			'upload_path'       => $dir,
			'file_name' =>  $tenhinh, 
		);
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
	
		if($this->upload->do_upload($file)) {
			$upload_data = $this->upload->data();
			$image_config["image_library"] = "GD2";
			$image_config["source_image"] = $upload_data["full_path"];
			$image_config['create_thumb'] = FALSE;
			$image_config['maintain_ratio'] = TRUE;
			$image_config['new_image'] = $dir;
			$image_config['quality'] = "100%";
			$image_config['width'] = 500;
			$image_config['height'] = 500;
			$image_config['overwrite'] = TRUE;
			$dim = (intval($upload_data["image_width"]) / intval($upload_data["image_height"])) - ($image_config['width'] / $image_config['height']);
			$image_config['master_dim'] = ($dim > 0)? "height" : "width";
			$this->image_lib->initialize($image_config);
			
			if($this->image_lib->resize() && $crop==true){ 
				//---resize lần 2---
				list($width, $height) = getimagesize($upload_data["full_path"]);
				
				
				$resize_config["image_library"] = "GD2";
				$resize_config["source_image"] = $upload_data["full_path"];
				$resize_config['create_thumb'] = FALSE;
				$resize_config['maintain_ratio'] = TRUE;
				$resize_config['new_image'] = $dirthumbs;
				$resize_config['quality'] = "100%";
				$resize_config['width'] = 210;
				$resize_config['height'] = 210;
				$resize_config['overwrite'] = TRUE;
				$dim = (intval($width) / intval($height)) - ($resize_config['width'] / $resize_config['height']);
				$resize_config['master_dim'] = ($dim > 0)? "height" : "width";
				$this->image_lib->clear();
				$this->image_lib->initialize($resize_config);
				$this->image_lib->resize();
				
				//-------------
				$crop_config['overwrite'] = TRUE;
				$crop_config['image_library'] = 'GD2';
				$crop_config['source_image'] = $dirthumbs.$upload_data['file_name'];
				$crop_config['new_image'] = $dirthumbs;
				$crop_config['quality'] = "100%";
				$crop_config['maintain_ratio'] = FALSE;
				$crop_config['width'] = 210;
				$crop_config['height'] = 210;
				$crop_config['x_axis'] = 0;
				$crop_config['y_axis'] = 0;
				$this->image_lib->clear();
				$this->image_lib->initialize($crop_config); 
				$this->image_lib->crop();
			}
		}
		return $upload_data['file_name'];
	}
	
}

