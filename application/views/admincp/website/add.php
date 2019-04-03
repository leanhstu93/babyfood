<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Hệ thống / Thành viên quản trị/ <?php echo $map_title ?></td>
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
    <td class = 'title_td' width="100">Cấp độ</td>
    <td>
        <select name = 'level'>
            <option value='0' <?php echo set_select('level', '0', TRUE); ?> >- - Chọn nhóm cha - -</option>
			<option value="1" <?php echo set_select('level', '1'); ?> >- - Administrator - -</option>
            <option value="2" <?php echo set_select('level', '2'); ?> >- - Mod - -</option>
        </select>
        <?php echo form_error('level'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Username</td>
    <td> <input type="text" name="username" value="<?php echo set_value('username','') ?>"  style="width:400px">
   		 <?php echo form_error('username'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Email</td>
    <td> <input type="text" name="email" value="<?php echo set_value('email','') ?>"  style="width:400px"> 
    	<?php echo form_error('email'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Password</td>
    <td> <input type="password" name="password" value=""  style="width:400px">
    	<?php echo form_error('password'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Repassword</td>
    <td> <input type="password" name="repassword" value=""  style="width:400px"> 
    	<?php echo form_error('repassword'); ?>
    </td>
</tr>

<tr>
	<td class = 'title_td' >Họ tên</td>
    <td> <input type="text" name="fullname" value="<?php echo set_value('fullname','') ?>"  style="width:400px"> </td>
</tr>
<tr>
	<td class = 'title_td' >Địa chỉ</td>
    <td> <input type="text" name="address" value="<?php echo set_value('address','') ?>"  style="width:400px"> </td>
</tr>
<tr>
	<td class = 'title_td' >Thông tin thêm</td>
    <td><textarea style="width:400px; height:100px;" name="note"> <?php echo set_value('note','') ?></textarea></td>
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