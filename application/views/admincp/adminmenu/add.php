<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Hệ thống / Admin Menu/ <?php echo $map_title ?></td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="content_i">
<?php
$images = null;
?>
<form method="post" name="add-new" action="<?php  echo base_url('admincp/adminmenu/add');  ?>" enctype="multipart/form-data">
<table>
<tr>
    <td class = 'title_td' width="100">Chủ đề</td>
    <td>
        <select name = 'parentid'>
            <option value = '0' <?php echo set_select('parentid', '0', TRUE); ?> >- - Chọn nhóm cha - -</option>
			<option value="1"  <?php echo set_select('parentid', '1'); ?> >- - Hệ thống - -</option>
            <option value="2" <?php echo set_select('parentid', '2'); ?> >- - Quản lý nội dung - -</option>
            <option value="3" <?php echo set_select('parentid', '3'); ?>>- - Quản lý cửa hàng - -</option>
            <option value="4" <?php echo set_select('parentid', '4'); ?> >- - Thống kê - -</option>
        </select>
       <?php echo form_error('parentid'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Admin menu</td>
    <td> <input type="text" name="title_vn" value="<?php echo set_value('title_vn','') ?>"  style="width:400px"> 
     <?php echo form_error('title_vn'); ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Route</td>
    <td> <input type="text" name="route" value="<?php echo set_value('route','') ?>"  style="width:400px">
    	<?php echo form_error('route'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Thứ tự</td>
    <td> <input type="text" name="sort" value="<?php echo set_value('sort',0) ?>"  style="width:400px"> 
    	<?php echo form_error('sort'); ?>
    </td>
</tr>

<tr>
	<td class = 'title_td' >Hình ảnh</td>
    <td> <input type="text" name="images"  id="id_image"  value="<?php echo set_value('images','') ?>"  style="width:400px"> 
    	<?php echo form_error('images'); ?>
    </td>
</tr>
<tr>
<td class = 'title_td' ></td>
	<td>
    <?php 
    echo "<div style='background-color:#fff; width:100%; 
		min-height:100px; border:1px solid #ddd; overflow:hidden;
		padding:5px 0 10px 0;'>";
	
		$dirs = dir(FCPATH ."public/template/admin/images/adminmenu");
		
		while($entry = $dirs->read())
		{
			if ($entry == '.' or $entry =='..')
				continue;
				
			$entry_path =FCPATH."public/template/admin/images/adminmenu/".$entry;
			
			if ( ! is_dir($entry_path))
			{
				$photo = array();
				$filetype = strtolower(substr($entry, strrpos($entry,'.')+1));
				
				$filesize = filesize($entry_path);
				$photo["name"] = $entry;
				$photo["type"] = '.'.$filetype;
				$photo["size"] = $filesize;
				
				if ($filetype == "jpg" || $filetype == "png" || $filetype == "gif")
				{
					echo "<div class='wrapper_image'>";
					
					if ($images == $photo["name"])
					{
						echo '<img src="'.ADMIN_PATH_IMG."adminmenu/".$photo["name"].'" class="icon hightlight" alt="'.$photo["name"].'" />';
					}else{
						echo '<img src="'.ADMIN_PATH_IMG."adminmenu/".$photo["name"].'" class="icon" alt="'.$photo["name"].'" />';
					}
					echo "</div>";
				}
			}
		}
	echo "</div>";
           ?>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Khóa</td>
    <td> <input type="checkbox" value="1" name="ticlock"  <?php echo set_checkbox('ticlock', '1'); ?>  /> </td>
</tr>
<tr>
<td  ></td>
    <th align = 'left'>
       <button type = 'submit' name="save"  value="save" class="button" >Thêm mới</button> &nbsp;&nbsp;&nbsp;&nbsp;
        <input type = 'reset' value = 'Làm lại' class="button">
    </th>
</tr>	
</table>
</form> 
</div>
</div>  
<script language="javascript">
$(document).ready(function(){
	$('.icon').click(function(){
		var txt_image = document.getElementById("id_image");
		txt_image.value = this.alt;
		//alert(this.alt);
	});
});
</script>   