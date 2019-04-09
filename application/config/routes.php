<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';

$route['index'] = 'home/index';
$route['page/(:any)'] = 'home/detail/$1';
//$route['danh-muc/(:any)'] = 'product/get_product/$1';
$route['dang-khuyen-mai'] = 'product/sales/$1'; 
//$route['san-pham/(:any)-(:num)'] ="product/detail/$2";
$route['gio-hang'] ="payment/cart";
$route['addcart_fromcat'] ="payment/addcart_fromcat";
$route['addcart_fromdetail'] ="payment/addcart_fromdetail";
$route['tim-kiem'] ="product/search";
$route['bai-viet/search'] ="news/search";
$route['bai-viet/(:any)'] ="news/detail/$1";
$route['chu-de/(:any)'] = 'news/catelog/$1';
$route['chu-de/(:any)/(:num)'] = 'news/catelog/$1/$2';
$route['thanh-toan'] = 'payment/order';
$route['dat-hang-thanh-cong/(:num)'] = 'payment/success/$1';
$route['call-back'] ="home/call_back";

$route['sitemap.xml'] ="tools/index";
$route['nextweb/themes/babyshop/css/customize-css'] ="tools/customizeCss";

$route['admincp'] ="admincp/login";

$route['404.html'] ="home/notfoud";
$route['(:any)\.html'] ="product/detail/$1";
$route['(:any)/(:num)'] = 'product/get_product/$1';
$route['(:any)'] = 'product/get_product/$1';

$route['san-pham/(:any)/(:num)'] = 'product/category/$1/$1';
$route['translate_uri_dashes'] = FALSE;

$route['404_override'] = 'home/notfound';