<?php echo $fb_header ?>
<div id="SearchPageHeader" class="Block Moveable Panel">
	<h2><?php echo $heading_title ?></h2>
</div>
<?php if($products) {?>
<div class="CategoryPagination">
	<div class="pagination"><?php echo $pagination ?></div>
</div>
<div class="SearchSorting clear">
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

<ul class="ProductList List clear">
	<?php foreach($products as $product) {?>
	<li>
		<div class="ProductImage">
			<a href="<?php echo $product['href']?>"><img src="<?php echo $product['thumb']?>"/></a>
		</div>
		<div class="ProductDetails">
			<div class="ProductRightCol">
				<span class="ProductPrice">
					<?php if (!$product['special']) { ?>
          			<span style="color: #4E4E4E; font-weight: bold;"><?php echo $product['price']; ?></span>
          			<?php } else { ?>
          			<span style="color: #4E4E4E font-weight: bold; text-decoration: line-through;"><?php echo $product['price']; ?></span> <span style="color: #F00;"><?php echo $product['special']; ?></span>
          			<?php } ?>	
			 	</span>
			</div>
			<strong>
				<a href="<?php echo $product['href']?>"><?php echo $product['name'] ?></a>
			</strong>
			<?php if ($product['rating']) { ?>
			<div class="Rating Rating0">
          			<img src="catalog/view/theme/default/image/stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" />
			</div>
			<?php } ?>
			<div class="ProductDescription">
				<?php echo $product['description'] ?>
			</div>
			<div class="ProductCompareButton">
				<a class="fb_bluebutton" onclick="Cart.show_overlay(<?php echo $product['product_id']; ?>);"><?php echo $button_add_to_cart ?></a>
			</div>
		</div>
	</li>
	<?php }?>
</ul>
<div class="clear CategoryPagination">
	<div class="pagination"><?php echo $pagination ?></div>
</div>
<?php } else {?>
	<div><?php echo $text_no_result ?></div>
<?php }?>
<?php echo $fb_footer ?>