<?php
/**
 * Vehicle Custom post type 
 * 
 * @package Arif CPT
 */
namespace Arif_CPT\Inc;
use Arif_CPT\Trait\Singleton;
class Vehicle_CPT{
    use Singleton;
    public function __construct(){
        $this->setup_hooks();
    }
    public function setup_hooks(){
        /**
         * Actions And filter
         */
        add_action('init',[$this,'register_cpt']);
    }
    public function register_cpt(){
        $lables=[
            $labels = array(
                'name'                  => esc_html__( 'Recipes', 'arif-cpt' ),
                'singular_name'         => esc_html__( 'Recipe',  'arif-cpt' ),
                'menu_name'             => esc_html__( 'Recipes',  'arif-cpt' ),
                'name_admin_bar'        => esc_html__( 'Recipe',  'arif-cpt' ),
                'add_new'               => esc_html__( 'Add New', 'arif-cpt' ),
                'add_new_item'          => esc_html__( 'Add New recipe', 'arif-cpt' ),
                'new_item'              => esc_html__( 'New recipe', 'arif-cpt' ),
                'edit_item'             => esc_html__( 'Edit recipe', 'arif-cpt' ),
                'view_item'             => esc_html__( 'View recipe', 'arif-cpt' ),
                'all_items'             => esc_html__( 'All recipes', 'arif-cpt' ),
                'search_items'          => esc_html__( 'Search recipes', 'arif-cpt' ),
                'parent_item_colon'     => esc_html__( 'Parent recipes:', 'arif-cpt' ),
                'not_found'             => esc_html__( 'No recipes found.', 'arif-cpt' ),
                'not_found_in_trash'    => esc_html__( 'No recipes found in Trash.', 'arif-cpt' ),
                'featured_image'        => esc_html__( 'Recipe Cover Image', 'arif-cpt' ),
                'set_featured_image'    => esc_html__( 'Set cover image','arif-cpt' ),
                'remove_featured_image' => esc_html__( 'Remove cover image', 'arif-cpt' ),
                'use_featured_image'    => esc_html__( 'Use as cover image', 'arif-cpt' ),
                'archives'              => esc_html__( 'Recipe archives', 'arif-cpt' ),
                'insert_into_item'      => esc_html__( 'Insert into recipe', 'arif-cpt' ),
                'uploaded_to_this_item' => esc_html__( 'Uploaded to this recipe', 'arif-cpt' ),
                'filter_items_list'     => esc_html__( 'Filter recipes list', 'arif-cpt' ),
                'items_list_navigation' => esc_html__( 'Recipes list navigation',  'arif-cpt' ),
                'items_list'            => esc_html__( 'Recipes list','arif-cpt' ),
            );     
        ]
    }

}