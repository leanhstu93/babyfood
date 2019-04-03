<?php foreach($products as $item) { ?>
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
<?php } ?>