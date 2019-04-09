<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Hệ thống / Banner/ <?php echo $map_title ?></td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="content_i">
<?php echo form_open_multipart('admincp/flash/edit/'.$info['Id']);?>

<table>
	<tr>
		<td class = 'title_td'>Loại file</td>
		<td>
		<select name = "style">
		<option value = '2' <?php echo set_select('style', '2',$info['style']==0?TRUE:FALSE); ?>>Ảnh</option>
        <option value = '1' <?php echo set_select('style', '1',$info['style']==0?TRUE:FALSE); ?>>Flash</option>
		</select>
        <?php echo form_error('style'); ?>
		</td>
	</tr>
	<tr>
		<td class = 'title_td'>Vị trí</td>
		<td>
		<select name = "location">
		<option value = '2' <?php if($data['info']['location'] == 2) echo 'selected';?>>Logo PC</option>
        <option value = '5' <?php if($data['info']['location'] == 5) echo 'selected';?>>Logo Mobile</option>
		<option value = '4' <?php if($data['info']['location'] == 4) echo 'selected';?>>Banner left</option>
       	<option value = '3' <?php if($data['info']['location'] == 3) echo 'selected';?>>Slideshow Mobile</option>
        <option value = '6' <?php if($data['info']['location'] == 6) echo 'selected';?>>Sản phẩm nổi bật Mobile</option>
		</select>
        <?php echo form_error('location'); ?>
		</td>
	</tr>
     <tr>
		<td class = 'title_td'>Bố cục</td>
		<td>
		<select name = "position">
			<option value = '1' <?php if($data['info']['position'] == 1) echo 'selected';?>>3 cột</option>
            <option value = '2' <?php if($data['info']['position'] == 2) echo 'selected';?>>1 cột</option>
		</select>
		</td>
	</tr>
	<tr>
		<td class = 'title_td'>File</td>
		<td><input type = 'file' name = 'userfile' size = '50'></td>
	</tr>
	<?php if($info['file_vn']!=""){ ?>
	<tr>
		<td>&nbsp;</td>
		<td><div id = "file_vn">
		<p>
		<?php if($info['style']==1){ ?>
        <embed width="<?php echo $info['width']; ?>" height="<?php echo $info['height']; ?>" menu="true" loop="true" play="true" src="/data/Flash/<?php echo $info['file_vn']; ?>" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed>
        <?php } else { ?>
        <img src="<?php echo PATH_IMG_FLASH.$info['file_vn']; ?>"   />
        <?php } ?>
        </p>
		&nbsp;&nbsp;&nbsp;
		<a href = "javascript: delFlash('flash_model','file_vn',<?php echo $info['Id'];?>,'<?php echo $info['file_vn'];?>')"><img src = "<?php echo ADMIN_PATH_IMG;?>b_drop.png"></a></div>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td class = 'title_td'>Kích thước</td>
		<td>Rộng: <input type = 'text' name = 'width' size = '15'  value = '<?php echo set_value("width",$info['width']); ?>'> Cao: <input type = 'text' name = 'height' size = '15'  value = '<?php echo set_value("height",$info['height']); ?>'></td>
	</tr>
	<tr>
		<td class = 'title_td'>Link</td>
		<td><input type = 'text' name = 'link' size = '60'  value = '<?php echo set_value('link',$info['link']);  ?>'></td>
	</tr>
	<tr>
		<td class = 'title_td'>Sắp xếp</td>
		<td><input type = 'text' name = 'sort' size = '10' value = '<?php echo set_value("sort",$info['sort']);?>'></td>
	</tr>
	<tr>
    	<td></td>
		<th  align = 'center'>
			<button type = 'submit' value = 'save' name = 'save' class="button">Cập nhật</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type = 'reset' value = 'Làm lại' class="button" >
		</th>
	</tr>	
</table>
</form>
</div>
</div>  