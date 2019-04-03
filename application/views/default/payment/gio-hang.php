<?php
	$cart = $this->session->userdata('cart');
?>

<div class="background_main" role="main">
<div class="container">
<div class="content-top row">
				
<div class="news-page col-xs-12 col-md-12">
                
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <!-- Breadcrumb NavXT 5.6.0 -->
<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to Baby Shop Đồ Chơi Trẻ Em." href="<?php echo base_url(); ?>" class="home"><span property="name">Trang chủ</span></a><meta property="position" content="1"></span> <i class="fa fa-angle-double-right"></i> <span property="itemListElement" typeof="ListItem"><span property="name">Giỏ hàng</span><meta property="position" content="2"></span></div>

<div class="singpages_lindo">
<?php
if(empty($cart)){
?>

<div class="cont-news-detail-page">
	<div class="post_page">
		<div class="woocommerce" style="text-align:center;">
			<p class="cart-empty">
			Chưa có sản phẩm nào trong giỏ hàng.</p>
			<p class="return-to-shop">
			<a class="button wc-backward button alt" href="<?php echo base_url(); ?>">Quay lại cửa hàng</a>
			</p>
		</div>
	</div>
</div>

<?php }else{ ?>
<div class="cont-news-detail-page">

<!--<h1 class="single_title">Giỏ hàng</h1>-->            
<div class="post_page">
<div class="woocommerce">
<form action="<?php echo base_url('payment/editcart');?>" method="post">

<table class="shop_table shop_table_responsive cart" cellspacing="0">

	<thead>
		<tr>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name">Sản phẩm</th>
			<th class="product-price">Giá</th>
			<th class="product-quantity">Số lượng</th>
			<th class="product-subtotal">Tổng cộng</th>
			<th class="product-remove">&nbsp;</th>
		</tr>
	</thead>
<?php
	$tongtien = 0;
	foreach($cart as $k=>$v){
	$idpro = (int)$v['idpro'];
	if($v['deal']==1){
		$pro = $this->deal_model->get_Id($idpro);
		$link = base_url("deal/".$pro[0]['alias']."-".$pro[0]['Id']."");
	}else{
		$pro = $this->product_model->get_Id($idpro);
		$link = base_url($pro[0]['alias'].".html");
	}
	$tongtien = $tongtien+ $pro[0]['sale_price']*$v['qty'];

?>

<tbody>
<tr class="cart_item">
	<td class="product-remove">
		<a target="_blank" href="<?php echo $link; ?>"><img width="90" src="<?php echo PATH_IMG_PRODUCT.$pro[0]['images']; ?>">
		</a>
	</td>
    <td class="product-name" data-title="Sản phẩm">
        <a target="_blank" href="<?php echo $link; ?>" style="font-size: 15px; color: green"><?php echo $pro[0]['title_vn'] ?>
        </a>
	</td>
    <td class="product-price" data-title="Giá">
        <p class="bsd-cart"><?php echo bsVndDot($pro[0]['sale_price']) ?> ₫</p>
    </td>
    <td class="product-quantity" data-title="Số lượng">
    	<div class="quantity">
	      	<input type="number" step="1" min="1" max="" name="quanty[<?php echo $k; ?>]" value="<?php echo $v['qty'] ?>" title="SL" class="input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric"  id="quanty"/>
	    </div>
        <!-- <select name="quanty[<?php echo $k; ?>]"  class="quantity">
        <?php 
		for($i=1;$i<=20;$i++){
		?>
        <option value="<?php echo $i; ?>" <?php if($i==$v['qty']) echo 'selected'; ?> style="padding: 5px "><?php echo $i; ?></option>
        <?php } ?>
         </select>   -->
    </td>
    <td class="product-subtotal" data-title="Tổng cộng">
        <p class="bsd-cart"><?php echo bsVndDot($pro[0]['sale_price']*$v['qty']) ?> ₫</p>
   	</td>
    <td class="product-remove">
    	<a href="<?php echo base_url('payment/delcart/'.$k); ?>" title="Xóa"  class="btndeletecart remove" data='<?php echo $k; ?>'><i class="fa fa-times" aria-hidden="true"></i>
    	</a>
   </td>
</tr>
<?php }?>
<tr>
	<td colspan="6" class="actions">
		<!-- <div class="coupon">
			<label for="coupon_code">Ưu đãi:</label> 
			<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Mã ưu đãi" style="width: 100px;padding: 5px ">
			<input type="submit" class="button" name="apply_coupon" value="Áp dụng ưu đãi" >
		</div> -->
		
		<a href="<?php echo base_url(); ?>" title="Tiếp tục mua hang" class="button checkout-button"><i class="fa fa-cart-plus" aria-hidden="true"></i> Tiếp tục mua hàng</a>
		<input type="submit" class="button checkout-button button alt wc-forward" name="update_cart" id="update_cart" value="Cập nhật Giỏ hàng">
	</td>
</tr>
</tbody>
</table>
</form>

<div class="cart-collaterals">
	<div class="cart_totals ">
	<h2>Tổng giỏ hàng</h2>
	<table cellspacing="0" class="shop_table shop_table_responsive">
		<tbody><tr class="cart-subtotal">
			<th>Tổng</th>
			<td data-title="Tổng phụ"><span class="woocommerce-Price-amount amount"><?php echo bsVndDot($tongtien)."₫" ?></span></td>
		</tr>
		<tr class="order-total">
			<th>Tổng cộng</th>
			<td data-title="Tổng cộng"><strong><span class="woocommerce-Price-amount amount"><?php echo bsVndDot($tongtien)."₫" ?></span></strong> </td>
		</tr>
	</tbody>
</table>

<div class="wc-proceed-to-checkout">
	<a href="thanh-toan" class="checkout-button button alt wc-forward">Thanh toán</a>
</div>

</div>
</div>
</div>
</div>
</div><!--end .cont-news-detail-page-->
<?php } ?>
</div>                
</div><!--end .news-page-->
</div><!--end .content-top-->
</div>
</div>
</div>
</div>

<style type="text/css">
	.wc-proceed-to-checkout a.button.alt{
	display: block;
    text-align: center;
    margin-bottom: 1em;
    font-size: 1.25em;
    padding: 1em;
    background: #090 !important;
    color: #FFF !important;
    font-weight: normal;
    border: none;
    text-transform: uppercase;
	}
</style>