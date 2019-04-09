<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('support_model');
		  $this->load->model('supportmenu_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		
		$temp['template']='supportcp/support/index'; 
		$temp['idmenu']=1;
		$config['base_url']	=	base_url('supportcp/support/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->support_model->count_all();
		$config['per_page']	=	50;
		$config['num_links'] = 10;
		
		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->support_model->list_data($config['per_page'],$this->uri->segment(4));
	    $this->load->view("supportcp/layout",$temp); 
	}
	public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 1;
		$temp['data']['map_title']  = "Thêm mới";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('is_unique','%s đã tồn tại');
		//$this->form_validation->set_message('xss_clean','%s không đúng định dạng');
		$this->form_validation->set_message('is_natural_no_zero','Vui lòng chọn %s');
		
		$this->form_validation->set_rules('username','Tên đăng nhập','required|trim|is_unique[mn_support.username]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[mn_support.email]');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required|matches[repassword]');
		$this->form_validation->set_rules('repassword', 'Nhập lại mật khẩu', 'required');
		$this->form_validation->set_rules('level','Cấp độ','required|is_natural_no_zero');
		
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE && ($result = $this->support_model->add()) )
			{
				$url = base_url('supportcp/support');
				$this->page->redirect($url);
			}
		}
		$temp['template']='supportcp/support/add'; 
		$this->load->view("supportcp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->support_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 1;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('is_unique','%s đã tồn tại');
		$this->form_validation->set_message('is_natural_no_zero','Vui lòng chọn %s');
		
		$this->form_validation->set_rules('username','Tên đăng nhập','required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required|matches[repassword]');
		$this->form_validation->set_rules('repassword', 'Nhập lại mật khẩu', 'required');
		$this->form_validation->set_rules('level','Cấp độ','required|is_natural_no_zero');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$result = $this->support_model->update($id,$data,true);
				$this->page->redirect(base_url('supportcp/support'));
			}
		}
		$temp['template']='supportcp/support/edit'; 
		$this->load->view("supportcp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->support_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->support_model->delete($v);
				}
			}
		}
		$this->page->redirect(base_url('supportcp/support'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->support_model->update($k,$data);
				}
			}
		}
		$this->page->redirect(base_url('supportcp/support'));
	}
}
