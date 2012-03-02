<?php   

class ControllerFbHeader extends Controller {
    
    public function index(){
        
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = HTTPS_IMAGE;
        } else {
            $server = HTTP_IMAGE;
        }
        
        if ($this->config->get('config_banner') && file_exists(DIR_IMAGE . $this->config->get('config_banner'))) {
            $this->data['banner'] = $server . $this->config->get('config_icon');
        } else {
            $this->data['banner'] = '';
        }
        
        if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
            $this->data['icon'] = $server . $this->config->get('config_icon');
        } else {
            $this->data['icon'] = '';
        }
        
        $this->data['show_banner'] = 0;
        if(isset($this->request->get['route']) && $this->request->get['route'] == 'fb/home'){
            $this->data['show_banner'] = 1;
        }
        
    	if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = $this->config->get('config_ssl');
		} else {
			$this->data['base'] = $this->config->get('config_url');
		}
        $this->data['charset'] = $this->language->get('charset');
        $this->data['lang'] = $this->language->get('code');
        $this->data['direction'] = $this->language->get('direction');
        $this->data['title'] = $this->document->title;
        $this->data['keywords'] = $this->document->keywords;
        $this->data['description'] = $this->document->description;
        
        $this->language->load('fb/header');
        
    	$output = 0;
        
        foreach($this->cart->getProducts() as $product){
        	$output+= $product['quantity'];
        }
    	if($output == 1){
        	$text = $this->language->get('text_view_cart').' ('.sprintf($this->language->get('text_num_item'),$output).')';
        }else if($output > 1){
        	$text = $this->language->get('text_view_cart').' ('.sprintf($this->language->get('text_num_items'),$output).')';
        }else{
        	$text = $this->language->get('text_view_cart');
        }
        
        $this->data['my_cart'] = $text;
        $this->data['cart'] = HTTP_SERVER . 'index.php?route=fb/cart';
        
        $this->data['store_name'] = $this->config->get('config_name');
        
        $this->data['text_home'] = $this->language->get('text_home');
        $this->data['text_placeholder_search'] = $this->language->get('text_placeholder_search');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_view_cart'] = $this->language->get('text_view_cart');
        $this->data['text_categories'] = $this->language->get('text_categories');
        $this->data['text_see_more'] = $this->language->get('text_see_more');
        $this->data['text_close'] = $this->language->get('text_close');
        
        if (isset($this->request->get['keyword'])) {
            $this->data['keyword'] = $this->request->get['keyword'];
        } else {
            $this->data['keyword'] = '';
        } 
        
        $this->data['home'] = HTTP_SERVER . 'index.php?route=fb/home';
        
        $this->load->model('catalog/category');
        $this->load->model('tool/seo_url');
        $categories = $this->model_catalog_category->getCategories(0);
       	$this->data['categories'] = array();
 
        foreach($categories as $category){
            $this->data['categories'][] = array(
                'name'		=>	$category['name'],
                'href'		=>	$this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=fb/category&amp;path=' . $category['category_id'])
            );
        }
        
        $this->template = 'fb/template/common/header.tpl';
    	$this->render();
        
    }
    
}