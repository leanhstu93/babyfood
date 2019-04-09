<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {
	protected $arrowmap = " | ";
	protected $map_title = '<a href="/">Trang chủ</a>';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('catelog_model');
		$this->load->model('catdeal_model');
		$this->load->model('user_model');
		$this->load->model('manufacturer_model');
		$this->load->model('bmenu_model');
		$this->load->model('menu_model');
		$this->load->model('deal_model');
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
	public function changeviews($id){
		$this->session->set_userdata('gridviews',$id);
	}
	public function index()
	{
		$this->load->view('default/landing/index');	
	}

	public function primetime()
	{
		$this->load->view('default/landing/primetime');	
	}
	
	
}
