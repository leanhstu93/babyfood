<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
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
		$this->load->model('flash_model');
		$this->load->model('menu_model');
		$this->load->model('news_model');
		$this->load->model('deal_model');
		$this->load->model('tags_model');
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

		$this->load->model('catnews_model');
	}
	public function changeviews($id){
		$this->session->set_userdata('gridviews',$id);
	}
	public function index($p=0)
	{
		$p  = $this->input->get('page', TRUE);
		/*$sql = "SELECT mn_catelog.Id as catelog_id,mn_catelog.title_vn as catelog_title, mn_catelog.parentid, count(mn_product.Id) AS total_id
						,mn_product.idcat as pr_idcat,  mn_catelog.alias
				FROM mn_catelog 
				INNER JOIN mn_product
				ON mn_product.idcat = mn_catelog.Id AND mn_catelog.ticlock = 0 AND mn_product.trash = 0
				GROUP BY catelog_id
				ORDER BY total_id ASC";*/
		$sql = "SELECT mn_catelog.Id as catelog_id,mn_catelog.title_vn as catelog_title, mn_catelog.parentid,mn_catelog.alias,  mn_catelog.ticlock
				FROM mn_catelog 
				WHERE hot=1 AND ticlock=0
				ORDER BY catelog_id ASC";

		$sql1 = "SELECT * FROM  mn_product WHERE status = 0 AND ticlock = 0 AND trash = 0";
		//$sql1 ="SELECT * FROM  mn_product 
			 	 // WHERE idcat IN (".$info_cat[0]['Id'].",".$subid.") AND ticlock = 0  AND trash = 0 AND status = 0
			 	 // GROUP BY Id
			 	 // ORDER BY Id";

		/*$sql2 = "SELECT mn_manufacturer.Id, mn_manufacturer.title_vn, mn_manufacturer.idcat, mn_manufacturer.images, mn_manufacturer.alias
				FROM  mn_manufacturer
				INNER JOIN mn_catelog
				ON mn_manufacturer.idcat = mn_catelog.Id AND mn_manufacturer.ticlock = 0
				GROUP BY mn_manufacturer.Id
				ORDER BY mn_catelog.Id ASC";*/
	
		$numrow = 100;
		$skip = $p * $numrow;
		
		$temp['data']['info_ct']= $this->product_model->get_query($sql,$numrow,$skip);
		$info_pr = $this->product_model->get_query($sql1,$numrow,$skip,true);
		$temp['data']['info_pr']= $info_pr;
		$temp['data']['cateloghome']  = $this->catelog_model->get_list(array('ticlock'=>0,/*'home'=>1,*/"parentid"=>0),'sort ASC, Id DESC',100,0);
		
		//$temp['data']['menu']  = $this->catelog_model->list_data();
		$temp['data']['menu']  = $this->catelog_model->get_list(array('ticlock'=>'0'),0,0);
		
		// $temp['data']['banner_left'] = $this->pagehtml_model->get_on_list_weblink(array('style'=>6, 'layout'=>'L'),1);
		// $temp['data']['banner_center'] = $this->pagehtml_model->get_on_list_weblink(array('style'=>6, 'layout'=>'C'),2);
		// $temp['data']['banner_right'] = $this->pagehtml_model->get_on_list_weblink(array('style'=>6, 'layout'=>'R'),1);
		$temp['data']['banner_under_slide'] = $this->pagehtml_model->get_on_list_weblink(array('style'=>5, 'layout'=>'', 'ticlock'=>'0'),3);
		$temp['data']['slide_home'] = $this->pagehtml_model->get_on_list_weblink(array('style'=>1, 'layout'=>'', 'ticlock'=>'0'),10);
		$temp['data']['banner_danhmuc'] = $this->pagehtml_model->get_on_list_weblink(array('style'=>3, 'layout'=>'', 'ticlock'=>'0'),20);
		$temp['data']['banner_right_slide'] = $this->pagehtml_model->get_on_list_weblink(array('style'=>7, 'layout'=>'', 'ticlock'=>'0'),2);
 		$temp['data']['product_views'] = $this->product_model->getMostView(2);
		$temp['template']='default/home/index';
		$this->load->view("default/layout",$temp);
	}

	public function detail($alias){
		$temp['data']['idcat'] = 0;
		$temp['data']['info'] = $info = $this->news_model->get_list(array('alias'=>$alias));
		if(!$alias || empty($info)) redirect(base_url('404.html'));
		$temp['meta']['title'] = strip_tags($info[0]['title_vn']);
		
		$temp['data']['cat'] = $this->catnews_model->get_where($info[0]['idcat']);
		//$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "'.base_url('bai-viet/'.$info[0]['alias']).'" >'.base_url('bai-viet/').'</a>';
		$temp['data']['baiviet'] = $this->pagehtml_model->get_newsidcat(10,10,0);
		$temp['data']['all_tag'] = $this->catelog_model->list_data();
		$temp['template']='default/home/page';
		$this->load->view("default/layout",$temp); 
	}

	public function contact(){
		$this->load->model('contact_model');
		$fullname = $this->input->post('fullname');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$content = $this->input->post('note');
		$mess = "Nhập thông tin cần thiết";

		if($fullname=="") { $mess = "Nhập họ tên"; $key = "#fullname-contact"; }
		else if($email=="") { $mess = "Nhập email"; $key = "#email-contact";  }
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $mess = "Email không đúng định dạng"; $key = "#email-contact"; }
		else if($content==""){  $mess = "Nhập nội dung cần gửi"; $key = "#content-contact"; }
		else {
			$arr = array(
				"email" =>$email,
				"fullname" =>$fullname,
				"phone" =>$phone,
				"note"=> $content,
				"date"	=>time(),
			);
			$this->contact_model->add($arr);

			$mess = "Gửi thông tin liên hệ thành công. Chúng tôi sẽ sớm liên hệ với bạn !";
			$this->session->set_flashdata('message_success', $mess);
			//die(json_encode(array('err'=>"false","mess"=>$mess)));
			redirect(base_url());
		}
		//die(json_encode(array('err'=>"true","mess"=>$mess,"key"=>$key)));
		$this->session->set_flashdata('message_success', $mess);
		redirect(current_url());
	}

	public function call_back(){
		$this->load->model('contact_model');
		$phone = $this->input->post('phone');
		$idpro = $this->input->post('idpro');
		$content = 'Yêu cầu gọi lại';

		$alias = $this->input->post('alias');

		$arr = array(
				"idpro" =>$idpro,
				"phone" =>$phone,
				"note"=> $content,
				"date"	=>time(),
			);
			$this->contact_model->add($arr);

		$mess = "Gửi thông tin liên hệ thành công. Chúng tôi sẽ sớm liên hệ với bạn !";
		$this->session->set_flashdata('message_success', $mess);
		//redirect(current_url());
		redirect(base_url($alias.'.html'));
	}

	public function email(){
		$email = $this->input->post('email');
		$phone = $this->input->post('email');
		$note = $this->input->post('note');

		$this->load->model('contact_model');
			$arr = array(
				"email" =>$email,
				"note" =>$note,
				'date'=>time(),
				'ticlock' =>0
			);
			$this->contact_model->add($arr);
			die(json_encode(array('mess'=>"Đăng ký email thành công")));
			$mess = "Đăng ký email thành công.";

		$this->session->set_flashdata('regemail_success', $mess);
		redirect(current_url());
	}

	public function notfound(){
		$temp['data'] = NULL;
		$temp['template']='default/home/notfound'; 
		$this->load->view("default/layout",$temp); 
	}
	public function message($id,$deal){
		
		$this->load->model('product_model');
		$this->load->model('deal_model');
		if($deal==1):
			$temp['info'] = $this->deal_model->get_Id($id);
		else:
			$temp['info'] = $this->product_model->get_Id($id);
		endif;
		$temp["deal"] = $deal;
		$this->load->view("default/home/message",$temp); 
	}
	public function feedback($id){
		$this->load->model('payment_model');
		$iduser = $this->session->userdata('login_user_id');
		$temp['cus']= $this->payment_model->get_list(array('code'=>$id,"iduser"=>$iduser));

		if(empty($temp['cus'])) die;

		if($this->input->post('save')){
			$error =false;
			$reasoncancel= $this->input->post('reasoncancel');
			$reason= $this->input->post('reason');
			if($reasoncancel<=0){
				$error =true;
				$message = "<div class=\"alert alert-danger\">Chọn lý do hủy đơn hàng</div>";
			}elseif($reasoncancel==5){
				if(strlen($reason)<=5){
					$error =true;
					$message = "<div class=\"alert alert-danger\">Nhập lý do hủy</div>";
				}
			}
			if($error==false){ 
				$error =false;
				$message = "<div class=\"alert alert-success\">Hủy đơn hàng thành công</div>";
				
				$this->payment_model->update($temp['cus'][0]["Id"],array("status"=>6));
				$this->payment_model->addreasoncancel(array("idcustomer"=>$temp['cus'][0]["Id"],"idreasoncancel"=>$reasoncancel,"content"=>$reason,"date"=>time())); 
			}
			die(json_encode(array("error"=>$error,"message"=>$message)));
		}
		$this->load->view("default/home/feedback",$temp); 
	}
	public function  sentmessage(){
		$this->load->model('contact_model');
		$fullname = $this->input->post('fullname');
		$phone = $this->input->post('phone');
		$idpro = $this->input->post('idpro');
		$deal = $this->input->post('deal');
		//--------check form----------------
		$error  = false;
		$mess=  NULL;
		if(empty($fullname)){
			$error = true;
			$mess['fullname-message'] = "Nhập tên họ tên của bạn";
		}
		if(empty($phone) ){
			$error = true;
			$mess['phone-message'] = "Nhập số điện thoại của bạn";
		}else if(strlen($phone)<9 || strlen($phone)>12 || !is_numeric($phone) ){
			$error = true;
			$mess['phone-message'] = "Số điện thoại không đúng";
		}
		
		if($error==false){
			
			$arr= array(
				"fullname" =>$fullname,
				"email" => "",
				"date" => time(),
				"phone" => $phone,
				"note" => "",
				"deal" => $deal,
				"idpro" => $idpro,
				"ticlock" => 0,
				"view" => 0,
				"iduser" => $this->session->userdata('login_user_id'),
			);
			$this->contact_model->add($arr);
			$mess = '<div class="alert alert-success">Gửi yêu cầu thành công. Mada sẽ gọi lại cho bạn trong thời gian sớm nhất. xin cảm ơn !</div><div class="form-group center " style="margin-top:15px">
	<button type="button" class="btn" onClick="close_box_popup()">Đóng</button></div>';
			die(json_encode(array("err"=>$error,"mess"=>$mess)));
		}
		die(json_encode(array("err"=>$error,"mess"=>$mess)));
	}
	public function landing(){
		$this->load->view("default/home/landing"); 
	}
	public function vquyen($id=0){
		$arr = "";
		$info  = $this->pagehtml_model->get_catelog($id);
		if(!empty($info)){
			foreach($info as $item){
				$subid =$this->page->getSubCatlogId($item['Id']);	
				if($subid !="")
					$arr .=$item["Id"].",".$subid;
				else
				$arr .=$item["Id"].",";
			}
		}
		echo $arr.$id;
	}
	public function excel()
	{
		$sql = "SELECT *,(SELECT title_vn FROM mn_catelog WHERE mn_catelog.Id= mn_product.idcat ) AS danhmuc,(SELECT title_vn FROM mn_manufacturer WHERE mn_manufacturer.Id= mn_product.idmanufacturer) AS manu FROM mn_product WHERE ticlock=0 AND trash=0";
		$data['info'] =  $this->product_model->get_query($sql,9999,0);
		$this->load->view("default/home/excel",$data); 
	}
	
}
