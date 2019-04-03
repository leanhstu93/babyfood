<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		  $this->load->model('adminmenu_model');
		
	}
	public function index()
	{
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
		
	     $this->load->view("admincp/layout",$temp); 
	}
	public function webadmin(){
		$this->page->redirect(base_url('admincp/product'));
		
	}
	public function denyaccess(){
		
		 $temp['idmenu'] = 3;
		 $temp['template']='admincp/dashboard/denyaccess';
		 $this->load->view("admincp/layout",$temp);  
	}
	
}
