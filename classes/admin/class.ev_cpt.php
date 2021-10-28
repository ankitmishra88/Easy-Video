<?php
    /**
     * Custom Post Type Video 
     */

     class EV_CPT{
         private $post_type;
         public function __construct(){
             $this->post_type='ev-videos';
             add_action('init',[$this,'register_post_type_video']);
             add_action('add_meta_boxes',[$this,'add_some_settings_related_to_yt']);
             add_action('save_post',[$this,'update_yt_settings'],10,1);
             add_filter('single_template', [$this,'ev_custom_template'],10,1);
         }

         public function ev_custom_template($template_file){
            if(get_post_type()==$this->post_type){
                return EV_PLUGIN_DIR.'/includes/templates/single-ev-video.php';
            }
            return $template_file;
         }

         public function get_post_type(){
             return $this->post_type;
         }

         function update_yt_settings($post_id){
            if(get_post_type($post_id)!=$this->post_type)
                return;
            if(isset($_POST['ev_video_id'])&&isset($_POST['ev_video_thumbnail'])){
                update_post_meta($post_id,'ev_video_id',sanitize_text_field($_POST['ev_video_id']));
                var_dump(update_post_meta($post_id,'ev_video_thumbnail',sanitize_text_field($_POST['ev_video_thumbnail'])));
                
            }
            
            
         }
         

         function register_post_type_video(){
            $labels = array(
                'name'                => _x( 'Videos', 'Post Type General Name', 'easy-video' ),
                'singular_name'       => _x( 'Video', 'Post Type Singular Name', 'easy-video' ),
                'menu_name'           => __( 'Videos', 'easy-video' ),
                'parent_item_colon'   => __( 'Parent Video', 'easy-video' ),
                'all_items'           => __( 'All Videos', 'easy-video' ),
                'view_item'           => __( 'View Video', 'easy-video' ),
                'add_new_item'        => __( 'Add New Video', 'easy-video' ),
                'add_new'             => __( 'Add New', 'easy-video' ),
                'edit_item'           => __( 'Edit Video', 'easy-video' ),
                'update_item'         => __( 'Update Video', 'easy-video' ),
                'search_items'        => __( 'Search Video', 'easy-video' ),
                'not_found'           => __( 'Not Found', 'easy-video' ),
                'not_found_in_trash'  => __( 'Not found in Trash', 'easy-video' ),
            );

            $args = array(
                'label'               => __( 'videos', 'easy-videoy' ),
                'description'         => __( 'Youtube Videos', 'easy-videoy' ),
                'labels'              => $labels,
                // Features this CPT supports in Post Editor
                'supports'            => array( 'title', 'editor' ),
                // You can associate this CPT with a taxonomy or custom taxonomy. 
                'taxonomies'          => array( 'category' ),
                /* A hierarchical CPT is like Pages and can have
                * Parent and child items. A non-hierarchical CPT
                * is like Posts.
                */ 
                'hierarchical'        => false,
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 5,
                'can_export'          => true,
                'has_archive'         => true,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'capability_type'     => 'post',
                'show_in_rest' => true,
         
            );

            register_post_type( $this->post_type, $args );
         }

         function add_some_settings_related_to_yt(){
             add_meta_box('yt-video-setting','Youtube Video Settings',[$this,'add_video_settings'],$this->post_type);
         }

         function add_video_settings($post){
             $video_thumbnail=get_post_meta($post->ID,'ev_video_thumbnail',true);
             $video_id=get_post_meta($post->ID,'ev_video_id',true);
             include_once('settings/ev-video-settings.php');
         }
     }
?>