<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catelog extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('catelog_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/catelog/index'; 
		$temp['idmenu']=3;
		$bdata = NULL;
		$config['base_url']	=	base_url('admincp/catelog/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->catelog_model->count_all();
		$config['per_page']	=	1000000;
		$config['num_links'] = 10;
		
		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->catelog_model->list_data($config['per_page'],$this->uri->segment(4));
	
	    $this->load->view("admincp/layout",$temp); 
	}
	public function add($data = NULL)
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
				$strname = $this->page->strtoseo($this->input->post('title_vn'));
				$name = mb_strtolower(trim($strname), "UTF-8").'-'.time();
				$config['file_name'] = $name;
				$config['upload_path'] = './data/Catelog/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '11000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('photo')){
					$arr =  $this->upload->data();
					$data['images'] = $arr['file_name'];
				}
				
				$name = mb_strtolower(trim($strname), "UTF-8").'-1-'.time();
				$config['file_name'] = $name;
				$config['upload_path'] = './data/Catelog/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '11000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('images1')){
					$arr =  $this->upload->data();
					$data['images1'] = $arr['file_name'];
				}
				
				$result = $this->catelog_model->add($data);
				$url = base_url('admincp/catelog');
				$this->page->redirect($url);
			}
		}
		$temp['data']['listcat'] = $this->pagehtml_model->get_catelog(0); 
		$temp['template']='admincp/catelog/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id, $data= NULL)
	{
		$id = $this->uri->segment(4);
		$info = $this->catelog_model->get_where($id);
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
				
				if($_FILES['photo']['name'] != ''){
					$strname = $this->page->strtoseo($this->input->post('title_vn'));
					$name = mb_strtolower(trim($strname), "UTF-8").'-'.time();
					
					$config['file_name'] = $name;
					$config['upload_path'] = './data/Catelog/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '1000';
					$this->load->library('upload', $config);
					
					if ($this->upload->do_upload('photo')){
						
						$arr =  $this->upload->data();
						$data['images'] = $arr['file_name'];
						if($info[0]['images']!=''){
							$this->page->delete_file($config['upload_path'].$info[0]['images']);
						}
						
					}
				}
				if($_FILES['images1']['name'] != ''){
					$strname = $this->page->strtoseo($this->input->post('title_vn'));
					$name = mb_strtolower(trim($strname), "UTF-8").'-1-'.time();
					
					$config['file_name'] = $name;
					$config['upload_path'] = './data/Catelog/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '1000';
					$this->load->library('upload', $config);
					
					if ($this->upload->do_upload('images1')){
						
						$arr =  $this->upload->data();
						$data['images1'] = $arr['file_name'];
						if($info[0]['images1']!=''){
							$this->page->delete_file($config['upload_path'].$info[0]['images1']);
						}
						
					}
				}
				
				$result = $this->catelog_model->update($id,$data,true);
				$this->page->redirect(base_url('admincp/catelog'));
			}
		}
		$temp['data']['listcat'] = $this->pagehtml_model->get_catelog(0);
		$temp['template']='admincp/catelog/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			$src = './data/Catelog/';
			$checkimg = $this->catelog_model->get_where($id);
			if($checkimg[0]['images']!=''){
				$this->page->delete_file($src.$checkimg[0]['images']);	
			}
			 $this->catelog_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				$src = './data/Catelog/';
				foreach($checked as $k=>$v){
					$checkimg = $this->catelog_model->get_where($v);
					if($checkimg[0]['images']!=''){
						$this->page->delete_file($src.$checkimg[0]['images']);	
					}
					$this->catelog_model->delete($v);
				}
			}
		}
		$this->page->redirect(base_url('admincp/catelog'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->catelog_model->update($k,$data);
				}
			}
		}
		$this->page->redirect(base_url('admincp/catelog'));
	}
}
