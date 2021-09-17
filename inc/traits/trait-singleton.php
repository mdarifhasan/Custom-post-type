<?php
/**
 * Trait singleton 
 * 
 * @package Arif CPT
 */
namespace Arif_CPT\Inc\Traits;
trait Singleton{
    private function __construct(){

    }
    private function __clone(){

    }
    public static function get_instance(){
        // Instance declare to hold class
        static $instance=[]; 
        // Get the class name which is called
        $called_class=get_called_class();
        if(!isset($instance[$called_class])){
            $instance[$called_class]=new $called_class();
            do_action(sprintf('Arif_CPT_singleton_init%s',$called_class));
        }
        return $instance[$called_class];
    }

}
?>