<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    	<i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Hệ thống / Thành viên quản trị  </td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="list_button">
<a href='<?php echo base_url('admincp/admin/add');  ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>icon-16-plus.png'> Thêm mới</a>
</div>
<form action = '<?php echo base_url('admincp/admin/delete');  ?>' method = 'post'  name="rowsForm" id="rowsForm">
<table class="view">
	<tr>
		<th width="50"><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
		<th>ID</th>
		<th>Username</th>
		<th>Email</th>
        <th>Cấp độ</th>   
		<th width="100">Bật / Tắt</th>
		<th colspan = '100'>Hành động</th>
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
			$urledit = base_url('admincp/admin/edit/'.$item->Id);
			$urldel = base_url('admincp/admin/delete/'.$item->Id); 
	?>
       <tr>
            <td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item->Id;?>"></td>
            <td><?php echo $item->Id; ?></td>
            <td align="left" style="padding-left:5px;"><a href = '<?php echo $urledit ?>' title = 'Sửa'><?php echo $item->username; ?></a></td>
                <td><?php echo $item->email; ?></td>
                 <td>
                 <?php
                    if($item->level==1) echo 'Administrator';
                    if($item->level==2) echo 'Mod';
					if($item->level==3) echo 'Writer';
                 ?>
                 </td>
                <td align = 'center'>
                <?php 
                if($item->ticlock == "1"){
                    echo "<div id = '".$item->Id."'><a href = 'javascript:ticlockactive(\"admin_model\",\"ticlock\",\"".$item->Id."\",\"0\");' title = 'Bỏ khóa'><img src = '".$imgremove."'></a></div>";
                }else{
                    echo "<div id = '".$item->Id."'><a href = 'javascript:ticlockactive(\"admin_model\",\"ticlock\",\"".$item->Id."\",\"1\");' title = 'Khóa tin'><img src = '".$imgtick."'></a></div>"; 
                }
                ?>
                </td>
                <td align = 'center' width="50"><a href = '<?php echo $urledit ?>' title = 'Sửa'><img src = '<?php echo $imgedit ?>'></a></td>
                <td align = 'center' width="50"><a href = '<?php echo $urldel;?>' title = 'Xóa' onclick = 'javascript:thongbao("Bạn có chắc muốn xóa dòng này");'><img src = '<?php echo $imgdel ?>'></a></td>
        </tr>
    <?php }} ?>
</table>
<div class="frm-paging">
<span class="total">Tổng số: <b><?php echo $total; ?></b> </span>
<?php 
echo $this->pagination->create_links();
?>
</div>
<div class="list_button">
<a href='<?php echo  base_url('admincp/admin/add'); ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>/icon-16-plus.png'> Thêm mới</a>
<a href = 'javascript:CheckAll(document.rowsForm.check_list)'  class="button">Check all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href = 'javascript:UnCheckAll(document.rowsForm.check_list)'  class="button">Uncheck all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmDelete('Bạn thật sự muốn xóa',document.rowsForm.check_list)"  class="button">Delete</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmSave('Bạn có chắc muốn lưu lại','<?php echo  base_url('admincp/admin/save');?>')" class="button">Save</a>
</div>
</form>
</div>
