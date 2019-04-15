<div class="main_area">
  <div class="breakcrumb">
    <table border="0">
      <tbody>
        <tr>
          <td width="25"><i class="fa icon-23 fa-windows"></i></td>
          <td> Quản lý nội dung / khuyến mãi </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="content">
  <div class="list_button">
    <form method="get" action = "<?php echo base_url('admincp/offer');?>" >
      <input type="text" value="<?php if($tukhoa!=-1) echo  $tukhoa ?>" placeholder="Nhập chương trình giảm giá" name="tukhoa" size="50" style="float:left; margin-right:5px;" />
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

        <th><span onClick="javascript:sortOrder('coupon_code','<?php if($this->session->userdata('sortuser')==' coupon_code asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Chương trình giảm giá</span></th>

        <th width="150"><span onClick="javascript:sortOrder('discount_value','<?php if($this->session->userdata('sortuser')=='discount_value asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Giá trị giảm giá</span></th>

        <th width="150"><span onClick="javascript:sortOrder('valid_from','<?php if($this->session->userdata('sortuser')=='	valid_from asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Bắt đầu</span></th>

        <th width="80"><span onClick="javascript:sortOrder('valid_until','<?php if($this->session->userdata('sortuser')=='valid_until asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Ngày hết hạn</span></th>
        <th>Thao tác</th>
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
			$urllogin = base_url('admincp/offer/loginUser/'.['id']);
			
	?>
      <tr>
        <td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item->id;?>">
          <br></td>
        <td><?php echo $item->id; ?></td>
        <td align="left">
            <?php echo $item->coupon_code; ?>
        </td>
        <td>
            <?php
            if($item->discount_unit == 1) {
                echo 'Giảm '. $item->discount_value.' VND';
            } else if($item->discount_unit == 3) {
                echo 'Giảm '. $item->discount_value.' %';
            } else if($item->discount_unit == 5) {
                echo 'Đồng giá '. $item->discount_value.' VND';
            }
            ?>
        </td>
        <td><?php echo date('d-m-Y', $item->valid_from) ?></td>

        <td><?php echo date('d-m-Y', $item->valid_until) ?></td>

        <td align = 'center' width="50">
          <a href = '<?php echo $urldel; ?>' title = 'Xóa' onclick = 'javascript:return thongbao("Bạn có chắc muốn xóa");'>
              <img src = '<?php echo ADMIN_PATH_IMG;?>b_drop.png'>
          </a>
            <a href = '<?php echo $urledit;?>' title = 'Sửa'>
                Xem
            </a>
          </td>
      </tr>
      <?php }} ?>
    </table>
    <div class="frm-paging"> <span class="total">Tổng số: <b><?php echo $total; ?></b> </span>
      <?php 
if($page) echo $page;
?>
    </div>
    <div class="list_button">
        <a href="/admincp/offer/add" class="button">Add</a>
    </div>

  </form>
</div>

<form name="frmSort" action="" method="post" >
  <input type="hidden" name="sortitem" value=""  />
  <input type="hidden" name="sorvalue" value=""  />
</form>
