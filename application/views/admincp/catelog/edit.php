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
<tr>
    <td class = 'title_td' width="100">Chủ đề</td>
    <td>
         <select name = 'parentid'>
            <option value = ''>- - Chọn chủ đề - -</option>
             <?php 
				if(!empty($listcat)){
					foreach($listcat  as $row){ 
					 $sub = $this->pagehtml_model->get_catelog($row['Id']);
				?>
                <option value="<?php echo $row['Id'] ?>" <?php if($info['parentid']== $row['Id']) echo 'selected'; ?> ><?php echo $row['title_vn'] ?></option>
                <?php
					if(!empty($sub)){
						 foreach($sub as $rw){
				?>
                <option value="<?php echo $rw['Id'] ?>" <?php if($info['parentid']== $rw['Id']) echo 'selected'; ?> >--- <?php echo $rw['title_vn'] ?></option> 
                <?php }}}} ?>
        </select>
    </td>
</tr>
<?php if($info['images']!=''){?>
<tr>
	<td class="title_td"></td>
    <td>
    <img width="90" src="/data/Catelog/<?php echo $info['images']?>" />
    </td>
</tr>
<?php }?>
<tr>
	<td class = 'title_td' >Hình ảnh menu PC </td>
    <td> <input type="file" name="photo"  style="width:400px">
     </td>
</tr>
<?php if($info['images1']!=''){?>
<tr>
	<td class="title_td"></td>
    <td>
    	<img width="90" src="/data/Catelog/<?php echo $info['images1']?>" />
    </td>
</tr>
<?php }?>
<tr>
	<td class = 'title_td' >Hình ảnh home Mobile</td>
    <td> <input type="file" name="images1"  style="width:400px">
     </td>
</tr>
<tr>
	<td class = 'title_td' >Tiêu đề</td>
    <td> <input type="text" name="title_vn" value="<?php echo set_value('title_vn',$info['title_vn']) ?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Tiêu đề ngắn gọn</td>
    <td> <input type="text" name="short_title" value="<?php echo set_value('short_title',$info['short_title']) ?>"   style="width:400px">
   		 <?php echo form_error('short_title'); ?>
     </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Mã màu</td>
    <td>
       <input type="text" name="style" value="<?php echo set_value('style',$info['style']) ?>"  style="width:400px">
        <?php echo form_error('style'); ?> 
    </td>
</tr>
<tr>
	<td class = 'title_td' >Alias</td>
    <td> <input type="text" name="alias" value="<?php echo $info['alias']; ?>"  style="width:400px"> 
     	<?php echo form_error('alias'); ?>
     </td>
</tr>

<tr>
    <td class = 'title_td' width="100">Tiêu đề Trang</td>
    <td>
       <input type="text" name="title" value="<?php echo $info['title']; ?>"  style="width:400px">
        <?php echo form_error('title'); ?> 
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Meta title</td>
    <td>
       <input type="text" name="meta_title" value="<?php echo set_value('meta_title',$info['meta_title']) ?>"  style="width:400px">
        <?php echo form_error('meta_title'); ?> 
    </td>
</tr>
<tr>
    <td class = 'title_td'> Meta Keyword</td>
    <td><textarea name="meta_keyword" style="width:400px; height:100px;" ><?php echo $info['meta_keyword'] ?></textarea>
     <?php echo form_error('meta_keyword'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td'> Meta Description</td>
    <td><textarea name="meta_description" style="width:400px; height:100px;"  ><?php echo $info['meta_description']; ?></textarea>
     <?php echo form_error('meta_description'); ?>
     </td>
</tr>
<tr>
    <td class = 'title_td'> Content</td>
    <td><textarea id="editor1" name="content" style="width:400px; height:100px;"  ><?php echo $info['content']; ?></textarea>
     <?php echo form_error('content'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Sắp xếp</td>
    <td> <input type="text" name="sort" value="<?php echo $info['sort']; ?>"  style="width:200px">
   		 <?php echo form_error('sort'); ?>
     </td>
</tr>

<tr>
	<td class = 'title_td' >Khóa</td>
    <td> <input type="checkbox" value="1" name="ticlock"  <?php if($info['ticlock']==1) echo 'checked'; ?> /> </td>
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
<script type="text/javascript">
if (typeof CKEDITOR == 'undefined') {
	document.write('CKEditor');
}else {
	var editorContent = CKEDITOR.replace('editor1'); 
}
</script>  