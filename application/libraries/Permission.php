<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permission{
	var $CI = '';
	 function __construct()
    {
        $this->CI =& get_instance();
		$this->CI->load->database();
    }
	function checkAdmin( $module = '', $action = '', $msg = '' )
	{	
		$this->checkSession();
		return true;
	}
	function checkSession()
	{
		
		if($this->CI->session->userdata('login_admin_id')){
			$login_admin_id = $this->CI->session->userdata('login_admin_id');
			if($login_admin_id!=1){
				header('location: /admincp/login');
				exit();
			}else{
				$login_admin_level = $this->CI->session->userdata('login_admin_level');
				if($login_admin_level<=0){
					$this->deny();
				}else if($login_admin_level==2){
					if($control=="website" || $control=="admin" || $control=="adminmenu"  ) $this->deny();
					
				}else if($login_admin_level==3){
						if($control=="website" || $control=="admin" || $control=="adminmenu" || $control=="payment"  || $control=="tags"   ) $this->deny();
				}
			}
		}else{
			header('location: /admincp/login');
			exit();
		}
	}
	function deny(){
		header('location: /admincp/dashboard/denyaccess');
		exit();
	}
	
}
/*End */