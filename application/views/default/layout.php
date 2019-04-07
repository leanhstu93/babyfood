<?php
$data['web'] = $web  =$this->pagehtml_model->get_website(1);
$data['menu_bottom']  = $this->catelog_model->list_data(null,null);
//data['catelog'] = $this->pagehtml_model->get_catelog(0);
$data['logo'] = $logo = $this->flash_model->list_data(null,null);
$data['hotro'] = $this->pagehtml_model->get_newsidcat(8,10,0);
$data['thongtin'] = $this->pagehtml_model->get_newsidcat(5,10,0);
$data['quydinh'] = $this->pagehtml_model->get_newsidcat(11,10,0);
$data['baiviet'] = $this->pagehtml_model->get_newsidcat(10,10,0);
$data['banner_bottom'] = $this->pagehtml_model->get_on_list_weblink(array('style'=>4, 'layout'=>'', 'ticlock'=>'0'),1);
$data['banner_top'] = $this->pagehtml_model->get_on_list_weblink(array('style'=>2, 'layout'=>'', 'ticlock'=>'0'),1);
$data['info_footer'] = $info_footer  =$this->pagehtml_model->list_data(1,null);
$tag = $this->tags_model->list_data(10,0);
$cart = $this->session->userdata('cart');
?>

<?php if ($this->session->flashdata('message_success')) { ?>
    <?php $message = $this->session->flashdata('message_success');
       echo "<script type='text/javascript'>alert('$message');</script>"; ?>
<?php } ?>

<!DOCTYPE html>
<html lang="vi" class="no-js"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title><?php if(isset($meta['title'])) echo $meta['title']; else echo $web['meta_title']; ?></title>
    <base href="<?php echo BASE_URL ?>" />
    <link rel="stylesheet" href="public/template/css/reset.css" />
    <link rel="stylesheet" href="nextweb/themes/babyshop/css/bootstrap.min.css" />
    <link rel="stylesheet" href="nextweb/themes/babyshop/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="nextweb/themes/babyshop/owl-carousel/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="nextweb/themes/babyshop/css/style.css" />
    <link rel="stylesheet" href="nextweb/themes/babyshop/css/product.css" />
    <link rel="stylesheet" href="nextweb/themes/babyshop/css/lindo_menu_cat.css?v=1" /> 
    <link rel="stylesheet" href="nextweb/themes/babyshop/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="nextweb/themes/babyshop/css/responsive.css" />
	<link rel="canonical" href="<?=current_url()?>" >
                <script type="text/javascript">document.documentElement.className = document.documentElement.className + ' yes-js js_active js'</script>
                        <style>
                .wishlist_table .add_to_cart, a.add_to_wishlist.button.alt { border-radius: 16px; -moz-border-radius: 16px; -webkit-border-radius: 16px; }          </style>
    <meta name="robots" content="index,follow,noydir,noodp"/>
	<meta name="description" content="<?php echo $meta['description'] ? $meta['description'] : $web['description_vn'] ?>"/>
	<meta name="keywords" content="<?php echo $meta['keywork'] ? $meta['keywork'] : $web['keyword_vn'] ?>"/>
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $meta['title'] ? $meta['title'] : $web['title_vn'] ?>" />
    <meta property="og:description" content="<?php echo $meta['description'] ? $meta['description'] : $web['description_vn'] ?>" />
    <meta property="og:url" content="<?=current_url()?>" />
    <meta property="og:site_name" content="<?php echo$web['title_vn'] ?>" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="<?php echo $meta['description'] ? $meta['description'] : $web['title_vn'] ?>" />
    <meta name="twitter:title" content="B<?php echo $meta['title'] ? $meta['title'] : $web['title_vn'] ?>" />
    <meta name="google-site-verification" content="ChU3fJ2FxqXV_iTjNcZBTlHzcQJJRXmV37o_SfXAPcw" />

	<?php if($this->uri->segment(1) == 'thanh-toan') : ?>
	<script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit' async defer></script>
	<?php endif; ?>
    <!--<script type="text/javascript">
        window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.2.1\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.2.1\/svg\/","svgExt":".svg","source":{"concatemoji":"https:\/\/babyfood.com.vn\/nextweb\/theme\babyshop\/js\/wp-emoji-release.min.js?ver=4.7.11"}};
        !function(a,b,c){function d(a){var b,c,d,e,f=String.fromCharCode;if(!k||!k.fillText)return!1;switch(k.clearRect(0,0,j.width,j.height),k.textBaseline="top",k.font="600 32px Arial",a){case"flag":return k.fillText(f(55356,56826,55356,56819),0,0),!(j.toDataURL().length<3e3)&&(k.clearRect(0,0,j.width,j.height),k.fillText(f(55356,57331,65039,8205,55356,57096),0,0),b=j.toDataURL(),k.clearRect(0,0,j.width,j.height),k.fillText(f(55356,57331,55356,57096),0,0),c=j.toDataURL(),b!==c);case"emoji4":return k.fillText(f(55357,56425,55356,57341,8205,55357,56507),0,0),d=j.toDataURL(),k.clearRect(0,0,j.width,j.height),k.fillText(f(55357,56425,55356,57341,55357,56507),0,0),e=j.toDataURL(),d!==e}return!1}function e(a){var c=b.createElement("script");c.src=a,c.defer=c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var f,g,h,i,j=b.createElement("canvas"),k=j.getContext&&j.getContext("2d");for(i=Array("flag","emoji4"),c.supports={everything:!0,everythingExceptFlag:!0},h=0;h<i.length;h++)c.supports[i[h]]=d(i[h]),c.supports.everything=c.supports.everything&&c.supports[i[h]],"flag"!==i[h]&&(c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&c.supports[i[h]]);c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&!c.supports.flag,c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.everything||(g=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",g,!1),a.addEventListener("load",g,!1)):(a.attachEvent("onload",g),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),f=c.source||{},f.concatemoji?e(f.concatemoji):f.wpemoji&&f.twemoji&&(e(f.twemoji),e(f.wpemoji)))}(window,document,window._wpemojiSettings);
    </script>-->
    <style type="text/css">
/*Bootstrap 5 item*/
.col-xs-5th-1,.col-xs-5th-2,.col-xs-5th-3,.col-xs-5th-4{float:left}.col-xs-5th-5{float:left;width:100%}.col-xs-5th-4{width:80%}.col-xs-5th-3{width:60%}.col-xs-5th-2{width:40%}.col-xs-5th-1{width:20%}.col-xs-5th-pull-5{right:100%}.col-xs-5th-pull-4{right:80%}.col-xs-5th-pull-3{right:60%}.col-xs-5th-pull-2{right:40%}.col-xs-5th-pull-1{right:20%}.col-xs-5th-pull-0{right:auto}.col-xs-5th-push-5{left:100%}.col-xs-5th-push-4{left:80%}.col-xs-5th-push-3{left:60%}.col-xs-5th-push-2{left:40%}.col-xs-5th-push-1{left:20%}.col-xs-5th-push-0{left:auto}.col-xs-5th-offset-5{margin-left:100%}.col-xs-5th-offset-4{margin-left:80%}.col-xs-5th-offset-3{margin-left:60%}.col-xs-5th-offset-2{margin-left:40%}.col-xs-5th-offset-1{margin-left:20%}.col-xs-5th-offset-0{margin-left:0}@media (min-width: 768px){.col-sm-5th-1,.col-sm-5th-2,.col-sm-5th-3,.col-sm-5th-4{float:left}.col-sm-5th-5{float:left;width:100%}.col-sm-5th-4{width:80%}.col-sm-5th-3{width:60%}.col-sm-5th-2{width:40%}.col-sm-5th-1{width:20%}.col-sm-5th-pull-5{right:100%}.col-sm-5th-pull-4{right:80%}.col-sm-5th-pull-3{right:60%}.col-sm-5th-pull-2{right:40%}.col-sm-5th-pull-1{right:20%}.col-sm-5th-pull-0{right:auto}.col-sm-5th-push-5{left:100%}.col-sm-5th-push-4{left:80%}.col-sm-5th-push-3{left:60%}.col-sm-5th-push-2{left:40%}.col-sm-5th-push-1{left:20%}.col-sm-5th-push-0{left:auto}.col-sm-5th-offset-5{margin-left:100%}.col-sm-5th-offset-4{margin-left:80%}.col-sm-5th-offset-3{margin-left:60%}.col-sm-5th-offset-2{margin-left:40%}.col-sm-5th-offset-1{margin-left:20%}.col-sm-5th-offset-0{margin-left:0}}@media (min-width: 992px){.col-md-5th-1,.col-md-5th-2,.col-md-5th-3,.col-md-5th-4{float:left}.col-md-5th-5{float:left;width:100%}.col-md-5th-4{width:80%}.col-md-5th-3{width:60%}.col-md-5th-2{width:40%}.col-md-5th-1{width:20%}.col-md-5th-pull-5{right:100%}.col-md-5th-pull-4{right:80%}.col-md-5th-pull-3{right:60%}.col-md-5th-pull-2{right:40%}.col-md-5th-pull-1{right:20%}.col-md-5th-pull-0{right:auto}.col-md-5th-push-5{left:100%}.col-md-5th-push-4{left:80%}.col-md-5th-push-3{left:60%}.col-md-5th-push-2{left:40%}.col-md-5th-push-1{left:20%}.col-md-5th-push-0{left:auto}.col-md-5th-offset-5{margin-left:100%}.col-md-5th-offset-4{margin-left:80%}.col-md-5th-offset-3{margin-left:60%}.col-md-5th-offset-2{margin-left:40%}.col-md-5th-offset-1{margin-left:20%}.col-md-5th-offset-0{margin-left:0}}@media (min-width: 1200px){.col-lg-5th-1,.col-lg-5th-2,.col-lg-5th-3,.col-lg-5th-4{float:left}.col-lg-5th-5{float:left;width:100%}.col-lg-5th-4{width:80%}.col-lg-5th-3{width:60%}.col-lg-5th-2{width:40%}.col-lg-5th-1{width:20%}.col-lg-5th-pull-5{right:100%}.col-lg-5th-pull-4{right:80%}.col-lg-5th-pull-3{right:60%}.col-lg-5th-pull-2{right:40%}.col-lg-5th-pull-1{right:20%}.col-lg-5th-pull-0{right:auto}.col-lg-5th-push-5{left:100%}.col-lg-5th-push-4{left:80%}.col-lg-5th-push-3{left:60%}.col-lg-5th-push-2{left:40%}.col-lg-5th-push-1{left:20%}.col-lg-5th-push-0{left:auto}.col-lg-5th-offset-5{margin-left:100%}.col-lg-5th-offset-4{margin-left:80%}.col-lg-5th-offset-3{margin-left:60%}.col-lg-5th-offset-2{margin-left:40%}.col-lg-5th-offset-1{margin-left:20%}.col-lg-5th-offset-0{margin-left:0}}
.header_maincontent .search-box-fixed{display: none;}
@media screen and (min-width: 1200px){
header .header_maincontent.fixed-top{padding: 3px 0}
.header_maincontent .title_cat{display: none;
    top: 0;
    position: relative;
    padding: 22px 0;
    line-height: 0px;
    width:190px;
    height:36px;
    font-size: 17px;
    text-transform: uppercase;
    font-weight: bold;
    color:#fff;
    cursor: pointer;
}
.header_maincontent .search-box-fixed .search_box,
.header_maincontent.fixed-top .group_like_cart{margin-top: 0}
.header_maincontent .search-box-fixed .search_box input[type="submit"]{
    background: #f6b900;
}
.fixed-top{
    position: fixed;
    top:0;
    left:0;
    width:100%;
    z-index: 10;
    background: red;
}
.fixed-top .logo-header{
    display: none;
}
.header_maincontent.fixed-top .title_cat{display: block;}
.header_maincontent.fixed-top .search-box-fixed{display: block;}
.header_maincontent.fixed-top .search-box-header{display: none;}
#banner_top{position: absolute;width:100%;background: #fff;top:47px;left:0;z-index: 1000}
#banner_top .menu_root li:hover {background: #ff0000;}
#backdrop{position: fixed;
    display: none;
    z-index: 999;
    top: 0px;
    left: 0px;
    width: 110%;
    height: 100%;
    margin: 0px;
    padding: 0px;
    overflow-x: auto;
    overflow-y: scroll;
    background-color: #000;
    opacity: 0.5;}
}
.home-top3-news{background: #fff;padding: 5px;margin-top:-15px;}
.top3-news{margin-bottom: 5px;padding:5px;}
.home-top3-news .top3-news:last-child{margin-bottom: 0}
.top3-news:after{content:'';display: block;clear: both;}
.top3-news .thumb{width:90px;float:left;height: 60px;overflow: hidden;}
.top3-news h4{float:left;width:230px;font-size: 14px;margin: 0 0 5px 5px;}
.home-top3-news .header-news{background: red;
    padding: 5px 10px;
    font-size: 15px;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;}
@media screen and (max-width: 768px){
    .header_maincontent.fixed-top{
        position: fixed;
        top:0;
        left:0;
        width:100%;
        background:#db2827;
        color:#fff;
        padding-top: 5px;
        padding-bottom: 5px;
        z-index: 1000;
    }
    .header_maincontent.fixed-top .mlindo_mobile{
        color:#fff;
        display: block;
        margin-top: 5px;
    }
    .header_maincontent.fixed-top .header_cart{
        margin-top: 5px;
    }
    .header_maincontent.fixed-top .search_box .button{
        background: #f6b900
    }
    .group_like_cart{margin:0;}
}
</style>
<link rel='stylesheet' id='validate-engine-css-css'  href='nextweb/plugins/wysija-newsletters/css/validationEngine.jquery.css' type='text/css' media='all' />
<link rel='stylesheet' id='woocommerce-layout-css'  href='nextweb/plugins/woocommerce/assets/css/woocommerce-layout.css' type='text/css' media='all' />
<link rel='stylesheet' id='woocommerce-smallscreen-css'  href='nextweb/plugins/woocommerce/assets/css/woocommerce-smallscreen.css' type='text/css' media='only screen and (max-width: 768px)' />
<link rel='stylesheet' id='woocommerce-general-css'  href='nextweb/plugins/woocommerce/assets/css/woocommerce.css' type='text/css' media='all' />
<link rel='stylesheet' id='wp-pagenavi-css'  href='nextweb/plugins/wp-pagenavi/pagenavi-css.css' type='text/css' media='all' />
<link rel='stylesheet' id='yith-wacp-frontend-css'  href='nextweb/plugins/yith-woocommerce-added-to-cart-popup/assets/css/wacp-frontend.css' type='text/css' media='all' />
<style id='yith-wacp-frontend-inline-css' type='text/css'>
                #yith-wacp-popup .yith-wacp-content a.button {
                        background: #ebe9eb;
                        color: #515151;
                }
                #yith-wacp-popup .yith-wacp-content a.button:hover {
                        background: #dad8da;
                        color: #515151;
                }
</style>
<link rel='stylesheet' id='ywcca_accordion_style-css'  href='nextweb/plugins/yith-woocommerce-category-accordion/assets/css/ywcca_style.css?ver=1.0.11' type='text/css' media='all' />
<link rel='stylesheet' id='jquery-colorbox-css'  href='nextweb/plugins/yith-woocommerce-compare/assets/css/colorbox.css?ver=4.7.11' type='text/css' media='all' />
<link rel='stylesheet' id='woocommerce_prettyPhoto_css-css'  href='nextweb/plugins/woocommerce/assets/css/prettyPhoto.css?ver=3.1.6' type='text/css' media='all' />
<link rel='stylesheet' id='jquery-selectBox-css'  href='nextweb/plugins/yith-woocommerce-wishlist/assets/css/jquery.selectBox.css?ver=1.2.0' type='text/css' media='all' />
<link rel='stylesheet' id='yith-wcwl-main-css'  href='nextweb/plugins/yith-woocommerce-wishlist/assets/css/style.css?ver=2.0.16' type='text/css' media='all' />
<link rel='stylesheet' id='yith-wcwl-font-awesome-css'  href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='decent-comments-widget-css'  href='nextweb/plugins/decent-comments/css/decent-comments-widget.css' type='text/css' media='all' />

<script type='text/javascript' src='nextweb/js/jquery/jquery.js?ver=1.12.4'></script>
<script type='text/javascript' src='nextweb/js/jquery/jquery-migrate.min.js?ver=1.4.1'></script>
<meta name="generator" content="Nextweb 5.0" />
<meta name="generator" content="Nextweb 5.0" />
  
<link rel="shortcut icon" type="image/x-icon" href="/public/template/images/favicon1.png"/>
</head>
<body data-rsssl=1 class="home blog">
<?php $this->load->view('messenger-fb'); ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php if (!empty($data['banner_top'])) { ?>
    <div class="adv-header" style="background-color: #f26e21">
        <div class="container">
            <a href="<?php echo base_url($data['banner_top'][0]['link']); ?>">
                <img class="img-responsive" alt="banner ads" src="<?php echo PATH_IMG_BANNER.$data['banner_top'][0]['images']."?v=".time();?>">
            </a>
        </div>
    </div>
<?php } ?>


<div id="page">
 <header>
    <nav class="navbar_lindo">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <div class="header_info">
                        <h1 class="site-title"><a title="<?php echo $web['title_vn'] ?>" href="" rel="home"><?php echo $web['title_vn'] ?></a></h1>
                         <p class="hotline_header"><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Tổng đài: <strong><a href="tel:<?php echo $web['hotline'] ?>" title="Call"><?php echo $web['hotline'] ?></a></strong></p>
                    </div>
                 <div class="lindo-header_top_menu">

                <div class="menu-menu-top-container">
                    <ul id="menu-menu-top" class="nav navbar-nav navbar-right">
                    <?php foreach($data['thongtin'] as $item) { ?>
                        <?php if ($item['alias'] == "gioi-thieu" || $item['alias'] == "lien-he" ) { ?>
                        <li id="" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-216">
                            <a href="<?php echo base_url('page/'.$item['alias']); ?>"><?php echo $item['title_vn']; ?></a>
                        </li>
                        <?php } ?>
                    <?php } ?>
                    <!-- <li id="menu-item-216" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-216"><a href="lien-he/">Liên Hệ</a></li>
                    <li id="menu-item-217" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-217"><a href="cau-hoi-thuong-gap/">Câu hỏi</a></li> -->
                    <!-- <li id="menu-item-218" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-218"><a href="chinh-sach-doi-tra-hang/">Chính sách</a></li> -->
                    </ul>
                </div>                
            </div>
                </div><!-- /.navbar-collapse -->
        </div>
    </div>
</nav>
<div class="clearfix"></div>
    <div class="header_maincontent">
        <div class="container" style="position: relative;">
            <div class="row">
              <div class="title_cat col-md-4 col-sm-24 col-xs-24">
                <img src="<?php echo base_url("") ?>/public/template/images/cat.png" style="margin: -9px 20px 0 16px; float: left;">
                Danh mục
                </div>
              <div class="col-sm-3 col-md-3 logo-header">
                  <div class="row">
                   <div class="col-xs-4 visible-xs">
                    <a class="mlindo_mobile" href="#mlindo_mobile"><i class="fa fa-bars" aria-hidden="true"></i> Menu</a>
                  </div>
                   <div class="col-xs-4 col-md-12">
                            <a class="a_pading"  title="<?php echo $web['title_vn'] ?>" href="">

                    <img src="<?php echo PATH_IMG_FLASH.$data['logo'][0]->file_vn."?v=".time();?>" alt="<?php echo $web['title_vn'] ?>" class="img-responsive" />
                    </a>
                                  </div>
                       <div class="col-xs-4 col-md-12">
                       <div class="fr header_cart visible-xs" style="text-align:center;">
                     <a rel="nofollow" target="_blank" title="Giỏ hàng" href="<?php echo base_url("thanh-toan") ?>" class="cart">
                    <i class="icon_vg40 icon_vg40_cart"></i>
                    <span class="notify"><?php echo count($cart); ?></span>
                    </a>
                    </div>
                       </div>
                
                  </div>
              </div>
              <div class="search-box-fixed col-sm-7 col-md-7">
              <div class="search_box">
                <form role="search" method="get" class="woocommerce-product-search" id="search-form" action="<?php echo base_url().'tim-kiem' ?>">
                    <div class="form-group search_input">
                    <input type="search" id="input_searchword" class="form-control" placeholder="Tìm sản phẩm&hellip;" value="" name="s" title="Tìm kiếm:" />
                    </div>
                    <input type="submit" class="btn btn-default pull-right button" value="Tìm kiếm" />
                    <input type="hidden" name="post_type" value="product" />
                </form>
                </div>
              </div>
              <div class="search-box-header col-sm-7 col-md-7">
              <div class="search_box">
                <form role="search" method="get" class="woocommerce-product-search" id="search-form" action="<?php echo base_url().'tim-kiem' ?>">
                    <div class="form-group search_input">
                    <input type="search" id="input_searchword" class="form-control" placeholder="Tìm sản phẩm&hellip;" value="" name="s" title="Tìm kiếm:" />
                    </div>
                    <input type="submit" class="btn btn-default pull-right button" value="Tìm kiếm" />
                    <input type="hidden" name="post_type" value="product" />
                </form>
                </div>
              </div>
               <div class="col-sm-2 col-md-2">
             
                    <div class="group_like_cart">
                    <div class="row">
                    <!-- <div class=" col-xs-6 col-sm-6 col-md-6">
                    <div class="fl header_like">
                    <a rel="nofollow" target="_blank" title="Yêu thích" href="wishlist/" class="follow">
                    <i class="icon_vg40 icon_vg40_like"></i>
                    <span>Yêu thích</span>
                    <div class="notify">0</div>
                    </a>
                    </div>
                    </div> -->
                    <div class=" col-xs-5 col-sm-10 col-md-10">
                    <div class="fr header_cart hidden-xs">
                     <a rel="nofollow" target="_blank" title="Giỏ hàng" href="<?php echo base_url("thanh-toan") ?>" class="cart">
                    <i class="icon_vg40 icon_vg40_cart"></i>
                    <span>Giỏ hàng</span>
                    <div class="notify"><?php echo count($cart); ?></div>
                    </a>
                    </div>
                    </div>
                    </div>
                    <div class="clear"></div>
                    </div>
              </div>
            </div>
            <?php $this->load->view('default/dropdown_menu'); ?>
            <div id="backdrop"></div>
        </div>

    </div>
</header>

  <?php  $this->load->view($template,$data); ?>

<div class="clearfix"></div>
<!-- <div class="footer_top_logo">
    <div class="container">
        <div class="lindo_logo">
            <div class="owl-carousel owl-theme" id="lindo_logo">
                <div class="item">
                    <a href="" title="Logo">
                    <img class="img-responsive" data-src="nextweb/uploads/2016/07/unimom.png" src="nextweb/uploads/2016/07/unimom.png" alt="Logo">
                </a>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="clearfix"></div>

<div class="footer_bottom_end">
<footer>
<div class="container info" style="position: relative;">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
            
             <div id="wysija-2" class="border-dash widget_wysija"><h4 class="box_title">Đăng ký để nhận bản tin của chúng tôi.</h4><div class="widget_wysija_cont"><div id="msg-form-wysija-2" class="wysija-msg ajax"></div>

            <form id="form-wysija-2" method="post" action="#wysija" class="widget_wysija">
                <div>Nhập Email để có thể nhận được thông tin đầy đủ và mới nhất mỗi khi có khuyến mãi</div><div class="clearfix"></div>
                <p class="wysija-paragraph">
                <input type="email" name="femail" class="wysija-input validate[required,custom[email]]" title="Email của bạn" placeholder="Email của bạn" value="" />
                </p>
                <input class="wysija-submit wysija-submit-field" type="submit" value="Đăng ký email" />
            </form>
            </div>

            </div>
                
                <div id="Subscribe">
                    <a rel="nofollow" title="facebook" href="#">
                    <div class="social-background social-fb"></div>
                    </a>

                    <a rel="nofollow" title="google plus" href="#">
                    <div class="social-background social-google"></div>
                    </a>

                    <a rel="nofollow" title="twitter" href="#">
                    <div class="social-background social-tw"></div>
                    </a>

                    <a rel="nofollow" title="linkedin" href="#">
                    <div class="social-background social-pint"></div>
                    </a>
                </div>
                
            </div>

            <div class="col-md-8 col-sm-8 col-xs-12 info_footer_mn">
            <div class="row">

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div id="nav_menu-3" class="padding-foot widget_nav_menu">
                    <h4 class="box_title">Giới thiệu</h4>
                    <div class="menu-footer-ve-chung-toi-container">
                        <ul id="menu-footer-ve-chung-toi" class="menu">
                            <?php foreach($data['thongtin'] as $item) { ?>
                                <li id="" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-320">
                                    <a href="<?php echo base_url('page/'.$item['alias']); ?>"><?php echo $item['title_vn']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                       
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div id="nav_menu-4" class="padding-foot widget_nav_menu"><h5 class="box_title">Hướng dẫn, hỗ trợ</h5>
                    <div class="menu-footer-huong-dan-ho-tro-container">
                        <ul id="menu-footer-huong-dan-ho-tro" class="menu">
                            <?php foreach($data['hotro'] as $item) { ?>
                                <li id="" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-320">
                                    <a href="<?php echo base_url('page/'.$item['alias']); ?>"><?php echo $item['title_vn']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>     
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div id="nav_menu-4" class="padding-foot widget_nav_menu"><h5 class="box_title">Quy định chính sách</h5>
                    <div class="menu-footer-huong-dan-ho-tro-container">
                        <ul id="menu-footer-huong-dan-ho-tro" class="menu">
                            <?php foreach($data['quydinh'] as $item) { ?>
                                <li id="" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-320">
                                    <a href="<?php echo base_url('page/'.$item['alias']); ?>"><?php echo $item['title_vn']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>


            </div>
            </div>
        </div>
    </div>

</footer>
</div>
<div class="clearfix"></div>
<div class="footer_info_lindo">
   <div class="copyright">
        <div class="container">
            <div class="row copyright-content">
                <div class="col-md-3 col-sm-3 col-xs-12 text-center">
                    <a href="<?php echo base_url(); ?>">
                        <img src="<?php echo PATH_IMG_FLASH.$data['logo'][0]->file_vn."?v=".time();?>" alt="Baby Shop Đồ Chơi Trẻ Em" title="<?php echo $web['title_vn'] ?>" class="img-responsive" />
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <div id="text-2" class="linfooter widget_text">
                    <?php foreach($info_footer as $item) { ?>
                        <?php if ($item->title_vn == "Thông tin footer" ) { ?>
                             <?php echo $item->content_vn ?>
                        <?php } ?>
                    <?php } ?>
                    </div>  
</div>
<div class="col-md-3 col-sm-3 col-xs-12">
<div id="text-3" class="linfooter-img widget_text">         
    <div class="textwidget"><!-- <img alt="lindo" src="nextweb/uploads/2016/07/code-lindo.png"> -->

<img src="nextweb/uploads/2016/07/dk_bo_cong_thuong.png" alt="bo cong thuong">

</div>
        </div>  
                </div>
            </div>
            
        </div>
    </div>
    
   
</div>

<div class="clearfix"></div>

<div class="footer_bottom_end" style="padding:15px 0">
<div class="container">
<div class="row">
<div  class="col-md-9 col-sm-6 col-xs-12">
Copyright © <?php echo $web['title_vn'] ?>. All right Reserved
</div>
</div>
</div>
</div>
                    
<script src="nextweb/themes/babyshop/js/jquery-2.1.3.min.js" type="text/javascript"></script>
<script src="nextweb/themes/babyshop/js/jquery-ui.min.js" type="text/javascript"></script>
    <script type='text/javascript' src='nextweb/js/product.js?ver=1.12.4'></script>
<script src="nextweb/themes/babyshop/js/bootstrap.min.js" type="text/javascript"></script>
<script src="nextweb/themes/babyshop/owl-carousel/js/owl.carousel.min.js" type="text/javascript"></script>
<script src="nextweb/themes/babyshop/js/functions_main.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>
<script src="nextweb/themes/babyshop/js/lindo_menu_cat.js" type="text/javascript"></script>

<link type="text/css" rel="stylesheet" href="nextweb/themes/babyshop/mmenu/css/jquery.mmenu.all.css" />
<script type="text/javascript" src="nextweb/themes/babyshop/mmenu/js/jquery.mmenu.all.min.js"></script>
<script type="text/javascript">
$(function() {
    $('nav#mlindo_mobile').mmenu();
    
    $(window).scroll(function () {
        //Mobile fixed top
        if($(window).width() < 768) {
            if ($(window).scrollTop() >= 50) {
                $('.header_maincontent').addClass('fixed-top');
            } else {
                $('.header_maincontent').removeClass('fixed-top');
            }
        }
        //Desktop fixed
        if ($(window).scrollTop() >= 500) {
            $('.header_maincontent').addClass('fixed-top');
        } else {
            $('.header_maincontent').removeClass('fixed-top');
        }
    });
    
    $('.title_cat').on('mouseover', function() {
        $('#banner_top').show();
        $('#backdrop').show();
    }).on('mouseleave', function(){
        if($('#banner_top').is(':visible')) {
            $('#banner_top').on('mouseleave', function(){
                $(this).hide();
                $('#backdrop').hide();
            })
        }
    });
    $('.menu_root > li').on('mouseover', function(){
       var target = $(this).attr('data-child');
       console.log(target)
       $('.menu_root').find('.background_menu').hide();
       $(target).show();
    });
    $('.lindo_produc_style').matchHeight();

    $('#form-wysija-2').on('submit', function() {
        var btn = $(this).find('input[type="submit"]');
        var femail = $(this).find('input[type="email"]');
        if(femail.val() != '') {
            $.ajax({
                url: '/ajax/addEmail',
                type: 'post',
                data: {femail: femail.val()},
                success: function(res) {
                    console.log(res);
                    femail.val('');
                    btn.attr('disabled', 'disabled').val('Thanks');
                }
            })
        }
        return false;
    })
});
</script>
<script>
$(document).ready(function(){
    $('#button_expand').on('click', function() {
        $('#content_category').toggleClass('open');
        if($('#content_category').hasClass('open')) {
            $('#button_expand').text('Thu gọn');
        } else {
            $('#button_expand').text('Xem thêm');
        }
    });
	$('#btnAppleCode').on('click', function(){
		if($('#voucherCode').val() == '') alert('Bạn chưa nhập mã code');
		else {
			$.ajax({
				url: '/payment/codeVoucher',
				type: 'post',
				dataType: 'json',
				data: {voucherCode: $('#voucherCode').val().trim(), totalOrder: totalOrder},
				success: function(res) {
					if(res.success) {
						$('#rowCodeVoucher').html(res.html);
						$('#totalPriceShip').text(res.total_order);
					} else {
						
					}
					alert(res.msg);
				}
			});
		}
	});
});
</script>
        
<nav id="mlindo_mobile">
    <div class="navbar-mobile">
        <ul id="menu-menu-produc" class="menu">
            <?php
            $menus = $this->catelog_model->get_list(array('ticlock'=>'0', 'parentid' => 0),'sort ASC',0,0);

            foreach($menus as $item) {
            ?>
                <li id="" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-403">
                    <a href="<?php echo base_url($item['alias']); ?>"><?php echo $item['title_vn']; ?></a>
                    <?php
                        $sub1_menus = $this->catelog_model->get_list(array('ticlock'=>'0', 'parentid' => $item['Id']),'sort ASC',0,0);
                        if(count($sub1_menus) > 0) {
                    ?>
                        <ul>
                            <?php foreach($sub1_menus as $sub1) { ?>
                                <li>
                                    <a  href="<?=site_url($sub1['alias'])?>" class="m-child2"><?=$sub1['title_vn']?></a>
                                    <?php
                                    $sub2_menus = $this->catelog_model->get_list(array('ticlock'=>'0', 'parentid' => $sub1['Id']),'sort ASC',0,0);
                                    if(count($sub2_menus) > 0) {
                                    ?>
                                        <ul>
                                            <?php
                                            foreach($sub2_menus as $key => $sub2) { ?>
                                                <li><a style="font-weight: normal;" title="" href="<?=site_url($sub2['alias'])?>"><?=$sub2['title_vn']?></a></li>
                                        <?php }  ?>
                                        </ul>
                                <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
                <?php } ?>
        </ul>
    </div>
</nav> 
               
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

\
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107154781-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-107154781-1');
</script>
</body>
</html>