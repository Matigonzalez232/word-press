<?php
/**
 * Add News post type and taxonomies
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;




/**
 * Register News post type and taxonomies
 */
class Auxin_Post_Type_News extends Auxin_Post_Type_Base {



    function __construct() {

        $post_type = 'news';

        parent::__construct( $post_type );
    }


    /**
     * Register post type
     *
     * @return void
     */
    public function register_post_type() {

        if( ! $single_slug  = get_theme_mod( $this->prefix.'permalink_'.$this->post_type.'_structure', '' ) )
            $single_slug    = $this->post_type; // validate single slug

        if( ! $archive_slug = get_theme_mod( $this->prefix.'permalink_'.$this->post_type.'_archive_structure', '' ) )
            $archive_slug   = $this->post_type.'/all'; // validate archive slug


        $labels = array(
            'name'               => _x( 'News'           , 'auxin-news' ),
            'singular_name'      => __( 'News'           , 'auxin-news' ),
            'menu_name'          => _x( 'News'           , 'Admin menu name', 'auxin-news' ),
            'add_new'            => __( 'Add News'       , 'auxin-news' ),
            'all_items'          => __( 'All News'       , 'auxin-news' ),
            'add_new_item'       => __( 'Add New News'   , 'auxin-news' ),
            'edit_item'          => __( 'Edit News'      , 'auxin-news' ),
            'new_item'           => __( 'New News'       , 'auxin-news' ),
            'view_item'          => __( 'View News'      , 'auxin-news' ),
            'search_items'       => __( 'Search News'    , 'auxin-news' ),
            'parent'             => __( 'Parent News'    , 'auxin-news' ),
            'not_found'          => __( 'No News found'  , 'auxin-news' ),
            'not_found_in_trash' => __( 'No News found in Trash', 'auxin-news' )
        );

        $args = array(
            'labels'                => $labels,
            'description'           => __( 'Here you can add news to your website.', 'auxin-news' ),
            'public'                => true,
            'publicly_queryable'    => true,
            'exclude_from_search'   => false,
            'show_ui'               => true,
            'query_var'             => true,
            'rewrite'               => array (
                'slug'       => $single_slug,
                'with_front' => true,
                'feeds'      => true
            ),
            'capability_type'       => $this->post_type,
            'map_meta_cap'          => true,
            'hierarchical'          => false,
            'menu_position'         => 32,
            'show_in_nav_menus'     => true,
            'menu_icon'             => 'dashicons-calendar',
            'supports'              => array( 'title','editor', 'author', 'thumbnail','excerpt','page-attributes', 'revisions', 'comments', 'elementor' ),
            'has_archive'           => $archive_slug
        );

        return register_post_type( $this->post_type, apply_filters( "auxin_register_post_type_args_{$this->post_type}", $args ) );
    }

    /**
     * Register taxonomies
     *
     * @return void
     */
    public function register_taxonomies() {


        // labels for Category of this post type
        $cat_labels = array(
            'name'              => __( 'News Categories'      , 'auxin-news' ),
            'singular_name'     => __( 'News Category'        , 'auxin-news' ),
            'all_items'         => __( 'All News Categories'  , 'auxin-news' ),
            'parent_item'       => __( 'Parent News Category' , 'auxin-news' ),
            'parent_item_colon' => __( 'Parent News Category:', 'auxin-news' ),
            'edit_item'         => __( 'Edit News Category'   , 'auxin-news' ),
            'update_item'       => __( 'Update News Category' , 'auxin-news' ),
            'add_new_item'      => __( 'Add New News Category', 'auxin-news' ),
            'new_item_name'     => __( 'New News Category'    , 'auxin-news' ),
            'search_items'      => __( 'Search in News Categories', 'auxin-news' ),
            'menu_name'         => _x( 'Categories', 'news-category admin menu name', 'auxin-news' )
        );

        $tax_cat_name = 'news-category';

        register_taxonomy( $tax_cat_name,
            apply_filters( "auxin_taxonomy_post_types_for_{$tax_cat_name}" , array( $this->post_type ) ),
            apply_filters( "auxin_taxonomy_args_{$tax_cat_name}"       , array(
                'hierarchical'          => true,
                'label'                 => __( 'News Categories', 'auxin-news' ),
                'labels'                => $cat_labels,
                'show_ui'               => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var'             => true,
                'capabilities'          => array(
                    'manage_terms'      => "manage_{$this->post_type}_terms",
                    'edit_terms'        => "edit_{$this->post_type}_terms",
                    'delete_terms'      => "delete_{$this->post_type}_terms",
                    'assign_terms'      => "assign_{$this->post_type}_terms",
                ),
                'rewrite'       => array(
                    'slug'          => get_theme_mod( $this->prefix.'permalink_'. $this->post_type. '_' .str_replace('-', '_', $tax_cat_name ) .'_structure', 'news-cats' ),
                    'hierarchical'  => false
                )
            ) )
        );





        // labels for Tag/Filter of this post type
        $tag_labels = array(
            'name'              => __( 'News Tags'            , 'auxin-news' ),
            'singular_name'     => __( 'News Tag'             , 'auxin-news' ),
            'search_items'      => __( 'Search in News Tags'  , 'auxin-news' ),
            'popular_items'     => __( 'Popular Tags'         , 'auxin-news' ),
            'all_items'         => __( 'All News Tags'        , 'auxin-news' ),
            'parent_item'       => __( 'Parent News Tag'      , 'auxin-news' ),
            'parent_item_colon' => __( 'Parent News Tag:'     , 'auxin-news' ),
            'edit_item'         => __( 'Edit News Tag'        , 'auxin-news' ),
            'update_item'       => __( 'Update News Tag'      , 'auxin-news' ),
            'add_new_item'      => __( 'Add new News Tag'     , 'auxin-news' ),
            'new_item_name'     => __( 'New News Tag'         , 'auxin-news' ),

            'separate_items_with_commas'    => __( 'Separate "Tag" with commas'       , 'auxin-news' ),
            'add_or_remove_items'           => __( 'Add or remove Tag'                , 'auxin-news' ),
            'choose_from_most_used'         => __( 'Choose from the most used tags'     , 'auxin-news' ),
            'menu_name'                     => _x( 'Tags', 'News-tag admin menu name'   , 'auxin-news' )
        );

        $tax_tag_name = 'news-tag';

        register_taxonomy( $tax_tag_name,
            apply_filters( "auxin_taxonomy_post_types_for_{$tax_tag_name}" , array( $this->post_type ) ),
            apply_filters( "auxin_taxonomy_args_{$tax_tag_name}", array(
                'hierarchical'          => false,
                'label'                 => __( 'News Tags', 'auxin-news' ),
                'labels'                => $tag_labels,
                'show_ui'               => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var'             => true,
                'capabilities'          => array(
                    'manage_terms'      => "manage_{$this->post_type}_terms",
                    'edit_terms'        => "edit_{$this->post_type}_terms",
                    'delete_terms'      => "delete_{$this->post_type}_terms",
                    'assign_terms'      => "assign_{$this->post_type}_terms",
                ),
                'rewrite'       => array(
                    'slug'          => get_theme_mod( $this->prefix.'permalink_'. $this->post_type. '_' .str_replace('-', '_', $tax_tag_name ) .'_structure', 'news-tags' ),
                    'hierarchical'  => false
                )
            ) )
        );

    }


    /**
     * Adds Post Type icons in admin
     *
     * @return void
     */
    public function admin_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-news div.wp-menu-image:before {
            content: '\f145' !important;
        }
    </style>
    <?php
    }


    /**
     * Customizing post type list Columns
     *
     * @param  array $column  An array of column name => label
     * @return array          List of columns shown when listing posts of the post type
     */
    public function manage_edit_columns( $columns ){

        $columns = array(
            "cb"       => "<input type=\"checkbox\" />",
            "title"    => _x('News Title'  , 'Title column at News  edit columns'    , 'auxin-news' ),
            "category" => _x("Categories"  , 'Category column at News edit columns' , 'auxin-news' ),
            "tag"      => __('Tags'    , 'auxin-news' ),
            "date"     => __('Date'    , 'auxin-news' ),
            "author"   => __('Author'    , 'auxin-news' ),
            "comments" => '<div class="vers"><img alt="'.__( 'Comments', 'auxin-news' ).'" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>'
        );

        return $columns;
    }


    /**
     * Applied to the list of columns to print on the manage posts screen for current post type
     *
     * @param  array $column  An array of column name => label
     * @return array          List of columns shown when listing posts of the post type
     */
    public function manage_posttype_custom_columns( $column ){
        global $post;

        switch ($column) {
            case "description":
                the_excerpt();
                break;
            case "category":
                echo get_the_term_list( $post->ID, 'news-category', '', ', ', '');
                break;
            case "tag":
                echo get_the_term_list( $post->ID, 'news-tag' , '', ', ', '' );
                break;
            case "author":
                echo get_the_author_meta( 'display_name' , $post->post_author );
                break;
        }
    }


}
