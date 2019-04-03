<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mgallery{
	function Upload_NoReSize($f,$name,$uploadDir, &$error ){
		$error="";	
		$name =  mb_strtolower(trim($name), "UTF-8"); 
		$choUpload = array("gif","jpeg","png","jpg");
		$maxsize = 1024*1024; //1MB
		$tmp_name = $f["tmp_name"];
		if ($tmp_name == "") return "";
		$coCuaFile = $f["size"]; //Tinh bang byte		
		$error="";
		 $ext = strtolower(substr(strrchr($f['name'], '.'), 1));
		if (in_array($ext,$choUpload)==false) $error = "<br>Kiểu file không chấp nhận";
		elseif ($coCuaFile>$maxsize) $error = "<br>Kích thước file quá lớn";
		if ($error!="") return "";
		echo $pathfile = $uploadDir.$name.".".$ext; 
		$tenhinhluu = $name.".".$ext;
		if (file_exists($uploadDir)==false) mkdir($uploadDir, NULL ,true);
		move_uploaded_file($tmp_name, $pathfile);	
		
		return $tenhinhluu;
	}
	function Upload($image,$image_root,$dir_save,$w,$h){
		$dir = FCPATH."data/Tam/";
		$ext = strtolower(substr(strrchr($image_root['name'], '.'), 1));
		$image = $image.".".$ext;
		move_uploaded_file($image_root["tmp_name"],$dir.$image);
		list($width, $height) = getimagesize($dir.$image); 
		if($width < $w){
			$w = $width;
		}
		$this->img_resize($image,$dir,$w,$h,$dir_save,$image);
		unlink($dir.$image);
		return $image;
	}
	function img_resize($tmpname,$save_dir,$aw,$ah,$dir,$img_tmp) {
		$save_dir .= ( substr($save_dir,-1) != "/") ? "/" : "";
		$gis = getimagesize($save_dir.$tmpname);
		$type = $gis[2];
		switch($type) {
			case "1": $imorig = imagecreatefromgif($save_dir.$tmpname); break;
			case "2": $imorig = imagecreatefromjpeg($save_dir.$tmpname);break;
			case "3": $imorig = imagecreatefrompng($save_dir.$tmpname); break;
			default: $imorig = imagecreatefromjpeg($save_dir.$tmpname);
		}
		$x = imagesx($imorig);
		$y = imagesy($imorig);
		if($ah=='auto' && is_numeric($aw)){
			$ah=($aw/$x*100)*($y/100);
		}
		if($aw=='auto' && is_numeric($ah)){
			$aw=($ah/$y*100)*($x/100);
		}
		$im = imagecreatetruecolor($aw,$ah);
		if (imagecopyresampled($im,$imorig , 0,0,0,0,$aw,$ah,$x,$y)) {
			imagejpeg($im, $dir.$img_tmp);
		}
		
	}
}
/*End */