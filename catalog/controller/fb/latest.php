<?php

class ControllerFbLatest extends Controller {

    public function index() {
        // load the models
        $this->load->model('catalog/product');
        $this->load->language('module/latest');
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');
        // get the products
        $results = $this->model_catalog_product->getLatestProducts($this->config->get('latest_limit'));
        $this->data['products'] = array();
        foreach ($results as $result) {
            $product = new Product($this->registry);
            $product->load($result);
            $this->data['products'][] = $product;
        }
        $this->id = 'latest';
        $this->data['id'] = $this->id;
        if (!$this->config->get('config_customer_price')) {
            $this->data['display_price'] = TRUE;
        } elseif ($this->customer->isLogged()) {
            $this->data['display_price'] = TRUE;
        } else {
            $this->data['display_price'] = FALSE;
        }
        // set the template and render
        $this->template = 'fb/template/product/carousel.tpl';
        $this->render();
    }

}