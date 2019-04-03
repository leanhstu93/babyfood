<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminmenu extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->helper('url');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/adminmenu/index'; 
		$temp['idmenu']=1;
		$config['base_url']	=	base_url('admincp/adminmenu/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->adminmenu_model->count_all();
		$config['per_page']	=	50;
		$config['num_links'] = 10;
		
		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->adminmenu_model->list_data($config['per_page'],$this->uri->segment(4));
	    $this->load->view("admincp/layout",$temp); 
	}
	public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 1;
		$temp['data']['map_title']  = "Thêm mới";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('is_unique','%s đã tồn tại');
		$this->form_validation->set_message('is_natural_no_zero','Vui lòng chọn %s');
		
		$this->form_validation->set_rules('title_vn','Tên menu','required|is_unique[mn_adminmenu.title_vn]');
		$this->form_validation->set_rules('images','Biểu tượng','required');
		$this->form_validation->set_rules('route','Route','required');
		$this->form_validation->set_rules('parentid','Chủ  đề','required|is_natural_no_zero');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE && ($result = $this->adminmenu_model->add()) )
			{
				$url = base_url('admincp/adminmenu');
				$this->page->redirect($url);
			}
		}
		$temp['template']='admincp/adminmenu/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$temp['data']['info']= $this->adminmenu_model->get_where($id);
		$temp['idmenu'] = 1;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('is_unique','%s đã tồn tại');
		$this->form_validation->set_message('is_natural_no_zero','Vui lòng chọn %s');
		
		$this->form_validation->set_rules('title_vn','Tên menu','required');
		$this->form_validation->set_rules('images','Biểu tượng','required');
		$this->form_validation->set_rules('route','Route','required');
		$this->form_validation->set_rules('parentid','Chủ  đề','required|is_natural_no_zero');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$result = $this->adminmenu_model->Update($id,$data,true);
				$this->page->redirect(base_url('admincp/adminmenu'));
			}
		}
		$temp['template']='admincp/adminmenu/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->adminmenu_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->adminmenu_model->delete($v);
				}
			}
		}
		$this->page->redirect(base_url('admincp/adminmenu'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->adminmenu_model->update($k,$data);
				}
			}
		}
		$this->page->redirect(base_url('admincp/adminmenu'));
	}
}
