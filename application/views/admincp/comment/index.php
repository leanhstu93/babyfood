<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    	<i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Hỏi đáp  </td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="list_button">
<a href='<?php echo base_url('admincp/comment/add');  ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>icon-16-plus.png'> Thêm mới</a>
</div>
<form action = '<?php echo base_url('admincp/comment/delete');  ?>' method = 'post'  name="rowsForm" id="rowsForm">
<table class="view">
	<tr>
		<th width="50"><input type="checkbox" name="Check_ctr" id = 'Check_ctr' value="yes" onClick="Check(document.rowsForm.check_list)"></th>
		<th width="50">ID</th>
		<th align="left">Tiêu đề</th>
        <th>Nội dung</th>
        <th>Tên sản phẩm</th>
        <th>Ngày bình luận</th>
        <th>Người bình luận</th>
		<th>Bật / Tắt</th>
		<th>Hành động</th>
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
			$urledit = base_url('admincp/comment/edit/'.$item->id);
			$urldel = base_url('admincp/comment/delete/'.$item->id); 
			
	?>
      <tr >
			<td align = 'center'><input type="checkbox" id = 'check_list' name="check_list[]" value="<?php echo $item->id;?>"><br></td>
			<td><?php echo $item->id; ?></td>
            <td align="left"><a href = '<?php echo $urledit?>' ><?php echo $item->title; ?></a></td>
            <td  width=""><?php echo $item->content;?></td>
            <td  width=""><a href="<?php echo BASE_URL?>san-pham/<?php echo $item->alias;?>-<?php echo $item->idpro;?>.html" target="_blank"><?php echo $item->title_vn;?></a></td>
             <td align = 'center'>
             	<?php echo date('d/m/Y', $item->date)?>
             </td>
             <td align = 'center'>
             	<?php echo $item->username?>
             </td>
			 <td align = 'center'>
			<?php 
            if($item->ticlock == "1"){
                echo "<div id = '".$item->id."'><a href = 'javascript:ticlockactive(\"comment_model\",\"ticlock\",\"".$item->id."\",\"0\");' title = 'Bỏ khóa'><img src = '".$imgremove."'></a></div>";
            }else{
                echo "<div id = '".$item->id."'><a href = 'javascript:ticlockactive(\"comment_model\",\"ticlock\",\"".$item->id."\",\"1\");' title = 'Khóa tin'><img src = '".$imgtick."'></a></div>"; 
            }
            ?>
            </td>
			<!--<td align = 'center' width="50"><a href = '<?php echo $urledit;?>'><img src = '<?php echo ADMIN_PATH_IMG;?>b_edit.png'></a></td>-->
            <td align = 'center' width="50"><a href = '<?php echo $urldel;?>'><img src = '<?php echo $imgdel;?>'></a></td>
		</tr>
    <?php 	
		}
	}
	?>
</table>
<div class="frm-paging">
<span class="total">Tổng số: <b><?php echo $total; ?></b> </span>
<?php 
echo $this->pagination->create_links();
?>
</div>
<div class="list_button">
<a href='<?php echo  base_url('admincp/comment/add'); ?>' class="button" >
<img src = '<?php echo ADMIN_PATH_IMG; ?>/icon-16-plus.png'> Thêm mới</a>
<a href = 'javascript:CheckAll(document.rowsForm.check_list)'  class="button">Check all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href = 'javascript:UnCheckAll(document.rowsForm.check_list)'  class="button">Uncheck all</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmDelete('Bạn thật sự muốn xóa',document.rowsForm.check_list)"  class="button">Delete</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:confirmSave('Bạn có chắc muốn lưu lại','<?php echo  base_url('admincp/comment/save');?>')" class="button">Save</a>
</div>
</form>
</div>
