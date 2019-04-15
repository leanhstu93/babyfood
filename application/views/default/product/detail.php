
<div class="clearfix"></div>
<hr>
<div class="background_list_product product-template-default single single-product  woocommerce woocommerce-page">
<div class="container">

  <?php foreach($prod as $item) { ?>

	<div id="container">
    <div id="content" role="main">
      <nav class="woocommerce-breadcrumb" itemprop="breadcrumb">
        <a href="<?php echo base_url() ?>">Trang chủ</a>&nbsp;&#47;&nbsp;<a href="<?php echo base_url($info_cat[0]['alias']); ?>"><?php echo $info_cat[0]['title_vn']; ?></a>&nbsp;&#47;&nbsp;<?php echo $item['title_vn']; ?>
      </nav>

      <?php if ($this->session->flashdata('message_addcart_fromcat_success')) { ?>
          <?php $message = $this->session->flashdata('message_addcart_fromcat_success');
             echo '<div class="woocommerce-message"><a href="thanh-toan" class="button wc-forward">Xem giỏ hàng</a><i class="fa fa-cart-plus" aria-hidden="true"></i> '.$message.'</div>'; 
          ?>
      <?php } ?> 
      <?php if ($this->session->flashdata('message_addcart_fromdetail_success')) { ?>
          <?php $message = $this->session->flashdata('message_addcart_fromdetail_success');
             echo '<div class="woocommerce-message"><a href="thanh-toan" class="button wc-forward">Xem giỏ hàng</a><i class="fa fa-cart-plus" aria-hidden="true"></i> '.$message.'</div>'; 
          ?>
      <?php } ?> 

<div itemscope itemtype="http://schema.org/Product" id="product-115" class="post-115 product type-product status-publish has-post-thumbnail first instock sale shipping-taxable purchasable product-type-simple">

	
	<span class="onsale">Giảm giá!</span>
<div class="images">
	<!-- <a href="" itemprop="image" class="woocommerce-main-image zoom" title="" data-rel="prettyPhoto"> -->
    <img id="myImg" width="366" height="306" src="<?php echo PATH_IMG_PRODUCT.$item['images']."?v=".time();?>" class="attachment-shop_single size-shop_single wp-post-image" alt="<?php echo $item['title_vn'] ?>" title="" srcset="<?php echo PATH_IMG_PRODUCT.$item['images']."?v=".time();?>" sizes="(max-width: 366px) 100vw, 366px" />
  <!-- </a> -->
</div>


<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<div class="summary entry-summary">
<h1 itemprop="name" class="product_title entry-title"><?php echo $item['title_vn']; ?></h1>
<div class="rating_sku">
<!-- <div class="sku_lindo">

		<span class="sku_wrapper">Mã: <span class="sku" itemprop="sku"><?php echo "MSP-".$item['Id'].'-'.$item['idcat']; ?></span></span>

	</div> -->
<div class="rating_lindo">
	<div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
		<!-- <div class="star-rating" title="Được xếp hạng 5 5 sao">
      <span style="width:100%">
        <strong itemprop="ratingValue" class="rating">5</strong> trên <span itemprop="bestRating">5</span>dựa trên <span itemprop="ratingCount" class="rating">1</span> bình chọn của khách hàng</span>
    </div> -->
		<!-- <a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<span itemprop="reviewCount" class="count">1</span> đánh giá của khách hàng)</a> -->	</div>
</div>
</div>

<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<p style="margin-bottom:5px;font-size: 16px;">Mã SP: <span style="font-size:16px;font-weight:bold;"><?=$item['codepro']?></span></p>
    <p style="margin-bottom:5px;font-size: 16px;">Tình trạng: <span style="font-size:16px;font-weight:bold;" class="<?= ($item['status'] == 0) ? 'in-stock' : 'out-stock' ?>"><?= ($item['status'] == 0) ? 'Còn hàng' : 'Hết hàng' ?></span></p>
<div class="lindo_sale_price">
<?php
    if ((int)$item['price'] != 0 && (int)$item['price'] != $item['sale_price']) {
        $pt = 100-floor(($item['sale_price']/ $item['price'])*100);
        ?>
  <div class="lindo_price">
  	<p class="price">
        <del>
            <span class="woocommerce-Price-amount amount"><?php echo bsVndDot($item['price']); ?>
                <span class="woocommerce-Price-currencySymbol">&#8363;</span>
            </span>
        </del>
        <ins>
            <span class="woocommerce-Price-amount amount">
                <?php echo bsVndDot($item['sale_price']); ?>
                <span class="woocommerce-Price-currencySymbol">&#8363;</span>
            </span>
        </ins>
    </p>
  </div>  
  <div class="lindo_sale">
    <div class="sale_off">Tiết kiệm đến<br><strong> <?php echo $pt?>%</strong></div> </div>  
<?php }else{ ?>
  <div class="lindo_price">
    <p class="price">
    <ins><span class="woocommerce-Price-amount amount"><?php echo bsVndDot($item['sale_price']); ?><span class="woocommerce-Price-currencySymbol">&#8363;</span></span></ins>    </p>
  </div> 
<?php } ?>
</div>    

	<meta itemprop="price" content="" />
	<meta itemprop="priceCurrency" content="VND" />
	<link itemprop="availability" href="https://schema.org/InStock" />

</div>
<?php if($item['description_vn']) : ?>
<div itemprop="description" class="">
<?php echo $item['description_vn']; ?>
</div>
<?php endif; ?>
<?php if($item['status'] == 0){ ?>
  <form action="<?php echo base_url('addcart_fromdetail'); ?>" method="post" class="cart" id="" enctype='multipart/form-data'/>
    <div class="quantity"><span style="float: left;line-height: 36px;display: inline-block;margin-right: 5px;">Số lượng</span>&nbsp;
      <input type="number" step="1" min="1" max="" name="quanty" value="1" title="SL" class="input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric" />
    </div>
    <input type="hidden" name="add-to-cart" value="<?php echo $item['Id']; ?>" />
    <input type="hidden" value="<?php echo $prod[0]['Id'] ?>" name="idpro" />
    <input type="hidden" value="<?php echo $prod[0]['sale_price'] ?>" name="shop_price" id="sale_price" />
    <input type="hidden" name="name_pro" value="<?php echo $item['title_vn']; ?>" />
    <input type="hidden" name="alias" value="<?php echo $item['alias']; ?>" />
    <button type="submit" class="single_add_to_cart_button button alt" name="buynow" value="1">Mua ngay</button>
    <button type="submit" class="single_add_to_cart_button button alt" style="background: #0188b7!important">Cho vào giỏ</button>
	</form>
<?php } ?>
<div class="rating_sku"></div>
        <!--<div id="review_form">
          <div id="respond" class="comment-respond">
            <form action="<?php echo base_url('call-back'); ?>" method="post" class="cart" id="" enctype='multipart/form-data' style="border-top: 1px solid #aaa">
              <p><i class="fa fa-phone"></i> Yêu cầu gọi lại</p>
              <p class="comment-form-email">
                <input name="phone" type="numeric" value="" size="25" aria-required="true" required=""><input name="submit" type="submit" id="submit" class="submit" value="Gửi đi">
              </p>
              <p class="form-submit">
              <input type="hidden" name="idpro" value="<?php echo $item['Id']; ?>" />
              <input type="hidden" name="alias" value="<?php echo $item['alias']; ?>" />
              </p>      
          </form>
        </div>
      </div>-->


<ul class="share_lindo" style="border-top: 1px solid #ddd">
<li><span>Share ngay : </span> </li>
<li>
<a title="share Facebook" rel="nofollow" target="_blank" href="https://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $item['title_vn'] ?>&p[url]=<?php echo current_url() ?>"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
</li>
<li>
<a title="share Google Plus" rel="nofollow" target="_blank" href="https://plus.google.com/share?url=<?php echo current_url() ?>"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
</li>

<li>
<a title="share pinterest" rel="nofollow" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo current_url() ?>/&description=&media="><i class="fa fa-pinterest-square" aria-hidden="true"></i></a>
</li>
<li>
<a title="share twitter" rel="nofollow" target="_blank" href="https://twitter.com/share?url=<?php echo current_url() ?>/&text="><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
</li>
</ul>
</div><!-- .summary -->

	
	

<div id="exTab2" class="woocommerce-tabs wc-tabs-wrapper"> 
  <ul class="nav nav-tabs">
    <li class="active">
      <a  href="#1" data-toggle="tab">Mô tả</a>
    </li>
    <li class="">
      <a  href="#2" data-toggle="tab">Bình luận</a>
    </li>
    <!-- <li><a href="#2" data-toggle="tab"><h3>Đánh giá</h3></a>
    </li> -->
  </ul>

    <div class="tab-content ">
      <div class="tab-pane active" id="1">
        <br>
        <?php echo $item['content_vn']; ?>
      </div>
      <div class="tab-pane" id="2">
        <div class="fb-comments" data-href="<?=current_url()?>" data-numposts="5" data-width="100%"></div>
      </div>
      <!-- <div class="tab-pane" id="2">
        <div id="review_form_wrapper">
      <div id="review_form">
          <div id="respond" class="comment-respond">
            <h3 id="reply-title" class="comment-reply-title">Hãy là người đầu tiên nhận xét “Đường đua Hotwheels DJC05” <small><a rel="nofollow" id="cancel-comment-reply-link" href="/san-pham/duong-dua-hotwheels-djc05/#respond" style="display:none;">Hủy</a></small></h3>      

            <form action="https://babyshop.mauwebsitedep.com/wp-comments-post.php" method="post" id="commentform" class="comment-form">
                <p class="comment-notes"><span id="email-notes">Thư điện tử của bạn sẽ không được hiển thị công khai.</span> Các trường bắt buộc được đánh dấu <span class="required">*</span></p><p class="comment-form-rating"><label for="rating">Đánh giá của bạn</label><p class="stars"><span><a class="star-1" href="#">1</a><a class="star-2" href="#">2</a><a class="star-3" href="#">3</a><a class="star-4" href="#">4</a><a class="star-5" href="#">5</a></span></p><select name="rating" id="rating" aria-required="true" required="" style="display: none;">
                      <option value="">Xếp hạng…</option>
                      <option value="5">Rất tốt</option>
                      <option value="4">Tốt</option>
                      <option value="3">Trung bình</option>
                      <option value="2">Không tệ</option>
                      <option value="1">Rất Tệ</option>
                    </select></p><p class="comment-form-comment"><label for="comment">Đánh giá của bạn <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required=""></textarea></p><p class="comment-form-author"><label for="author">Tên <span class="required">*</span></label> <input id="author" name="author" type="text" value="" size="30" aria-required="true" required=""></p>
            <p class="comment-form-email"><label for="email">Email <span class="required">*</span></label> <input id="email" name="email" type="email" value="" size="30" aria-required="true" required=""></p>
            <p class="form-submit"><input name="submit" type="submit" id="submit" class="submit" value="Gửi đi"> <input type="hidden" name="comment_post_ID" value="34" id="comment_post_ID">
            <input type="hidden" name="comment_parent" id="comment_parent" value="0">
            </p>      
          </form>
              </div>
                </div>
          <div class="clear"></div>
        </div>
        <div class="start-line">
          <?php
              if($dcomment[0]['total'] >0) $star =round($dcomment[0]['star']/$dcomment[0]['total'],1);else $star = 0;
              $star_array = explode(".",$star) ;
              for($i=1;$i<=$star_array[0];$i++){ echo '<i class="fa fa-star yellow"></i>'; }
              if(isset($star_array[1])){
              $star_bellow = 5 -($star_array[0]+1) ;
              echo '<i class="fa fa-star-half-o yellow"></i>';
              }else{
              $star_bellow = 5 -$star_array[0] ;
              }
              for($i=1;$i<=$star_bellow;$i++){ echo '<i class="fa fa-star"></i>'; }
              ?>
          có
          <?php  echo $dcomment[0]['total']; ?>
          nhận xét </div>
          <div class="tab-title">Nhận xét của khách hàng</div>
              <p><?php echo $dcomment[0]['content']; ?></p>
      </div> -->
    </div>
    <?php if($item['tag']) { 
	$tags = explode(",", $item['tag']);
	foreach($tags as $k => $tag) {
		$tags[$k] = '<a href="/product/search?s='.$tag.'">'.$tag.'</a>';
	}
	?>
    <div style="margin: 15px 0;"><strong>Tags:</strong> <?php echo implode(",", $tags)?></div>
    <?php }?>
</div>

	<div class="related_products">
		<h2 class="title_related">Sản phẩm liên quan</h2>
		<ul class="products">
      <div class="row">

      <?php $i=0; ?>
			<?php if(!empty($prod_cl)){ foreach($prod_cl as $item) { ?>
        <?php if ($i==4) break; ?>
  			<div class="col-xs-6 col-sm-3 col-md-3">
          <li class="lindo_produc_style">
            <?php
              if ((int)$item['price'] != 0 && (int)$item['price'] != $item['sale_price']) {
                  $pt = 100-floor(($item['sale_price']/ $item['price'])*100);
                  ?>
                  <div class="sale_off_lindo"><strong>
                  <i><?php  echo $pt?>%</i></strong></div>
            <?php } ?>

          <a href="<?php echo base_url($item['alias'].'.html'); ?>" title="<?php echo $item['title_vn']; ?>" class="woocommerce-LoopProduct-link">
          	<span class="onsale">Giảm giá!</span>
          <img width="300" height="300" src="<?php echo PATH_IMG_PRODUCT.$item['images']."?v=".time();?>" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="<?php echo $item['title_vn']; ?>" title="<?php echo $item['title_vn']; ?>" srcset="<?php echo PATH_IMG_PRODUCT.$item['images']."?v=".time();?>" sizes="(max-width: 300px) 100vw, 300px" /><h3><?php echo $item['title_vn']; ?></h3>

          	<span class="price"><del>
             <?php
              if ((int)$item['price'] != 0 && (int)$item['price'] != $item['sale_price']) {
                  ?>
                  <span class="woocommerce-Price-amount amount"><?php echo bsVndDot($item['price']); ?><span class="woocommerce-Price-currencySymbol">&#8363;</span></span>
            <?php } ?>

            </del> <ins><span class="woocommerce-Price-amount amount"><?php echo bsVndDot($item['sale_price']); ?><span class="woocommerce-Price-currencySymbol">&#8363;</span></span></ins></span>
          </a>
          <form action="<?php echo base_url('addcart_fromcat'); ?>" method="post" class="cart" id="" enctype='multipart/form-data'/>
            <input type="hidden" name="quanty" value="1" />
            <input type="hidden" value="<?php echo $item['Id'] ?>" name="idpro" />
            <input type="hidden" value="<?php echo $item['sale_price'] ?>" name="shop_price" id="sale_price" />
            <input type="hidden" value="<?php echo current_url(); ?>" name="link" />
            <input type="hidden" value="<?php echo $item['title_vn'] ?>" name="name_pro" />
            <button rel="nofollow"  class="button product_type_simple add_to_cart_button ajax_add_to_cart">Thêm vào giỏ</button>
          </form>
        </li>
        </div>
        <?php $i++; ?>
      <?php }}else{ ?>
        <div class="alert alert-danger">Sản phẩm đang update.</div>
    <?php } ?>

</div>
</ul>
</div>

	<meta itemprop="url" content="" />

</div><!-- #product-115 -->


		
	</div>
<?php } ?>
</div>

</div>
</div>

<style>
#myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;

}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 10000; /* Sit on top */
    margin:  auto;
    padding-top: 20px;
    top: 0;
    width: 70%; /* Full width */
    height: auto; /* Full height */

    /*overflow: auto;*/ /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 60%;
    max-width: 700px;
    max-height: 95%;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 90%;
        margin-top: 50px;
    }
}
</style>
<script>
var modal = document.getElementById('myModal');
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}
var span = document.getElementsByClassName("close")[0];
span.onclick = function() { 
    modal.style.display = "none";
}
</script>