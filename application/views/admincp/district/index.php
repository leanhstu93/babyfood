<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    	<i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Địa điểm  </td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="list_button">
<a href='<?php echo base_url('admincp/district/add');  ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>icon-16-plus.png'> Thêm mới</a>
<form action="<?php echo base_url('admincp/district/index'); ?>" method="get">
<table cellpadding="0" style="float:left">
<tbody>
<td>
</td>
<td> 
<select name="idcat">
	<option value="0">Tất cả Tỉnh/ Thành phố</option>
	<?php
    if(!empty($listcat)){
        foreach($listcat  as $row){ 
    ?>
    <option value="<?php echo $row['Id'] ?>" <?php if($idcat == $row['Id']) echo "selected"; ?> ><?php echo $row['title_vn'] ?></option>

    <?php }} ?>
</select>
<input type="text" value="<?php if($tukhoa !='0') echo $tukhoa; ?>" placeholder="Từ khóa" size="20" name="tukhoa" /> </td>
<td> <input type="submit" value="Tìm kiếm" name="btntimkiem" class="button" /></td>
</tbody>
</table>
</form>
</div>
<form action = '<?php echo base_url('admincp/district/delete');  ?>' method = 'post'  name="rowsForm" id="rowsForm">
<table class="view">
	<tr>
		<th width="50"><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
		<th width="50">ID</th>
		<th>Tiêu đề</th>
         <th>Free ship<span style="color:#f00">*</span> </th>
        <th>Phí giao hàng</th>
        <th>Tỉnh/ Thành phố</th>
        <th>Sắp xếp</th>
		<th width="100">Bật / Tắt</th>
		<th width="100" colspan="2">Hành động</th>
	</tr>
    <?php
	if(empty($info)){
	?>
    <tr>
		<td colspan = '10' class = 'emptydata'>Không có dữ liệu</td>
	</tr>
    <?php }else{
		 foreach ($info as $item) { 
			$imgdel = ADMIN_PATH_IMG."b_drop.png";
			$imgedit = ADMIN_PATH_IMG."b_edit.png";
			$imgnondefault = ADMIN_PATH_IMG."icon-16-nondefault.png";
			$imgdefault = ADMIN_PATH_IMG."icon-16-default.png";
			$imgremove = ADMIN_PATH_IMG."icon-16-remove.png";
			$imgtick = ADMIN_PATH_IMG."icon-16-tick.png";
			$urledit = base_url('admincp/district/edit/'.$item['Id']);
			$urldel = base_url('admincp/district/delete/'.$item['Id']); 
	?>
      <tr>
			<td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item['Id'];?>"><br></td>
			<td><?php echo $item['Id']; ?></td>
            <td align="left"><a href = '<?php echo $urledit?>'><?php echo $item['title_vn']; ?></a></td>
            <td align = 'center'>
			<?php 
            if($item['free'] == 1){
                echo "<div id = 'free".$item['Id']."'><a href = 'javascript: hideshow(\"district_model\",\"free\",\"".$item['Id']."\",\"0\",\"free".$item['Id']."\");' title = 'Bỏ khóa'><img src = '".ADMIN_PATH_IMG."icon-16-default.png'></a></div>";
            }else{
                echo "<div id = 'free".$item['Id']."'><a href = 'javascript: hideshow(\"district_model\",\"free\",\"".$item['Id']."\",\"1\",\"free".$item['Id']."\");' title = 'Khóa user'><img src = '".ADMIN_PATH_IMG."icon-16-nondefault.png'></a></div>"; 	 
            }
            ?>
            </td>
            <td><?php echo $this->page->bsVndDot($item['ship']); ?></td>
            <td><?php echo $item['tinh']; ?></td>
            <td  width="100"><input type="text" size="1" value="<?php echo $item['sort']; ?>" name="sort[<?php echo  $item['Id']; ?>]"  style="text-align:center"/></td>
			 <td align = 'center'>
			<?php 
            if($item['ticlock'] == "1"){
                echo "<div id = '".$item['Id']."'><a href = 'javascript:ticlockactive(\"district_model\",\"ticlock\",\"".$item['Id']."\",\"0\");' title = 'Bỏ khóa'><img src = '".$imgremove."'></a></div>";
            }else{
                echo "<div id = '".$item['Id']."'><a href = 'javascript:ticlockactive(\"district_model\",\"ticlock\",\"".$item['Id']."\",\"1\");' title = 'Khóa tin'><img src = '".$imgtick."'></a></div>"; 
            }
            ?>
            </td>
			<td align = 'center' width="50"><a href = '<?php echo $urledit;?>'><img src = '<?php echo ADMIN_PATH_IMG;?>b_edit.png'></a></td>
            <td align = 'center' width="50"><a href = '<?php echo $urldel;?>'><img src = '<?php echo $imgdel;?>'></a></td>
		</tr>
    <?php }} ?>
</table>
<p style="font-size:11px; text-align:left; padding:5px;"><b style="color:#f00">*</b>Chỉ áp dụng với đơn hàng hơn có giá trị hơn 150.000đ</p>
<div class="frm-paging">
<span class="total">Tổng số: <b><?php echo $total; ?></b> </span>
<?php 
if(!empty($page)) echo $page;
?>
</div>
<div class="list_button">
<a href='<?php echo  base_url('admincp/district/add'); ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>/icon-16-plus.png'> Thêm mới</a>
<a href = 'javascript:CheckAll(document.rowsForm.check_list)'  class="button">Check all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href = 'javascript:UnCheckAll(document.rowsForm.check_list)'  class="button">Uncheck all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmDelete('Bạn thật sự muốn xóa',document.rowsForm.check_list)"  class="button">Delete</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmSave('Bạn có chắc muốn lưu lại','<?php echo  base_url('admincp/district/save');?>')" class="button">Save</a>
</div>
</form>
</div>
