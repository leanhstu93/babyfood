<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Thương hiệu / <?php echo $map_title ?></td>
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
    <td> <input type="text" name="title_vn" value="<?php echo $info['title_vn'];?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Danh mục sản phẩm</td>
    <td>
         <select name = 'idcat'>
            <option value = ''>- - Chọn chủ đề - -</option>
             <?php 
				if(!empty($listcat)){
					foreach($listcat  as $row){ 
					
				?>
                <option value="<?php echo $row['Id'] ?>" <?php if($info['idcat']==$row['Id']) echo 'selected'; ?>  ><?php echo $row['title_vn'] ?></option>
               
                <?php }} ?>
        </select>
    </td>
</tr>
<?php if($info['images']!=""){ ?>  
<tr>
	<td class = 'title_td' ></td>
    <td> 
    <img src="<?php echo PATH_IMG_MANUFACTURER.$info['images']; ?>" width="60" />	
     </td>
</tr>
<?php } ?> 	
<tr>
	<td class = 'title_td' >Hình</td>
    <td> <input type="file" name="userfile"   >
     </td>
</tr>
<tr>
	<td class = 'title_td' >Mô tả</td>
    <td> <textarea class="textdes" name="description_vn" id="editor1"><?php echo $info['description_vn']; ?></textarea>
    	 <?php echo form_error('description_vn'); ?>
     </td>
</tr>		
<tr>
	<td class = 'title_td' >Alias</td>
    <td> <input type="text" name="alias" value="<?php echo $info['alias'];?>"  style="width:400px">
   		 <?php echo form_error('alias'); ?>
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