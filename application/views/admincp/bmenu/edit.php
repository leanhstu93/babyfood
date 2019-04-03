<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Banner menu / <?php echo $map_title ?></td>
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
	<td class = 'title_td' >Danh mục</td>
    <td> <select name="parentid">
    	<option value="">Chọn danh mục hiển thị</option>
        <?php
		if(!empty($catlist)){
			foreach($catlist as $item){
		?>
        <option value="<?php echo $item['Id'] ?>" <?php echo set_select('idcat',$item['Id'],($info['parentid']==$item['Id'])?TRUE:FALSE) ?>><?php echo $item['title_vn'] ?></option>
        <?php }} ?>
    	</select>
   		 <?php echo form_error('parentid'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Vị trí</td>
    <td> <select name="style">
    	<option value="" >Chọn vị trí hiển thị</option>
        <option value="1" <?php echo set_select('style',1,($info['style']==1)?TRUE:FALSE) ?> >Cột 1</option>
        <option value="2" <?php echo set_select('style',2,($info['style']==2)?TRUE:FALSE) ?>>Cột 2</option>
    	</select>
   		 <?php echo form_error('style'); ?>
     </td>
</tr>
<?php
if($info['images']!=""){ 
?>
<tr>
	<td class = 'title_td' ></td>
    <td> <div id="images"><img src="<?php echo '/data/Banner/'.$info['images']; ?>" >
    	
            	<a href="javascript: delFlash('bmenu_model','images',<?php echo $info['Id'] ?>,'images')"><img src="<?php echo ADMIN_PATH_IMG; ?>b_drop.png"></a>
          </div>
    </td>
</tr>
<?php } ?>
<tr>
	<td class = 'title_td' >Hình ảnh</td>
    <td> <input type="file" name="userfile">
   		 <?php echo form_error('userfile'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Link</td>
    <td> <input type="text" name="link" value="<?php echo set_value('link',$info['link']) ?>"  style="width:400px">
   		 <?php echo form_error('link'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Sắp xếp</td>
    <td> <input type="text" name="sort" value="<?php echo $info['sort'] ?>"  style="width:200px">
   		 <?php echo form_error('sort'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Khóa</td>
    <td> <input type="checkbox" value="1" name="ticlock" <?php if($info['ticlock']==1) echo 'checked'; ?> /> </td>
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