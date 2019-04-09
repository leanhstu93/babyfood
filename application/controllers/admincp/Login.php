<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('admin_model');
	
	}
	public function index()
	{	
		//echo $this->page->gen_pass('admin');
		if($this->session->userdata('login_admin_id')==1){
			$this->page->redirect(base_url('admincp/product'));
			exit();
		}
		$temp = null;
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('valid_email','Email không hợp lệ');
		$this->form_validation->set_rules('username','Tên đăng nhập','required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required');
		
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('submit'))
		{
			if($this->form_validation->run() == TRUE )
			{
				$data['username'] =  $this->input->post('username');
				$data['password'] =  $this->page->gen_pass($this->input->post('password'));
				$data['email'] =  $this->input->post('email');				
				$arr = $this->admin_model->get_Arr($data);
				if(!empty($arr)){
					$arrs['login_admin_id']  =1;
					$arrs['login_admin_username']  = $arr[0]['username'];
					$arrs['login_admin_level']  = $arr[0]['level'];
					$arrs['login_admin_uid']  = $arr[0]['Id'];
					$this->session->set_userdata($arrs);
					$this->page->redirect(base_url('admincp/product'));
				}else{
					$temp['error'] = "Tài khoản hoặc mật khẩu không chính xác";
				}
			}
		}
	    $this->load->view("admincp/login/index",$temp); 
	}
	public function logout()
	{
		
		$this->session->sess_destroy();
		$this->page->redirect(base_url('admincp/login'));
	}
	
}
