<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
<div class="content">
<div class="tabs htabs"><a tab="#tab_general"><?php echo $tab_general; ?></a></div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <div id="tab_general" class="page">
    <table class="form">
	  <tr>
	  	<td colspan="2">
			<img src="/admin/view/image/paymentsense_secure.jpg" />
		</td>
	  </tr>
      <tr>
	  	<td colspan="2">
			<strong>Module Version:</strong> v1.5.1.1<br />
			<strong>Release Date:</strong> 24th Aug 2011
		</td>
	  </tr>
      <tr>
        <td><?php echo $entry_status; ?>
			<div class="help">Enable or Disable this payment module.</div>
		</td>
        <td><select name="paymentsense_hosted_status">
            <?php if ($paymentsense_hosted_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_mid; ?>
			<div class="help"><?php echo $help_mid; ?></div>
		</td>
        <td>
          <input type="text" name="paymentsense_hosted_mid" value="<?php echo $paymentsense_hosted_mid; ?>" />
          <br />
          <?php if (isset($error_mid)) { ?>
          <span class="error"><?php echo $error_mid; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_pass; ?>
			<div class="help"><?php echo $help_pass; ?></div>
		</td>
        <td>
          <input type="text" name="paymentsense_hosted_pass" value="<?php echo $paymentsense_hosted_pass; ?>" />
          <br />
          <?php if (isset($error_pass)) { ?>
          <span class="error"><?php echo $error_pass; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_key; ?>
			<div class="help"><?php echo $help_key; ?></div>
		</td>
        <td>
          <input type="text" name="paymentsense_hosted_key" size="100" value="<?php echo $paymentsense_hosted_key; ?>" />
          <br />
          <?php if (isset($error_key)) { ?>
          <span class="error"><?php echo $error_key; ?></span>
          <?php } ?></td>
      </tr>
      <!--tr>
        <td><?php echo $entry_test; ?></td>
        <td>
          <input type="radio" name="paymentsense_hosted_test" value="1"<?php echo ($paymentsense_hosted_test) ? 'checked="checked"' : '' ?> /><?php echo $text_yes; ?>
          <input type="radio" name="paymentsense_hosted_test" value="0"<?php echo (!$paymentsense_hosted_test) ? 'checked="checked"' : '' ?> /><?php echo $text_no; ?>
		</td>
      </tr-->
      <tr>
        <td><?php echo $entry_type; ?>
			<div class="help">Select "SALE" to capture payment immediately.<br />Select "PREAUTH" to manually collect payment after authorisation.</div>
		</td>
        <td><select name="paymentsense_hosted_type">
            <?php if ($paymentsense_hosted_type) { ?>
            <option value="1" selected="selected"><?php echo $text_sale; ?></option>
            <option value="0"><?php echo $text_preauth; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_sale; ?></option>
            <option value="0" selected="selected"><?php echo $text_preauth; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_order_status; ?>
			<div class="help">Select the desired status for a successful transaction made through the PaymentSense gateway.</div>
		</td>
        <td><select name="paymentsense_hosted_order_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $paymentsense_hosted_order_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
	   <tr>
        <td><?php echo $entry_failed_order_status; ?>
			<div class="help">Select the desired status for a failed transaction made through the PaymentSense gateway.</div>
		</td>
        <td><select name="paymentsense_hosted_failed_order_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $paymentsense_hosted_failed_order_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_geo_zone; ?>
			<div class="help">Select the zone which can use this payment method.</div>
		</td>
        <td><select name="paymentsense_hosted_geo_zone_id">
            <option value="0"><?php echo $text_all_zones; ?></option>
            <?php foreach ($geo_zones as $geo_zone) { ?>
            <?php if ($geo_zone['geo_zone_id'] == $paymentsense_hosted_geo_zone_id) { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
	  <tr>
	  	<td colspan="2">
			<strong>Mandatory Fields</strong>
			<div class="help">Select the fields you require a customer to complete on the hosted payment page.</div>
		</td>
	  </tr>
	  <tr>
        <td><?php echo $entry_CV2Mandatory; ?></td>
        <td><select name="paymentsense_hosted_cv2_mand">
            <?php if ($paymentsense_hosted_cv2_mand == "TRUE") { ?>
            <option value="TRUE" selected="selected">True</option>
            <option value="FALSE">False</option>
            <?php } else { ?>
            <option value="TRUE">True</option>
            <option value="FALSE" selected="selected">False</option>
            <?php } ?>
          </select></td>
      </tr>
	  <tr>
        <td><?php echo $entry_Address1Mandatory; ?></td>
        <td><select name="paymentsense_hosted_address1_mand">
            <?php if ($paymentsense_hosted_address1_mand == "TRUE") { ?>
            <option value="TRUE" selected="selected">True</option>
            <option value="FALSE">False</option>
            <?php } else { ?>
            <option value="TRUE">True</option>
            <option value="FALSE" selected="selected">False</option>
            <?php } ?>
          </select></td>
      </tr>
	  <tr>
        <td><?php echo $entry_CityMandatory; ?></td>
        <td><select name="paymentsense_hosted_city_mand">
            <?php if ($paymentsense_hosted_city_mand == "TRUE") { ?>
            <option value="TRUE" selected="selected">True</option>
            <option value="FALSE">False</option>
            <?php } else { ?>
            <option value="TRUE">True</option>
            <option value="FALSE" selected="selected">False</option>
            <?php } ?>
          </select></td>
      </tr>
	  <tr>
        <td><?php echo $entry_PostCodeMandatory; ?></td>
        <td><select name="paymentsense_hosted_postcode_mand">
            <?php if ($paymentsense_hosted_postcode_mand == "TRUE") { ?>
            <option value="TRUE" selected="selected">True</option>
            <option value="FALSE">False</option>
            <?php } else { ?>
            <option value="TRUE">True</option>
            <option value="FALSE" selected="selected">False</option>
            <?php } ?>
          </select></td>
      </tr>
	  <tr>
        <td><?php echo $entry_StateMandatory; ?></td>
        <td><select name="paymentsense_hosted_state_mand">
            <?php if ($paymentsense_hosted_state_mand == "TRUE") { ?>
            <option value="TRUE" selected="selected">True</option>
            <option value="FALSE">False</option>
            <?php } else { ?>
            <option value="TRUE">True</option>
            <option value="FALSE" selected="selected">False</option>
            <?php } ?>
          </select></td>
      </tr>
	  <tr>
        <td><?php echo $entry_CountryMandatory; ?></td>
        <td><select name="paymentsense_hosted_country_mand">
            <?php if ($paymentsense_hosted_country_mand == "TRUE") { ?>
            <option value="TRUE" selected="selected">True</option>
            <option value="FALSE">False</option>
            <?php } else { ?>
            <option value="TRUE">True</option>
            <option value="FALSE" selected="selected">False</option>
            <?php } ?>
          </select></td>
      </tr>
    </table>
  </div>
</form>
</div>
  </div>
</div>
<?php echo $footer; ?> 