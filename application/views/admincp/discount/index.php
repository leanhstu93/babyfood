<div class="main_area">
  <div class="breakcrumb">
    <table border="0">
      <tbody>
        <tr>
          <td width="25"><i class="fa icon-23 fa-windows"></i></td>
          <td> Nội dung / Màu sắc </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="content">
  <div class="list_button"> <a href='<?php echo base_url('admincp/discount/add');  ?>' class="button" > <img src = '<?php echo ADMIN_PATH_IMG; ?>icon-16-plus.png'> Thêm mới</a>
    <form action="<?php echo base_url('admincp/discount/index'); ?>" method="get">
      <table cellpadding="0" style="float:left">
        <tbody>
        <td></td>
          <td><input type="text" value="<?php if($tukhoa !='0') echo $tukhoa; ?>" placeholder="Từ khóa" size="50" name="tukhoa" /></td>
          <td><input type="submit" value="Tìm kiếm" name="btntimkiem" class="button" /></td>
            </tbody>
      </table>
    </form>
  </div>
  <form action = '<?php echo base_url('admincp/discount/delete');  ?>' method = 'post'  name="rowsForm" id="rowsForm">
    <table class="view">
      <tr>
        <th width="50"><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
        <th width="50">id</th>
        <th>Mã giảm giá</th>
        <th>Mệnh giá</th>
        <th>Ngày tạo</th>
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
			$urledit = base_url('admincp/discount/edit/'.$item['id']);
			$urldel = base_url('admincp/discount/delete/'.$item['id']); 
	?>
      <tr>
        <td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item['id'];?>">
          <br></td>
        <td><?php echo $item['id']; ?></td>
        <td align=""><a href = '<?php echo $urledit?>'><?php echo $item['code']; ?></a></td>
        <td><?php echo $item['type']?></td>
        <td  width="100"><?php echo date('d-m-Y', $item['created'])?></td>
        <td align = 'center'><?php 
            if($item['ticlock'] == "1"){
                echo "<div id = '".$item['id']."'><a href = 'javascript:ticlockactive(\"discount_code_model\",\"ticlock\",\"".$item['id']."\",\"0\");' title = 'Bỏ khóa'><img src = '".$imgremove."'></a></div>";
            }else{
                echo "<div id = '".$item['id']."'><a href = 'javascript:ticlockactive(\"discount_code_model\",\"ticlock\",\"".$item['id']."\",\"1\");' title = 'Khóa tin'><img src = '".$imgtick."'></a></div>"; 
            }
            ?></td>
        <td align = 'center' width="50"><a href = '<?php echo $urledit;?>'><img src = '<?php echo ADMIN_PATH_IMG;?>b_edit.png'></a></td>
        <td align = 'center' width="50"><a href = '<?php echo $urldel;?>'><img src = '<?php echo $imgdel;?>'></a></td>
      </tr>
      <?php }} ?>
    </table>
    <div class="frm-paging"> <span class="total">Tổng số: <b><?php echo $total; ?></b> </span>
      <?php 
if(!empty($page)) echo $page;
?>
    </div>
    <div class="list_button"> <a href='<?php echo  base_url('admincp/discount/add'); ?>' class="button" > <img src = '<?php echo ADMIN_PATH_IMG; ?>/icon-16-plus.png'> Thêm mới</a> <a href = 'javascript:CheckAll(document.rowsForm.check_list)'  class="button">Check all</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href = 'javascript:UnCheckAll(document.rowsForm.check_list)'  class="button">Uncheck all</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:confirmDelete('Bạn thật sự muốn xóa',document.rowsForm.check_list)"  class="button">Delete</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:confirmSave('Bạn có chắc muốn lưu lại','<?php echo  base_url('admincp/discount/save');?>')" class="button">Save</a> </div>
  </form>
</div>
