<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller  {
	
	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('payment_model');
		 $this->load->model('deal_model');
		 $this->load->model('size_model');
		 $this->load->model('color_model');
		 $this->load->model('adminmenu_model');
		 $this->load->model('commentpayment_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
	
		$temp['template']='admincp/payment/index'; 
		$temp['idmenu']=3;	
		
		$this->session->unset_tempdata('sort');
		//***-----------------sort---------------
		if($this->input->post('sortitem')){
			$sortitem = $this->input->post('sortitem');
			$sorvalue = $this->input->post('sorvalue');
			if($sorvalue=='0'){
				$sorvalue = 'asc';
			}else $sorvalue = 'desc';
			$val = $sortitem." ".$sorvalue;
			$this->session->set_userdata('sort',$val);
		}
		if($this->session->userdata('sort')){
			$order = $this->session->userdata('sort');
		}else{
			$order  = "date DESC";
		}
		
		$tukhoa =$this->input->get('tukhoa', TRUE)?$this->input->get('tukhoa', TRUE):-1;
		$status = $this->input->get('status');
		
		if($status!=''){
			
			$sql = "SELECT * FROM mn_customer  WHERE status like'%".$status."%' ORDER BY ".$order;
			
			$sql_toal = "SELECT COUNT(Id) AS total FROM mn_customer WHERE status like'%".$status."%' ORDER BY ".$order;
			
		}else{
		
		$sql = "SELECT * FROM mn_customer  WHERE (  code like  '%".$tukhoa."%' OR fullname like  '%".$tukhoa."%' OR phone like  '%".$tukhoa."%' OR '".$tukhoa."' = -1 ) ORDER BY ".$order;
		
		$sql_toal = "SELECT COUNT(Id) AS total FROM mn_customer   WHERE ( fullname like  '%".$tukhoa."%' OR phone like  '%".$tukhoa."%' OR '".$tukhoa."' = -1 ) ORDER BY ".$order;
		
		}
		
		
		$link	=	base_url('admincp/payment/index?id=0&tukhoa='.$tukhoa.'&status='.$status.'&p=');
		//*---------------pagination------------------
		$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
		$numrow = 50;
		$div = 10;
		$skip = $p * $numrow;
		
		$temp['data']['info'] = $this->payment_model->get_query($sql,$numrow,$skip);
		$temp['data']['total'] = $this->payment_model->count_query($sql_toal); 
		$temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
		
	    $this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$temp['idmenu']=3;		
		 $sql = "SELECT mn_customer.*,(SELECT code FROM mn_voucher WHERE mn_voucher.order_id = mn_customer.code) AS codevoucher, (SELECT title_vn FROM mn_provinces WHERE mn_provinces.Id = mn_customer.idprovinces) AS provinces,(SELECT title_vn FROM mn_district WHERE mn_district.Id = mn_customer.iddistrict) AS district,(SELECT free FROM mn_district WHERE mn_district.Id = mn_customer.iddistrict) AS free,(SELECT ship FROM mn_district WHERE mn_district.Id = mn_customer.iddistrict) AS ship FROM mn_customer WHERE Id=".$id;
		$temp['data']['cus'] = $this->payment_model->get_query($sql,1,0);
		
		$sql = "SELECT  * FROM mn_customer_cart WHERE idcustomer=".$id;
		$temp['data']['cart'] = $this->payment_model->get_query($sql,100,0);
		$this->payment_model->update($id,array('view'=>1));
		if($this->input->post('tinhtrang')){
			$arr = array(
                "status"=>$this->input->post('tinhtrang')
            );
            
			$this->payment_model->update($id,$arr);
			redirect(base_url('admincp/payment'));
		}
        if($this->input->post('savelocation')) {
            $arr = array(
                "address" => $this->input->post('address'),
                "idprovinces"=>$this->input->post('idprovinces'),
                "iddistrict"=>$this->input->post('iddistrict')
            );
			$this->payment_model->update($id,$arr);
			redirect(base_url('admincp/payment'));
        }
        
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('note','Nội dung','required');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save')){
			if($this->form_validation->run() == TRUE  )
			{
				$brr['idcustommer'] = $id;
				$brr['date'] = time();
				$brr['admin'] = $this->session->userdata('login_admin_username');
				$brr['content'] = $this->input->post('note');
				$this->commentpayment_model->add($brr);
				redirect(base_url('admincp/payment/edit/'.$id));
			}
		}
		$temp['data']['comment'] =$this->commentpayment_model->get_list(array('idcustommer'=>$id),"Id ASC",1000,0);
		$temp['template']='admincp/payment/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function orderjson(){
		$sql = "SELECT COUNT(Id) as total FROM  mn_customer WHERE view !=1";
		$total =  $this->payment_model->count_query($sql);
		
		$sql = "SELECT COUNT(Id) as total FROM  mn_contact WHERE view !=1";
		$lienhe =  $this->payment_model->count_query($sql);
		
		if($total>0){
			$donhang = $total;
			$lienhe = $lienhe;
			$alert = true;
		}else{
			$donhang = 0;
			$lienhe = 0;
			$alert = false;
		}
		
		die(json_encode(array("alert"=>$alert,"donhang"=>$donhang,"lienhe"=>$lienhe)));
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->payment_model->delete($id);
			
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->payment_model->delete($v);
					
				}
			}
		}
		redirect(base_url('admincp/payment'));
	}
	public function printorder($id=0)
	{
		$sql = "SELECT mn_customer.*, 
		(SELECT title_vn FROM mn_provinces WHERE mn_provinces.Id = mn_customer.idprovinces) AS provinces,
		(SELECT title_vn FROM mn_district WHERE mn_district.Id = mn_customer.iddistrict) AS district,
		(SELECT free FROM mn_district WHERE mn_district.Id = mn_customer.iddistrict) AS free,
		(SELECT ship FROM mn_district WHERE mn_district.Id = mn_customer.iddistrict) AS ship, 
		(SELECT title_vn FROM mn_provinces WHERE mn_provinces.Id = mn_customer.idprovinces) AS provinces
		FROM mn_customer WHERE Id=".$id;
		$temp['cus'] = $this->payment_model->get_query($sql,1,0);
		
		$sql = "SELECT  * FROM mn_customer_cart WHERE idcustomer=".$id;
		$temp['cart'] = $this->payment_model->get_query($sql,100,0);
		
		$temp['voucher_sale'] = $this->db->where('order_id', $id)->get('mn_voucher')->row_array();
		
		$this->load->view("admincp/payment/printorder",$temp); 
	}
	
	
}

