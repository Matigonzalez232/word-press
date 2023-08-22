<?php
/**
 * Advanced Recent Products Element
 *
 * 
 * @package    
 * @license    LICENSE.txt
 * @author     averta <info@averta.net>
 * @link       https://bitbucket.org/averta/
 * @copyright  (c) 2010-2023 averta <info@averta.net>
 */
function auxin_get_the_advance_recent_products_master_array( $master_array ) {

    $master_array['aux_advance_recent_product'] = array(
        'name'                    => __("Advance Products", 'auxin-shop'  ),
        'auxin_output_callback'   => 'auxin_widget_the_advance_recent_products_callback',
        'base'                    => 'aux_advance_recent_product',
        'description'             => __("a Advance Widget for Display Your Store's Products", 'auxin-shop' ),
        'class'                   => 'aux-widget-recent-products-pro',
        'show_settings_on_create' => true,
        'weight'                  => 1,
        'category'                => THEME_NAME,
        'is_widget'               => true,
        'is_shortcode'            => true,
        'group'                   => '',
        'admin_enqueue_js'        => '',
        'admin_enqueue_css'       => '',
        'front_enqueue_js'        => '',
        'front_enqueue_css'       => '',
        'icon'                    => 'aux-element aux-pb-icons-grid',
        'custom_markup'           => '',
        'js_view'                 => '',
        'html_template'           => '',
        'deprecated'              => '',
        'content_element'         => '',
        'as_parent'               => '',
        'as_child'                => '',
        'params'                  => array(
            array(
                'heading'           => __('Products Type', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'product_type',
                'type'              => 'dropdown',
                'def_value'         => '',
                'holder'            => '',
                'value'             =>array (
                    'recent'            => __('Recent Products' , 'auxin-shop'),
                    'featured'          => __('Featured Products' , 'auxin-shop'),
                    'top_rated'         => __('Top Rated Products', 'auxin-shop'),
                    'best_selling'      => __('Best Selling Products'     , 'auxin-shop'),
                    'sale'              => __('On Sale Products'   , 'auxin-shop'),
                    'deal'              => __('Deal Products'   , 'auxin-shop'),
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'          => __('Title','auxin-shop' ),
                'description'      => __('Advance products title, leave it empty if you don`t need title.', 'auxin-shop'),
                'param_name'       => 'title',
                'type'             => 'textfield',
                'value'            => '',
                'holder'           => 'textfield',
                'class'            => 'title',
                'admin_label'      => false,
                'dependency'       => '',
                'weight'           => '',
                'group'            => '',
                'edit_field_class' => ''
            ),
            array(
                'heading'          => __('Subtitle','auxin-shop' ),
                'description'      => __('Recent products subtitle, leave it empty if you don`t need title.', 'auxin-shop'),
                'param_name'       => 'subtitle',
                'type'             => 'textfield',
                'value'            => '',
                'holder'           => 'textfield',
                'class'            => 'title',
                'admin_label'      => false,
                'dependency'       => '',
                'weight'           => '',
                'group'            => '',
                'edit_field_class' => ''
            ),
            array(
                'heading'           => __('Categories', 'auxin-shop'),
                'description'       => __('Specifies a category that you want to show posts from it.', 'auxin-shop' ),
                'param_name'        => 'cat',
                'type'              => 'aux_taxonomy',
                'taxonomy'          => 'product_cat',
                'def_value'         => '',
                'holder'            => '',
                'class'             => 'cat',
                'value'             => ' ', // should use the taxonomy name
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Number of posts to show', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'num',
                'type'              => 'textfield',
                'value'             => '8',
                'holder'            => '',
                'class'             => 'num',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => __( 'Query', 'auxin-shop' ),
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Image aspect ratio', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'image_aspect_ratio',
                'type'              => 'dropdown',
                'def_value'         => '0.75',
                'holder'            => '',
                'class'             => 'order',
                'value'             =>array (
                    '0.75'          => __('Horizontal 4:3' , 'auxin-shop'),
                    '0.56'          => __('Horizontal 16:9', 'auxin-shop'),
                    '1.00'          => __('Square 1:1'     , 'auxin-shop'),
                    '1.15'          => __('Vertical 1.15:1'     , 'auxin-shop'),
                    '1.33'          => __('Vertical 3:4'   , 'auxin-shop'),
                    '1.5'           => __('Vertical 2:3'   , 'auxin-shop'),

                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Exclude posts without media','auxin-shop' ),
                'description'       => '',
                'param_name'        => 'exclude_without_media',
                'type'              => 'aux_switch',
                'value'             => '0',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Order by', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'order_by',
                'type'              => 'dropdown',
                'def_value'         => 'date',
                'holder'            => '',
                'class'             => 'order_by',
                'value'             => array (
                    'date'            => __('Date', 'auxin-shop'),
                    'menu_order date' => __('Menu Order', 'auxin-shop'),
                    'title'           => __('Title', 'auxin-shop'),
                    'ID'              => __('ID', 'auxin-shop'),
                    'rand'            => __('Random', 'auxin-shop'),
                    'comment_count'   => __('Comments', 'auxin-shop'),
                    'modified'        => __('Date Modified', 'auxin-shop'),
                    'author'          => __('Author', 'auxin-shop'),
                    'post__in'        => __('Inserted Post IDs', 'auxin-shop')
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Order', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'order',
                'type'              => 'dropdown',
                'def_value'         => 'DESC',
                'holder'            => '',
                'class'             => 'order',
                'value'             =>array (
                    'DESC'          => __('Descending', 'auxin-shop'),
                    'ASC'           => __('Ascending', 'auxin-shop'),
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Only products','auxin-shop' ),
                'description'       => __('If you intend to display ONLY specific products, you should specify the products here. You have to insert the Products IDs that are separated by comma (eg. 53,34,87,25).', 'auxin-shop' ),
                'param_name'        => 'only_products__in',
                'type'              => 'textfield',
                'value'             => '',
                'holder'            => '',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Include products','auxin-shop' ),
                'description'       => __('If you intend to include additional products, you should specify the products here. You have to insert the Products IDs that are separated by comma (eg. 53,34,87,25)', 'auxin-shop' ),
                'param_name'        => 'include',
                'type'              => 'textfield',
                'value'             => '',
                'holder'            => '',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Exclude products','auxin-shop' ),
                'description'       => __('If you intend to exclude specific products from result, you should specify the products here. You have to insert the Products IDs that are separated by comma (eg. 53,34,87,25)', 'auxin-shop' ),
                'param_name'        => 'exclude',
                'type'              => 'textfield',
                'value'             => '',
                'holder'            => '',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Start offset','auxin-shop' ),
                'description'       => __('Number of products to displace or pass over.', 'auxin-shop' ),
                'param_name'        => 'offset',
                'type'              => 'textfield',
                'value'             => '',
                'holder'            => '',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Show filters', 'auxin-shop' ),
                'description'       => '',
                'param_name'        => 'show_filters',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'weight'            => '',
                'group'             => 'Filter',
                'edit_field_class'  => ''
            ),

            array(
                'heading'           => __( 'Show Sortlist', 'auxin-shop' ),
                'description'       => '',
                'param_name'        => 'show_sort',
                'type'              => 'aux_switch',
                'value'             => '0',
                'class'             => '',
                'admin_label'       => false,
                'weight'            => '',
                'group'             => 'Filter',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Filter by', 'auxin-shop' ),
                'description'       => __( 'Filter by categories or tags', 'auxin-shop' ),
                'param_name'        => 'filter_by',
                'type'              => 'dropdown',
                'def_value'         => 'portfolio-filter',
                'holder'            => 'dropdown',
                'value'             =>array (
                    'product_cat'     => __( 'Category', 'auxin-shop' ),
                    'product_tag'     => __( 'Tag', 'auxin-shop' )
                ),
                'dependency'        => array(
                    'element'       => 'show_filters',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => 'Filter',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Filter Control Alignment', 'auxin-shop' ),
                'param_name'        => 'filter_align',
                'type'              => 'aux_visual_select',
                'def_value'         => 'aux-center',
                'holder'            => '',
                'choices'           => array(
                    'aux-left'      => array(
                        'label'     => __('Left' , 'auxin-shop'),
                        'image'     => AUXIN_URL . 'images/visual-select/filter-left.svg'
                    ),
                    'aux-center'    => array(
                        'label'     => __('Center' , 'auxin-shop'),
                        'image'     => AUXIN_URL . 'images/visual-select/filter-mid.svg'
                    ),
                    'aux-right'     => array(
                        'label'     => __('Right' , 'auxin-shop'),
                        'image'     => AUXIN_URL . 'images/visual-select/filter-right.svg'
                    )
                ),
                'dependency'        => array(
                    'element'       => 'show_filters',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => 'Filter',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Filter button style', 'auxin-shop' ),
                'description'       => __( 'Style of filter buttons.', 'auxin-shop' ),
                'param_name'        => 'filter_style',
                'type'              => 'aux_visual_select',
                'def_value'         => 'aux-slideup',
                'holder'            => '',
                'dependency'        => array(
                    'element'       => 'show_filters',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => 'Filter',
                'edit_field_class'  => '',
                'choices'           => array(
                    'aux-slideup'      => array(
                        'label'     => __( 'Slide up' , 'auxin-shop' ),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterSlideUp2.webm webm'
                    ),
                    'aux-fill'    => array(
                        'label'     => __( 'Fill' , 'auxin-shop' ),
                        'video_src' => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterFill.webm webm'
                    ),
                    'aux-cube'     => array(
                        'label'     => __( 'Cube' , 'auxin-shop' ),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterCube.webm webm'
                    ),
                    'aux-underline'     => array(
                        'label'     => __( 'Underline' , 'auxin-shop' ),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterUnderline.mp4 mp4'
                    ),
                    'aux-overlay'    => array(
                        'label'     => __( 'Float frame' , 'auxin-shop' ),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterFloatFrame.webm webm'
                    ),
                    'aux-bordered'     => array(
                        'label'     => __( 'Borderd' , 'auxin-shop' ),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterBordered.mp4 mp4'
                    ),
                    'aux-overlay aux-underline-anim'     => array(
                        'label'     => __( 'Float underline' , 'auxin-shop' ),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterUnderline.webm webm'
                    ),
                    'aux-dropdown-filter'     => array(
                        'label'     => __( 'DropDown' , 'auxin-shop' ),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterUnderline.webm webm'
                    ),
                ),
            ),
            array(
                'heading'           => __('Display products price', 'auxin-shop' ),
                'param_name'        => 'display_price',
                'type'              => 'aux_switch',
                'def_value'         => '',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_price',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Display products rating', 'auxin-shop' ),
                'param_name'        => 'display_rating',
                'type'              => 'aux_switch',
                'def_value'         => '',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_rating',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Display add to cart ', 'auxin-shop' ),
                'param_name'        => 'display_add_to_cart',
                'type'              => 'aux_switch',
                'def_value'         => '',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_add_to_cart',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Display wishlist ', 'auxin-shop' ),
                'param_name'        => 'display_wishlist',
                'type'              => 'aux_switch',
                'def_value'         => '',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_wishlist',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Display sale badge', 'auxin-shop' ),
                'param_name'        => 'display_sale_badge',
                'type'              => 'aux_switch',
                'def_value'         => '',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_sale_badge',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Display product title','auxin-shop' ),
                'description'       => '',
                'param_name'        => 'display_title',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => 'display_title',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Display Categories','auxin-shop' ),
                'description'       => '',
                'param_name'        => 'display_categories',
                'type'              => 'aux_switch',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_categories',
                'admin_label'       => false,
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Display Quicklook','auxin-shop' ),
                'description'       => '',
                'param_name'        => 'display_quicklook',
                'type'              => 'aux_switch',
                'value'             => '0',
                'holder'            => '',
                'class'             => 'display_quicklook',
                'admin_label'       => false,
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Number of columns', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'desktop_cnum',
                'type'              => 'dropdown',
                'def_value'         => '4',
                'holder'            => '',
                'class'             => 'num',
                'value'             => array(
                    '1'  => '1', '2' => '2', '3' => '3',
                    '4'  => '4', '5' => '5', '6' => '6'
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Layout',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Number of columns in tablet size', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'tablet_cnum',
                'type'              => 'dropdown',
                'def_value'         => 'inherit',
                'holder'            => '',
                'class'             => 'num',
                'value'             => array(
                    'inherit' => 'Inherited from larger',
                    '1'  => '1', '2' => '2', '3' => '3',
                    '4'  => '4', '5' => '5', '6' => '6'
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Layout',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Number of columns in phone size', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'phone_cnum',
                'type'              => 'dropdown',
                'def_value'         => '1',
                'holder'            => '',
                'class'             => 'num',
                'value'             => array(
                    '1' => '1', '2' => '2', '3' => '3'
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Layout',
                'edit_field_class'  => ''
            ),
            // array(
            //     'heading'           => __('Content layout', 'auxin-shop'),
            //     'description'       => __('Specifies the style of content for each post column.', 'auxin-shop' ),
            //     'param_name'        => 'content_layout',
            //     'type'              => 'dropdown',
            //     'def_value'         => 'default',
            //     'holder'            => '',
            //     'class'             => 'content_layout',
            //     'value'             =>array (
            //         'default'       => __('Full Content', 'auxin-shop'),
            //         'entry-boxed'   => __('Boxed Content', 'auxin-shop')
            //     ),
            //     'admin_label'       => false,
            //     'dependency'        => '',
            //     'weight'            => '',
            //     'group'             => '',
            //     'edit_field_class'  => ''
            // ),
            array(
                'heading'           => __('Extra class name','auxin-shop' ),
                'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'auxin-shop' ),
                'param_name'        => 'extra_classes',
                'type'              => 'textfield',
                'value'             => '',
                'def_value'         => '',
                'holder'            => '',
                'class'             => 'extra_classes',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            )
        )
    );

    return $master_array;
}

add_filter( 'auxin_master_array_shortcodes', 'auxin_get_the_advance_recent_products_master_array', 10, 1 );

function auxin_widget_the_advance_recent_products_callback( $atts, $shortcode_content = null ){

    // Defining default attributes
    $default_atts = array(
        'product_type'          => '',    // available values : recent, featured, top_rated, sale, deal, best_selling
        'title'                 => '',    // header title (required)
        'subtitle'              => '',    // header subtitle
        'cat'                   => '',
        'num'                   => '8',   // max generated entry
        'image_aspect_ratio'    => 0.75,
        'preloadable'           => false,
        'preload_preview'       => true,
        'preload_bgcolor'       => '',
        'exclude_without_media' => 0,
        'order_by'              => 'date',
        'order'                 => 'DESC',
        'only_products__in'     => '',   // display only these post IDs. array or string comma separated
        'include'               => '',    // include these post IDs in result too. array or string comma separated
        'exclude'               => '',    // exclude these post IDs from result. array or string comma separated
        'offset'                => '',
        'show_filters'          => '1',
        'show_sort'             => '0',
        'filter_by'             => 'product_cat',
        'filter_style'          => 'aux-slideup',
        'filter_align'          => 'aux-center',
        'display_price'         => true,
        'display_rating'        => true,
        'display_meta_fields'   => false,
        'display_add_to_cart'   => true,
        'display_wishlist'      => true,
        'display_sale_badge'    => true,
        'display_feat_badge'    => true,
        'display_title'         => true,
        'display_content'       => false,
        'desc_char_num'         => 120,
        'display_categories'    => true,
        'display_quicklook'     => false,
        'deeplink'              => 0,
        'deeplink_slug'         => uniqid('product-cat-'),
        'desktop_cnum'          => 4,
        'tablet_cnum'           => 'inherit',
        'phone_cnum'            => '1',
        'post_type'             => 'product',
        'taxonomy_name'         => 'product_cat', // the taxonomy that we intent to display in post info
        'tax_args'              => '',
        'terms'                 => '',
        'extra_classes'         => '',
        'template_part_file'    => 'template-advanced-recent-product',
        'extra_template_path'   => AUXSHP_PUB_DIR . '/templates/elements',
        'universal_id'          => '',
        'use_wp_query'          => false, // true to use the global wp_query, false to use internal custom query
        'reset_query'           => true,
        'wp_query_args'         => array(), // additional wp_query args
        'query_args'            => array(),
        'custom_wp_query'       => '',
        'base'                  => 'aux_advance_recent_products',
        'base_class'            => 'aux-widget-recent-products-pro',
        'show_pagination'       => '',
        'paged'                 => 1
    );

    $result = auxin_get_widget_scafold( $atts, $default_atts, $shortcode_content );

    $container_class = 'aux-recent-products-pro-wrapper aux-ajax-view aux-row aux-de-col' . $result['parsed_atts']['desktop_cnum'] ;
    $result['parsed_atts']['image_class'] = '';

    $column_media_width = auxin_get_content_column_width( $result['parsed_atts']['desktop_cnum'], 15 );

    $result['parsed_atts']['image_size'] = array( 'width' => $column_media_width, 'height' => $column_media_width * $result['parsed_atts']['image_aspect_ratio'] );

    $deeplink = auxin_is_true( $result['parsed_atts']['deeplink'] );

    ob_start();

    // widget header ------------------------------
    echo $result['widget_header'];
    echo $result['widget_title'];

    if ( auxin_is_true( $result['parsed_atts']['show_filters']  ) || auxin_is_true( $result['parsed_atts']['show_sort'] ) ) {

        $sort_args = array();

        if ( auxin_is_true( $result['parsed_atts']['show_sort'] ) ) {

            $sort_args = array(
                __('popularity','auxin-shop' )        => 'popularity',
                __('average rating','auxin-shop' )    => 'rating',
                __('newness','auxin-shop' )           => 'date',
                __('price:low to high','auxin-shop' ) => array(
                    'orderby' => 'price',
                    'order'   => 'low'
                ),
                __('price:high to low','auxin-shop' ) => array(
                    'orderby' => 'price',
                    'order'   => 'high'
                )
            );

        }

        if( function_exists('auxin_filter_output') ){
            // Filter Markup
            auxin_filter_output(
                array(
                    'taxonomy'   => $result['parsed_atts']['filter_by'],
                    'meta_query' => array(
                        'relation' => 'OR',
                        array( 'meta_key' => 'tax_position' )
                    ),
                    'orderby'    => 'tax_position',
                    'hide_empty' => true,
                    'include'    => $result['parsed_atts']['cat']
                ),
                $result['parsed_atts']['filter_style'],
                $result['parsed_atts']['filter_align'],
                'aux-ajax-filters',
                $sort_args
            );
        }

    }

    $tablet_cnum      = ( 'inherit' == $result['parsed_atts']['tablet_cnum']  ) ? $result['parsed_atts']['desktop_cnum'] : $result['parsed_atts']['tablet_cnum'] ;
    $container_class .= ' aux-tb-col' . $tablet_cnum . ' aux-mb-col' . $result['parsed_atts']['phone_cnum'];

    $container_attrs  = 'data-element-id="' . $result['parsed_atts']['universal_id'] . '" data-num="'. $result['parsed_atts']['num'] .'" data-order="'. $result['parsed_atts']['order'] .'" data-orderby="'. $result['parsed_atts']['order_by'] .'" data-taxonomy="'. $result['parsed_atts']['filter_by'] .'" data-n="'. wp_create_nonce( 'aux_ajax_filterable_product' ) .'"';
    $container_attrs .= ' data-deeplink="'. ( $deeplink ? 'true' : 'false' ) . '"';
    $container_attrs .= ' data-slug="'. esc_attr( $result['parsed_atts']['deeplink_slug'] ).'"';
    
    if ( !empty( $result['parsed_atts']['show_pagination'] ) ) {
        $container_attrs .= ' data-paged="' . $result['parsed_atts']['paged'] . '"';
    } 

    if ( auxin_is_true( $result['parsed_atts']['show_filters']  ) ) {
        echo '<div class="aux-isotope-animated"><div class="aux-items-loading aux-loading-hide"><div class="aux-loading-loop"><svg class="aux-circle" width="100%" height="100%" viewBox="0 0 42 42"><circle class="aux-stroke-bg" r="20" cx="21" cy="21" fill="none"></circle><circle class="aux-progress" r="20" cx="21" cy="21" fill="none" transform="rotate(-90 21 21)"></circle></svg></div></div></div>';
    }

    printf( '<div class="%s" %s>', $container_class, $container_attrs );

    // widget custom output -----------------------
    include_once auxin_get_template_file( $result['parsed_atts']['template_part_file'], '', $result['parsed_atts']['extra_template_path'] );
    echo auxin_advanced_recent_products( $result['parsed_atts'] );
    echo '</div>';
    echo '<script type="text/javascript">var ' . $result['parsed_atts']['universal_id'] . 'AjaxConfig = ' . wp_json_encode( $result['parsed_atts'] ) . ';</script>';
    // widget footer ------------------------------
    echo $result['widget_footer'];

    return ob_get_clean();
}
