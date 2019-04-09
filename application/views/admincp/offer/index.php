<div class="main_area">
  <div class="breakcrumb">
    <table border="0">
      <tbody>
        <tr>
          <td width="25"><i class="fa icon-23 fa-windows"></i></td>
          <td> Quản lý nội dung / Code offer </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="content">
  <div class="list_button">
    <form method="get" action = "<?php echo base_url('admincp/offer');?>" >
      <input type="text" value="<?php if($tukhoa!=-1) echo  $tukhoa ?>" placeholder="Nhập mã code / Đơn hàng " name="tukhoa" size="50" style="float:left; margin-right:5px;" />
      <select name="type_search" style="float:left; margin-right:5px;">
        <option value="0">Tìm gần đúng</option>
        <option value="1">Tìm chính xác</option>
      </select>
      <input type="submit" value="Tìm kiếm" name="btntimkiem"  class="button"  />
    </form>
  </div>
  <form action = '<?php echo base_url('admincp/offer/delete');  ?>' method = 'post'  name="rowsForm" id="rowsForm">
    <table class="view">
      <tr>
        <th width="30"><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
        <th width="50"><span onClick="javascript:sortOrder('id','<?php if($this->session->userdata('sortuser')=='id asc') echo 0; else echo 1; ?>');" style="cursor:pointer">id</span></th>
        <th width="50"><span onClick="javascript:sortOrder('userid','<?php if($this->session->userdata('sortuser')=='id asc') echo 0; else echo 1; ?>');" style="cursor:pointer">User id</span></th>
        <th><span onClick="javascript:sortOrder('fullname','<?php if($this->session->userdata('sortuser')=='fullname asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Họ tên</span></th>
        <th><span onClick="javascript:sortOrder('username','<?php if($this->session->userdata('sortuser')=='username asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Username</span></th>
        <th><span onClick="javascript:sortOrder('email','<?php if($this->session->userdata('sortuser')=='email asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Email</span></th>
        <th><span onClick="javascript:sortOrder('code','<?php if($this->session->userdata('sortuser')==' code asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Code offer</span></th>
        <th width="150"><span onClick="javascript:sortOrder('price','<?php if($this->session->userdata('sortuser')=='price asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Giá giãm</span></th>
        <th width="150"><span onClick="javascript:sortOrder('created','<?php if($this->session->userdata('sortuser')=='created asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Ngày tạo</span></th>
        <th width="150"><span onClick="javascript:sortOrder('start_day','<?php if($this->session->userdata('sortuser')=='start_day asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Ngày đăng ký</span></th>
        <th width="80"><span onClick="javascript:sortOrder('end_day','<?php if($this->session->userdata('sortuser')=='end_day asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Ngày hết hạn</span></th>
        <th width="80"><span onClick="javascript:sortOrder('status','<?php if($this->session->userdata('sortuser')=='status asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Trạn thái</span></th>
        <th width="80"><span onClick="javascript:sortOrder('order_id','<?php if($this->session->userdata('sortuser')=='order_id asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Mã Đơn Hàng</span></th>
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
			$urledit = base_url('admincp/offer/edit/'.$item->id);
			$urldel = base_url('admincp/offer/delete/'.$item->id);
			$urllogin = base_url('admincp/offer/loginUser/'.$item->id);
			
	?>
      <tr>
        <td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item->id;?>">
          <br></td>
        <td><?php echo $item->id; ?></td>
        <td><?php echo $item->userid; ?></td>
        <td><?php echo $item->fullname; ?></td>
        <td align="left"><a href = '<?php echo $urledit;?>' title = 'Sửa'><?php echo $item->username; ?></a></td>
        <td><?php echo $item->email; ?></td>
        <td align="left"><a href = '<?php echo $urledit;?>' title = 'Sửa'><?php echo $item->code; ?></a></td>
        <td><?php 
			echo $item->price;
		 ?></td>
          <td><?php echo date('d-m-Y H:i:s', $item->created) ?></td>
        <td><?php echo date('d-m-Y', $item->start_day) ?></td>
        <td><?php echo date('d-m-Y', $item->end_day) ?></td>
        <td><?php if($item->status==1){echo "Đã sử dụng";} else echo 'Chưa sử dụng'; ?></td>
        <td><?php echo $item->order_id; ?></td>
        <td align = 'center' width="50"><a href = '<?php echo $urledit;?>' title = 'Sửa'><img src = '<?php echo ADMIN_PATH_IMG;?>b_edit.png'></a> <a href = '<?php echo $urldel; ?>' title = 'Xóa' onclick = 'javascript:return thongbao("Bạn có chắc muốn xóa");'><img src = '<?php echo ADMIN_PATH_IMG;?>b_drop.png'></a></td>
      </tr>
      <?php }} ?>
    </table>
    <div class="frm-paging"> <span class="total">Tổng số: <b><?php echo $total; ?></b> </span>
      <?php 
if($page) echo $page;
?>
    </div>
    <div class="list_button"><a href="/admincp/offer/add" class="button">Add</a> <a href="/admincp/offer/export_excel_offer" class="button">Exprot Excel</a> </div>
    <!--<div class="list_button"> <a href = 'javascript:CheckAll(document.rowsForm.check_list)'  class="button">Check all</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href = 'javascript:UnCheckAll(document.rowsForm.check_list)'  class="button">Uncheck all</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:confirmDelete('Bạn thật sự muốn xóa',document.rowsForm.check_list)"  class="button">Delete</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:confirmSave('Bạn có chắc muốn lưu lại','<?php echo  base_url('admincp/offer/save');?>')" class="button">Save</a> </div>-->
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
