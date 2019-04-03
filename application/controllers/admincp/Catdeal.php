<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class catdeal extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('catdeal_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/catdeal/index'; 
		$temp['idmenu']=3;
		$bdata = NULL;
		$config['base_url']	=	base_url('admincp/catdeal/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->catdeal_model->count_all();
		$config['per_page']	=	1000000;
		$config['num_links'] = 10;
		
		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->catdeal_model->list_data($config['per_page'],$this->uri->segment(4));
	
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
				/*$config['upload_path'] = './data/catdeal/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload()){
					$arr =  $this->upload->data();
					$data['images'] = $arr['file_name'];
				}*/
				
				$result = $this->catdeal_model->add(NULL);
				$url = base_url('admincp/catdeal');
				$this->page->redirect($url);
			}
		}
		$temp['data']['listcat'] = $this->pagehtml_model->get_catdeal(0); 
		$temp['template']='admincp/catdeal/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->catdeal_model->get_where($id);
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
				$result = $this->catdeal_model->update($id,NULL,true);
				$this->page->redirect(base_url('admincp/catdeal'));
			}
		}
		$temp['data']['listcat'] = $this->pagehtml_model->get_catdeal(0);
		$temp['template']='admincp/catdeal/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->catdeal_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->catdeal_model->delete($v);
				}
			}
		}
		$this->page->redirect(base_url('admincp/catdeal'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->catdeal_model->update($k,$data);
				}
			}
		}
		$this->page->redirect(base_url('admincp/catdeal'));
	}
}
