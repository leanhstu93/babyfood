<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('admin_model');
		  $this->load->model('adminmenu_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/admin/index'; 
		$temp['idmenu']=1;
		$config['base_url']	=	base_url('admincp/admin/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->admin_model->count_all();
		$config['per_page']	=	50;
		$config['num_links'] = 10;
		
		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->admin_model->list_data($config['per_page'],$this->uri->segment(4));
	    $this->load->view("admincp/layout",$temp); 
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
		
		$this->form_validation->set_rules('username','Tên đăng nhập','required|trim|is_unique[mn_admin.username]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[mn_admin.email]');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required|matches[repassword]');
		$this->form_validation->set_rules('repassword', 'Nhập lại mật khẩu', 'required');
		$this->form_validation->set_rules('level','Cấp độ','required|is_natural_no_zero');
		
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE && ($result = $this->admin_model->add()) )
			{
				$url = base_url('admincp/admin');
				$this->page->redirect($url);
			}
		}
		$temp['template']='admincp/admin/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->admin_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 1;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('is_unique','%s đã tồn tại');
		$this->form_validation->set_message('is_natural_no_zero','Vui lòng chọn %s');
		
		$this->form_validation->set_rules('username','Tên đăng nhập','required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		//$this->form_validation->set_rules('password', 'Mật khẩu', 'required|matches[repassword]');
		//$this->form_validation->set_rules('repassword', 'Nhập lại mật khẩu', 'required');
		$this->form_validation->set_rules('level','Cấp độ','required|is_natural_no_zero');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$result = $this->admin_model->update($id,$data,true);
				$this->page->redirect(base_url('admincp/admin'));
			}
		}
		$temp['template']='admincp/admin/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function change()
	{
		$id = $this->session->userdata('login_admin_uid');
		$info = $this->admin_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('is_unique','%s đã tồn tại');
		$this->form_validation->set_message('is_natural_no_zero','Vui lòng chọn %s');
		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username','Tên đăng nhập','required|trim');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required|matches[repassword]');
		$this->form_validation->set_rules('repassword', 'Nhập lại mật khẩu', 'required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$result = $this->admin_model->update($id,$data,true);
				$temp['data']['mes'] = "Đổi thông tin thành công";
			}
		}
		$temp['template']='admincp/admin/change'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->admin_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->admin_model->delete($v);
				}
			}
		}
		$this->page->redirect(base_url('admincp/admin'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->admin_model->update($k,$data);
				}
			}
		}
		$this->page->redirect(base_url('admincp/admin'));
	}
}
