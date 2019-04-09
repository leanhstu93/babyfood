<div class="clearfix"></div><div class="header_menu_bottom">
        <div class="container">
        <div class="lindo_row">
              <div class="lindo-width-20" style="padding-right:0">
              <h2 class="nav_lindo"><i class="fa fa-bars" aria-hidden="true"></i> DANH MỤC SẢN PHẨM</h2>
              </div>

               <div class="lindo-width-80" style="padding-left:0">
                 <div class="menu-menu-header-container">
                  <ul id="menu_main" class="menu">
                    <li class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-258">
                      <a style="text-decoration: none;" title="Sản phẩm đang khuyến mãi" href="<?php echo base_url("dang-khuyen-mai") ?>">Sản phẩm đang khuyến mãi<i class="icon-hot"></i></a>
                    </li>
                    <?php $i=0; ?>
                    <?php foreach($info_ct as $item) { ?>
                      <?php if ($i == 4 ) break; ?>
                      <li class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-258">
                        <a style="text-decoration: none;" title="<?php echo $item['catelog_title']?>" href="<?php echo base_url($item['alias']); ?>"><?php echo $item['catelog_title']?><i class="icon-hot"></i></a>
                      </li>
                    <?php $i++; ?>
                    <?php } ?>   
                  </ul>
                </div>

              </div>
        </div>
        </div>
     </div>
<?php
$menus = $this->catelog_model->get_list(array('ticlock'=>'0', 'parentid' => 0),'sort ASC',0,0);
?>
<div id="lindo-nav-menu-3" class="widget_lindo-nav-menu">
<div class="lindo_category_bg">
  <div class="container">
   <div class="lindo-row">
    <div class="lindo-width-20">
   <div class="categories">
    <ul class="lindo_mega_left">
      <li>
        <a title="Sản phẩm đang khuyến mãi" href="<?php echo base_url("dang-khuyen-mai") ?>"><span class="fl-img">
          <img id="imgIcon" alt="" src="nextweb/uploads/2016/07/khuyen-mai-1.png" style="display: block;">
          </span>Sản phẩm đang khuyến mãi</a>
      </li>
     <?php foreach($menus as $item) { ?>
        <li data-category-hover="cat1">
          <a title="<?php echo $item['title_vn']?>" href="<?php echo base_url($item['alias']); ?>"><span class="fl-img">
          <img id="imgIcon" alt="" src="<?=base_url('data/Catelog/'.$item['images'])?>" onerror="this.src='nextweb/uploads/2016/07/khuyen-mai-1.png'" style="display: block;">
          </span><?php echo $item['title_vn']?></a>

          <ul class="lindo_supmenu " style="min-width: 920px; max-height: 950px;">
            <div class="sub-menu">
            <?php $mnChil=0; ?>
			<?php
			$sub1_menus = $this->catelog_model->get_list(array('ticlock'=>'0', 'parentid' => $item['Id']),'sort ASC',0,0);
			?>
            <?php foreach($sub1_menus as $item_chil) { ?>
                <?php //if ($mnChil == 8 ) break; ?>
                  <div class="col-md-3">
                    <h3 style="font-weight: bold;"><a href="<?php echo base_url($item_chil['alias']); ?>"><?php echo $item_chil['title_vn']?></a></h3>
                    <?php $mnChilSe=0; ?>
					<?php
					$sub2_menus = $this->catelog_model->get_list(array('ticlock'=>'0', 'parentid' => $item_chil['Id']),'sort ASC',0,0);
					?>
                    <?php foreach($sub2_menus as $count_sub2 => $item_chil_second) { ?>
                        <?php //if ($count_sub2 == 5 ) break; ?>
                          <p><a href="<?php echo base_url($item_chil_second['alias']); ?>"><?php echo $item_chil_second['title_vn']?></a></p>
                        
                      <?php } ?>
                  </div>

                <?php $mnChil++; ?>
              <?php } ?>
            </div>
          </ul>
                       
        </li>
        <?php } ?>
  </div>
  </div>
  <div class="lindo-width-80" style="padding-left:0">
     <div class="lindo-row-sup">
   
   <div class="lindo-witch-8" style="padding-left:0; padding-right:0">

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <?php $sl=0; ?>
        <?php foreach ($slide_home as $item){ ?>
          <?php if ($sl==0) { ?>
            <li data-target="#myCarousel" data-slide-to="<?php echo $sl ?>" class="active"></li>
          <?php }else{ ?>
             <li data-target="#myCarousel" data-slide-to="<?php echo $sl ?>"></li>
          <?php } ?>
          <?php $sl++; ?>
      <?php } ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <?php $sl=0; ?>
        <?php foreach ($slide_home as $item){ ?>
            <?php if ($sl==0) { ?>
              <div class="item active">
                <a href="<?php echo base_url($item['link']); ?>">
                  <img src="<?php echo PATH_IMG_BANNER.$item['images']."?v=".time();?>" alt="<?php echo $item['images'] ?>" width="100%" style="max-height: 370px">
                </a>
              </div>
            <?php }else{ ?>
                <div class="item">
                  <a href="<?php echo base_url($item['link']); ?>">
                    <img src="<?php echo PATH_IMG_BANNER.$item['images']."?v=".time();?>" alt="<?php echo $item['images'] ?>" width="100%" style="max-height: 370px">
                  </a>
                </div>
            <?php } ?>
            <?php $sl++; ?>
        <?php } ?>

    
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <!-- <span class="glyphicon glyphicon-chevron-left"></span> -->
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <!-- <span class="glyphicon glyphicon-chevron-right"></span> -->
      <span class="sr-only">Next</span>
    </a>
  </div>

     
   </div>
     <div class="lindo-witch-2" style="padding-left:0">
      <div class="lindo_pr_right">
          <?php foreach ($product_views as $item){ ?>
            <div class="header_style_produc">
              <a href="<?php echo base_url($item['alias'].'.html'); ?>" title="<?=$item['title_vn']?>">
                <img style="width: 98%;padding: 1%;border-radius: 0%;height: auto;max-height: 180px" src="<?php echo PATH_IMG_PRODUCT.$item['images']."?v=".time();?>" class="" />
              </a>
            </div>
        <?php } ?> 
        </div>
     </div>
     </div>
  </div>
  </div>
</div>

</div>


</div>
<div class="ads_home_lindo_three_col">
<div class="container">
<div class="row row-desktop">
<!-- update banner -->
<?php if(!empty($banner_under_slide)){ foreach($banner_under_slide as $key => $item) { 
  if($key==2) break;?>
<div class="col-sm-4 col-md-4">
  <div class="lindo_ads_3">
    <a title="seo title" href="<?php echo base_url($item['link']); ?>" target="">
      <img alt="seo alt" src="<?php echo PATH_IMG_BANNER.$item['images']."?v=".time();?>" style="height:369px;width: 100%">
    </a>
  </div>
</div>
<?php }} ?>
<div class="col-sm-4 col-md-4 col-news-desktop">
  <div class="home-top3-news" style="background: #fff;padding: 0">
  <div class="header-news"><a href="<?php echo base_url("/chu-de/bai-viet") ?>">Tin tức</div>
<?php
$info_cat = $this->catnews_model->get_list(array('alias'=>'bai-viet'), 3);
$contents = $this->news_model->get_list(array("ticlock"=>0,"idcat"=>$info_cat[0]['Id']),"sort DESC, Id DESC",5,0);
foreach ($contents as $key => $item) { ?>
  <div class="top3-news">
    <div class="thumb"><a href="<?php echo base_url('bai-viet/'.$item['alias']); ?>"><img width="150" height="150" src="<?php echo PATH_IMG_NEWS.$item['images']."?v=".time();?>" class="img-responsive wp-post-image" alt="" srcset="<?php echo PATH_IMG_NEWS.$item['images']."?v=".time();?>" sizes="(max-width: 150px) 100vw, 150px" />       </a></div>
    <h4><a href="<?php echo base_url('bai-viet/'.$item['alias']); ?>"><?=$item['title_vn']?></a></h4>
  </div>
<?php }
?></div>
</div>
</div>

<div class="row row-mobile">
<!-- update banner -->
<?php if(!empty($banner_under_slide)){ foreach($banner_under_slide as $key => $item) { 
  if($key==2) break;?>
<div class="ads_mobile">
  <div class="">
    <a title="seo title" href="<?php echo base_url($item['link']); ?>" target="">
      <img alt="seo alt" src="<?php echo PATH_IMG_BANNER.$item['images']."?v=".time();?>">
    </a>
  </div>
</div>
<?php }} ?>
<div class="" style="clear: both;">
  <div class="home-top3-news" style="background: #fff;padding: 0">
  <div class="header-news"><a href="<?php echo base_url("/chu-de/bai-viet") ?>">Tin tức</div>
<?php
$info_cat = $this->catnews_model->get_list(array('alias'=>'bai-viet'), 3);
$contents = $this->news_model->get_list(array("ticlock"=>0,"idcat"=>$info_cat[0]['Id']),"sort DESC, Id DESC",5,0);
foreach ($contents as $key => $item) { ?>
  <div class="top3-news">
    <div class="thumb"><a href="<?php echo base_url('bai-viet/'.$item['alias']); ?>"><img width="150" height="150" src="<?php echo PATH_IMG_NEWS.$item['images']."?v=".time();?>" class="img-responsive wp-post-image" alt="" srcset="<?php echo PATH_IMG_NEWS.$item['images']."?v=".time();?>" sizes="(max-width: 150px) 100vw, 150px" />       </a></div>
    <h4><a href="<?php echo base_url('bai-viet/'.$item['alias']); ?>"><?=$item['title_vn']?></a></h4>
  </div>
<?php }
?></div>
</div>
</div>

</div>
</div>  
<div role="main" class="home_main_lindo">
  
  <?php $j=1; ?>
  <?php foreach($cateloghome as $item_ct) { ?>
    <?php $arrId = array(); ?>
    <?php $arrId[] = $item_ct['Id']; ?>
    <div id="" class="container widget_home-produc-one">

      <div class="content_block lindo-home-box-pro" itemtype="http://schema.org/ItemList">
      <div class="row category_box">
            <div class="col-sm-3 col-md-2 lindo-right-0">
            <div class="lindo_tang_<?php echo $j; ?>f lindotang" style="max-height: 472px;overflow: hidden;">
                 <div class="lindo-category_icon"><?php echo $j; ?>F</div>
                 <a title="<?php echo $item_ct['title_vn'] ?>" href="<?php echo base_url($item_ct['alias']); ?>">
                    <div class="pro-lindo-title">
                        <p class="icon-lindo"><img src="<?=base_url('data/Catelog/'.$item_ct['images'])?>" onerror="this.src='nextweb/uploads/2016/07/khuyen-mai-1.png'" alt="icon"></p>
                        <h2><?php echo $item_ct['title_vn'] ?></h2>
                    </div>
                </a>

               <ul class="sub_category">
                <?php foreach($menu as $item_chil) { ?>
                  <?php if ($item_chil['parentid'] == $item_ct['Id']){ ?>
                    <?php $arrId[] = $item_chil['Id']; ?>
                    <li><a style="text-decoration: none;font-size: 13px !important" href="<?php echo base_url($item_chil['alias']); ?>"><?php echo $item_chil['title_vn']?></a></li>
                  <?php } ?>
                <?php } ?>
              </ul>
           </div>
          </div>

          <!--<div class="col-sm-12 col-md-4 lindo-left-0 lindo-right-0 banner hidden-sm">
              
            <?php if(!empty($banner_danhmuc)){ foreach($banner_danhmuc as $banner) { ?>
              <?php if ($banner['parentid'] == $item_ct['Id']){ ?>
                <a href="<?php echo base_url($banner['link']); ?>">
                  <img src="<?php echo PATH_IMG_BANNER.$banner['images']."?v=".time();?>" alt="banner" style="height: 100%">
                </a>
              <?php } ?>
            <?php } } ?>

          </div>-->

          <div class="col-sm-9 col-md-10 lindo-left-0">
                <div class="items lindo-pro-style-sp">
                  <?php $i=0; ?>
                  <?php $sql_product = "SELECT Id,title_vn,price, sale_price, images, alias, codepro FROM mn_product WHERE idcat ='".$item_ct['Id']."' OR idcat IN (SELECT Id FROM mn_catelog WHERE parentid='".$item_ct['Id']."' OR parentid IN (SELECT Id FROM mn_catelog WHERE parentid='".$item_ct['Id']."')) ORDER BY Id DESC";
				  $info_pr = $this->product_model->get_query($sql_product,10,0); 
				  ?>
                    <?php foreach ($info_pr as $item_pr){ ?>
                        <?php //if (in_array($item_pr['idcat'], $arrId)){ ?>
                      <?php if ($i == 10) break; ?>
                      <div itemprop="itemListElement" itemscope="" name="<?php echo $item_pr['name'] ?>" itemtype="http://schema.org/Product" class="col-md-5th-1 col-sm-3 col-xs-6 item">
                        <?php $price = (int)$item_pr['price'];$sale_price = $item_pr['sale_price'];
                        if ($price != 0 && $price != $sale_price) {
                            $pt = 100-floor(($sale_price/ $price)*100) ?>
                            <div class="sale_off_lindo"><strong>
                            <i><?php  echo $pt?>%</i></strong></div>
                        <?php }else{ echo "";} ?>

                        <a href="<?php echo base_url($item_pr['alias'].'.html'); ?>" rel="bookmark" title="<?php echo $item_pr['title_vn'] ?>">
                          <span class="onsale">Giảm giá!</span>
                          <img width="300" height="300"
                               src="<?php echo LAZYLOAD_IMAGE ?>"
                               class="lazyload attachment-shop_catalog size-shop_catalog wp-post-image"
                               alt="<?php echo $item_pr['title_vn'] ?>" title="<?php echo $item_pr['title_vn'] ?>"
                               data-src="<?php echo resizeImage(PATH_IMG_PRODUCT.$item_pr['images'], 129,129,3)?>" />
                            <p class="max-lines"><?php echo $item_pr['title_vn'] ?></p>
                        </a>
                          <div style="text-align:center;font-size:13px;font-weight:bold;">Mã SP: <?=$item_pr['codepro']?></div>                
                          <!-- <div class="star-rating" title="Được xếp hạng 5 5 sao"><span style="width:100%"><strong class="rating">5</strong> trên 5</span></div> -->
                          <span class="price">
                            
                        <?php
                          if ((int)$item_pr['price'] != 0 && (int)$item_pr['price'] != $item_pr['sale_price']) {
                              ?>
                              <del><span class="woocommerce-Price-amount amount">
                              <?php echo bsVndDot($item_pr['price']); ?>
                              <span class="woocommerce-Price-currencySymbol">&#8363;</span></span></del>
                        <?php } ?>
                              
                        <ins><span class="woocommerce-Price-amount amount"><?php echo bsVndDot($item_pr['sale_price']); ?><span class="woocommerce-Price-currencySymbol">&#8363;</span></span></ins>
                          </span>
                      </div>
                      <?php $i++; ?>
                    <?php //} ?>
                  <?php } ?>              
               </div>  
           </div>

      </div>
    </div>
  </div>
  <?php $j++; ?>
  <?php /*}*/ } ?>
    
  <!-- <?php $l==0 ?>
    <?php foreach($info_ct as $item_ct) { ?>
    <?php if ($item_ct['parentid'] != 0){ ?>
      <?php if($l==4) break; ?>
    <div id="" class="container widget_home-produc-one">

      <div class="content_block lindo-home-box-pro" itemtype="http://schema.org/ItemList">
      <div class="row category_box">
            <div class="col-sm-12 col-md-12 lindo-left-0">
              <div id="content" class="page-title woocommerce-breadcrumb">
                  <span><h1 style="font-weight: bold;font-size: 20px">  <i class="fa fa-chevron-right" aria-hidden="true"></i> <?php echo $item_ct['catelog_title'] ?> | <a style="color: #aaa;font-size: 12px;font-weight: normal;" title="Xem thêm" href="<?php echo base_url($item_ct['alias']); ?>">
                    Xem thêm <i class="fa fa-angle-double-right"></i>
                    </a></h1>
                  </span>
              </div>
                
                <div class="items lindo-pro-style-sp">
                  <?php $i=0; ?>
                    <?php foreach ($info_pr as $item_pr){ ?>
                      <?php if ($item_pr['idcat'] == $item_ct['catelog_id'] || $item_pr['idcat'] == $item_ct['parentid']){ ?>
                      <?php if ($i == 6) break; ?>
                      <div itemtype="http://schema.org/Product" class="col-md-2 col-sm-2 col-xs-6 item" style="border-left: 1px solid #e5e5e5;border-right: 1px solid #e5e5e5">
                        <?php
                        if ($item_pr['price'] != 0 && $item_pr['price'] != $item_pr['sale_price']) {
                          if($item_pr['price']>0){
                            if($item_pr['price']>0) 
                            $pt = 100-floor(($item_pr['sale_price']/ $item_pr['price'])*100); else  $pt=0;
                            ?>
                            <div class="sale_off_lindo"><strong>
                            <i><?php  echo $pt?>%</i></strong></div>
                      <?php }} ?>

                        <a href="<?php echo base_url($item_pr['alias'].'.html'); ?>" rel="bookmark" title="<?php echo $item_pr['title_vn'] ?>">
                          <span class="onsale">Giảm giá!</span>
                          <img width="300" height="300" src="<?php echo PATH_IMG_PRODUCT.$item_pr['images']."?v=".time();?>" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="" title="" srcset="<?php echo PATH_IMG_PRODUCT.$item_pr['images']."?v=".time();?>" sizes="(max-width: 300px) 100vw, 300px" /><p class="max-lines"><?php echo $item_pr['title_vn'] ?></p></a>
                                          
                          <div class="star-rating" title="Được xếp hạng 5 5 sao"><span style="width:100%"><strong class="rating">5</strong> trên 5</span></div>
                          <span class="price">
                            
                              <?php
                                  if ($item_pr['price'] != 0 && $item_pr['price'] != $item_pr['sale_price']) {
                                      ?>
                                      <del><span class="woocommerce-Price-amount amount">
                                      <?php echo bsVndDot($item_pr['price']); ?>
                                      <span class="woocommerce-Price-currencySymbol">&#8363;</span></span></del>
                                <?php } ?>
                              
                        <ins><span class="woocommerce-Price-amount amount"><?php echo bsVndDot($item_pr['sale_price']); ?><span class="woocommerce-Price-currencySymbol">&#8363;</span></span></ins>
                          </span>
                      </div>
                      <?php $i++; ?>
                    <?php } ?>
                  <?php } ?>              
               </div>  
           </div>
                
        </div>
    </div>
    </div>
    <?php $l++; ?>
    <?php } ?>
  <?php } ?> -->

  </div>

<style>

</style>