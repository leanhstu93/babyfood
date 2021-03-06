<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    	<i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Bài viết  </td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="list_button">
<a href='<?php echo base_url('admincp/news/add');  ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>icon-16-plus.png'> Thêm mới</a>
<form action="<?php echo base_url('admincp/news/index'); ?>" method="get">
<table cellpadding="0" style="float:left">
<tbody>
<tr>
<td>
<select name="idcat">
	<option value="0">Chọn chủ đề</option>
    <?php
	$idcat = $this->input->get('idcat', TRUE);
	 $catelog = $this->pagehtml_model->get_catnews(array('ticlock'=>0,'parentid'=>0),1000);
	if(!empty($catelog)){
    	foreach($catelog as $item){
			$sub = $this->pagehtml_model->get_catnews(array('ticlock'=>0,'parentid'=>$item['Id']),100);
	?>
    <option value="<?php echo $item['Id'] ?>" <?php if($idcat==$item['Id']) echo "selected"; ?>><?php echo $item['title_vn'] ?></option>
    <?php if(!empty($sub)){
    	foreach($sub as $row){ ?>
        <option value="<?php echo $row['Id'] ?>" <?php if($idcat==$row['Id']) echo "selected"; ?>> --- <?php echo $row['title_vn'] ?></option>
    <?php }}}} ?>
</select>
</td>
<td> 
<input type="text" value="<?php echo $this->input->get('tukhoa', TRUE); ?>" placeholder="Tìm tiêu đề" size="40" name="tukhoa" /> 
</td>
<td> 
<button value="save" type="submit" class="button" name="save" >Tìm kiếm</button>
</td>
</tr>
</tbody>
</table>
</form>
</div>
<form action = '<?php echo base_url('admincp/news/delete');  ?>' method = 'post'  name="rowsForm" id="rowsForm">
<table class="view">
	<tr>
		<th width="50"><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
		<th width="50">ID</th>
        <th>Hình ảnh</th>
		<th>Tiêu đề</th>
        <th>Ngày đăng</th>
        <th>Sắp xếp</th>
        <th width="100">Hot</th>
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
			$urledit = base_url('admincp/news/edit/'.$item->Id);
			$urldel = base_url('admincp/news/delete/'.$item->Id); 
	?>
      <tr>
			<td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item->Id;?>"><br></td>
			<td><?php echo $item->Id; ?></td>
            <td>
            <?php if($item->images != ""){?>
            <img src="<?php echo PATH_IMG_NEWS.$item->images; ?>" width="60" />
            <?php } ?>
            </td>
            <td align="left"><a href = '<?php echo $urledit?>'><?php echo $item->title_vn; ?></a></td>
            <td><?php echo date("d/m/Y",$item->date);?></td>
            <td  width="100"><input type="text" size="1" value="<?php echo $item->sort; ?>" name="sort[<?php echo  $item->Id; ?>]"  style="text-align:center"/></td>
             <td align = 'center'>
			<?php 
            if($item->NoiBat == 1){
                echo "<div id = 'NoiBat".$item->Id."'><a href = 'javascript: hideshow(\"news_model\",\"NoiBat\",\"".$item->Id."\",\"0\",\"NoiBat".$item->Id."\");' title = 'Bỏ khóa'><img src = '".ADMIN_PATH_IMG."icon-16-default.png'></a></div>";
            }else{
                echo "<div id = 'NoiBat".$item->Id."'><a href = 'javascript: hideshow(\"news_model\",\"NoiBat\",\"".$item->Id."\",\"1\",\"NoiBat".$item->Id."\");' title = 'Khóa user'><img src = '".ADMIN_PATH_IMG."icon-16-nondefault.png'></a></div>"; 	 
            }
            ?>
            </td>
			 <td align = 'center'>
			<?php 
            if($item->ticlock == "1"){
                echo "<div id = '".$item->Id."'><a href = 'javascript:ticlockactive(\"news_model\",\"ticlock\",\"".$item->Id."\",\"0\");' title = 'Bỏ khóa'><img src = '".$imgremove."'></a></div>";
            }else{
                echo "<div id = '".$item->Id."'><a href = 'javascript:ticlockactive(\"news_model\",\"ticlock\",\"".$item->Id."\",\"1\");' title = 'Khóa tin'><img src = '".$imgtick."'></a></div>"; 
            }
            ?>
            </td>
			<td align = 'center' width="50"><a href = '<?php echo $urledit;?>'><img src = '<?php echo ADMIN_PATH_IMG;?>b_edit.png'></a></td>
            <td align = 'center' width="50"><a href = '<?php echo $urldel;?>'><img src = '<?php echo $imgdel;?>'></a></td>
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
<a href='<?php echo  base_url('admincp/news/add'); ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>/icon-16-plus.png'> Thêm mới</a>
<a href = 'javascript:CheckAll(document.rowsForm.check_list)'  class="button">Check all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href = 'javascript:UnCheckAll(document.rowsForm.check_list)'  class="button">Uncheck all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmDelete('Bạn thật sự muốn xóa',document.rowsForm.check_list)"  class="button">Delete</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmSave('Bạn có chắc muốn lưu lại','<?php echo  base_url('admincp/news/save');?>')" class="button">Save</a>
</div>
</form>
</div>
