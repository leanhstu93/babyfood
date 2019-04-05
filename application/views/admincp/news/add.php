<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Bài viết / <?php echo $map_title ?></td>
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
         <select name = 'idcat'>
            <option value = ''>- - Chọn chủ đề - -</option>
            <?php echo $this->page->TreeCat($listcat,0,"","","--");?>
        </select>
        <?php echo form_error('idcat'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Tiêu đề </td>
    <td> <input type="text" name="title_vn" value="<?php echo set_value('title_vn','') ?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Mô tả </td>
    <td> 
    <textarea id="editor1"  class="textdes" name="description_vn"><?php echo set_value('description_vn','') ?></textarea>
     <?php echo form_error('description_vn'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Nội dung </td>
    <td> 
    <textarea id="editorvn" name="content_vn"><?php echo set_value('content_vn','') ?></textarea>
     <?php echo form_error('content_vn'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Alias</td>
    <td> <input type="text" name="alias" value="<?php echo set_value('alias','') ?>"  style="width:400px">
   		 <?php echo form_error('alias'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Images</td>
    <td> <input type="file" name="userfile"   >
     </td>
</tr>
<tr>
                  <td class = 'title_td' >Meta title</td>
                  <td><input type="text" name="meta_title" value="<?php echo set_value('meta_title', '');  ?>"  style="width:400px">
                    <?php echo form_error('meta_title'); ?></td>
                </tr>
<tr>
	<td class = 'title_td' >Meta Description</td>
    <td> 
    <textarea  name="meta_description" class="textarea"><?php echo set_value('meta_description','') ?></textarea>
     <?php echo form_error('meta_description'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td' >Link mở rộng</td>
    <td>
        <input type="text" name="link_extend" value="<?php echo set_value('link_extend', '');  ?>"  style="width:400px">
        <?php echo form_error('link_extend'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Meta Keywork</td>
    <td>
    <textarea  name="meta_keyword" class="textarea" ><?php echo set_value('meta_keyword','') ?></textarea>
     <?php echo form_error('meta_keyword'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Tag</td>
    <td> <input type="text" name="tag" value="<?php echo set_value('tag','') ?>"  style="width:400px">
   		 <?php echo form_error('tag'); ?>
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
<script type="text/javascript">
if (typeof CKEDITOR == 'undefined') {
	document.write('CKEditor');
}else {
	var editorContent = CKEDITOR.replace('editorvn'); 
	var editorContent = CKEDITOR.replace('editor1'); 
}
</script>    