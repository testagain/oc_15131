<?php echo $fb_header ?>
<div id="CategoryHeading" class="Block Moveable Panel">
	<h2><?php echo $heading_title ?></h2>
<?php if($category_id) {?>	
	<?php if($categories) {?>
	<div class="SubCategoryList">
		<ul>
			<?php foreach($categories as $category){?>
				<li><a href="<?php echo $category['href']?>"><?php echo $category['name']?></a></li>
			<?php }?>
		
		</ul>
	</div>
	<?php }?>
	
	<?php if($products) {?>
	<div class="clear CategoryPagination">
		<div class="pagination"><?php echo $pagination ?></div>
	</div>
	<div class="SearchSorting">
		<?php echo $text_sort ?><select name="sort" onchange="location = this.value">
	          <?php foreach ($sorts as $sorts) { ?>
	          <?php if (($sort . '-' . $order) == $sorts['value']) { ?>
	          <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
	          <?php } else { ?>
	          <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
	          <?php } ?>
	          <?php } ?>
	        </select>
	</div>
	
	<ul id="product_list" class="clear">
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
                <a class="fb_bluebutton" onclick="Cart.show_overlay(<?php echo $product->product_id(); ?>);"" title="<?php echo $button_add_to_cart; ?>" ><?php echo $button_add_to_cart; ?></a>
                <?php } ?>
                <?php if ($product->rating()) { ?>
                <br />
                <img src="catalog/view/theme/default/image/stars_<?php echo $product->rating() . '.png'; ?>" alt="<?php echo $product->star_rating(); ?>" />
                <?php } ?>
            </li>
            <?php } ?> 
            <li class="clear"></li>       
    </ul>
	
	<div class="clear CategoryPagination">
		<div class="pagination"><?php echo $pagination ?></div>
	</div>
	<?php } else {?>
		<div><?php echo $text_no_product ?></div>
	<?php }?>
	
<?php }?>	
</div>
<?php echo $fb_footer ?>