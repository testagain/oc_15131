<?php

class ControllerFbHome extends Controller {

    public function index() {
        $this->children = array(
        	'common/content_bottom',
            'fb/header',
            'fb/footer',
        );        
        
        
        
        $this->document->title = $this->config->get('config_title');
        $this->template = 'fb/template/common/home.tpl';
        $this->response->setOutput($this->render());
    }
}