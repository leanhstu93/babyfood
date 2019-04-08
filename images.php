<?php
// Lay ra cac tham so can thiet
function debug($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    exit();
}
$request_url_expr = explode('/',trim($_SERVER['REQUEST_URI'],'/'));
$dir =  __DIR__.'/'.$request_url_expr[0].'/'.$request_url_expr[1].'/';
$file_path = implode('/',array_slice($request_url_expr,2));
$extension = pathinfo($file_path,PATHINFO_EXTENSION);
// Thong số MẶC ĐỊNH ĐỂ CẮT HÌNH
$dst_w = 400;
$dst_h = 400;
$crop_type = 1; // loại cắt 1: thu gọn, 2 bao quanh hình nền
$hex_bg = 'FFFFFF'; // Hình nền bao ngoài
// lấy ra thông số tùy chỉnh trên URL, bắt buộc w,h, t
$has_option = preg_match("/_w\d+_h\d+_t[123](_bg([\da-zA-Z]{3}){1,2})?\.$extension$/",$file_path,$options);
if($has_option) {
    //'/^(w|h|t|bg)[\da-zA-Z]+$/'
    $options_str = str_replace('.'.$extension, '',ltrim($options[0],'_'));
    $filepath = str_replace('_'.$options_str,'',$file_path);

    foreach (explode('_',$options_str) as $option) {
        if(preg_match('/^(w|h|t|bg)[\da-zA-Z]+$/',$option,$match)) {
            $k = $match[1];
            $v = str_replace($k,'',$option);
            switch($k) {
                case 'w':
                    $dst_w = intval($v);
                    break;
                case 'h':
                    $dst_h = intval($v);
                    break;
                case 't':
                    $crop_type = intval($v);
                    break;
                case 'bg':
                    $hex_bg = intval($v);
                    break;
            }
        }
    }
}
// Load image
$abs_filepath = $dir.$file_path;

if (!is_file($abs_filepath)) {
    $file_path = urldecode($filepath);
    $abs_filepath = $dir.$file_path;
}

$exists_file = is_file($abs_filepath);

$src_img = $exists_file ? imagecreatefromstring(file_get_contents($abs_filepath)) : false;

if ($src_img === false) {
    exit('Image is not available');
}

$req_w = $dst_w;
$req_h = $dst_h;
list($ori_w, $ori_h) = getimagesize($abs_filepath);
$src_w = $ori_w;
$src_h = $ori_h;
$dst_x = $dst_y = $src_x = $src_y = 0;

// tỉ lệ with/height
$dst_ratio = $dst_w / $dst_h;
$src_ratio = $src_w / $src_h;
if (!$has_option) {
    $req_w = $dst_w = $src_w;
    $req_h = $dst_h = $src_h;
} else {
    if($crop_type === 3) {
        /**
         * Xu ly resize anh theo ty le voi with
         */
        $req_w = $dst_w;
        $req_h = $ori_h / ($ori_w / $req_w);
    } elseif ($crop_type === 1) {
        // cắt kiểu thu gọn (cũ)
        // Cắt tối đa chiều rộng hình gốc, và hình gốc vẫn dư chiều cao
        if ($dst_ratio > $src_ratio) {
            $src_h = $ori_w / $dst_ratio;
            $src_y = ($ori_h - $src_h) / 2;
        } elseif ($dst_ratio < $src_ratio) {
            // cắt tối đa chiều cao hình gốc, và hình gốc vẫn dư chiều rộng
            $src_w = $src_h * $dst_ratio;
            $src_x = ($ori_w - $src_w) / 2;
        }
    } elseif ($crop_type === 2) {
        $has_fill_color = true;
        // Cắt hình dư khoảng trống top và bottom
        if ($src_ratio > $dst_ratio) {
            $dst_h = $dst_w / $src_ratio;
            $dst_y = ($req_h - $dst_h) / 2;

            $bg1_x1 = $bg1_y1 = 0;
            $bg1_x2 = $req_w - 1;
            $bg1_y2 = $dst_y - 1;

            $bg2_x1 = 0;
            $bg2_y1 = $dst_y + $dst_h - 1;
            $bg2_x2 = $req_w - 1;
            $bg2_y2 = $req_h - 1;
        } elseif ($src_ratio < $dst_ratio) {
            // cat hinh du khoang left va right
            $dst_w = $dst_h * $src_ratio;
            $dst_x = ($req_w - $dst_w) / 2;

            $bg1_x1 = $bg1_y1 = 0;
            $bg1_x2 = $dst_x - 1;
            $bg1_y2 = $req_h - 1;

            $bg2_x1 = $dst_x + $dst_w - 1;
            $bg2_y1 = 0;
            $bg2_x2 = $req_w - 1;
            $bg2_y2 = $req_h - 1;
        } else {
            $has_fill_color = false;
        }
    }
}

// Xu ly cat hinh

$dst_img = imagecreatetruecolor($req_w, $req_h);

if ($extension === 'png') {
    imagealphablending($dst_img, false);
    imagesavealpha($dst_img, true);
}

/** xu ly resize anh theo ty le voi with */
if($crop_type === 3){

    imagecopyresampled($dst_img, $src_img,0,0,0,0,$req_w,$req_h,$ori_w,$ori_h);
    /**
     * end xu ly resize anh theo ty le with
     */
} else {
    imagecopyresampled($dst_img, $src_img, $dst_x,$dst_y,$src_x,$src_y,$dst_w,$dst_h,$src_w,$src_h);
}

/*
 * fill mau 2 ben neu thuoc tinh dang 2
 */
if($crop_type == 2 && $has_fill_color) {
    if (strlen($hex_bg) == 3) {
        /*
         * ma hex 3 ky tu , chuyen thanh 6 ky tu
         */
        $hex_bg = substr_replace($hex_bg, substr($hex_bg,0,1), 1,0);
        $hex_bg = substr_replace($hex_bg, substr($hex_bg,2,1), 3,0);
        $hex_bg .= substr($hex_bg,4);
    }

    if(strlen($hex_bg) === 6) {
        $red_color = hexdec(substr($hex_bg,0,2));
        $green_color = hexdec(substr($hex_bg, 2,2));
        $blue_color = hexdec(substr($hex_bg,4));
        $bg_color = imagecolorallocate($dst_img,$red_color,$green_color,$blue_color);

        // fill mau
        imagefilledrectangle($dst_img,$bg1_x1,$bg1_y1,$bg1_x2,$bg1_y2,$bg_color);
        imagefilledrectangle($dst_img,$bg2_x1,$bg2_y1,$bg2_x2,$bg2_y2,$bg_color);
    }
}

// Dat response header la kieu image
if ($extension === 'jpg') {
    $extension = 'jpeg';
}
$mime_type = 'image/' . $extension;
header('Content-Type:' . $mime_type);

// render
call_user_func(str_replace('/','',$mime_type), $dst_img);
imagedestroy($dst_img);
imagedestroy($src_img);
exit;
