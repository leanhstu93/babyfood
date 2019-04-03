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
	<td class = 'title_td' >Shop</td>
    <td><?php echo $user[0]['username']; ?></td>
</tr>	
<tr>
	<td class = 'title_td' >Tình trạng</td>
    <td> 
    	<select name="status_check">
    		<option value="0" <?php echo set_select('status_check', '0',$info['status_check']==0?TRUE:FALSE); ?> >Đang chờ duyệt</option>
            <option value="1" <?php echo set_select('status_check', '0',$info['status_check']==1?TRUE:FALSE); ?> >Đã được duyệt</option>
            <option value="2" <?php echo set_select('status_check', '0',$info['status_check']==2?TRUE:FALSE); ?> >Không được duyệt</option>
    	</select>
   		 <?php echo form_error('status_check'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Lý do không duyệt</td>
    <td> <textarea name="note" style="width:400px; height:50px;" ><?php echo set_value('note',$info['note']);  ?></textarea>
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Chủ đề</td>
    <td>
         <select name = 'idcat'>
            <option value = ''>- - Chọn chủ đề - -</option>
             <?php
				if(!empty($listcat)){
					foreach($listcat  as $row){ 
					 $sub = $this->pagehtml_model->get_catelog($row['Id']);
				?>
                <option value="<?php echo $row['Id'] ?>" <?php if($info['idcat']== $row['Id']) echo 'selected'; ?> ><?php echo $row['title_vn'] ?></option>
                <?php
					if(!empty($sub)){
						 foreach($sub as $rw){
				?>
                <option value="<?php echo $rw['Id'] ?>" <?php if($info['idcat']== $rw['Id']) echo 'selected'; ?> >--- <?php echo $rw['title_vn'] ?></option> 
                <?php }}}} ?>
        </select>
         <?php echo form_error('idcat'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Tiêu đề</td>
    <td> <input type="text" name="title_vn" value="<?php echo set_value('title_vn',$info['title_vn']);  ?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Alias</td>
    <td> <input type="text" name="alias" value="<?php echo set_value('alias',$info['alias']);  ?>"  style="width:400px">
   		 <?php echo form_error('alias'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td'>Giá gốc</td>
    <td> <input type="text" name="price" value="<?php echo set_value('price',$this->page->bsVndDot($info['price']));  ?>"  style="width:200px" onkeyup="this.value = FormatNumber(this.value);" >
   		 <?php echo form_error('price'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td'>Giá</td>
    <td> <input type="text" name="sale_price" value="<?php echo set_value('sale_price',$this->page->bsVndDot($info['sale_price']));  ?>"  style="width:200px" onkeyup="this.value = FormatNumber(this.value);" >
   		 <?php echo form_error('sale_price'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Mô tả</td>
    <td> <textarea  name="description_vn" style="width:400px; height:50px;"><?php echo set_value('description_vn',str_replace("<br />"," \r\n ",$info['description_vn']));  ?></textarea>
    	 <?php echo form_error('description_vn'); ?>
     </td>
</tr>			
<tr>
	<td class = 'title_td' >Chi tiết</td>
    <td> <textarea id="editor1" name="content_vn"><?php echo set_value('content_vn',$info['content_vn']);  ?></textarea>
    	 <?php echo form_error('content_vn'); ?>
     </td>
</tr>		
<tr>
<td  ></td>
    <th align = 'left'>
       <button type = 'submit' name="save" value="save"  class="button" >Cập nhật</button> &nbsp;&nbsp;&nbsp;&nbsp;
        <input type = 'reset' value = 'Làm lại' class="button">
    </th>
</tr>	
</table>
</td>
<td valign="top">
	<table class="right_new" >
     	<?php if(!empty($info['images'])){?>
    	<tr>
            <td class = 'title_td'></td>
            <td>
            <div id="images">
            <img src="<?php echo PATH_IMG_PRODUCT.$info['images']; ?>"  width="60"/>
            	<a href="javascript: delFlash('product_model','images',<?php echo $info['Id'] ?>,'images')"><img src="<?php echo ADMIN_PATH_IMG; ?>b_drop.png"></a>
             </div>
            </td>
        </tr>
        <?php } ?>
   	  	<tr>
            <td class = 'title_td'>Hình </td>
            <td><input type = 'file' name = 'images' size = "50"></td>
        </tr>
		<?php echo form_error('images'); ?>
        <?php if(!empty($info['images1'])){?>
        <tr>
            <td class = 'title_td'></td>
            <td>
            <div id="images1">
            <img src="<?php echo PATH_IMG_PRODUCT.$info['images1']; ?>"  width="60"/>
            	<a href="javascript: delFlash('product_model','images1',<?php echo $info['Id'] ?>,'images1')"><img src="<?php echo ADMIN_PATH_IMG; ?>b_drop.png"></a>
             </div>
            </td>
        </tr>
        <?php } ?>
		<tr>
			<td class = 'title_td'>Hình 1</td>
			<td><input type = 'file' name = 'images1' size = "50"></td>
		</tr>
         <?php if(!empty($info['images2'])){?>
		<tr>
            <td class = 'title_td'></td>
            <td>
            <div id="images2">
            <img src="<?php echo PATH_IMG_PRODUCT.$info['images2']; ?>"  width="60"/>
            	<a href="javascript: delFlash('product_model','images2',<?php echo $info['Id'] ?>,'images2')"><img src="<?php echo ADMIN_PATH_IMG; ?>b_drop.png"></a>
             </div>
            </td>
        </tr>
        <?php } ?>
		<tr>
			<td class = 'title_td'>Hình 2</td>
			<td><input type = 'file' name = 'images2' size = "50"></td>
		</tr>
         <?php if(!empty($info['images3'])){?>
		<tr>
            <td class = 'title_td'></td>
            <td>
            <div id="images3">
            <img src="<?php echo PATH_IMG_PRODUCT.$info['images3']; ?>"  width="60"/>
            	<a href="javascript: delFlash('product_model','images3',<?php echo $info['Id'] ?>,'images3')"><img src="<?php echo ADMIN_PATH_IMG; ?>b_drop.png"></a>
             </div>
             </td>
        </tr>
        <?php } ?>
		<tr>
			<td class = 'title_td'>Hình 3</td>
			<td><input type = 'file' name = 'images3' size = "50"></td>
		</tr>
         <?php if(!empty($info['images4'])){?>
		<tr>
            <td class = 'title_td'></td>
            <td>
            <div id="images4">
            <img src="<?php echo PATH_IMG_PRODUCT.$info['images4']; ?>"  width="60"/>
            	<a href="javascript: delFlash('product_model','images4',<?php echo $info['Id'] ?>,'images4')"><img src="<?php echo ADMIN_PATH_IMG; ?>b_drop.png"></a>
             </div>
            </td>
        </tr>
        <?php } ?>
		<tr>
			<td class = 'title_td'>Hình 4</td>
			<td><input type = 'file' name = 'images4' size = "50"></td>
		</tr>

       
   	 <tr>
            <td class = 'title_td'>Home</td>
            <td>
            	<select name="hot">
              		<option value="0"  <?php echo set_select('hot', 0,$info['hot']==0?TRUE:FALSE); ?>  >Tắt</option>
                	<option value="1"  <?php echo set_select('hot', 1,$info['hot']==1?TRUE:FALSE); ?>  >Bật</option>
                    
            	</select>
            </td>
        </tr>
        <tr>
            <td class = 'title_td'>Bật / Tắt</td>
            <td>
            	<select name="ticlock">
                	<option value="0"  <?php echo set_select('ticlock', '0',$info['ticlock']==0?TRUE:FALSE); ?> >Bật</option>
                    <option value="1"  <?php echo set_select('ticlock', '1',$info['ticlock']==1?TRUE:FALSE); ?> >Tắt</option>
            	</select>
            </td>
        </tr>
         <tr>
            <td class = 'title_td'>Sắp xếp</td>
            <td><input type = 'text' name = 'sort' size = '30' value="<?php echo $info['sort'];  ?>"></td>
        </tr> 
     	<tr>
            <td class = 'title_td'>Title page</td>
            <td><input type = 'text' name = 'titlepage' size = '30' value="<?php echo $info['titlepage'];  ?>"></td>
        </tr> 
        <tr>
            <td class = 'title_td'>Meta Keyword</td>
            <td><textarea name = 'meta_keyword' class="left-tag" ><?php echo $info['meta_keyword'];  ?></textarea></td>
        </tr> 
        <tr>
            <td class = 'title_td'>Meta Description</td>
            <td><textarea name = 'meta_description' class="left-tag"  ><?php echo $info['meta_description'];  ?></textarea></td>
        </tr> 
     	<tr>
            <td class = 'title_td'>Tag</td>
            <td><textarea name = 'tag' class="left-tag" ><?php echo $info['tag'];  ?></textarea></td>
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