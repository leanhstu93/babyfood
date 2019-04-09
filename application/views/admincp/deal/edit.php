<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Hệ thống / Deal / <?php echo $map_title ?></td>
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
 
         <select name = 'idcat' >
            <option value = ''>- - Chọn chủ đề - -</option>
             <?php
				if(!empty($listcat)){
					foreach($listcat  as $row){ 
					 $sub = $this->pagehtml_model->get_catdeal($row['Id']);
				?>
                <option value="<?php echo $row['Id'] ?>" <?php  if($row['Id'] == $info['idcat']) echo 'selected'; ?> ><?php echo $row['title_vn'] ?></option>
                <?php
					if(!empty($sub)){
						 foreach($sub as $rw){
							  $subchilde = $this->pagehtml_model->get_catdeal($rw['Id']);
				?>
                <option value="<?php echo $rw['Id'] ?>" <?php if($rw['Id'] == $info['idcat']) echo 'selected'; ?>  >--- <?php echo $rw['title_vn'] ?></option> 
					 <?php
                        if(!empty($subchilde)){
                             foreach($subchilde as $rwchild){
                    ?>
                    <option value="<?php echo $rwchild['Id'] ?>" <?php if($rwchild['Id'] == $info['idcat']) echo 'selected'; ?>  >------ <?php echo $rwchild['title_vn'] ?></option> 
                    <?php }} ?>
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
	<td class = 'title_td'>Giá bán</td>
    <td> <input type="text" name="sale_price" value="<?php echo set_value('sale_price',$this->page->bsVndDot($info['sale_price']));  ?>"  style="width:200px" onkeyup="this.value = FormatNumber(this.value);" >
   		 <?php echo form_error('sale_price'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Mô tả</td>
    <td> <textarea  name="description_vn" id ="editor2"><?php echo set_value('description_vn',str_replace("<br />"," \r\n ",$info['description_vn']));  ?></textarea>
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
            <td class = 'title_td'>Mã giảm giá</td>
            <td>
            	<select name="discount_code">
                <option value="">---Chọn mã giảm giá---</option>
                <?php
                	if(isset($discount_code)){
						foreach($discount_code as $discount){
				?>
                    <option value="<?php echo $discount['code']?>" <?php if($discount['code']== $info['discount_code']) echo 'selected="selected"' ?> ><?php echo $discount['code']?></option>
                    <?php }}?>
            	</select>
            </td>
        </tr>
        <tr>
            <td class = 'title_td'>Nơi sử dụng</td>
            <td>
            	<select name="location">
                <option value="">---Chọn địa điểm sử dụng---</option>
                <?php
                	if(isset($location)){
						foreach($location as $row){
				?>
                    <option value="<?php echo $row['id']?>" <?php if($row['id']== $info['location']) echo 'selected="selected"' ?> ><?php echo $row['title']?></option>
                    <?php }}?>
            	</select>
            </td>
        </tr>
        <tr>
            <td class = 'title_td'>Deal giá sốc</td>
            <td>
            	<select name="home">
                <option value="">---Chọn hiện thị---</option>
                    <option value="0" <?php if($info['home']== '0') echo 'selected="selected"' ?> >Deal giá sốc</option>
                    <option value="1" <?php if($info['home']== '1') echo 'selected="selected"' ?> >Deal thường</option>
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
	var editorContent = CKEDITOR.replace('editor2'); 
}
</script>  