<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	function GetArr($str = NULL){
		if($str== 0 && is_numeric($str) ) {
			$str = array('0');
			return $str;
		}
		if(!empty($str)){
			$str = explode(",",$str);
		}else { $str[] = 0;}
		
		if(!in_array(0,$str)) $str[] = 0;
		return $str;
	}
	function ArrNotelist($id,$arr){
		$brr = array();
		if(in_array($id,$arr)){
			foreach($arr as $k){
				if($k!=$id) $brr[] = $k;
			}
		}else{
			$brr = $arr;
			$brr[] = $id;
		}
	
		//--------kiềm tra cuối cùng
		if(!empty($brr)){
			foreach($brr as $k=>$v){
				if($v == 0) unset($brr[$k]);
			}
		}
		return $brr;
	}  
	function eli_string($arr){
	
		if(!empty($arr)){
			foreach($arr as $k =>$v){
				if($v == 0) unset($arr[$k]);
			}
		}
		if(empty($arr)) return 0;
		return implode(",",$arr);
	}
	function getLink($link,$id,$color,$size,$manu,$fromprice,$topprice,$sort,$task,$q="",$idcat =0,$option='option'){
		
		$var_link = NULL;
		if($task=='color'){
			$color = ArrNotelist($id,$color);
			if(!empty($color))  $var_link .= "&color=".implode(",",$color);
		}else{
			$color = eli_string($color);
			if($color!=0)  $var_link .= "&color=".$color;
		}
		//-------------------size -------------
		if($task == 'size'){
			$size = ArrNotelist($id,$size);
			if(!empty($size))  $var_link .= "&size=".implode(",",$size);
		}else{
			$size = eli_string($size);
			
			if($size!=0)  $var_link .= "&size=".$size;
		}
		//-------------------manu -------------
		if($task == 'manu'){
			$manu = ArrNotelist($id,$manu);
			if(!empty($manu))  $var_link .= "&manu=".implode(",",$manu);
		}else{
			$manu = eli_string($manu);
			if($manu!=0)  $var_link .= "&manu=".$manu;
		}
		//-------------------------
		if($task=='no-sort'){
			$var_link .= "&min=".$fromprice."&max=".$topprice;
		}else{
			if($task == 'price'){
				$var_link .= "&sort=".$sort;
			}else{
				$var_link .= "&min=".$fromprice."&max=".$topprice."&sort=".$sort;
			}
		}
		
		$var_link = substr($var_link,1);
		$link = $link."?".$var_link;
		
		return $link;
	}
	function bsVndDot($strNum)
	{
		$strNum = (int)$strNum;
		$result = number_format($strNum,0,',','.');
		return $result;
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
	
	function meta_pro($property = '', $content = '', $type = 'property', $newline = "\n")
	{
		// Since we allow the data to be passes as a string, a simple array
		// or a multidimensional one, we need to do a little prepping.
		if ( ! is_array($property))
		{
			$property = array(array('property' => $property, 'content' => $content, 'type' => $type, 'newline' => $newline));
		}
		else
		{
			// Turn single array into multidimensional
			if (isset($property['property']))
			{
				$property = array($property);
			}
		}

		$str = '';
		foreach ($property as $meta)
		{
			$type       = ( ! isset($meta['type']) OR $meta['type'] == 'property') ? 'property' : 'http-equiv';
			$property       = ( ! isset($meta['property']))     ? ''    : $meta['property'];
			$content    = ( ! isset($meta['content']))  ? ''    : $meta['content'];
			$newline    = ( ! isset($meta['newline']))  ? "\n"  : $meta['newline'];

			$str .= '<meta '.$type.'="'.$property.'" content="'.$content.'" />'.$newline;
		}

		return $str;
	}
	function GetHtmlSort($sort){
		if($sort=='sort ASC') return 'Đề cử';
		else if($sort=='sale_price ASC') return 'Giá tăng dần';
		else if($sort=='sale_price DESC') return 'Giá giảm dần';
		else if($sort=='oder DESC') return 'Bán chạy';
		else if($sort=='Id DESC') return 'Mới nhất';
		else return 'Đề cử';
	}
	
	function GetPay($data){
		ksort($data);
		$stringHashData = "";
		foreach ( $data as $key => $value ) {
			if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
				 $stringHashData .= $key . "=" . $value . "&";
			}
		}
			return $stringHashData;
	}
	function getImg($images,$size="original"){
		$dir = FCPATH."data/Product/";
		$dirthumb = FCPATH."data/Product/thumbs/";
		if($size=="thumb"){
			if(file_exists($dirthumb.$images)){
				$images = PATH_IMG_PRODUCT."thumbs/".$images;
			}else{
				$images = PATH_IMG_PRODUCT.$images;
			}
		}else{
			$images = PATH_IMG_PRODUCT.$images;
		}
		return $images;
	}

	function resizeImage($data,$with,$height,$t)
    {
        $match = '_w'.$with.'_h'.$height.'_t'.$t;
        preg_match("/^.*.(jpg|JPG|PNG|png|GIF|gif)$/",$data,$m);
        $result = preg_replace("~.".end($m)."(?!.*.".end($m).")~", $match.'.'.end($m), $data);
        return $data;
    }

function minimizeCSS($css)
{
    $css = preg_replace('/\/\*((?!\*\/).)*\*\//s', '', $css);
    $css = preg_replace('/\s{2,}/', ' ', $css);
    $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
    $css = preg_replace('/;}/', '}', $css);
    return $css;
}

/**
 * get gia khuyen mai
 * @param $price
 */
function getPriceOffer($price)
{

}