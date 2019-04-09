<div class="clearfix"></div><div class="background_main" role="main">
<div class="container">
<div class="content-top row">
				
				<div class="news-page col-xs-12  col-sm-12 col-md-12">
                
  <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <!-- Breadcrumb NavXT 5.6.0 -->
<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to Baby Shop Đồ Chơi Trẻ Em." href="<?php echo base_url() ?>" class="home"><span property="name">Trang chủ</span></a><meta property="position" content="1"></span> <i class="fa fa-angle-double-right"></i> <span property="itemListElement" typeof="ListItem"><span property="name">Tin tức</span><meta property="position" content="2"></span></div>
<div class="title-cate-all">

<h1 class="pagetitle">Tin tức</h1>
</div><!--end .pos-link-->
					

<div class="cont-news-page">
	<?php foreach($info as $item) { ?>
	<div class="list-news-page">
		<div class="cat_img">
			<a href="<?php echo base_url('bai-viet/'.$item['alias']); ?>" title="<?php echo $item['title_vn'] ?>">
				<img width="150" height="150" src="<?php echo PATH_IMG_NEWS.$item['images']."?v=".time();?>" class="img-responsive wp-post-image" alt="" srcset="<?php echo PATH_IMG_NEWS.$item['images']."?v=".time();?>" sizes="(max-width: 150px) 100vw, 150px" />            
			</a>
		</div>
		<div class="cat_note">
			<h2>
				<a href="<?php echo base_url('bai-viet/'.$item['alias']); ?>" title="<?php echo $item['title_vn'] ?>"><?php echo $item['title_vn'] ?></a>
			</h2>
			<p><?php echo $item['description_vn']; ?></p>
		</div>
	</div><!--end .list-news-page-->
	<?php } ?>
	<div class="woocommerce-pagination" style="text-align:center">
	<div class="pagination">
		<?php 
	    	echo $this->pagination->create_links();
	    ?>
	</div><!--end .panigation-page-->
	</div>

</div><!--end .cont-news-page-->
				</div><!--end .news-page-->
</div><!--end .content-top-->
</div>
</div>
<div class="clearfix"></div>
