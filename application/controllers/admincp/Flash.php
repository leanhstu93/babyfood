<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flash extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('flash_model');
		 $this->load->model('adminmenu_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/flash/index'; 
		$temp['idmenu']=1;
		$config['base_url']	=	base_url('flashcp/flash/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->flash_model->count_all();
		$config['per_page']	=	50;
		$config['num_links'] = 10;
		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->flash_model->list_data($config['per_page'],$this->uri->segment(4));
	    $this->load->view("admincp/layout",$temp); 
	}
	public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 1;
		$temp['data']['map_title']  = "Thêm mới";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('is_natural_no_zero','Vui lòng chọn %s');
		
		$this->form_validation->set_rules('location','Vị trí','required|is_natural_no_zero');
		//$this->form_validation->set_rules('userfile','File','required');
		
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				
				$config['upload_path'] = './data/Flash/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1024';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload()){
					$arr =  $this->upload->data();
					$data['file_vn'] = $arr['file_name'];
				}
				$result = $this->flash_model->add($data);
				$url = base_url('admincp/flash');
				$this->page->redirect($url);
			}
		}
		$temp['template']='admincp/flash/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->flash_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 1;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('is_natural_no_zero','Vui lòng chọn %s');
		$this->form_validation->set_rules('location','Vị trí','required|is_natural_no_zero');
		
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$config['upload_path'] = './data/Flash/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1024';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload())
				{
					$error = array('error' => $this->upload->display_errors());
					//var_dump($error);
					//$this->load->view('upload_form', $error);
				}else{
					$arr =  $this->upload->data();
					$data['file_vn'] = $arr['file_name'];
				}
				$result = $this->flash_model->update($id,$data,true);
				$this->page->redirect(base_url('admincp/flash'));
			}
		}
		$temp['template']='admincp/flash/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			$info = $this->flash_model->get_where($id); 
			 $this->flash_model->delete($id);
			 if(file_exists('./data/Flash/'.$info[0]['images']))
						unlink('./data/Flash/'.$info[0]['images']);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$info = $this->flash_model->get_where($v); 
					$this->flash_model->delete($v);
					if(file_exists('./data/Flash/'.$info[0]['images']))
						unlink('./data/Flash/'.$info[0]['images']);
				}
			}
		}
		$this->page->redirect(base_url('admincp/flash'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = (int)$v;
					$this->flash_model->update($k,$data);
				}
			}
		}
		$this->page->redirect(base_url('admincp/flash'));
	}
}
