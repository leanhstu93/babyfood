<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    	<i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Quản lý nội dung / Người bán  </td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="list_button">
<form method="get" action = "<?php echo base_url('admincp/reseller');?>" >
	<input type="text" value="<?php if($tukhoa!=-1) echo  $tukhoa ?>" placeholder="Nhập họ tên / tài khoản / email" name="tukhoa" size="50" style="float:left; margin-right:5px;" /> 
    <select name="type_search" style="float:left; margin-right:5px;">
    	<option value="0">Tìm gần đúng</option>
        <option value="1">Tìm chính xác</option>
    </select>
    <input type="submit" value="Tìm kiếm" name="btntimkiem"  class="button"  />
</form>
</div>
<form action = '<?php echo base_url('admincp/reseller/delete');  ?>' method = 'post'  name="rowsForm" id="rowsForm">
<table class="view">
	<tr>
		<th width="30"><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
		<th width="50"><span onClick="javascript:sortOrder('id','<?php if($this->session->userdata('sortuser')=='id asc') echo 0; else echo 1; ?>');" style="cursor:pointer">id</span></th>
        <th><span onClick="javascript:sortOrder('fullname','<?php if($this->session->userdata('sortuser')==' fullname asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Tên Shop</span></th>
        <th><span onClick="javascript:sortOrder('username','<?php if($this->session->userdata('sortuser')==' username asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Username</span></th>
        <th><span onClick="javascript:sortOrder('email','<?php if($this->session->userdata('sortuser')==' email asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Email</span></th>
        <th width="150"><span onClick="javascript:sortOrder('phone','<?php if($this->session->userdata('sortuser')=='phone asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Điện thoại</span></th>
        <th width="150"><span onClick="javascript:sortOrder('catelog','<?php if($this->session->userdata('sortuser')=='catelog asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Cung cấp</span></th>
         <th width="100"><span onClick="javascript:sortOrder('total','<?php if($this->session->userdata('sortuser')=='total asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Sản phẩm</span></th>
        <th width="100"><span onClick="javascript:sortOrder('date','<?php if($this->session->userdata('sortuser')=='date asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Ngày đăng ký</span></th>
         <th width="80"><span onClick="javascript:sortOrder('auto_check','<?php if($this->session->userdata('sortuser')=='auto_check asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Tự động duyệt</span></th>
         <th width="80"><span onClick="javascript:sortOrder('lock','<?php if($this->session->userdata('sortuser')=='lock asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Khóa</span></th>
        <th width="80"><span onClick="javascript:sortOrder('ticlock','<?php if($this->session->userdata('sortuser')=='ticlock asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Kích hoạt</span></th>
        <th colspan = '2'>Hành động</th>
	</tr>
    <?php
	if(empty($info)){
	?>
    <tr>
		<td colspan = '18' class = 'emptydata'>Không có dữ liệu</td>
	</tr>
    <?php }else{
		 foreach ($info as $item) { 
			$imgdel = ADMIN_PATH_IMG."b_drop.png";
			$imgedit = ADMIN_PATH_IMG."b_edit.png";
			$imgnondefault = ADMIN_PATH_IMG."icon-16-nondefault.png";
			$imgdefault = ADMIN_PATH_IMG."icon-16-default.png";
			$imgremove = ADMIN_PATH_IMG."icon-16-remove.png";
			$imgtick = ADMIN_PATH_IMG."icon-16-tick.png";
			$urledit = base_url('admincp/reseller/edit/'.$item->id);
			$urldel = base_url('admincp/reseller/delete/'.$item->id); 
			$urllogin = base_url('admincp/reseller/loginUser/'.$item->id); 
	?>
    <tr>
        <td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item->id;?>"><br></td>
        <td><?php echo $item->id; ?></td>
        <td align="left"><a href = '<?php echo $urledit;?>' title = 'Sửa' ><?php echo $item->shop_name; ?></a></td>
        <td align="left"><a href = '<?php echo $urledit;?>' title = '<?php echo $item->username; ?>' style="width:130px; overflow:hidden; display:block;"><?php echo $item->username; ?></a></td>
        <td><?php echo $item->email; ?></td>
        <td><span  style="width:130px; overflow:hidden; display:block;"><?php echo $item->phone; ?></span></td>
        <td><?php echo $item->namecatelog; ?></td>
        <td><?php echo $item->total; ?></td>
        <td ><?php echo date("d-m-Y",$item->date); ?></td>
    
        <td align = 'center'>
		<?php 
        if($item->auto_check == 1){
            echo "<div id = 'auto_check".$item->id."'><a href = 'javascript: hideshow(\"user_model\",\"auto_check\",\"".$item->id."\",\"0\",\"auto_check".$item->id."\");' title = 'Bỏ khóa'><img src = '".ADMIN_PATH_IMG."icon-16-default.png'></a></div>";
        }else{
            echo "<div id = 'auto_check".$item->id."'><a href = 'javascript: hideshow(\"user_model\",\"auto_check\",\"".$item->id."\",\"1\",\"auto_check".$item->id."\");' title = 'Khóa user'><img src = '".ADMIN_PATH_IMG."icon-16-nondefault.png'></a></div>"; 	 
        }
        ?>
        </td>
        <td align = 'center'>
		<?php 
        if($item->lock == 1){
            echo "<div id = 'lock".$item->id."'><a href = 'javascript: hideshow(\"user_model\",\"lock\",\"".$item->id."\",\"0\",\"lock".$item->id."\");' title = 'Bỏ khóa'><img src = '".ADMIN_PATH_IMG."icon-16-default.png'></a></div>";
        }else{
            echo "<div id = 'lock".$item->id."'><a href = 'javascript: hideshow(\"user_model\",\"lock\",\"".$item->id."\",\"1\",\"lock".$item->id."\");' title = 'Khóa user'><img src = '".ADMIN_PATH_IMG."icon-16-nondefault.png'></a></div>"; 	 
        }
        ?>
        </td>		
         <td align = 'center'>
        <?php 
        if($item->ticlock == 1){
            echo "<div id = '".$item->id."'><a href = 'javascript:ticlockactive(\"user_model\",\"ticlock\",\"".$item->id."\",\"0\");' title = 'Bỏ khóa'><img src = '".ADMIN_PATH_IMG."icon-16-remove.png'></a></div>";
        }else{
            echo "<div id = '".$item->id."'><a href = 'javascript:ticlockactive(\"user_model\",\"ticlock\",\"".$item->id."\",\"1\");' title = 'Khóa tin'><img src = '".ADMIN_PATH_IMG."icon-16-tick.png'></a></div>"; 
        }
        ?>
        </td>
        <td align = 'center' width="30"><a href = '<?php echo $urledit;?>' title = 'Sửa'><img src = '<?php echo ADMIN_PATH_IMG;?>b_edit.png'></a></td>
        <td align = 'center' width="30">
        <a href = '<?php echo $urldel; ?>' title = 'Xóa' onclick = 'javascript:return thongbao("Bạn có chắc muốn xóa");'><img src = '<?php echo ADMIN_PATH_IMG;?>b_drop.png'></a>
        </td>
    </tr>
    <?php }} ?>
</table>
<div class="frm-paging">
<span class="total">Tổng số: <b><?php echo $total; ?></b> </span>
<?php 
if($page) echo $page;
?>
</div>
<div class="list_button">
<a href = 'javascript:CheckAll(document.rowsForm.check_list)'  class="button">Check all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href = 'javascript:UnCheckAll(document.rowsForm.check_list)'  class="button">Uncheck all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmDelete('Bạn thật sự muốn xóa',document.rowsForm.check_list)"  class="button">Delete</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmSave('Bạn có chắc muốn lưu lại','<?php echo  base_url('admincp/reseller/save');?>')" class="button">Save</a>
</div>
</form>
</div>
<script type="text/javascript">
function sortOrder(str,val){
	document.frmSort.sortitem.value=str;
	document.frmSort.sorvalue.value=val;
	document.frmSort.submit();
}
</script>
<form name="frmSort" action="" method="post" >
<input type="hidden" name="sortitem" value=""  />
<input type="hidden" name="sorvalue" value=""  />
</form>