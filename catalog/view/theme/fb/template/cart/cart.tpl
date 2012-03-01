<?php echo $fb_header ?>
<div id="CartHeader" class="Block Moveable Panel">
	<h2><?php echo $heading_title ?></h2>
	<?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <?php if($products) {?>
	<form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="cart_form">
	<table class="CartContents" cellspacing="0" cellpadding="0">
        <tr>
          <th align="left"><?php echo $column_image; ?></th>
          <th align="left"><?php echo $column_name; ?></th>
          <th align="left"><?php echo $column_quantity; ?></th>
          <?php if ($display_price) { ?>
		  <th align="left"><?php echo $column_price; ?></th>
          <th align="left"><?php echo $column_total; ?></th>
		  <?php } ?>
        </tr>
        <?php $class = 'odd'; ?>
        <?php foreach ($products as $product) { ?>
        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
        <tr class="<?php echo $class; ?>" id="row_<?php echo $product['key'] ?>">
          <td align="left"><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></td>
          <td align="left" valign="top"><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><?php echo $product['name']; ?></a>
            <?php if (!$product['stock']) { ?>
            <span style="color: #FF0000; font-weight: bold;">***</span>
            <?php } ?>
            <div>
              <?php foreach ($product['option'] as $option) { ?>
              - <smarketplace><?php echo $option['name']; ?> <?php echo $option['value']; ?></smarketplace><br />
              <?php } ?>
            </div></td>
          
          <td align="left" valign="top"><input type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="3" /><br/>
          <a onclick="Cart.remove_product('<?php echo $product['key'] ?>')"><?php echo $text_remove ?></a>
          </td>
          <?php if ($display_price) { ?>
		  <td align="left" valign="top"><?php echo $product['price']; ?></td>
          <td align="left" valign="top"><?php echo $product['total']; ?></td>
		  <?php } ?>
        </tr>
        <?php } ?>
      </table>
      
       <?php if ($display_price) { ?>
	  <div style="width: 100%; display: inline-block;">
        <table style="float: right; display: inline-block;">
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td align="right"><b><?php echo $total['title']; ?></b></td>
            <td align="right"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
        </table>
        <br />
      </div>
	  <?php } ?>
      <div class="buttons">
        <table>
          <tr>
            <td align="left"><a onclick="$('#cart_form').submit();" class="fb_bluebutton"><span><?php echo $button_update; ?></span></a></td>
            <td align="center"><a onclick="location = '<?php echo str_replace('&amp;', '&', $continue); ?>'" class="fb_bluebutton"><span><?php echo $button_shopping; ?></span></a></td>
            <td align="right"><a href="<?php echo str_replace('&amp;', '&', $checkout); ?>" target="_blank" class="fb_bluebutton"><span><?php echo $button_checkout; ?></span></a></td>
          </tr>
        </table>
      </div>
      
	</form>
	<?php } else{?>
		<div class="CategoryPagination"><?php echo $text_empty_cart ?></div>
		<a onclick="location = '<?php echo str_replace('&amp;', '&', $continue); ?>'" class="fb_bluebutton"><span><?php echo $button_shopping; ?></span></a>
	<?php }?>
</div>