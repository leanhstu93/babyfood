<div class="clearfix"></div>
<style type="text/css">
  #content_category .content_inner{
    max-height: 165px;
    transition: ease-in-out 0.3s;
    overflow: hidden;
  }
  #content_category.open .content_inner{
    max-height: unset;
  }
  #content_category .content_inner h2,
  #content_category .content_inner h3,
  #content_category .content_inner h4{
	  margin:0 0 10px 0;
	  line-height: 17px!important;
  }
</style>
<div class="background_main archive tax-product_cat term-cho-be-an term-54 woocommerce woocommerce-page" role="main">
<div class="container">
      <div class="content-top row">
        <div class="col-xs-12 col-sm-3 col-md-3">
  <div class="sidebar-web">

<div id="yith_wc_category_accordion-2" class="lindo_wd widget widget_yith_wc_category_accordion">
	<h3 class="ywcca_widget_title"><?php echo $data['cat'][0]['title_vn']; ?></h3>
  <div class="categories">
    <ul class="lindo_mega_left menu_category">
      
     <?php foreach($menu as $item) { 
      $sub_menus = $this->catelog_model ->get_sub_menu($item['Id']);
      ?>
        <li data-category-hover="cat1">
          <a title="<?php echo $item['title_vn']?>" href="<?php echo base_url($item['alias']); ?>"><span class="fl-img">
          <img id="imgIcon" alt="" src="wp-content/uploads/2016/07/khuyen-mai-1.png" style="display: block;">
          </span><?php echo $item['title_vn']?><?php if(!empty($sub_menus)) echo '<span class="pull-right"><i class="fa fa-angle-right"></i></span>';?></a>
          <?php
          if(!empty($sub_menus)){
          ?>
          <ul>
            <?php foreach($sub_menus as $sub) { 
			$sub1_menus = $this->catelog_model->get_list(array('parentid'=>$sub['Id']),0,0);
			?>
              <li><a href="<?=site_url($sub['alias'])?>"><?=$sub['title_vn']?>
			  <?php if(!empty($sub1_menus)) echo '<span class="pull-right"><i class="fa fa-angle-right"></i></span>';?></a>
			  <?php
			  if(!empty($sub1_menus)){
			  ?>
			  <ul>
				<?php foreach($sub1_menus as $sub1) { 
				?>
				  <li><a href="<?=site_url($sub1['alias'])?>"><?=$sub1['title_vn']?></a></li>
				<?php } ?>
			  </ul>
			<?php } ?>
			  </li>
            <?php } ?>
          </ul>
        <?php } ?>
        </li>

      <?php }?>
  </div>
</div>

<div id="woocommerce_price_filter-2" class="lindo_wd widget woocommerce widget_price_filter"><div class="title-section"><span>Lọc theo giá</span></div>
<form method="get" action="<?php echo $linked; ?>">
  <div class="price_slider_wrapper">

      <div class="price_slider_wrapper">
        <div class="price_slider_amount">
          <input type="text" id="" name="min_price" value="" onkeyup="this.value = GetNumber(this.value);" placeholder="Giá thấp nhất" style="float: left;margin: 4px"/><span> VND</span>
          <br>
          <input type="text" id="" name="max_price" value="" onkeyup="this.value = GetNumber(this.value);" data-max="" placeholder="Giá cao nhất" style="float: left;;margin: 4px"/><span> VND</span>
          <div class="clear"></div>
          
          <button type="submit" class="button">Lọc</button>
        </div>
      </div>
    </div>
</form>

</div>
</div>                 
</div><!--end .sidebar-home-->

        <div class="cate-all-child col-xs-12  col-sm-9 col-md-9">
          <div class="cont-cate-all">
 <div id="container">
 	<div id="content" role="main">
 	<?php if (($data['namepage']=='getproduct')) { ?>
    <nav class="woocommerce-breadcrumb"><a href="<?php echo base_url() ?>">Trang chủ</a>
      <?php foreach($breadcrumbs as $b) : ?>
         / <a href="<?=$b['href']?>"><?=$b['title']?></a>
      <?php endforeach ?>
    </nav>
    <h1 class="page-title" style="font-size: 20px;font-weight: bold;margin: 10px 0;padding: 5px 0;"><?php echo $data['cat'][0]['meta_title']; ?></h1>
  <?php }elseif(($data['namepage']=='search')){ ?>
  	<nav class="woocommerce-breadcrumb"><a href="<?php echo base_url() ?>">Trang chủ</a>&nbsp;/&nbsp;Tìm kiếm</nav>
  	<h1 class="page-title" style="font-size: 20px;font-weight: bold;margin: 10px 0;padding: 5px 0;">Tìm kiếm</h1>
  <?php }elseif(($data['namepage']=='getsales')){ ?>
    <nav class="woocommerce-breadcrumb"><a href="<?php echo base_url() ?>">Trang chủ</a>&nbsp;/&nbsp;Sản phẩm đang khuyến mãi</nav>
    <h1 class="page-title" style="font-size: 20px;font-weight: bold;margin: 10px 0;padding: 5px 0;">Sản phẩm đang khuyến mãi</h1>
  <?php } ?>

    <?php if ($this->session->flashdata('message_addcart_fromcat_success')) { ?>
        <?php $message = $this->session->flashdata('message_addcart_fromcat_success');
           echo '<div class="woocommerce-message"><a href="gio-hang/" class="button wc-forward">Xem giỏ hàng</a><i class="fa fa-cart-plus" aria-hidden="true"></i> '.$message.'</div>'; 
        ?>
    <?php } ?>
<?php if($cat[0]['content']) : ?>
  <div class="woocommerce_archive_description" id="content_category">
	   <div class="content_inner">
      <?php if($cat[0]['content']) : ?><div style="background:#fff;padding:10px;margin-top:15px;clear:both"><?=$cat[0]['content']?></div><?php endif; ?>
      </div>
      <div style="text-align: center;"><a href="javascript:;" id="button_expand">Xem thêm</a></div>
    </div><?php endif; ?>
    
       <p class="woocommerce-result-count">
        <?php if(!empty($info)){ ?>
          Có <?php echo $data['totalItem']; ?> sản phẩm trong danh mục.
        <?php
          }else{
        ?>
        Không có sản phẩm nào được hiển thị.
        <?php } ?>
        </p>

  <div class="woocommerce-ordering">
	
    <ul class="fillter-sort">
		<li style="display:inline-block"><a href="<?php echo $linked."&sort=Id DESC" ?>" class="btn btn-default btn-sm js-sort-btn <?php if($sort =="Id DESC") echo "active btn-primary"; ?>">Sản phẩm mới nhất</a></li>
		<li style="display:inline-block"><a href="<?php echo $linked."&sort=oder DESC" ?>" class="btn btn-default btn-sm js-sort-btn <?php if($sort =="oder DESC") echo "active btn-primary"; ?>" >Sản phẩm bán chạy</a></li>
		<li style="display:inline-block"><a href="<?php echo $linked."&sort=sale_price DESC" ?>" class="btn btn-default btn-sm js-sort-btn <?php if($sort =="sale_price DESC") echo "active btn-primary"; ?>">Giá giảm dần</a></li>
		<li style="display:inline-block"><a href="<?php echo $linked."&sort=sale_price ASC" ?>" class="btn btn-default btn-sm js-sort-btn <?php if($sort =="sale_price ASC") echo "active btn-primary"; ?>" >Giá tăng dần</a></li>
	</ul>
  </div>
  
      <ul class="products">
        <div class="row">
        <?php if(!empty($info)){ foreach ($info as $item){ ?>
           <div class="col-xs-6 col-sm-3 col-md-3">
				<li class="lindo_produc_style" itemscope itemtype="http://schema.org/Product">
				<?php
            if ((int)$item['price'] != 0 && (int)$item['price'] != $item['sale_price']) {
                $pt = 100-floor(($item['sale_price']/ $item['price'])*100);
                ?>
                <div class="sale_off_lindo"><strong>
                <i><?php  echo $pt?>%</i></strong></div>
          <?php } ?>
          <a style="text-decoration: none;" title="<?php echo $item['title_vn'] ?>" href="<?php echo base_url($item['alias'].'.html'); ?>" class="woocommerce-LoopProduct-link">
				  <span class="onsale">Giảm giá!</span>
				<img width="300" height="300" src="<?php echo PATH_IMG_PRODUCT.$item['images']."?v=".time();?>" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="<?php echo $item['title_vn'] ?>" title="<?php echo $item['title_vn'] ?>" srcset="<?php echo PATH_IMG_PRODUCT.$item['images']."?v=".time();?>" sizes="(max-width: 300px) 100vw, 300px" />
				<p class="max-lines"><?php echo $item['title_vn'] ?></p>
				<p style="margin-bottom:5px;font-size: 16px;">Mã SP: <span style="font-size:16px;font-weight:bold;"><?=$item['codepro']?></span></p>
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
          <button rel="nofollow"  class="button product_type_simple add_to_cart_button ajax_add_to_cart">Mua ngay</button>
        </form>

      </li>        
        	</div>
        	<?php 
				}
			}else{
		?>
		<div class="alert alert-danger">Sản phẩm đang update.</div>
        <?php } ?>
        </div>
      </ul>
      
      <?php if(!empty($page)) echo '
        <nav class="woocommerce-pagination">
          <div class="pagination" style="">'.$page.' </div>
        </nav>
      '; ?>
	  <div style="clear:both"></div>
	  <?php echo $phantrang;?>
  </div>

  </div>
</div>
          </div><!--end .cont-cate-all-->
        </div><!--end .cate-all-child-->
      </div><!--end .content-top-->
    </div>
</div>
<div class="clearfix"></div>

<div id="yith-wacp-popup">
  <div class="yith-wacp-overlay"></div>
  <div class="yith-wacp-wrapper woocommerce">
    <div class="yith-wacp-main">
      <div class="yith-wacp-head">
        <a href="#" class="yith-wacp-close">X</a>
      </div>
      <div class="yith-wacp-content"></div>
    </div>
  </div>
</div>

<style>
  .pagination{
    margin: auto;
    box-sizing: border-box;
    height: 40px;
    padding: 8px 10px;
    display: block;
    padding-left: 0;
    margin: 20px 0;
    border-radius: 4px;
  }

  .pagination a{
    display: inline-block;
    padding: 6px 10px;
    background-color: #eee;
    text-align: center;
    box-sizing: border-box;
    font-size: 12px;
    color: #686868;
    margin: 0 2px;
    text-decoration: none!important;
  }
  .pagination a:hover{
    color: #fff;
    background-color: #e74847;
  }
  .pagination strong {
    display: inline-block;
    padding: 6px 10px;
    text-align: center;
    box-sizing: border-box;
    font-size: 12px;
    margin: 0 2px;
    text-decoration: none;
    color: #fff;
    background-color: #e74847;
}
  #lengthValue,
  #widthValue {
    color: blue
  }

  #areaValue {
    color: red
  }
</style>
<script>
  function updateAreaValue() {
    var max = document.getElementById('max_price').value;
    var min = document.getElementById('min_price').value;
  }
  function maxChange(val) {
     document.getElementById('maxValue').innerHTML = val;
     updateAreaValue();
  }
  function minChange(val) {
     document.getElementById('minValue').innerHTML = val;
     updateAreaValue();
  }
  function FormatNumber(str){
    var strTemp = GetNumber(str);
    if(strTemp.length <= 3)
        return strTemp;
    strResult = "";
    for(var i =0; i< strTemp.length; i++)
        strTemp = strTemp.replace(".", "");
        strTemp = strTemp.replace(",", "");

    for(var i = strTemp.length; i>=0; i--)
    {
        if(strResult.length >0 && (strTemp.length - i -1) % 3 == 0)
            strResult = "." + strResult;
        strResult = strTemp.substring(i, i + 1) + strResult;
    } 
    return strResult;
}
function GetNumber(str)
{
    for(var i = 0; i < str.length; i++)
    { 
        var temp = str.substring(i, i + 1);   
        if(!(temp == "," || temp == "." || (temp >= 0 && temp <=9)))
        {
            alert("Giá chỉ được nhập vào là số từ 0-9");
            return str.substring(0, i);
        }
        if(temp == " ")
            return str.substring(0, i);
    }
    return str;
}

</script>