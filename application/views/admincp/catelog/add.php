<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Chủ đề / <?php echo $map_title ?></td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="content_i">
<form method="post" name="add-new" action="" enctype="multipart/form-data">
<table>
<tbody>
<tr>
<td width="820" valign="top">
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
	<td class = 'title_td' >Hình ảnh menu PC</td>
    <td> <input type="file" name="photo"  style="width:400px">
     </td>
</tr>
<tr>
	<td class = 'title_td' >Hình ảnh home Mobile</td>
    <td> <input type="file" name="images1"  style="width:400px">
     </td>
</tr>
<tr>
	<td class = 'title_td' >Tiêu đề</td>
    <td> <input type="text" name="title_vn" value="<?php echo set_value('title_vn','') ?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Tiêu đề ngắn gọn</td>
    <td> <input type="text" name="short_title" value="<?php echo set_value('short_title','') ?>"   style="width:400px">
   		 <?php echo form_error('short_title'); ?>
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
    <td class = 'title_td' width="100">Tiêu đề Trang</td>
    <td>
       <input type="text" name="title" value="<?php echo set_value('title','') ?>"  style="width:400px">
        <?php echo form_error('title'); ?> 
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Meta title</td>
    <td>
       <input type="text" name="meta_title" value="<?php echo set_value('meta_title','') ?>"  style="width:400px">
        <?php echo form_error('meta_title'); ?> 
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
    <td class = 'title_td'> Content</td>
    <td><textarea id="editor1" name="content" style="width:400px; height:100px;"  ><?php echo set_value('content','') ?></textarea>
     <?php echo form_error('content'); ?>
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
</td>
<td valign="top">
	<table class="right_new" >
   	  	<tr>
            <td class = 'title_td'>Hình </td>
            <td><input type = 'file' name = 'images' size = "50"></td>
        </tr>
		<?php echo form_error('images'); ?>
		<tr>
			<td class = 'title_td'>Hình 1</td>
			<td><input type = 'file' name = 'images1' size = "50"></td>
		</tr>
	
		<tr>
			<td class = 'title_td'>Hình 2</td>
			<td><input type = 'file' name = 'images2' size = "50"></td>
		</tr>
	
		<tr>
			<td class = 'title_td'>Hình 3</td>
			<td><input type = 'file' name = 'images3' size = "50"></td>
		</tr>
	
		<tr>
			<td class = 'title_td'>Hình 4</td>
			<td><input type = 'file' name = 'images4' size = "50"></td>
		</tr>

       
   	 <tr>
            <td class = 'title_td'>Home</td>
            <td>
            	<select name="hot">
              		<option value="0"  <?php echo set_select('hot', 0); ?>  >Tắt</option>
                	<option value="1"  <?php echo set_select('hot', 1); ?>  >Bật</option>
                    
            	</select>
            </td>
        </tr>
        <tr>
            <td class = 'title_td'>Hot</td>
            <td>
            	<select name="ticnew">
              		<option value="0"  <?php echo set_select('ticnew', 0); ?> >Tắt</option>
                	<option value="1"   <?php echo set_select('ticnew', 1); ?> >Bật</option>
                    
            	</select>
            </td>
        </tr>
        
        <tr>
            <td class = 'title_td'>Bật / Tắt</td>
            <td>
            	<select name="ticlock">
                	<option value="0"  <?php echo set_select('ticlock', '0'); ?> >Bật</option>
                    <option value="1"  <?php echo set_select('ticlock', '1'); ?> >Tắt</option>
            	</select>
            </td>
        </tr>
         <tr>
            <td class = 'title_td'>Sắp xếp</td>
            <td><input type = 'text' name = 'sort' size = '30' value="<?php echo set_value('sort','');  ?>"></td>
        </tr> 
   
        <tr>
            <td class = 'title_td'>Meta Keyword</td>
            <td><textarea name = 'meta_keyword' class="left-tag" ><?php echo set_value('meta_keyword','');  ?></textarea></td>
        </tr> 
        <tr>
            <td class = 'title_td'>Meta Description</td>
            <td><textarea name = 'meta_description' class="left-tag"  ><?php echo set_value('meta_description','');  ?></textarea></td>
        </tr> 
     	<tr>
            <td class = 'title_td'>Tag</td>
            <td><textarea name = 'tag' class="left-tag" ><?php echo set_value('tag','');  ?></textarea></td>
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
if (typeof CKEDITOR == 'undefined') {
	document.write('CKEditor');
}else {
	var editorContent = CKEDITOR.replace('editor1'); 
}
</script>  