<?php
/**
 * Load all classes
 * 
 * @package Arif CPT
 */

namespace Arif_CPT\Inc;

use Arif_CPT\Inc\Traits\Singleton;

class CPT{
    use Singleton;
    public function __construct(){
        // Load Actions and filter hook function
        $this->setup_hooks();

    }
    public function setup_hooks(){
        Book_CPT::get_instance();
        Vehicle_CPT::get_instance();
    }
}