<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    	<i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Quản lý Deal </td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="list_button">
<a href='<?php echo base_url('admincp/deal/add');  ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>icon-16-plus.png'> Thêm mới</a>
<a href="<?php echo base_url("admincp/deal/index"); ?>" class="button <?php if($act =='index') echo 'actives'; ?>">Tất cả</a>
<a href="<?php echo base_url("admincp/trash/index"); ?>" class="button">Thùng rác</a>
<form action="<?php echo base_url('admincp/deal/index'); ?>" method="get">
<table cellpadding="0" style="float:left">
<tbody>
<td>
</td>
<td> 
<select name="catelog">
	<option value="-1">Tất cả danh mục</option>
	<?php
    if(!empty($listcat)){
        foreach($listcat  as $row){ 
         $sub = $this->pagehtml_model->get_catdeal($row['Id']);
    ?>
    <option value="<?php echo $row['Id'] ?>" <?php if($catelog == $row['Id']) echo "selected"; ?> ><?php echo $row['title_vn'] ?></option>
    <?php
        if(!empty($sub)){
             foreach($sub as $rw){
    ?>
    <option value="<?php echo $rw['Id'] ?>" <?php if($catelog == $rw['Id']) echo "selected"; ?> > --- <?php echo $rw['title_vn'] ?></option> 
    <?php }}}} ?>
</select>
<input type="text" value="<?php if($iduser !='-1') echo $tukhoa; ?>" placeholder="Từ khóa" size="20" name="tukhoa" /> </td>
<td> <input type="submit" value="Tìm kiếm" name="btntimkiem" class="button" /></td>
</tbody>
</table>
</form>
</div>
<form action ='<?php echo base_url('admincp/deal/delete?q='.$arr_query);?>' method = 'post'  name="rowsForm" id="rowsForm">
<table class="view">
	<tr>
		<th width="40"><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
		<th width="50">
        <span onClick="javascript:sortOrder('mn_deal.Id','<?php if($this->session->userdata('sort')=='Id asc') echo 0; else echo 1; ?>');" style="cursor:pointer">ID</span></th>
		<th> <span onClick="javascript:sortOrder('mn_deal.title_vn','<?php if($this->session->userdata('sort')=='title_vn asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Tiêu đề</span></th>
        <th width="100">Hình ảnh</th>
        <th width="120"><span onClick="javascript:sortOrder('sale_price','<?php if($this->session->userdata('sort')=='price asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Giá gốc </span></th>
        <th width="120"><span onClick="javascript:sortOrder('sale_price','<?php if($this->session->userdata('sort')=='sale_price asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Giá bán</span></th>
        <th width="100"><span onClick="javascript:sortOrder('idcat','<?php if($this->session->userdata('sort')=='idcat asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Danh mục</span></th>
         <th><span onClick="javascript:sortOrder('mn_deal.date','<?php if($this->session->userdata('sort')=='date asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Ngày đăng</span></th>
		<th width="50">Hết hàng</th>
        <th width="50">Deal giá sốc</th>
        <th width="50">Khóa</th>
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
			$imgdel = ADMIN_PATH_IMG."icon-16-trash.gif";
			$imgedit = ADMIN_PATH_IMG."b_edit.png";
			$imgnondefault = ADMIN_PATH_IMG."icon-16-nondefault.png";
			$imgdefault = ADMIN_PATH_IMG."icon-16-default.png";
			$imgremove = ADMIN_PATH_IMG."icon-16-remove.png";
			$imgtick = ADMIN_PATH_IMG."icon-16-tick.png";
			$urledit = base_url('admincp/deal/edit/'.$item['Id'].'?q='.$arr_query);
			$urldel = base_url('admincp/deal/delete/'.$item['Id'].'?q='.$arr_query); 
	?>
      <tr>
			<td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item['Id'];?>"><br></td>
			<td><?php echo $item['Id']; ?></td>
			<td align="left"><a href="<?php echo $urledit; ?>" ><?php echo $item['title_vn']; ?></a></td>
            <td><?php if(!empty($item['images'])): ?><img src="<?php echo PATH_IMG_PRODUCT.$item['images'];?>" width="60" /> <?php endif; ?></td>
               <td><input type="text" size="10" name="price[<?php echo $item['Id'] ?>]" value="<?php echo $this->page->bsVndDot($item['price']); ?>" style="text-align:center;" onkeyup="this.value = FormatNumber(this.value);"></td>	

            <td><input type="text" size="10" name="price_sale[<?php echo $item['Id'] ?>]" value="<?php echo $this->page->bsVndDot($item['sale_price']); ?>" style="text-align:center;" onkeyup="this.value = FormatNumber(this.value);"></td>
            <td>
            	<?php echo $item['catelog']; ?>
            </td>		
           <td align = 'center'><?php echo date("d/m/Y",$item['date']); ?></td>	
           <td align = 'center'>
			<?php 
			if($item['status'] == "1"){
				echo "<div id = 'status".$item['Id']."'><a href = 'javascript:hideshow(\"deal_model\",\"status\",\"".$item['Id']."\",\"0\",\"status".$item['Id']."\");' title = 'Có hàng'><img src = '".ADMIN_PATH_IMG."icon-16-remove.png'></a></div>";
			}else{
				echo "<div id = 'status".$item['Id']."'><a href = 'javascript:hideshow(\"deal_model\",\"status\",\"".$item['Id']."\",\"1\",\"status".$item['Id']."\");' title = 'Hết hàng'><img src = '".ADMIN_PATH_IMG."icon-16-tick.png'></a></div>"; 
			}
			?>
			</td>
            <td align = 'center'>
			<?php 
			if($item['home'] == "1"){
				echo "<div id = 'home".$item['Id']."'><a href = 'javascript:hideshow(\"deal_model\",\"home\",\"".$item['Id']."\",\"0\",\"home".$item['Id']."\");' title = 'Có hàng'><img src = '".ADMIN_PATH_IMG."icon-16-remove.png'></a></div>";
			}else{
				echo "<div id = 'home".$item['Id']."'><a href = 'javascript:hideshow(\"deal_model\",\"home\",\"".$item['Id']."\",\"1\",\"home".$item['Id']."\");' title = 'Hết hàng'><img src = '".ADMIN_PATH_IMG."icon-16-tick.png'></a></div>"; 
			}
			?>
			</td>
			<td align = 'center'>
			<?php 
			if($item['ticlock'] == "1"){
				echo "<div id = '".$item['Id']."'><a href = 'javascript:ticlockactive(\"deal_model\",\"ticlock\",\"".$item['Id']."\",\"0\");' title = 'Bỏ khóa'><img src = '".ADMIN_PATH_IMG."icon-16-remove.png'></a></div>";
			}else{
				echo "<div id = '".$item['Id']."'><a href = 'javascript:ticlockactive(\"deal_model\",\"ticlock\",\"".$item['Id']."\",\"1\");' title = 'Khóa tin'><img src = '".ADMIN_PATH_IMG."icon-16-tick.png'></a></div>"; 
			}
			?>
			</td>
            <td align = 'center'  width="30">
            <a href = '<?php echo $urledit; ?>' title = 'Sửa' ><img src = '<?php echo $imgedit; ?>'></a>
            </td>
            <td align = 'center'  width="30">
            <a href = '<?php echo $urldel; ?>' title = 'Xóa' onclick = 'javascript:return thongbao("Cho vào thùng rác");'><img src = '<?php echo $imgdel; ?>'></a>
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
<a href="javascript:confirmDelete('Cho vào thùng rác',document.rowsForm.check_list)"  class="button">Delete</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmSave('Bạn có chắc muốn lưu lại','<?php echo  base_url('admincp/deal/save?q='.$arr_query);?>')" class="button">Save</a>
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