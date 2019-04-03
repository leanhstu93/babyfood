<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('manufacturer_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/manufacturer/index'; 
		$temp['idmenu']=3;
		$tukhoa =$this->input->get('tukhoa', TRUE)?$this->input->get('tukhoa', TRUE):-1;

		$idcat =$this->input->get('idcat', TRUE)?$this->input->get('idcat', TRUE):0;

		if($idcat > 0 || $tukhoa !=-1){

			$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;

			$sql= "SELECT * FROM mn_manufacturer WHERE  ( title_vn LIKE '%".$tukhoa."%' OR '".$tukhoa."' = -1) ORDER BY Id DESC"; 

			$temp['data']['info'] = $this->manufacturer_model->get_query($sql,500,0);

			$temp['data']['total'] = count($temp['data']['info']);;

		}else{ 

			$config['base_url']	=	base_url('admincp/manufacturer/index');

			$temp['data']['total'] = $config['total_rows']	=	$this->manufacturer_model->count_all();

			$config['per_page']	=	50;

			$config['num_links'] = 10;

			

			$this->pagination->initialize($config);

			$temp['data']['info'] = $this->manufacturer_model->list_data($config['per_page'],$this->uri->segment(4));

		}

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
				$config['upload_path'] = './data/Manufacturer/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '2024';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload()){
					$arr =  $this->upload->data();
					$data['images'] = $arr['file_name'];
				}
				$result = $this->manufacturer_model->add($data);
				$url = base_url('admincp/manufacturer');
				redirect($url);
			}
		}
		$temp['data']['listcat'] = $this->pagehtml_model->get_catelog(0); 
		$temp['template']='admincp/manufacturer/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->manufacturer_model->get_where($id);
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
				$config['upload_path'] = './data/Manufacturer/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload()){
					$arr =  $this->upload->data();
					if($arr['file_name'] !=""){
						$data['images'] = $arr['file_name'];
					}
				}else{
					$error = $this->upload->display_errors();
				}
				$result = $this->manufacturer_model->update($id,$data,true);
				redirect(base_url('admincp/manufacturer'));
			}
		}
		$temp['data']['listcat'] = $this->pagehtml_model->get_catelog(0); 
		$temp['template']='admincp/manufacturer/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			$info = $this->manufacturer_model->get_where($v);
			if(file_exists('./data/Manufacturer/'.$info[0]['images']))
				unlink('./data/Manufacturer/'.$info[0]['images']);
			 $this->manufacturer_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$info = $this->manufacturer_model->get_where($v);
					if(file_exists('./data/Manufacturer/'.$info[0]['images']))
						unlink('./data/Manufacturer/'.$info[0]['images']);
					$this->manufacturer_model->delete($v);
				}
			}
		}
		redirect(base_url('admincp/manufacturer'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->manufacturer_model->update($k,$data);
				}
			}
		}
		redirect(base_url('admincp/manufacturer'));
	}
}
