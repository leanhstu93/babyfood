<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Quản lý nội dung / Người mua / <?php echo $map_title ?></td>
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
<tr>
    <td class = 'title_td' width="100">Tên đăng nhập</td>
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
    <td class = 'title_td' width="100">Họ tên</td>
    <td>
	<input type="text" name="fullname" value="<?php echo set_value('fullname',$info['fullname']) ?>"  style="width:400px"> 
        <?php echo form_error('fullname'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Giới tính</td>
    <td>
		<select name="gioitinh">
        	<option value="">Chọn giới tính</option>
            <option value="1" <?php if($info['gioitinh']==1) echo 'selected'; ?>>Nam</option>
            <option value="0" <?php if($info['gioitinh']==0) echo 'selected'; ?> >Nữ</option>
        </select>
        <?php echo form_error('fullname'); ?>
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
    <td class = 'title_td' width="100">Tỉnh thành</td>
    <td>
		<select name="idtinh">
        	<option value="">Chọn tỉnh thành </option>
            <?php
			if(!empty($listprovinces)){
				foreach($listprovinces as $item){
			?>
            <option value="<?php echo $item['Id']; ?>" <?php if($info['idtinh']==$item['Id']) echo 'selected'; ?>><?php echo $item['title_vn']; ?></option>
            <?php }} ?>
        </select>
        <?php echo form_error('idtinh'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Cấp độ</td>
    <td>
		<select name="level">
        	<option value="">Chọn cấp độ</option>
            <option value="1" <?php if($info['level']==1) echo 'selected'; ?>>Người mua</option>
            <option value="2" <?php if($info['level']==2) echo 'selected'; ?> > Người bán</option>
        </select>
        <?php echo form_error('level'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Kích hoạt</td>
    <td> <input type="checkbox" value="1" name="ticlock"  <?php if(!empty($info['ticlock'])){ if($info['ticlock']==1) echo 'checked'; } ?> /> </td>
</tr>
<tr>
	<td class = 'title_td' >Khóa </td>
    <td> <input type="checkbox" value="1" name="lock"  <?php if(!empty($info['lock'])){ if($info['lock']==1) echo 'checked'; } ?> /> </td>
</tr>
<tr>
<td  ></td>
    <th align = 'left'>
       <button type = 'submit' name="save" value="save"  class="button" >Cập nhật</button> &nbsp;&nbsp;&nbsp;&nbsp;
        <input type = 'reset' value = 'Làm lại' class="button">
    </th>
</tr>	
</table>
</form> 
</div>
</div>    