<?php 
class ControllerFbFooter extends Controller { 
	
	public function index(){
		$this->language->load('fb/footer');
		$this->load->model('catalog/information');
		$this->load->model('tool/seo_url');
		$this->data['informations'] = array();

		$this->data['facebook_application_id'] = $this->config->get('facebook_application_id');
		
		foreach ($this->model_catalog_information->getInformations() as $result) {
      		$this->data['informations'][] = array(
        		'title' => $result['title'],
	    		'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=fb/information&information_id=' . $result['information_id'])
      		);
    	}
		
		$this->data['text_add_to_cart'] = $this->language->get('text_add_to_cart');
		$this->id = 'fb_footer';
		$this->template = 'fb/template/common/footer.tpl';
		$this->render();
	}
	
}