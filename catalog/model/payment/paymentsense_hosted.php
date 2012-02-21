<?php 
class ModelPaymentPaymentSenseHosted extends Model {
  	public function getMethod($country_id = '', $zone_id = '', $postcode = '') {
		$this->load->language('payment/paymentsense_hosted');
		
		if ($this->config->get('paymentsense_hosted_status')) {
			// Get Address Data (Model)
		    $address = array();
		    if (method_exists($this->customer, 'getAddress')) { // v1.3.2 Normal Checkout
        		$address = $this->customer->getAddress($this->session->data['payment_address_id']);
        		$address['zone_code'] = $address['code'];
			} else {
        		if (isset($this->session->data['payment_address_id']) && $this->session->data['payment_address_id']) { // v1.3.4+ Normal checkout
        			$this->load->model('account/address');
        			$address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
				} else { //v1.3.4+ Guest checkout
					if (isset($this->session->data['guest']) && is_array($this->session->data['guest'])) {
						$address = $this->session->data['guest'];
					}
				}
			}
			$country_id	= (isset($address['country_id'])) ? $address['country_id'] : 0;
			$zone_id 	= (isset($address['zone_id'])) ? $address['zone_id'] : 0;
			//
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('paymentsense_hosted_geo_zone_id') . "' AND country_id = '" . (int)$country_id . "' AND (zone_id = '" . (int)$zone_id . "' OR zone_id = '0')");
			//
			
			if (!$this->config->get('paymentsense_hosted_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
      		  	$status = TRUE;
      		} else {
     	  		$status = FALSE;
			}	
      	} else {
			$status = FALSE;
		}
				
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'         => 'paymentsense_hosted',
        		'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('paymentsense_hosted_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>