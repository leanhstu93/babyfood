<div class="main_area">
  <div class="breakcrumb">
    <table border="0">
      <tbody>
        <tr>
          <td width="25"><i class="fa icon-23 fa-windows"></i></td>
          <td> Nội dung / Đơn hàng </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="content">
  <div class="list_button">
    <form action="<?php echo base_url('admincp/payment/index'); ?>" method="get">
      <table cellpadding="0" style="float:left">
        <tbody>
        <td></td>
          <td><input type="text" value="" placeholder="Tìm khách hàng" size="40" name="tukhoa" /></td>
          <td><input type="submit" value="Tìm kiếm" name="btntimkiem" class="button" /></td>
            </tbody>
      </table>
    </form>
  </div>
  <form action = '<?php echo base_url('admincp/payment/delete');  ?>' method = 'post'  name="rowsForm" id="rowsForm">
    <table class="view">
      <tr>
        <th><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
        <th>Mã ĐH</th>
        <th>Họ tên</th>
        <th >Điện thoại </th>
        <th>Địa chỉ</th>
        <th>Email</th>
        <th>Ngày đặt</th>
        <th>Tình trạng</th>
        <th>Xem</th>
        <th width="130" colspan="2">Hành động</th>
      </tr>
      <?php
	if(empty($info)){
	?>
      <tr>
        <td colspan = '15' class = 'emptydata'>Không có dữ liệu</td>
      </tr>
      <?php }else{
		 foreach ($info as $item) { 
			$imgdel = ADMIN_PATH_IMG."b_drop.png";
			$imgedit = ADMIN_PATH_IMG."b_edit.png";
			$imgnondefault = ADMIN_PATH_IMG."icon-16-nondefault.png";
			$imgdefault = ADMIN_PATH_IMG."icon-16-default.png";
			$imgremove = ADMIN_PATH_IMG."icon-16-remove.png";
			$imgtick = ADMIN_PATH_IMG."icon-16-tick.png";
			$urledit = base_url('admincp/payment/edit/'.$item['Id']);
			$urldel = base_url('admincp/payment/delete/'.$item['Id']);
	?>
      <tr <?php if($item['view']==0) echo 'style="font-weight:bold"'; ?>>
        <td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item['Id'];?>">
          <br></td>
        <td><?php echo $item['code']; ?></td>
        <td align="left"><a href="<?php echo $urledit; ?>"><?php echo $item['fullname']; ?></a></td>
        <td align = 'center'><?php echo $item['phone']; ?></td>
        <td align = 'center'><div style="max-width:300px; overflow:hidden"><?php echo $item['address']; ?></div></td>
        <td align = 'center'><?php echo $item['email']; ?></td>
        <td align = 'center'><?php echo date("d-m-Y",$item['date']); ?></td>
        <td align = 'center'><?php 
		   		if($item['status']==0) echo "Chưa xác nhận";
		   		if($item['status']==1) echo "Đã xác nhận";
				if($item['status']==2) echo "Đã hoàn thành";
				if($item['status']==3) echo "Đơn hàng thất bại";
		    ?></td>
        <td><img src = '<?php echo USER_PATH_IMG;?>icon-16-comment.gif' align="Click để xem chi tiết" style="cursor:pointer" onClick="return popitup('<?php echo base_url('/admincp/payment/printorder/'.$item['Id']); ?>')" /></td>
        
        <td align = 'center'  width="30"><a href = '<?php echo $urledit; ?>' title = 'Sửa' ><img src = '<?php echo $imgedit; ?>'></a></td>
        <td align = 'center'  width="30"><a href = '<?php echo $urldel; ?>' title = 'Xóa' onclick = 'javascript:return thongbao("Bạn có chắc xóa không");'><img src = '<?php echo ADMIN_PATH_IMG;?>b_drop.png'></a></td>
      </tr>
      <?php }} ?>
    </table>
    <div class="frm-paging"> <span class="total">Tổng số: <b><?php echo $total; ?></b> </span>
      <?php 
if(!empty($page)) echo $page;
?>
    </div>
    <div class="list_button"> <a href = 'javascript:CheckAll(document.rowsForm.check_list)'  class="button">Check all</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href = 'javascript:UnCheckAll(document.rowsForm.check_list)'  class="button">Uncheck all</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:confirmDelete('Bạn thật sự muốn xóa',document.rowsForm.check_list)"  class="button">Delete</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
  </form>
</div>
