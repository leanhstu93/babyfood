<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bmenu extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('bmenu_model');
		 $this->load->model('menu_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/bmenu/index'; 
		$temp['idmenu']=1;
		$config['base_url']	=	base_url('admincp/bmenu/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->bmenu_model->count_all();
		$config['per_page']	=	50;
		$config['num_links'] = 10;
			 
		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->bmenu_model->list_data($config['per_page'],$this->uri->segment(4));
	    $this->load->view("admincp/layout",$temp); 
	}
	public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 1;
		$temp['data']['map_title']  = "Thêm mới";

		if($this->input->post('save'))
		{
			
				$config['upload_path'] = './data/Banner/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '2000';
				$config['encrypt_name'] = TRUE; 
				$config['file_name'] = $this->page->rand_string(30);
				$this->load->library('upload', $config);
				if ($this->upload->do_upload()){
					$arr =  $this->upload->data();
					$data['images'] = $arr['file_name'];
				}
				$result = $this->bmenu_model->add($data);
				$url = base_url('admincp/bmenu');
				redirect($url);
		
		}
		$temp['data']['catlist']= $this->menu_model->get_list(array('ticlock'=>0,"parentid"=>0),"sort ASC, Id DESC",20,0);
		$temp['template']='admincp/bmenu/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->bmenu_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 1;
		$temp['data']['map_title']  = "Sửa";
		if($this->input->post('save'))
		{
			
				$config['upload_path'] = './data/Banner/';
				$config['file_name'] = $this->page->rand_string(30);
				$config['encrypt_name'] = TRUE;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload()){
					$arr =  $this->upload->data();
					$data['images'] = $arr['file_name'];
				}
				$result = $this->bmenu_model->update($id,$data,true);
				redirect(base_url('admincp/bmenu'));
			
		}
		$temp['data']['catlist']= $this->menu_model->get_list(array('ticlock'=>0,"parentid"=>0),"sort ASC, Id DESC",20,0);
		$temp['template']='admincp/bmenu/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			$info = $this->bmenu_model->get_where($id); 
			$this->bmenu_model->delete($id);
			if(file_exists('./data/Banner/'.$info[0]['images']))
						unlink('./data/Banner/'.$info[0]['images']);
	
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$info = $this->bmenu_model->get_where($v); 
					$this->bmenu_model->delete($v);
					if(file_exists('./data/Banner/'.$info[0]['images']))
						unlink('./data/Banner/'.$info[0]['images']);
				}
			}
		}
		redirect(base_url('admincp/bmenu'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->bmenu_model->update($k,$data);
				}
			}
		}
		redirect(base_url('admincp/bmenu'));
	}
}
