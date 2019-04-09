<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Danh mục Deal / <?php echo $map_title ?></td>
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
    <td class = 'title_td' width="100">Chủ đề</td>
    <td>
         <select name = 'parentid'>
            <option value = ''>- - Chọn chủ đề - -</option>
          	<?php
			if(!empty($listcat)){
				foreach($listcat as $item){
					$sub= $this->pagehtml_model->get_catelog($item['Id']); 
			?>
            <option value="<?php echo $item['Id'] ?>" <?php echo set_select('parentid', $item['Id']); ?>><?php echo $item['title_vn']; ?></option>
            <?php if(!empty($sub)){ 
				foreach($sub as $row){
			?>
            <option value="<?php echo $row['Id'] ?>" <?php echo set_select('parentid', $row['Id']); ?>>---<?php echo $row['title_vn']; ?></option>
            <?php }}}} ?>
        </select>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Tiêu đề</td>
    <td> <input type="text" name="title_vn" value="<?php echo set_value('title_vn','') ?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Alias</td>
    <td> <input type="text" name="alias" value="<?php echo set_value('alias','') ?>"  style="width:400px"> 
     	<?php echo form_error('alias'); ?>
     </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Mã màu</td>
    <td>
       <input type="text" name="style" value="<?php echo set_value('style','') ?>"  style="width:400px">
        <?php echo form_error('style'); ?> 
    </td>
</tr>
<tr>
    <td class = 'title_td'>Tag</td>
    <td><textarea name="tag" style="width:400px; height:100px;" ><?php echo set_value('tag','') ?></textarea>
     <?php echo form_error('tag'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Tiêu đề Trang</td>
    <td>
       <input type="text" name="title" value="<?php echo set_value('title','') ?>"  style="width:400px">
        <?php echo form_error('title'); ?> 
    </td>
</tr>
<tr>
    <td class = 'title_td'> Meta Keyword</td>
    <td><textarea name="meta_keyword" style="width:400px; height:100px;" ><?php echo set_value('meta_keyword','') ?></textarea>
     <?php echo form_error('meta_keyword'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td'> Meta Description</td>
    <td><textarea name="meta_description" style="width:400px; height:100px;"  ><?php echo set_value('meta_description','') ?></textarea>
     <?php echo form_error('meta_description'); ?>
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