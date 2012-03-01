<?php

class ControllerFbHome extends Controller {

    public function index() {
        $this->children = array(
            'fb/header',
            'fb/bestseller',
            'fb/latest', // TODO get dynamically from the installed modules
           // 'fb/featured',
            'fb/footer',
        );        
        $this->document->title = $this->config->get('config_title');
        $this->template = 'fb/template/common/home.tpl';
        $this->response->setOutput($this->render());
    }
}