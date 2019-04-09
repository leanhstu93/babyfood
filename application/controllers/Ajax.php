<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	protected $arrowmap = " > ";
	protected $map_title = '<a href="/">Trang chủ</a>';
	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('catelog_model');
		 $this->load->model('flash_model');
		 $this->load->model('user_model');
		 $this->load->model('size_model');
		 $this->load->model('color_model');
		 $this->load->model('comment_model');
		 $this->load->model('provinces_model');
		 $this->load->model('manufacturer_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
	public function vquyen(){
		if(isset($_POST['save'])){
			$src_none = './upload/original/';
			$src_resize = './upload/' ;
			$src_thumb = './upload/thumbs/';	
			$this->load->library('image_lib');
			$config = array(
					'allowed_types'     => 'jpg|jpeg|gif|png', 
					'overwrite'			=> TRUE,
					'max_size'          => 0,//2048000, //2MB max
					'max_width'			=> 0,
					'max_height'		=> 0,
					'upload_path'       => $src_resize 
		  		);
			$this->load->library('upload', $config);
			if($this->upload->do_upload("images")) {
				$upload_data = $this->upload->data();
					$data['photo'] = $upload_data['file_name'];
					$image_config["image_library"] = "GD2";
					$image_config["source_image"] = $upload_data["full_path"];
					$image_config['create_thumb'] = FALSE;
					$image_config['maintain_ratio'] = TRUE;
					$image_config['new_image'] = $src_resize;
					$image_config['quality'] = "100%";
					$image_config['width'] = 300;
					$image_config['height'] = 300;
					$image_config['overwrite'] = TRUE;
					$dim = (intval($upload_data["image_width"]) / intval($upload_data["image_height"])) - ($image_config['width'] / $image_config['height']);
					$image_config['master_dim'] = ($dim > 0)? "height" : "width";
					
					$this->load->library('image_lib');
					$this->image_lib->initialize($image_config);
					
					if(!$this->image_lib->resize()){ 
						echo "Lỗi <hr />";
					}else{
						$image_config['overwrite'] = TRUE;
						$image_config['image_library'] = 'GD2';
						$image_config['source_image'] = $src_resize.$upload_data['file_name'];
						$image_config['new_image'] = $src_resize;
						$image_config['quality'] = "100%";
						$image_config['maintain_ratio'] = FALSE;
						$image_config['width'] = 250;
						$image_config['height'] = 250;
						$image_config['x_axis'] = 0;
						$image_config['y_axis'] = 0;
						$this->image_lib->clear();
						$this->image_lib->initialize($image_config); 
						$this->image_lib->crop();
						echo "Thành công <hr />";
					}
			}
		}
		echo "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\"><input type=\"file\" name=\"images\" /><button type=\"submit\" name=\"save\" value=\"save\">Tai len</button></form>";
	}
	public function promotion()
	{
		$p  = $this->input->post('page', TRUE);
		$numrow  = $this->input->post('numpage', TRUE);
		$skip = $p * $numrow;
		$temp['pro']=  $this->product_model->list_data(array('ticlock'=>0,'trash'=>0,'hot'=>1),$numrow,$skip);
		$this->load->view("default/ajax/promotion",$temp); 
	}
	public function keyword()
	{
		$q  = $this->input->post('q', TRUE);
		$q = $this->page->escape_str($q);
		$this->load->model('news_model');
		$sql = "SELECT * FROM mn_tags WHERE ticlock=0 AND ( title_vn like '%".$q."%' OR alias like '%".$q."%' ) ORDER BY views DESC";
		$info =  $this->news_model->get_query($sql,10,0);
		$data = "<div class=\"shopee-searchbar-hints\"><div class=\"shopee-searchbar-hints__header\">Gợi ý</div>";
		$error = true;
		if(!empty($info)){
			$error = false;
			foreach($info as $item){
				$data .="<a href=\"tim-kiem.html?catelog=0&s=".$item["title_vn"]."\" class=\"shopee-searchbar-hints__history-entry\" >".$item["title_vn"]."</a>";
			}
		}
		die(json_encode(array("error"=>$error,"data"=>$data)));
	}
	public function loadDistrict() {
		$id = $this->input->get('province_id');
		$this->load->model('district_model');
		$results = $this->district_model->list_district('idcat='.$id);
		foreach($results as $item) {
			$html .= '<option value="'.$item['Id'].'" data-price="'.$item['ship'].'" data-priceformat="'.number_format($item['ship']).'">'.$item['title_vn'].'</option>';
		}
		echo $html;
	}
	public function addEmail() {
		$this->load->model('contact_model');
		$email = $this->input->post('femail');
		if($email != '') {
			$this->contact_model->add(array('email' => $email, 'date' => time()));
			echo 'ok';
		}
	}
	public function getShip() {
		$iddistrict = $this->input->get('iddistrict');
		$ship = $this->db->where('Id', $iddistrict)->get('mn_district')->row_array();
		$cart = $this->session->userdata('cart');
		$tong = 0;
		foreach($cart as $k => $v){
			$arr['idpro'] = $idpro=  (int)$v['idpro'];
			$pro = $this->product_model->get_Id($idpro);
			$tong += $pro[0]['sale_price']*$v['qty'];
		}
		$res = array(
			'total' => bsVndDot($tong + $ship['ship'] - $this->session->userdata('voucher_price')),
			'ship' => bsVndDot($ship['ship'])
		);
		header('Content-Type: application/json');
		echo json_encode($res);
	}
}
?>