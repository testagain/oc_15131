<?php 
class ControllerFbCategory extends Controller { 	
	
	public function index(){
		
		$this->language->load('product/category');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('tool/seo_url');
		
		$this->data['text_sort'] = $this->language->get('text_sort');
        $this->data['text_no_product'] = $this->language->get('text_empty');
        $this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');
        
		$this->data['categories'] = array();
		
		if (isset($this->request->get['path'])) {
			$this->data['category_id'] = $this->request->get['path']; 
			$category_id = $this->request->get['path'];
			
			$category_info = $this->model_catalog_category->getCategory($category_id);
			
			$this->data['heading_title'] = $category_info['name'];
			
			$this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			
			$this->data['text_sort'] = $this->language->get('text_sort');
				
			$results = $this->model_catalog_category->getCategories($category_id);
				
        		foreach ($results as $result) {
					$this->data['categories'][] = array(
            			'name'  => $result['name'],
            			'href'  => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=fb/category&path='.$result['category_id']),
          			);
        		}
        		
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else { 
				$page = 1;
			}	
			
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'p.sort_order';
			}

			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'ASC';
			}	
        		
        	$this->data['products'] = array();
        		
			if (!$this->config->get('config_customer_price')) {
                    $this->data['display_price'] = TRUE;
            } elseif ($this->customer->isLogged()) {
                    $this->data['display_price'] = TRUE;
            } else {
                    $this->data['display_price'] = FALSE;
            }
        	
        	$results = $this->model_catalog_product->getProductsByCategoryId($category_id, $sort, $order, ($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));	
			$product_total = $this->model_catalog_product->getTotalProductsByCategoryId($category_id);
        	
        	foreach($results as $result){
        		$product = new Product($this->registry);
            	$product->load($result);
            	$product->image_size(150);
            	
            	$this->data['products'][] = $product;
        	}
        	
        	
        	//echo "<pre>";print_r($this->data['products']);exit;
        		$url = '';

                if (isset($this->request->get['page'])) {
                    $url .= '&page=' . $this->request->get['page'];
                }	
                
                $this->data['sorts'] = array();
                
                $this->data['sorts'][] = array(
                    'text'  => $this->language->get('text_default'),
                    'value' => 'p.sort_order-ASC',
                    'href'  => HTTP_SERVER . 'index.php?route=fb/category&path='.$category_id . $url . '&sort=p.sort_order&order=ASC'
                );
                
                $this->data['sorts'][] = array(
                    'text'  => $this->language->get('text_name_asc'),
                    'value' => 'pd.name-ASC',
                    'href'  => HTTP_SERVER . 'index.php?route=fb/category&path='.$category_id.  $url . '&sort=pd.name&order=ASC'
                ); 

                $this->data['sorts'][] = array(
                    'text'  => $this->language->get('text_name_desc'),
                    'value' => 'pd.name-DESC',
                    'href'  => HTTP_SERVER . 'index.php?route=fb/category&path='.$category_id . $url . '&sort=pd.name&order=DESC'
                );

                $this->data['sorts'][] = array(
                    'text'  => $this->language->get('text_price_asc'),
                    'value' => 'p.price-ASC',
                    'href'  => HTTP_SERVER . 'index.php?route=fb/category&path='.$category_id . $url . '&sort=p.price&order=ASC'
                ); 

                $this->data['sorts'][] = array(
                    'text'  => $this->language->get('text_price_desc'),
                    'value' => 'p.price-DESC',
                    'href'  => HTTP_SERVER . 'index.php?route=fb/category&path='.$category_id. $url . '&sort=p.price&order=DESC'
                ); 
                
                $this->data['sorts'][] = array(
                    'text'  => $this->language->get('text_rating_desc'),
                    'value' => 'rating-DESC',
                    'href'  => HTTP_SERVER . 'index.php?route=fb/category&path='.$category_id . $url . '&sort=rating&order=DESC'
                ); 
                
                $this->data['sorts'][] = array(
                    'text'  => $this->language->get('text_rating_asc'),
                    'value' => 'rating-ASC',
                    'href'  => HTTP_SERVER . 'index.php?route=product/category&path='.$category_id . $url . '&sort=rating&order=ASC'
                );
                
                $this->data['sorts'][] = array(
                    'text'  => $this->language->get('text_model_asc'),
                    'value' => 'p.model-ASC',
                    'href'  => HTTP_SERVER . 'index.php?route=fb/category&path='.$category_id . $url . '&sort=p.model&order=ASC'
                ); 

                $this->data['sorts'][] = array(
                    'text'  => $this->language->get('text_model_desc'),
                    'value' => 'p.model-DESC',
                    'href'  => HTTP_SERVER . 'index.php?route=fb/category&path='.$category_id . $url . '&sort=p.model&order=DESC'
                );
        	
        	
        	    $url = '';

                if (isset($this->request->get['keyword'])) {
                    $url .= '&keyword=' . $this->request->get['keyword'];
                }
                
                if (isset($this->request->get['category_id'])) {
                    $url .= '&category_id=' . $this->request->get['category_id'];
                }
                
                if (isset($this->request->get['description'])) {
                    $url .= '&description=' . $this->request->get['description'];
                }
                
                if (isset($this->request->get['model'])) {
                    $url .= '&model=' . $this->request->get['model'];
                }
                
                if (isset($this->request->get['sort'])) {
                    $url .= '&sort=' . $this->request->get['sort'];
                }	

                if (isset($this->request->get['order'])) {
                    $url .= '&order=' . $this->request->get['order'];
                }
                
                $pagination = new Pagination();
                $pagination->total = $product_total;
                $pagination->page = $page;
                $pagination->limit = $this->config->get('config_catalog_limit');
                $pagination->text = $this->language->get('text_pagination');
                $pagination->url = HTTP_SERVER . 'index.php?route=fb/search' . $url . '&page={page}';
                
                $this->data['pagination'] = $pagination->render();
                
                $this->data['sort'] = $sort;
                $this->data['order'] = $order;
		}else{
			$this->data['category_id'] = 0;
		}
		
		$this->template = 'fb/template/product/category.tpl';
	        
	        $this->children = array(
	            'fb/footer',
	            'fb/header'
	        );
	        
	        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
		
	}
	
}