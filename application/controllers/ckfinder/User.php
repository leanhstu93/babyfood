<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	
	public function connector()
	{
		$login_admin_id = $this->session->userdata('login_admin_id');
		$login_id = $this->session->userdata('login_id');
		if($login_admin_id==1){
			$login_admin_username = $this->session->userdata('login_admin_username');
			define('USER_CAN_CKDINDER',true);
			$dir = 'data/Upload';
			define('UPLOAD_PATH_DATA',$dir);
		}else if($login_id=1){
			$login_username = $this->session->userdata('login_username');
			$login_user_level = $this->session->userdata('login_user_level');
			if($login_user_level==1){
				define('USER_CAN_CKDINDER',true);
				$dir = 'data/Upload/'.$login_username;
				define('UPLOAD_PATH_DATA',$dir);
			}else{
				define('USER_CAN_CKDINDER',false);
			}
		}else{
			define('USER_CAN_CKDINDER',false);
		}
		require_once("./public/ck/ckfinder/core/connector/php/connector.php");
		
	}
	public function html()
	{

		$this->load->view("ckfinder/user"); 
		
	}
}