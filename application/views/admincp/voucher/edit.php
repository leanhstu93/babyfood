<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Quản lý nội dung / coder voucher / <?php echo $map_title ?></td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="content_i">
<form method="post" name="add-new" action="" enctype="multipart/form-data">
 <input type="hidden" name="Id" value="<?php if(!empty($info['id'])) echo $info['id']; ?>">

<table>
<tr>
    <td class = 'title_td' width="100">Code voucher</td>
    <td>
	<?php echo $info['code']?>  
       
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Username</td>
    <td>
	<?php echo $info['username']?>  
        
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Email</td>
    <td>
		<?php echo $info['email']?>        
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Loại voucher</td>
    <td>
	<?php echo $info['price']?>
        
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Ngày đăng ký</td>
    <td>
	<?php echo date('d-m-Y', $info['start_day']) ?>
        
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Ngày kết thúc</td>
    <td>
	<?php echo date('d-m-Y', $info['end_day']) ?>
        
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Trạng thái</td>
    <td>
	<?php if($info['status']==1){echo "Đã sử dụng";} else echo 'Chưa sử dụng'; ?>
        
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Mã đơn hàng</td>
    <td>
	<?php echo $info['order_id']?>
        
    </td>
</tr>
	
</table>
</form> 
</div>
</div>    