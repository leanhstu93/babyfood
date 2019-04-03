<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagehtml extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/pagehtml/index'; 
		$temp['idmenu']=2;
		$config['base_url']	=	base_url('admincp/pagehtml/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->pagehtml_model->count_all();
		$config['per_page']	=	50;
		$config['num_links'] = 10;
		
		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->pagehtml_model->list_data($config['per_page'],$this->uri->segment(4));
	    $this->load->view("admincp/layout",$temp); 
	}
	public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 2;
		$temp['data']['map_title']  = "Thêm mới";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('title_vn','Tiêu đề','required');
		$this->form_validation->set_rules('content_vn', 'Nội dung', 'required');
		
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE )
			{
				
				$result = $this->pagehtml_model->add(NULL);
				$url = base_url('admincp/pagehtml');
				redirect($url);
			}
		}
		$temp['template']='admincp/pagehtml/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->pagehtml_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 2;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('title_vn','Tiêu đề','required');
		$this->form_validation->set_rules('content_vn', 'Nội dung', 'required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				
				$result = $this->pagehtml_model->update($id,NULL,true);
				redirect(base_url('admincp/pagehtml'));
			}
		}
		$temp['template']='admincp/pagehtml/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->pagehtml_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->pagehtml_model->delete($v);
				}
			}
		}
		redirect(base_url('admincp/pagehtml'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->pagehtml_model->update($k,$data);
				}
			}
		}
		redirect(base_url('admincp/admin'));
	}
}
