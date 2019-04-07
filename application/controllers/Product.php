<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
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
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}

	public function get_product($alias = '')
	{
		$temp['data']['cat'] = $info_cat = $this->catelog_model->get_list(array('alias'=>$alias));
		if(!$alias || empty($info_cat)) redirect(base_url('404.html'));
		$cat_id = $info_cat[0]['Id'];
		//--------meta-----------
		$temp['meta']['title'] = $info_cat[0]['meta_title'] ? $info_cat[0]['meta_title'] : $info_cat[0]['title_vn'];
		$temp['meta']['description'] = $info_cat[0]['meta_description'];
		$temp['meta']['keywork'] = $info_cat[0]['meta_keyword'];
		$temp['data']['namepage'] = 'getproduct';
		//-----------------Fillter-------
		$p  = $this->input->get('page', TRUE);
		$size_select  = $this->input->get('size', TRUE);
		$color_select  = $this->input->get('color', TRUE);
		$manu_select  = $this->input->get('manu', TRUE);
		
		$temp['data']['fromprice'] = $fromprice  = (int)$this->input->get('min_price', TRUE);
		$temp['data']['toprice'] = $toprice  = (int)$this->input->get('max_price', TRUE);
		$temp['data']['sort'] = $sort  = $this->input->get('sort', TRUE);
		if(empty($sort)) $temp['data']['sort'] = $sort = "sort ASC";
		if(empty($fromprice)) $temp['data']['fromprice'] = $fromprice = 0;
		if(empty($toprice)) $temp['data']['toprice']=$toprice = 1000000000;
		$temp['data']['manu_select']  =  $arr_manu = GetArr($manu_select);
		//----------------------------
		$sort .= ",Id DESC";
		$subid =$this->page->getSubCatlogId($info_cat[0]['Id']);
		if($subid != ""){
			$subid = substr($subid,0,-1);
			$sql ="SELECT * FROM  mn_product 
			 	 WHERE idcat IN (".$info_cat[0]['Id'].",".$subid.") AND ticlock = 0  AND trash = 0 AND status = 0
			 	 AND sale_price >=".$fromprice." AND sale_price <=".$toprice." 
			 	 ORDER BY ".$sort;

            $sql_price ="SELECT MAX(mn_product.sale_price) AS price_max, MIN(mn_product.sale_price) AS price_min FROM  mn_product 
			 	 WHERE idcat IN (".$info_cat[0]['Id'].",".$subid.") AND ticlock = 0  AND trash = 0 AND status = 0
			 	 ORDER BY ".$sort;
				 //$subid[] = $cat_id;*/
			//var_dump($subid);
			$data_product = $this->product_model->get_product($subid,$fromprice,$toprice,$sort);
			//$count_product= $this->product_model->cout_product($subid,$fromprice,$toprice,$sort);
			
			
			$sql_total = "SELECT COUNT(mn_product.Id) AS total FROM mn_product 
				WHERE idcat IN (".$info_cat[0]['Id'].",".$subid.") AND ticlock = 0  AND trash = 0 AND status = 0
			 	 AND sale_price >=".$fromprice." AND sale_price <=".$toprice." 
				 GROUP BY mn_product.Id ";
				
			$sql_max_price ="SELECT MAX(mn_product.sale_price) AS pricemax
				 FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE mn_product.idcat IN (".$info_cat[0]['Id'].",".$subid.") and mn_product.ticlock = 0 ";

		}else{
			$sql ="SELECT * FROM  mn_product 
			 	 WHERE idcat IN (".$info_cat[0]['Id'].") AND ticlock = 0  AND trash = 0  AND status = 0
			 	 AND sale_price >=".$fromprice." AND sale_price <=".$toprice." 
			 	 GROUP BY mn_product.Id
			 	 ORDER BY ".$sort;

			$sql_total = "SELECT COUNT(mn_product.Id) AS total FROM mn_product
				 WHERE  ticlock =0 and idcat = '".$info_cat[0]['Id']."' AND mn_product.trash = 0  AND status = 0
				AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice." 
				GROUP BY mn_product.Id ";
			$sql_max_price ="SELECT MAX(mn_product.sale_price) AS pricemax
				FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE  ticlock =0 and idcat = '".$info_cat[0]['Id']."'";

            $sql_price ="SELECT MAX(mn_product.sale_price) AS price_max, MIN(mn_product.sale_price) AS price_min FROM  mn_product 
			 	 WHERE idcat IN (".$info_cat[0]['Id'].") AND ticlock = 0  AND trash = 0 AND status = 0
			 	 ORDER BY ".$sort;
				
		}
		$temp['data']['subcat']   = $this->pagehtml_model->get_catelog($info_cat[0]['Id'],50);
		if(empty($temp['data']['subcat'])){
			$temp['data']['subcat']   = $this->pagehtml_model->get_catelog($info_cat[0]['parentid'],50);
		}

		//breadcrumb
		if($info_cat[0]['parentid'] > 0) {
			$info_parent = $this->catelog_model->get_list(array('Id'=>$info_cat[0]['parentid']));
			if($info_parent[0]['parentid'] > 0) {
				$info_parent1 = $this->catelog_model->get_list(array('Id'=>$info_parent[0]['parentid']));
				$temp['breadcrumbs'][] = array(
					'title' => $info_parent1[0]['title_vn'],
					'href' => base_url($info_parent1[0]['alias'])
				);
			}
			$temp['breadcrumbs'][] = array(
				'title' => $info_parent[0]['title_vn'],
				'href' => base_url($info_parent[0]['alias'])
			);
		}
		$temp['breadcrumbs'][] = array(
			'title' => $info_cat[0]['title_vn'],
			'href' => base_url($info_cat[0]['alias'])
		);
		
		$numrow = 12;
		$div = 5;
		$skip = $p * $numrow;
		$temp['data']['linkredirect'] = BASE_URL.$info_cat[0]['alias'];
		$temp['data']['linked'] =  getLink($temp['data']['linkredirect'],0,$arr_manu,$fromprice,$toprice,$sort,$task = 'link',null,null);
		
		$temp['data']['linkedsort'] =  getLink($temp['data']['linkredirect'],0,$arr_manu,$fromprice,$toprice,$sort,$task = 'no-sort',null,null);
				
		$total= count($this->product_model->get_query($sql_total,0,0));
		$temp['data']['totalItem']= count($this->product_model->get_query($sql_total,0,0));
		//$temp['data']['info']= $this->product_model->get_query($sql,$numrow,$skip);
		//$temp['data']['page']= $this->page->divPageF($total,$p,$div,$numrow,$temp['data']['linked']."&page=" );
		$info_max_price =  $this->product_model->get_query($sql_max_price,1,0);
        $info_price =  $this->product_model->get_query($sql_price);
		$temp['data']['toprice'] = $info_max_price/*[0]['pricemax']*/;
		/*if($info_cat[0]['parentid'] == 0) {
			$menus = $this->catelog_model->get_list(array('parentid'=>$info_cat[0]['Id']),0,0);
			$title_category = $info_cat;
		} else {
			$menus = $this->catelog_model->get_list(array('parentid'=>$info_cat[0]['parentid']),0,0);
			$title_category = $this->catelog_model->get_list(array('Id'=>$info_cat[0]['parentid']));
		}*/
		$temp['data']['title_category'] = $title_category[0]['title_vn'];
		$menu =$temp['data']['menu'] = $this->catelog_model ->get_sub_menu($cat_id);
		//var_dump($cat_id);
		/*$temp['data']['menu']  = $this->catelog_model->list_data();
		$temp['data']['menu']  = $this->catelog_model->get_list(array('ticlock'=>'0'),0,0);
		*/
		$config['base_url'] = BASE_URL.$info_cat[0]['alias'];
        $config['reuse_query_string'] = TRUE;
		$config["total_rows"] = $total;
		$config["per_page"] = $data["per_page"] = 12;
		$config["uri_segment"] = 2;
		$config['num_links'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this -> pagination -> initialize($config);
		$page = ($this->uri->segment(2))? $this->uri->segment(2) : 0;
		$offset = ($page  == 0) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		$temp['data']['info']= $this->product_model->get_query($sql,$config["per_page"],$offset);
		$temp['data']['info_price'] = $info_price[0];
		$temp['data']['phantrang']= $this->pagination->create_links();
        //debug($sql);
		/*$sqli = $this->db->last_query();
			echo $sqli;*/
		$temp['template']='default/product/danh-muc';
		$this->load->view("default/layout",$temp); 	
	}
	public function category($alias = ''){
		$temp['data']['cat'] = $info_cat = $this->catelog_model->get_list(array('alias'=>$alias));
		if(!$alias || empty($info_cat)) redirect(base_url('404.html'));
		$cat_id = $info_cat[0]['Id'];
		//--------meta-----------
		$temp['meta']['title'] = $info_cat[0]['meta_title'] ? $info_cat[0]['meta_title'] : $info_cat[0]['title_vn'];
		$temp['meta']['description'] = $info_cat[0]['meta_description'];
		$temp['meta']['keywork'] = $info_cat[0]['meta_keyword'];
		$temp['data']['namepage'] = 'getproduct';
		//breadcrumb
		if($info_cat[0]['parentid'] > 0) {
			$info_parent = $this->catelog_model->get_list(array('Id'=>$info_cat[0]['parentid']));
			if($info_parent[0]['parentid'] > 0) {
				$info_parent1 = $this->catelog_model->get_list(array('Id'=>$info_parent[0]['parentid']));
				$temp['breadcrumbs'][] = array(
					'title' => $info_parent1[0]['title_vn'],
					'href' => base_url($info_parent1[0]['alias'])
				);
			}
			$temp['breadcrumbs'][] = array(
				'title' => $info_parent[0]['title_vn'],
				'href' => base_url($info_parent[0]['alias'])
			);
		}
		$temp['breadcrumbs'][] = array(
			'title' => $info_cat[0]['title_vn'],
			'href' => base_url($info_cat[0]['alias'])
		);
		$temp['data']['title_category'] = $title_category[0]['title_vn'];
		$menu =$temp['data']['menu'] = $this->catelog_model ->get_sub_menu($cat_id);
		$temp['template']='default/product/danh-muc';
		$this->load->view("default/layout",$temp); 
	}
	public function sales($p=0){
		$temp['data']['namepage'] = 'getsales';
		$p  = $this->input->get('page', TRUE);
		
		$temp['data']['fromprice'] = $fromprice  = (int)$this->input->get('min_price', TRUE);
		$temp['data']['toprice'] = $toprice  = (int)$this->input->get('max_price', TRUE);
		$temp['data']['sort'] = $sort  = $this->input->get('sort', TRUE);
		if(empty($sort)) $temp['data']['sort'] = $sort = "sort ASC";
		if(empty($fromprice)) $temp['data']['fromprice'] = $fromprice = 0;
		if(empty($toprice)) $temp['data']['toprice']=$toprice = 1000000000;
		$sort .= ",Id DESC";

		$sql ="SELECT * FROM  mn_product 
			 	 WHERE ticlock = 0  AND trash = 0 AND status = 0 AND price != sale_price AND price != 0
			 	 AND sale_price >=".$fromprice." AND sale_price <=".$toprice." 
			 	 GROUP BY Id
			 	 ORDER BY ".$sort;

		$sql_total = "SELECT COUNT(Id) AS total FROM mn_product
				 WHERE  ticlock =0 AND trash = 0 AND status = 0 AND price != sale_price AND price != 0
				AND sale_price >=".$fromprice." AND sale_price <=".$toprice."
				GROUP BY Id ";

		$numrow = 12;
		$div = 5;
		$skip = $p * $numrow;
		$temp['data']['linkredirect'] = BASE_URL.'dang-khuyen-mai';
		$temp['data']['linked'] =  getLink($temp['data']['linkredirect'],0,$arr_manu,$fromprice,$toprice,$sort,$task = 'link');
		$total= count($this->product_model->get_query($sql_total,0,0));
		$temp['data']['totalItem']= count($this->product_model->get_query($sql_total,0,0));
		$temp['data']['info']= $this->product_model->get_query($sql,$numrow,$skip);
		$temp['data']['page']= $this->page->divPageF($total,$p,$div,$numrow,$temp['data']['linked']."&page=" );
		
		$menus = $this->catelog_model->get_list(array('parentid'=>0),'sort ASC' , 0, 0);
		$temp['data']['title_category'] = 'Danh mục sản phẩm';
		$temp['data']['menu']  = $menus;
		
		$temp['template']='default/product/danh-muc';
		$this->load->view("default/layout",$temp); 	
	}

	public function detail($id){
		//lay thong tin san pham
		$temp['data']['prod'] = $this->product_model->getAlias($id);
		if(empty($temp['data']['prod'])) redirect(base_url('404.html'));
		$temp['data']['namepage'] = 'detail';
		//------------meta--------------------	
		$temp['meta']['title'] = $temp['data']['prod'][0]['meta_title'] != '' ? $temp['data']['prod'][0]['meta_title'] : $temp['data']['prod'][0]['title_vn'];
		$temp['meta']['description'] = $temp['data']['prod'][0]['meta_description'];
		$temp['meta']['keywork'] = $temp['data']['prod'][0]['meta_keyword'];

		//-----------lay cung loại
		$idsub = $this->GetSubCatelogId($idcat);
		if($idsub!=""){
			$where  = "AND ticlock = 0 AND idcat IN (".$idsub.$temp['data']['prod'][0]['idcat'].") AND Id != '".$id."'";
		}else{
			$where  = "AND ticlock = 0 AND idcat= '".$temp['data']['prod'][0]['idcat']."' AND Id != '".$id."'";
		}
		$sql = "SELECT mn_product.*,(SELECT SUM(star)  as total FROM mn_comment WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS star,
		(SELECT COUNT(Id) as total FROM mn_comment WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS countstar FROM  mn_product WHERE trash = 0 ".$where." ORDER BY date DESC";
		$temp['data']['prod_cl']= $this->product_model->get_query($sql,5,0);

		$sql = "SELECT mn_color.* FROM mn_color INNER JOIN pro_color ON mn_color.Id= pro_color.idcolor WHERE pro_color.idpro = ".$temp['data']['prod'][0]['Id']." GROUP BY mn_color.Id";
		$temp['data']['color']= $this->product_model->get_query($sql,1100,0);
		$sql = "SELECT mn_size.* FROM mn_size INNER JOIN pro_size ON mn_size.Id= pro_size.idsize WHERE pro_size.idpro = ".$temp['data']['prod'][0]['Id']." GROUP BY mn_size.Id";
		$temp['data']['size']= $this->product_model->get_query($sql,1100,0);
		if($temp['data']['prod'][0]['idmanufacturer']>0){
			$temp['data']['manu']= $this->manufacturer_model->get_where($temp['data']['prod'][0]['idmanufacturer']);
		}
		$this->product_model->updateView($temp['data']['prod'][0]['Id'], $temp['data']['prod'][0]['view']);

		//------------comment--------------
		$sql = "SELECT *,SUM(star) as star,COUNT(Id) as total FROM mn_comment WHERE ticlock = 0 AND idpro= '".$id."'";
		$temp['data']['dcomment']= $this->comment_model->get_query($sql);

		$temp['data']['info_cat'] = $this->catelog_model->get_where($temp['data']['prod'][0]['idcat']);
		$temp['data']['all_tag']  = $this->catelog_model->list_data(30,0);
		// if($iduser >0){
		// 	$temp['data']['follow'] = $this->page->readFile($iduser.'_'.$temp['data']['prod'][0]["Id"]);  
		// }else{
		// 	$temp['data']['follow'] = 0;
		// }
		//$temp['data']['userId'] = $iduser;
		/*$ship_provinces_id = $this->session->userdata('ship_provinces_id');
		if($ship_provinces_id>0){
			
			$temp['data']['districtOne'] = $this->provinces_model->list_district(array('Id'=>$ship_provinces_id,"ticlock"=>0));
			$temp['data']['provincesOne'] = $this->provinces_model->getdata(array('Id'=>$temp['data']['districtOne'][0]["idcat"]));
			$temp['data']['district'] = $this->provinces_model->list_district(array('idcat'=>$temp['data']['provincesOne'][0]["Id"],"ticlock"=>0));
		}
		$temp['data']['provinces'] = $this->provinces_model->getdata(array('ticlock'=>0));*/
		$temp['template']='default/product/detail';
		$this->load->view("default/layout",$temp); 
	}
	
	public function search(){
		$temp['data']['fromprice'] = $fromprice  = (int)$this->input->get('min_price', TRUE);
		$temp['data']['toprice'] = $toprice  = (int)$this->input->get('max_price', TRUE);
		$temp['data']['sort'] = $sort  = $this->input->get('sort', TRUE);
		if(empty($sort)) $temp['data']['sort'] = $sort = "sort ASC";
		if(empty($fromprice)) $temp['data']['fromprice'] = $fromprice = 0;
		if(empty($toprice)) $temp['data']['toprice']=$toprice = 1000000000;
		$temp['data']['namepage'] = 'search';
		$temp['data']['s'] =$s  = $this->input->get('s', TRUE);
		$catelog  = (int)$this->input->get('catelog', TRUE);
		$temp['data']['sort'] = $sort  = $this->input->get('sort', TRUE);
		$p  = (int)$this->input->get('page', TRUE);
		//$temp['data']['toprice'] = $toprice =  0;
		$sort .= ",Id DESC";
		//--------meta-----------
		//$temp['meta']['description'] = $temp['meta']['title'] = stripcslashes($s).' - Tìm kiếm sản phẩm trên Mada.vn';
		
		$alias = $this->page->strtoseo($s);
		$result = $this->tags_model->get_list(array("title_vn"=>$s,"alias"=>$alias));
		if(!empty($result)){
			$this->tags_model->countview($result[0]['Id']);
		}else{
			$arrw = array(
				"title_vn"=>$s,
				"alias" =>$alias,
				"sort" =>1,
				"ticlock" =>0,
				"views" =>1,
				"date" =>time()
			);
			$result = $this->tags_model->add($arrw);
		}
		//------------------------
		$p = (int)$this->input->get('page', TRUE);
		$numrow = 12;
		$div = 5;
		$skip = $p * $numrow;

		$s = $this->page->escape_str($s);
		$sql = "SELECT mn_product.*,
		 (SELECT SUM(star)  as total FROM mn_comment 
		 WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS star,
		(SELECT COUNT(Id) as total FROM mn_comment
		 WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS countstar
		 FROM mn_product 
		 WHERE   mn_product.title_vn like '%".$s."%'  AND  mn_product.ticlock = 0 AND mn_product.trash= 0 
		 	AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice." 
		 	AND (mn_product.idcat= '".$catelog."' OR ".$catelog."= 0) 
		 GROUP BY mn_product.Id
		 ORDER BY ".$sort;

        $sql_price = "SELECT MAX(mn_product.sale_price) AS price_max, MIN(mn_product.sale_price) AS price_min FROM mn_product  
		WHERE mn_product.title_vn like '%".$s."%' AND   mn_product.ticlock = 0 AND mn_product.trash= 0
			AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice." 
			AND (mn_product.idcat= '".$catelog."' OR ".$catelog."= 0)
		ORDER BY date DESC";
			
		$sql_total = "SELECT COUNT(mn_product.Id) AS total FROM mn_product  
		WHERE mn_product.title_vn like '%".$s."%' AND   mn_product.ticlock = 0 AND mn_product.trash= 0
			AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice." 
			AND (mn_product.idcat= '".$catelog."' OR ".$catelog."= 0)
		ORDER BY date DESC";

		$temp['data']['subcat']= $this->pagehtml_model->get_catelog(0);
		$temp['data']['info']= $this->product_model->get_query($sql,$numrow,$skip);
        $temp['data']['info_price']= $this->product_model->get_query($sql_price,null,null)[0];
		$temp['data']['totalItem'] = $total= count($this->product_model->get_query($sql,0,0));
		$temp['data']['linkredirect'] = BASE_URL."tim-kiem";
		//$temp['data']['linked'] = BASE_URL."tim-kiem?s=".$s."&catelog=".$catelog;
		//$temp['data']['linked'] =  getLink($temp['data']['linkredirect'],0,$arr_manu,$fromprice,$toprice,$sort,$task = 'link');
		
		$params = $this->input->get();
		$params['page'] = '';
		$temp['data']['linked'] = BASE_URL."tim-kiem?".http_build_query($params);
		
		$temp['data']['page']= $this->page->divPageF($total,$p,$div,$numrow,$temp['data']['linked']);
		//$iduser = (int)$this->session->userdata('login_user_id');
		 
		// breadcrumb---------------------------
		$temp['data']['title_category'] = 'Danh mục sản phẩm';
		$temp['data']['menu']  = $this->catelog_model->get_list(array('ticlock'=>'0', 'parentid'=>0), 'sort ASC', 0,0);
		//$temp['data']['menu']  = $this->catelog_model->list_data();
		//$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "#">Tìm kiếm</a>';
		$temp['template']='default/product/danh-muc'; 
			$this->load->view("default/layout",$temp);
	}

	public function catelog($alias, $p=0)
	{
		$temp['data']['cat'] = $info_cat = $this->catelog_model->get_list(array('alias'=>$alias));
		if(!$alias || empty($info_cat)) redirect(base_url('404.html'));
		//--------meta-----------
		$temp['meta']['title'] = $info_cat[0]['title_vn'];
		$temp['meta']['description'] = $info_cat[0]['meta_description'];
		$temp['meta']['keywork'] = $info_cat[0]['meta_keyword'];
		
		$temp['linktag'] = array(array("href " => USER_PATH_CSS."owl.carousel.css","type" => "text/css","rel"=> "stylesheet"),array("href " => USER_PATH_CSS."owl.theme.css","type" => "text/css","rel"=> "stylesheet"),array("href " => USER_PATH_CSS."jquery.slider.min.css","type" => "text/css","rel"=> "stylesheet"));
		$temp['scripttag'] = array(USER_PATH_JS.'owl.carousel.js',USER_PATH_JS.'jshashtable-2.1_src.js',USER_PATH_JS.'jquery.numberformatter-1.2.3.js',USER_PATH_JS.'tmpl.js',USER_PATH_JS.'jquery.dependClass-0.1.js',USER_PATH_JS.'draggable-0.1.js',USER_PATH_JS.'jquery.slider.js');
		//-----------------Fillter-------
		$p  = $this->input->get('page', TRUE);
		$size_select  = $this->input->get('size', TRUE);
		$color_select  = $this->input->get('color', TRUE);
		$manu_select  = $this->input->get('manu', TRUE);
		
		$temp['data']['fromprice'] = $fromprice  = (int)$this->input->get('min', TRUE);
		$temp['data']['toprice'] = $toprice  = (int)$this->input->get('max', TRUE);
		$temp['data']['sort'] = $sort  = $this->input->get('sort', TRUE);
		if(empty($sort)) $temp['data']['sort'] = $sort = "sort ASC";
		if(empty($fromprice)) $temp['data']['fromprice'] = $fromprice = 0;
		if(empty($toprice)) $temp['data']['toprice']=$toprice = 1000000000;
		
		$temp['data']['color_select']  =  $arr_color = GetArr($color_select);
		$temp['data']['size_select']  =  $arr_size = GetArr($size_select);
		$temp['data']['manu_select']  =  $arr_manu = GetArr($manu_select);
		//----------------------------
		$sort .= ",Id DESC";
		$subid =$this->page->getSubCatlogId($info_cat[0]['Id']);
		if($subid != ""){
			$subid = substr($subid,0,-1);
			$sql ="SELECT mn_product.*,
				(SELECT SUM(star)  as total FROM mn_comment WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS star,
				(SELECT COUNT(Id) as total FROM mn_comment WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS countstar
				 FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE mn_product.idcat IN (".$info_cat[0]['Id'].",".$subid.") AND mn_product.ticlock = 0  AND mn_product.trash = 0 
				 AND (pro_color.idcolor IN (".implode(",",$arr_color).") OR ".count($arr_color)."= 1 )
				 AND (pro_size.idsize IN (".implode(",",$arr_size).") OR ".count($arr_size)."= 1 )
				 AND (mn_product.idmanufacturer IN (".implode(',',$arr_manu).") OR ".count($arr_manu)."= 1 )
				 AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice." 
				 AND mn_product.status = 0
				 GROUP BY mn_product.Id
				 ORDER BY ".$sort;	
			$sql_total = "SELECT COUNT(mn_product.Id) AS total FROM  
				mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				WHERE mn_product.idcat IN (".$info_cat[0]['Id'].",".$subid.") AND mn_product.ticlock = 0  AND mn_product.trash = 0 
				 AND (pro_color.idcolor IN (".implode(",",$arr_color).") OR ".count($arr_color)."= 1 )
				 AND (pro_size.idsize IN (".implode(",",$arr_size).") OR ".count($arr_size)."= 1 )
				 AND (mn_product.idmanufacturer IN (".implode(',',$arr_manu).") OR ".count($arr_manu)."= 1 )
				 AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice." 
				 AND mn_product.status = 0
				 GROUP BY mn_product.Id ";
				
			$sql_max_price ="SELECT MAX(mn_product.sale_price) AS pricemax
				 FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE mn_product.idcat IN (".$info_cat[0]['Id'].",".$subid.") and mn_product.ticlock = 0 ";

				 	
			$sql_color = "SELECT mn_color.Id,mn_color.title_vn,mn_color.color 
					FROM mn_color LEFT JOIN pro_color ON mn_color.Id = pro_color.idcolor
					INNER JOIN mn_product ON mn_product.Id = pro_color.idpro 
					 WHERE mn_product.idcat IN (".$info_cat[0]['Id'].",".$subid.") and mn_product.ticlock = 0
					GROUP BY mn_color.Id";	 
			$sql_size = "SELECT mn_size.Id,mn_size.title_vn
					FROM mn_size LEFT JOIN pro_size ON mn_size.Id = pro_size.idsize
					INNER JOIN mn_product ON mn_product.Id = pro_size.idpro 
					 WHERE mn_product.idcat IN (".$info_cat[0]['Id'].",".$subid.") and mn_product.ticlock = 0
					GROUP BY mn_size.Id";
			$sql_manu = "SELECT mn_manufacturer.Id,mn_manufacturer.title_vn
					FROM mn_manufacturer INNER JOIN mn_product ON mn_manufacturer.Id = mn_product.idmanufacturer
					 WHERE mn_product.idcat IN (".$info_cat[0]['Id'].",".$subid.") and mn_product.ticlock = 0
					GROUP BY mn_manufacturer.Id";
		}else{
			$sql ="SELECT mn_product.*, 
					(SELECT SUM(star)  as total FROM mn_comment WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS star,
				(SELECT COUNT(Id) as total FROM mn_comment WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS countstar
				FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE  ticlock =0 and idcat = '".$info_cat[0]['Id']."' AND mn_product.trash = 0 
				 AND (pro_color.idcolor IN (".implode(",",$arr_color).") OR ".count($arr_color)."= 1 )
				 AND (pro_size.idsize IN (".implode(",",$arr_size).") OR ".count($arr_size)."= 1 )
				 AND (mn_product.idmanufacturer IN (".implode(',',$arr_manu).") OR ".count($arr_manu)."= 1 )
				 AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice."  
				  AND mn_product.status = 0 
				  GROUP BY mn_product.Id
				 ORDER BY ".$sort;	
			 
			$sql_total = "SELECT COUNT(mn_product.Id) AS total FROM  
				mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE  ticlock =0 and idcat = '".$info_cat[0]['Id']."' AND mn_product.trash = 0 
				  AND (pro_color.idcolor IN (".implode(",",$arr_color).") OR ".count($arr_color)."= 1 )
				 AND (pro_size.idsize IN (".implode(",",$arr_size).") OR ".count($arr_size)."= 1 )
				 AND (mn_product.idmanufacturer IN (".implode(',',$arr_manu).") OR ".count($arr_manu)."= 1 ) 
				  AND mn_product.status = 0   
				AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice." ";	
			$sql_max_price ="SELECT MAX(mn_product.sale_price) AS pricemax
				FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE  ticlock =0 and idcat = '".$info_cat[0]['Id']."'";
				
			$sql_color = "SELECT mn_color.Id,mn_color.title_vn,mn_color.color 
				FROM mn_color LEFT JOIN pro_color ON mn_color.Id = pro_color.idcolor
				INNER JOIN mn_product ON mn_product.Id = pro_color.idpro 
				 WHERE mn_product.ticlock =0 and mn_product.idcat = '".$info_cat[0]['Id']."'
				GROUP BY mn_color.Id";	 
			$sql_size = "SELECT mn_size.Id,mn_size.title_vn
				FROM mn_size LEFT JOIN pro_size ON mn_size.Id = pro_size.idsize
				INNER JOIN mn_product ON mn_product.Id = pro_size.idpro 
				 WHERE  mn_product.ticlock =0 and mn_product.idcat = '".$info_cat[0]['Id']."'
				GROUP BY mn_size.Id";
			$sql_manu = "SELECT mn_manufacturer.Id,mn_manufacturer.title_vn
					FROM mn_manufacturer INNER JOIN mn_product ON mn_manufacturer.Id = mn_product.idmanufacturer
					WHERE  mn_product.ticlock =0 and mn_product.idcat = '".$info_cat[0]['Id']."'
					GROUP BY mn_manufacturer.Id";
				
		}
		$temp['data']['subcat']   = $this->pagehtml_model->get_catelog($info_cat[0]['Id'],50);
		if(empty($temp['data']['subcat'])){
			$temp['data']['subcat']   = $this->pagehtml_model->get_catelog($info_cat[0]['parentid'],50);
		}
		
		$numrow = 12;
		$div = 5;
		$skip = $p * $numrow;
		
		$temp['data']['linkredirect'] = BASE_URL.$info_cat[0]['alias'];
		$temp['data']['linked'] =  getLink($temp['data']['linkredirect'],0,$arr_color,$arr_size,$arr_manu,$fromprice,$toprice,$sort,$task = 'link');
		
		$temp['data']['linkedsort'] =  getLink($temp['data']['linkredirect'],0,$arr_color,$arr_size,$arr_manu,$fromprice,$toprice,$sort,$task = 'no-sort');
				
		$total= count($this->product_model->get_query($sql_total,0,0));
		
		
		$temp['data']['info']= $this->product_model->get_query($sql,$numrow,$skip);
		$temp['data']['page']= $this->page->divPageF($total,$p,$div,$numrow,$temp['data']['linked']."&page=" );
		$info_max_price =  $this->product_model->get_query($sql_max_price,1,0);
		$temp['data']['toprice'] = $info_max_price[0]['pricemax'];

		if($info_cat[0]['parentid'] >0){
			$subcat = $this->catelog_model->get_where($info_cat[0]['parentid']);
			if($subcat[0]['parentid'] != 0){
				$subcat2 = $this->catelog_model->get_where($subcat[0]['parentid']);
				$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "'.base_url($subcat2[0]['alias']).'" title="'.$subcat2[0]['title_vn'].'">'.$subcat2[0]['title_vn'].'</a>' 
					.$this-> arrowmap . '<a href = "'.base_url($subcat[0]['alias']).'" title="'.$subcat[0]['title_vn'].'">'.$subcat[0]['title_vn'].'</a>'
					.$this->arrowmap . '<a href = "'.base_url($info_cat[0]['alias']).'" title="'.$info_cat[0]['title_vn'].'">'.$info_cat[0]['title_vn'].'</a>';
			}else{
				$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "'.base_url($subcat[0]['alias']).'" title="'.$subcat[0]['title_vn'].'">'.$subcat[0]['title_vn'].'</a>' 
					.$this-> arrowmap . '<a href = "'.base_url($info_cat[0]['alias']).'" title="'.$info_cat[0]['title_vn'].'">'.$info_cat[0]['title_vn'].'</a>'; 
			}
		}else{
			$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "'.base_url($info_cat[0]['alias']).'" title="'.$info_cat[0]['title_vn'].'">'.$info_cat[0]['title_vn'].'</a>';
		}

		if($info_cat['idparent'] == 0) {
			$sql = "idparent=".$info_cat['id'];
		} else {
			$sql = "idparent=".$info_cat['idparent'];
		}
		$menus = $this->catelog_model->list_data($sql);

		$temp['data']['menu'] = $menus;

		$temp['data']['adv'] = $this->pagehtml_model->get_on_list_weblink(array('ticlock'=>0,'parentid'=>$info_cat[0]['Id'],'style'=>2),2);
		$temp['data']['slide'] = $this->pagehtml_model->get_on_list_weblink(array('ticlock'=>0,'parentid'=>$info_cat[0]['Id'],'style'=>3),10);
		$temp['data']['advbottom'] = $this->pagehtml_model->get_on_list_weblink(array('ticlock'=>0,'parentid'=>$info_cat[0]['Id'],'style'=>4),3);
		$temp['data']['advleft'] = $this->pagehtml_model->get_on_list_location(4,10);
		$temp['data']['color'] = $this->product_model->get_query($sql_color,999,0);
		$temp['data']['size'] = $this->product_model->get_query($sql_size,999,0);
		$temp['data']['manu'] = $this->product_model->get_query($sql_manu,999,0);
		if(USERTYPE=='Mobile'){
			$temp['template']='default/product/m_catelog';
			$this->load->view("default/layoutMobile",$temp); 
		}else{
			$temp['template']='default/product/catelog';
			$this->load->view("default/layout",$temp); 
		}
	}

	public function GetSubCatelogId($id){
		$allid="";
		$rows = NULL;
		$rows = $this->catelog_model->get_list(array("ticlock"=>'0',"parentid"=>$id),"Id DESC",100,0);
		if(!empty($rows)){
			foreach($rows as $item)
			{
				$allid .= $item['Id'].",";
				$allid .= $this->GetSubCatelogId($item['Id']);
			}
		}
		
		return $allid;
	}
	public function getformcomment(){
		$login_id = $this->session->userdata('login_id');
		//if($login_id!=1) die('1');
	}
	public function comment(){
		$login_id = $this->session->userdata('login_id');
		$login_user_id = $this->session->userdata('login_user_id');
		$starvalue  = $this->input->post('starvalue');
		$title  = $this->input->post('txt-comment-title');
		$cont  = $this->input->post('txt-comment-content');
		$idpro  = $this->input->post('idpro');
		if($login_id!=1) die(json_encode(array("err"=>true,'mess'=>"Vui lòng đăng nhập để gửi bình luận")));
		if($starvalue <=0) die(json_encode(array("err"=>true,'mess'=>"Đánh giá mức độ hài lòng của bạn với sản phẩm")));
		if($title =="") die(json_encode(array("err"=>true,'mess'=>"Nhập tiêu đề bình luận")));
		if($cont=="") die(json_encode(array("err"=>true,'mess'=>"Nhập nội dung cần bình luận")));
		$arr = array(
			"content"=>$cont,
			"title"=>$title,
			"star"=>$starvalue,
			"ticlock"=>1,
			"idpro"=>$idpro,
			"iduser"=>$login_user_id,
			"date"=>time(),
		);
		$this->comment_model->add($arr);
		die(json_encode(array("err"=>false,'mess'=>"Gửi bình luận về sản phẩm thành công")));
	}
	public function loadcomment($idpro,$p=0){
		$numrow = 5;
		$div = 5;
		$skip = $p * $numrow;
		$sql = "SELECT mn_comment.*,(SELECT fullname FROM mn_user WHERE mn_user.id = mn_comment.iduser ) AS user,
				(SELECT avatar FROM mn_user WHERE mn_user.id = mn_comment.iduser ) AS avatar
				FROM mn_comment WHERE ticlock = 0 AND idpro='".$idpro."' ORDER BY Id DESC LIMIT ".$skip.",".$numrow;
		$temp['comment']= $this->comment_model->get_query($sql);
		$total = $this->comment_model->count_where(array('idpro'=>$idpro,'ticlock'=>0));
		$link = $idpro;
		$temp['page']= $this->page->divPageAjax($total,$p,$div,$numrow,$link);
		$this->load->view("default/product/loadcomment",$temp);
	}
	
	public function sphot($p=0){
		$temp['meta']['title'] = "Sản phẩm khuyến mãi";

		$temp['linktag'] = array(array("href " => USER_PATH_CSS."owl.carousel.css","type" => "text/css","rel"=> "stylesheet"),array("href " => USER_PATH_CSS."owl.theme.css","type" => "text/css","rel"=> "stylesheet"),array("href " => USER_PATH_CSS."jquery.slider.min.css","type" => "text/css","rel"=> "stylesheet"));
		$temp['scripttag'] = array(USER_PATH_JS.'owl.carousel.js',USER_PATH_JS.'jshashtable-2.1_src.js',USER_PATH_JS.'jquery.numberformatter-1.2.3.js',USER_PATH_JS.'tmpl.js',USER_PATH_JS.'jquery.dependClass-0.1.js',USER_PATH_JS.'draggable-0.1.js',USER_PATH_JS.'jquery.slider.js');
		
		$size_select  = $this->input->get('size', TRUE);
		$color_select  = $this->input->get('color', TRUE);
		$temp['data']['fromprice'] = $fromprice  = (int)$this->input->get('min', TRUE);
		$temp['data']['toprice'] = $toprice  = (int)$this->input->get('max', TRUE);
		$manu_select  = $this->input->get('manu', TRUE);
		$temp['data']['sort'] = $sort  = $this->input->get('sort', TRUE);
		$p  = (int)$this->input->get('page', TRUE);
		
		if(empty($sort)) $temp['data']['sort'] = $sort = 'date DESC';
		if(empty($fromprice)) $temp['data']['fromprice'] = $fromprice= 0;
		if(empty($toprice)) $temp['data']['toprice'] = $toprice= 25000000;
		
		$temp['data']['color_select']  =  $arr_color = GetArr($color_select);
		$temp['data']['size_select']  =  $arr_size = GetArr($size_select);
		$temp['data']['manu_select']  =  $arr_manu = GetArr($manu_select);
		
		
		$sort  .= ",Id DESC";
		$numrow = 24;
		$div = 5;
		$skip = $p * $numrow;
		
		$temp['data']['linkredirect'] = BASE_URL."khuyen-mai.html";
		$temp['data']['linked'] =  getLink($temp['data']['linkredirect'],0,$arr_color,$arr_size,$arr_manu,$fromprice,$toprice,$sort,$task = 'link');
		$temp['data']['linkedsort'] =  getLink($temp['data']['linkredirect'],0,$arr_color,$arr_size,$arr_manu,$fromprice,$toprice,$sort,$task = 'notsort');
		
		$sql = "SELECT mn_product.*,
			 	(SELECT SUM(star)  as total FROM mn_comment 
				WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS star,
				(SELECT COUNT(Id) as total FROM mn_comment 
				WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS countstar
				FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE  mn_product.ticlock=0 AND mn_product.trash=0  AND mn_product.hot=1 
				  AND (pro_color.idcolor IN (".implode(",",$arr_color).") OR ".count($arr_color)."= 1 )
				 AND (pro_size.idsize IN (".implode(",",$arr_size).") OR ".count($arr_size)."= 1 )
				 AND (mn_product.idmanufacturer IN (".implode(',',$arr_manu).") OR ".count($arr_manu)."= 1 )
				 AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice."
				 GROUP BY Id
				 ORDER BY ".$sort;
		$sql_total = "SELECT COUNT(mn_product.Id) AS total FROM  
				mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE mn_product.ticlock=0 AND mn_product.trash=0  AND mn_product.hot=1 
				  AND (pro_color.idcolor IN (".implode(",",$arr_color).") OR ".count($arr_color)."= 1 )
				 AND (pro_size.idsize IN (".implode(",",$arr_size).") OR ".count($arr_size)."= 1 )
				 AND (mn_product.idmanufacturer IN (".implode(',',$arr_manu).") OR ".count($arr_manu)."= 1 )
				 AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice." ";
		$temp['data']['info']= $this->product_model->get_query($sql,$numrow,$skip);		 
		$temp['data']['total'] = $total= $this->product_model->count_query($sql_total);
		
		$temp['data']['page']= $this->page->divPageF($total,$p,$div,$numrow,$temp['data']['linked']."&page=");
		$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "/khuyen-mai.html">Sản phẩm khuyến mãi</a>';
		
		$sql = "SELECT mn_color.Id,mn_color.title_vn,mn_color.color 
				FROM mn_color LEFT JOIN pro_color ON mn_color.Id = pro_color.idcolor
				INNER JOIN mn_product ON mn_product.Id = pro_color.idpro 
				 WHERE mn_product.ticlock=0 AND mn_product.trash= 0  AND mn_product.hot=1 
				GROUP BY mn_color.Id";	 
		$temp['data']['color'] = $this->product_model->get_query($sql,999,0);	
		$sql = "SELECT mn_size.Id,mn_size.title_vn
				FROM mn_size LEFT JOIN pro_size ON mn_size.Id = pro_size.idsize
				INNER JOIN mn_product ON mn_product.Id = pro_size.idpro 
				 WHERE mn_product.ticlock=0 AND mn_product.trash= 0  AND mn_product.hot=1 
				GROUP BY mn_size.Id";
		$sql_manu = "SELECT mn_manufacturer.Id,mn_manufacturer.title_vn
					FROM mn_manufacturer INNER JOIN mn_product ON mn_manufacturer.Id = mn_product.idmanufacturer
					 WHERE mn_product.ticlock=0 AND mn_product.trash= 0  AND mn_product.hot=1 
					GROUP BY mn_manufacturer.Id";
		$sql_max_price ="SELECT MAX(mn_product.sale_price) AS pricemax
				 FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE mn_product.hot = 1 AND mn_product.ticlock = 0 ";
		$info_max_price =  $this->product_model->get_query($sql_max_price,1,0);
		$temp['data']['toprice'] = $info_max_price[0]['pricemax'];
		$temp['data']['manu'] = $this->product_model->get_query($sql_manu,999,0);
		$temp['data']['size'] = $this->product_model->get_query($sql,999,0);	
		$temp['data']['subcat']= $this->pagehtml_model->get_catelog(0);
		
		$temp['template']='default/product_bk/hot';
			$this->load->view("default/layout",$temp);
	}

	public function order($p=0){
		$temp['meta']['title'] = "Sản phẩm bán chạy";

		$temp['linktag'] = array(array("href " => USER_PATH_CSS."owl.carousel.css","type" => "text/css","rel"=> "stylesheet"),array("href " => USER_PATH_CSS."owl.theme.css","type" => "text/css","rel"=> "stylesheet"),array("href " => USER_PATH_CSS."jquery.slider.min.css","type" => "text/css","rel"=> "stylesheet"));
		$temp['scripttag'] = array(USER_PATH_JS.'owl.carousel.js',USER_PATH_JS.'jshashtable-2.1_src.js',USER_PATH_JS.'jquery.numberformatter-1.2.3.js',USER_PATH_JS.'tmpl.js',USER_PATH_JS.'jquery.dependClass-0.1.js',USER_PATH_JS.'draggable-0.1.js',USER_PATH_JS.'jquery.slider.js');
		
		$size_select  = $this->input->get('size', TRUE);
		$color_select  = $this->input->get('color', TRUE);
		$temp['data']['fromprice'] = $fromprice  = (int)$this->input->get('min', TRUE);
		$temp['data']['toprice'] = $toprice  = (int)$this->input->get('max', TRUE);
		$manu_select  = $this->input->get('manu', TRUE);
		$temp['data']['sort'] = $sort  = $this->input->get('sort', TRUE);
		$p  = (int)$this->input->get('page', TRUE);
		
		if(empty($sort)) $temp['data']['sort'] = $sort = 'id DESC';
		if(empty($fromprice)) $temp['data']['fromprice'] = $fromprice= 0;
		if(empty($toprice)) $temp['data']['toprice'] = $toprice= 25000000;
		
		$temp['data']['color_select']  =  $arr_color = GetArr($color_select);
		$temp['data']['size_select']  =  $arr_size = GetArr($size_select);
		$temp['data']['manu_select']  =  $arr_manu = GetArr($manu_select);
		
		
		$numrow = 24;
		$div = 5;
		$skip = $p * $numrow;
		$sql = "SELECT mn_product.*,
			 (SELECT SUM(star)  as total FROM mn_comment WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS star,
				
			(SELECT COUNT(Id) as total FROM mn_comment WHERE ticlock = 0 AND mn_comment.idpro= mn_product.Id) AS countstar
				 FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE  mn_product.ticlock=0 AND mn_product.trash=0  
				 AND (pro_color.idcolor IN (".implode(",",$arr_color).") OR ".count($arr_color)."= 1 )
				 AND (pro_size.idsize IN (".implode(",",$arr_size).") OR ".count($arr_size)."= 1 )
				 AND (mn_product.idmanufacturer IN (".implode(',',$arr_manu).") OR ".count($arr_manu)."= 1 )
				 AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice."
				 GROUP BY Id
				 ORDER BY ".$sort;
		$sql_total = "SELECT COUNT(mn_product.Id) AS total FROM  
				mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE mn_product.ticlock=0 AND mn_product.trash=0  
				 AND (pro_color.idcolor IN (".implode(",",$arr_color).") OR ".count($arr_color)."= 1 )
				 AND (pro_size.idsize IN (".implode(",",$arr_size).") OR ".count($arr_size)."= 1 )
				 AND (mn_product.idmanufacturer IN (".implode(',',$arr_manu).") OR ".count($arr_manu)."= 1 )
				 AND mn_product.sale_price >=".$fromprice." AND mn_product.sale_price <=".$toprice." ";
		$sql_max_price ="SELECT MAX(mn_product.sale_price) AS pricemax
				 FROM  mn_product LEFT JOIN pro_color ON mn_product.Id = pro_color.idpro
				 LEFT JOIN pro_size ON mn_product.Id = pro_size.idpro
				 WHERE mn_product.trash = 0 AND mn_product.ticlock = 0 
				  AND (pro_color.idcolor IN (".implode(",",$arr_color).") OR ".count($arr_color)."= 1 )
				 AND (pro_size.idsize IN (".implode(",",$arr_size).") OR ".count($arr_size)."= 1 )
				 AND (mn_product.idmanufacturer IN (".implode(',',$arr_manu).") OR ".count($arr_manu)."= 1 )";
		$temp['data']['info']= $this->product_model->get_query($sql,$numrow,$skip);		 
		$temp['data']['total'] = $total= $this->product_model->count_query($sql_total);
		
		$info_max_price =  $this->product_model->get_query($sql_max_price,1,0);
		$temp['data']['toprice'] = $info_max_price[0]['pricemax'];
		
		$temp['data']['linkredirect'] = BASE_URL."ban-chay.html";
		$temp['data']['linked'] =  getLink($temp['data']['linkredirect'],0,$arr_color,$arr_size,$arr_manu,$fromprice,$toprice,$sort,$task = 'link');
		$temp['data']['linkedsort'] =  getLink($temp['data']['linkredirect'],0,$arr_color,$arr_size,$arr_manu,$fromprice,$toprice,$sort,$task = 'notsort');
		
		$temp['data']['page']= $this->page->divPageF($total,$p,$div,$numrow,$temp['data']['linked']."&page=");
		$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "/ban-chay.html">Sản phẩm bán chạy</a>';
		$sql = "SELECT mn_color.Id,mn_color.title_vn,mn_color.color 
				FROM mn_color LEFT JOIN pro_color ON mn_color.Id = pro_color.idcolor
				INNER JOIN mn_product ON mn_product.Id = pro_color.idpro 
				 WHERE mn_product.ticlock=0 AND mn_product.trash= 0  
				GROUP BY mn_color.Id";	 
		$temp['data']['color'] = $this->product_model->get_query($sql,999,0);	
		$sql = "SELECT mn_size.Id,mn_size.title_vn
				FROM mn_size LEFT JOIN pro_size ON mn_size.Id = pro_size.idsize
				INNER JOIN mn_product ON mn_product.Id = pro_size.idpro 
				 WHERE mn_product.ticlock=0 AND mn_product.trash= 0 
				GROUP BY mn_size.Id";
		$sql_manu = "SELECT mn_manufacturer.Id,mn_manufacturer.title_vn
					FROM mn_manufacturer INNER JOIN mn_product ON mn_manufacturer.Id = mn_product.idmanufacturer
					 WHERE mn_product.ticlock=0 AND mn_product.trash= 0 
					GROUP BY mn_manufacturer.Id";
		$temp['data']['manu'] = $this->product_model->get_query($sql_manu,999,0);
		$temp['data']['size'] = $this->product_model->get_query($sql,999,0);	
		$temp['data']['subcat']= $this->pagehtml_model->get_catelog(0);
		$temp['data']['linked']  = base_url('ban-chay.html?size='.$size_select."&color=".$color_select."&min=".$fromprice."&max=".$toprice."&manu=".$manu_select."");
		if(USERTYPE=='Mobile'){
			$temp['template']='default/product/m_order';
			$this->load->view("default/layoutMobile",$temp); 
			
		}else{
			$temp['template']='default/product/order';
			$this->load->view("default/layout",$temp);
		}
	}
}
