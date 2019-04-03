<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('contact_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		
		$temp['template']='admincp/contact/index'; 
		$temp['idmenu']=3;
		$order  = "Id DESC";
		$tukhoa = $this->input->get('tukhoa', TRUE);
		if(empty($tukhoa)){
			$p = $this->uri->segment(4);
			$numrow = 50;
			$div = 10;
			$skip = $p * $numrow;
			$link  = base_url("admincp/contact/index/");
			//*---------------pagination------------------
			$sql = "SELECT * FROM mn_contact  ORDER BY ".$order;
			
			$sql_total = "SELECT  COUNT(Id) AS total FROM mn_contact ";
			$temp['data']['total'] = $this->contact_model->count_query($sql_total); 
			$temp['data']['info'] = $this->contact_model->get_query($sql,$numrow,$skip);
			$temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
			
		}else{
		 $sql = "SELECT * FROM mn_contact  WHERE ( email like  '%".$tukhoa."%') OR (  phone like  '%".$tukhoa."%') OR ( fullname like  '%".$tukhoa."%') ORDER BY ".$order;
		   
			$sql_toal = "SELECT COUNT(mn_contact.Id) AS total FROM mn_contact WHERE ( email like  '%".$tukhoa."%') OR ( phone like  '%".$tukhoa."%') OR ( fullname like  '%".$tukhoa."%') "; 
			
			$config['base_url']	=	base_url('admincp/contact/index?tukhoa='.$tukhoa.'&p=');
			//*---------------pagination------------------
			$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
			$numrow = 50;
			$div = 10;
			$skip = $p * $numrow;
			$temp['data']['info'] = $this->contact_model->get_query($sql,$numrow,$skip);
			$temp['data']['total'] = $this->contact_model->count_query($sql_toal); 
			$temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
		} 
	
		$this->load->model('product_model');
		$this->load->model('deal_model');
	   $this->load->view("admincp/layout",$temp); 
	}
	
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->contact_model->get_Id($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Xem";
		$this->contact_model->update($id,array('view'=>1));
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				
				redirect(base_url('admincp/contact'));
			}
		}
		$temp['template']='admincp/contact/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->contact_model->delete($id);
			
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->contact_model->delete($v);
					
				}
			}
		}
		redirect(base_url('admincp/contact'));
	}

	public function save()
	{
		
		if($this->input->post('price_sale')) {
			$checked = $this->input->post("price_sale");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sale_price'] = str_replace(".","",$v);
					$this->contact_model->update($k,$data);
				}
			}
		}

		redirect(base_url('admincp/contact'));
	}
	
}

