<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Wellcome to admin</title>
<base href="<?php echo BASE_URL?>admincp">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo ADMIN_PATH_IMG; ?>favication.png">
<script type="text/javascript" src="/public/ck/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/public/ck/ckeditor/ckeditor.js"></script>
    <script>
        console.log(typeof CKEDITOR);
    </script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(ADMIN_PATH_CSS); ?>style.css?v=<?php echo time(); ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_PATH_CSS; ?>font-awesome.min.css"/>
<script src="<?php echo ADMIN_PATH_JS; ?>jquery-1.10.2.js"></script>
<script src="<?php echo ADMIN_PATH_JS; ?>default.js"></script>

<script language = 'javascript' src = '<?php echo ADMIN_PATH_JS; ?>datepicker/WdatePicker.js'></script>
</head>
<body>
<header class="header">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="left" width="50%"></td>
        <td align="right" width="50%" valign="middle"><div class="personal"> Chào bạn, <a href="<?php echo base_url('admincp/admin/change'); ?>"><?php echo $this->session->userdata('login_admin_username'); ?></a> | <a href="<?php echo base_url('admincp/login/logout'); ?>"> Thoát</a> </div></td>
      </tr>
    </tbody>
  </table>
</header>
<section id="container" class="container">
<div class="wrapper_adminmenu">
  <div class="menuitem-home"> <a href="<?php  echo  base_url("admincp");?>" title="Trang chủ"> <img alt="Tổng Quan" src="<?php echo ADMIN_PATH_IMG; ?>icon-16-home.png"> </a> </div>
  <a href="<?php  echo  base_url("admincp/website");?>">
  <div class="menuitem">Hệ thống</div>
  </a> <a href="<?php  echo  base_url("admincp/news");?>">
  <div class="menuitem">Quản lý bài viết - Liên hệ</div>
  </a> <a href="<?php  echo  base_url("admincp/product");?>">
  <div class="menuitem">Quản lý cửa hàng</div>
  </a> </div>
<div class="wrapper_submenu">
  <?php
if($idmenu>0){
	$submenu	=	$this->adminmenu_model->get_list($idmenu);
	if(!empty($submenu)){
		foreach($submenu as $row){
?>
  <div class="wrapper_item"> <a href="<?php echo  base_url($row->route); ?>">
    <div class="item cl-<?php echo $row->Id; ?>">
    	<div class="bage">0</div>
      <div class="image"> <img alt="" src="<?php  echo  ADMIN_PATH_IMG.'adminmenu/'.$row->images; ?>"> </div>
      <div class="text"><?php echo $row->title_vn; ?></div>
    </div>
    </a> </div>
  <?php } }} ?>
</div>
<?php $this->load->view($template,$data); ?>
</div>
<div class="main-button-delete-cache">
<span class="id-short-cache" title="Xóa cache toàn trang"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></span>
</body>
</html>