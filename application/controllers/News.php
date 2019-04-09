<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {
	protected $arrowmap = " > ";
	protected $map_title = '<a href="/">Trang chủ</a>';
	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('catnews_model');
		 $this->load->model('news_model');
		 $this->load->model('catelog_model');
		 $this->load->model('flash_model');
		 $this->load->model('tags_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
	public function detail($alias){
		$temp['data']['idcat'] = 0;
		$temp['data']['info'] = $info = $this->news_model->get_list(array('alias'=>$alias));
		
		if(!$alias || empty($info)) redirect(base_url('404.html'));
		$temp['meta']['title'] = $info[0]['meta_title'] != '' ? $info[0]['meta_title'] : $info[0]['title_vn'];
		$temp['meta']['description'] = $info[0]['meta_description'];
		$temp['meta']['keywork'] = $info[0]['meta_keyword'];
		
		$this->pagehtml_model->update_news_view($temp['data']['info'][0]);
		$temp['data']['cat'] = $this->catnews_model->get_where($info[0]['idcat']);
		//$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap . '<a href = "'.base_url('bai-viet/'.$info[0]['alias']).'" >'.base_url('bai-viet/').'</a>';
		$temp['data']['baiviet'] = $this->pagehtml_model->get_newsidcat(10,10,0);
		$temp['data']['mostviews'] = $this->pagehtml_model->get_news_most_view(10);
		$temp['template']='default/news/detail';
		$temp['data']['all_tag'] = $this->catelog_model->list_data(null,null);
		$this->load->view("default/layout",$temp); 
	}
	public function catelog($alias,$p=0){
		$info_cat = $this->catnews_model->get_list(array('alias'=>$alias));
		// $temp['meta']['title'] = $info_cat[0]['title_vn'];
		// $temp['meta']['description'] = $info_cat[0]['meta_description'];
		// $temp['meta']['keywork'] = $info_cat[0]['meta_keyword'];
		
		$config['base_url']	=	base_url('chu-de/'.$info_cat[0]['alias']);
		
		$config['total_rows'] = $this->news_model->count_where(array("ticlock"=>0,"idcat"=>$info_cat[0]['Id']));
		$config['per_page']	= 5;
		$config['num_links'] = 5;
		
		$this->pagination->initialize($config);
		$temp['data']['info'] = $this->news_model->get_list(array("ticlock"=>0,"idcat"=>$info_cat[0]['Id']),"sort DESC, Id DESC",$config['per_page'],$p);
		
		$temp['data']['baiviet'] = $this->pagehtml_model->get_newsidcat(10,10,0);
		
		$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap."<a href='".base_url("chu-de/".$info_cat['0']['alias'])."'>".$info_cat[0]['title_vn']."</a>";
		
		$temp['data']['all_tag']  = $this->catelog_model->list_data();
		$temp['template']='default/news/news'; 

		$this->load->view("default/layout",$temp); 
		
	}

	public function search($p=0){
		// $temp['meta']['title'] = $info_cat[0]['title_vn'];
		// $temp['meta']['description'] = $info_cat[0]['meta_description'];
		// $temp['meta']['keywork'] = $info_cat[0]['meta_keyword'];
		$s = $this->input->get('s');
		$config['base_url']	=	base_url('bai-viet/search');
		
		$sql = "SELECT COUNT(Id) AS total FROM `mn_news` WHERE `title_vn` LIKE '%".$s."%' OR `tag` LIKE '%".$s."%' OR `content_vn` LIKE '%".$s."%'";
		$tatal = $this->news_model->get_query($sql);

		$config['total_rows'] = $total[0]['total'];
		$config['per_page']	= 5;
		$config['num_links'] = 5;
		
		$this->pagination->initialize($config);
		$sql = "SELECT * FROM `mn_news` WHERE `title_vn` LIKE '%".$s."%' OR `tag` LIKE '%".$s."%' OR `content_vn` LIKE '%".$s."%'";
		$temp['data']['info'] = $this->news_model->get_query($sql, $config['per_page'], $p);
		
		$temp['data']['baiviet'] = $this->pagehtml_model->get_newsidcat(10,10,0);
		
		$temp['data']['breadcrumb'] =  $this->map_title .$this-> arrowmap."<a href='".base_url("chu-de/".$info_cat['0']['alias'])."'>".$info_cat[0]['title_vn']."</a>";
		
		$temp['data']['all_tag']  = $this->catelog_model->list_data();
		$temp['template']='default/news/news'; 

		$this->load->view("default/layout",$temp); 
		
	}

	public function GetSubCatelogId($id){
		$allid="";
		$rows = NULL;
		$rows = $this->catelog_model->get_list(array("ticlock"=>0,"parentid"=>$id),"Id DESC",100,0);
		if(!empty($rows)){
			foreach($rows as $item)
			{
				$allid .= $item['Id'].",";
				$allid .= $this->GetSubCatelogId($item['Id']);
			}
		}
		
		return $allid;
	}
}
