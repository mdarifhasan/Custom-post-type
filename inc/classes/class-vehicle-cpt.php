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
        add_action('manage_vehicle_posts_columns',[$this,'cpt_custom_columns']);//Custom columns for cpt
        add_action('manage_vehicle_posts_custom_column',[$this,'cpt_custom_column_data_render']);//Custom column data render
        add_filter('manage_edit-vehicle_sortable_columns',[$this,'cpt_columns_sorting']);//Custom column sorting
        add_action('init',[$this,'cpt_taxonomy']);//Registering category
        add_action('restrict_manage_posts',[$this,'category_filter_box_layout']);//Taxonomy filter box layout
        add_action('parse_query',[$this,'category_filter_data_query']);
    }
    /**
     * Register our custom post type
     */
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
    /**
     * Meta boxes for custom post type
     */
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
    /**
     * Meta box html structure and data show in the form
     */
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
    /**
     * Meta box data save
     */
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
    /**
     * Custom column for CPT.
     */
    public function cpt_custom_columns($columns){
        $columns=[
            'cb'                    =>'<input type="checkbox"/>',
            'title'                 =>'Vehicle Title',
            'vehicle_price'         =>'Vehicle Price',
            'vehicle_technician'    =>'Assigned Technican',
            'date'                  =>'Date'
        ];
        return $columns;

    }
    /**
     * Custom column data render to show in the table
     */
    public function cpt_custom_column_data_render($column){
        switch($column){

            case 'vehicle_price':
                $vehicle_price=get_post_meta(get_the_ID(  ),'vehicle_price_key',true);
                echo $vehicle_price;
                break;
            case 'vehicle_technician':
                $vehicle_technician=get_post_meta(get_the_ID(  ),'vehicle_technician_key',true);
                echo $vehicle_technician;
                break;
        }
    }
    /**
     * Custom column sorting by ASC OR DESC
     */
    public function cpt_columns_sorting($columns){
        $columns['vehicle_price'] = 'vehicle_price';
        $columns['vehicle_technician'] = 'vehicle_technician';
        return $columns;
    }
    /**
     * Custom taxonomy register for our CPT
     */
    public function cpt_taxonomy(){
        $args=[
            'label'             =>esc_html__( 'Vehicle Category','arif-cpt' ),
            'rewrite'           => ['slug' => 'vehicle_categories' ],
            'hierarchical'      => true,
            'query_var'         =>true,
            'show_in_rest'      =>true
        ];
        register_taxonomy( 'vahicle_category','vehicle', $args );
    }
    public function category_filter_box_layout(){
        global $typenow;
        $post_type='vehicle';
        $taxonomy = 'vahicle_category';
        
        //Check if the type is vehicle or not
        if($typenow == $post_type){
            $selected= isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            wp_dropdown_categories( [
                'show_option_all'       => 'Show all',
                'name'                  =>$taxonomy,
                'taxonomy'              =>$taxonomy,
                'show_count'            =>true,
                'orderby'               =>'name',
                'selected'              =>$selected
            ] );
        }

    }
    public function category_filter_data_query($query){
        global $typenow;
        global $pagenow;
        $query_variable=&$query->query_vars;
        $post_type='vehicle';
        $taxonomy='vahicle_category';
        if($typenow == $post_type && $pagenow == 'edit.php' && isset($query_variable[$taxonomy]) && is_numeric($query_variable[$taxonomy]) && $query_variable[$taxonomy]!=0){
            
            $term_details=get_term_by('id', $query_variable[$taxonomy],$taxonomy ) ;
            $query_variable[$taxonomy]=$term_details->slug;
            
        }
    }
           

}