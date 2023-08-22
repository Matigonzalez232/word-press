<?php
/**
 * Code highlighter element
 *
 * 
 * @package    
 * @license    LICENSE.txt
 * @author     averta <info@averta.net>
 * @link       https://bitbucket.org/averta/
 * @copyright  (c) 2010-2023 averta <info@averta.net>
 */

function auxin_get_products_carousel_master_array( $master_array ) {

    $master_array['aux_products_carousel'] = array(
        'name'                          => __('Recent Products Carousel', 'auxin-shop' ),
        'auxin_output_callback'         => 'auxin_widget_products_carousel_callback',
        'base'                          => 'aux_products_carousel',
        'description'                   => __('It adds recent products in carousel mode.', 'auxin-shop' ),
        'class'                         => 'aux-widget-recent-products-carousel',
        'show_settings_on_create'       => true,
        'weight'                        => 1,
        'is_widget'                     => false,
        'is_shortcode'                  => true,
        'category'                      => THEME_NAME,
        'group'                         => '',
        'admin_enqueue_js'              => '',
        'admin_enqueue_css'             => '',
        'front_enqueue_js'              => '',
        'front_enqueue_css'             => '',
        'icon'                          => 'aux-element aux-pb-icons-grid',
        'custom_markup'                 => '',
        'js_view'                       => '',
        'html_template'                 => '',
        'deprecated'                    => '',
        'content_element'               => '',
        'as_parent'                     => '',
        'as_child'                      => '',
        'params' => array(
            array(
                'heading'          => __('Title','auxin-shop' ),
                'description'      => __('Recent products title, leave it empty if you don`t need title.', 'auxin-shop'),
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
                'def_value'         => ' ',
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
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Use Custom Aspect Ratio', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'custom_image_aspect_ratio',
                'type'              => 'aux_switch',
                'def_value'         => '0',
                'holder'            => '',
                'class'             => 'order',
                'value'             => false,
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
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
                    '1.33'          => __('Vertical 3:4'   , 'auxin-shop'),
                    '1.5'           => __('Vertical 2:3'   , 'auxin-shop')
                ),
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'custom_image_aspect_ratio',
                    'value'         => '1'
                ),
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
                'heading'           => __( 'Display product title', 'auxin-shop' ),
                'description'       => '',
                'param_name'        => 'display_title',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => 'display_title',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Info',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Display products price', 'auxin-shop' ),
                'param_name'        => 'display_price',
                'type'              => 'aux_switch',
                'def_value'         => '',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_price',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Info',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Display add to cart', 'auxin-shop' ),
                'description'       => '',
                'param_name'        => 'display_add_to_cart',
                'type'              => 'aux_switch',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_add_to_cart',
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'show_info',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => 'Info',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Display Categories', 'auxin-shop' ),
                'description'       => '',
                'param_name'        => 'display_categories',
                'type'              => 'aux_switch',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_categories',
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'show_info',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => 'Info',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Display share', 'auxin-shop' ),
                'param_name'        => 'display_share',
                'type'              => 'aux_switch',
                'def_value'         => '',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_share',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Info',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Display add to wishlist', 'auxin-shop' ),
                'param_name'        => 'display_wishlist',
                'type'              => 'aux_switch',
                'def_value'         => '',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_wishlist',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Info',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Display Sale Badge', 'auxin-shop' ),
                'description'       => '',
                'param_name'        => 'display_sale_badge',
                'type'              => 'aux_switch',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'display_sale_badge',
                'admin_label'       => false,
                'weight'            => '',
                'group'             => 'Info',
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
            array(
                'heading'           => __('Display items as', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'preview_mode',
                'type'              => 'dropdown',
                'def_value'         => 'grid',
                'holder'            => 'textfield',
                'class'             => 'num',
                'value'             => array(
                    'carousel'      => __( 'Carousel', 'auxin-shop' )
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Content layout', 'auxin-shop'),
                'description'       => __('Specifies the style of content for each post column.', 'auxin-shop' ),
                'param_name'        => 'content_layout',
                'type'              => 'dropdown',
                'def_value'         => 'default',
                'holder'            => '',
                'class'             => 'content_layout',
                'value'             =>array (
                    'default'       => __('Full Content', 'auxin-shop'),
                    'entry-boxed'   => __('Boxed Content', 'auxin-shop')
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            // Carousel Options
            array(
                'heading'           => __( 'Column space', 'auxin-shop' ),
                'description'       => __( 'Specifies horizontal space between items (pixel).', 'auxin-shop' ),
                'param_name'        => 'carousel_space',
                'type'              => 'textfield',
                'value'             => '30',
                'holder'            => '',
                'class'             => 'excerpt_len',
                'admin_label'       => false,
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Navigation type', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'carousel_navigation',
                'type'              => 'dropdown',
                'def_value'         => 'peritem',
                'holder'            => '',
                'class'             => 'num',
                'value'             => array(
                   'peritem'        => __('Move per column', 'auxin-shop'),
                   'perpage'        => __('Move per page', 'auxin-shop'),
                   'scroll'         => __('Smooth scroll', 'auxin-shop'),
                ),
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'preview_mode',
                    'value'         => 'carousel'
                ),
                'weight'            => '',
                'group'             => 'Carousel',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Navigation control', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'carousel_navigation_control',
                'type'              => 'dropdown',
                'def_value'         => 'arrows',
                'holder'            => '',
                'class'             => 'num',
                'value'             => array(
                   'arrows'         => __('Arrows', 'auxin-shop'),
                   'bullets'        => __('Bullets', 'auxin-shop'),
                   ''               => __('None', 'auxin-shop'),
                ),
                'dependency'        => array(
                    'element'       => 'preview_mode',
                    'value'         => 'carousel'
                ),
                'weight'            => '',
                'admin_label'       => false,
                'group'             => 'Carousel',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Control Position', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'carousel_nav_control_pos',
                'type'              => 'dropdown',
                'def_value'         => 'center',
                'holder'            => '',
                'value'             => array(
                   'center'         => __('Center', 'auxin-shop'),
                   'side'           => __('Side', 'auxin-shop'),
                ),
                'dependency'        => array(
                    'element'       => 'carousel_navigation_control',
                    'value'         => 'arrows'
                ),
                'weight'            => '',
                'admin_label'       => false,
                'group'             => 'Carousel',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Control Arrow Skin', 'auxin-shop'),
                'description'       => '',
                'param_name'        => 'carousel_nav_control_skin',
                'type'              => 'dropdown',
                'def_value'         => 'boxed',
                'holder'            => '',
                'value'             => array(
                   'boxed'           => __('boxed', 'auxin-shop'),
                   'long'         => __('Long Arrow', 'auxin-shop'),
                ),
                'dependency'        => array(
                    'element'       => 'carousel_navigation_control',
                    'value'         => 'arrows'
                ),
                'weight'            => '',
                'admin_label'       => false,
                'group'             => 'Carousel',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Loop navigation','auxin-shop' ),
                'description'       => '',
                'param_name'        => 'carousel_loop',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'dependency'        => array(
                    'element'       => 'preview_mode',
                    'value'         => 'carousel'
                ),
                'weight'            => '',
                'group'             => 'Carousel',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Autoplay carousel','auxin-shop' ),
                'description'       => '',
                'param_name'        => 'carousel_autoplay',
                'type'              => 'aux_switch',
                'value'             => '0',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'preview_mode',
                    'value'         => 'carousel'
                ),
                'weight'            => '',
                'group'             => 'Carousel',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Autoplay delay','auxin-shop' ),
                'description'       => __('Specifies the delay between auto-forwarding in seconds.', 'auxin-shop' ),
                'param_name'        => 'carousel_autoplay_delay',
                'type'              => 'textfield',
                'value'             => '2',
                'holder'            => '',
                'class'             => 'excerpt_len',
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'carousel_autoplay',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => 'Carousel',
                'edit_field_class'  => ''
            ),
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

add_filter( 'auxin_master_array_shortcodes', 'auxin_get_products_carousel_master_array', 10, 1 );




/**
 * Element without loop and column
 * The front-end output of this element is returned by the following function
 *
 * @param  array  $atts              The array containing the parsed values from shortcode, it should be same as defined params above.
 * @param  string $shortcode_content The shorcode content
 * @return string                    The output of element markup
 */
function auxin_widget_products_carousel_callback( $atts, $shortcode_content = null ){

    global $aux_content_width;
    // Defining default attributes
    $default_atts = array(
        'title'                       => '',    // header title (required)
        'subtitle'                    => '',    // header subtitle
        'cat'                         => ' ',
        'num'                         => '8',   // max generated entry
        'only_products__in'           => '',   // display only these post IDs. array or string comma separated
        'include'                     => '',    // include these post IDs in result too. array or string comma separated
        'exclude'                     => '',    // exclude these post IDs from result. array or string comma separated
        'offset'                      => '',
        'paged'                       => '',
        'post_type'                   => 'product',
        'taxonomy_name'               => 'product_cat', // the taxonomy that we intent to display in post info
        'tax_args'                    => '',
        'order_by'                    => 'date',
        'order'                       => 'DESC',

        'exclude_without_media'       => 0,
        'exclude_custom_post_formats' => 0,
        'exclude_quote_link'          => 0,
        'exclude_post_formats_in'     => array(), // the list od post formats to exclude

        'size'                        => '',
        'display_title'               => true,
        'show_media'                  => true,
        'display_wishlist'            => true,
        'display_categories'          => true,
        'display_price'               => true,
        'display_share'               => true,
        'display_add_to_cart'         => true,
        'display_sale_badge'          => true,
        'display_rating'              => false,
        'display_meta_fields'         => false,
        'display_content'             => false,
        'display_quicklook'           => false,
        'desc_char_num'               => 120,
        'content_layout'              => '', // entry-boxed
        'excerpt_len'                 => '160',
        'show_excerpt'                => true,
        'show_info'                   => true,
        'show_date'                   => true,
        'post_info_position'          => 'after-title',
        'author_or_readmore'          => 'readmore', // readmore, author, none
        'image_aspect_ratio'          => 0.75,
        'desktop_cnum'                => 4,
        'tablet_cnum'                 => 'inherit',
        'phone_cnum'                  => '1',
        'preview_mode'                => 'carousel',
        'display_price'               => true,
        'display_sale_badge'          => true,
        'display_featured_color'      => false,
        'preloadable'                 => false,
        'preload_preview'             => true,
        'preload_bgcolor'             => '',

        'extra_classes'               => '',
        'extra_column_classes'        => '',
        'custom_el_id'                => '',
        'carousel_space'              => '30',
        'carousel_autoplay'           => false,
        'carousel_same_height'        => false,
        'carousel_autoplay_delay'     => '2',
        'carousel_navigation'         => 'peritem',
        'carousel_navigation_control' => 'arrows',
        'carousel_nav_control_pos'    => 'center',
        'carousel_nav_control_skin'   => 'boxed',
        'carousel_loop'               => 1,

        'request_from'                => 'element',

        'template_part_file'          => 'elements/products-carousel',
        'extra_template_path'         =>  AUXSHP_PUB_DIR . '/templates/',

        'universal_id'                => '',
        'use_wp_query'                => false, // true to use the global wp_query, false to use internal custom query
        'reset_query'                 => true,
        'wp_query_args'               => array(), // additional wp_query args
        'custom_wp_query'             => '',
        'base'                        => 'aux_products_carousel',
        'base_class'                  => 'aux-widget-recent-products-carousel'
    );

    $result = auxin_get_widget_scafold( $atts, $default_atts, $shortcode_content );
    extract( $result['parsed_atts'] );

    // get content width
    global $aux_content_width;

    // --------------

    ob_start();

    if( empty( $cat ) || $cat == " " || ( is_array( $cat ) && in_array( " ", $cat ) ) ) {
        $tax_args = array();
    } else {
        $tax_args = array(
            array(
                'taxonomy' => $taxonomy_name,
                'field'    => 'term_id',
                'terms'    => ! is_array( $cat ) ? explode( ",", $cat ) : $cat
            )
        );
    }

    if( $custom_wp_query ){
        $wp_query = $custom_wp_query;

    } elseif( ! $use_wp_query ){

        // create wp_query to get latest items ---------------------------------
        $args = array(
            'post_type'               => $post_type,
            'orderby'                 => $order_by,
            'order'                   => $order,
            'offset'                  => $offset,
            'paged'                   => $paged,
            'tax_query'               => $tax_args,
            'post_status'             => 'publish',
            'posts_per_page'          => $num,
            'ignore_sticky_posts'     => 1,

            'include_posts__in'       => $include, // include posts in this list
            'posts__not_in'           => $exclude, // exclude posts in this list
            'posts__in'               => $only_products__in, // only posts in this list

            'exclude_without_media'   => $exclude_without_media,
            'exclude_post_formats_in' => $exclude_post_formats_in
        );

        // ---------------------------------------------------------------------

        // add the additional query args if available
        if( $wp_query_args ){
            $args = wp_parse_args( $wp_query_args, $args );
        }

        // pass the args through the auxin query parser
        $wp_query = new WP_Query( auxin_parse_query_args( $args ) );
    } else {

        global $wp_query;
    }

    // widget header ------------------------------
    echo $result['widget_header'];
    echo $result['widget_title'];
    echo '<h4 class="aux-h4 widget-subtitle aux-product-carousel-subtitle">' . esc_html( $subtitle ) . '</h4>';


    $phone_break_point     = 767;
    $tablet_break_point    = 1025;

    $show_comments         = true; // shows comments icon
    $post_counter          = 0;
    $column_class          = '';
    $item_class            = '';
    $carousel_attrs        = '';

    $columns_custom_styles = '';

    if( ! empty( $loadmore_type ) ) {
        $item_class        .= ' aux-ajax-item';
    }

    $column_class    = 'products-loop master-carousel aux-no-js aux-mc-before-init';
    $item_class      .= ' aux-mc-item';

    // genereate the master carousel attributes
    $carousel_attrs  =  'data-columns="' . esc_attr( $desktop_cnum ) . '"';
    $carousel_attrs .= ' data-autoplay="' . esc_attr( $carousel_autoplay ) . '"';
    $carousel_attrs .= ' data-delay="' . esc_attr( $carousel_autoplay_delay ) . '"';
    $carousel_attrs .= ' data-navigation="' . esc_attr( $carousel_navigation ) . '"';
    $carousel_attrs .= ' data-space="' . esc_attr( $carousel_space ). '"';
    $carousel_attrs .= ' data-loop="' . esc_attr( $carousel_loop ) . '"';
    $carousel_attrs .= ' data-wrap-controls="true"';
    $carousel_attrs .= ' data-bullets="' . ('bullets' == $carousel_navigation_control ? 'true' : 'false') . '"';
    $carousel_attrs .= ' data-bullet-class="aux-bullets aux-small aux-mask"';
    $carousel_attrs .= ' data-arrows="' . ('arrows' == $carousel_navigation_control ? 'true' : 'false') . '"';
    $carousel_attrs .= ' data-same-height="' . esc_attr( $carousel_same_height ) . '"';

    if ( 'inherit' != $tablet_cnum || 'inherit' != $phone_cnum ) {
        $carousel_attrs .= ' data-responsive="'. esc_attr( ( 'inherit' != $tablet_cnum  ? $tablet_break_point . ':' . $tablet_cnum . ',' : '' ).
                                                           ( 'inherit' != $phone_cnum   ? $phone_break_point  . ':' . $phone_cnum : '' ) ) . '"';
    }


    $extra_column_classes .= 'aux-' . $carousel_nav_control_pos . '-control';

    // Specifies whether the columns have footer meta or not
    $column_class  .= ' aux-ajax-view  ' . $extra_column_classes;

    $column_media_width = auxin_get_content_column_width( $desktop_cnum, 15 );
    $size = array( 'width' => $column_media_width, 'height' => $column_media_width * $image_aspect_ratio );

    $have_posts = $wp_query->have_posts();

    if( $have_posts ){

        echo ! $skip_wrappers ? sprintf( '<div class="aux-mc-wrapper"><div data-element-id="%s" class="%s" %s>', esc_attr( $universal_id ), esc_attr( $column_class ), $carousel_attrs ) : '';

        while ( $wp_query->have_posts() ) {

            $wp_query->the_post();
            $post = get_post();

            $the_format = get_post_format( $post );

            // Generate the markup by template parts
            if( has_action( $base_class . '-template-part' ) ){
                do_action(  $base_class . '-template-part', $result, $post_vars, $item_class );

            } else {
                printf( '<div class="%s post-%s">', esc_attr( $item_class ), esc_attr( $post->ID ) );
                include auxin_get_template_file( $template_part_file, '', $extra_template_path );
                echo    '</div>';
            }

        }

        if ( 'bullets' != $carousel_navigation_control ) {
            ?>
                <?php if ( 'boxed' ===  $carousel_nav_control_skin )  { ;?>
                    <div class="aux-carousel-controls">
                        <div class="aux-next-arrow aux-arrow-nav aux-outline aux-hover-fill">
                            <span class="aux-svg-arrow aux-small-right"></span>
                            <span class="aux-hover-arrow aux-white aux-svg-arrow aux-small-right"></span>
                        </div>
                        <div class="aux-prev-arrow aux-arrow-nav aux-outline aux-hover-fill">
                            <span class="aux-svg-arrow aux-small-left"></span>
                            <span class="aux-hover-arrow aux-white aux-svg-arrow aux-small-left"></span>
                        </div>
                    </div>
                <?php } else { ;?>
                    <div class="aux-carousel-controls">
                        <div class="aux-next-arrow">
                            <span class="aux-svg-arrow aux-l-right"></span>
                        </div>
                        <div class="aux-prev-arrow">
                            <span class="aux-svg-arrow aux-l-left"></span>
                        </div>
                    </div>
                <?php } ;?>
            <?php
        }

        if( ! $skip_wrappers ) {
            // End tag for aux-ajax-view wrapper
            echo '</div></div>';
        } else {
            // Get post counter in the query
            echo '<span class="aux-post-count hidden">'.$wp_query->post_count.'</span>';
            echo '<span class="aux-all-posts-count hidden">'.$wp_query->found_posts.'</span>';
        }

    }


    if( $reset_query ){
        wp_reset_postdata();
    }

    // return false if no result found
    if( ! $have_posts ){
        ob_get_clean();
        return false;
    }

    // widget footer ------------------------------
    echo $result['widget_footer'];

    return ob_get_clean();
}
