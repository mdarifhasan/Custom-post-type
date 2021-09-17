<?php
/**
 * Vehicle Custom post type 
 * 
 * text-domain :arif-cpt
 * 
 * @package Arif CPT
 */
namespace Arif_CPT\Inc;

use Arif_CPT\Inc\Traits\Singleton;

class Vehicle_CPT{
    use Singleton;
    public function __construct(){
        $this->setup_hooks();
    }
    public function setup_hooks(){
        /**
         * Actions And filter
         */
        add_action('init',[$this,'register_cpt']);//Register post type
        add_action('add_meta_boxes',[$this,'cpt_meta_boxes']);//Meta box for post type
        add_action('save_post',[$this,'cpt_meta_data_save']);//Save meta box data
    }
    public function register_cpt(){
        $labels=[
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
    public function cpt_meta_boxes(){
        add_meta_box( 
            'vehicle_data', 
            esc_html__('Vehicle Data','arif-cpt'),
            [$this,'vehicle_meta_html'], 
            'vehicle', 
            'advanced',
            'high' 
        );
    }
    public function vehicle_meta_html($postID){
        $postID=get_the_ID(  );
        $vehicle_made=get_post_meta( $postID, 'vehicle_made_key',true );
        $vehicle_model=get_post_meta( $postID, 'vehicle_model_key',true );
        $vehicle_price=get_post_meta( $postID, 'vehicle_price_key',true );
        $vehicle_technician=get_post_meta( $postID, 'vehicle_technician_key',true );

        ?>
            <!-- Vehicle made -->
            <p>
                <label for="<?php echo esc_attr( 'vehicle_made' ) ?>">
                    <?php esc_html_e( 'Made','arif-cpt' ) ?>
                </label>
                <input class="widefat" type="text" name="<?php echo esc_attr('vehicle_made') ?>" id="<?php echo esc_attr('vehicle_made') ?>" value="<?php echo esc_attr( $vehicle_made ) ?>">
            </p>
            <!-- Vehicle model -->
            <p>
                <label for="<?php echo esc_attr( 'vehicle_model' ) ?>">
                    <?php esc_html_e( 'Model','arif-cpt' ) ?>
                </label>
                <input class="widefat" type="text" name="<?php echo esc_attr('vehicle_model') ?>" id="<?php echo esc_attr('vehicle_model') ?>" value="<?php echo esc_attr( $vehicle_model ) ?>">
            </p>
            <!-- Vehicle Price -->
            <p>
                <label for="<?php echo esc_attr( 'vehicle_price' ) ?>">
                    <?php esc_html_e( 'Price','arif-cpt' ) ?>
                </label>
                <input class="widefat" type="number" name="<?php echo esc_attr('vehicle_price') ?>" id="<?php echo esc_attr('vehicle_price') ?>" value="<?php echo esc_attr( $vehicle_price ) ?>">
            </p>
            <!-- Assigned technichian -->
            <p>
                <label for="<?php echo esc_attr( 'vehicle_technician' ) ?>">
                    <?php esc_html_e( 'Assigned technician','arif-cpt' ) ?>
                </label>
                <input class="widefat" type="text" name="<?php echo esc_attr('vehicle_technician') ?>" id="<?php echo esc_attr('vehicle_technician') ?>" value="<?php echo esc_attr( $vehicle_technician ) ?>">
            </p>
        <?php
    }
    public function cpt_meta_data_save(){
        $post_id=get_the_ID(  );
        $vehicle_made=isset($_POST['vehicle_made'])?$_POST['vehicle_made']:'';
        $vehicle_model=isset($_POST['vehicle_model'])?$_POST['vehicle_model']:'';
        $vehicle_price=isset($_POST['vehicle_price'])?$_POST['vehicle_price']:'';
        $vehicle_technician=isset($_POST['vehicle_technician'])?$_POST['vehicle_technician']:'';

        update_post_meta( $post_id,'vehicle_made_key',$vehicle_made );
        update_post_meta( $post_id,'vehicle_model_key',$vehicle_model );
        update_post_meta( $post_id,'vehicle_price_key',$vehicle_price );
        update_post_meta( $post_id,'vehicle_technician_key',$vehicle_technician );
    }

}