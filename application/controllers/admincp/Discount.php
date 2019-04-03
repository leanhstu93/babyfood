<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discount extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('discount_code_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/discount/index'; 
		$temp['idmenu']=3;
		
		$temp['data']['tukhoa'] = $tukhoa =$this->input->get('tukhoa', TRUE)?$this->input->get('tukhoa', TRUE):0;
		$temp['data']['idcat'] = $idcat =$this->input->get('idcat', TRUE)?$this->input->get('idcat', TRUE):0;
		if($tukhoa!=""){
			$sql = "SELECT * FROM mn_code_discount WHERE ( code like  '%".$tukhoa."%') ORDER BY  id ASC"; 
			$sql_toal = "SELECT COUNT(mn_code_discount.id) AS total FROM  mn_code_discount  WHERE ( code like  '%".$tukhoa."%') ORDER BY  sort ASC "; 
		}else{
			$sql = "SELECT * FROM mn_code_discount    ORDER BY  id ASC"; 
			$sql_toal = "SELECT COUNT(mn_code_discount.id) AS total FROM  mn_code_discount  ORDER BY  id ASC "; 

		}
		$link	=	base_url('admincp/discount/index?tukhoa='.$tukhoa.'&idcat='.$idcat.'&p=');
		$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
		$numrow = 50;
		$div = 10;
		$skip = $p * $numrow;
		$temp['data']['info'] = $this->discount_code_model->get_query($sql,$numrow,$skip);
		$temp['data']['total'] = $this->discount_code_model->count_query($sql_toal); 
		$temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
		
	    $this->load->view("admincp/layout",$temp); 
	}
	public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Thêm mới";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('code','Tiêu đề','required');
		$this->form_validation->set_rules('type','Giá trị giảm giá','required');
		$this->form_validation->set_rules('start_day','Thời gian bắt đầu','required');
		$this->form_validation->set_rules('end_day','Thời gian kết thúc','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				
				$result = $this->discount_code_model->add();
				$url = base_url('admincp/discount');
				redirect($url);
			}
		}
		$temp['template']='admincp/discount/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->discount_code_model->get_where($id);
		$temp['data']['info'] = $info;
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('code','Tiêu đề','required');
		$this->form_validation->set_rules('type','Giá trị giảm giá','required');
		$this->form_validation->set_rules('start_day','Thời gian bắt đầu','required');
		$this->form_validation->set_rules('end_day','Thời gian kết thúc','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$result = $this->discount_code_model->update($id,NULL,true);
				redirect(base_url('admincp/discount'));
			}
		}
		$temp['template']='admincp/discount/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->discount_code_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->discount_code_model->delete($v);
				}
			}
		}
		redirect(base_url('admincp/discount'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->discount_code_model->update($k,$data);
				}
			}
		}
		redirect(base_url('admincp/discount'));
	}
}
