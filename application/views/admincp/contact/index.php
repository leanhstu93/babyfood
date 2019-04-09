<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    	<i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Gọi lại</td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="list_button">


<form action="<?php echo base_url('admincp/contact/index'); ?>" method="get">
<table cellpadding="0" style="float:left">
<tbody>
<td>
</td>
<td> 
<input type="text" value="" placeholder="Tìm tiêu đề" size="40" name="tukhoa" /> </td>
<td> <input type="submit" value="Tìm kiếm" name="btntimkiem" class="button" /></td>
</tbody>
</table>
</form>
</div>
<form action = '<?php echo base_url('admincp/contact/delete');  ?>' method = 'post'  name="rowsForm" id="rowsForm">
<table class="view">
	<tr>
		<th><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
		<th>ID</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th width="300">Sản phẩm</th>
        <th>Ngày</th>
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
			$urledit = base_url('admincp/contact/edit/'.$item['Id']);
			$urldel = base_url('admincp/contact/delete/'.$item['Id']); 
	?>
      <tr <?php if($item['view']==0) echo 'style="font-weight:bold"'; ?> >
			<td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item['Id'];?>"><br></td>
			<td><?php echo $item['Id']; ?></td>
			<td align="left"><a href="<?php echo $urledit; ?>"><?php echo $item['fullname']; ?></a></td>
           	<td><?php echo $item['email']; ?></td>
            <td>
            <?php 
			if($item["idpro"]>0):
				if($item['deal']==1):
				 $pro = $this->deal_model->get_Id($item["idpro"]);
			?>
              <a href="/deal/<?php echo $pro[0]["alias"]."-".$pro[0]["Id"].".html"; ?>" target="_blank"><img src="<?php echo getImg($pro[0]["images"],"thumb"); ?>" width="60" style="float:left; margin-left:5px" /><?php echo $pro[0]["title_vn"] ?></a>
            <?php else: 
				$pro = $this->product_model->get_Id($item["idpro"]);
			?>
            <a href="/san-pham/<?php echo $pro[0]["alias"]."-".$pro[0]["Id"].".html"; ?>" target="_blank"><img src="<?php echo getImg($pro[0]["images"],"thumb"); ?>" width="60" style="float:left; margin-left:5px" /><?php echo $pro[0]["title_vn"] ?></a>
            <?php endif; endif; ?>
            </td>
           <td align = 'center'><?php echo date("d-m-Y",$item['date']); ?></td>	
            <td align = 'center'  width="30">
            <a href = '<?php echo $urledit; ?>' title = 'Sửa' ><img src = '<?php echo $imgedit; ?>'></a>
            </td>
            <td align = 'center'  width="30">
            <a href = '<?php echo $urldel; ?>' title = 'Xóa' onclick = 'javascript:return thongbao("Bạn có chắc xóa không");'><img src = '<?php echo ADMIN_PATH_IMG;?>b_drop.png'></a>
            </td>
		</tr>
    <?php }} ?>
</table>
<div class="frm-paging">
<span class="total">Tổng số: <b><?php echo $total; ?></b> </span>
<?php 
if(!empty($page)) echo $page;
?>
</div>
<div class="list_button">
<a href = 'javascript:CheckAll(document.rowsForm.check_list)'  class="button">Check all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href = 'javascript:UnCheckAll(document.rowsForm.check_list)'  class="button">Uncheck all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmDelete('Bạn thật sự muốn xóa',document.rowsForm.check_list)"  class="button">Delete</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmSave('Bạn có chắc muốn lưu lại','<?php echo  base_url('admincp/contact/save');?>')" class="button">Save</a>
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