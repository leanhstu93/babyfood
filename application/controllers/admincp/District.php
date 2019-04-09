<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class District extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('adminmenu_model');
		 $this->load->model('district_model');
		 $this->load->model('provinces_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
	}
	public function index()
	{
		$temp['template']='admincp/district/index'; 
		$temp['idmenu']=3;
		
		$temp['data']['tukhoa'] = $tukhoa =$this->input->get('tukhoa', TRUE)?$this->input->get('tukhoa', TRUE):0;
		$temp['data']['idcat'] = $idcat =$this->input->get('idcat', TRUE)?$this->input->get('idcat', TRUE):0;
		if($tukhoa!=""){
			$sql = "SELECT mn_district.*,(SELECT title_vn FROM mn_provinces WHERE mn_provinces.Id = mn_district.parentid) AS tinh FROM mn_district  WHERE ( title_vn like  '%".$tukhoa."%') AND ((idcat='".$idcat."') OR ".$idcat." = '0')   ORDER BY idcat ASC, sort ASC"; 
			$sql_toal = "SELECT COUNT(mn_district.Id) AS total FROM  mn_district  WHERE ( title_vn like  '%".$tukhoa."%') AND ((idcat='".$idcat."') OR ".$idcat." = '0')   ORDER BY idcat ASC, sort ASC "; 
		}else{
			$sql = "SELECT mn_district.*,(SELECT title_vn FROM mn_provinces WHERE mn_provinces.Id = mn_district.idcat) AS tinh FROM mn_district  WHERE ((idcat='".$idcat."') OR ".$idcat." = '0')   ORDER BY idcat ASC, sort ASC"; 
			$sql_toal = "SELECT COUNT(mn_district.Id) AS total FROM  mn_district  WHERE ((idcat='".$idcat."') OR ".$idcat." = '0')   ORDER BY idcat ASC, sort ASC "; 

		}
		$link	=	base_url('admincp/district/index?tukhoa='.$tukhoa.'&idcat='.$idcat.'&p=');
		$p =$this->input->get('p', TRUE)?str_replace("/","",$this->input->get('p', TRUE)):0;
		$numrow = 50;
		$div = 10;
		$skip = $p * $numrow;
		$temp['data']['info'] = $this->product_model->get_query($sql,$numrow,$skip);
		$temp['data']['total'] = $this->product_model->count_query($sql_toal); 
		$temp['data']['page']= $this->page->divPage($temp['data']['total'],$p,$div,$numrow,$link);
		
		$temp['data']['listcat'] = $this->provinces_model->getdata(array('ticlock'=>0));
	    $this->load->view("admincp/layout",$temp); 
	}
	public function add()
	{
		$id = $this->uri->segment(4);
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Thêm mới";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('title_vn','Tiêu đề','required');
		$this->form_validation->set_rules('idcat','Tỉnh thành','required|is_natural_no_zero');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');

		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				
				$result = $this->district_model->add();
				$url = base_url('admincp/district');
				redirect($url);
			}
		}
		$temp['data']['listcat'] = $this->provinces_model->getdata(array('ticlock'=>0));
		$temp['template']='admincp/district/add'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function edit($id)
	{
		$id = $this->uri->segment(4);
		$info = $this->district_model->get_where($id);
		$temp['data']['info'] = $info[0];
		$temp['idmenu'] = 3;
		$temp['data']['map_title']  = "Sửa";
		$this->form_validation->set_message('required','Vui lòng nhập %s');
		$this->form_validation->set_rules('title_vn','Tiêu đề','required');
		$this->form_validation->set_rules('idcat','Tỉnh thành','required|is_natural_no_zero');
		$this->form_validation->set_error_delimiters('<span class="input-error ">', '</span>');
		if($this->input->post('save'))
		{
			if($this->form_validation->run() == TRUE  )
			{
				$result = $this->district_model->update($id,NULL,true);
				redirect(base_url('admincp/district'));
			}
		}
				$temp['data']['listcat'] = $this->provinces_model->getdata(array('ticlock'=>0));
		$temp['template']='admincp/district/edit'; 
		$this->load->view("admincp/layout",$temp); 
	}
	public function delete()
	{
		$id = $this->uri->segment(4);
		if($id>0){
			 $this->district_model->delete($id);
		}
		if($this->input->post('check_list')) {
			$checked = $this->input->post("check_list");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$this->district_model->delete($v);
				}
			}
		}
		redirect(base_url('admincp/district'));
	}
	public function save()
	{
		if($this->input->post('sort')) {
			$checked = $this->input->post("sort");
			if(!empty($checked)){
				foreach($checked as $k=>$v){
					$data['sort'] = $v;
					$this->district_model->update($k,$data);
				}
			}
		}
		redirect(base_url('admincp/district'));
	}
    
    function ajax_get() {
        $idcat = $this->input->post('idcat');
        $district = array('Id' => 0, 'title_vn' => '--Quận/Huyện--');
        $districts = $this->db->query("SELECT Id,title_vn FROM mn_district WHERE idcat='".$idcat."'")->result();
        $response[] = (object)$district;
        foreach($districts as $district) {
            $response[] = $district;
        }
        echo json_encode($response);
    }
}
