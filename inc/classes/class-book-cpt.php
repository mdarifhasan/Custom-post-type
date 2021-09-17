<?php
/**
 * Book custom post type
 * 
 * @package Arif CPT
 */

namespace Arif_CPT\Inc;

use Arif_CPT\Inc\Traits\Singleton;

class Book_CPT{
    use Singleton;
    public function __construct(){
        // Load Actions and filter hook function
        $this->setup_hooks();

    }
    public function setup_hooks(){
        /**
         * Actions And Filter
         */
        add_action('init',[$this,'register_cpt']); //Register post type
        add_action('add_meta_boxes',[$this,'cpt_meta_boxes']); //Post type meta box 
        add_action('save_post',[$this,'cpt_metadata_save']); // Post type meta box data save
        add_action('manage_recipe_posts_columns',[$this,'cpt_custom_columns']);//Custom columns for cpt
        add_action('manage_recipe_posts_custom_column',[$this,'cpt_custom_column_render_data'],10,2); //Custom columns data render
        add_filter('manage_edit-recipe_sortable_columns',[$this,'cpt_columns_sorting']); //Custom columns sorting
        add_action('restrict_manage_posts',[$this,'filter_box_layout']);//Filter box layout for author
        add_filter('parse_query',[$this,'filter_box_query']);//Query for the author filter box
        add_action('init',[$this,'cpt_taxonomy_register']);//CPT taxonomy register
        add_action('restrict_manage_posts',[$this,'cat_filter_box_layout']);// Category Filter box layout 
        add_filter('parse_query',[$this,'cat_filter_box_query']); //Category filter box category

    }
    public function register_cpt(){
        $labels = [
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
        ];     
        $args = [
            'labels'             => $labels,
            'description'        => 'Recipe custom post type.',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => 'recipe' ],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'supports'           => [ 'title', 'editor', 'author', 'thumbnail','excerpt','comments' ],
            'show_in_rest'       => true
        ];
        register_post_type('recipe',$args);
    }
    public function cpt_meta_boxes(){
        // Meta box for recipe time
        add_meta_box( 
            'recipe_time',
            esc_html__('Recipe Time','arif-cpt'),
           [$this,'recipe_time_meta_html'],
            'recipe',
            'side',
            'high' 
        );
        // Meta box for author
        add_meta_box(
            'recipe_author',
            esc_html__( 'Recipe Author', 'arif-cpt' ),
            [$this,'recipe_author_meta_html'],
            'recipe',
            'side',
            'high'
        );
    }
    /**
     * Custom post type meta html
     */
    //Recipe time 
    public function recipe_time_meta_html(){
        $recipe_total_time=get_post_meta( get_the_ID(  ), 'recipe_total_time_key', true );
        $recipe_prep_time=get_post_meta( get_the_ID(  ), 'recipe_prep_time_key', true );
        $recipe_cook_time=get_post_meta( get_the_ID(  ), 'recipe_cook_time_key', true );
        ?>
            <!-- Recipe Total time -->
            <p>
                <label for="<?php esc_html_e( 'recipe_total_time','arif-cpt' ) ?>">
                    <?php esc_html_e( 'Recipe total time','arif-cpt' ) ?>
                </label>
                <input class="widefat" type="time" name="<?php esc_attr_e('recipe_total_time','arif-cpt') ?>" id="<?php esc_attr_e('recipe_total_time','arif-cpt') ?>" value="<?php esc_attr_e( $recipe_total_time, 'arif-cpt' ) ?>">
            </p>
            <!-- Recipe Preparation time -->
            <p>
                <label for="<?php esc_html_e( 'recipe_prep_time','arif-cpt' ) ?>">
                    <?php esc_html_e( 'Recipe Preparation time','arif-cpt' ) ?>
                </label>
                <input class="widefat" type="text" name="<?php esc_attr_e('recipe_prep_time','arif-cpt') ?>" id="<?php esc_attr_e('recipe_prep_time','arif-cpt') ?>" value="<?php esc_attr_e( $recipe_prep_time ,'arif-cpt'); ?> ">
            </p>
            <!-- Recipe Cook time -->
            <p>
                <label for="<?php esc_html_e( 'recipe_cook_time','arif-cpt' ) ?>">
                    <?php esc_html_e( 'Recipe cook time','arif-cpt' ) ?>
                </label>
                <input class="widefat" type="text" name="<?php esc_attr_e('recipe_cook_time','arif-cpt') ?>" id="<?php esc_attr_e('recipe_cook_time','arif-cpt') ?>" value="<?php esc_attr_e( $recipe_cook_time,'arif-cpt' ) ?>">
            </p>
        <?php
    }
    // Recipe author
    public function recipe_author_meta_html($postID){
        $postID=get_the_ID(  );
        $selected_author_value=get_post_meta($postID,'dd_recipe_author_key',true);
        $users=get_users(['role'=>'author']);
        $selected='';
        ?>
            <p>
                <label for="<?php esc_attr_e('dd_recipe_author','arif-cpt') ?>">
                    <?php esc_html_e( 'Recipe Author','arif-cpt' ) ;?>
                </label>
                <?php
                    if(!empty($users)){
                        ?>
                            <select name="<?php esc_attr_e('dd_recipe_author','arif-cpt') ?>" id="<?php esc_attr_e('dd_recipe_author','arif-cpt') ?>">
                                <?php
                                    foreach($users as $index=>$user){
                                        if($selected_author_value == $user->ID){
                                            $selected='selected="selected"';
                                        }
                                        ?>
                                            <option value="<?php echo esc_attr( $user->ID ) ?>" <?php echo esc_attr($selected); ?>>
                                                <?php esc_html_e( $user->display_name, 'arif-cpt' ) ?>
                                            </option>
                                        <?php
                                    }
                                ?>
                            </select>
                        <?php
                    }
                ?>
            </p>
        <?php
    }
    /**
     * Custom Post type meta data save 
     */
    public function cpt_metadata_save(){
        $post_id=get_the_ID(  );
        //Recipe Time
        $recipe_prep_time=isset($_POST['recipe_prep_time'])?$_POST['recipe_prep_time']:'';
        $recipe_total_time=isset($_POST['recipe_total_time'])?$_POST['recipe_total_time']:'';
        $recipe_cook_time=isset($_POST['recipe_cook_time'])?$_POST['recipe_cook_time']:'';
        update_post_meta( $post_id, 'recipe_total_time_key',$recipe_total_time );
        update_post_meta( $post_id, 'recipe_prep_time_key',$recipe_prep_time );
        update_post_meta( $post_id, 'recipe_cook_time_key',$recipe_cook_time );

        // Recipe author
        $recipe_author=isset($_REQUEST['dd_recipe_author'])?$_REQUEST['dd_recipe_author']:'';
        update_post_meta($post_id,'recipe_author_id_key',$recipe_author);
        
  
    }
    /**
     * Custom columns
     */
    public function cpt_custom_columns($columns){
        $columns=[
            'cb'                    =>'<input type="checkbox" />',
            'title'                 =>'Recipe Title',
            'recipe_total_time'     =>'Total time',
            'recipe_prep_time'      =>'Preparation time',
            'recipe_cook_time'      =>'Cook time',
            'date'                  =>'Date'
        ];
        return $columns;
    }
    /**
     * Custom column data retrieve to show in the column
     */
    public function cpt_custom_column_render_data($column){
        switch($column){
            case 'recipe_total_time':
                $recipe_total_time=get_post_meta(get_the_ID(  ),'recipe_total_time_key',true);
                echo $recipe_total_time;
                break;
            case 'recipe_prep_time':
                $recipe_prep_time=get_post_meta(get_the_ID(  ),'recipe_prep_time_key',true);
                echo $recipe_prep_time;
                break;
            case 'recipe_cook_time':
                $recipe_cook_time=get_post_meta(get_the_ID(  ),'recipe_cook_time_key',true);
                echo $recipe_cook_time;
                break;
        }
    }
    /**
     * Column sorting ASC or DESC
     */
    public function cpt_columns_sorting($columns){
        $columns['recipe_total_time']='recipe_total_time';
        $columns['recipe_prep_time']='recipe_prep_time';
        $columns['recipe_cook_time']='recipe_cook_time';
        return $columns;
    }
    /**
     * Filter box layout for author
     */
    public function filter_box_layout(){
        global $typenow;
     
        // Layout for author box
        if($typenow=='recipe'){
            $selected_author_id=isset($_GET['filter_by_author'])?intval($_GET['filter_by_author']):'';
            wp_dropdown_users( [
                'show_option_none'=>'Select writer',
                'role'            =>'author',
                'id'              =>'dd-filter-author-id',
                'name'            =>'filter_by_author',
                'selected'        =>$selected_author_id
 
            ] );
        }
       
    }
    public function filter_box_query($query){
        global $typenow;
        global $pagenow;
        $selected_author_id=isset($_GET['filter_by_author'])?intval($_GET['filter_by_author']):'';
        if($typenow=='recipe' && $pagenow='edit.php' && !empty($selected_author_id)){
            $query->query_vars['meta_key'] ='recipe_author_id_key';
            $query->query_vars['meta_value']=$selected_author_id;
        }
    }
    public function cpt_taxonomy_register(){
        $args=[
            'label'             =>esc_html__( 'Recipe Category','arif-cpt' ),
            'rewrite'           => ['slug' => 'recipe_categories' ],
            'hierarchical'      => true,
            'query_var'         =>true,
            'show_in_rest'      =>true
        ];
        register_taxonomy(
            'recipe_category',
            'recipe',
            $args
        );
        
     
       
    }
   
    public function cat_filter_box_layout() {
        global $typenow;
        global $wp_query;
        $post_type = 'recipe'; 
        $taxonomy  = 'recipe_category'; 

        if ($typenow == $post_type) {
            $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            wp_dropdown_categories(array(
                'show_option_all' => 'Show all ',
                'taxonomy'        =>$taxonomy,
                'name'            => $taxonomy,
                'orderby'         => 'name',
                'selected'        => $selected,
                'show_count'      => true,
                'hide_empty'      => true,
                
            ));
        };
    }
    public function cat_filter_box_query($query){
        global $typenow;
        global $pagenow;
        $query_variable= &$query->query_vars;

        $post_type='recipe';
        $taxonomy='recipe_category';
        if($typenow == $post_type && $pagenow == 'edit.php' && isset($query_variable[$taxonomy]) && is_numeric($query_variable[$taxonomy]) && $query_variable[$taxonomy]!=0){
            $term_details=get_term_by( 'id',$query_variable[$taxonomy] ,$taxonomy);
            $query_variable[$taxonomy]=$term_details->slug;

        }
    }
    
    
}
?>