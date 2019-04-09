<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('simple_html_dom.php');
class Page{
	protected $conn_id;
	var $CI = '';
	protected $dictionnaryNumbers 	= array(
			0 => "không",
			1 => "một",
			2 => "hai",
			3 => "ba",
			4 => "bốn",
			5 => "năm",
			6 => "sáu",
			7 => "bẩy",
			8 => "tám",
			9 => "chín",
		);
	protected $dictionnaryUnits 	= array(
		0 => "tỷ",		
		1 => "triệu",		
		2 => "nghìn",		
		3 => "đồng",		
	);
	
	function __construct()
    {
        $this->CI =& get_instance();
		$this->CI->load->database();
    }
	function redirect( $url = '' )
	{
		header("location:{$url}");
		exit;
	}
	function gen_pass($pass)
	{
		$pass = md5($pass);
		//$pass = md5(KEY.$pass);
		return $pass;
	}
	function delete_file($file){
		return @unlink($file);
	}
	function limit_text($text,$maxlen){
	  $sentenceSymbol=array(".","!","?"," ");  // di?m k?t thúc câu
	  $text=strip_tags($text,"<br /><br/><br><b><i>"); // nh?ng tag mu?n gi? l?i
	  for ($i=$maxlen; $i>0; $i--)  {
		  $ch=substr($text,$i,1);
		  if (in_array($ch,$sentenceSymbol)){
			 $pos=$i;
			 $i=0;
		  }
	  }
	  $temp=substr($text,0,$pos+1);
	  $temp  =strip_tags($temp);
	  return trim($temp);
	}
	
	function escape_str($str, $like = FALSE)
	{
		if (is_array($str))
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = $this->escape_str($val, $like);
			}
	
			return $str;
		}
		if (function_exists('mysqli_real_escape_string') AND is_object($this->conn_id))
		{
			$str = mysqli_real_escape_string($this->conn_id, $str);
		}
		else
		{
			$str = addslashes($str);
		}
	
		// escape LIKE condition wildcards
		if ($like === TRUE)
		{
			$str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
		}
	
		return $str;
	}
	function getStarPro($sumstar=0,$countstar=0){
		if($countstar >0) $star =round($sumstar/$countstar,1);else $star = 0;
		$star_array = explode(".",$star) ;
		$str = NULL;
		for($i=1;$i<=$star_array[0];$i++){  $str .='<i class="fa fa-star yellow"></i>'; }
		if(isset($star_array[1])){
			$star_bellow = 5 -($star_array[0]+1) ;
			$str .= '<i class="fa fa-star-half-o yellow"></i>';
		}else{
			$star_bellow = 5 -$star_array[0] ;
		}
		for($i=1;$i<=$star_bellow;$i++){ $str .= '<i class="fa fa-star"></i>'; }
		return $str;
	}
	function getNoteList($arr,$note){
		if(empty($arr)) return false;
		$i=0;
		$list = NULL;
		foreach($arr as $k=>$v){
			if($v==0){
				// xoa
			}else if($v == $note){
				$i=1;
			}else{
				$list .= $v.",";
			}
		}
		if($i!=1) $list .=$note.".";
		if($list==NULL) return 0;
		return	 substr($list,0,-1);
	}
	function changeList($arr){
		if(empty($arr)) return false;
		$i=0;
		$list = NULL;
		foreach($arr as $item){
			$list[] = $item['Id'];
		}
		return	 $list;
	}
	function getNdate($time){
		$date = $time - time();
		if($date>0){
			$day  = round($date/86400);
			$ngay =   $day." ngày";
		}else{
			$date = (int)$date;
			$day  = round($date/86400);
			$ngay =   $day." ngày";
		}
		return $ngay;
	}
	function strtoseo($value,$task=false){ 
		
		$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
		"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
		,"ế","ệ","ể","ễ",
		"ì","í","ị","ỉ","ĩ",
		"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
		,"ờ","ớ","ợ","ở","ỡ",
		"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
		"ỳ","ý","ỵ","ỷ","ỹ",
		"đ",
		"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
		,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
		"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
		"Ì","Í","Ị","Ỉ","Ĩ",
		"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
		,"Ờ","Ớ","Ợ","Ở","Ỡ",
		"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
		"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
		"Đ",
		" ","?",":","\"","'",",",".","!","#","@","$","(",")","[","]","{","}","|","+","`","&","/","%","\\","<",">");
	
		$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
		,"a","a","a","a","a","a",
		"e","e","e","e","e","e","e","e","e","e","e",
		"i","i","i","i","i",
		"o","o","o","o","o","o","o","o","o","o","o","o"
		,"o","o","o","o","o",
		"u","u","u","u","u","u","u","u","u","u","u",
		"y","y","y","y","y",
		"d",
		"A","A","A","A","A","A","A","A","A","A","A","A"
		,"A","A","A","A","A",
		"E","E","E","E","E","E","E","E","E","E","E",
		"I","I","I","I","I",
		"O","O","O","O","O","O","O","O","O","O","O","O"
		,"O","O","O","O","O",
		"U","U","U","U","U","U","U","U","U","U","U",
		"Y","Y","Y","Y","Y",
		"D",
		"-","","","","","","","","","","","","","","","","","","","","","","","-","","");
		$value = str_replace($marTViet,$marKoDau,$value);
		$value = mb_strtolower(trim($value), "UTF-8"); 
		$value = str_replace(' ','-',$value);
	
		$value = str_replace('?','',$value);
		$value = str_replace('/','-',$value);	$value = str_replace('%','',$value);	
		$charaterA = '#(à|ả|ã|á|ạ|ă|ằ|ẳ|ẵ|ắ|ặ|â|ầ|ẩ|ẫ|ấ|ậ)#imsU';     
		$replaceCharaterA = 'a';     
		$value = preg_replace($charaterA, $replaceCharaterA, $value);      	      	
		$charaterD = '#(đ)#imsU';      $replaceCharaterD = 'd';      
		$value = preg_replace($charaterD,$replaceCharaterD,$value);            
		$charaterE = '#(è|ẻ|ẽ|é|ẹ|ê|ề|ể|ễ|ế|ệ)#imsU';      
		$replaceCharaterE = 'e';      
		$value = preg_replace($charaterE,$replaceCharaterE,$value);         
		$charaterI = '#(ì|ỉ|ĩ|í|ị)#imsU';      
		$replaceCharaterI = 'i';      
		$value = preg_replace($charaterI,$replaceCharaterI,$value);            
		$charaterO = '#(ò|ỏ|õ|ó|ọ|ô|ồ|ổ|ỗ|ố|ộ|ơ|ờ|ở|ỡ|ớ|ợ)#imsU';      
		$replaceCharaterO = 'o';      
		$value = preg_replace($charaterO,$replaceCharaterO,$value);                  
		$charaterU = '#(ù|ủ|ũ|ú|ụ|ư|ừ|ử|ữ|ứ|ự)#imsU';      
		$replaceCharaterU = 'u';      
		$value = preg_replace($charaterU,$replaceCharaterU,$value);            
		$charaterY = '#(ỳ|ỷ|ỹ|ý|ỵ)#imsU';      
		$replaceCharaterY = 'y';      
		$value = preg_replace($charaterY,$replaceCharaterY,$value); 
		$value = str_replace(',','',$value); 
		$value = str_replace('---','-',$value);   
		$value = str_replace('--','-',$value);   
		$value = str_replace('-–-','-',$value);    
		$value = str_replace('_','-',$value); 
		$value = str_replace('(','',$value); 
		$value = str_replace(')','',$value); 
		$value = str_replace('{','',$value); 
		$value = str_replace('&','',$value); 
		$value = str_replace('}','',$value); 
		$value = str_replace('.','-',$value); 
		$value = str_replace('--','-',$value);    
		$value = str_replace('ỏ','o',$value); 
		$value = preg_replace('/[^\p{L}\p{N}]/u', '-', $value);
		$value = str_replace("--",'-',$value);
		if($task ==true){
			$value = str_replace("--",'',$value);
			$value = str_replace("-",'',$value);
		}	 			
		return $value;	
	}
	function strlink($value,$task=false){ 
		
		$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
		"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
		,"ế","ệ","ể","ễ",
		"ì","í","ị","ỉ","ĩ",
		"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
		,"ờ","ớ","ợ","ở","ỡ",
		"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
		"ỳ","ý","ỵ","ỷ","ỹ",
		"đ",
		"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
		,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
		"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
		"Ì","Í","Ị","Ỉ","Ĩ",
		"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
		,"Ờ","Ớ","Ợ","Ở","Ỡ",
		"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
		"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
		"Đ",
		" ","?",":","\"","'",",",".","!","#","@","$","(",")","[","]","{","}","|","+","`","&","/","%","\\","<",">");
	
		$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
		,"a","a","a","a","a","a",
		"e","e","e","e","e","e","e","e","e","e","e",
		"i","i","i","i","i",
		"o","o","o","o","o","o","o","o","o","o","o","o"
		,"o","o","o","o","o",
		"u","u","u","u","u","u","u","u","u","u","u",
		"y","y","y","y","y",
		"d",
		"A","A","A","A","A","A","A","A","A","A","A","A"
		,"A","A","A","A","A",
		"E","E","E","E","E","E","E","E","E","E","E",
		"I","I","I","I","I",
		"O","O","O","O","O","O","O","O","O","O","O","O"
		,"O","O","O","O","O",
		"U","U","U","U","U","U","U","U","U","U","U",
		"Y","Y","Y","Y","Y",
		"D",
		"-","","","","","","","","","","","","","","","","","","","","","","","-","","");
		$value = str_replace($marTViet,$marKoDau,$value);
		$value = mb_strtolower(trim($value), "UTF-8"); 
		$value = str_replace(' ',',',$value);
	
		$value = str_replace('?','',$value);
		$value = str_replace('/','-',$value);	$value = str_replace('%','',$value);	
		$charaterA = '#(à|ả|ã|á|ạ|ă|ằ|ẳ|ẵ|ắ|ặ|â|ầ|ẩ|ẫ|ấ|ậ)#imsU';     
		$replaceCharaterA = 'a';     
		$value = preg_replace($charaterA, $replaceCharaterA, $value);      	      	
		$charaterD = '#(đ)#imsU';      $replaceCharaterD = 'd';      
		$value = preg_replace($charaterD,$replaceCharaterD,$value);            
		$charaterE = '#(è|ẻ|ẽ|é|ẹ|ê|ề|ể|ễ|ế|ệ)#imsU';      
		$replaceCharaterE = 'e';      
		$value = preg_replace($charaterE,$replaceCharaterE,$value);         
		$charaterI = '#(ì|ỉ|ĩ|í|ị)#imsU';      
		$replaceCharaterI = 'i';      
		$value = preg_replace($charaterI,$replaceCharaterI,$value);            
		$charaterO = '#(ò|ỏ|õ|ó|ọ|ô|ồ|ổ|ỗ|ố|ộ|ơ|ờ|ở|ỡ|ớ|ợ)#imsU';      
		$replaceCharaterO = 'o';      
		$value = preg_replace($charaterO,$replaceCharaterO,$value);                  
		$charaterU = '#(ù|ủ|ũ|ú|ụ|ư|ừ|ử|ữ|ứ|ự)#imsU';      
		$replaceCharaterU = 'u';      
		$value = preg_replace($charaterU,$replaceCharaterU,$value);            
		$charaterY = '#(ỳ|ỷ|ỹ|ý|ỵ)#imsU';      
		$replaceCharaterY = 'y';      
		$value = preg_replace($charaterY,$replaceCharaterY,$value); 
		$value = str_replace(',','',$value); 
		$value = str_replace('---','-',$value);   
		$value = str_replace('--','-',$value);   
		$value = str_replace('-–-','-',$value);    
		$value = str_replace('_','-',$value); 
		$value = str_replace('(','',$value); 
		$value = str_replace(')','',$value); 
		$value = str_replace('{','',$value); 
		$value = str_replace('&','',$value); 
		$value = str_replace('}','',$value); 
		$value = str_replace('.','-',$value); 
		$value = str_replace('--','-',$value);    
		$value = str_replace('ỏ','o',$value); 
		$value = preg_replace('/[^\p{L}\p{N}]/u', '-', $value);
		$value = str_replace("--",'-',$value);
		if($task ==true){
			$value = str_replace('',$value);
			$value = str_replace('',$value);
		}	 			
		$value = str_replace("-",' ',$value);
		return $value;
			
	}
	
	function bsVndDot($strNum)
	{
		$strNum = (int)$strNum;
		$result = number_format($strNum,0,',','.');
		return $result;
	}
	function getlastchange($time,$timedang = '0'){
		$date = time()- $time;
		//if($time==$timedang)  $lu = 'Đăng'; else $lu = "Up";
		$lu =NULL;
		if($date <= 60){
			return $lu.' vài giây trước';
		}
		else if($date < 3600){
			$minute  = round($date/60);
			return $minute." phút trước";
		}
		else if( $date < 86400) {
			$day  = round($date/3600);
			return $day." giờ trước";
		}elseif( $date <= 604800){
			$day  = round($date/86400);
			return $day." ngày ";
		}else{
			return $lu." ngày ".date('d/m/Y',$time); 
		}
	}
	function check_valid_date($year, $month, $day)
	{
		if ($year == 0) return false;
		if ($month == 0) return false;
		return true;
		//$num_day_of_month = self::num_day_of_month($year, $month);
		//return ($day >= 1) && ($day <= $num_day_of_month);
	}
	function getRealIPAddress(){  
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	function rand_string($len = 32)
	{
		$length = $len;
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$string = "";    
		for ($p = 0; $p < $length; $p++)
		{
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}
		return $string;
	}
	function get_domain($url)
	{
	  $parsedUrl = parse_url($url);
	  return $parsedUrl['host'];
	  /*  $pieces = parse_url($url);
	  $domain = isset($pieces['host']) ? $pieces['host'] : '';
	  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
		return $regs['domain'];
	  }
	  return false;*/
	}
	function get_BaseDomain($url)
	{
	  $pieces = parse_url($url);
	  $domain = isset($pieces['host']) ? $pieces['host'] : '';
	  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
		  $domain  = str_replace('www.',"",$regs['domain']);
		return $domain;
	  }
	  return false;
	}
	function readFile($idfollow){
		$dir = FCPATH.'data/Follow/'.$idfollow;
        $result = @file_get_contents($dir);
        return $result;
	}
	public function  TreeCat($data,$pid,$tcat,$id,$text,$colum = "title_vn")
	{
	
		if(!empty($data))
		{
			foreach($data as $item)
			{
				if(!isset($item['parentid'])) $parentid = 0; else $parentid = $item['parentid'];
				if($pid == $parentid){ 
					if($id == $item['Id']){
						$str = '<option value = "'.$item['Id'].'" selected >'.$text.$item["title_vn"].'</option>';
					}else{
						$str = '<option value = "'.$item['Id'].'">'.$text.$item["title_vn"].'</option>';
					}
					$tcat .= $this->TreeCat($data,$item['Id'],$str,$id,$text." --- ",'title_vn');
				}
				
			}
		}
		return $tcat;
	}
	function divPage($total = 0,$currentPage = 0,$div = 5,$rows = 10,$goto){
		if(!$total || !$rows || !$div || $total<=$rows) return false;
		
		$nPage = floor($total/$rows) + (($total%$rows)?1:0);
		$nDiv  = floor($nPage/$div) + (($nPage%$div)?1:0);
		$currentDiv = floor($currentPage/$div) ;
		$sPage = '';
		
		if($currentDiv) {
			$sPage .= '<a href="'.$goto.'/0" class = \'apaging\'><<</a> ';
			$sPage .= '<a href="'.$goto.'/'.($currentDiv*$div - 1).'"><</a> ';
		}
		
		$count =($nPage<=($currentDiv+1)*$div)?($nPage-$currentDiv*$div):$div;
		
		for($i=0;$i<$count;$i++){
			$page = ($currentDiv*$div + $i);
			if($page==$currentPage){
				$sPage .= '<strong >'.($page+1).'</strong> ';
			}else{
				$sPage .= '<a href="'.$goto.'/'.($currentDiv*$div + $i ).'" >'.($page+1).'</a> ';
			}
		}
		
		if($currentDiv < $nDiv - 1){			
			$sPage .= '<a href="'.$goto.'/'.(($currentDiv+1)*$div + 1 ).'">></a> ';
			$sPage .= '<a href="'.$goto.'/'.(($nDiv-1)*$div + 1 ).'">>></a>';
		}
		return $sPage;
	}
	function divPageF($total = 0,$currentPage = 0,$div = 5,$rows = 10,$goto){
		if(!$total || !$rows || !$div || $total<=$rows) return false;
		
		$nPage = floor($total/$rows) + (($total%$rows)?1:0);
		$nDiv  = floor($nPage/$div) + (($nPage%$div)?1:0);
		$currentDiv = floor($currentPage/$div) ;
		$sPage = '';
		
		if($currentDiv) {
			$sPage .= '<a href="'.$goto.'" class = \'apaging\'><<</a> ';
			$sPage .= '<a href="'.$goto.''.($currentDiv*$div - 1).'"><</a> ';
		}
		
		$count =($nPage<=($currentDiv+1)*$div)?($nPage-$currentDiv*$div):$div;
		
		for($i=0;$i<$count;$i++){
			$page = ($currentDiv*$div + $i);
			if($page==$currentPage){
				$sPage .= '<strong >'.($page+1).'</strong> ';
			}else{
				$sPage .= '<a href="'.$goto.''.($currentDiv*$div + $i ).'" >'.($page+1).'</a> ';
			}
		}
		
		if($currentDiv < $nDiv - 1){			
			$sPage .= '<a href="'.$goto.''.(($currentDiv+1)*$div + 1 ).'">></a> ';
			$sPage .= '<a href="'.$goto.''.(($nDiv-1)*$div + 1 ).'">>></a>';
		}
		return $sPage;
	}
	function divPageAjax($total = 0,$currentPage = 0,$div = 5,$rows = 10,$goto){
		if(!$total || !$rows || !$div || $total<=$rows) return false;
		
		$nPage = floor($total/$rows) + (($total%$rows)?1:0);
		$nDiv  = floor($nPage/$div) + (($nPage%$div)?1:0);
		$currentDiv = floor($currentPage/$div) ;
		$sPage = '';
		
		if($currentDiv) {
			$sPage .= '<a href="javascript: cmt_pagination('.$goto.',0,true)" class = \'cmt-pagination\'><<</a> ';
			$sPage .= '<a href="javascript: cmt_pagination('.$goto.','.($currentDiv*$div - 1).',true)"><</a> ';
		}
		
		$count =($nPage<=($currentDiv+1)*$div)?($nPage-$currentDiv*$div):$div;
		
		for($i=0;$i<$count;$i++){
			$page = ($currentDiv*$div + $i);
			if($page==$currentPage){
				$sPage .= '<strong >'.($page+1).'</strong> ';
			}else{
				$sPage .= '<a href="javascript: cmt_pagination('.$goto.','.($currentDiv*$div + $i ).',true)" class="cmt-pagination" >'.($page+1).'</a> ';
			}
		}
		
		if($currentDiv < $nDiv - 1){			
			$sPage .= '<a href="javascript: cmt_pagination('.$goto.','.(($currentDiv+1)*$div + 1 ).',true)">></a> ';
			$sPage .= '<a href="javascript: cmt_pagination('.$goto.','.(($nDiv-1)*$div + 1 ).',true)">>></a>';
		}
		return $sPage;
	}
	// get html dom form file
	function file_get_html() {
		$dom = new simple_html_dom;
		$args = func_get_args();
		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		$context = stream_context_create($opts);
		$args[] = false;
		$args[] = $context;
		$dom->load(call_user_func_array('file_get_contents' ,$args), true);
		return $dom;
	}
	
	// get html dom form string
	function str_get_html($str, $lowercase=true) {
		$dom = new simple_html_dom;
		$dom->load($str, $lowercase);
		return $dom;
	}
	
	// dump html dom tree
	function dump_html_tree($node, $show_attr=true, $deep=0) {
		$lead = str_repeat('    ', $deep);
		echo $lead.$node->tag;
		if ($show_attr && count($node->attr)>0) {
			echo '(';
			foreach($node->attr as $k=>$v)
				echo "[$k]=>\"".$node->$k.'", ';
			echo ')';
		}
		echo "\n";
	
		foreach($node->nodes as $c)
			dump_html_tree($c, $show_attr, $deep+1);
	}
	
	// get dom form file (deprecated)
	function file_get_dom() {
		$dom = new simple_html_dom;
		$args = func_get_args();
		$dom->load(call_user_func_array('file_get_contents', $args), true);
		return $dom;
	}
	
	// get dom form string (deprecated)
	function str_get_dom($str, $lowercase=true) {
		$dom = new simple_html_dom;
		$dom->load($str, $lowercase);
		return $dom;
	}
	function get_img_content($html){
		$content = $this->str_get_html($html);
		$content = $content->find('img',0);
		if(empty($content)) return USER_PATH_IMG.'no-image.png';
		$hr =  $content->src;
		
		if(file_exists($hr)){
			$file = $hr;
		}else{
			if (!filter_var($hr, FILTER_VALIDATE_URL) === false) {
				
					$file = $hr;
				//}
			}else{
				$file =  USER_PATH_IMG.'no-image.png';
			}
			
		}
		return $file;
	}
	function out_content($html){
		$content = $this->str_get_html($html);
		foreach( $content->find('a') as $link) {
			//$aliaslink = rand_linkTS();
			$link->outertext = $link->innertext;
		}
		/*foreach( $content->find('img') as $link) {
			//$aliaslink = rand_linkTS();
			$link->outertext = "";
		}*/
		$content = $content->innertext;
		return $content;
	}
	function replace_script($content){
		$content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
		return $content;
	}
	function getSubCatlogId($id) {
		$allid= NULL;
		$query =  $this->CI->db->get_where('mn_catelog',array('ticlock'=>0,'parentid'=>$id),500,0);
		$rows =  $query->result_array();
		if(!empty($rows)){
			foreach($rows as $item)
			{
				$allid .= $item['Id'].",";
				$allid .= $this->getSubCatlogId($item['Id']);
			}
		}
		
		return $allid;
	}
	function getSubCatDealId($id) {
		$allid= NULL;
		$query =  $this->CI->db->get_where('mn_catdeal',array('ticlock'=>0,'parentid'=>$id),500,0);
		$rows =  $query->result_array();
		if(!empty($rows)){
			foreach($rows as $item)
			{
				$allid .= $item['Id'].",";
				$allid .= $this->getSubCatDealId($item['Id']);
			}
		}
		
		return $allid;
	}
	function RandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.time();
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	
	function rand_number($len = 8)
	{
		$length = $len;
		$characters = '0123456789';
		$string = "";    
		for ($p = 0; $p < $length; $p++)
		{
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}
		return $string;
	}
	function getCode($rand) {
		$query =  $this->CI->db->get_where('mn_customer',array('code'=>$rand),100,0);
		$rows =  $query->result_array();
		if(!empty($rows)){
			$this->getCode($this->$this->rand_number());
		}else{
			return $rand;
		}
	}
	function readNumber3Digits($number, $readFull = true){
		
			// 01 - LẤY CHỮ SỐ HÀNG TRĂM, HÀNG CHỤC, HÀNG ĐƠN VỊ

			$number 	= strval($number);
			$number 	= str_pad($number, 3, 0, STR_PAD_LEFT);
			$digit_0 	= substr($number, 2, 1);
			$digit_00 	= substr($number, 1, 1);
			$digit_000 	= substr($number, 0, 1);
			
			// 02 - HÀNG TRĂM
			$str_000 = $this->dictionnaryNumbers[$digit_000] . " trăm ";
			
			
			// 03 - HÀNG CHỤC
			$str_00 = $this->dictionnaryNumbers[$digit_00] . " mươi ";
			if($digit_00 == 0) $str_00 = " linh ";
			if($digit_00 == 1) $str_00 = " mười ";
			
			// 04 - HÀNG ĐƠN VỊ
			$str_0 = $this->dictionnaryNumbers[$digit_0];
			if($digit_00 > 1 && $digit_0 == 1) $str_0 = " mốt ";
			if($digit_00 > 0 && $digit_0 == 5) $str_0 = " lăm ";
			if($digit_00 == 0 && $digit_0 == 0){
					$str_0 	= "";
					$str_00 = "";
			}
			
			if($digit_0 == 0){
					$str_0 	= "";
			}
	
			if($readFull == false){
					if($digit_000 == 0) $str_000 = "";
					if($digit_000 == 0 && $digit_00 == 0) $str_00 = "";
			}
			$result = $str_000 . $str_00 . $str_0;
		
			return $result;
	}
	
	function formatString($str, $type = null){
    	// Dua tat ca cac ky tu ve dang chu thuong
	    $str	= strtolower($str);
 
	    // Loai bo khoang trang dau va cuoi chuoi
	    $str	= trim($str);
 
    	// Loai bo khoang trang du thua giua cac tu
 
	    $array 	= explode(" ", $str);
    	foreach($array as $key => $value){
		        if(trim($value) == null) {
        			    unset($array[$key]);
            			continue;
		        }
			
		        // Xu ly cho danh tu
		        if($type=="danh-tu") {
            			$array[$key] = ucfirst($value);
    		    }
	    }
 
    	$result = implode(" ", $array);
 
	    // Chuyen ky tu dau tien thanh chu hoa
	    $result	= ucfirst($result);
 
	    return $result;
	}
	 
	function readNumber12Digits($number){
			$number 	= strval($number);
			$number 	= str_pad($number, 12, 0, STR_PAD_LEFT);
			$arrNumber 	= str_split($number, 3);
			foreach($arrNumber as $key => $value){

					if($value != "000"){
						
							$index = $key;
							break;
							
					}
			}
			$i=0;
			foreach($arrNumber as $key => $value){
				$i++;
				if($key >= $index){
					
						$readFull = true;
						if($key >= $index) $readFull = false;
						$result[$key] = $this->readNumber3Digits($value, $readFull) . " " . $this->dictionnaryUnits[$key];
				}
			}
			$result = implode(" ", $result);
	
			$result = $this->formatString($result);
		
		//		$result = str_replace("không đồng", "đồng", $result);
		//		$result = str_replace("không trăm đồng", "đồng", $result);
		// 		$result = str_replace("không nghìn đồng", "đồng", $result);
		// 		$result = str_replace("không trăm nghìn đồng", "đồng", $result);
			$result = str_replace("triệu nghìn đồng", "triệu đồng", $result);
			$result = str_replace("tỷ triệu đồng", "tỷ đồng", $result);
			return $result;
	}
	
	
	
}
/*End */