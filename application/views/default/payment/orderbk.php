<?php
  $cart = $this->session->userdata('cart');
?>

<div class="background_main" role="main">
<div class="container">
<div class="content-top row">
        
<div class="news-page col-xs-12 col-md-12">
                
 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <!-- Breadcrumb NavXT 5.6.0 -->
<span property="itemListElement" typeof="ListItem">
  <a property="item" typeof="WebPage" title="Go to Baby Shop Đồ Chơi Trẻ Em." href="<?php echo base_url() ?>" class="home"><span property="name">Trang chủ</span></a><meta property="position" content="1"></span> <i class="fa fa-angle-double-right"></i> <span property="itemListElement" typeof="ListItem"><span property="name">Thanh toán</span><meta property="position" content="2"></span></div>

<div class="singpages_lindo">

<div class="cont-news-detail-page">
<div class="post_page">
<div class="woocommerce">

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo current_url(); ?>" enctype="multipart/form-data">
    <div class="col2-set" id="customer_details">
      <div class="col-1">
        <div class="woocommerce-billing-fields">
    <h3>Thông tin thanh toán</h3>
    <p class="form-row form-row address-field  validate-required" id="billing_first_name_field">
      <label for="billing_first_name" class="">Họ và tên <abbr class="required" title="bắt buộc">*</abbr>
      </label>
      <input type="text" class="input-text " name="fullname" id="" placeholder="" autocomplete="given-name" value="<?php echo set_value("fullname",$info_payment->fullname); ?>" required="">
    </p>
  <div class="clear"></div>
  
    <p class="form-row form-row form-row-first validate-required validate-email" id="billing_email_field">
      <label for="billing_email" class="">Địa chỉ email <abbr class="required" title="bắt buộc">*</abbr>
      </label>
      <input type="email" class="input-text " name="email" id="" placeholder="" autocomplete="email" value="<?php echo set_value("email",$info_payment->email); ?>" required="">
    </p>
  
    <p class="form-row form-row form-row-last validate-required validate-phone" id="billing_phone_field">
      <label for="billing_phone" class="">Số điện thoại <abbr class="required" title="bắt buộc">*</abbr>
      </label>
      <input type="tel" class="input-text " name="phone" id="" placeholder="" autocomplete="tel" value="<?php echo set_value("phone",$info_payment->phone); ?>" required="">
    </p>
    <div class="clear"></div>
  
    <p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field">
      <label for="billing_address_1" class="">Địa chỉ nhận hàng<abbr class="required" title="bắt buộc">*</abbr>
      </label>
      <input type="text" class="input-text " name="address" id="" placeholder="" autocomplete="address-line1" value="<?php echo set_value("address",$info_payment->address); ?>" required="">
    </p>

    <p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field">
      <label for="billing_address_1" class="">Tỉnh thành<abbr class="required" title="bắt buộc">*</abbr>
      </label>
      <span class="pdr-w50">
        <select id="ship" name="ship" class="form-control" onchange="shipFee(this)" required="">
            <option value="">-Tỉnh/Thành Nhận hàng-</option>
            <option value="0"> Hồ Chí Minh mua &gt; 5SP Nội Thành (+ 0 vnđ)</option>
            <option value="15.000"> Hồ Chí Minh - Q.1 (+ 15,000 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.2 (+ 20,000 vnđ)</option>
            <option value="15.000"> Hồ Chí Minh - Q.3 (+ 15,000 vnđ)</option>
            <option value="15.000"> Hồ Chí Minh - Q.4 (+ 15,000 vnđ)</option>
            <option value="15.000"> Hồ Chí Minh - Q.5 (+ 15,000 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.6 (+ 20,000 vnđ)</option>
            <option value="0"> Hồ Chí Minh - Q.7 (+ 0 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.8 (+ 20,000 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.9 (+ 20,000 vnđ)</option>
            <option value="15.000"> Hồ Chí Minh - Q.10 (+ 15,000 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.11 (+ 20,000 vnđ)</option>
            <option value="25.000"> Hồ Chí Minh - Q.12 (+ 25,000 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.Bình Thạnh (+ 20,000 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.Phú Nhuận (+ 20,000 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.Tân Bình (+ 20,000 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.Tân Phú (+ 20,000 vnđ)</option>
            <option value="25.000"> Hồ Chí Minh - Q.Bình Tân (+ 25,000 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.Gò Vấp (+ 20,000 vnđ)</option>
            <option value="20.000"> Hồ Chí Minh - Q.Thủ Đức (+ 20,000 vnđ)</option>
            <option value="0"> Hồ Chí Minh - TT Nhà Bè (+ 0 vnđ)</option>
            <option value="25.000"> Hồ Chí Minh - Huyện Nhà Bè các Xã khác (+ 25,000 vnđ)</option>
            <option value="15.000"> Hồ Chí Minh - Huyện Nhà Bè, Xã P.Kiển (+ 15,000 vnđ)</option>
            <option value="15.000"> Hồ Chí Minh - Huyện Nhà Bè, Xã P.Xuân (+ 15,000 vnđ)</option>
            <option value="35.000"> Hồ Chí Minh - Huyện Bình Chánh (+ 35,000 vnđ)</option>
            <option value="35.000"> Hồ Chí Minh - Huyện Hóc Môn (+ 35,000 vnđ)</option>
            <option value="35.000"> Hồ Chí Minh - Huyện Củ Chi (+ 35,000 vnđ)</option>
            <option value="35.000"> Hồ Chí Minh - Huyện Cần Giờ (+ 35,000 vnđ)</option>
            <option value="35.000"> Các tỉnh khác mua &lt; 5SP TL &lt; 1KG (+ 35,000 vnđ)</option>
            <option value="45.000"> Các tỉnh khác mua &lt; 5SP TL 1-2KG (+ 45,000 vnđ)</option>
            <option value="55.000"> Các tỉnh khác mua &lt; 5SP TL 2-3KG (+ 55,000 vnđ)</option>
            <option value="60.000"> Các tỉnh khác mua &lt; 5SP TL &gt;3KG (+ 60,000 vnđ)</option>
            <option value="0"> Các tỉnh khác mua &gt; 5SP TL &lt; 1KG (+ 0 vnđ)</option>
            <option value="20.000"> Các tỉnh khác mua &gt; 5SP TL 1-2KG (+ 20,000 vnđ)</option>
            <option value="30.000"> Các tỉnh khác mua &gt; 5SP TL 2-3KG (+ 30,000 vnđ)</option>
            <option value="35.000"> Các tỉnh khác mua &gt; 5SP TL &gt;3KG (+ 35,000 vnđ)</option>
        </select>
    </span>
    </p>

  </div>
      </div>
<script>
function shipFee(a) {
    var x = (a.value || a.options[a.selectedIndex].value); 
    document.getElementById('trans_fee').innerHTML = x;
    document.getElementById('transfee').value = x;
}
</script>

      <div class="col-2">
        <div class="woocommerce-shipping-fields">
      <h3>Thông tin thêm</h3>
      <p class="form-row form-row notes" id="order_comments_field">
        <label for="order_comments" class="">Ghi chú đơn hàng</label>
        <textarea name="note" class="input-text " id="" placeholder="Ghi chú về đơn hàng, ví dụ: lưu ý khi giao hàng." rows="2" cols="5" value="<?php echo set_value("note",""); ?>">
        </textarea>
      </p>
  </div>
      </div>
    </div>
  <h3 id="order_review_heading">Đơn hàng của bạn</h3>
  <div id="order_review" class="woocommerce-checkout-review-order">
    <table class="shop_table woocommerce-checkout-review-order-table">
  <thead>
    <tr>
      <th class="product-name">Sản phẩm</th>
      <th class="product-total">Tổng cộng</th>
    </tr>
  </thead>
    <tbody>
  <?php
    if(empty($cart)){
      ?>
      <div class="alert-block ">Giỏ hàng trống</div>
      <a href="<?php echo base_url(); ?>" class="btncart-return">Tiếp tục mua hàng</a>
      <?php }else{ 
        $tongtien = 0;
        $u=0;
      foreach($cart as $k=>$v){
        $u++;
        $idpro = (int)$v['idpro'];
        if($v['deal']==1){
          $pro = $this->deal_model->get_Id($idpro);
          $link = base_url("deal/".$pro[0]['alias']."-".$pro[0]['Id']);
        }else{
          $pro = $this->product_model->get_Id($idpro);
          $link = base_url($pro[0]['alias'].".html");
        }
        $tongtien = $tongtien+ $pro[0]['sale_price']*$v['qty'];
      ?>

      <tr class="cart_item">
        <td class="product-name"><?php  echo $pro[0]['title_vn']; ?>
          <strong class="product-quantity">× <?php echo $v['qty'];  ?></strong>
        </td>
        <td class="product-total">
          <span class="woocommerce-Price-amount amount"><?php echo bsVndDot($pro[0]['sale_price']) ?><span class="woocommerce-Price-currencySymbol">₫</span></span>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  <tfoot>
    <tr class="cart-subtotal">
      <th>Tổng phụ</th>
      <td><span class="woocommerce-Price-amount amount"><?php echo bsVndDot($tongtien) ?><span class="woocommerce-Price-currencySymbol">₫</span></span></td>
    </tr>
    <tr class="order-total">
      <th>Tổng cộng</th>
      <td><strong><span class="woocommerce-Price-amount amount"><?php echo bsVndDot($tongtien) ?><span class="woocommerce-Price-currencySymbol">₫</span></span></strong> </td>
    </tr>
    <tr class="order-total">
      <th>Phí giao hàng</th>
      <td><strong><span class="woocommerce-Price-amount amount" id="trans_fee" name="trans_fee">0</span><span class="woocommerce-Price-currencySymbol">₫</span></strong> </td>
      <input type="hidden" name="transfee" id="transfee">
    </tr>
  </tfoot>
</table>
<?php } ?>
<div id="payment" class="woocommerce-checkout-payment">
      <ul class="wc_payment_methods payment_methods methods">
        <!-- <li class="wc_payment_method payment_method_bacs">
          <input id="" type="radio" class="input-radio" name="fpaymentmethod" value="Chuyển khoản ngân hàng" data-order_button_text="">
          <label for="payment_method_bacs">
            Chuyển khoản ngân hàng  </label>
            <div class="payment_box payment_method_bacs">
            <p>Thực hiện thanh toán vào ngay tài khoản ngân hàng của chúng tôi. Vui lòng sử dụng ID Đơn hàng của bạn như một phần để tham khảo khi thanh toán. Đơn hàng của bạn sẽ không được vận chuyển cho tới khi tiền được gửi vào tài khoản của chúng tôi.</p>
          </div>
        </li> -->
        <li class="wc_payment_method payment_method_cod">
            <input id="" type="radio" class="input-radio" name="fpaymentmethod" value="Thanh toán khi nhận hàng" checked="checked" data-order_button_text="">
            <label for="payment_method_cod">
          Trả tiền mặt khi nhận hàng  </label>
            <div class="payment_box payment_method_cod">
            <p>Trả tiền mặt khi giao hàng</p>
          </div>
        </li>
    </ul>
    <div class="form-row place-order">
    <noscript>
      Trình duyệt của bạn không hỗ trợ JavaScript, hoặc nó bị vô hiệu hóa, hãy đảm bảo bạn nhấp vào <em> Cập nhật giỏ hàng </ em> trước khi bạn thanh toán. Bạn có thể phải trả nhiều hơn số tiền đã nói ở trên, nếu bạn không làm như vậy.     <br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="Cập nhật tổng" />
    </noscript>
    <input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Đặt hàng" data-value="Đặt hàng">
    <input type="hidden" id="_wpnonce" name="_wpnonce" value="315cccd9ac"><input type="hidden" name="_wp_http_referer" value="/thanh-toan/?wc-ajax=update_order_review">  </div>
</div>
  </div>
</form>
</div>
</div>
</div><!--end .cont-news-detail-page-->
</div>                
</div><!--end .news-page-->
</div><!--end .content-top-->
</div>
</div>

<style type="text/css">
  .woocommerce-checkout-payment .button.alt{
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