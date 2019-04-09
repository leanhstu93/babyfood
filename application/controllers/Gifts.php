<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gifts extends CI_Controller {
	
	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('provinces_model');
		 $this->load->model('user_model');
		 $this->load->model('product_model');
		 $this->load->model('flash_model');
		 $this->load->model('gifts_model');
		 $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
	
	public function auto(){
		 
		for($i=0; $i<5000; $i++){
			
			var_dump($this->receiving());	
		}	
	}
	
	
	
	public function receiving(){
		
		//if(!$this->input->is_ajax_request()) echo 'No direct script access allowed'; die();
		
		$userid = $this->session->userdata('login_user_id');
		if(isset($userid) && is_numeric($userid) && $userid >0){
				
			$array_gifts = array('1' => 2, '2' => 2, '3' => 5, '4' => 2, '5' => 100, '6' => 400);
			
			$start_day = strtotime(date('Y-m-d 00:00:00', time()));
			$end_day = strtotime('+5 day 23:59:59');
			$data = array(
				'id_user' => $userid,
				'status' => 1,
				'start_day' => '',
				'end_day' 	=> '',
				'created' => time()
			);
			
			$choise = $this->random_probability($array_gifts);
			if($choise && $choise!=6){
				$gift = $this->gifts_model->get_by_type($choise);
				if( $gift >= $array_gifts[$choise]){
					$choise = 6;
				}
			}else{
				$choise = 6;	
			}
			if($choise != 6){
				$data['type'] = $choise;
			} else {
				$data['type'] = 6;
			}	
			$id_user_gift = $this->gifts_model->add($data);
			$r_gift = $this->gifts_model->gift($id_user_gift);
			if(isset($r_gift) && $r_gift!=''){
				switch ($r_gift) {
				case $r_gift['type']==1:
					echo json_encode(array('type' => 1, 'msg'=>'Bạn đã trúng được camera hành trình SJCAM 4000 Wifi Full HD'));
					break;
				case $r_gift['type']==2:
					echo json_encode(array('type' => 1, 'msg'=>'Bạn đã trúng được cây son TomFord'));
					break;
				case $r_gift['type']==3:
					echo json_encode(array('type' => 1, 'msg'=>'Bạn đã trúng được điện thoại Nokia 105'));
					break;
				case $r_gift['type']==4:
					echo json_encode(array('type' => 1, 'msg'=>'Bạn đã trúng được 1 vé Buffet Hana BBQ'));
					break;
				case $r_gift['type']==5:
					echo json_encode(array('type' => 1, 'msg'=>'Bạn đã trúng được thẻ cào điện thoại mobile 20k'));
					break;
				case $r_gift['type']==6:
					echo json_encode(array('type' => 1, 'msg'=>'Chúc bạn mai mắn lần sau!'));
					break;
				}						
			
			}				
		}
		
	}
	
    function random_probability($probabilities) {
      $rand = rand(0, array_sum($probabilities));
      do {
        $sum = array_sum($probabilities);
        if($rand <= $sum && $rand >= $sum - end($probabilities)) {
          return key($probabilities);
        }
      } while(array_pop($probabilities));
    }
	
	
	
}
