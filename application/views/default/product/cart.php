<?php
$cart = $this->session->userdata('cart');
?>
<?php var_dump($cart); ?>
<h2 class="title"><span>Giỏ hàng của bạn</span></h2>

<?php
if(empty($cart)){
?>
<p>
<p class="empty">Giỏ hàng trống</p>
</p>
<?php }else{ 
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
<p>
  <p align="center"><a target="_blank" href="<?php echo $link; ?>"><img width="90" src="<?php echo PATH_IMG_PRODUCT.$pro[0]['images']; ?>"></a></p>
    <p>
      <spong>Sản phẩm</spong>
        <a target="_blank" href="<?php echo $link; ?>"><?php echo $pro[0]['title_vn'] ?></a>
        <?php if(!empty($v['color']) || !empty($v['size'])){
    echo "<p class='bxoption'>";
    ?>(<?php
     if(!empty($v['color'])){
      $color = $this->color_model->get_where((int)$v['color']); 
     ?>
    Màu sắc: <span><?php echo $color[0]['title_vn'].", "  ?></span>
    <?php } ?>
        <?php
     if(!empty($v['size'])){
       $size = $this->size_model->get_where((int)$v['size']);   
     ?>
    Size: <?php  echo $size[0]['title_vn']; ?>
    <?php } ?>)
         <?php echo '</p>'; } ?>
  </p>
    <p align="center">
      <p class="tibcart">Giá</p>
        <p class="bsd-cart"><?php echo bsVndDot($pro[0]['sale_price']) ?> vnđ</p>
    </p>
    <p align="center">
      <p class="tibcart">Số lượng</p>
        <select name="quanty[<?php echo $k; ?>]">
        <?php 
    for($i=1;$i<=20;$i++){
    ?>
        <option value="<?php echo $i; ?>" <?php if($i==$v['qty']) echo 'selected'; ?>><?php echo $i; ?></option>
        <?php } ?>
         </select>  
    </p>
    <p align="center">
      <p class="tibcart">Thành tiền</p>
        <p class="bsd-cart"><?php echo bsVndDot($pro[0]['sale_price']*$v['qty']) ?> vnđ</p>
    </p>
    <p align="center" class="row-act">
    <a href="<?php echo base_url('payment/delcart/'.$k); ?>" title="Xóa"  class="btndeletecart" data='<?php echo $k; ?>'><i class="fa fa-times" aria-hidden="pue"></i></a>
   </p>
</p>
<?php }?>
</div>
<div class="row-total">
  Thành tiền: <span><?php echo bsVndDot($tongtien)."vnđ" ?></span>
</div>
<div class="clear">
  <a href="" onClick="close_box_popup();return false;" class="btnksp"><i class="fa fa-long-arrow-left" ></i> Tiếp tục mua hàng</a>
  <a href="/gio-hang" rel="nofollow" class="btnpayshort">Tiền hành thanh toán <i class="fa fa-long-arrow-right" ></i></a>  
</div>
<?php } ?>
</div>
</div>