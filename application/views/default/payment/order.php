<?php
  $cart = $this->session->userdata('cart');
?>
<style type="text/css">
.cart-heading{
    background: #f26e21;
    margin:0;
    padding: 7px 10px;
    font-size: 17px;
    color:#fff;
}
.table-cart thead tr th{
    background: #f1f1f1;
    border-bottom: 1px solid #ddd;
}
.form-checkout .woocommerce-billing-fields{
    border:1px solid #f26e21;
    padding:10px;
}
.btn{
    border-radius: 0;
}
.btn-primary{
    background: #f26e21;
    border-color: #f26e21;
}
.btn-primary:hover{
    border-color: #f26e21;
    background: #f26e21;
    opacity: 0.8
}
.input-group .form-control:first-child, .input-group-addon:first-child, .input-group-btn:first-child>.btn, .input-group-btn:first-child>.btn-group>.btn, .input-group-btn:first-child>.dropdown-toggle, .input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle), .input-group-btn:last-child>.btn-group:not(:last-child)>.btn{
    border-radius: 0
}
.form-control,.input-group-addon{
    border-radius: 0
}
.checkout .input-group-addon:last-child{
    background: red;
    border-color: red;
    color:#fff;
    padding-left: 20px;
    padding-right: 20px;
}
</style>
<div class="background_main" role="main">
    <div class="container">
        <div class="content-top row">
            <div class="news-page col-xs-12 col-md-12">
                <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                    <!-- Breadcrumb NavXT 5.6.0 -->
                    <span property="itemListElement" typeof="ListItem">
  <a property="item" typeof="WebPage" title="" href="<?php echo base_url() ?>" class="home"><span property="name">Trang chủ</span></a>
                    <meta property="position" content="1">
                    </span> <i class="fa fa-angle-double-right"></i> <span property="itemListElement" typeof="ListItem"><span property="name">Thanh toán</span>
                    <meta property="position" content="2"></span>
                </div>
                <?php
                if(empty($cart)){
                ?>
                <div class="alert-block " style="text-align: center;">
                    <p style="font-size: 15px;margin-bottom: 10px;" class="alert alert-warning">Giỏ hàng trống</p>
                    <a href="/" class="btn btn-default">Tiếp tục mua hàng</a>
                </div>
            <?php } else { ?>
                <div class="singpages_lindo">
                    <div class="row">
                        <div class="col-md-8 col-sm-6 col-xs-12">
                        <form name="checkout" method="post" class="checkout" action="<?php echo current_url(); ?>" enctype="multipart/form-data">
                            <h3 class="cart-heading">1. Giỏ hàng</h3>
                            <table class="table table-cart" style="margin-bottom:0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="product-name">Sản phẩm</th>
                                        <th class="product-total">Đơn giá</th>
                                        <th class="product-total">Thành tiền</th>
										<th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(empty($cart)){
                                  ?>
                                    
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
                                            <td><img src="<?=PATH_IMG_PRODUCT.'thumbs/' . $pro[0]['images']?>" width="70"/></td>
                                            <td class="product-name">
                                            <p style="margin-bottom: 10px"><?php  echo $pro[0]['title_vn']; ?></p>
                                            <p>Số lượng: <input type="number" name="quanty[]" value="<?=$v['qty']?>" size="3" style="width: 40px;display: inline-block;text-align: center" onchange="updateOrder(this);" onkeyup="updateOrder(this);" /></p>
                                            </td>
                                            <td class="product-total">
                                            <span class="woocommerce-Price-amount amount"><?php echo bsVndDot($pro[0]['sale_price']) ?><span class="woocommerce-Price-currencySymbol">₫</span></span>
                                            </td>
                                            <td class="product-total">
                                            <span class="woocommerce-Price-amount amount" style="font-weight: bold"><?php echo bsVndDot($pro[0]['sale_price'] * $v['qty']) ?><span class="woocommerce-Price-currencySymbol">₫</span></span>
                                            </td>
											<td><a href="/payment/delcart/<?=$k?>" style="font-weight: bold">X</a></td>
                                        </tr>
                                  <?php } ?>
                                  </tbody>
                                  <tfoot>
                                  <!--<tr class="cart-subtotal">
                                  <th colspan="3">Tổng</th>
                                  <td colspan="2"><span class="woocommerce-Price-amount amount"><?php echo bsVndDot($tongtien) ?><span class="woocommerce-Price-currencySymbol">₫</span></span>
                                  </td>
                                  </tr>-->
                                  <tr class="order-total">
                                  <th colspan="3">Phí giao hàng</th>
                                  <td colspan="2"><strong><span class="woocommerce-Price-amount amount" id="trans_fee" name="trans_fee">0</span><span class="woocommerce-Price-currencySymbol">₫</span></strong> </td>
                                  </tr>
								  <tr id="rowCodeVoucher">
								  <?php if(($this->session->userdata('voucher_code'))) : ?>
								  
									<td colspan="3">Mã voucher</td>
									<td colspan="2"><strong><?=$this->session->userdata('voucher_code') . ' - giãm ' . bsVndDot($this->session->userdata('voucher_price'))?></strong></td>
								  <?php endif; ?>
                                  </tr>
								  <tr class="order-total">
                                  <th colspan="2"><form method="post" action="">
										<div class="input-group" style="margin-bottom:15px">
											<input type="text" class="form-control" name="rdcode" id="voucherCode" placeholder="Mã giãm giá" value="<?=$this->session->userdata('voucher_code')?>" <?=$this->session->userdata('voucher_code') !=''?' disabled':''?>>
											<span class="input-group-addon" id="btnAppleCode" <?=$this->session->userdata('voucher_code') !=''?' disabled':''?> style="cursor:pointer;">Áp dụng</span>
										</div>
									</form>
								</th>
                                  <td colspan="3" style="font-size:20px;color:red;text-align:right;">Tổng cộng: <strong><span id="totalPriceShip" class="woocommerce-Price-amount amount" style="font-size:20px;color:red"><?php echo bsVndDot($tongtien - $this->session->userdata('voucher_price')) ?></span><span class="woocommerce-Price-currencySymbol" style="font-size:20px;color:red">₫</span></strong> </td>
                                  </tr>
								  
                                  </tfoot>
                                </table>
								<script>
var totalOrder = <?=$tongtien?>;
</script>
                            <?php  }?>
                                <div class="form-row place-order" style="margin-bottom:15px">
                                <noscript>Trình duyệt của bạn không hỗ trợ JavaScript, hoặc nó bị vô hiệu hóa, hãy đảm bảo bạn nhấp vào <em> Cập nhật giỏ hàng </ em> trước khi bạn thanh toán. Bạn có thể phải trả nhiều hơn số tiền đã nói ở trên, nếu bạn không làm như vậy.     <br/>
                                <input type="submit" class="btn btn-primary" name="woocommerce_checkout_update_totals" value="Cập nhật tổng" /></noscript>
                <hr />
                <div class="row">
                    <div class="col-md-6">
        				<a href="" onClick="close_box_popup();return false;" class="btn btn-default btnksp"><i class="fa fa-long-arrow-left" ></i> Tiếp tục mua hàng</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <button name="update-cart" value="1" style="display:none">Update</button>
                    </div>
                </div>
                <div class="clearfix"></div>
    <?php if($error_code) echo '<div class="alert alert-danger">'.$error_code.'</div>'?>
                        </div>
                        </form>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                        <form method="post" class="form-checkout" action="<?php echo current_url(); ?>" enctype="multipart/form-data">
                            <h3 class="cart-heading">2. Thông tin thanh toán</h3>
                            <div class="woocommerce-billing-fields">
                                                    
                                                    <p class="form-group" id="billing_first_name_field">
                                                        <label for="billing_first_name" class="">Họ và tên <abbr class="required" title="bắt buộc">*</abbr>
                                                        </label>
                                                        <input type="text" class="form-control" name="fullname" id="" placeholder="" autocomplete="given-name" value="<?php echo set_value(" fullname ",$info_payment->fullname); ?>" required="">
                                                    </p>
                                                    <div class="clear"></div>

                                                    <p class="form-group" id="billing_email_field">
                                                        <label for="billing_email" class="">Địa chỉ email <abbr class="required" title="bắt buộc">*</abbr>
                                                        </label>
                                                        <input type="email" class="form-control" name="email" id="" placeholder="" autocomplete="email" value="<?php echo set_value(" email ",$info_payment->email); ?>" required="">
                                                    </p>

                                                    <p class="form-group" id="billing_phone_field">
                                                        <label for="billing_phone" class="">Số điện thoại <abbr class="required" title="bắt buộc">*</abbr>
                                                        </label>
                                                        <input type="tel" class="form-control" name="phone" id="" placeholder="" autocomplete="tel" value="<?php echo set_value(" phone ",$info_payment->phone); ?>" required="">
                                                    </p>
                                                    <div class="clear"></div>

                                                    <p class="form-group" id="billing_address_1_field">
                                                        <label for="billing_address_1" class="">Địa chỉ nhận hàng<abbr class="required" title="bắt buộc">*</abbr>
                                                        </label>
                                                        <input type="text" class="form-control " name="address" id="" placeholder="" autocomplete="address-line1" value="<?php echo set_value(" address ",$info_payment->address); ?>" required="">
                                                    </p>

                                                    <div class="form-group" id="billing_address_1_field">
                                                        <label for="billing_address_1" class="">Tỉnh thành<abbr class="required" title="bắt buộc">*</abbr>
                                                        </label>
                                                        <div class="row">
                                                            <!--<div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select id="ship" name="province_id" class="form-control" onchange="loadDistrict(this)" required="">
                                                                <option value="">-Tỉnh/Thành Nhận hàng-</option>
                                                                <?php
                                                                foreach($provinces as $item)  {
                                                                ?>
                                                                <option value="<?=$item['Id']?>"> <?=$item['title_vn']?></option>
                                                                <?php } ?>
                                                            </select>
                                                            </div>-->
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <select id="district" name="district_id" class="form-control" onchange="shipFee(this)" required="">
                                                                <option value="">-Quận/huyện-</option>
                                                                <?php
                                                                $districts = $this->district_model->list_district('idcat=1');
                                                                foreach($districts as $item)  {
                                                                ?>
                                                                <option value="<?=$item['Id']?>" data-price="<?=$item['ship']?>" data-priceformat="<?=number_format($item['ship'])?>">Hồ Chí Minh - <?=$item['title_vn']?> (<?=number_format($item['ship'])?>đ)</option>
                                                                <?php } ?>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="form-group" id="order_comments_field">
                                                        <label for="order_comments" class="">Ghi chú đơn hàng</label>
                                                        <textarea name="note" class="form-control" id="" placeholder="Ghi chú về đơn hàng, ví dụ: lưu ý khi giao hàng." rows="2" cols="5"><?php echo set_value("note",""); ?></textarea>
                                                    </p>
													<p class="form-group">
														<div class="g-recaptcha" id="g-recaptcha" data-sitekey="6LffpH8UAAAAANRn1FR7XxeC6OoXMYPtQOMzihu0"></div>
														<?=form_error('ReCaptcha')?>
													</p>
                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-primary btn-block" name="woocommerce_checkout_place_order" id="place_order" value="Đặt hàng" data-value="Đặt hàng" disabled>
                                                    </div>
													<input type="hidden" name="transfee" id="transfee">
													<script>
var onloadCallback = function() {
    grecaptcha.render('g-recaptcha', {
      'sitekey' : '6LffpH8UAAAAANRn1FR7XxeC6OoXMYPtQOMzihu0',
      'callback' : correctCaptcha
    });
  };
var correctCaptcha = function(response) {
    if(response.length > 0) {
        $('#place_order').removeAttr('disabled').removeClass('disabled');
    } else {
        console.log('error');
    }
};
</script>
                                                    <script>
													
                                                function shipFee(a) {
                                                    var x = (a.dataset.priceformat || a.options[a.selectedIndex].dataset.priceformat);
                                                    document.getElementById('trans_fee').innerHTML = x;
                                                    document.getElementById('transfee').value = a.options[a.selectedIndex].dataset.price;
													$.ajax({
														url: '<?=base_url('ajax/getShip')?>',
														type: 'get',
														data: {iddistrict: a.options[a.selectedIndex].value},
														dataType: 'json',
														success: function(res) {
															console.log(res);
															$('#totalPriceShip').text(res.total);
															
														}
													})
                                                }
                                                function loadDistrict(elem) {
                                                    $.ajax({
                                                        url: '<?=base_url('ajax/loadDistrict')?>',
                                                        type: 'get',
                                                        data: {province_id: $(elem).find('option:selected').val()},
                                                        dataType: 'html',
                                                        success: function(res) {
                                                            $('#district').html(res);
                                                        }
                                                    })
                                                }
												function updateOrder(elem){
													if($(elem).val() != '' && $(elem).val() > 0)
													$('button[name="update-cart"]').trigger('click');
												}
                                            </script>

                                                </div>
                                </form>                
                        </div>
                    </div>
                    
                </div>
            <?php } ?>


            </div>
        </div>
    </div>
</div>