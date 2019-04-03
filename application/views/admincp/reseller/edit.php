<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Quản lý nội dung / Người bán / <?php echo $map_title ?></td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="content_i">
<form method="post" name="add-new" action="" enctype="multipart/form-data">
 <input type="hidden" name="Id" value="<?php if(!empty($info['id'])) echo $info['id']; ?>">
<table>
<tbody>
<tr>
<td width="820" valign="top">
<table>
<tr>
    <td class = 'title_td' width="100">Tên Shop</td>
    <td>
	<input type="text" name="shop_name" value="<?php echo set_value('shop_name',$info['shop_name']) ?>"  style="width:400px"> 
        <?php echo form_error('shop_name'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Tài khoản</td>
    <td>
	<input type="text" name="username" value="<?php echo set_value('username',$info['username']) ?>"  style="width:400px"> 
        <?php echo form_error('username'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Email</td> 
    <td>
	<input type="text" name="email" value="<?php echo set_value('email',$info['email']) ?>"  style="width:400px"> 
        <?php echo form_error('email'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Tỉnh thành</td>
    <td>
	<select  name="shop_city" id="shop_city" class="form-control">
        <option selected="">Chọn tỉnh/thành</option>
        <?php
        if(!empty($provinces)){
            foreach($provinces as $item){
                if($item['Id']!=65){
        ?>
            <option value="<?php echo $item['Id'] ?>" <?php echo set_select('shop_city', $item['Id'],($info['shop_city']==$item['Id'])?TRUE:FALSE); ?> ><?php echo $item['title_vn'] ?></option>
        <?php }}} ?>
        </select>
        <?php echo form_error('shop_city'); ?> 
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Quận huyện</td>
    <td>
	<select  id="shop_district" name="shop_district" class="form-control"></select>
	<?php echo form_error('shop_district'); ?> 
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Phạm vi bán hàng </td>
    <td>
	<select name="shop_province" class="form-control">
	<?php
    if(!empty($provinces)){
        foreach($provinces as $item){
    ?>
        <option value="<?php echo $item['Id'] ?>" <?php echo set_select('shop_province', $item['Id'],($info['shop_province']==$item['Id'])?TRUE:FALSE); ?>><?php echo $item['title_vn'] ?></option>
    <?php }} ?>
    </select>
    <?php echo form_error('shop_province'); ?>
    </td>
</tr>

<tr>
    <td class = 'title_td' width="100">Chuyển cung cấp</td>
    <td>
	<select class="form-control" name="catelog">
	<?php
    if(!empty($catelog)){
        foreach($catelog as $item){
    ?>
        <option value="<?php echo $item['Id'] ?>" <?php echo set_select('catelog', $item['Id'],($info['catelog']==$item['Id'])?TRUE:FALSE); ?>><?php echo $item['title_vn'] ?></option>
    <?php }} ?>
    </select>
    <?php echo form_error('catelog'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Địa chỉ</td>
    <td>
	<input type="text" name="address" value="<?php echo set_value('address',$info['address']) ?>"  style="width:400px"> 
        <?php echo form_error('address'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Điện thoại</td>
    <td>
	<input type="text" name="phone" value="<?php echo set_value('phone',$info['phone']) ?>"  style="width:400px"> 
        <?php echo form_error('phone'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Website</td>
    <td>
	<input type="text" name="shop_website" value="<?php echo set_value('shop_website',$info['shop_website']) ?>"  style="width:400px"> 
        <?php echo form_error('shop_website'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Tự động duyệt</td>
    <td> <input type="checkbox" value="1" name="auto_check"  <?php if(!empty($info['auto_check'])){ if($info['auto_check']==1) echo 'checked'; } ?> /> </td>
</tr>
<tr>
	<td class = 'title_td' >Khóa</td>
    <td> <input type="checkbox" value="1" name="ticlock"  <?php if(!empty($info['ticlock'])){ if($info['ticlock']==1) echo 'checked'; } ?> /> </td>
</tr>
<tr>
	<td class = 'title_td' >Khóa vĩnh viễn</td>
    <td> <input type="checkbox" value="1" name="lock"  <?php if(!empty($info['lock'])){ if($info['lock']==0) echo 'checked'; } ?> /> </td>
</tr>
<tr>
<td  ></td>
    <th align = 'left'>
       <button type = 'submit' name="save" value="save"  class="button" >Cập nhật</button> &nbsp;&nbsp;&nbsp;&nbsp;
        <input type = 'reset' value = 'Làm lại' class="button">
    </th>
</tr>	
</table>
</td>
<td valign="top">
	<table class="right_new" >
     	 
     	<tr>
            <td class = 'title_td'>Title page</td>
            <td><input type = 'text' name = 'titlepage' size = '30' value="<?php echo set_value('titlepage',$info['titlepage']) ?>"></td>
        </tr> 
        <tr>
            <td class = 'title_td'>Meta Keyword</td>
            <td><textarea name = 'meta_keyword' class="left-tag" ><?php echo set_value('meta_keyword',$info['meta_keyword']);  ?></textarea></td>
        </tr> 
        <tr>
            <td class = 'title_td'>Meta Description</td>
            <td><textarea name = 'meta_description' class="left-tag"  ><?php echo set_value('meta_description',$info['meta_description']);  ?></textarea></td>
        </tr> 
    </table>
</td>
</tr>
</tbody>
</table>
</form> 
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	val = $('#shop_city').val();
	url = "/user/district/"+val;
	$('#shop_district').load(url,function(){$('#shop_district').val('<?php echo $info['shop_district']; ?>')});
	$('#shop_city').change(function(){
		id = $(this).val();
		$('#shop_district').load("/user/district/"+id);
	});
})
</script>    