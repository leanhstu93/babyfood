<div class="container">
<div class="content-top row">
<div class="news-page col-xs-12 col-md-12">                
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <!-- Breadcrumb NavXT 5.6.0 -->
<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to Baby Shop Đồ Chơi Trẻ Em." href="<?php echo base_url(); ?>" class="home"><span property="name">Trang chủ</span></a><meta property="position" content="1"></span> <i class="fa fa-angle-double-right"></i> <span property="itemListElement" typeof="ListItem"><span property="name">Thanh toán</span><meta property="position" content="2"></span></div>

<div class="singpages_lindo">

<div class="cont-news-detail-page">

<div class="post_page">
<div class="woocommerce">
	<?php if ($this->session->flashdata('payment_success')) { ?>
          <?php $message = $this->session->flashdata('payment_success');
             echo '<div class="woocommerce-message"><i class="fa fa-check-circle" aria-hidden="true"></i> '.$message.'</div>'; 
          ?>
      <?php } ?> 

<p class="woocommerce-thankyou-order-received">Cảm ơn bạn. Đơn hàng của bạn đã được nhận.</p>
	<ul class="woocommerce-thankyou-order-details order_details">
		<li class="order">
			Số đơn hàng: <strong><?php echo $cus[0]['code']; ?></strong>
		</li>
		<li class="date">
			Ngày: <strong><?php echo date("d-m-Y",$cus[0]['date']);?></strong>
		</li>
		<!-- <li class="total">
			Tổng cộng: <strong><span class="woocommerce-Price-amount amount"><?php echo  bsVndDot($tongcong);?><span class="woocommerce-Price-currencySymbol">₫</span></span></strong>
		</li> -->
		<li class="method">
			Phương thức thanh toán:<strong> <?php echo $cus[0]['methodpay']?></strong>
		</li>
	</ul>
<div class="clear"></div>

<?php if ($cus[0]['methodpay'] == 'Chuyển khoản ngân hàng') {
	echo "<h3>Thông tin tài khoản ngân hàng của chúng tôi: </h3>";
	echo "<p>Thực hiện thanh toán vào ngay tài khoản ngân hàng của chúng tôi.</br> Vui lòng sử dụng Số đơn hàng của bạn như một phần để tham khảo khi thanh toán.</br> Đơn hàng của bạn sẽ không được vận chuyển cho tới khi tiền được gửi vào tài khoản của chúng tôi.</p>";
}else 
	echo "<h3>Thanh toán khi nhận hàng</h3>";
?>

<h2>Chi tiết đơn hàng</h2>
<table class="shop_table order_details">
	<thead>
		<tr>
			<th class="product-name">Sản phẩm</th>
			<th class="product-total">Tổng cộng</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	if(!empty($cart))
	{
		$tongcong = 0;
		foreach($cart as $item)
		{
			$pro = $this->product_model->get_Id($item['idpro']);
			$price = $pro[0]['sale_price'];
			$tong = $price *$item['amount'];
			$tongcong += $tong;
			$i++;
		?>
		<tr class="order_item">
		<td class="product-name">
			<a href="<?php echo base_url($pro[0]['alias'].".html") ?>"><?php echo $pro[0]['title_vn'];?></a> <strong class="product-quantity">× <?php echo $item['amount'];?></strong></td>
		<td class="product-total">
			<span class="woocommerce-Price-amount amount"><?php echo bsVndDot($tong);?><span class="woocommerce-Price-currencySymbol">₫</span></span>	</td>
		</tr>
		<?php 
		}
	}
	?>

	</tbody>
	<tfoot>
		<tr>
			<th scope="row">Tổng:</th>
			<td><span class="woocommerce-Price-amount amount"><?php echo  bsVndDot($tongcong);?><span class="woocommerce-Price-currencySymbol">₫</span></span></td>
		</tr>
						<tr>
			<th scope="row">Phương thức thanh toán:</th>
			<td><?php echo $cus[0]['methodpay']?></td>
		</tr>
		<tr class="order-total">
	      <th>Phí giao hàng:</th>
	      <td><strong><span class="woocommerce-Price-amount amount"><?php echo bsVndDot($cus[0]['transfee']);?></span><span class="woocommerce-Price-currencySymbol">₫</span></strong> </td>
	    </tr>
		<?php if($voucher_price) { ?>
		<tr class="order-total">
	      <th>Voucher:</th>
	      <td><strong><span class="woocommerce-Price-amount amount"><?php echo  $voucher_code .' - Giảm '. bsVndDot($voucher_price);?></span><span class="woocommerce-Price-currencySymbol">₫</span></strong> </td>
	    </tr>
		
		<?php } ?>
		<tr>
			<th scope="row">Tổng cộng:</th>
			<td><span class="woocommerce-Price-amount amount"><?php echo  bsVndDot($tongcong + $cus[0]['transfee'] - $voucher_price);?><span class="woocommerce-Price-currencySymbol">₫</span></span></td>
		</tr>
		
	</tfoot>
</table>
<h2>Thông tin nhận hàng</h2>
<table class="shop_table order_details">
	<tr>
		<td><p><strong>Người nhận: </strong><?php echo $cus[0]['fullname'] ?></p><p><strong>Số điện thoại: </strong><?php echo $cus[0]['phone'] ?></p><p><strong>Địa chỉ: </strong><?php echo $cus[0]['address'] ?></p>
		</td>
	</tr>
</table>	
</div>
</div>
</div><!--end .cont-news-detail-page-->
</div>                
</div><!--end .news-page-->
</div><!--end .content-top-->
</div>