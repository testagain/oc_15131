<?php 
class ControllerPaymentPaymentSenseHosted extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/paymentsense_hosted');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {			
			$this->model_setting_setting->editSetting('paymentsense_hosted', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect((((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=extension/payment'));
		}		

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_preauth'] = $this->language->get('text_preauth');
				
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_failed_order_status'] = $this->language->get('entry_failed_order_status');
		$this->data['entry_mid'] = $this->language->get('entry_mid');
		$this->data['entry_pass'] = $this->language->get('entry_pass');
		$this->data['entry_key'] = $this->language->get('entry_key');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_type'] = $this->language->get('entry_type');
		
		$this->data['entry_CV2Mandatory'] = $this->language->get('entry_CV2Mandatory');
		$this->data['entry_Address1Mandatory'] = $this->language->get('entry_Address1Mandatory');
		$this->data['entry_CityMandatory'] = $this->language->get('entry_CityMandatory');
		$this->data['entry_PostCodeMandatory'] = $this->language->get('entry_PostCodeMandatory');
		$this->data['entry_StateMandatory'] = $this->language->get('entry_StateMandatory');
		$this->data['entry_CountryMandatory'] = $this->language->get('entry_CountryMandatory');		
		
		$this->data['help_mid'] = $this->language->get('help_mid');
		$this->data['help_pass'] = $this->language->get('help_pass');
		$this->data['help_key'] = $this->language->get('help_key');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

		if (isset($this->error['warning'])) {$this->data['error_warning'] = $this->error['warning'];} else { $this->data['error_warning'] = ''; }
		if (isset($this->error['mid'])) {$this->data['error_mid'] = $this->error['mid'];} else { $this->data['error_mid'] = ''; }
		if (isset($this->error['pass'])) {$this->data['error_pass'] = $this->error['pass'];} else { $this->data['error_pass'] = ''; }
		if (isset($this->error['key'])) {$this->data['error_key'] = $this->error['key'];} else { $this->data['error_key'] = ''; }

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/paymentsense_hosted', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('payment/paymentsense_hosted', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['paymentsense_hosted_status'])) {
			$this->data['paymentsense_hosted_status'] = $this->request->post['paymentsense_hosted_status'];
		} else {
			$this->data['paymentsense_hosted_status'] = $this->config->get('paymentsense_hosted_status');
		}
		
		if (isset($this->request->post['paymentsense_hosted_geo_zone_id'])) {
			$this->data['paymentsense_hosted_geo_zone_id'] = $this->request->post['paymentsense_hosted_geo_zone_id'];
		} else {
			$this->data['paymentsense_hosted_geo_zone_id'] = $this->config->get('paymentsense_hosted_geo_zone_id'); 
		}

		if (isset($this->request->post['paymentsense_hosted_order_status_id'])) {
			$this->data['paymentsense_hosted_order_status_id'] = $this->request->post['paymentsense_hosted_order_status_id'];
		} else {
			$this->data['paymentsense_hosted_order_status_id'] = $this->config->get('paymentsense_hosted_order_status_id'); 
		} 
		
		if (isset($this->request->post['paymentsense_hosted_failed_order_status_id'])) {
			$this->data['paymentsense_hosted_failed_order_status_id'] = $this->request->post['paymentsense_hosted_failed_order_status_id'];
		} else {
			$this->data['paymentsense_hosted_failed_order_status_id'] = $this->config->get('paymentsense_hosted_failed_order_status_id'); 
		}

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['paymentsense_hosted_mid'])) {
			$this->data['paymentsense_hosted_mid'] = $this->request->post['paymentsense_hosted_mid'];
		} else {
			$this->data['paymentsense_hosted_mid'] = $this->config->get('paymentsense_hosted_mid');
		}
		
		if (isset($this->request->post['paymentsense_hosted_pass'])) {
			$this->data['paymentsense_hosted_pass'] = $this->request->post['paymentsense_hosted_pass'];
		} else {
			$this->data['paymentsense_hosted_pass'] = $this->config->get('paymentsense_hosted_pass');
		}
		
		if (isset($this->request->post['paymentsense_hosted_key'])) {
			$this->data['paymentsense_hosted_key'] = $this->request->post['paymentsense_hosted_key'];
		} else {
			$this->data['paymentsense_hosted_key'] = $this->config->get('paymentsense_hosted_key');
		}
		
		if (isset($this->request->post['paymentsense_hosted_test'])) {
			$this->data['paymentsense_hosted_test'] = $this->request->post['paymentsense_hosted_test'];
		} else {
			$this->data['paymentsense_hosted_test'] = $this->config->get('paymentsense_hosted_test');
		}
		
		if (isset($this->request->post['paymentsense_hosted_type'])) {
			$this->data['paymentsense_hosted_type'] = $this->request->post['paymentsense_hosted_type'];
		} else {
			$this->data['paymentsense_hosted_type'] = $this->config->get('paymentsense_hosted_type');
		}
		
		if (isset($this->request->post['paymentsense_hosted_sort_order'])) {
			$this->data['paymentsense_hosted_sort_order'] = $this->request->post['paymentsense_hosted_sort_order'];
		} else {
			$this->data['paymentsense_hosted_sort_order'] = $this->config->get('paymentsense_hosted_sort_order');
		}
		
		if (isset($this->request->post['paymentsense_hosted_cv2_mand'])) {
			$this->data['paymentsense_hosted_cv2_mand'] = $this->request->post['paymentsense_hosted_cv2_mand'];
		} else {
			$this->data['paymentsense_hosted_cv2_mand'] = $this->config->get('paymentsense_hosted_cv2_mand');
		}
		
		if (isset($this->request->post['paymentsense_hosted_address1_mand'])) {
			$this->data['paymentsense_hosted_address1_mand'] = $this->request->post['paymentsense_hosted_address1_mand'];
		} else {
			$this->data['paymentsense_hosted_address1_mand'] = $this->config->get('paymentsense_hosted_address1_mand');
		}
		
		if (isset($this->request->post['paymentsense_hosted_city_mand'])) {
			$this->data['paymentsense_hosted_city_mand'] = $this->request->post['paymentsense_hosted_city_mand'];
		} else {
			$this->data['paymentsense_hosted_city_mand'] = $this->config->get('paymentsense_hosted_city_mand');
		}
		
		if (isset($this->request->post['paymentsense_hosted_postcode_mand'])) {
			$this->data['paymentsense_hosted_postcode_mand'] = $this->request->post['paymentsense_hosted_postcode_mand'];
		} else {
			$this->data['paymentsense_hosted_postcode_mand'] = $this->config->get('paymentsense_hosted_postcode_mand');
		}
		
		if (isset($this->request->post['paymentsense_hosted_state_mand'])) {
			$this->data['paymentsense_hosted_state_mand'] = $this->request->post['paymentsense_hosted_state_mand'];
		} else {
			$this->data['paymentsense_hosted_state_mand'] = $this->config->get('[paymentsense_hosted_state_mand');
		}
				
		if (isset($this->request->post['paymentsense_hosted_country_mand'])) {
			$this->data['paymentsense_hosted_country_mand'] = $this->request->post['paymentsense_hosted_country_mand'];
		} else {
			$this->data['paymentsense_hosted_country_mand'] = $this->config->get('paymentsense_hosted_country_mand');
		}
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
			
		$this->template = 'payment/paymentsense_hosted.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/paymentsense_hosted')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['paymentsense_hosted_mid']) {
			$this->error['mid'] = $this->language->get('error_mid');
		}
		
		if (!$this->request->post['paymentsense_hosted_pass']) {
			$this->error['pass'] = $this->language->get('error_pass');
		}
		
		if (!$this->request->post['paymentsense_hosted_key']) {
			$this->error['key'] = $this->language->get('error_key');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>