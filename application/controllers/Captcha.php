<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {
	
	public function __construct()
	{
		 parent::__construct();
		$this->load->helper('captcha');
	}
	
	public function created(){
				
		$original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $captcha = substr(str_shuffle($original_string), 0, 6);
		
		$vals = array(
        'word'          => $captcha,
        'img_path'      => './data/Captcha/',
        'img_url'       => base_url().'data/Captcha',
        'font_path'     => '',
        'img_width'     => '100',
        'img_height'    => 32,
        'expiration'    => 7200,
        'word_length'   => '',
        'font_size'     => 16,
        'img_id'        => 'Imageid',
        'pool'          => '',
        'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(4, 0, 0),
                'grid' => array(255, 225, 255, 255)
       		 )
		);
	
	
	$cap = create_captcha($vals);
	
	//if(file_exists(BASEPATH."./public/Captcha/".$this->session->userdata['image']))
         //  unlink(BASEPATH."./public/Captcha/".$this->session->userdata['image']);

    $this->session->set_userdata(array('captcha'=>$captcha, 'image' => $cap['time'].'.jpg'));
    echo $cap['image'];  

	}
	
	
}
