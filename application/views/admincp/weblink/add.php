<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Banner Home / <?php echo $map_title ?></td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="content_i">
<form method="post" name="add-new" action="" enctype="multipart/form-data">
<table>
<tr>
	<td class = 'title_td' >Danh mục</td>
    <td> <select name="parentid">
    	<option value="">Chọn danh mục hiển thị</option>
        <?php
		if(!empty($catlist)){
			foreach($catlist as $item){
		?>
        <option value="<?php echo $item['Id'] ?>" <?php echo set_select('idcat',$item['Id']) ?>><?php echo $item['title_vn'] ?></option>
        <?php }} ?>
    	</select>
   		 <?php echo form_error('parentid'); ?>
     </td>
</tr>
<!-- <tr>
	<td class = 'title_td' >Danh mục deal</td>
    <td> <select name="iddeal">
    	<option value="">Chọn danh mục hiển thị</option>
        
        <?php
		if(!empty($catdeallist)){
			foreach($catdeallist as $item){
		?>
        <option value="<?php echo $item['Id'] ?>" <?php echo set_select('iddeal',$item['Id']) ?>><?php echo $item['title_vn'] ?></option>
        <?php }} ?>
    	</select>
   		 <?php echo form_error('iddeal'); ?>
     </td>
</tr> -->
<tr>
	<td class = 'title_td' >Vị trí</td>
    <td> <select name="style">
    	<option value="" >Chọn vị trí hiển thị</option>
        <option value="6" <?php /*echo set_select('style',6)*/ ?>>Banner Home</option>
        <option value="2" <?php echo set_select('style',2) ?>>Banner Top trang chủ</option>
        <option value="1" <?php echo set_select('style',1) ?>>Banner Slideshow trang chủ</option>
        <option value="7" <?php echo set_select('style',7) ?>>Banner bên phải slideshow trang chủ </option>
        <option value="5" <?php echo set_select('style',5) ?>>Banner dưới slideshow trang chủ </option>
        <option value="3" <?php echo set_select('style',3) ?>>Baner danh mục trang chủ</option>
        <option value="4" <?php echo set_select('style',4)?> >Baner trên footer </option>
    	</select>
   		 <?php echo form_error('style'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Bố cục</td>
    <td> <select name="layout">
    	<option value="" >Chọn bố cục hiển thị</option>
        <option value="L" <?php echo set_select('layout','L') ?>>Left</option>
        <option value="C" <?php echo set_select('layout','C') ?> >Center</option>
        <option value="R" <?php echo set_select('layout','R') ?>>Right</option>
        
    	</select>
   		 <?php echo form_error('layout'); ?>
     </td>
</tr>

<tr>
	<td class = 'title_td' >Hình ảnh</td>
    <td> <input type="file" name="userfile">
   		 <?php echo form_error('userfile'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Link</td>
    <td> <input type="text" name="link" value="<?php echo set_value('link','') ?>"  style="width:400px">
   		 <?php echo form_error('link'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Sắp xếp</td>
    <td> <input type="text" name="sort" value="<?php echo set_value('sort','') ?>"  style="width:200px">
   		 <?php echo form_error('sort'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Khóa</td>
    <td> <input type="checkbox" value="1" name="ticlock"  <?php echo set_checkbox('ticlock', '1'); ?>/> </td>
</tr>
<tr>
<td  ></td>
    <th align = 'left'>
       <button type = 'submit' name="save" value="save"  class="button" >Thêm mới</button> &nbsp;&nbsp;&nbsp;&nbsp;
        <input type = 'reset' value = 'Làm lại' class="button">
    </th>
</tr>	
</table>
</form> 
</div>
</div>  