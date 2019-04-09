<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('payment_model');
		 $this->load->model('adminmenu_model');
		 $this->load->model('website_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$id = 1;
		$info = $this->website_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 1;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('is_natural_no_zero','Vui lòng chọn %s');
		
		$this->form_validation->set_rules('title_vn','Tiêu đề trang','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		
		if($this->input->post('save'))
		{	$goge = $this->input->post('googleanalytics');
			if($this->form_validation->run() == TRUE  )
			{
				$result = $this->website_model->update($id,$data,true);
				redirect(base_url('admincp/website'));
			}
		}

		$temp['template']='admincp/website/edit'; 
		$this->load->view("admincp/layout",$temp);
	}
	public function removecache()
	{
		$this->cache->clean();
		redirect(base_url('admincp/website'));
	}
	public function removecacheAjax()
	{
		$this->cache->clean();
		echo '<span><i class="fa fa-check" aria-hidden="true"></i> Xóa cache thành công</span>';
	}
	
}
