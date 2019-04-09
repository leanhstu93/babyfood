<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 	
		 $this->load->model('adminmenu_model');
		 $this->load->model('voucher_model');
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
		$temp['template']='admincp/voucher/index'; 
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
			$sql = "SELECT * FROM mn_voucher  WHERE ( code = '".$tukhoa."' OR order_id = '".$tukhoa."' OR '".$tukhoa."' = -1 ) ORDER BY ".$order;
			 $sql_count = "SELECT COUNT(r1.id) AS total
			 FROM mn_voucher AS r1 WHERE  ( code = '".$tukhoa."' OR order_id = '".$tukhoa."'  OR '".$tukhoa."' = -1 )";

		}else{
			 
			 $sql ="SELECT *, (SELECT user_id FROM mn_discount WHERE mn_discount.code = mn_voucher.code) AS userid, (SELECT username FROM mn_user WHERE mn_user.id = userid) as username, (SELECT created FROM mn_discount WHERE mn_discount.code = mn_voucher.code) as created, (SELECT email FROM mn_user WHERE mn_user.id = userid) as email, (SELECT fullname FROM mn_user WHERE mn_user.id = userid) as fullname FROM mn_voucher WHERE( code like '%".$tukhoa."' OR order_id like '%".$tukhoa."' OR '".$tukhoa."' =-1 ) ORDER BY ".$order;
			 
			 $sql_count = "SELECT COUNT(r1.id) AS total
			 FROM mn_voucher AS r1 WHERE ( code like '%".$tukhoa."%' OR order_id like '%".$tukhoa."%'  OR '".$tukhoa."' = -1 ) ";
		}
		$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
		$temp['data']['total']= $total = $this->voucher_model->count_query($sql_count);
		$numrow = 50;
		$div = 10;
		$skip = $p * $numrow;
		$link	=	base_url('admincp/voucher?tukhoa='.$tukhoa.'&p=');
		$temp['data']['info'] = $this->voucher_model->get_query($sql,$numrow,$skip);
		$temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
		$temp['data']['tukhoa'] = $tukhoa;
	    $this->load->view("admincp/layout",$temp); 
	}
	public function export_excel_voucher(){
	
	$this->load->library('phpexcel');
	
	$sheet = $this->phpexcel->getActiveSheet(); 
	
		
			$objWorkSheet = $this->phpexcel->createSheet(0);	
			$objWorkSheet->setCellValue('A1', 'STT');
			$objWorkSheet->setCellValue('B1', 'HỌ TÊN');
			$objWorkSheet->setCellValue('C1', 'USER ID');
			$objWorkSheet->setCellValue('D1', 'USERNAME');
			$objWorkSheet->setCellValue('E1', 'EMAIL');
			$objWorkSheet->setCellValue('F1', 'LOẠI VOUCHER');
			$objWorkSheet->setCellValue('G1', 'NGÀY ĐĂNG KÝ');
			$objWorkSheet->setCellValue('H1', 'NGÀY HẾT HẠN');
			$objWorkSheet->setCellValue('I1', 'TRẠNG THÁI');
			$objWorkSheet->setCellValue('J1', 'MÃ ĐƠN HÀNG');
			$objWorkSheet->setCellValue('K1', 'CODE VOUCHER');

			//-------------------------------
			$page = 24000 + $i*1000;
			$result_data = $this->voucher_model->get_all_data(0, $page);
			
			if(!empty($result_data)){
				$k=1;
				//$j= $page;
				 foreach ($result_data as $item) { 
				 $k++;
				 $j++;
				switch ($item['price']) {
						case 2000:
							$vc =' Voucher 2 triệu';
							break;
						case 1000:
							$vc = 'Voucher 1 triệu';
							break;
						case 500:
							$vc= 'Voucher 500k';
							break;
						case 200:
							$vc= 'Voucher 200K';
							break;
						case 100:
							$vc = 'Voucher 100k';
							break;
						case 20:
							$vc = 'Giảm 20%';
							break;
						}
						if($item['status']==1){ $status = "Đã sử dụng";} else $status= 'Chưa sử dụng';
				 	
						$objWorkSheet->setCellValue('A'.$k, $j);
						$objWorkSheet->setCellValue('B'.$k, $item['fullname']);
						$objWorkSheet->setCellValue('C'.$k, $item['userid']);
						$objWorkSheet->setCellValue('D'.$k, $item['username']);
						$objWorkSheet->setCellValue('E'.$k, $item['email']);
						$objWorkSheet->setCellValue('F'.$k, $vc);
						$objWorkSheet->setCellValue('G'.$k, date('d-m-Y', $item['start_day']));
						$objWorkSheet->setCellValue('H'.$k, date('d-m-Y', $item['end_day']));
						$objWorkSheet->setCellValue('I'.$k, $status);
						$objWorkSheet->setCellValue('J'.$k, $item['order_id']);
						$objWorkSheet->setCellValue('K'.$k, $item['code']);
				 }
			}
			//------------
			$objWorkSheet->setTitle('Danh sách mã voucher');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			//sleep(10);
		
		$this->phpexcel->setActiveSheetIndex(0);
		
	$filename='danh_sach_code_voucher.xls'; //save our workbook as this file name
	
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	
	$objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');  
	$objWriter->save('php://output');
	
	}	
    
    public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Thêm mới";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('code','Tiêu đề','required');
		$this->form_validation->set_rules('price','Giá trị giảm giá','required');
		$this->form_validation->set_rules('start_day','Thời gian bắt đầu','required');
		$this->form_validation->set_rules('end_day','Thời gian kết thúc','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$post = $this->input->post();
                $post['start_day'] = strtotime($post['start_day']);
                $post['end_day'] = strtotime($post['end_day']);
                $post['created'] = time();
                unset($post['save']);
				$result = $this->voucher_model->add($post);
				$url = base_url('admincp/voucher');
				redirect($url);
			}
		}
		$temp['template']='admincp/voucher/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info =  $this->voucher_model->get_id_edit($id);
		$temp['data']['info'] = $info;
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
				$this->voucher_model->update($id,NULL,TRUE);
				redirect(base_url('voucher/user'));
			}
		}
		$temp['data']['listprovinces'] = $this->provinces_model->getdata(array('ticlock'=>0));
		$temp['template']='admincp/voucher/edit'; 
		$this->load->view("admincp/layout",$temp); 
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
		$info =  $this->voucher_model->get_where(array('id'=>$id),1,0);
		$arr['cash']=$info[0]['cash'] + $cash;
		$this->voucher_model->update($id,$arr);
		}
		$this->page->redirect(base_url('admincp/user/edit/'.$id));
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->voucher_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->voucher_model->delete($v);
				}
			}
		}
		$this->page->redirect(base_url('admincp/voucher'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->voucher_model->update($k,$data);
				}
			}
		}
		$this->page->redirect(base_url('admincp/user'));
	}
	
}
