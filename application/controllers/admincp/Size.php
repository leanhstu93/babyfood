<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Size extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('size_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/size/index'; 
		$temp['idmenu']=3;
		
		$temp['data']['tukhoa'] = $tukhoa =$this->input->get('tukhoa', TRUE)?$this->input->get('tukhoa', TRUE):0;
		$temp['data']['idcat'] = $idcat =$this->input->get('idcat', TRUE)?$this->input->get('idcat', TRUE):0;
		if($tukhoa!=""){
			$sql = "SELECT * FROM mn_size WHERE ( title_vn like  '%".$tukhoa."%')    ORDER BY  sort ASC"; 
			$sql_toal = "SELECT COUNT(mn_size.Id) AS total FROM  mn_size  WHERE ( title_vn like  '%".$tukhoa."%')    ORDER BY  sort ASC "; 
		}else{
			$sql = "SELECT * FROM mn_size     ORDER BY  sort ASC"; 
			$sql_toal = "SELECT COUNT(mn_size.Id) AS total FROM  mn_size    ORDER BY  sort ASC "; 

		}
		$link	=	base_url('admincp/size/index?tukhoa='.$tukhoa.'&idcat='.$idcat.'&p=');
		$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
		$numrow = 50;
		$div = 10;
		$skip = $p * $numrow;
		$temp['data']['info'] = $this->product_model->get_query($sql,$numrow,$skip);
		$temp['data']['total'] = $this->product_model->count_query($sql_toal); 
		$temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
		
	    $this->load->view("admincp/layout",$temp); 
	}
	public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Thêm mới";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('title_vn','Tiêu đề','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				
				$result = $this->size_model->add();
				$url = base_url('admincp/size');
				redirect($url);
			}
		}
		$temp['template']='admincp/size/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->size_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('title_vn','Tiêu đề','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$result = $this->size_model->update($id,NULL,true);
				redirect(base_url('admincp/size'));
			}
		}
		$temp['template']='admincp/size/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->size_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->size_model->delete($v);
				}
			}
		}
		redirect(base_url('admincp/size'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->size_model->update($k,$data);
				}
			}
		}
		redirect(base_url('admincp/size'));
	}
}
