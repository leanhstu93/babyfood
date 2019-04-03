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
<?php echo form_open_multipart('admincp/flash/add');?>

<table>
	<tr>
		<td class = 'title_td'>Loại file</td>
		<td>
		<select name = "style">
		<option value = '2' <?php echo set_select('style', '2',TRUE); ?>>Ảnh</option>
        <option value = '1' <?php echo set_select('style', '1'); ?>>Flash</option>
		</select>
        <?php echo form_error('style'); ?>
		</td>
	</tr>
	<tr>
		<td class = 'title_td'>Vị trí</td>
		<td>
		<select name = "location">
			<option value = '2' >Logo PC</option>
            <option value = '5' >Logo Mobile</option>
            <option value = '4' >Banner Left</option>
            <option value = '3' >Slideshow Mobile</option>
            <option value = '6' >Sản phẩm hot Mobile</option>
		</select>
        <?php echo form_error('location'); ?>
		</td>
	</tr>
    <tr>
		<td class = 'title_td'>Bố cục</td>
		<td>
		<select name = "position">
			<option value = '1' >3 cột</option>
            <option value = '2' >1 cột</option>
		</select>
		</td>
	</tr>
	<tr>
		<td class = 'title_td'>File</td>
		<td><input type = 'file' name = 'userfile' size = '50'>
         <?php echo form_error('userfile'); ?>
        </td>
	</tr>
	
	<tr>
		<td class = 'title_td'>Kích thước</td>
		<td>Rộng: <input type = 'text' name = 'width' size = '15'  value = '<?php echo set_value("width",''); ?>'> Cao: <input type = 'text' name = 'height' size = '15'  value = '<?php echo set_value("height",''); ?>'></td>
	</tr>
	<tr>
		<td class = 'title_td'>Link</td>
		<td><input type = 'text' name = 'link' size = '60'  value = '<?php echo set_value('link','');  ?>'></td>
	</tr>
	<tr>
		<td class = 'title_td'>Sắp xếp</td>
		<td><input type = 'text' name = 'sort' size = '10' value = '<?php echo set_value("sort","");?>'></td>
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