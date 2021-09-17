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
                'name'                  => esc_html__( 'Vehicles', 'arif-cpt' ),
                'singular_name'         => esc_html__( 'Vehicle',  'arif-cpt' ),
                'menu_name'             => esc_html__( 'Vehicles',  'arif-cpt' ),
                'name_admin_bar'        => esc_html__( 'Vehicle',  'arif-cpt' ),
                'add_new'               => esc_html__( 'Add New', 'arif-cpt' ),
                'add_new_item'          => esc_html__( 'Add New vehicle', 'arif-cpt' ),
                'new_item'              => esc_html__( 'New vehicle', 'arif-cpt' ),
                'edit_item'             => esc_html__( 'Edit vehicle', 'arif-cpt' ),
                'view_item'             => esc_html__( 'View vehicle', 'arif-cpt' ),
                'all_items'             => esc_html__( 'All vehicles', 'arif-cpt' ),
                'search_items'          => esc_html__( 'Search vehicles', 'arif-cpt' ),
                'parent_item_colon'     => esc_html__( 'Parent vehicles:', 'arif-cpt' ),
                'not_found'             => esc_html__( 'No vehicles found.', 'arif-cpt' ),
                'not_found_in_trash'    => esc_html__( 'No vehicles found in Trash.', 'arif-cpt' ),
                'featured_image'        => esc_html__( 'Vehicle Cover Image', 'arif-cpt' ),
                'set_featured_image'    => esc_html__( 'Set cover image','arif-cpt' ),
                'remove_featured_image' => esc_html__( 'Remove cover image', 'arif-cpt' ),
                'use_featured_image'    => esc_html__( 'Use as cover image', 'arif-cpt' ),
                'archives'              => esc_html__( 'Vehicle archives', 'arif-cpt' ),
                'insert_into_item'      => esc_html__( 'Insert into vehicle', 'arif-cpt' ),
                'uploaded_to_this_item' => esc_html__( 'Uploaded to this vehicle', 'arif-cpt' ),
                'filter_items_list'     => esc_html__( 'Filter vehicles list', 'arif-cpt' ),
                'items_list_navigation' => esc_html__( 'Vehicles list navigation',  'arif-cpt' ),
                'items_list'            => esc_html__( 'Vehicles list','arif-cpt' ),   
        ];
        $args = [
            'labels'             => $labels,
            'description'        => 'Vehicle custom post type.',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => 'vehicle' ],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'supports'           => [ 'title' ],
            'show_in_rest'       => true
        ];
        register_post_type( 'vehicle',$args );
    }

}