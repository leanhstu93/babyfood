<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {
	protected $arrowmap = " > ";
	protected $map_title = '<a href="/">Trang chủ</a>';
	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('catelog_model');
		 $this->load->model('flash_model');
		 $this->load->model('user_model');
		 $this->load->model('tags_model');
		 $this->load->model('size_model');
		 $this->load->model('color_model');
		 $this->load->model('comment_model');
		 $this->load->model('provinces_model');
		 $this->load->model('manufacturer_model');
		 $this->load->model('district_model');
		 $this->load->model('provinces_model');
		 $this->load->model('gifts_model');
		 $this->load->model('voucher_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}

	public function cart()
	{
		$temp['template']='default/payment/gio-hang'; 
		$this->load->view("default/layout",$temp); 	
	}

	public function addcart_fromdetail()
	{
		$size = (int)$this->input->post('size');
		$color = (int)$this->input->post('color');
		$idpro = (int)$this->input->post('idpro');
		$quanty = (int)$this->input->post('quanty');
		$deal = (int)$this->input->post('deal');

		$alias = $this->input->post('alias');
		$name_pro = $this->input->post('name_pro');
		
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
				$arr[$j+1] = array("idpro"=>$idpro,"qty"=>$quanty,"color"=>$color,"size"=>$size,'deal'=>$deal);
			}
			$this->session->set_userdata('cart',$arr);
		}
		$this->session->set_flashdata('message_addcart_fromdetail_success', '"'.$name_pro.'" đã được thêm vào giỏ hàng.');
		if($this->input->post('buynow') == 1) {
			redirect('thanh-toan');	
		} else {
			redirect(base_url($alias.'.html'));
		}
		
	}

	public function addcart_fromcat()
	{
		$size = (int)$this->input->post('size');
		$color = (int)$this->input->post('color');
		$idpro = (int)$this->input->post('idpro');
		$quanty = (int)$this->input->post('quanty');
		$deal = (int)$this->input->post('deal');

		$link = $this->input->post('link');
		$name_pro = $this->input->post('name_pro');
		
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
				$arr[$j+1] = array("idpro"=>$idpro,"qty"=>$quanty,"color"=>$color,"size"=>$size,'deal'=>$deal);
			}
			$this->session->set_userdata('cart',$arr);
		}
		$this->session->set_flashdata('message_addcart_fromcat_success', '"'.$name_pro.'" đã được thêm vào giỏ hàng.');
		redirect(site_url('thanh-toan'));	
	}

	public function delcart($id)
	{
		$cart = $this->session->userdata('cart');
		unset($cart[$id]);
		$this->session->set_userdata('cart', $cart);
		redirect(base_url('gio-hang'));
	}

	public function editcart()
	{
		$cart = $this->session->userdata('cart');
		$fillter  = $this->input->post('quanty');
	
		if(!empty($fillter)){
			foreach($fillter as $k=>$v){
				if($v<=0) unset($cart[$k]);
				else
					$cart[$k]['qty'] = $v;
			}
		}
		$this->session->set_userdata('cart',$cart);
		redirect(base_url('gio-hang'));
	}

	public function order()
	{
		$this->load->model('payment_model');
		
		$temp['data']['info_payment']= json_decode(get_cookie("info_payment"));
		//$this->form_validation->set_message('required','Vui lòng nhập %s');
		//$this->form_validation->set_rules('fullname','Họ và tên','required');
		// $this->form_validation->set_rules('email','Email','required|valid_email',array('valid_email'=>"Email không đúng định dạng"));
		// $this->form_validation->set_rules('idprovinces','Tỉnh/ Thành phố','required|is_natural_no_zero');
		// $this->form_validation->set_rules('iddistrict','Quận/ Huyện','required|is_natural_no_zero');
		// $this->form_validation->set_rules('address','Địa chỉ','required');
		// $this->form_validation->set_rules('phone','số điện thoại','required');
		// $this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		$cart = $this->session->userdata('cart');
		//$temp['data']['info']['login_id'] = $this->session->userdata('login_id');
		// $temp['data']['info']['fullname'] = $this->session->userdata('login_user_fullname');
		// $temp['data']['info']['email'] = $this->session->userdata('login_email');
		// $uid =  $this->session->userdata('login_user_id');
		// if($uid>0){
		// 	$user = $this->user_model->get_one_user($uid);
		// 	$temp['data']['info']['address'] = $user[0]['address'];
		// 	$temp['data']['info']['phone'] = $user[0]['phone'];
		// }
		$this->load->library('form_validation');
		$count = count($cart);
		//if($this->input->post('save'))
		$valid = true;
        $has_voucher_code = false;
		
		if($this->input->post('update-cart')) {
			$fillter  = $this->input->post('quanty');
		
			if(!empty($fillter)){
				foreach($fillter as $k=>$v){
					if($v<=0) unset($cart[$k]);
					else
						$cart[$k]['qty'] = $v;
				}
			}
			$this->session->set_userdata('cart',$cart);
		}
		
        if($this->input->post('woocommerce_checkout_place_order'))
		{
			if($this->input->post('province_id')) $temp['data']['districts'] = $this->district_model->list_district('idcat='.$this->input->post('province_id'));
			$this->form_validation->set_rules('ReCaptcha', lang('reset_password_lbl_captcha'), 'callback_validateReCaptcha');
			
			if($this->form_validation->run()) {
				if($this->input->post('rdcode')) {
                $voucher_code = $this->input->post('rdcode');
                $check_code = $this->voucher_model->get_where(array('code' => $voucher_code));
                if(!empty($check_code)) {
                    if($check_code[0]['status'] == 1 || $check_code[0]['start_day'] > time() || $check_code[0]['end_day']< time()) {
                        $valid = false;
                        $temp['data']['error_code'] = 'Mã giãm giá không hợp lệ.';  
                    } else {
                        $valid = true;
                        $has_voucher_code = $check_code[0]['id'];
                        $discount_price = $check_code[0]['price'];
                    }
                } else {
                    $valid = false;
                    $temp['data']['error_code'] = 'Mã giãm giá không hợp lệ.';  
                }
                
            }
            
            if($count >0 && $valid == true)
			{
				$data['code'] = $code = $this->page->getCode($this->page->rand_number());
				$data['fullname'] = $fullname = $this->input->post('fullname');
				$data['email'] = $email = $this->input->post('email');
				$data['address'] = $address = $this->input->post('address');
				$data['phone'] = $phone = $this->input->post('phone');
				$data['note'] = $note = $this->input->post('note');
				$data['date'] = $date = time();
				$data['methodpay'] = $methodpay = $this->input->post('fpaymentmethod') ? $this->input->post('fpaymentmethod') : 'Thanh toán khi nhận hàng';
				$data['transfee'] = $transfee = $this->input->post('transfee');
				$data['idprovinces'] = 1;
				$data['iddistrict'] = $this->input->post('district_id');
                
                $id = $this->payment_model->add($data);
				
                if($this->session->userdata('voucher_code') && $this->session->userdata('voucher_price')) {
                    $this->db->where('code', $this->session->userdata('voucher_code'))->update('mn_voucher', array(
                       'status' => 1,
                       'order_id' => $id 
                    ));
                }
                
				$tongthanhtoan = 0;
				$tong = 0;
				foreach($cart as $k => $v){
					$arr['idpro'] = $idpro=  (int)$v['idpro'];
					if($idpro>0){

						$pro = $this->product_model->get_Id($idpro);
						$this->product_model->countorder($idpro);
						$arr['amount']=  (int)$v['qty'];
						$arr['idmanu']=  (int)$pro[0]['iduser'];
						$arr['idcustomer']=  $id;
						$arr['price']=  $pro[0]['sale_price'];
						$arr['size'] = $v['size'];
						$arr['color'] = $v['color'];
						//$arr['deal'] = (int)$v['deal'];
						$tong = $pro[0]['sale_price']*$v['qty'];
						$tongthanhtoan += $tong; 
						$this->payment_model->addcart($arr);

						$sanpham .= ' <tr><td align="left" valign="top" style="padding:3px 9px">
						                 <span>'.$pro[0]['title_vn'].'</span><br></td>
						                 <td align="left" valign="top" style="padding:3px 9px"><span>'.bsVndDot($pro[0]['sale_price']).'&nbsp;₫</span></td>
						                 <td align="left" valign="top" style="padding:3px 9px">'.$v['qty'].'</td>
						                 <td align="right" valign="top" style="padding:3px 9px"><span>'.bsVndDot($pro[0]['sale_price']*$v['qty']).'&nbsp;₫</span></td>
						               </tr>'; 
					}
				}
				$tongthanhtoan = $tongthanhtoan - $this->session->userdata('voucher_price') + $transfee;

				//sent email
				$noidung =  file_get_contents(BASE_URL."/public/email/xacnhandonhang.html");
				$noidung =str_replace("{SANPHAM}", $sanpham ,$noidung);
				$noidung =str_replace("{FULLNAME}", $data['fullname'] ,$noidung);
				$noidung =str_replace("{CODE}", "#".$code ,$noidung);
				$noidung =str_replace("{DATE}", date('d-m-y H:i:s') ,$noidung);
				$noidung =str_replace("{EMAIL}", $email ,$noidung);
				$noidung =str_replace("{PHONE}", $phone ,$noidung);
				$noidung =str_replace("{DIACHI}", $address ,$noidung);
				$noidung =str_replace("{SHIP}", bsVndDot($transfee) ,$noidung);
				$noidung =str_replace("{PTTHANHTOAN}", $methodpay,$noidung);
				if($this->session->userdata('voucher_code'))
					$noidung =str_replace("{VOUCHERCODE}", '<tr>
                    <td colspan="3" align="right" style="padding:5px 9px">Voucher code</td>
                    <td align="right" style="padding:5px 9px"><span>'.$this->session->userdata('voucher_code').' giảm ' . bsVndDot($this->session->userdata('voucher_price')) .'đ</span></td>
                  </tr>',$noidung);
				//$noidung =str_replace("{TONGTIEN}", bsVndDot($tongdonhang) ,$noidung);
				$noidung =str_replace("{TONGTHANHTOAN}", bsVndDot($tongthanhtoan) ,$noidung);
				//$noidung =str_replace("{PRICESALE}", bsVndDot($total_price_sale) ,$noidung);
				//$noidung =str_replace("{HOTLINE}", $web['hotline'] ,$noidung);
						
				$this->sendmail($noidung, $data['email']);

				$this->session->unset_userdata('code');
				$this->session->unset_userdata('voucher_code');
				$this->session->unset_userdata('voucher_price');
				//$this->session->unset_userdata('toltal_sale'); 


				$this->session->unset_userdata('cart');
				redirect(base_url('dat-hang-thanh-cong/'.$code));
			}
			}
			
            
		}
		$temp['data']['breadcrumb'] =  $this->map_title . $this->arrowmap . '<a href = "/gio-hang" >Giỏ hàng</a>';
		$temp['data']['provinces'] = $this->provinces_model->getdata(array('ticlock'=>0));
		$temp['scripttag'] = array(USER_PATH_JS.'chosen.jquery.js');
		$temp['linktag'] = array(array("href" => USER_PATH_CSS."chosen.css","type" => "text/css","rel"=>"stylesheet"));
		$this->session->set_flashdata('payment_success', 'Bạn đã đặt hàng thành công');
		$temp['template']='default/payment/order'; 
		$this->load->view("default/layout",$temp);
	}

	/*public function testmail(){
		$this->sendmail('test', 'nvtuan.it007@gmail.com');
	}*/
	
	public function validateReCaptcha() {
        # Verify captcha
        $post_data = http_build_query(
            array(
                'secret' => '6LffpH8UAAAAAKzC5ciwlGxIatgkgW_NkgEOWKhU',
                'response' => $_POST['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        $context  = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $result = json_decode($response);
        if (!$result->success) {
            $this->form_validation->set_message('validateReCaptcha', 'Gah! CAPTCHA verification failed. Please email me directly at: jstark at jonathanstark dot com');
            return false;
        } else {
            return true;
        }
    }

	public function sendmail($body, $email_nguoinhan){
		$this->load->library('send_email');

		$this->send_email->_Send('Xác nhận đơn hàng Babyshop', $body, '', $email_nguoinhan);
        $this->session->set_flashdata('message_success', 'Đặt hàng thành công, thông tin đơn hàng được gửi về email của bạn!');
        $response = array('result' => 'success');
        header('Content-Type: application/json');
        echo json_encode( $response );
        
	}

	public function success($id)
	{
		$this->load->model('payment_model');
		$this->load->model('district_model');
		$this->load->model('provinces_model');
		$this->load->model('color_model');
		$this->load->model('size_model');
		$temp['data']['cus']= $this->payment_model->get_list(array('code'=>$id));
		if(empty($temp['data']['cus'])) redirect(base_url("404.html"));
		$voucher = $this->db->where('order_id', $temp['data']['cus'][0]["Id"])->get('mn_voucher')->row_array();
		if($voucher) {
			$temp['data']['voucher_price'] = $voucher['price'];
			$temp['data']['voucher_code'] = $voucher['code'];
		}
		else $temp['data']['voucher_price'] = 0;
		$temp['data']['cart']= $this->payment_model->get_list_cart(array('idcustomer'=>$temp['data']['cus'][0]["Id"]));
		
		$temp['template']='default/payment/over-view';
		$this->load->view("default/layout",$temp); 
		
	}
	
	public function codeVoucher(){
		$code = trim($this->input->post('voucherCode'));
		$total_order = $this->input->post('totalOrder');
		$now = time();
		$check_voucher = $this->db->where('code', $code)->where('order_id', 0)->where('status', 0)->get('mn_voucher')->row_array();
		
		if(empty($check_voucher)) {
			$res['success'] = false;
			$res['msg'] = 'Mã voucher không hợp lệ 1';
		} else if($check_voucher['start_day'] > $now || $check_voucher['end_day'] < $now) {
			$res['success'] = false;
			$res['msg'] = 'Mã voucher không hợp lệ 2';
		} else {
			if($check_voucher['price'] > 0) {
				$this->session->set_userdata('voucher_price', $check_voucher['price']);
				$this->session->set_userdata('voucher_code', $code);
				$res['success'] = true;
				$res['msg'] = 'Mã voucher được giãm ' . bsVndDot($check_voucher['price']);
				$res['html'] = '<td colspan="3">Mã voucher</td>
									<td colspan="2"><strong>'.$code.' - giãm ' . bsVndDot($check_voucher['price']) . '</strong></td>';
				$res['voucher_discount'] = $check_voucher['price'];
				$res['total_order'] = bsVndDot($total_order - $check_voucher['price']);
			} else {
				$res['success'] = true;
				$res['msg'] = 'Mã voucher được giãm 0đ';
				$res['html'] = '';
				$res['voucher_discount'] = 0;
				$res['total_order'] = bsVndDot($total_order - $check_voucher['price']);
			}
		}
		header('Content-Type: application/json');
		echo json_encode($res);
	}

	public function code_voucher(){
		
		$err = FALSE;
		$this->load->model('discount_model');
		$cart = $this->session->userdata('cart');
		$userid = $this->session->userdata('login_user_id');
		$code = trim($this->input->post('rdcode'));
		$voucher = $this->discount_model->check_code($userid, $code);
		$end_day = $voucher['end_day'];
		
		if($code==''){
			$flag = array('type' => 'error','message' => 'Bạn vui lòng nhập code voucher!');
			$this->session->set_flashdata('message_flashdata', $flag);
		}
		if(time() > $end_day && $voucher!=''){
			$flag = array('type' => 'error','message' => 'Code voucher "'.$code.'" đã hết giá trị sử dụng!');
			$this->session->set_flashdata('message_flashdata', $flag);
		}
		if($voucher['status']==1){
			$flag = array('type' => 'error','message' => 'Code voucher "'.$code.'" đã được sử dụng!');
			$this->session->set_flashdata('message_flashdata', $flag);	
		}
		if($voucher['code']!=$code){
			$flag = array('type' => 'error','message' => 'Code voucher "'.$code.'" không hợp lệ!');
			$this->session->set_flashdata('message_flashdata', $flag);		
		}
		
		if($voucher['voucher']==1 && $voucher['status']==0 && $voucher['code']==$code && $code!='' && time() <= $end_day){
				if(!empty($cart)){
					$total_price = 0; $total_price_voucher =0;
					
					foreach($cart as $k=>$v){
						$idpro = (int)$v['idpro'];
						 if($v['deal']==1){
               			 		$pro = $this->deal_model->get_Id($idpro);
						 }else{
								$pro = $this->product_model->get_Id($idpro); 
						 	}
							 $total_price = $total_price+ $pro[0]['sale_price']*$v['qty'];	
						}
					
					if($total_price>=2000000){
						
						if($voucher['value']==1){
							$total_price_voucher = $total_price - 2000000;	
						} 
						if($voucher['value']==2){
							$total_price_voucher = $total_price - 1000000;	
						} 
						if($voucher['value']==3){
							$total_price_voucher = $total_price - 500000;	
						} 
						if($voucher['value']==4){
							$total_price_voucher = $total_price - 200000;	
						} 
						if($voucher['value']==5){
							$total_price_voucher = $total_price - 100000;
						}
						$arr_price_sale = array('toltal_sale' => $total_price_voucher);
						$this->session->set_userdata($arr_price_sale); 
						$get_code = $this->discount_model->get_code($code);
						if($get_code!=''){
							$arr_code = array('code' => $get_code['code']); $this->session->set_userdata($arr_code);
						}
						if($total_price_voucher!=''){
							$flag = array('type' => 'successful','message' => 'Đơn hàng của quý khách đã được giảm!');
							$this->session->set_flashdata('message_flashdata', $flag);
						}
						
					}else{
						$flag = array('type' => 'error','message' => 'Chỉ áp dụng cho đơn hàng 2 triệu!');
						$this->session->set_flashdata('message_flashdata', $flag);	
					}
				}
			}
			if($voucher['voucher']==0 && $voucher['status']==0 && $voucher['code']==$code &&  $code!='' && time() <= $end_day){
				
				$total_price =0; $count_sale =0; $price_sale =0; $order_sale =0; $total_price_sale =0; $___price___sale =0;
				
				foreach($cart as $k => $v){
					$idpro = (int)$v['idpro'];
					if($v['deal']==1){ $pro = $this->deal_model->get_Id($idpro);}
					else{
						$pro = $this->product_model->get_Id($idpro); 
						}
							
					if($pro[0]['hot']==1){
						$___price___sale = $pro[0]['sale_price']*$v['qty'];
						$count_sale = 100 - 20;
						$price_sale = $count_sale / 100;
						$total_price_sale += $___price___sale * $price_sale;
						
						if($total_price_sale!=''){
							$flag = array(
								'type' => 'successful',
								'message' => 'Sản phẩm trong đơn hàng được giảm 20%'
							);
							$this->session->set_flashdata('message_flashdata', $flag);
						}	
						$get_code = $this->discount_model->get_code($code);
						if($get_code!=''){
							$arr_code = array(
								'code' => $get_code['code']
							); 
						$this->session->set_userdata($arr_code);
						}
					}else{ 
							 $total_price = $total_price+ $pro[0]['sale_price']*$v['qty'];	
							
						}	
					}
					
					if($total_price_sale!=''){
					    $total___price = $total_price_sale + $total_price;
						$arr_price_sale = array( 'toltal_sale' =>$total___price);
						$this->session->set_userdata($arr_price_sale);
						
					}else{
						$total___price = $total_price;
						$flag = array(
							'type' => 'error', 
							'message' => 'Sản phẩm trong đơn hàng không nằm tronh danh mục giảm 20%'
						);						
						$this->session->set_flashdata('message_flashdata', $flag);
					}
			}
	}
}
