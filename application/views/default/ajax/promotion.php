<?php
if(!empty($pro)){
	foreach($pro as $item){
	if($item['price']>0)	$pt = 100-floor(($item['sale_price']/ $item['price'])*100); else  $pt=0;	
?>
	 <div class="itempro">
    <div class="images">
     <?php  if($pt>0){ ?><span class="price__discount"><span>-<?php echo $pt; ?>%</span></span><?php } ?>
   	<a href="<?php echo base_url('san-pham/'.$item['alias'].'-'.$item['Id'].'.html') ?>">
    <img src="<?php echo PATH_IMG_PRODUCT.$item['images'] ?>" alt="<?php echo $item['title_vn'] ?>" />
    </a>
    </div>
    <h2><a href="<?php echo base_url('san-pham/'.$item['alias'].'-'.$item['Id'].'.html') ?>"><?php echo $item['title_vn'] ?></a></h2>
    <p class="price">
    <span class="sale-price"><?php echo bsVndDot($item['sale_price']) ?>đ</span>
    <?php if($item['price']>0){ ?>
    <span class="old-price"><?php echo bsVndDot($item['price']) ?>đ</span>
    <?php } ?>
    </p>
    </div>
<?php }}else echo 0; ?>