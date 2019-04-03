<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	protected $arrowmap = "<img src='/public/template/images/maker2-m.gif' />";
	protected $map_title = '<a href="/">Trang chủ</a>';
	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('provinces_model');
		 $this->load->model('user_model');
		 $this->load->model('product_model');
		 $this->load->model('flash_model');
		 $this->load->model('discount_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
	function urlfacebook(){
		$fb = new Facebook\Facebook([
		  'app_id' => '269938036694238',
		  'app_secret' => '7d2f5bde41a3f556dc3734adf68d4b36',
		  'default_graph_version' => 'v2.5',
		]);
		$helper = $fb->getRedirectLoginHelper();
		$permissions = array('email','user_activities','public_profile','user_birthday','user_photos');   // optional
		$urlfacelogin = $helper->getLoginUrl('http://www.mada.vn/user/loginfacebook', $permissions);
		redirect($urlfacelogin);
	}
	function notlogin(){
		$temp['data'] = NULL;
		$temp['template']='default/user/alert'; 
		$this->load->view("default/layout",$temp); 
	}
	function loginfacebook(){
		$fb = new Facebook\Facebook([
		  'app_id' => '269938036694238',
		  'app_secret' => '7d2f5bde41a3f556dc3734adf68d4b36',
		  'default_graph_version' => 'v2.5',
		]);
		$helper = $fb->getRedirectLoginHelper();
		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		   redirect(base_url('user/notlogin'));
		  //echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		 //echo 'Facebook SDK returned an error: ' . $e->getMessage();
		   redirect(base_url('user/notlogin'));
		  exit;
		}
		
		if (isset($accessToken)) {
		  // Logged in!
		  $this->session->set_userdata('facebook_access_token',(string)$accessToken);
		  $fb->setDefaultAccessToken($accessToken);
			try {
			  	$fields = array('id', 'name', 'email','link');
  				$response = $fb->get('/me?fields='.implode(',', $fields).'', $accessToken);
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  // When Graph returns an error
			 // echo 'Graph returned an error: ' . $e->getMessage();
			   redirect(base_url('user/notlogin'));
			  exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  // When validation fails or other local issues
			  //echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  redirect(base_url('user/notlogin'));
			  exit;
			}
			$userface = $response->getGraphUser();
			$getuser = $this->user_model->get_where(array('email'=>$userface['email'],'idfacebook'=>$userface['id']),10,0,true);
			
			if(empty($getuser)){
				
				$url ='http://graph.facebook.com/'.$userface['id'].'/picture?type=large';
				$contents=file_get_contents($url);
				$avatar = $userface['id'].".jpeg";
				$save_path= FCPATH."/data/User/".$avatar;
				file_put_contents($save_path,$contents); 
				
				$arr['fullname'] = $userface['name'];
				$arr['username'] = $userface['email'];
				$arr['address'] = "";
				$arr['idtinh'] = "";
				$arr['phone'] = "";
				$arr['email'] = $userface['email'];
				$arr['idfacebook'] = 0;
				$arr['avatar'] = $avatar;
				$arr['password'] = md5(rand_string(10)) ;
				$arr['level'] = 1;
				$arr['gender'] = 1;
				$arr['ticlock'] = 0;
				$arr['lock'] = 0;
				$arr['idfacebook'] = $userface['id'];
				$arr['date'] = time();
				$id = $this->user_model->add($arr);
				/*
				$this->load->library('email');
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'utf-8';
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				$noidung =  file_get_contents(BASE_URL."/public/email/socialvoucher.html");
				$noidung =str_replace("{USERNAME}", $userface['email'] ,$noidung);
				$noidung =str_replace("{CODE}", $data['code'] ,$noidung);
				$noidung =str_replace("{VALUE}", $value ,$noidung);
				$this->email->from('cskh@mada.vn', 'Mada.vn');
				$this->email->to($userface['email']);
				$this->email->subject('Nhận voucher đăng ký thành viên từ Mada #'.$data['code']);
				$this->email->message($noidung);
				$this->email->send();*/
			
					
				$arr= array(
					"login_id" => 1,
					"login_user_id" => $id,
					"login_user_username" => $userface['email'],
					"login_email" => $userface['email'],
					"login_user_ticlock" => 0,
					"login_user_level" => 1,
					"login_user_fullname" => $userface['name'],
					"login_user_images" =>$avatar,
				);
				//$this->session->set_userdata($arr_voucher);
				$this->session->set_userdata($arr);				 
			}else{
				$arr= array(
					"login_id" => 1,
					"login_user_id" => $getuser[0]['id'],
					"login_email" => $getuser[0]['email'],
					"login_user_ticlock" => $getuser[0]['ticlock'],
					"login_user_fullname" => $getuser[0]['fullname'],
					"login_user_username" => $getuser[0]['username'],
					"login_user_level" => $getuser[0]['level'],
					"login_user_images" =>$getuser[0]['avatar'],
				);
				$this->session->set_userdata($arr);
			}
			$this->cache->clean();
			$this->load->view("default/user/scriptload");
			
		}
	}
	public function urlgoogle(){
		$google_client_id 		= '287023163008-bdcss6f1hpe85qvb9mrocst6h17glfep.apps.googleusercontent.com';
		$google_client_secret 	= 'XvXnL9u56JZ8o9cgnB7mko5D';
		$google_redirect_url 	= 'http://www.mada.vn/dang-nhap-google'; //path to your script
		$google_developer_key 	= 'AIzaSyAsRInmPLf4vEIpLiaiyPAX60YCl-BMVOQ';
		require_once FCPATH.'api/Google/Google_Client.php';
		require_once FCPATH.'api/Google/contrib/Google_Oauth2Service.php';
		
		$gClient = new Google_Client();
		$gClient->setApplicationName('Login to Mada.vn');
		$gClient->setClientId($google_client_id);
		$gClient->setClientSecret($google_client_secret);
		$gClient->setRedirectUri($google_redirect_url);
		$gClient->setDeveloperKey($google_developer_key);
		
		$google_oauthV2 = new Google_Oauth2Service($gClient);
		
		//If user wish to log out, we just unset Session variable
		if ($this->input->get('reset')) 
		{
			
		  $this->session->unset_userdata('token');
		  $gClient->revokeToken();
		  redirect(filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
		}
		
		//If code is empty, redirect user to google authentication page for code.
		//Code is required to aquire Access Token from google
		//Once we have access token, assign token to session variable
		//and we can redirect user back to page and login.
		
		if ($this->input->get('code')) 
		{ 

			$gClient->authenticate($this->input->get('code'));
			$this->session->set_userdata('token',$gClient->getAccessToken());
			redirect(filter_var($google_redirect_url, FILTER_SANITIZE_URL));
			return;
		}
		
		
		if ($this->session->userdata('token')) 
		{ 
			$gClient->setAccessToken($this->session->userdata('token'));
		}
		
		
		if ($gClient->getAccessToken()) 
		{
			  //For logged in user, get details from google using access token
			  $user 				= $google_oauthV2->userinfo->get();
			  $user_id 				= $user['id'];
			  $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
			  $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
			  $profile_url 			= filter_var($user['link'], FILTER_VALIDATE_URL);
			  $profile_image_url 	= filter_var($user['picture'], FILTER_VALIDATE_URL);
			  //$personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
			  $this->session->set_userdata('token',$gClient->getAccessToken());
		}
		else {
			//For Guest user, get google login url
			$authUrl = $gClient->createAuthUrl();
		}
		
		if(isset($authUrl)) //user is not logged in, show login button
		{
			redirect($authUrl);
		} 
		else // user logged in 
		{	
			
			$getuser = $this->user_model->get_where(array('email'=>$user['email'],'idfacebook'=>$user['id']),10,0,true);
			
			if(empty($getuser)){
				
				$contents=file_get_contents($user['picture']);
				$avatar = $user['id'].".jpeg";
				$save_path= FCPATH."/data/User/".$avatar;
				file_put_contents($save_path,$contents); 
				
				$arr['fullname'] = $user['name'];
				$arr['username'] = $user['email'];
				$arr['address'] = "";
				$arr['idtinh'] = "";
				$arr['phone'] = "";
				$arr['email'] = $user['email'];
				$arr['avatar'] = $avatar;
				$arr['password'] = md5(rand_string(10)) ;
				$arr['level'] = 1;
				$arr['gender'] = 1;
				$arr['ticlock'] = 0;
				$arr['lock'] = 0;
				$arr['idfacebook'] = $user['id'];
				$arr['date'] = time();
				$id = $this->user_model->add($arr);
				/*
				$this->load->library('email');
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'utf-8';
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				$noidung =  file_get_contents(BASE_URL."/public/email/socialvoucher.html");
				$noidung =str_replace("{USERNAME}", $$arr['email'] ,$noidung);
				$noidung =str_replace("{CODE}", $data['code'] ,$noidung);
				$noidung =str_replace("{VALUE}", $value ,$noidung);
				$this->email->from('cskh@mada.vn', 'Mada.vn');
				$this->email->to($arr['email']);
				$this->email->subject('Nhận voucher đăng ký thành viên từ Mada #'.$data['code']);
				$this->email->message($noidung);
				$this->email->send();*/
				
				$arr= array(
					"login_id" => 1,
					"login_user_id" => $id,
					"login_user_username" => $user['email'],
					"login_email" => $user['email'],
					"login_user_ticlock" => 0,
					"login_user_level" => 1,
					"login_user_fullname" => $user['name'],
					"login_user_images" =>$avatar,
				);
				//$this->session->set_userdata($arr_voucher);
				$this->session->set_userdata($arr);
				 
			}else{
				$arr= array(
					"login_id" => 1,
					"login_user_id" => $getuser[0]['id'],
					"login_email" => $getuser[0]['email'],
					"login_user_ticlock" => $getuser[0]['ticlock'],
					"login_user_fullname" => $getuser[0]['fullname'],
					"login_user_username" => $getuser[0]['username'],
					"login_user_level" => $getuser[0]['level'],
					"login_user_images" =>$getuser[0]['avatar'],
				);
				$this->session->set_userdata($arr);
			}
			$this->cache->clean();
			$this->load->view("default/user/scriptload");
		}
	}
	public function urltwitter(){
		require_once FCPATH.'api/Twitter/twitteroauth.php';
		//Fresh authentication
		$oauth_token =  $this->input->get('oauth_token');
		$token_witter = $this->session->userdata('token_witter');
		if(isset($oauth_token) &&  $token_witter !== $oauth_token) {
			 $this->session->unset_userdata('token_witter');
			 $this->session->unset_userdata('token_secret');
				echo "1"; die;
			redirect(base_url('user/notlogin'));
		}else if(isset($oauth_token) && $token_witter == $oauth_token) {
			$token_secret = $this->session->userdata('token_secret');
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $token_witter , $token_secret);
			$oauth_verifier = $this->input->get('oauth_verifier'); 
			$access_token = $connection->getAccessToken($oauth_verifier);
			if($connection->http_code == '200')
			{
				
				$this->session->set_userdata('status_witter','verified');
				$this->session->set_userdata('request_vars',$access_token);
				$user = $connection->get('account/verify_credentials',array('include_email')); 
				$getuser = $this->user_model->get_where(array('email'=>$user->email,'idfacebook'=>$user['id']),10,0,true);
				if(empty($getuser)){
					
					$contents=file_get_contents($user['picture']);
					$avatar = $user['id'].".jpeg";
					$save_path= FCPATH."/data/User/".$avatar;
					file_put_contents($save_path,$contents); 
					
					$arr['fullname'] = $user['name'];
					$arr['username'] = $user['email'];
					$arr['address'] = "";
					$arr['idtinh'] = "";
					$arr['phone'] = "";
					$arr['email'] = $user['email'];
					$arr['avatar'] = $avatar;
					$arr['password'] = md5(rand_string(10)) ;
					$arr['level'] = 1;
					$arr['gender'] = 1;
					$arr['ticlock'] = 0;
					$arr['lock'] = 0;
					$arr['idfacebook'] = $user['id'];
					$arr['date'] = time();
					$id = $this->user_model->add($arr);
					
					/*
					$this->load->library('email');
					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['charset'] = 'utf-8';
					$config['mailtype'] = 'html';
					$config['wordwrap'] = TRUE;
					$this->email->initialize($config);
					$noidung =  file_get_contents(BASE_URL."/public/email/socialvoucher.html");
					$noidung =str_replace("{USERNAME}", $arr['email'] ,$noidung);
					$noidung =str_replace("{CODE}", $data['code'] ,$noidung);
					$noidung =str_replace("{VALUE}", $value ,$noidung);
					$this->email->from('cskh@mada.vn', 'Mada.vn');
					$this->email->to($arr['email']);
					$this->email->subject('Nhận voucher đăng ký thành viên từ Mada #'.$data['code']);
					$this->email->message($noidung);
					$this->email->send();*/
					
					$arr= array(
						"login_id" => 1,
						"login_user_id" => $id,
						"login_user_username" => $user['email'],
						"login_email" => $user['email'],
						"login_user_ticlock" => 0,
						"login_user_level" => 1,
						"login_user_fullname" => $user['name'],
						"login_user_images" =>$avatar,
					);
					//$this->session->set_userdata($arr_voucher);
					$this->session->set_userdata($arr);
					 
				}else{
					$arr= array(
						"login_id" => 1,
						"login_user_id" => $getuser[0]['id'],
						"login_email" => $getuser[0]['email'],
						"login_user_ticlock" => $getuser[0]['ticlock'],
						"login_user_fullname" => $getuser[0]['fullname'],
						"login_user_username" => $getuser[0]['username'],
						"login_user_level" => $getuser[0]['level'],
						"login_user_images" =>$getuser[0]['avatar'],
					);
					$this->session->set_userdata($arr);
					$this->output->delete_cache('/home/index');
				}
				unset($_SESSION['token']);
				unset($_SESSION['token_secret']);
				$this->load->view("default/user/scriptload");
			}else{
				redirect(base_url('user/notlogin'));
			}
		}else{
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
			$request_token = $connection->getRequestToken(OAUTH_CALLBACK);
			//Received token info from twitter
			
			$this->session->set_userdata('token_witter',$request_token['oauth_token']);
			$this->session->set_userdata('token_secret',$request_token['oauth_token_secret']);
		
			//Any value other than 200 is failure, so continue only if http code is 200
			if($connection->http_code == '200')
			{
				//redirect user to twitter
				$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
				redirect($twitter_url); 
			}else{
				redirect(base_url('user/notlogin'));
			}
		}
	}
	public function  login(){
		$username = $this->input->post('email');
		$password = $this->input->post('password');
		//--------check form----------------
		$error  = false;
		$mess=  array('login_id'=>1);
		if(empty($username)){
			$error = true;
			$mess['email-login'] = "Email không được bỏ trống";
		}
		if(empty($password)){
			$error = true;
			$mess['pass-login'] = "Mật khẩu không được bỏ trống";
		}
		if($error==false && $this->login_check($username,$password)==false){
			$error = true;
			$mess['pass-login'] = "Tài khoản mật khẩu không chính xác";
			$mess['email-login'] = "Tài khoản mật khẩu không chính xác";
		}
		if($error==false){
			$user = $this->user_model->get_user_pass($username,$password);
			$arr= array(
				"login_id" => 1,
				"login_user_id" => $user[0]['id'],
				"login_username" => $user[0]['username'],
				"login_email" => $user[0]['email'],
				"login_user_level" => $user[0]['level'],
				"login_user_ticlock" => $user[0]['ticlock'],
				"login_user_lock" => $user[0]['lock'],
				"login_user_fullname" => $user[0]['fullname'],
				"login_user_images" =>$user[0]['avatar'],
			);
			$this->session->set_userdata($arr);	
		}
		die(json_encode(array("err"=>$error,"mess"=>$mess)));
	}
	
	public function login_check($email,$password){
		$user = $this->user_model->get_user_pass($email,$password);
		if(empty($user)){
			return false;
		}else{
			return true;
		}
	}
	
	public function checklogin(){
		$this->load->model('gifts_model');
		$userid = $this->session->userdata('login_user_id');
		$c_status = $this->gifts_model->check_status($userid);
		
		if(!$this->input->is_ajax_request()) die(json_encode(array('err'=>'No direct script access allowed')));
		$login_id = $this->session->userdata('login_id');
		
		if($login_id!=1){
			echo json_encode( array('type' => 0, 'msg' => 'Bạn vui lòng đăng nhập để Share sản phẩm!'));
			die;	
		}
		if($c_status['status']==1){
			echo json_encode(array('check_status' => 1, 'msg'=>'Tài khoản của bạn đã thăm gia share link sản phẩm'));							 			die;
		}
		else{
			echo json_encode(array('type' => 1));	
		}
		
	}

	public function register(){
		
		//if(!$this->input->is_ajax_request()) die(json_encode(array('err'=>'No direct script access allowed')));
		
		if($this->input->post('save')){
			
			$error  = false;
			$mess=  array('login_id'=>1);
			$fullname = $this->input->post('fullname');
			$email = $this->input->post('email');
			$password  = $this->input->post('password');
			$repassword  = $this->input->post('repassword');
			$phone  = $this->input->post('phone');
			$captcha_code = $this->session->userdata('captcha');
			$captcha = $this->input->post('captcha');
						
			if(empty($fullname)){
				$error = true;
				$mess['fullname-regitser']= "Họ và tên không được để trống";
			}
			if(empty($phone)){
				$error = true;
				$mess['phone-regitser']= "Số Điện thoại không được bỏ trống ";
			}elseif($this->check_phone($phone)==false){
				$error = true;
				$mess['phone-regitser']= "Số điện thoại đã tồn tại";
			}elseif(!is_numeric($phone)){
				$error = true;
				$mess['phone-regitser']= "Số điện thoại không hợp lệ";	
			}
			if(empty($email)){
				$error = true;
				$mess['email-regitser']= "Địa chỉ Email không được để trống";
			}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error = true;
				$mess['email-regitser']= "Địa chỉ Email không đúng định dạng";
			}elseif($this->check_email($email)==false){
				$error = true;
				$mess['email-regitser']= "Địa chỉ Email đã tồn tại";
			}
			if(strlen($password)<6){
				$error = true;
				$mess['pass-regitser']= "Mật khẩu phải ít nhất 6 ký tự!";
			}
			if(empty($password)){
				$error = true;
				$mess['pass-regitser']= "Mật khẩu không được để trống";
			}else if($password != $repassword){
				$error = true;
				$mess['repass-regitser']= "Mật khẩu không khớp";
			}
			/*if(empty($captcha_code)){
				$error = true;
				$mess['captcha-regitser']= "Mã bảo vệ không được bỏ trống ";
			}
			if($captcha_code !=$captcha){
				$error = true;
				$mess['captcha-regitser'] ="Mã bảo vệ không hợp lệ";	
			}*/
			
			if($error==false){
					$arr['fullname'] = $fullname;
					$arr['username'] = $email;
					$arr['address'] = "";
					$arr['idtinh'] = 0;
					$arr['phone'] = $phone;
					$arr['email'] = $email;
					$arr['idfacebook'] = 0;
					$arr['avatar'] = "";
					$arr['password'] = md5($password);
					$arr['level'] = 1;
					$arr['gender'] = 1;
					$arr['ticlock'] = 0;
					$arr['lock'] = 0;
					$arr['date'] = time();
					$id = $this->user_model->add($arr);
					$arr= array(
						"login_id" => 1,
						"login_user_id" => $id,
						"login_username" =>$arr['username'],
						"login_email" => $arr['email'],
						"login_user_level" =>1,
						"login_user_fullname" =>$arr['fullname'],
						"login_user_images" =>$arr['avatar'],
						"login_user_ticlock" =>0, 
						"login_user_lock" =>0,
					);
					$this->session->set_userdata($arr);
					$this->output->delete_cache('Home/index');
					
			}
			die(json_encode(array("err"=>$error,"mess"=>$mess))); 
			
		}else{
			$temp['template']='default/user/m_register';
			$this->load->view("default/layoutMobile",$temp); 
		}
	}
	
	public function thanks(){
		$sort='Id DESC';
		$sql = "SELECT mn_product.*,
			 	(SELECT SUM(star)  as total FROM mn_comment 
				WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS star,
				(SELECT COUNT(Id) as total FROM mn_comment 
				WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS countstar
				FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE  mn_product.ticlock=0 AND mn_product.trash=0  AND mn_product.hot=1 
				 
				 GROUP BY Id
				 ORDER BY ".$sort;
		
		$data['info'] = $this->product_model->get_query($sql, 20, 0);
		
		if(USERTYPE=='Mobile'){
			$data['template']='default/user/m_thanks';
			$this->load->view("default/layoutMobile",$data); 
		}else{
			$this->load->view('default/user/thanks', $data);
		}
		
		
	}
	public function member(){
		$data = NULL;
		$this->load->view('default/user/member', $data);
	}
	
	public function check_email($email){
		$total = $this->user_model->count_where(array('email'=>$email));
		if($total>=1){
			return false;
		}else{
			return true;
		}
	}
	public function check_phone($phone){
		$total = $this->user_model->count_where(array('phone'=>$phone));
		if($total>=1){
			return false;
		}else{
			return true;
		}
	}
	public function district($id){
		 $provinces = $this->provinces_model->list_district(array('idcat'=>$id,"ticlock"=>0));
		 echo '<option value="">Chọn Quận/Huyện</option>'; 
		 if(!empty($provinces)){
		 	foreach($provinces as $item){
				echo '<option value="'.$item["Id"].'">'.$item["title_vn"].'</option>'; 
			}
		 }
		 die;	
	}
	public function follow($id,$type){ 
		$this->load->model('follow_model');
		$iduser = $this->session->userdata('login_user_id');
		if($iduser<=0) die(json_encode(array('err'=>true,"mess"=>"Đăng nhập để sử dụng tính năng này"))); 
		if($iduser < 0 || $id<0 || $type<0) die(json_encode(array('err'=>true,"mess"=>"Lỗi theo dõi"))); 
		if($type==0){
			
			$total = (int)$this->follow_model->count_where(array("iduser"=>$iduser,"idpro"=>$id));
			if(!isset($total)) $total = 0;
			if($total <= 0){
				$arr  = array(
					"iduser" => $iduser,
					"idpro" =>$id,
				);
				$this->follow_model->add($arr);  
				$this->createFile($iduser.'_'.$id,1,"data/Follow/"); 
			}
		}else{
			$this->follow_model->delete(array("iduser"=>$iduser,"idpro"=>$id));
			$dir = FCPATH.'data/Follow/'.$iduser.'_'.$id;
			@unlink($dir);	
		}
		die(json_encode(array('err'=>false))); 
	}
	public function createFile($id, $data,$dirS='data/Upuser/') {
       $dir = FCPATH.$dirS.$id; 
        $file = fopen($dir, 'w+');
        if (flock($file, LOCK_EX)) { // exclusive lock
            fwrite($file, $data);
            flock($file, LOCK_UN); // lock released
			fclose ($file); 
            return TRUE;
        } else
            return FALSE;
    }
	
	public function birthday_check($date){
		$nam  = $this->input->post('nam');
		$thang  = $this->input->post('thang');
		$ngay  = $this->input->post('ngay');
		return false;
	}
	public function  logout(){
		$this->session->unset_userdata('login_id');
		$this->session->unset_userdata('login_user_id');
		$this->session->unset_userdata('login_user_level');
		$this->session->unset_userdata('login_username');
		$this->session->unset_userdata('login_email');
		$this->session->unset_userdata('login_user_fullname');
		$this->session->unset_userdata('login_user_level');
		$this->session->unset_userdata('login_shop_name');
		$this->session->unset_userdata('login_user_ticlock');
		$this->session->unset_userdata('login_user_lock');
		//$this->session->unset_userdata('value');
		//$this->session->unset_userdata('code');
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('toltal_sale');
		$this->session->unset_userdata('code');
		$this->session->unset_userdata('code_type'); 
		$this->cache->clean(); 
		redirect(base_url());
	}
	public function  forgot(){
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('valid_email','Địa chỉ email không hợp lệ'); 
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_emailforgot_check');
		$this->form_validation->set_error_delimiters('<br/><span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$email = $this->input->post('email');
				$user = $this->user_model->checkEmail($email);
				$mk = $this->page->rand_string(10);
				$pass = md5($mk);
				$arr= array(
					'password' =>$pass,
				);
				$this->user_model->update($user[0]['id'],$arr,FALSE);
				
				$this->load->library('email');
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'utf-8';
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				
				$subject = "Email  yêu cầu lấy lại mật khẩu";
				$body .= "Bạn nhận được mail này <br> vì đã yêu cầu lấy lại mật khẩu thành viên tại Mada.vn <br>";
				$body .="Email đăng nhập: ".$user[0]['email'].".<br>"; 
				$body .="Mật khẩu: ".$mk.".<br>"; 
				
				$this->email->from('info@mada.vn', 'Mada.vn');
				$this->email->to($user[0]['email']);
				$this->email->subject($subject);
				$this->email->message($body);
				$this->email->send();
				
				redirect(base_url('user/success'));	
				
			}
		}
		$temp['template']='default/user/forgot'; 
		$this->load->view("default/layout",$temp); 
	}
	public function emailforgot_check($email){
		$user = $this->user_model->checkEmail($email);
		if(empty($user)){
			$this->form_validation->set_message('emailforgot_check', '{field} không tồn tại trên hệ thống');
			return false;
		}else{
			return true;
		}
	}
	public function notaccess(){
		$temp['data']= NULL;
		$iduser = $this->session->userdata('login_user_id');
		if($iduser>0) redirect(base_url('thong-tin-ca-nhan.html'));
		if(USERTYPE=='Mobile'){
			$temp['template']='default/user/m_login';
			$this->load->view("default/layoutMobile",$temp); 
		}else{
			$temp['template']='default/user/notaccess'; 
			$this->load->view("default/layout",$temp); 
		}
	}
	public function  successfull(){
		$temp['data']= NULL;
		$temp['template']='default/user/successfull'; 
		$this->load->view("default/layout",$temp); 
	}
	public function  ticlock(){
		$temp['data']= NULL;
		$temp['template']='default/user/ticlock'; 
		$this->load->view("default/layout",$temp); 
	}
	public function  lock(){
		$temp['data']= NULL;
		$temp['template']='default/user/lock'; 
		$this->load->view("default/layout",$temp); 
	}
	public function  success(){
		$temp['data']= NULL;
		$temp['template']='default/user/success'; 
		$this->load->view("default/layout",$temp); 
	}
	public function  show_alert(){ 
		$this->load->model('follow_model');
		$iduser = $this->session->userdata('login_user_id');
		$sql = "SELECT date,ticlock,view,(SELECT fullname FROM mn_user WHERE mn_user.id = mn_follow.iduser) AS fullname,
				(SELECT shop_name FROM mn_user WHERE mn_user.id = mn_follow.iduser) AS shop_name,
				(SELECT level FROM mn_user WHERE mn_user.id = mn_follow.iduser) AS level
				FROM mn_follow WHERE  ticlock ='0' AND idshop = '".$iduser." ORDER BY date DESC'
				";
		$temp['info']= $this->product_model->get_query($sql,5,0);
		$this->load->view("default/persion/show_alert",$temp); 
	}
	public function formlogin(){
		//-----------code facebook------------
		$fb = new Facebook\Facebook([
		  'app_id' => '256178458062923',
		  'app_secret' => '9c231d70a83ed031d0796465fea84dd4',
		  'default_graph_version' => 'v2.5',
		]);
		$helper = $fb->getRedirectLoginHelper();
		$permissions = array('email','user_activities','public_profile','user_birthday','user_photos');   // optional
		$temp['urlfacelogin'] = $helper->getLoginUrl('http://mada.vn/user/loginfacebook', $permissions);
		$this->load->view("default/user/formlogin",$temp); 
	}
	public function formregister(){
		$temp = NULL;
		$this->load->view("default/user/formregister",$temp); 
	
	}
	public function fastpayment(){
		$temp = NULL;
		$this->load->view("default/user/fastpayment", $temp);
	}
	function smtpmailer($from,$to,$subject,  $body, $from_name='Webgiasi.vn') {
		global $error;
		require(FCPATH."phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();  // tạo một đối tượng mới từ class PHPMailer
		$mail->IsSMTP(); // bật chức năng SMTP
		$mail->SMTPDebug = 0;  // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
		$mail->SMTPAuth = true;  // bật chức năng đăng nhập vào SMTP này
		$mail->SMTPSecure = "ssl"; // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->Mailer = "smtp";
		$mail->Username = "webgiasi1@gmail.com";
		$mail->Password = "vanquyen";
		$mail->SetFrom($from, $from_name);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($to);
		if(!$mail->Send()) {
			log_message('error', $to.":".$mail->ErrorInfo);
			return false;
		} else {
			//$error = "thư của bạn đã được gởi đi ";
		return true;
		}
	}
	
	public function get_discount_today($user_id){
		$array_voucher = array(
			1  => 0,
			2 => 2,
			3 => 4,
			4 => 5,
			5 => 50,
			6 => 6
		);
		
		$choise = $this->rand_voucher($array_voucher);
		
		$data = array(
					'user_id' => $user_id,
					'created' => time(),
					'status' => 0,
				);
		
		if($choise && $choise != 6 ){
			$num_voucher = $this->discount_model->get_by_value($choise);
			if( $num_voucher >= $array_voucher[$choise]){
				$choise = 6;
			}
		} else {
			$choise  = 6;
		}
		if($choise != 6){
			$data['value'] = $choise;
			$data['voucher'] = '1';
			//echo 'trung '.$choise;
			//echo "<br>";
		} else {
			$data['value'] = 6;
			$data['voucher'] = '0';
			//echo 'trat -'.$choise;
			//echo "<br>";
		}
		$start_day = strtotime(date('Y-m-d 00:00:00', time()));
		$end_day = strtotime('+1 month');
		$data['code'] = $this->create_code($data['value'], $start_day, $end_day);
		$this->discount_model->add($data);
		return $data;
		
		
	}
	
	private function rand_voucher($array_voucher){
		$total = 0;
		foreach($array_voucher as $_number){
			$total += $_number;
		}
		$random = rand(1, $total);
		$giatri = 0;
		foreach($array_voucher as $_key => $value){
			$giatri += $value;
			if($random <= $giatri){
				return $_key;
			}
		}
		return FALSE;
	}
	
	private function create_code($value, $start_day, $end_day){
		$code = $this->check_rand_code($this->page->RandomString());
		$voucher_type = $this->discount_model->get_voucher_type_by_id($value);
		if($voucher_type){
			$data = array(
				'code' => $code,
				'status' => 0,
				'start_day' => $start_day,
				'end_day' => $end_day,
				'price' => $voucher_type['price'],
				'type' => $voucher_type['type']
			);
			if($voucher_id = $this->discount_model->insert_voucher($data)){
				return $code;
			}
		}
		return FALSE;
		
	}
	private function check_rand_code($radom){
		$query = $this->db->get_where('mn_voucher', array('code' => $radom),100, 0);
		$row = $query->row_array();
		if(!empty($row)){
			$this->check_rand_code($this->page->RandomString());
		}else{
			return $radom;
		}	
	}
}
