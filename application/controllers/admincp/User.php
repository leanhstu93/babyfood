<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('user_model');
		 $this->load->model('comment_model');
		  $this->load->model('provinces_model');
		 $this->load->helper('url');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/user/index'; 
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
			$sql = "SELECT * FROM mn_user  WHERE ( username = '".$tukhoa."' OR fullname = '".$tukhoa."' OR email = '".$tukhoa."' OR '".$tukhoa."' = -1 ) ORDER BY ".$order;
			 $sql_count = "SELECT COUNT(r1.id) AS total
			 FROM mn_user AS r1 WHERE  ( username = '".$tukhoa."' OR fullname = '".$tukhoa."' OR email = '".$tukhoa."' OR '".$tukhoa."' = -1 ) AND level = '2'";

		}else{
			$sql = "SELECT *
			 FROM mn_user  WHERE ( username like '%".$tukhoa."%' OR fullname like '%".$tukhoa."%' OR email like '%".$tukhoa."%' OR '".$tukhoa."' = -1 )  ORDER BY ".$order;
			 $sql_count = "SELECT COUNT(r1.id) AS total
			 FROM mn_user AS r1 WHERE ( username like '%".$tukhoa."%' OR fullname like '%".$tukhoa."%' OR email like '%".$tukhoa."%' OR '".$tukhoa."' = -1 ) ";
		}
		$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
		$temp['data']['total']= $total = $this->user_model->count_query($sql_count);
		$numrow = 50;
		$div = 10;
		$skip = $p * $numrow;
		$link	=	base_url('admincp/user?tukhoa='.$tukhoa.'&p=');
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
		$temp['template']='admincp/user/sentemail'; 
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
		$this->form_validation->set_rules('fullname', 'Họ tên', 'required');
		$this->form_validation->set_rules('address', 'Địa chỉ', 'required');
		$this->form_validation->set_rules('phone', 'Điện thoại', 'required');
		$this->form_validation->set_rules('idtinh','Tỉnh thành','required|is_natural_no_zero');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$this->user_model->update($id,NULL,TRUE);
				redirect(base_url('admincp/user'));
			}
		}
		$temp['data']['listprovinces'] = $this->provinces_model->getdata(array('ticlock'=>0));
		$temp['template']='admincp/user/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delcomment()
	{
		$id = $this->uri->segment(4);
		$iduser = $this->uri->segment(5);
		$result = $this->comment_model->delete($id);
		$this->page->redirect(base_url('admincp/user/edit/'.$iduser));
	}
	public function update(){
		$id = $this->uri->segment(4);
		$idmon = $this->input->post('idm');
		$payment = $this->input->post('payment');
		$payment = str_replace(".", "", $payment);
		$price = $this->input->post('price');
		$cash = $price - $payment;
		
		$this->money_model->update($idmon,array('payment'=>$payment,'time'=>time()));
		if($cash>0){
		$info =  $this->user_model->get_where(array('id'=>$id),1,0);
		$arr['cash']=$info[0]['cash'] + $cash;
		$this->user_model->update($id,$arr);
		}
		$this->page->redirect(base_url('admincp/user/edit/'.$id));
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
		$this->page->redirect(base_url('admincp/user'));
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
		$this->page->redirect(base_url('admincp/user'));
	}
	public function excel_total()
	{
		set_time_limit(0);
		$this->load->library('excel');
		//truy van 
		$sql = "SELECT r1.id,r1.fullname,r1.clicktotal,r1.tongthunhap,r1.hoahong,r1.date,r1.username,
			r1.ticlock,r1.active,r1.oldcash,r1.email,r1.phone,
			(SELECT title_vn FROM mn_provinces  WHERE mn_provinces.Id = r1.idtinh)  as provincesname,
			(SELECT COUNT(id) FROM mn_user as t3 WHERE t3.magioithieu = r1.id) as totaluser,
			(SELECT username FROM mn_user as t2  WHERE t2.id = r1.magioithieu)  as tennguoigioithieu, 
			(SELECT COUNT(id) FROM mn_comment  WHERE mn_comment.idpro = r1.id) as totalcomment,
			(SELECT COUNT(Id) FROM mn_product WHERE mn_product.iduser = r1.id) AS totallinks
			 FROM mn_user AS r1 ORDER BY r1.date DESC";  
			 
		$sheet = $this->excel->getActiveSheet(); 
		for($i=0;$i<4;$i++){
				$objWorkSheet = $this->excel->createSheet($i);	
				$objWorkSheet->setCellValue('A1', 'STT');
				$objWorkSheet->setCellValue('B1', 'HỌ TÊN');
				$objWorkSheet->setCellValue('C1', 'USERNAME');
				$objWorkSheet->setCellValue('D1', 'TỈNH THÀNH');
				$objWorkSheet->setCellValue('E1', 'NGÀY ĐĂNG KÝ');
				$objWorkSheet->setCellValue('F1', 'NGƯỜI GIỚI THIỆU');
				$objWorkSheet->setCellValue('G1', 'TỔNG LINK');
				$objWorkSheet->setCellValue('H1', 'TỔNG VIEW');
				$objWorkSheet->setCellValue('I1', 'THU NHẬP');
				$objWorkSheet->setCellValue('J1', 'TV NHÓM');
				$objWorkSheet->setCellValue('K1', 'HOA HỒNG');
				$objWorkSheet->setCellValue('L1', 'TỔNG THU NHẬP');
				$objWorkSheet->setCellValue('M1', 'EMAIL');
				$objWorkSheet->setCellValue('N1', 'ĐIỆN THOẠI');
				$objWorkSheet->setCellValue('O1', 'TÌNH TRẠNG');
			//-------------------------------
			$page = 24000 + $i*1000;
			$info = $this->user_model->get_query($sql,1000,$page);
			if(!empty($info)){
				$k=1;
				$j= $page;
				 foreach ($info as $item) { 
				 $k++;
				 $j++;
				 if($item->active==1) $tinhtrang=" Đã bị khóa";
				 else $tinhtrang=" Đang hoạt động";
				 	
						$objWorkSheet->setCellValue('A'.$k, $j);
						$objWorkSheet->setCellValue('B'.$k, $item->fullname);
						$objWorkSheet->setCellValue('C'.$k, $item->username);
						$objWorkSheet->setCellValue('D'.$k, $item->provincesname);
						$objWorkSheet->setCellValue('E'.$k, date( "d-m-Y",strtotime($item->date)));
						$objWorkSheet->setCellValue('F'.$k, $item->tennguoigioithieu);
						$objWorkSheet->setCellValue('G'.$k, $item->totallinks);
						$objWorkSheet->setCellValue('H'.$k, $item->clicktotal);
						$objWorkSheet->setCellValue('I'.$k, ($item->tongthunhap-$item->hoahong));
						$objWorkSheet->setCellValue('J'.$k, $item->totaluser);
						$objWorkSheet->setCellValue('K'.$k, $item->hoahong);
						$objWorkSheet->setCellValue('L'.$k, $item->tongthunhap+$item->oldcash);
						$objWorkSheet->setCellValue('M'.$k, $item->email);
						$objWorkSheet->setCellValue('N'.$k, $item->phone);
						$objWorkSheet->setCellValue('O'.$k, $tinhtrang);
				 }
			}
			//------------
			$objWorkSheet->setTitle('Danh sách thành viên');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			//sleep(10);
		}
		$this->excel->setActiveSheetIndex(0);
		
		
		$filename='danhsachthanhvienoni.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  

		$objWriter->save('php://output');
		die;
	}
}
