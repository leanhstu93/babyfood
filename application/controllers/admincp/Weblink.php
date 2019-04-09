<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weblink extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('weblink_model');
		 $this->load->model('catelog_model');
		 $this->load->model('catdeal_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/weblink/index'; 
		$temp['idmenu']=3;
		$config['base_url']	=	base_url('admincp/weblink/index');
		$temp['data']['total'] = $config['total_rows']	=	$this->weblink_model->count_all();
		$config['per_page']	=	50;
		$config['num_links'] = 10;
		
		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->weblink_model->list_data($config['per_page'],$this->uri->segment(4));
	    $this->load->view("admincp/layout",$temp); 
	}
	public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Thêm mới";

		if($this->input->post('save'))
		{
			
				$config['upload_path'] = './data/Banner/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload()){
					$arr =  $this->upload->data();
					$data['images'] = $arr['file_name'];
				}
				$result = $this->weblink_model->add($data);
				$url = base_url('admincp/weblink');
				$this->page->redirect($url);
		
		}
		$temp['data']['catlist']= $this->catelog_model->get_list(array('ticlock'=>0,"parentid"=>0),"sort ASC, Id DESC",20,0);
		$temp['data']['catdeallist']= $this->catdeal_model->get_list(array('ticlock'=>0,"home"=>1,"parentid"=>0),"sort ASC, Id DESC",20,0);
		$temp['template']='admincp/weblink/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->weblink_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Sửa";
		if($this->input->post('save'))
		{
			
				$config['upload_path'] = './data/Banner/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload()){
					$arr =  $this->upload->data();
					$data['images'] = $arr['file_name'];
				}
				$result = $this->weblink_model->update($id,$data,true);
				$this->page->redirect(base_url('admincp/weblink'));
			
		}
		$temp['data']['catlist']= $this->catelog_model->get_list(array('ticlock'=>0,"parentid"=>0),"sort ASC, Id DESC",20,0);
		$temp['data']['catdeallist']= $this->catdeal_model->get_list(array('ticlock'=>0,"home"=>1,"parentid"=>0),"sort ASC, Id DESC",20,0);
		$temp['template']='admincp/weblink/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $info = $this->weblink_model->get_where($id); 
			 $this->weblink_model->delete($id);
			 if(file_exists('./data/Banner/'.$info[0]['images']))
						unlink('./data/Banner/'.$info[0]['images']);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$info = $this->weblink_model->get_where($v); 
					$this->weblink_model->delete($v);
					if(file_exists('./data/Banner/'.$info[0]['images']))
						unlink('./data/Banner/'.$info[0]['images']);
				}
			}
		}
		$this->page->redirect(base_url('admincp/weblink'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->weblink_model->update($k,$data);
				}
			}
		}
		$this->page->redirect(base_url('admincp/weblink'));
	}
}
