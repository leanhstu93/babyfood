<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('tags_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/tags/index'; 
		$temp['idmenu']=3;
		$config['base_url']	=	base_url('admincp/tags/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->tags_model->count_all();
		$config['per_page']	=	50;
		$config['num_links'] = 10;

		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->tags_model->list_data($config['per_page'],$this->uri->segment(4));
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
				$config['upload_path'] = './data/tags/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1024';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload()){
					$arr =  $this->upload->data();
					$data['images'] = $arr['file_name'];
				}
				$result = $this->tags_model->add($data);
				$url = base_url('admincp/tags');
				$this->page->redirect($url);
			}
		}
		$temp['template']='admincp/tags/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->tags_model->get_where($id);
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
				
				//$result = $this->tags_model->update($id,$data,true);
				$this->page->redirect(base_url('admincp/tags'));
			}
		}
		$temp['template']='admincp/tags/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->tags_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->tags_model->delete($v);
				}
			}
		}
		$this->page->redirect(base_url('admincp/tags'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->tags_model->update($k,$data);
				}
			}
		}
		$this->page->redirect(base_url('admincp/tags'));
	}
}
