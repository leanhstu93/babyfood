<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
-------------------------------------------------------------------------------------------								
													
-------------------------------------------------------------------------------------------
- File cấu hình website, thông tin kết nối database path thư mục, addon domain.
*/

define("HOSTNAME_CONNECT","localhost");
define("USERNAME_CONNECT","root");
define("PASSWORD_CONNECT","");
define("DATABSE_CONNECT","babyfood");
//------------------------------------//
define("KEY","Van@quyenKIMada#!+");
define("DATE_EXP","2017-05-31");
define("ADMIN_PATH_IMG","/public/template/admin/images/");
define("ADMIN_PATH_JS","/public/template/admin/js/");
define("ADMIN_PATH_CSS","/public/template/admin/css/");
define("USER_PATH_IMG","/public/template/images/");
define("USER_PATH_JS","/public/template/js/");
define("USER_PATH_CSS","/public/template/css/");
define("PATH_IMG_FLASH","/data/Flash/");
define("PATH_IMG_NEWS","/data/News/");
define("PATH_IMG_PRODUCT","/data/Product/");
define("PATH_IMG_USER","/data/User/");
define("PATH_IMG_BANNER","/data/Banner/");
define("PATH_IMG_MANUFACTURER","/data/Manufacturer/");
define("PATH_IMG_PARTNERS","/data/Partners/");

define('CONSUMER_KEY', '27wxHrOIG1oLoRr5NxvIkxPcp'); 
define('CONSUMER_SECRET', 'BqTReJG7wnLYFk0UAHUaNIuBeFjoQlb492wtNJy1cevreq39H1');
define('OAUTH_CALLBACK', '');
define('LAZYLOAD_IMAGE','data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC');
$server_name = $_SERVER['HTTP_HOST'];
//$server_name = 'http://localhost/babyshop.com';
define("BASE_URL","http://anhle93.com:93/");
define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/api/Facebook/');
include __DIR__ . '/Mobile_Detect.php';
$detect = new Mobile_Detect();
if ($detect->isMobile()){
	define("USERTYPE","Mobile");
}else{
	define("USERTYPE","PC");
}
require_once __DIR__ . '/api/Facebook/autoload.php';
?>