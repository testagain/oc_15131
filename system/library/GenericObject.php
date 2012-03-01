<?php

/**
 * Abstract class in which all objects in the registry are available 
 * as instance variables using the magic get and set methods
 */
abstract class GenericObject {

    protected $registry;

    public function __construct($registry) {
        $this->registry = $registry;
    }

    public function __get($key) {
        return $this->registry->get($key);
    }
    
    public function __set($key, $value) {
        $this->registry->set($key, $value);
    }
}