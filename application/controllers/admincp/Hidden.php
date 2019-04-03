<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hidden extends CI_Controller  {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->helper('url');
		 $controller = $this->router->fetch_class();
		 $act = $this->router->fetch_method();
		 $this->permission->checkAdmin($controller,$act);
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
	public function ticlock()
	{
		if(!$this->input->is_ajax_request())  die("No access");
		//$this->cache->clean();
		$table = $this->uri->segment(4);
		$colum = $this->uri->segment(5);
		$id = $this->uri->segment(6);
		$value = $this->uri->segment(7);
		$arrParam['ticlock'] = $value; 
		$this->load->model($table);
		$this->$table->Update($id,$arrParam);
		if($value == 1){
			echo '<div id = "'.$id.'"><a href = "javascript:ticlockactive(\''.$table.'\',\'ticlock\','.$id.',\'0\');" title = "Bỏ khóa"><img src = "'.ADMIN_PATH_IMG.'icon-16-remove.png"></a></div>';
		}else{
			echo '<div id = "'.$id.'"><a href = "javascript:ticlockactive(\''.$table.'\',\'ticlock\','.$id.',\'1\');" title = "Khóa tin"><img src = "'.ADMIN_PATH_IMG.'icon-16-tick.png"></a></div>';
		}
	}
	public function active()
	{
		//$this->cache->clean();
		$table = $this->uri->segment(4);
		$colum = $this->uri->segment(5);
		$id = $this->uri->segment(6);
		$value = $this->uri->segment(7);
		$iddiv = $this->uri->segment(8);
		$arrParam[$colum] = $value; 
		$this->load->model($table);
		$this->$table->update($id,$arrParam);
		if($value == 1){
			echo '<div id = "'.$iddiv.'"><a href = "javascript:hideshow(\''.$table.'\',\''.$colum.'\',\''.$id.'\',\'0\',\''.$iddiv.'\');" title = "Bật"><img src = "'.ADMIN_PATH_IMG.'icon-16-default.png"></a></div>';
			}else{
				echo '<div id = "'.$iddiv.'"><a href = "javascript:hideshow(\''.$table.'\',\''.$colum.'\',\''.$id.'\',\'1\',\''.$iddiv.'\');" title = "Tắt"><img src = "'.ADMIN_PATH_IMG.'icon-16-nondefault.png"></a></div>';	
		}
	}
	
	public function delflash()
	{
		$table = $this->uri->segment(4);
		$colum = $this->uri->segment(5);
		$id = $this->uri->segment(6);
		$value = $this->uri->segment(7);
		$arrParam[$colum] = ""; 
		$this->load->model($table);
		if($table=='product_model') $info = $this->$table->get_Id($id);
		else $info = $this->$table->get_where($id);
		$this->$table->update($id,$arrParam);
		
		switch($table){ //kiem tra update thuoc bang nao
			case 'product_model':			 $dir = 'Product'; break;
			case 'flash_model':			 $dir = 'Flash'; break;
			case 'bmenu_model':			 $dir = 'Banner'; break;
			case 'weblink_model':			 $dir = 'Banner'; break;
		}
		if(file_exists('./data/'.$dir.'/'.$info[0][$colum]))
			unlink('./data/'.$dir.'/'.$info[0][$colum]);
		echo "Xóa thành công";
		die;
	}
}
