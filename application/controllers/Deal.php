<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deal extends CI_Controller {
	protected $arrowmap = " > ";
	protected $map_title = '<a href="/">Trang chủ</a> > <a href="/deal-hom-nay.html">Deal Mada</a>';
	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('catdeal_model');
		 $this->load->model('flash_model');
		 $this->load->model('user_model');
		 $this->load->model('tags_model');
		 $this->load->model('deal_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
	public function catelog($alias,$p=0)
	{
		
		$temp['data']['cat'] = $info_cat = $this->catdeal_model->get_list(array('alias'=>$alias));
		if(!$alias || empty($info_cat)) redirect(base_url('404.html'));
		//--------meta-----------
		$temp['meta']['title'] = $info_cat[0]['title_vn'];
		$temp['meta']['description'] = $info_cat[0]['meta_description'];
		$temp['meta']['keywork'] = $info_cat[0]['meta_keyword'];
		//----------------------------
		$subid =$this->page->getSubCatDealId($info_cat[0]['Id']);
		if($subid != ""){
			$subid = substr($subid,0,-1);
			$sql ="SELECT mn_deal.* FROM  mn_deal 
				 WHERE mn_deal.idcat IN (".$info_cat[0]['Id'].",".$subid.") and mn_deal.ticlock = 0 
				 ORDER BY sort ASC,Id DESC";	
			$sql_total = "SELECT COUNT(mn_deal.Id) AS total FROM  mn_deal 
				WHERE mn_deal.idcat IN (".$info_cat[0]['Id'].",".$subid.") and mn_deal.ticlock = 0 ";	
		
		}else{
			$sql ="SELECT mn_deal.* FROM  mn_deal 
				 WHERE  ticlock = 0 and idcat = '".$info_cat[0]['Id']."'
				 ORDER BY sort ASC,Id DESC";	
			$sql_total = "SELECT COUNT(mn_deal.Id) AS total FROM  mn_deal 
				 WHERE  ticlock =0 and idcat = '".$info_cat[0]['Id']."'";
		}
		$temp['data']['subcat']   = $this->pagehtml_model->get_catdeal($info_cat[0]['Id'],50);
		
		$numrow = 12;
		$div = 5;
		$skip = $p * $numrow;
		$link = BASE_URL."deal/".$alias."/";
				
		$total= $this->deal_model->count_query($sql_total);
		
		$temp['data']['info']= $this->deal_model->get_query($sql,$numrow,$skip);
		$temp['data']['page']= $this->page->divPageF($total,$p,$div,$numrow,$link);


		if($info_cat[0]['parentid'] >0){
			$subcat = $this->catdeal_model->get_where($info_cat[0]['parentid']);
			if($subcat[0]['parentid'] != 0){
				$subcat2 = $this->catdeal_model->get_where($subcat[0]['parentid']);
				$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "'.base_url("deal/".$subcat2[0]['alias']).'" title="'.$subcat2[0]['title_vn'].'">'.$subcat2[0]['title_vn'].'</a>' 
					.$this-> arrowmap . '<a href = "'.base_url("deal/".$subcat[0]['alias']).'" title="'.$subcat[0]['title_vn'].'">'.$subcat[0]['title_vn'].'</a>'
					.$this->arrowmap . '<a href = "'.base_url($info_cat[0]['alias']).'" title="'.$info_cat[0]['title_vn'].'">'.$info_cat[0]['title_vn'].'</a>';
			}else{
				$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "'.base_url("deal/".$subcat[0]['alias']).'" title="'.$subcat[0]['title_vn'].'">'.$subcat[0]['title_vn'].'</a>' 
					.$this-> arrowmap . '<a href = "'.base_url("deal/".$info_cat[0]['alias']).'" title="'.$info_cat[0]['title_vn'].'">'.$info_cat[0]['title_vn'].'</a>'; 
			}
		}else{
			$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "'.base_url("deal/".$info_cat[0]['alias']).'" title="'.$info_cat[0]['title_vn'].'">'.$info_cat[0]['title_vn'].'</a>';
		}
		
		if(USERTYPE=='Mobile'){
			$temp['template']='default/deal/m_catelog';
			$this->load->view("default/layoutMobile",$temp); 
		}else{
			$temp['template']='default/deal/catelog';
			$this->load->view("default/layout",$temp);
		}
	}
	public function detail($id){
		$iduser = (int)$this->session->userdata('login_user_id');
		$temp['data']['prod'] = $this->deal_model->get_Id($id);
		//if(empty($temp['data']['prod'])) redirect(base_url('404.html'));

		//------------meta--------------------	
		$temp['meta']['title'] = $temp['data']['prod'][0]['title_vn'];
		if($temp['data']['prod'][0]['meta_description']=="" )
		$temp['meta']['description'] = $this->page->limit_text($temp['data']['prod'][0]['description_vn'],200);
		else $temp['meta']['description'] =$temp['data']['prod'][0]['meta_description'];
		$temp['meta']['keywork'] =$temp['data']['prod'][0]['meta_keyword'];
		//-----------------
		$temp['scripttag'] = array(USER_PATH_JS.'owl.carousel.js');
		
		
			$this->deal_model->countview($id);
			
			$idcat = $temp['data']['prod'][0]['idcat'];
			if((int)$idcat>0):
				$info_cat = $this->catdeal_model->get_where($idcat);
				if($info_cat[0]['parentid'] !=0){
					$subcat = $this->catdeal_model->get_where($info_cat[0]['parentid']);
					if($subcat[0]['parentid'] != 0){
						$subcat2 = $this->catdeal_model->get_where($subcat[0]['parentid']);
						$temp['data']['breadcrumb']  =  $this->map_title.$this->arrowmap.'<a href = "/deal/'.$subcat2[0]['alias'].'" title="'.$subcat2[0]['title_vn'].'">'.$subcat2[0]['title_vn'].'</a>' 
							. $this->arrowmap . '<a href = "'.base_url("deal/".$subcat[0]['alias']).'" title="'.$subcat[0]['title_vn'].'">'.$subcat[0]['title_vn'].'</a>'
							. $this->arrowmap . '<a href = "'.base_url("deal/".$info_cat[0]['alias']).'.html" title="'.$info_cat[0]['title_vn'].'">'.$info_cat[0]['title_vn'].'</a>';
					}else{
						$temp['data']['breadcrumb'] =  $this->map_title.$this->arrowmap . '<a href = "'.base_url($subcat[0]['alias']).'" title="'.$subcat[0]['title_vn'].'">'.$subcat[0]['title_vn'].'</a>' 
							. $this->arrowmap . '<a href = "'.base_url("deal/".$info_cat[0]['alias']).'" title="'.$info_cat[0]['title_vn'].'">'.$info_cat[0]['title_vn'].'</a>';
					}
				}else{
					$temp['data']['breadcrumb'] =  $this->map_title . $this->arrowmap . '<a href = "'.base_url('deal/'.$info_cat[0]['alias']).'" title="'.$info_cat[0]['title_vn'].'">'.$info_cat[0]['title_vn'].'</a>';
				}
				//-----------lay cung loại
				$idsub = $this->page->getSubCatDealId($idcat);
				if($idsub!=""){
					$where  = "AND ticlock = 0 AND idcat IN (".$idsub.$temp['data']['prod'][0]['idcat'].") AND Id != '".$id."'";
				}else{
					$where  = "AND ticlock = 0 AND idcat= '".$temp['data']['prod'][0]['idcat']."' AND Id != '".$id."'";
				}
				$sql = "SELECT * FROM  mn_deal WHERE trash = 0 ".$where." ORDER BY date DESC";
				$temp['data']['prod_cl']= $this->deal_model->get_query($sql,5,0);
				
			endif; 
		if(USERTYPE=='Mobile'){
			$temp['template']='default/deal/m_detail';
			$this->load->view("default/layoutMobile",$temp); 
		}else{
			$temp['template']='default/deal/detail'; 
			$this->load->view("default/layout",$temp); 
		}
	}
	
	public function hot($p=0){
		$temp['meta']['title'] = "Deal hôm nay ";
		$numrow = 12;
		$div = 5;
		$skip = $p * $numrow;
		$link = base_url('hot-deal')."/";
		
		$sql = "SELECT mn_deal.*  FROM  mn_deal 
				 WHERE  mn_deal.ticlock=0 AND mn_deal.trash=0 
				 ORDER BY date DESC, Id DESC";
		$sql_total = "SELECT COUNT(mn_deal.Id) AS total FROM  mn_deal 
				 WHERE mn_deal.ticlock=0 AND mn_deal.trash=0   ";
		$temp['data']['info']= $this->deal_model->get_query($sql,$numrow,$skip);		 
		$temp['data']['total'] = $total= $this->deal_model->count_query($sql_total);
		
		$temp['data']['page']= $this->page->divPageF($total,$p,$div,$numrow,$link);
		$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "/hot-deal">Deal hôm nay</a>';
		if(USERTYPE=='Mobile'){
			$temp['template']='default/deal/m_hot';
			$this->load->view("default/layoutMobile",$temp); 
		}else{
			$temp['template']='default/deal/hot';
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
	public function getreson(){
		
	}
}
