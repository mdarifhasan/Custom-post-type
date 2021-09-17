<?php
/**
 * Plugin Name: Book CPT
 * Description: Book custom post type.
 * Version:     1.0.0
 * Author:      Arif Hasan
 * Text Domain: arif-cpt
 * Domain Path: /languages/
 *
 * @package Book CPT
 */

if(!defined('Arif_CPT_DIR_PATH')){
    define('Arif_CPT_DIR_PATH',untrailingslashit( plugin_dir_path(__FILE__) ));
}
if(!defined('Arif_CPT_DIR_PATH_URI')){
    define('Arif_CPT_DIR_PATH_URI',untrailingslashit( plugin_dir_url(__FILE__) ));
}

require_once  Arif_CPT_DIR_PATH.'/inc/helpers/autoloader.php';

function arif_cpt_get_instance(){
    Arif_CPT\Inc\Book_CPT::get_instance();
}
arif_cpt_get_instance();
