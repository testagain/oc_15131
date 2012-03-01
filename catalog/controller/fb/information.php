<?php  
class ControllerFbInformation extends Controller {
	public function index() {
		
		$this->language->load('information/information');
		
		$this->load->model('catalog/information');
		
		$this->document->breadcrumbs = array();
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	);
		
		if (isset($this->request->get['information_id'])) {
			$information_id = $this->request->get['information_id'];
		} else {
			$information_id = 0;
		}
		
		$information_info = $this->model_catalog_information->getInformation($information_id);
   		
		if ($information_info) {
	  		$this->document->title = $information_info['title']; 

      		$this->document->breadcrumbs[] = array(
        		'href'      => HTTP_SERVER . 'index.php?route=information/information&information_id=' . $this->request->get['information_id'],
        		'text'      => $information_info['title'],
        		'separator' => $this->language->get('text_separator')
      		);		
						
      		$this->data['heading_title'] = $information_info['title'];
      		
      		$this->data['button_continue'] = $this->language->get('button_continue');
			
			$this->data['description'] = html_entity_decode($information_info['description']);
      		
			$this->data['continue'] = HTTP_SERVER . 'index.php?route=common/home';

			$this->template = 'fb/template/common/information.tpl';
	        
	        $this->children = array(
	            'fb/footer',
	            'fb/header'
	        );
	        
	    	$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
}
}