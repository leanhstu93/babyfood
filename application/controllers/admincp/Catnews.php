<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catnews extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('catnews_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/catnews/index'; 
		$temp['idmenu']=2;
		$bdata = NULL;
		$config['base_url']	=	base_url('admincp/catnews/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->catnews_model->count_all();
		$config['per_page']	=	100;
		$config['num_links'] = 10;
		
		$this->pagination->initialize($config);
		$bdatas = $this->catnews_model->list_data($config['per_page'],$this->uri->segment(4));
		if(!empty($bdatas)){
			foreach($bdatas as $rows)
			{
				$bdata[] = $rows;
			}
		}
		$temp['data']['info'] =$bdata;
	    $this->load->view("admincp/layout",$temp); 
	}
	public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 2;
		$temp['data']['map_title']  = "Thêm mới";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('title_vn','Tiêu đề','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				/*$config['upload_path'] = './data/catnews/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload()){
					$arr =  $this->upload->data();
					$data['images'] = $arr['file_name'];
				}*/
				
				$result = $this->catnews_model->add(NULL);
				$url = base_url('admincp/catnews');
				redirect($url);
			}
		}
		$temp['data']['listcat'] = $this->catnews_model->list_data(50,0);
		$temp['template']='admincp/catnews/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->catnews_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 2;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('title_vn','Tiêu đề','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				
				$result = $this->catnews_model->update($id,NULL,true);
				redirect(base_url('admincp/catnews'));
			}
		}
		$temp['data']['listcat'] = $this->catnews_model->list_data(50,0);
		$temp['template']='admincp/catnews/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->catnews_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->catnews_model->delete($v);
				}
			}
		}
		redirect(base_url('admincp/catnews'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->catnews_model->update($k,$data);
				}
			}
		}
		redirect(base_url('admincp/catnews'));
	}
}
