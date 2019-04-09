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
	<td class = 'title_td' >Mã sản phẩm</td>
    <td> <input type="text" name="codepro" value="<?php echo set_value('codepro','');  ?>"  style="width:400px">
   		 <?php echo form_error('codepro'); ?>
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
	<td class = 'title_td'>Giá niêm yết</td>
    <td> <input type="text" name="price" value="<?php echo set_value('price','');  ?>"  style="width:200px" onkeyup="this.value = FormatNumber(this.value);" >
   		 <?php echo form_error('price'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td'>Giá</td>
    <td> <input type="text" name="sale_price" value="<?php echo set_value('sale_price','');  ?>"  style="width:200px" onkeyup="this.value = FormatNumber(this.value);" >
   		 <?php echo form_error('sale_price'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Mô tả</td>
    <td> <textarea id="editor2" name="description_vn"><?php echo set_value('description_vn','');  ?></textarea>
    	 <?php echo form_error('description_vn'); ?>
     </td>
</tr>			
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
            <td class = 'title_td'>Title page</td>
            <td><input type = 'text' name = 'titlepage' size = '30' value="<?php echo set_value('titlepage','');  ?>"></td>
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
	editorContent.config.width = 700;
	editorContent.config.height = 200;
	CKFinder.setupCKEditor( editorContent,'<?php echo BASE_URL ?>public/ck/ckfinder/');
	var editorContent = CKEDITOR.replace('editor2'); 
	editorContent.config.width = 700;
	editorContent.config.height = 200;
	CKFinder.setupCKEditor( editorContent,'<?php echo BASE_URL ?>public/ck/ckfinder/');
}
</script>  