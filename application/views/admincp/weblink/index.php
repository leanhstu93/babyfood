<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    	<i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Banner Home  </td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="list_button">
<a href='<?php echo base_url('admincp/weblink/add');  ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>icon-16-plus.png'> Thêm mới</a>
</div>
<form action = '<?php echo base_url('admincp/weblink/delete');  ?>' method = 'post'  name="rowsForm" id="rowsForm">
<table class="view">
	<tr>
		<th width="50"><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
		<th width="50">ID</th>
        <th >Hình ảnh</th>
        <th>Vị trí</th>
        <th>Danh mục</th>
        <!-- <th>Danh mục deal</th> -->
      	<th width="200">Link</th>
        <th>Sắp xếp</th>
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
			$urledit = base_url('admincp/weblink/edit/'.$item->Id);
			$urldel = base_url('admincp/weblink/delete/'.$item->Id); 
	?>
      <tr>
			<td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item->Id;?>"><br></td>
			<td><?php echo $item->Id; ?></td>
             <td >
          	<?php if($item->images != ""){?>
            
            <img src="<?php echo "data/Banner/".$item->images; ?>" width="60" />
            <?php } ?>
            </td>
   			<td style="text-align:left">
          	<?php
			if($item->style==1) echo 'Banner Slideshow trang chủ';
			if($item->style==2) echo 'Banner Top trang danh mục';
			if($item->style==3) echo 'Banner danh mục trang chủ';
			if($item->style==4) echo 'Banner trên footer ';
			if($item->style==5) echo 'Banner dưới slideshow trang chủ';
			if($item->style==7) echo 'Banner bên phải slideshow trang chủ';
			if($item->style==6) echo 'Banner Home';
			if($item->style==6){
				if($item->layout=='L') echo '<p style="background:#000; color:#fff; margin-left:10px; display:inline-block; padding:3px 10px;">Banner Left</p>';	
				if($item->layout=='C') echo '<p style="background:#000; color:#fff; margin-left:10px; display:inline-block; padding:3px 10px;">Banner Center</p>';	
				if($item->layout=='R') echo '<p style="background:#000; color:#fff; margin-left:10px; display:inline-block; padding:3px 10px;">Banner Right</p>';	
			}
			?>
            </td>
            <td>
			<?php 
			if($item->parentid>0){
				$cat = $this->pagehtml_model->get_once_catelog($item->parentid);
				echo $cat[0]['title_vn'];
			}
			?>
            </td>
             <!-- <td>
			<?php 
			if($item->iddeal >0){
				$catdeal = $this->catdeal_model->get_list(array("Id"=>$item->iddeal));
				echo $catdeal[0]['title_vn']; 
			}
			?>
            </td> -->
            <td><div style="max-width:200px; overflow:hidden"><?php echo $item->link; ?></div></td>
            <td  width="100"><input type="text" size="1" value="<?php echo $item->sort; ?>" name="sort[<?php echo  $item->Id; ?>]"  style="text-align:center"/></td>
			 <td align = 'center'>
			<?php 
            if($item->ticlock == "1"){
                echo "<div id = '".$item->Id."'><a href = 'javascript:ticlockactive(\"weblink_model\",\"ticlock\",\"".$item->Id."\",\"0\");' title = 'Bỏ khóa'><img src = '".$imgremove."'></a></div>";
            }else{
                echo "<div id = '".$item->Id."'><a href = 'javascript:ticlockactive(\"weblink_model\",\"ticlock\",\"".$item->Id."\",\"1\");' title = 'Khóa tin'><img src = '".$imgtick."'></a></div>"; 
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
<a href='<?php echo  base_url('admincp/weblink/add'); ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>/icon-16-plus.png'> Thêm mới</a>
<a href = 'javascript:CheckAll(document.rowsForm.check_list)'  class="button">Check all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href = 'javascript:UnCheckAll(document.rowsForm.check_list)'  class="button">Uncheck all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmDelete('Bạn thật sự muốn xóa',document.rowsForm.check_list)"  class="button">Delete</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmSave('Bạn có chắc muốn lưu lại','<?php echo  base_url('admincp/weblink/save');?>')" class="button">Save</a>
</div>
</form>
</div>
