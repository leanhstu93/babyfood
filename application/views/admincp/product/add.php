<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Hệ thống / Sản phẩm / <?php echo $map_title ?></td>
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
         <select name = 'idcat'>
            <option value = ''>- - Chọn chủ đề - -</option>
            <?php echo $this->page->TreeCat($listcat,0,"",set_value('idcat',''),"--");?>
        </select>
         <?php echo form_error('idcat'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Tiêu đề</td>
    <td> <input type="text" name="title_vn" value="<?php echo set_value('title_vn','');  ?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>

<tr>
	<td class = 'title_td' >Alias</td>
    <td> <input type="text" name="alias" value="<?php echo set_value('alias','');  ?>"  style="width:400px">
   		 <?php echo form_error('alias'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td'>Giá gốc</td>
    <td> <input type="text" name="price" value="<?php echo set_value('price','');  ?>"  style="width:200px" onkeyup="this.value = FormatNumber(this.value);" >
   		 <?php echo form_error('price'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td'>Giá bán</td>
    <td> <input type="text" name="sale_price" value="<?php echo set_value('sale_price','');  ?>"  style="width:200px" onkeyup="this.value = FormatNumber(this.value);" >
   		 <?php echo form_error('sale_price'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td'>Mã SP</td>
    <td> <input type="text" name="codepro" value="<?php echo set_value('codepro','');  ?>"  style="width:200px" >
   		 <?php echo form_error('codepro'); ?>
     </td>
</tr>
    <tr>
        <td class="title_td">Kho hàng</td>
        <td>
            <select name="status">
                <option value="0">Còn hàng</option>
                <option value="1" >Hết hàng</option>
            </select>
        </td>
    </tr>
<tr>
    <td class = 'title_td' width="100">Thương hiệu</td>
    <td>
 
         <select name = 'idmanufacturer'  >
            <option value = ''>- - Chọn nhà sản xuất - -</option>
             <?php
				if(!empty($manufacturer)){
					foreach($manufacturer  as $row){ 
				?>
                <option value="<?php echo $row['Id'] ?>" <?php echo set_select('idmanufacturer', $row['Id']); ?> ><?php echo $row['title_vn'] ?></option>
               
                <?php }} ?>
        </select>
         <?php echo form_error('idmanufacturer'); ?>
    </td>
</tr>
<!--<tr>
	<td class = 'title_td' >Màu sắc</td>
    <td> 
    <div class="cont-filter-attr">
    <ul class="active">
	<?php
    if(!empty($lcolor)){
    foreach($lcolor as $item){
    ?>
    <li class="category_id-1">
    <label>
     <input value="<?php echo $item['Id'] ?>" type="checkbox" name="color[]"   <?php echo set_checkbox('color[]', $item['Id']); ?> >
        <span class="checkbox"><span  style="background-color:<?php echo $item['color'] ?>"></span></span>
    </label>
    </li>
    <?php }} ?>                                         
    </ul>
    </div>
     </td>
</tr>	
<tr>
	<td class = 'title_td' >Kích thước</td>
    <td> 
    	<div class="cont-filter-attr">
    <ul class="active">
    <?php
	if(!empty($lsize)){
		foreach($lsize as $item){
	?>
                <li class="category_id-1">
                <label>
                 <input value="<?php echo $item['Id'] ?>" type="checkbox" name="size[]" <?php echo set_checkbox('size[]', $item['Id']); ?> >
                    <span class="checkbox"><span><?php echo $item['title_vn'] ?></span></span>
                </label>
            </li>
    <?php }} ?>                                      
    </ul>
    </div>
     </td>
</tr>-->	
<tr>
	<td class = 'title_td' >Mô tả</td>
    <td> <textarea id="editor2" name="description_vn"><?php echo set_value('description_vn','');  ?></textarea>
    	 <?php echo form_error('description_vn'); ?>
     </td>
</tr>	
<!--<tr>
  <td class = 'title_td' >Thông số kỹ thuật</td>
  <td><textarea  name="digital" id ="editor3"><?php echo set_value('digital',"");  ?></textarea>
    <?php echo form_error('digital'); ?></td>
</tr>-->			
<tr>
	<td class = 'title_td'> Chi tiết</td>
    <td> <textarea id="editor1" name="content_vn"><?php echo set_value('content_vn','');  ?></textarea>
    	 <?php echo form_error('content_vn'); ?>
     </td>
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
                  <td class = 'title_td' >Meta title</td>
                  <td><input type="text" name="meta_title" value="<?php echo set_value('meta_title', '');  ?>"  style="width:400px">
                    <?php echo form_error('meta_title'); ?></td>
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

	var editorContent = CKEDITOR.replace('editor2'); 
	var editorContent = CKEDITOR.replace('editor3');

}
</script>  