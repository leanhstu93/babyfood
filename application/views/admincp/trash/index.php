 <script language="JavaScript" type="text/javascript" src="/public/template/tooltip/stickytooltip.js"></script>
 <link href="/public/template/tooltip/stickytooltip.css" rel="stylesheet" type="text/css" />
<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    	<i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Quản lý sản phẩm </td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="list_button">
<a href="<?php echo base_url("admincp/product/index"); ?>" class="button">Tất cả</a>
<a href="<?php echo base_url("admincp/trash/index"); ?>" class="button  actives">Thùng rác</a>
<form action="<?php echo base_url('admincp/trash/index'); ?>" method="get">
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
         $sub = $this->pagehtml_model->get_catelog($row['Id']);
    ?>
    <option value="<?php echo $row['Id'] ?>" <?php if($catelog == $row['Id']) echo "selected"; ?> ><?php echo $row['title_vn'] ?></option>
    <?php
        if(!empty($sub)){
             foreach($sub as $rw){
    ?>
    <option value="<?php echo $rw['Id'] ?>" <?php if($catelog == $rw['Id']) echo "selected"; ?> > --- <?php echo $rw['title_vn'] ?></option> 
    <?php }}}} ?>
</select>
<select name="status_check">
	<option value="-1">Tất cả </option>
    <option value="0" <?php if($status_check == 0) echo "selected"; ?>>Đang chờ duyệt</option>
    <option value="1" <?php if($status_check == 1) echo "selected"; ?> >Đã được duyệt</option>
    <option value="2" <?php if($status_check == 2) echo "selected"; ?> >Không được duyệt</option>
</select>
<select name="ticlock">
	<option value="-1">Tất cả </option>
    <option value="0" <?php if($ticlock == 0) echo "selected"; ?>>Không khóa</option>
    <option value="1" <?php if($ticlock == 1) echo "selected"; ?> >Khóa</option>
</select>
<input type="text" name="iduser" value="<?php if($iduser !='-1') echo $iduser; ?>" placeholder="Id shop" />
<input type="text" value="<?php if($iduser !='-1') echo $tukhoa; ?>" placeholder="Từ khóa" size="20" name="tukhoa" /> </td>
<td> <input type="submit" value="Tìm kiếm" name="btntimkiem" class="button" /></td>
</tbody>
</table>
</form>
</div>
<form action = '<?php echo base_url('admincp/trash/delete?q='.$arr_query);  ?>' method = 'post'  name="rowsForm" id="rowsForm">
<table class="view">
	<tr>
		<th width="40"><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
		<th width="50">
        <span onClick="javascript:sortOrder('mn_product.Id','<?php if($this->session->userdata('sort')=='Id asc') echo 0; else echo 1; ?>');" style="cursor:pointer">ID</span></th>
		<th> <span onClick="javascript:sortOrder('mn_product.title_vn','<?php if($this->session->userdata('sort')=='title_vn asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Tiêu đề</span></th>
        <th width="100">Hình ảnh</th>
        <th width="120"><span onClick="javascript:sortOrder('sale_price','<?php if($this->session->userdata('sort')=='sale_price asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Giá </span></th>
         <th width="150"><span onClick="javascript:sortOrder('idcat','<?php if($this->session->userdata('sort')=='idcat asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Danh mục</span></th>
         <th><span onClick="javascript:sortOrder('mn_product.date','<?php if($this->session->userdata('sort')=='date asc') echo 0; else echo 1; ?>');" style="cursor:pointer">Ngày đăng</span></th>
       <th>Người đăng</th> 
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
			$imgedit = ADMIN_PATH_IMG."icon-16-restore.png";
			$imgnondefault = ADMIN_PATH_IMG."icon-16-nondefault.png";
			$imgdefault = ADMIN_PATH_IMG."icon-16-default.png";
			$imgremove = ADMIN_PATH_IMG."icon-16-remove.png";
			$imgtick = ADMIN_PATH_IMG."icon-16-tick.png";
			$urledit = base_url('admincp/trash/restore/'.$item['Id'].'?q='.$arr_query);
			$urldel = base_url('admincp/trash/delete/'.$item['Id'].'?q='.$arr_query); 
	?>
      <tr>
			<td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item['Id'];?>"><br></td>
			<td><?php echo $item['Id']; ?></td>
			<td align="left"><span  data-tooltip="sti<?php echo $item['Id'] ?>" ><?php echo $item['title_vn']; ?></span></td>
            <td><?php if(!empty($item['images'])): ?><img src="<?php echo PATH_IMG_PRODUCT.$item['images'];?>" width="60" /> <?php endif; ?></td>
            <td><?php echo $this->page->bsVndDot($item['sale_price']); ?></td>	
            <td>
            	<?php echo $item['catelog']; ?>
            </td>	
           <td align = 'center'><?php echo date("d/m/Y",$item['date']); ?></td>	
           <td align = 'center'><span  style="width:130px; display:block; overflow:hidden;" title="<?php echo $item['admin']; ?>"><?php echo $item['admin']; ?></span></td>
          
			<?php /*?><td align = 'center'>
			<?php 
			if($item['ticlock'] == "1"){
				echo "<div id = '".$item['Id']."'><a href = 'javascript:ticlockactive(\"product_model\",\"ticlock\",\"".$item['Id']."\",\"0\");' title = 'Bỏ khóa'><img src = '".ADMIN_PATH_IMG."icon-16-remove.png'></a></div>";
			}else{
				echo "<div id = '".$item['Id']."'><a href = 'javascript:ticlockactive(\"product_model\",\"ticlock\",\"".$item['Id']."\",\"1\");' title = 'Khóa tin'><img src = '".ADMIN_PATH_IMG."icon-16-tick.png'></a></div>"; 
			}
			?>
			</td><?php */?>
            <td align = 'center'  width="30">
           	 <a href = '<?php echo $urledit; ?>' title = 'Sửa' ><img src = '<?php echo $imgedit; ?>'></a>
            </td>
            <td align = 'center'  width="30">
            <a href = '<?php echo $urldel; ?>' title = 'Xóa vĩnh viễn' onclick = 'javascript:return thongbao("Bạn có chắc xóa không");'><img src = '<?php echo $imgdel; ?>'></a>
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
<?php
if(!empty($info)){
?>
<div id="mystickytooltip" class="stickytooltip">
<?php
	foreach($info as $item){
?>
<div id="sti<?php echo $item['Id'] ?>" class="atip">
 <?php echo stripcslashes($item['content_vn']); ?>
</div>
<?php } ?>
</div>
<?php } ?>