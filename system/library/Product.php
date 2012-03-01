<?php 

class Product extends GenericObject {

    /**
     * Array to store the passed db row data
     */
    protected $_data = array();

    /**
     * Integer product_id primary key
     */
    protected $_product_id;

    /**
     * String product name
     */
    protected $_name;

    /**
     * String model
     */
    protected $_model;

    /**
     * String rating on the product
     */
    protected $_rating;

    /**
     * String ratings in terms of stars
     */
    protected $_star_rating;

    /**
     * Decimal Price 
     */
    protected $_original_price;

    /**
     * Decimal Final calculated price
     */
    protected $_price;

    /**
     * Array options
     */
    protected $_options;
    
    /**
     * Decimal Special Price
     */
    protected $_special_price;
    
    protected $_imagefile;
    
    /**
     * String image href
     */
    protected $_image;

    /**
     * String image thumbnail href
     */
    protected $_thumb;

    /**
     * String Product href
     */
    protected $_href;

    protected $_stock;

    protected $_description;

    protected $_sku;

    protected $_manufacturer;

    protected $_minimum = 1;

    /**
     * Integer image size in pixels (defaults to 90)
     */
    private static $_image_size = 90;

    /**
     * Add to cart href
     */
    protected $_add_cart_href;    

    public function __construct($registry) {
        parent::__construct($registry);
        $this->load->model('catalog/product');
        $this->load->model('catalog/review');
        $this->load->model('tool/seo_url');
        $this->load->model('tool/image');
        $this->load->language('module/latest');
    }

    /**
     * Load the product object from the db row array
     * @param Array $data
     */
    public function load(array $row) {
        $this->_data = $row;
        $this->_product_id = $row['product_id'];
        $this->_name = $row['name'];
        $this->_model = $row['model'];
        $this->_manufacturer = isset($row['manufacturer']) ? $row['manufacturer'] : '';
        $this->_original_price = $row['price'];
        $this->_price = $this->price();
        $this->_imagefile = $row['image'];
        $this->_tax_class_id  = $row['tax_class_id'];
        $this->_stock = isset($row['stock']) ? $row['stock'] : '' ;
        $this->_sku = $row['sku'];
        $this->_description = $row['description'];
        $this->_minimum = $row['minimum'] ? $row['minimum'] : 1;
    }
    
    /**
     * Getter for the data array
     * @return Array
     */
    public function data() {
        return $this->_data;
    }

    public function product_id() {
        return $this->_product_id;
    }

    public function name() {
        return $this->_name;
    }

    public function model() {
        return $this->_model;
    }

    public function stock() {
        return $this->_stock;
    }

    public function sku() {
        return $this->_sku;
    }

    public function description() {
        return $this->_description;
    }

    public function minimum() {
        return $this->_minimum;
    }

    /**
     * Method to set image_size
     * @param 
     */
    public static function image_size($size) {
        self::$_image_size = $size;
    }

    /**
     * Method to compute the price considering the discount as well as set special price
     * @return Decimal $price
     */
    public function price() {
        if ($this->_price == null) {
            $discount = $this->model_catalog_product->getProductDiscount($this->_product_id);
            if ($discount) {
                $this->_price = $this->currency->format($this->tax->calculate($discount, $this->_tax_class_id, $this->config->get('config_tax')));
            } else {
                $this->_price = $this->currency->format($this->tax->calculate($this->_original_price, $this->_tax_class_id, $this->config->get('config_tax')));
                $special = $this->model_catalog_product->getProductSpecial($this->_product_id);
                if ($special) {
                    $this->_special_price = $this->currency->format($this->tax->calculate($special, $this->_tax_class_id, $this->config->get('config_tax')));
                }
            }
        }
        return $this->_price;
    }

    /**
     * Method to return special price on the product if any
     * @return Decimal $price
     */
    public function special_price() {
        if ($this->_special_price == null) {
            $this->price();
        }
        return $this->_special_price;
    }

    /**
     * Method to set and return options
     * @return Array
     */
    public function options() {
        if ($this->_options == null) {
            $options = $this->model_catalog_product->getProductOptions($this->_product_id);
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
                
                $this->_options[] = array(
                    'option_id'    => $option['product_option_id'],
                    'name'         => $option['name'],
                    'option_value' => $option_value_data
                );
            }
        }
        return $this->_options;
    }

    public function manufacturer() {
        return $this->_manufacturer;
    }

    /**
     * Method to set and return the image src
     */
    public function image() {
        if ($this->_image == null) {
        	
            $this->_imagefile = $this->_imagefile ? $this->_imagefile : 'no_image.jpg';
            $this->_image = $this->model_tool_image->resize($this->_imagefile, self::$_image_size, self::$_image_size);
            
        }
        return $this->_image;
    }

    /**
     * Method to set and return the thumbnail src
     */
    public function thumb() {
        if ($this->_image == null) {
            $this->_imagefile = $this->_imagefile ? $this->_imagefile : 'no_image.jpg';
            $this->_image = $this->model_tool_image->resize($this->_imagefile, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
        }
        return $this->_image;
    }

    /**
     * Method to calculate and return the rating on the product
     * @return int rating
     */
    public function rating() {
        if ($this->_rating == null) {
            if ($this->config->get('config_review')) {
                $this->_rating = $this->model_catalog_review->getAverageRating($this->_product_id);
            } else {
                $this->_rating = false;
            }
        }
        return $this->_rating;
    }

    public function star_rating() {
        if ($this->_start_rating == null) {
            $this->_start_rating = sprintf($this->language->get('text_stars'), $this->rating());
        }
        return $this->_start_rating;
    }

    /**
     * Method to return the url of the product details page
     */
    public function href() {
        return $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=fb/product&product_id=' . $this->_product_id);
    }

    /**
     * Method to get the add to cart href
     * @return String add to cart url
     */
    public function add_cart_href() {
        $options = $this->options();
        if ($options) {
            $add = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&amp;product_id=' . $this->_product_id);
        } else {
            $add = HTTPS_SERVER . 'index.php?route=checkout/cart&amp;product_id=' . $this->_product_id;
        }
        return $add;
    }

    /**
     * String href of this product on the fb store 
     */
    public function fb_href() {
        return HTTPS_SERVER . 'index.php?route=fb/product&product_id=' . $this->_product_id;
    }
}