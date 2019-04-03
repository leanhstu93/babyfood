<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('user_model');
		 $this->load->model('comment_model');
		 $this->load->helper('url');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/reseller/index'; 
		$temp['idmenu']=3;
		//***-----------------sort---------------
		if($this->input->post('sortitem')){
			$sortitem = $this->input->post('sortitem');
			$sorvalue = $this->input->post('sorvalue');
			if($sorvalue=='0'){
				$sorvalue = 'desc';
			}else $sorvalue = 'asc';
			$this->session->set_userdata('sortuser',$sortitem." ".$sorvalue);
		}
		if( $this->session->userdata('sortuser')){
			$order = $this->session->userdata('sortuser');
		}else{
			$order  = "id DESC";
		}
		$tukhoa =$this->input->get('tukhoa', TRUE)?$this->input->get('tukhoa', TRUE):-1;
		$type_search =$this->input->get('type_search', TRUE)?$this->input->get('type_search', TRUE):-1;
		
		if($type_search==1){
			$sql = "SELECT r1.id,r1.fullname,r1.date,r1.username,r1.phone,r1.ticlock,r1.shop_name,r1.email,r1.hot,r1.end_date,r1.auto_check,r1.lock,
			(SELECT title_vn FROM mn_catelog WHERE mn_catelog.Id = r1.catelog) AS namecatelog,
			(SELECT COUNT(Id) FROM mn_product WHERE mn_product.iduser = r1.id) AS total
			 FROM mn_user AS r1 WHERE ( username = '".$tukhoa."' OR fullname = '".$tukhoa."' OR email = '".$tukhoa."' OR '".$tukhoa."' = -1 ) AND level = '1' ORDER BY ".$order;
			 $sql_count = "SELECT COUNT(r1.id) AS total
			 FROM mn_user AS r1 WHERE  ( username = '".$tukhoa."' OR fullname = '".$tukhoa."' OR email = '".$tukhoa."' OR '".$tukhoa."' = -1 ) AND level = '1'";

		}else{
			$sql = "SELECT r1.id,r1.fullname,r1.date,r1.username,r1.phone,r1.ticlock,r1.shop_name,r1.hot,r1.email,r1.end_date,r1.auto_check,r1.lock,
			(SELECT title_vn FROM mn_catelog WHERE mn_catelog.Id = r1.catelog) AS namecatelog,
			(SELECT COUNT(Id) FROM mn_product WHERE mn_product.iduser = r1.id) AS total
			 FROM mn_user AS r1 WHERE ( username like '%".$tukhoa."%' OR fullname like '%".$tukhoa."%' OR email like '%".$tukhoa."%' OR '".$tukhoa."' = -1 ) AND level = '1' ORDER BY ".$order;
			 $sql_count = "SELECT COUNT(r1.id) AS total
			 FROM mn_user AS r1 WHERE ( username like '%".$tukhoa."%' OR fullname like '%".$tukhoa."%' OR email like '%".$tukhoa."%' OR '".$tukhoa."' = -1 ) AND level = '1'";
		}
		$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
		$temp['data']['total']= $total = $this->user_model->count_query($sql_count);
		$numrow = 50;
		$div = 10;
		$skip = $p * $numrow;
		$link	=	base_url('admincp/reseller?tukhoa='.$tukhoa.'&p=');
		$temp['data']['info'] = $this->user_model->get_query($sql,$numrow,$skip);
		$temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
		
		$temp['data']['tukhoa'] = $tukhoa;
	    $this->load->view("admincp/layout",$temp); 
	}
	public function loginUser($id){
		if($id>0){
			$user = $this->user_model->get_where(array('id'=>$id));
			//var_dump($user);
			$arr= array(
						"login_id" => 1,
						"login_user_id" => $user[0]['id'],
						"login_level" => $user[0]['level'],
						"login_username" => $user[0]['username'],
						"lock_user" => $user[0]['ticlock'],
						"lockt_user" => $user[0]['lockt'],
						"lockt_admin" => 1,		
					);
			$this->session->set_userdata($arr);
			$this->page->redirect(base_url('trang-ca-nhan.html'));
		}
	}
	public function sentemail($id){
		$info =  $this->user_model->get_where(array('id'=>$id),1,0);
		$temp['idmenu']=3;
		$temp['template']='admincp/reseller/sentemail'; 
		$temp['data']['map_title']  = "Đổi mật khẩu";
		
		$mk = $this->page->rand_string(10);
		$pass = md5($mk);
		$arr= array(
			'password' =>$pass,
		);
		$this->user_model->update((int)$id,$arr,FALSE);
		$body .= "<h3>".$info[0]['email']."</h3>";  
		$body .= "Bạn nhận được mail này <br> vì đã yêu cầu lấy lại mật khẩu thành viên tại Oni.vn <br>";
		$body .="Tên đăng nhập: ".$info[0]['username'].".<br>"; 
		$body .="Mật khẩu: ".$mk.".<br>"; 
		$temp['data']['body']  = $body;
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info =  $this->user_model->get_where(array('id'=>$id),1,0);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_message('is_unique','%s đã tồn tại');
		$this->form_validation->set_message('is_natural_no_zero','Vui lòng chọn %s');
		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');;
		$this->form_validation->set_rules('shop_name', 'Tên shop', 'required');
		$this->form_validation->set_rules('address', 'Địa chỉ', 'required');
		$this->form_validation->set_rules('phone', 'Điện thoại', 'required');
		$this->form_validation->set_rules('shop_province','Tỉnh thành','required|is_natural_no_zero');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{	
				$arr['shop_name'] = $this->input->post('shop_name');
				$arr['username'] = $this->input->post('username');
				$arr['address'] = $this->input->post('address');
				$arr['shop_city'] = $this->input->post('shop_city');
				$arr['shop_district'] = $this->input->post('shop_district');
				$arr['shop_province'] = $this->input->post('shop_province');
				$arr['catelog'] = $this->input->post('catelog');
				$arr['phone'] = $this->input->post('phone');
				$arr['shop_website'] = $this->input->post('shop_website');
				$arr['email'] = $this->input->post('email');
				$arr['ticlock'] = $this->input->post('ticlock')?$this->input->post('ticlock'):0;
				$arr['lock'] = $this->input->post('lock')?$this->input->post('lock'):0;
				$arr['auto_check'] = $this->input->post('auto_check')?$this->input->post('auto_check'):0;
				$arr['titlepage'] = $this->input->post('titlepage');	
				$arr['meta_keyword'] = $this->input->post('meta_keyword');	
				$arr['meta_description'] = $this->input->post('meta_description');	
				$this->user_model->update($id,$arr,FALSE);
				redirect(base_url('admincp/reseller'));
			}
		}
		$temp['data']['provinces'] =  $this->pagehtml_model->get_provinces();
		$temp['data']['catelog'] =  $this->pagehtml_model->get_catelog(0); 
		$temp['template']='admincp/reseller/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delcomment()
	{
		$id = $this->uri->segment(4);
		$iduser = $this->uri->segment(5);
		$result = $this->comment_model->delete($id);
		$this->page->redirect(base_url('admincp/reseller/edit/'.$iduser));
	}
	
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->user_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->user_model->delete($v);
				}
			}
		}
		redirect(base_url('admincp/reseller'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->user_model->update($k,$data);
				}
			}
		}
		$this->page->redirect(base_url('admincp/reseller'));
	}
}
