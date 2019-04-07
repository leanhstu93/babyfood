<?php
// Lay ra cac tham so can thiet
function debug($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    exit();
}
$request_url_expr = explode('/',trim($_SERVER['REQUEST_URI'],'/'));
$dir=  $request_url_expr[0].'/'.$request_url_expr[1].'/';
$file_path = implode('/',array_slice($request_url_expr,2));
$extension = pathinfo($file_path,PATHINFO_EXTENSION);
// Thong số MẶC ĐỊNH ĐỂ CẮT HÌNH
$dst_w = 400;
$dst_h = 400;
$crop_type = 1; // loại cắt 1: thu gọn, 2 bao quanh hình nền
$hex_bg = 'FFFFFF'; // Hình nền bao ngoài
// lấy ra thông số tùy chỉnh trên URL, bắt buộc w,h, t
$has_option = preg_match("/_w\d+_h\d+_t[123](_bg([\da-zA-Z](3))(1,2))?\.$extension$/",$file_path,$options);
debug($has_option);
