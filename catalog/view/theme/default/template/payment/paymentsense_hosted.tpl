<form action="<?php echo $action; ?>" method="post" id="payment">
  <?php foreach ($fields as $key => $value) { ?>
    <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
  <?php } ?>
</form>
<div class="buttons">
    <div class="right">
		<a onclick="location='<?php echo $back; ?>'" class="button"><span><?php echo $button_back; ?></span></a>
		<a onclick="confirmSubmit();" class="button"><span><?php echo $button_continue; ?></span></a>	
	</div>
</div>
<script type="text/javascript"><!--
function confirmSubmit() {
	$.ajax({
		type: 'GET',
		url: 'index.php?route=payment/paymentsense_hosted/confirm',
		success: function() {
			$('#payment').submit();
		}
	});
}
//--></script>