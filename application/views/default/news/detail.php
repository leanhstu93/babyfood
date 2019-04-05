<style>
.cont-news-detail-page{
	font-size:13px;
}
.cont-news-detail-page p{
	margin-bottom: 10px;
}
.cont-news-detail-page h1,
.cont-news-detail-page h2,
.cont-news-detail-page h3{
	font-size:18px;
	font-weight:bold;
	margin:0 0 10px 0;
}
.cont-news-detail-page h1{
	font-size:24px;
}
.cont-news-detail-page h2{
	font-size:20px;
}
.cont-news-detail-page h3{
	font-size:14px;
}

</style>
<div class="clearfix"></div><div class="background_main" role="main">
<div class="container">
<div class="content-top row">

	<div class="news-page col-xs-12  col-sm-12 col-md-12">
					
		 <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
			<!-- Breadcrumb NavXT 5.6.0 -->
			<span property="itemListElement" typeof="ListItem">
				<a property="item" typeof="WebPage" title="Go to Baby Shop Đồ Chơi Trẻ Em." href="<?php echo base_url() ?>" class="home"><span property="name">Trang chủ</span>
				</a>
				<meta property="position" content="1"></span> <i class="fa fa-angle-double-right"></i> <span property="itemListElement" typeof="ListItem">
					<a property="item" typeof="WebPage" title="Tin tức." href="<?php echo base_url('chu-de/bai-viet') ?>" class="taxonomy category"><span property="name">Tin tức</span>
					</a>
					<meta property="position" content="2"></span> <i class="fa fa-angle-double-right"></i> 
			<span property="itemListElement" typeof="ListItem"><span property="name">
				<?php echo  $info[0]['title_vn'] ?></h1></span><meta property="position" content="3"></span>
		</div>
		<div class="singpages_lindo">

		<div class="cont-news-detail-page">
			<h1 class="tib"><?php echo  $info[0]['title_vn'] ?></h1>
			<?php echo $info[0]['content_vn'];?>
		</div><!--end .cont-news-detail-page-->

		<?php if($info[0]['tag']) { 
		$tags = explode(",", $info[0]['tag']);
		foreach($tags as $k => $tag) {
			$tags[$k] = '<a href="/bai-viet/search?s='.$tag.'">'.$tag.'</a>';
		}
		?>
	    <div style="margin: 15px 0;"><strong>Tags:</strong> <?php echo implode(",", $tags)?></div>
	    <?php }?>
        <?php if(!empty($info[0]['link_extend'])){ ?>
            <div class="js-buy-now btn-buy-now">
                <a target="_blank" href="<?php echo $info[0]['link_extend'] ?>">
                    Mua ngay
                </a>
            </div>
        <?php } ?>

		<div class="share-post">
			<ul class="share_lindo">
			<li><span>Share ngay : </span> </li>
				<li>
				<a title="share Facebook" rel="nofollow" target="_blank" href="https://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $info[0]['title_vn'] ?>&amp;p[url]=<?php echo current_url() ?>/"><i class="fa fa-facebook-square" aria-hidden="true"></i>
				</a>
				</li>
				<li>
				<a title="share Google Plus" rel="nofollow" target="_blank" href="https://plus.google.com/share?url=<?php echo current_url() ?>/&amp;title=<?php echo $info[0]['title_vn'] ?>"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
				</li>

				<li>
				<a title="share pinterest" rel="nofollow" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo current_url() ?>/&amp;description=&amp;media="><i class="fa fa-pinterest-square" aria-hidden="true"></i></a>
				</li>
				<li>
				<a title="share twitter" rel="nofollow" target="_blank" href="https://twitter.com/share?url=<?php echo current_url() ?>/&amp;text="><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
				</li>
			</ul>
		</div>
		<div class="tab-pane" id="2">
				<div class="fb-comments" data-href="<?=current_url()?>" data-numposts="5" data-width="100%"></div>
		</div>

		</div>                
	</div><!--end .news-page-->
			<!--<div class="sidebar-single-page col-xs-12  col-sm-3 col-md-3 ">
			<div class="sidebar-web">
					<div id="recent-posts-2" class="lindo_wd widget_recent_entries">		
						<div class="title-section"><span>Bài viết mới</span></div>		
						<ul>
							<?php foreach($baiviet as $item) { ?>
								<li>
								<a href="<?php echo base_url('bai-viet/'.$item['alias']); ?>"><?php echo $item['title_vn']; ?></a></br>
									<span style="float: right;font-size: 10px;color: #666">- <?php echo date("d-m-Y",$item['date']) ?> -</span>
								</li>
							<?php } ?>
						</ul>
					</div>		

				<div id="tag_cloud-2" class="lindo_wd widget_tag_cloud">
					<div class="title-section"><span>Bài viết được xem nhiều</span></div>		
						<ul>
							<?php foreach($mostviews as $item) { ?>
								<li>
								<a href="<?php echo base_url('bai-viet/'.$item['alias']); ?>"><?php echo $item['title_vn']; ?></a></br>
									<span style="float: right;font-size: 10px;color: #666">- <?php echo date("d-m-Y",$item['date']) ?> -</span>
								</li>
							<?php } ?>
						</ul>
				</div>					
			</div>
		</div>-->

</div><!--end .content-top-->
</div>
</div>
<div class="clearfix"></div>
