<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrawlerSite extends CI_Controller {
    
    public $title = 'Crawler Tool';
    private $_controller = 'crawlersite';
    private $_limit_image = 1;
    
    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'product_model'
        ));
        $this->load->library(array(
            'pagination', 
            'simplecrawler'
        ));
        $this->load->database();
        $this->load->helper(array('url','utf8', 'email', 'htmlpurifier', 'form'));
        $this->data = array();
		$this->load->model('catelog_model');
    }

    public function updateCode() {
        $this->load->database();
        $handle = fopen('./code.txt', 'r');
        $count = 0;
        if($handle) {
            while(($line = fgets($handle)) !== false) {
                $temp = explode("|", $line);
                $codepro = str_replace('Mã SP:', '', $temp[1]);
                $this->db->where('alias', trim($temp[0]))->update('mn_product', array('codepro' => trim($codepro)));
                if($this->db->affected_rows()) $count++;
            }
        }
        echo 'Updated ' . $count;
    }

    function getCode($start=0) {
        $this->load->database();
        $file = './code.txt';
        $products = file_get_contents('./products_'.$start.'.json');
        if(!empty($products)) {
            $products = json_decode($products);
            $products = (array)$products;
        } else {
            $products = $this->db->select('alias')->from('mn_product')->limit(100, $start)->get()->result_array();
            
            file_put_contents('./products_'.$start.'.json', json_encode($products));
        }
        
        foreach($products as $product) {
            $product = (array)$product;
            $link = 'https://babyfood.com.vn/'.$product['alias'].'.html';
            
            $data = $this->dlPage($link);
            if(!empty($data)) {
                $find_code = $data->find('.product-mpn > p', 0);
                if(!empty($find_code)) {
                    $code = $find_code->plaintext;
                    file_put_contents($file, $product['alias'].'|'.$code."\n", FILE_APPEND);
                }
            }
        }
    }
    
    function index() {
        $this->data['heading_title'] = $this->title;
        $this->data['results'] = '';
        $this->data['url'] = '';
        $this->data['site'] = '';
        if($post = $this->input->post()) {
            $this->data['url'] = $post['url'];
            $this->data['site'] = $post['site'];
            $data = $this->simplecrawler->http_request($this->input->post('url'));
            $links = $this->simplecrawler->extract_elements('a', $data);
			//$links = iconv("CP1257","UTF-8", $links);
			//print_r($links);
            if ( count($links) > 0 ) {
               
                $filename = "json/".$post['site']."_file_".time().".json";
                
                file_put_contents(FCPATH . '/'.$filename, json_encode($links, JSON_PRETTY_PRINT));
                
                $links = file_get_contents(FCPATH . '/'.$filename);
                
                $results = json_decode($links);
                $array_links = array();
                
                if($post['site'] == 'babyfood.com.vn') {
                    foreach($results as $item) {
                        $attr = $item->attributes;
                        $href = $attr->href;
                        $class = isset($attr->class) ? $attr->class : '';
                        //if($class == 'post-link')
                        if(strpos($href, ".html") != false) {
							if(strpos($href, "babyfood.com.vn") === false) {
								$array_links[] = "https://babyfood.com.vn/".$href;
							} else {
								$array_links[] = $href;
							}
						}
                                
                    }
                }
                
                $this->data['results'] = implode("\n", $array_links);
            }
        }
		$this->data['listcat']= $this->catelog_model->get_list(array('ticlock'=>0),'sort ASC, Id DESC',500,0); 
        $this->load->view('admincp/crawler/view', $this->data);
    }
    
    function import() {
        $post = $this->input->post();
        if(isset($post['sitename']) && $post['sitename'] == 'babyfood.com.vn') {
            $this->import_babyfoot($post['url'], $post['category_id']);
        }
    }
    
    function SpinContent() {
        $array = array();
        $hanld = fopen(FCPATH . "/spin.txt", "r");
        while($line = fgets($hanld) !== false) {
            $str = explode("|", $line);
            if(isset($str[0]) && isset($str[1])) {
                $array[trim($str[0])] = trim($str[1]);
            }
        }
        return $array;
    }
	
	function importNews() {
		$data = $this->simplecrawler->http_request('https://babyfood.com.vn/tin-tuc/');
            $links = $this->simplecrawler->extract_elements('a', $data);
			//$links = iconv("CP1257","UTF-8", $links);
			//print_r($links);
            if ( count($links) > 0 ) {
				
				$filename = "json/news_".time().".json";
				
				file_put_contents(FCPATH . '/'.$filename, json_encode($links, JSON_PRETTY_PRINT));
                
                $links = file_get_contents(FCPATH . '/'.$filename);
                
                $results = json_decode($links);
                $array_links = array();
                
                if($post['site'] == 'babyfood.com.vn') {
                    foreach($results as $item) {
                        $attr = $item->attributes;
                        $href = $attr->href;
                        $class = isset($attr->class) ? $attr->class : '';
                        //if($class == 'post-link')
                        if(strpos($href, ".html") != false) {
							if(strpos($href, "babyfood.com.vn") === false) {
								$array_links[] = "https://babyfood.com.vn/".$href;
							} else {
								$array_links[] = $href;
							}
						}
                                
                    }
                }
                
                $this->data['results'] = implode("\n", $array_links);
            }
	}
    
    function dlPage($href) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		//curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_URL, $href);
		curl_setopt($curl, CURLOPT_REFERER, $href);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
			// Blindly accept the certificate
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		// decode response
		curl_setopt($curl, CURLOPT_ENCODING, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
		$str = curl_exec($curl);
		
		if(curl_exec($curl) === false)
		{
			echo 'Curl error: ' . curl_error($curl);
		}
		
		curl_close($curl);
		// Create a DOM object
		$dom = new simple_html_dom();
		// Load HTML from a string
		$dom->load($str);

		return $dom;
	}
    
    function check_exists($alias) {
        $check = $this->db->select('Id')->from('mn_product')->where('alias', $alias)->get()->num_rows();
        if($check > 0) return true;
        else return false;
    }
    
    function insertData($data) {
        if($this->check_exists($data['alias']) == false) {
			$insert = array(
               'title_vn' => trim($data['title_vn']),
               'alias' => $data['alias'],
               'content_vn' => $data['content_vn'],
               'idcat' => isset($data['idcat']) ? $data['idcat'] : 0, //cho thue can ho
               'price' => $data['price'] ? $data['price'] : 0,
			   'sale_price' => $data['sale_price'] ? $data['sale_price'] : 0,
               'images' => $data['images'],
               'date' => time()
            );
			
            $this->db->insert('mn_product', $insert);
            
            $id = $this->db->insert_id();
            
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function _Resize_Crop($file_path, $file_name, $folder = 'images', $width=155, $height=130) {
        
        $this->load->library('image_moo');
        $return = $this->image_moo->load($file_path)
                //->set_background_colour('#ffffff')
                ->resize_crop($width, $height, TRUE)
                ->save(FCPATH . 'uploads/thumb/'.$folder.'/'.$file_name, TRUE);
        return $return;
    }
    
    function ftp_upload_file($filename, $name) {
        
        //-- Code to Transfer File on Server Dt: 06-03-2008 by Aditya Bhatt --//
        //-- Connection Settings
        $ftp_server = "image.muonnha.com.vn"; // Address of FTP server.
        $ftp_user_name = "imgver"; // Username
        $ftp_user_pass = 'Admin@123'; // Password
        $destination_file = "/domains/image.muonnha.com.vn/public_html/uploads/"; //where you want to throw the file on the webserver (relative to your login dir)
        $conn_id = ftp_connect($ftp_server) or die("<span style='color:#FF0000'><h2>Couldn't connect to $ftp_server</h2></span>");        // set up basic connection
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die("<span style='color:#FF0000'><h2>You do not have access to this ftp server!</h2></span>");   // login with username and password, or give invalid user message
        if ((!$conn_id) || (!$login_result)) {  // check connection
            // wont ever hit this, b/c of the die call on ftp_login
            return false;
        } else {
            return false;
        }
        $upload = ftp_put($conn_id, $destination_file.$name, $filename, FTP_BINARY);  // upload the file
        ftp_close($conn_id); // close the FTP stream  
        if (!$upload) {  // check upload status
            return false;
        } else {
            return true;
        }
    }
    
    function save_image_ftp($file, $name) {
        
        $tmp_file = $this->save_base64_image(file_get_contents($file), $name);
        
        if($tmp_file !== false) {
            
            //extract name
            $folders = explode("/", $tmp_file);
            $year = $folders[0];
            $month = $folders[1];
            $date = $folders[2];
            
            //resize image tmp
            $this->load->library('image_moo');
            $return = $this->image_moo->load(FCPATH . '/uploads/images/' . $tmp_file)
            //->set_background_colour('#ffffff')
            ->resize_crop(784, 484, TRUE)
            ->save(FCPATH . '/tmp/'.$tmp_file, TRUE);
            //upload to server image via FTP
            $ftp_server = "image.muonnha.com.vn"; // Address of FTP server.
            $ftp_user_name = "imgver"; // Username
            $ftp_user_pass = 'Admin@123'; // Password
            $destination_dir = "/domains/image.muonnha.com.vn/public_html/uploads/"; 
            $destination_file = "/public_html/uploads/images/"; //where you want to throw the file on the webserver (relative to your login dir)
            $conn_id = ftp_connect($ftp_server) or die("<span style='color:#FF0000'><h2>Couldn't connect to $ftp_server</h2></span>");        // set up basic connection
            $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die("<span style='color:#FF0000'><h2>You do not have access to this ftp server!</h2></span>");   // login with username and password, or give invalid user message
            
            if ((!$conn_id) || (!$login_result)) {  // check connection
                // wont ever hit this, b/c of the die call on ftp_login
                return false;
            } else {
                $remote_file = "/public_html/uploads/images/" . $tmp_file;
                $local_file = FCPATH . '/uploads/images/' . $tmp_file;
                //if( !ftp_chdir($conn_id, $destination_file . $year) ) 
                @ftp_mkdir($conn_id, $destination_file . $year);
                //if (!ftp_chdir($conn_id, $destination_file . $year . '/' . $month)) 
                @ftp_mkdir($conn_id, $destination_file . $year . '/' . $month);
                //if (!ftp_chdir($conn_id, $destination_file . $year . '/' . $month . '/' . $date)) 
                @ftp_mkdir($conn_id ,$destination_file . $year . '/' . $month . '/' . $date);
                
                $upload = ftp_put($conn_id, $remote_file, $local_file, FTP_BINARY);
            }
            //delete tmp filename
            @unlink(FCPATH . '/uploads/images/' . $tmp_file);
            
            //return filename
            return $tmp_file;
        }
    }
    
    function save_base64_image($file, $name) {
        
        if(strlen($name) > 150) {
            $name = substr($name, 0, 150);
        }
        
        //create path folder 2016/11/07
        $year = date("Y", time());
        $month = date("m", time());
        $date = date("d", time());
        
        $folder = 'data';
       
        $upload_path = FCPATH . 'data/Product/';
        $filename = $name . ".jpg";
        $upload_thumb_path = FCPATH . 'data/Product/thumbs/';
        
        if($file!=''){
            if (!is_dir($upload_path) or !is_writable($upload_path)) {
                // Error if directory doesn't exist or isn't writable.
                echo 'Error folder not found';
                return false;
            } elseif (is_file($upload_path) and !is_writable($upload_path)) {
                echo 'Permission deny';
                return false;
                // Error if the file exists and isn't writable.
            }
            file_put_contents($upload_path . $name.".jpg", $file);
            
            //_Resize_Crop($upload_path . $name.".jpg", $image_path . '/' . $name.'.jpg', 'images');
            
            $image_size = getimagesize($upload_path . $name.".jpg");
            $image_width = $image_size[0];
            $image_height = $image_size[1];
            
            $this->load->library('image_moo');   
            //Resize image
            
            //Tạo ảnh thumb 150x150
            $file_fullpath = $upload_path . $name.".jpg";
            $create_thumb = $this->image_moo->load($file_fullpath)
                ->set_background_colour('#ffffff')
                ->resize_crop(150, 150, TRUE)
                ->save( $upload_thumb_path . $name . ".jpg", TRUE );
            
            
            return $filename;    
        } else {
            return false;
        }
    }
  
    function formatPriceUnit($price_number) {
        $result = array();
        if(($price_number / 1000000) >= 1) { // Nếu là số triệu
            $result['price_unit'] = 1;
            $result['unit_label'] = 'Triệu/tháng';
            $result['price_number'] = $price_number / 1000000;
        } elseif(($price_number / 1000) >= 1) { // Nếu là số trăm
            $result['price_unit'] = 2; 
            $result['unit_label'] = 'Nghìn/tháng';
            $result['price_number'] = $price_number / 1000;
        } else { //Mặc định triệu
            $result['price_number'] = $price_number;
            $result['price_unit'] = 1;
            $result['unit_label'] = 'Triệu/tháng';
        }
        return $result;
    }
    
    function testFormatPrice($price) {
        print_r($this->formatPriceUnit($price));
    }
    
    function import_babyfoot($url, $category_id) {
        //require APPPATH . "/third_party/phpcrawl/libs/simple_html_dom.php";
		
		$data = $this->dlPage(trim($url));
		$res = array();
        $res['url'] = trim($url);
        
        //$this->logIndex($index);
		if(!empty($data)) {
			//do something
            $insert = array(
                'title_vn' => '',
				'content_vn' => '',
				'idcat' => 0,
				'images' => '',
				'price' => '',
				'sale_price' => '',
				'alias' => '',
				'idcat' => $category_id
            );
			
            //Find title
            $find_title = $data->find('.page-title > span');
			if(!empty($find_title)) {
				foreach($find_title as $item) {
					$title = $item->plaintext;
                    //$title = sub_string($title, 130);
                    //Title
                    $insert['title_vn'] = trim($title);
				}    
			}
			
            $title_alias = $this->to_slug(str_replace("/","-",$insert['title_vn']));
			
            if($this->check_exists($title_alias) == false) {
                $insert['alias'] = $title_alias;
                
                //Image
    			$find_image = $data->find('.block_big_thumb > .relative > img');
				if(!empty($find_image)) {
					foreach($find_image as $item) {
						$image = $item->src;
						$image_base64 = file_get_contents($image);
						$image_name = $insert['alias'].'-'.time();
						$image_uploaded = $this->save_base64_image($image_base64, $image_name);
						//if($image_uploaded) 
							$insert['images'] = $image_uploaded;
						
					}    
				}
				
				//Price
				$find_price = $data->find('.price-wrapper > .price > span');
				if(!empty($find_price)) {
					$product_price = 0;
					foreach($find_price as $price) {
						$product_price = $price->plaintext;
					}
					$insert['price'] = str_replace(",", "", $product_price);
					$insert['sale_price'] = str_replace(",", "", $product_price);
				}
				
                //Content
    			foreach($data->find('.noidung') as $item) {
    				$content = $item->innertext;
                    $insert['content_vn'] = $content;
    			}
                if($insert && $insert['title_vn']!='' && $insert['alias']!='') {
					
					$insert_id = $this->insertData($insert);
                    //if($insert_id)
                      // $this->db->where('url', $url)->update('crawler_links', array('status'=>1));
                }
    			
    			$res['success'] = true;    
    			$res['title'] = $title;
            } else {
                $res['success'] = false;
            }
		} else {
			$res['success'] = false;
		}
		echo json_encode($res);
    }
	
	function to_slug($str) {
		$str = trim(mb_strtolower($str));
		$str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
		$str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
		$str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
		$str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
		$str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
		$str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
		$str = preg_replace('/(đ)/', 'd', $str);
		$str = preg_replace('/[^a-z0-9-\s]/', '', $str);
		$str = preg_replace('/([\s]+)/', '-', $str);
		$str = preg_replace("/[\/_|+ -]+/", '-', $str);
		return $str;
	}
}