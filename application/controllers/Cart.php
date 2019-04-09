<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
	protected $arrowmap = '  >  ';
	protected $map_title = '<a href="/">Trang chủ</a>';
	
	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('payment_model');
		 $this->load->model('deal_model');
		 $this->load->model('provinces_model');
		 $this->load->model('district_model');
		 $this->load->model('discount_model');
		 $this->load->model('discount_code_model');
		 $this->load->model('color_model');
		 $this->load->model('size_model');
		 $this->load->model('flash_model');
		 $this->load->model('user_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
	public function cart($idpro)
	{
		$cart = $this->session->userdata('cart');
		$k=0;
		$c= 0;
		if($idpro>0){
			if(!empty($cart)){
				foreach($cart as $k=>$v){
					if($v['idpro']== $idpro){
						$arr[$k] = 	array("idpro"=>$idpro,"qty"=>($v['qty']+1),"color"=>$v['color'],"size"=>$v['size'],"deal"=>0);
						$c = 1;
					}else{
						$arr[$k] = $v; 
					}
					$k=$k;
				}
			}
			$k= $k+1;
			if($c== 0)
				$arr[$k]= array('idpro'=>$idpro,'qty'=>1,'color'=>0,'size'=>0,'deal'=>0);
			$this->session->set_userdata('cart',$arr);
		}
		redirect(base_url('gio-hang'));
	}
	public function addcart()
	{
		$size = (int)$this->input->post('size');
		$color = (int)$this->input->post('color');
		$idpro = (int)$this->input->post('idpro');
		$quanty = (int)$this->input->post('quanty');
		$deal = (int)$this->input->post('deal');
		$cart = $this->session->userdata('cart');
		if(empty($cart)){
			$arr[]= array('idpro'=>$idpro,'qty'=>$quanty,'color'=>$color,'size'=>$size,'deal'=>$deal);
			$this->session->set_userdata('cart',$arr);
		}else{
			$c= 0;
			$j=0;
			foreach($cart as $k=>$v){
				if($v['idpro']==$idpro){
					$arr[$k] = 	array("idpro"=>$idpro,"qty"=>$quanty,"color"=>$color,'size'=>$size,'deal'=>$deal);
					$c = 1;
				}else{
					$arr[$k] = $v;
				}
				$j=$k;
			}
			if($c==0){
				$arr[$j+1] = 	array("idpro"=>$idpro,"qty"=>$quanty,"color"=>$color,"size"=>$size,'deal'=>$deal);
			}
			$this->session->set_userdata('cart',$arr);
		}
		$temp['template']='default/payment/shortcart';
		$this->load->view("default/payment/shortcart",$temp); 
		//redirect(base_url('addcart'));

	}

	public function order()
	{
		$this->load->model('payment_model');
		
		$temp['data']['info_payment']= json_decode(get_cookie("info_payment"));
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('fullname','Họ và tên','required');
		$this->form_validation->set_rules('email','Email','required|valid_email',array('valid_email'=>"Email không đúng định dạng"));
		$this->form_validation->set_rules('idprovinces','Tỉnh/ Thành phố','required|is_natural_no_zero');
		$this->form_validation->set_rules('iddistrict','Quận/ Huyện','required|is_natural_no_zero');
		$this->form_validation->set_rules('address','Địa chỉ','required');
		$this->form_validation->set_rules('phone','số điện thoại','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		$cart = $this->session->userdata('cart');
		$temp['data']['info']['login_id'] = $this->session->userdata('login_id');
		$temp['data']['info']['fullname'] = $this->session->userdata('login_user_fullname');
		$temp['data']['info']['email'] = $this->session->userdata('login_email');
		$uid =  $this->session->userdata('login_user_id');
		if($uid>0){
			$user = $this->user_model->get_one_user($uid);
			$temp['data']['info']['address'] = $user[0]['address'];
			$temp['data']['info']['phone'] = $user[0]['phone'];
		}
		
		$count = count($cart);
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE && $count >0 )
			{
				$iduser = $this->session->userdata('login_user_id');
				$data['fullname'] = $this->input->post('fullname');
				$data['email'] = $this->input->post('email');
				$data['address'] = $this->input->post('address');
				$data['phone'] = $this->input->post('phone');
				$data['note'] = $this->input->post('note');
				$data['idprovinces'] = $this->input->post('idprovinces');
				$data['iddistrict'] = $this->input->post('iddistrict');
				$data['iduser'] = $iduser;
				$data['date'] = time();
				$data['methodpay'] = $this->input->post('fpaymentmethod');
				$id = $this->payment_model->add($data);
				foreach($cart as $k => $v){
					$arr['idpro'] = $idpro=  (int)$v['idpro'];
					if($idpro>0){
						if($v['deal']==1){
							$this->deal_model->countorder($idpro);
							$pro = $this->deal_model->get_Id($idpro);
						}else{
							$pro = $this->product_model->get_Id($idpro);
							$this->product_model->countorder($idpro);
						}
						$arr['amount']=  (int)$v['qty'];
						$arr['idmanu']=  (int)$pro[0]['iduser'];
						$arr['idcustomer']=  $id;
						$arr['price']=  $pro[0]['sale_price'];
						$arr['size'] = $v['size'];
						$arr['color'] = $v['color'];
						$arr['deal'] = (int)$v['deal'];
						$this->payment_model->addcart($arr);
					}
				}
				$this->session->unset_userdata('cart'); 
				redirect(base_url('payment/success'));
			}
		}
		$temp['data']['breadcrumb'] =  $this->map_title . $this->arrowmap . '<a href = "/gio-hang.html" >Giỏ hàng</a>';
		$temp['data']['provinces'] = $this->provinces_model->getdata(array('ticlock'=>0));
		$temp['scripttag'] = array(USER_PATH_JS.'chosen.jquery.js');
			$temp['linktag'] = array(array("href" => USER_PATH_CSS."chosen.css","type" => "text/css","rel"=>"stylesheet"));
			$temp['template']='default/payment/order'; 
			$this->load->view("default/layout",$temp); 
	}
	function order_b1(){
		$iduser = $this->session->userdata('login_user_id');
		if($iduser>0) redirect(base_url('thanh-toan.html/buoc-2'));
		$data['cart'] = $this->session->userdata('cart');
		if(USERTYPE=='Mobile'){
			$temp['data'] = $data;
			$temp['template']='default/payment/m_order_b1';
			$this->load->view("default/layoutMobile",$temp); 
		}else{
			$this->load->view("default/payment/order_b1",$data); 
		}
	}
	function order_b2(){
		
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('fullname','Họ và tên','required');
		$this->form_validation->set_rules('email','Email','required|valid_email',array('valid_email'=>'Email không đúng định dạng'));
		$this->form_validation->set_rules('provinces','Tỉnh/ Thành phố','required|is_natural_no_zero');
		$this->form_validation->set_rules('district','Quận/ Huyện','required|is_natural_no_zero');
		$this->form_validation->set_rules('address','Địa chỉ','required');
		$this->form_validation->set_rules('phone','Số điện thoại','required|numeric|min_length[8]|max_length[13]',array('numeric'=>'Số điện thoại không chính xác','min_length'=>'Số điện thoại không chính xác','max_length'=>'Số điện thoại không chính xác'));
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		$iduser = $this->session->userdata('login_user_id');
		if($iduser >0) {
			$data['user'] = $this->user_model->get_one_user($iduser);
		}
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE )
			{
				$arr['fullname'] = $this->input->post('fullname');
				$arr['email'] = $this->input->post('email');
				$arr['phone'] = $this->input->post('phone');
				$arr['address'] = $this->input->post('address');
				$arr['provinces'] = $this->input->post('provinces');
				$arr['district'] = $this->input->post('district');
				$arr['note'] = $this->input->post('note');
				$this->session->set_userdata('address_payment',$arr);
				if(empty($data['user'][0]['address']) && !empty($data['user'])){
					$brr['address'] = $arr['address'];
					$brr['idtinh'] = $arr['provinces'];
					$brr['iddistrict'] = $arr['district'];
					$brr['phone'] = $arr['phone'];
					$this->user_model->update($iduser,$brr);
				}
				redirect(base_url('thanh-toan.html/buoc-3'));
			}
		}
		
		$data['cart'] = $this->session->userdata('cart');
		$data['provinces'] = $this->provinces_model->getdata(array('ticlock'=>0));
		if(USERTYPE=='Mobile'){
			$temp['data'] = $data;
			$temp['template']='default/payment/m_order_b2';
			$this->load->view("default/layoutMobile",$temp); 
		}else{
			$this->load->view("default/payment/order_b2",$data); 
		}
	}
	function order_b3(){
		$code_voucher = $this->session->userdata('code');
		$total_price_sale = $this->session->userdata('toltal_sale');
		$discount_code = $this->session->userdata('code_type');
		
		$iduser = $this->session->userdata('login_user_id');
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);

		$this->load->model('provinces_model');
		$this->load->model('district_model');
		
		$fullname  = $this->input->post('fullname');
		$phone  = $this->input->post('phone');
		$note  = $this->input->post('note');
		$idprovinces  = $this->input->post('ProvinceId');
		$iddistrict  = $this->input->post('DistrictId');
		$address  = $this->input->post('address');
		
		$data['cart'] = $this->session->userdata('cart');
		if(empty($data['cart'])) redirect(base_url());
	
		if($iddistrict>0) $data['district']= $this->district_model->get_where($iddistrict);
		if($idprovinces>0) $data['provinces']= $this->provinces_model->get_where($idprovinces);
		$error = false;
		if(empty($phone)){
			$error = true;
			$message["phone-error"] = "Vui lòng nhập số điện thoại";
		} else if(!is_numeric($phone) || strlen($phone)>11 || strlen($phone)<9){
			$error = true;
			$message["phone-error"] = "Số điện thoại không đúng";
		}
		if(empty($fullname)){
			$error = true;
			$message["name-error"] = "Vui lòng nhập họ tên";
		}
		if($error == false){
			
			$arr['code']  = $this->page->getCode($this->page->rand_number());
			$arr['fullname']  = $fullname;
			$arr['idprovinces']  = $idprovinces;
			$arr['iddistrict']  = $iddistrict;
			$arr['phone']  = $phone;
			$arr['address']  = $address;
			$arr['note']  = $note;
			$arr['iduser']  = $iduser;
			$arr['idgioithieu'] = (int)get_cookie('idgioithieu');
			$arr['date']  = time();
			$arr['view']  = 0;
			$arr['status']  = 0;
			$arr['agree']  = '';
			$arr['methodpay']  = 'Thanh toán khi nhận hàng';
			$arr['email']  =  "";
			$arrcode = array(
				'status' => 1,
				'order_id' => $arr['code'],
			);
			$this->discount_model->update_status_voucher($code_voucher, $arrcode);
			
			$id = $this->payment_model->add($arr);
			
			if(!empty($data['cart'])){
				$tongdonhang = 0;
				foreach($data['cart'] as $k=>$v){
					$idpro = (int)$v['idpro'];
					if($v['deal']==1){
						 $brr['deal']= 1; 
						 $pro = $this->deal_model->get_Id($idpro);
						 $this->deal_model->countorder($idpro);
						 $brr['idpercent']  = 0;
						 if($discount_code!=''){
							$this->discount_code_model->update_code_type($idpro, array('code_type' => '1'));
						}
					}
					else {
						$brr['deal']= 0;
						$pro = $this->product_model->get_Id($idpro);
						$this->product_model->countorder($idpro);
						$brr['idpercent']  = $pro[0]['idpercent'];
						 if($discount_code!=''){
							$this->discount_code_model->update_code_type_product($idpro, array('code_type' => '1'));
						}
					}
					/*$sanpham .= ' <tr><td align="left" valign="top" style="padding:3px 9px">
                 <span>'.$pro[0]['title_vn'].'</span><br></td>
                 <td align="left" valign="top" style="padding:3px 9px"><span>'.bsVndDot($pro[0]['sale_price']).'&nbsp;₫</span></td>
                 <td align="left" valign="top" style="padding:3px 9px">'.$v['qty'].'</td>
                 <td align="right" valign="top" style="padding:3px 9px"><span>'.bsVndDot($pro[0]['sale_price']*$v['qty']).'&nbsp;₫</span></td>
                 </tr>'; */
				 	
					$brr['idcustomer'] = $id;
					$brr['idpro'] = $v['idpro'];
					$brr['amount'] = $v['qty'];
					$brr['size'] = $v['size'];
					$brr['color'] = $v['color'];
					$brr['idgioithieu'] = (int)get_cookie('idgioithieu');
					$brr['price'] = $pro[0]['sale_price'];
					$this->payment_model->addcart($brr);
					
					$tongdonhang = $tongdonhang+ $pro[0]['sale_price']*$v['qty'];
			}
			
			$this->session->unset_userdata('code_type'); 
			$arr_ck = array("fullname"=>$fullname,"phone"=>$phone,"address"=>$address,"idprovinces"=>$idprovinces,"iddistrict"=>$iddistrict); 
			set_cookie('info_payment',json_encode($arr_ck),60*60*24*2);
			$this->session->set_userdata('idorder_payment',array('iduser'=>$iduser,'idorder'=>$arr['code'],'email'=>$arr['email'] ));
			die(json_encode(array("error"=>false,"message"=>"Successfull")));
			//email---------------
			//$address = $arr['address'].",".$data['district'][0]['title_vn'].",".$data['provinces'][0]['title_vn'];
			
			/*if(isset($total_price_sale) && $total_price_sale!=''){
		
				if($total_price_sale>300000){
					 $ship="Miễn phí";
					 $tongthanhtoan = $total_price_sale;
				}else if($data['district'][0]['free']==1 && $total_price_sale>=150000) {
					$ship="Miễn phí";
					$tongthanhtoan = $total_price_sale;
				}
					else {
					 $ship= bsVndDot($data['district'][0]['ship'])."đ";
					 $tongthanhtoan = $total_price_sale+$data['district'][0]['ship'];
				}
				//$noidung =  file_get_contents(BASE_URL."/public/email/donhanggiamgia.html");
			}else{
				if($tongdonhang>300000){
					 $ship="Miễn phí";
					 $tongthanhtoan = $tongdonhang;
				}else if($data['district'][0]['free']==1 && $tongdonhang>=150000) {
					$ship="Miễn phí";
					$tongthanhtoan = $tongdonhang;
				}else {
					 $ship= bsVndDot($data['district'][0]['ship'])."đ";
					 $tongthanhtoan = $tongdonhang+$data['district'][0]['ship'];
				}
				//$noidung =  file_get_contents(BASE_URL."/public/email/xacnhandonhang.html");
			}*/
			
			/*$noidung =str_replace("{SANPHAM}", $sanpham ,$noidung);
			$noidung =str_replace("{FULLNAME}", $arr['fullname'] ,$noidung);
			$noidung =str_replace("{CODE}", "#".$arr['code'] ,$noidung);
			$noidung =str_replace("{DATE}", date('d-m-y H:i:s') ,$noidung);
			$noidung =str_replace("{EMAIL}", $user[0]['email'] ,$noidung);
			$noidung =str_replace("{PHONE}", $arr['phone'] ,$noidung);
			$noidung =str_replace("{DIACHI}", $address ,$noidung);
			$noidung =str_replace("{SHIP}", $ship ,$noidung);
			$noidung =str_replace("{PTTHANHTOAN}", $arr['methodpay'],$noidung);
			$noidung =str_replace("{TONGTIEN}", bsVndDot($tongdonhang) ,$noidung);
			$noidung =str_replace("{TONGTHANHTOAN}", bsVndDot($tongthanhtoan) ,$noidung);
			$noidung =str_replace("{PRICESALE}", bsVndDot($total_price_sale) ,$noidung);
			$noidung =str_replace("{HOTLINE}", $web['hotline'] ,$noidung);
					
			$this->email->from('cskh@mada.vn', 'Mada.vn');
			$this->email->to($arr['email']);
			$this->email->subject('Xác nhận đơn hàng #'.$arr['code']);
			$this->email->message($noidung);
			$this->email->send();
			$this->session->unset_userdata('code');
			$this->session->unset_userdata('toltal_sale'); 
			//redirect(base_url('dat-hang-thanh-cong.html'));	*/	
	
			}
 			
		}else{
			die(json_encode(array("error"=>true,"message"=>$message)));
		}
		/*if(USERTYPE=='Mobile'){
			$temp['data'] = $data;
			$temp['template']='default/payment/m_order_b3';
			$this->load->view("default/layoutMobile",$temp); 
		}else{
			$this->load->view("default/payment/order_b3",$data); 
		}*/
	}


}
?>