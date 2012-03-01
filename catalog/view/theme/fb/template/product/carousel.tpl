<?php if ($products) { ?>
<div class="product-carousel">
    <h2><?php echo $heading_title; ?></h2>
    <ul id="<?php echo $id; ?>-carousel" class="jcarousel-skin-kmfb">
        <?php foreach ($products as $product) { ?>
            <li>
                <a href="<?php echo $product->href(); ?>"><img src="<?php echo $product->image(); ?>" alt="<?php echo $product->name(); ?>" /></a>
                <br />
                <a href="<?php echo $product->href(); ?>" title="<?php echo $product->name(); ?>"><?php echo (strlen($product->name()) > 16 ? substr($product->name(), 0, 16) . '..' : $product->name()); ?></a>
                <?php if ($display_price) { ?>
                <br />
                <?php if (!$product->special_price()) { ?>
                <span class="fb-price"><?php echo $product->price(); ?></span>
                <?php } else { ?>
                <span class="fb-price-strike"><?php echo $product->price(); ?></span> <span class="lite-price"><?php echo $product->special_price(); ?></span>
                <?php } ?>
                <br/><br/>
                <a class="fb_bluebutton" onclick="Cart.show_overlay(<?php echo $product->product_id(); ?>);" title="<?php echo $button_add_to_cart; ?>" ><?php echo $button_add_to_cart; ?></a>
                <?php } ?>
                <?php if ($product->rating()) { ?>
                <br /><br />
                <img src="catalog/view/theme/default/image/stars_<?php echo $product->rating() . '.png'; ?>" alt="<?php echo $product->star_rating(); ?>" />
                <?php } ?>
            </li>
            <?php } ?>        
    </ul>
</div>
<?php } ?>
<script type="text/javascript" charset="utf-8">
  $(window).load(function() {
    jQuery('#<?php echo $id; ?>-carousel').jcarousel();
  });
</script>
