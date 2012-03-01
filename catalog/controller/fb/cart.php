<?php 
class ControllerFbCart extends Controller { 
	
	public function index(){
		
		$this->data['products'] = array();	
		$this->language->load('checkout/cart');
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_empty_cart'] = $this->language->get('text_empty_cart');
		$this->data['button_update'] = $this->language->get('button_update');
        $this->data['button_shopping'] = $this->language->get('button_shopping');
        $this->data['button_checkout'] = $this->language->get('button_checkout');
		
		if (isset($this->session->data['redirect'])) {
                $this->data['continue'] = $this->session->data['redirect'];
                
                unset($this->session->data['redirect']);
            } else {
                $this->data['continue'] = HTTP_SERVER . 'index.php?route=fb/home';
        }
		
		if (isset($this->error['warning'])) {
                $this->data['error_warning'] = $this->error['warning'];			
            } elseif (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
                $this->data['error_warning'] = $this->language->get('error_stock');
            } else {
                $this->data['error_warning'] = '';
            }
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            
            if (isset($this->request->post['quantity'])) {
                if (!is_array($this->request->post['quantity'])) {
                    if (isset($this->request->post['option'])) {
                        $option = $this->request->post['option'];
                    } else {
                        $option = array();	
                    }
                    
                    $this->cart->add($this->request->post['product_id'], $this->request->post['quantity'], $option);
                } else {
                    foreach ($this->request->post['quantity'] as $key => $value) {
                        $this->cart->update($key, $value);
                    }
                }
                
                unset($this->session->data['shipping_methods']);
                unset($this->session->data['shipping_method']);
                unset($this->session->data['payment_methods']);
                unset($this->session->data['payment_method']);
            }

            if (isset($this->request->post['quantity']) || isset($this->request->post['remove'])) {
                unset($this->session->data['shipping_methods']);
                unset($this->session->data['shipping_method']);
                unset($this->session->data['payment_methods']);
                unset($this->session->data['payment_method']);	
                
                $this->redirect(HTTPS_SERVER . 'index.php?route=fb/cart');
            }
    	}
		
		
		if ($this->cart->hasProducts()) {
		
            $this->data['text_select'] = $this->language->get('text_select');
            $this->data['text_sub_total'] = $this->language->get('text_sub_total');
            $this->data['text_discount'] = $this->language->get('text_discount');
            $this->data['text_weight'] = $this->language->get('text_weight');
            $this->data['text_remove'] = $this->language->get('text_remove');
            
            $this->data['column_remove'] = $this->language->get('column_remove');
            $this->data['column_image'] = $this->language->get('column_image');
            $this->data['column_name'] = $this->language->get('column_name');
            $this->data['column_model'] = $this->language->get('column_model');
            $this->data['column_quantity'] = $this->language->get('column_quantity');
            $this->data['column_price'] = $this->language->get('column_price');
            $this->data['column_total'] = $this->language->get('column_total');

			if (!$this->config->get('config_customer_price')) {
                    $this->data['display_price'] = TRUE;
            } elseif ($this->customer->isLogged()) {
                    $this->data['display_price'] = TRUE;
            } else {
                    $this->data['display_price'] = FALSE;
            }
            
            $this->data['action'] = HTTP_SERVER . 'index.php?route=fb/cart';
		
		 	$this->load->model('tool/seo_url'); 
         	$this->load->model('tool/image');

			foreach($this->cart->getProducts() as $result){
        		 $option_data = array();

                foreach ($result['option'] as $option) {
                    $option_data[] = array(
                        'name'  => $option['name'],
                        'value' => $option['value']
                    );
                }

                if ($result['image']) {
                    $image = $result['image'];
                } else {
                    $image = 'no_image.jpg';
                }

                $this->data['products'][] = array(
                    'key'      => $result['key'],
                    'name'     => $result['name'],
                    'model'    => $result['model'],
                    'thumb'    => $this->model_tool_image->resize($image, $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height')),
                    'option'   => $option_data,
                    'quantity' => $result['quantity'],
                    'stock'    => $result['stock'],
                    'price'    => $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))),
                    'total'    => $this->currency->format($this->tax->calculate($result['total'], $result['tax_class_id'], $this->config->get('config_tax'))),
                    'href'     => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=fb/product&product_id=' . $result['product_id'])
                );
        	}
         
		}
         
         $total_data = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();
            
            $this->load->model('checkout/extension');
            
            $sort_order = array(); 
            
            $results = $this->model_checkout_extension->getExtensions('total');
            
            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
            }
            
            array_multisort($sort_order, SORT_ASC, $results);
            
            foreach ($results as $result) {
                $this->load->model('total/' . $result['key']);

                $this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
            }
            
            $sort_order = array(); 
            
            foreach ($total_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $total_data);

            $this->data['totals'] = $total_data;
            
            $this->data['checkout'] = HTTPS_SERVER . 'index.php?route=checkout/cart';
         
         	$this->template = 'fb/template/cart/cart.tpl';
	        
	        $this->children = array(
	            'fb/footer',
	            'fb/header'
	        );
	        
	    $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
		
	}
	
	public function callback(){
		
		$this->language->load('fb/cart');
		$this->load->model('catalog/product');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            
            if (isset($this->request->post['remove'])) {
                //$result = explode('_', $this->request->post['remove']);
                $this->cart->remove(trim($this->request->post['remove']));
            } else {
                if (isset($this->request->post['option'])) {
                    $option = $this->request->post['option'];
                } else {
                    $option = array();	
                }
                
                $this->cart->add($this->request->post['product_id'], $this->request->post['quantity'], $option);
                $product_info = $this->model_catalog_product->getProduct($this->request->post['product_id']);
      			$json['add'] = sprintf($this->language->get('text_cart_add'),$product_info['name'],HTTPS_SERVER .'index.php?route=fb/cart');
            }
        }
        
       // echo "<pre>";print_r($this->cart->getProducts());exit;
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
        
        $json['output'] = $text;
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	public function addtocartoverlay(){
		
		$this->language->load('product/product');
		
	    $this->load->model('catalog/product');
        
	    $json = array();
	    
	    $this->data['text_discount'] = $this->language->get('text_discount');
	    $this->data['text_order_quantity'] = $this->language->get('text_order_quantity');
	    $this->data['text_price_per_item'] = $this->language->get('text_price_per_item');
	    $this->data['text_option'] = $this->language->get('text_option');
	    $this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_discount'] = $this->language->get('text_discount');
		$this->data['text_price'] = $this->language->get('text_price');
	    $this->data['text_select'] = $this->language->get('text_select');
	    $this->data['text_options'] = $this->language->get('text_options');
		
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
		
        $this->data['product_id'] = $product_id;
        $product_info = $this->model_catalog_product->getProduct($product_id);
        $this->data['product_info'] = $product_info;
        
        $desc = strlen($product_info['description']) > 300 ? substr($product_info['description'],0,300).'...' : $product_info['description'];
        
        $this->data['description'] = html_entity_decode($desc, ENT_QUOTES, 'UTF-8');
        
		$this->load->model('tool/image');

		if ($product_info['image']) {
        	$image = $product_info['image'];
        } else {
            $image = 'no_image.jpg';
        }

        $this->data['product_image'] = $this->model_tool_image->resize($image, 120, 120);
        
	    $discount = $this->model_catalog_product->getProductDiscount($product_id);
        $this->data['discount'] = $discount;     
	    
            if ($discount) {
                $this->data['price'] = $this->currency->format($this->tax->calculate($discount, $product_info['tax_class_id'], $this->config->get('config_tax')));
                
                $this->data['special'] = FALSE;
            } else {
                $this->data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
            
                $specials = $this->model_catalog_product->getProductSpecial($product_id);
            
                if ($specials) {
                    $this->data['special'] = $this->currency->format($this->tax->calculate($specials, $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                   $this->data['special'] = FALSE;
                }
            }

			$discounts_data = $this->model_catalog_product->getProductDiscounts($product_id);
			
			$this->data['discounts'] = array(); 
			
			foreach ($discounts_data as $discount) {
				$this->data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
				);
			}            
        
	        if ($product_info['minimum']) {
                $this->data['minimum'] = $product_info['minimum'];
            } else {
                $this->data['minimum'] = 1;
            }     

			$this->data['options'] = array();
			
			$options = $this->model_catalog_product->getProductOptions($product_id);
			
			foreach ($options as $option) { 
				$option_value_data = array();
				
				foreach ($option['option_value'] as $option_value) {
					$option_value_data[] = array(
						'option_value_id' => $option_value['product_option_value_id'],
						'name'            => $option_value['name'],
						'price'           => (float)$option_value['price'] ? $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax'))) : FALSE,
						'prefix'          => $option_value['prefix']
					);
				}
				
				$this->data['options'][] = array(
					'option_id'    => $option['product_option_id'],
					'name'         => $option['name'],
					'option_value' => $option_value_data
				);
			}           
            

		$this->template = 'fb/template/cart/cartoverlay.tpl';
		
		$output = $this->render(TRUE);
		
		$json['output'] = $output;
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
		
	}
	
	
}