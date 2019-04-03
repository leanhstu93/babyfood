<?php
$cart = $this->session->userdata('cart');
?>
<div class="breadcrumb">
  <div class="container"><?php echo $breadcrumb; ?></div>
</div>
<div class="space_10"></div>
<?php
if(empty($cart)):
?>
<div class="null_cart">
    <i class="iconnoti iconnull"></i>
    Không có sản phẩm nào <br> trong giỏ hàng
    <a href="/" class="buyother">Về trang chủ</a>

    <div class="callship">
        Khi cần trợ giúp vui lòng gọi <a href="tel:<?php echo $web["hotline"] ?>"><?php echo $web["hotline"] ?></a><br>(7h30 - 22h)
    </div>
</div>
<div class="clear"></div>
<?php else: ?>
<div class="wap-cart">
    <div class="box-cart">
      <form action="<?php echo base_url('payment/editcart');?>" method="post" id="form-cart" class="form-cart" >
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
          $link = base_url("deal/".$pro[0]['alias']."-".$pro[0]['Id'].".html");
        }else{
          $pro = $this->product_model->get_Id($idpro);
          $link = base_url($pro[0]['alias'].".html");
        }
        $tongtien = $tongtien+ $pro[0]['sale_price']*$v['qty'];

      ?>
        <div class="row-cart">
          <div class="images"> <a target="_blank" href="<?php echo $link; ?>"><img width="90" src="<?php echo PATH_IMG_PRODUCT.$pro[0]['images']; ?>"></a> 
              <button class="del" data-id="<?php echo $k; ?>" type="button"><span></span>Xóa</button>
          </div>
          <div class="colinfo" > 
          <p class="price-color"><?php echo bsVndDot($pro[0]['sale_price']) ?>₫</p>
          <a target="_blank" href="<?php echo $link; ?>"><?php echo $pro[0]['title_vn'] ?></a>
            <?php
            if(!empty($v['color'])){
               echo "<p class='bxoption'>";
              $color = $this->color_model->get_where((int)$v['color']); 
            ?>
            <span>Màu sắc:</span> <?php echo $color[0]['title_vn']  ?>
            <?php echo "</p>"; } ?>
            <?php
            if(!empty($v['size'])){
               echo "<p class='bxoption'>";
              $size = $this->size_model->get_where((int)$v['size']);    
            ?>
            <span>Size:</span> <?php  echo $size[0]['title_vn']; ?>
            <?php  echo '</p>'; } ?>

            <div class="choosenumber">
                <div class="abate active"><i></i></div>
                <div class="number"><?php echo $v['qty']; ?></div>
                <div class="augment"><i></i><i></i></div>
                 <input type="hidden" name="quanty[<?php echo $k; ?>]" value="<?php echo $v['qty'];  ?>" />
            </div>
            </div>
           
            
        </div>
        <?php }?>

        <div class="area_total">
                <div class="total">
                    <b>Tổng tiền:</b>
                    <strong id="totalOr" data-val="<?php echo $tongtien; ?>"><?php echo bsVndDot($tongtien) ?>₫</strong>
                </div>    
      </div>
   
        <?php } ?>
      </form>

      <form action="" method="post" class="form-order" id="form-order" >
    
        <div class="infouser <?php if(!empty($info_payment)) echo "hide"; ?>">  
            <div class="areainfo">
                <div class="left">
                    <input autocomplete="name" class="form-control" id="Customer_Name" name="fullname" placeholder="Họ và tên" type="text" value="<?php echo set_value("fullname",$info_payment->fullname); ?>">
                    <label id="name-error" class="texterror"></label>
                </div>
                <div class="right">
                    <input autocomplete="tel" class="form-control"  id="Customer_Phone" name="phone" placeholder="Số điện thoại" type="tel" value="<?php echo set_value("phone",$info_payment->phone); ?>">
                    <label id="phone-error" class="texterror"></label>
                </div>
                <input  name="note" placeholder="Yêu cầu khác (không bắt buộc)" type="text" value="<?php echo set_value("note",""); ?>" class="form-control">               
             </div>
        </div>
  <?php if(!empty($info_payment)): ?>
    <div class="infoold">
        Anh/ Chị: <strong><?php echo $info_payment->fullname; ?></strong> - <?php echo $info_payment->phone; ?>
        <span class="change">Sửa</span>
    </div>
    <?php endif; ?>
     <?php /*?> <div class="area_other receipt-methods">
        <div class="textnote"><b>Để được phục vụ nhanh hơn,</b> hãy chọn thêm:</div>
            <div class="address">
                

<span class="radio-ctnr  " id="radctnr-Delivery">
<input data-recalc="" id="Delivery" name="ReceiptMethod" type="radio" value="Delivery" <?php  if($info_payment->idprovinces>0) echo "checked"; ?>>    <label class="radio" for="Delivery">
<span class="box"></span>
<span class="text">Địa chỉ giao hàng</span>
</label>
</span>
            </div>

            <div class="area_address  <?php if($info_payment->idprovinces<=0) echo "hide"; ?>">
                <div class="firstaddress ">
                    <div class="citydis">
                        <span class="pdr-w50">
                            <select id="Customer_ProvinceId" name="ProvinceId" class="form-control" >
                            <option value="">Chọn Tỉnh/ Thành</option>
                            <?php
                            if(!empty($provinces)){
                                foreach($provinces as $item){
                                    echo "<option value=\"".$item["Id"]."\" title=".str_replace("-"," ",$this->page->strtoseo($item['title_vn'])).">".$item["title_vn"]."</option>";
                                }
                            }
                            ?>
                            </select>
                        </span>
                        <span class="pdr-w50">
                            <select  id="Customer_DistrictId" name="DistrictId" class="form-control"  >
                                <option selected="selected" value="">Chọn Quận/huyện</option>
                               
                                </select>
                      </span>
                    </div>
                    <input class="homenumber form-control" id="Customer_Address" name="address" placeholder="Số nhà, tên đường, phường / xã" type="text" value="<?php echo set_value("address",(!empty($info_payment->address)?$info_payment->address:"")) ?>">
                    <div class="clear"></div>
                </div>
                    
                 <div class="clear"></div>                                             
            </div>
                            
      <div class="clear"></div>
       </div><?php */?>
    </form>
      <div class="form-payment">
        <div id="paymentarea">
                <div class="pay-config" >
                    <div class="payonline ">
                        <div class="choosepayment" >Tiếp tục mua hàng <span>Mua nhiều trúng lớn</span></div>
                    </div>
                </div>
               <?php /*?> <div class="onlinemethod" >
                    <a href="#"  class="atm">Dùng thẻ ATM<span>Có internet Banking</a>
                    <a href="#" class="visa">Dùng thẻ Visa, MASTER</a>
                    <div class="clear">
                    <a class="rechoose" href="javascript:;">Chọn lại hình thức thanh toán</a>
                    </div>
                </div><?php */?>
        </div>
        <a href="#" id="btnOrder" class="payoffline choosepayment" >Thanh toán khi nhận hàng<span>Không mua không sao</span></a>

      </div>
  
    <div class="space_10"></div>
    </div>
  
</div>
<script type="text/javascript">
$(document).ready(function(){
  $("#Customer_ProvinceId").chosen();
  $("#Customer_DistrictId").chosen();
  $("#Customer_ProvinceId").change(function(){
    $("#Customer_DistrictId").chosen("destroy");
    $.get("/payment/district/"+$(this).val(),function(data){
      $("#Customer_DistrictId").html(data).chosen().change();
    });
  });
  $(".change").click(function(){
    $(".infoold").addClass("hide");
    $(".infouser").removeClass("hide");
  });
  <?php
  if($info_payment->idprovinces>0){
  ?>
  $("#Customer_ProvinceId").val(<?php echo $info_payment->idprovinces; ?>);
  $("#Customer_ProvinceId").trigger("chosen:updated");
  $("#Customer_DistrictId").chosen("destroy");
  $.get("/payment/district/<?php echo $info_payment->idprovinces; ?>",function(data){
    $("#Customer_DistrictId").html(data).chosen().change();
    <?php
    if($info_payment->iddistrict>0){
    ?>
    $("#Customer_DistrictId").val(<?php echo $info_payment->iddistrict; ?>);
    $("#Customer_DistrictId").trigger("chosen:updated");
    <?php } ?>
  });
  <?php } ?>
  $("#btnOrder").click(function(){
    $(".texterror").hide();
    data = $("#form-order").serialize();
    $.ajax({
      type: "POST",
      url: "/thanh-toan",
      data:data,
      dataType:"json",
      success: function(res) {
        if(res.error==true){
          $.each(res.message,function(item,value){
            $("#"+item).html(value).show();
          });
        }else{
          window.location="/dat-hang-thanh-cong"
        }
      }
    });
    return false;
  });
});
</script>
<?php endif; ?>