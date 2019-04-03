<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Địa điểm / <?php echo $map_title ?></td>
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
	<td class = 'title_td' >Tiêu đề</td>
    <td> <input type="text" name="title_vn" value="<?php echo set_value('title_vn','') ?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Tỉnh/ Thành phố</td>
    <td> <select name="idcat">
    	<option value="0">Chọn Tỉnh / Thành phố</option>
        <?php 
		if(!empty($listcat)){
			foreach($listcat as $item){	
		?>
        <option value="<?php echo $item['Id'] ?>" <?php echo set_select('idcat', $item['Id']); ?>><?php echo $item['title_vn']; ?></option>
        <?php }} ?>
    </select>
   		 <?php echo form_error('idcat'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Phí giao hàng</td>
    <td> <input type="text" name="ship" value="<?php echo set_value('ship','') ?>"  style="width:200px" onkeyup="this.value = FormatNumber(this.value);" >
   		 <?php echo form_error('ship'); ?>
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