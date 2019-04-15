<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends CI_Controller  {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('adminmenu_model');
        $this->load->model('offer_model');
        $this->load->model('product_model');
        $this->load->model('catelog_model');
        $this->load->helper('url');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $controller = $this->router->fetch_class();
        $act = $this->router->fetch_method();
        $this->permission->checkAdmin($controller,$act);
    }
    public function index()
    {
        $temp['template']='admincp/offer/index';
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
        $tukhoa = $this->input->get('tukhoa', TRUE) ? $this->input->get('tukhoa', TRUE): '';
        $type_search = $this->input->get('type_search', TRUE)?$this->input->get('type_search', TRUE): '';

        if($type_search==1){
            $where  = $this->input->get('tukhoa', TRUE) ? " AND `coupon_code` = '".$this->input->get('tukhoa', TRUE)."' " : '';

        }else{
            $where  = $this->input->get('tukhoa', TRUE) ? " AND `coupon_code` = '%".$this->input->get('tukhoa', TRUE)."%' " : '';
        }
        $sql = "SELECT * FROM payment_offer  WHERE 1 = 1 ".$where." ORDER BY ".$order;
        $sql_count = "SELECT COUNT(id) AS total
			 FROM payment_offer WHERE 1 = 1  ".$where;
        $p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
        $temp['data']['total']= $total = $this->offer_model->count_query($sql_count);
        $numrow = 50;
        $div = 10;
        $skip = $p * $numrow;
        $link	=	base_url('admincp/offer?tukhoa='.$tukhoa.'&p=');

        $temp['data']['info'] = $this->offer_model->get_query($sql,$numrow,$skip);
        $temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
        $temp['data']['tukhoa'] = $tukhoa;
        $this->load->view("admincp/layout",$temp);
    }

    public function add()
    {
        $id = $this->uri->segment(4);
        $temp['idmenu'] = 3;
        $temp['data']['map_title']  = "Thêm mới";
        $this->form_validation->set_message('required','Vui lòng nhập %s');
        $this->form_validation->set_rules('coupon_code','chương trình khuyến mãi','required');
        $this->form_validation->set_rules('discount_value','Giá trị giảm giá','required');
        $this->form_validation->set_rules('valid_from','Thời gian bắt đầu','required');
        $this->form_validation->set_rules('valid_until','Thời gian kết thúc','required');
        $this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

        if($this->input->post('save'))
        {
            if($this->form_validation->run() == TRUE  )
            {
                $post = $this->input->post();

                $post['valid_until'] = strtotime($post['valid_until']);
                $post['valid_from'] = strtotime($post['valid_from']);
                $post['create_date'] = time();
                unset($post['save']);
                $result = $this->offer_model->add($post);
                $url = base_url('admincp/offer');
                redirect($url);
            }
        }
        $temp['data']['listproduct'] = $this->pagehtml_model->getListProuct();

        $temp['data']['listcat'] = $this->pagehtml_model->get_catelog(0);
        $temp['template']='admincp/offer/add';
        $this->load->view("admincp/layout",$temp);
    }

    public function edit($id)
    {
        $id = $this->uri->segment(4);
        $info =  $this->offer_model->get_id_edit($id);
        $temp['data']['info'] = $info;
        $temp['idmenu'] = 3;
        $temp['data']['map_title']  = "Sửa";
        $this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

        $temp['template']='admincp/offer/edit';
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
            $this->offer_model->delete($id);
        }
        if($this->input->post('check_list')) {
            $checked = $this->input->post("check_list");
            if(!empty($checked)){
                foreach($checked as $k=>$v){
                    $this->offer_model->delete($v);
                }
            }
        }
        $this->page->redirect(base_url('admincp/offer'));
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
