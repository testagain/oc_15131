<!-- prefix: po -->
<div class="poProductContainer">
<ul class="l w40 pad10 lsNone">
					<li class="poImgContainer"><img src="<?php echo $product_image ?>" alt="Img1" class="poImg" /></li>
				</ul>
				
				<div class="r w40 pad10">
					<p class="h1 vpad10 tBlue"><?php echo $product_info['name'] ?></p>
<?php if (!$special) { ?>
	<p class="h4 vpad10">Price <span class="poPrice h2"><?php echo $price ?></span></p>
<?php } else {?>
	<p class="h4 vpad10">Price <span class="strikeCut"><?php echo $price ?></span> <span class="specialprice"><?php echo $special ?></span></p>
<?php }?>
<p class="h4 vpad10"><?php echo $description ?></p>
				</div> <!-- l w50 pad10 -->
				
				<div class="clear"></div>
				
			</div> <!-- poProductContainer -->	
			
			<div class="h6 topSepBlueBorder">&nbsp;</div> <!-- topsepborder -->
<div class="poFormContainer">
				<div class="w50 pad10 l formContainerX">
					<p class="formParaSep">
						<label for="qty">Quantity</label> <input id="qty" name="quantity" value="<?php echo $minimum ?>" class="w50 pad5" type="text" />
					</p>

    
  <?php if ($discounts) { ?>
  <br /><br /><b><?php echo $text_discount ?></b><br />
					              <div class="discounts">
					                <table class="fullwidth">
					                  <tr>
					                    <td class="tal"><b><?php echo $text_order_quantity ?></b></td>
					                    <td class="tal"><b><?php echo $text_price_per_item ?></b></td>
					          </tr>
		<?php foreach ($discounts as $discount) { ?>
			<tr>
			                    <td class="tal"><?php echo $discount['quantity'] ?></td>
			                    <td class="tal"><p class="h4 vpad10"><span class="poPrice h2"><?php echo $discount['price'] ?></span></p></td>
			                  </tr>
		
		<?php }?>			          
  </table>
</div>
<?php }?>
</div> <!-- w50 l pad10 -->
<div class="clear"></div>
 <?php if ($options) { ?>
              <b><?php echo $text_options; ?></b><br />
              <div>
                <table style="width: 100%;">
                  <?php foreach ($options as $option) { ?>
                  <tr>
                    <td><?php echo $option['name']; ?>:<br />
                      <select name="option[<?php echo $option['option_id']; ?>]">
                        <?php foreach ($option['option_value'] as $option_value) { ?>
                        <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?>
                        <?php if ($option_value['price']) { ?>
                        <?php echo $option_value['prefix']; ?><?php echo $option_value['price']; ?>
                        <?php } ?>
                        </option>
                        <?php } ?>
                      </select></td>
                  </tr>
                  <?php } ?>
                </table>
              </div>
 <?php } ?>

<div class="w40 pad10 r">
					<p class="tm20"><a id="add_to_cart" class="fb_bluebutton">Add item</a></p>
					<input type="hidden" name="product_id" value="<?php echo $product_id ?>" />
				</div> <!-- w50 l pad10 -->
				
				<div class="clear"></div>
</div> <!-- poOrderContainer -->