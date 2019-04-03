<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Yêu cầu gọi lại / <?php echo $map_title ?></td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="content_i">
<form method="post" name="add-new" action="" enctype="multipart/form-data">
<table>
<tr>
	<td class = 'title_td' >Họ tên</td>
    <td> <input type="text" name="fullname" value="<?php echo set_value('fullname',$info['fullname']);  ?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Điện thoại</td>
    <td> <input type="text" name="phone" value="<?php echo set_value('phone',$info['phone']);  ?>"  style="width:400px">
   		 <?php echo form_error('phone'); ?>
     </td>
</tr>
<tr>
	<td class = 'title_td' >Ngày gửi</td>
    <td> <input type="text" name="email" value="<?php echo date("d-m-Y H:i:s",$info['date']);  ?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>			
<tr>
	<td class = 'title_td' >Sản phẩm</td>
    <td> 
    <?php 
	if($info["idpro"]>0):
		if($info['deal']==1):
		 $pro = $this->deal_model->get_Id($info["idpro"]);
	?>
	  <a href="/deal/<?php echo $pro[0]["alias"]."-".$pro[0]["Id"].".html"; ?>" target="_blank"><img src="<?php echo getImg($pro[0]["images"],"thumb"); ?>" width="60" style="float:left; margin-left:5px" /><?php echo $pro[0]["title_vn"] ?></a>
	<?php else: 
		$pro = $this->product_model->get_Id($info["idpro"]);
	?>
	<a href="/san-pham/<?php echo $pro[0]["alias"]."-".$pro[0]["Id"].".html"; ?>" target="_blank"><img src="<?php echo getImg($pro[0]["images"],"thumb"); ?>" width="60" style="float:left; margin-left:5px" /><?php echo $pro[0]["title_vn"] ?></a>
	<?php endif; endif; ?>
    
     </td>
</tr>		
<tr>
<td  ></td>
    <th align = 'left'>
       <button type = 'submit' name="save" value="save"  class="button" >Cập nhật</button> &nbsp;&nbsp;&nbsp;&nbsp;
        <input type = 'reset' value = 'Làm lại' class="button">
    </th>
</tr>	
</table>
</form>
</div>
</div>  
 