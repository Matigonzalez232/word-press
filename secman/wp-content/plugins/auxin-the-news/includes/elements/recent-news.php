<?php
/**
 *
 * @package    Auxin
 * @license    LICENSE.txt
 * @author
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2017
 */

function auxin_get_recent_news_master_array( $master_array ) {


    $master_array['aux_recent_news'] = array(
        'name'                          => __( 'Recent News', 'auxin-news' ),
        'auxin_output_callback'         => 'auxin_widget_recent_news_callback',
        'base'                          => 'aux_recent_news',
        'description'                   => __( 'It adds recent news.', 'auxin-news' ),
        'class'                         => 'aux-widget-recent-news',
        'show_settings_on_create'       => true,
        'weight'                        => 1,
        'is_widget'                     => true,
        'is_shortcode'                  => true,
        'category'                      => THEME_NAME,
        'group'                         => '',
        'admin_enqueue_js'              => '',
        'admin_enqueue_css'             => '',
        'front_enqueue_js'              => '',
        'front_enqueue_css'             => '',
        'icon'                          => 'auxin-element auxin-grid',
        'custom_markup'                 => '',
        'js_view'                       => '',
        'html_template'                 => '',
        'deprecated'                    => '',
        'content_element'               => '',
        'as_parent'                     => '',
        'as_child'                      => '',
        'params' => array(
            array(
                'heading'           => __( 'Title', 'auxin-news' ),
                'description'       => __( 'Recent items title, leave it empty if you don`t need title.', 'auxin-news' ),
                'param_name'        => 'title',
                'type'              => 'textfield',
                'value'             => '',
                'holder'            => 'textfield',
                'class'             => 'title',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '' ,
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Categories', 'auxin-news' ),
                'description'       => __( 'Specifies a category that you want to show news items from it.', 'auxin-news' ),
                'param_name'        => 'cat',
                'type'              => 'aux_taxonomy',
                'taxonomy'          => 'news-category',
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
                'heading'           => __( 'Number of items to show', 'auxin-news' ),
                'description'       => __( 'Leave it empty to show all items', 'auxin-news' ),
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
                'heading'           => __( 'Exclude news without media', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'exclude_without_media',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'            => __( 'Order by', 'auxin-news' ),
                'description'        => '',
                'param_name'         => 'order_by',
                'type'               => 'dropdown',
                'def_value'          => 'date',
                'holder'             => '',
                'class'              => 'order_by',
                'value'              => array (
                    'date'            => __( 'Date', 'auxin-news' ),
                    'menu_order date' => __( 'Menu Order', 'auxin-news' ),
                    'title'           => __( 'Title', 'auxin-news' ),
                    'ID'              => __( 'ID', 'auxin-news' ),
                    'rand'            => __( 'Random', 'auxin-news' ),
                    'comment_count'   => __( 'Comments', 'auxin-news' ),
                    'modified'        => __( 'Date Modified', 'auxin-news' ),
                    'author'          => __( 'Author', 'auxin-news' ),
                    'post__in'        => __( 'Inserted Post IDs', 'auxin-news' )
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Order', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'order',
                'type'              => 'dropdown',
                'def_value'         => 'DESC',
                'holder'            => '',
                'class'             => 'order',
                'value'             =>array (
                    'DESC'          => __( 'Descending', 'auxin-news' ),
                    'ASC'           => __( 'Ascending', 'auxin-news' ),
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Only news', 'auxin-news' ),
                'description'       => __( 'If you intend to display ONLY specific news, you should specify them here. You have to insert the post IDs that are separated by comma (eg. 53,34,87,25).', 'auxin-news' ),
                'param_name'        => 'only_posts__in',
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
                'heading'           => __( 'Include news', 'auxin-news' ),
                'description'       => __( 'If you intend to include additional news, you should specify them here. You have to insert the Post IDs that are separated by comma (eg. 53,34,87,25)', 'auxin-news' ),
                'param_name'        => 'include',
                'type'              => 'textfield',
                'value'             => '',
                'holder'            => 'textfield',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Exclude news', 'auxin-news' ),
                'description'       => __('If you intend to exclude specific news from result, you should specify the news here. You have to insert the Post IDs that are separated by comma (eg. 53,34,87,25)', 'auxin-news' ),
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
                'heading'           => __( 'Big Post Content Length', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'big_content',
                'type'              => 'textfield',
                'value'             => 0,
                'holder'            => 'textfield',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Start offset', 'auxin-news' ),
                'description'       => __( 'Number of post to displace or pass over.', 'auxin-news' ),
                'param_name'        => 'offset',
                'type'              => 'textfield',
                'value'             => '',
                'holder'            => 'textfield',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Layout', 'auxin-news' ),
                'description'       => __( 'Different layout types of appearing items.', 'auxin-news' ),
                'param_name'        => 'header_position',
                'type'              => 'aux_visual_select',
                'def_value'         => 'top',
                'holder'            => '',
                'class'             => 'num',
                'value'             => array(
                    'top'           => 'Top Header',
                    'side'          => 'Side Header',
                ),
                'choices'           => array (
                    'top'       => array(
                            'label' => __( 'Top Header', 'auxin-news' ),
                            'image' =>  AUXNEW_ADMIN_URL . '/assets/images/visual-select/recent-news-1.svg'
                    ),
                    'side'       => array(
                            'label' => __( 'Side Header', 'auxin-news' ),
                            'image' =>  AUXNEW_ADMIN_URL . '/assets/images/visual-select/recent-news-2.svg'
                    ),
                ),
                'admin_label'       => true,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'          => __('Load More Type','auxin-news' ),
                'description'      => '',
                'param_name'       => 'loadmore_type',
                'type'             => 'aux_visual_select',
                'value'            => 'infinite-scroll',
                'class'            => 'loadmore_type',
                'admin_label'      => false,
                'dependency'       => '',
                'weight'           => '',
                'group'            => '' ,
                'edit_field_class' => '',
                'choices'          => array(
                    ''             => array(
                        'label' => __('None', 'auxin-news' ),
                        'image' => AUXIN_URL . 'images/visual-select/load-more-none.svg'
                    ),
                    'infinite-scroll'       => array(
                        'label' => __('Infinite Scroll', 'auxin-news' ),
                        'image' => AUXIN_URL . 'images/visual-select/load-more-infinite.svg'
                    ),
                    'next'         => array(
                        'label' => __('Next Button', 'auxin-news' ),
                        'image' => AUXIN_URL . 'images/visual-select/load-more-button.svg'
                    ),
                    'next-prev'    => array(
                        'label' => __('Next Prev', 'auxin-news' ),
                        'image' => AUXIN_URL . 'images/visual-select/load-more-next-prev.svg'
                    )
                )
            ),
            array(
                'heading'           => __( 'Show big post', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'show_header',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Show big post image', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'header_show_image',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'show_header',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Show posts image', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'show_image',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Insert news title', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'show_title',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Insert news info', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'show_info',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Post info position', 'auxin-news' ),
                'description'       => 'Show post info before or after post title.',
                'param_name'        => 'info_position',
                'type'              => 'dropdown',
                'def_value'         => 'after_title',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'show_info',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => '',
                'value'             => array(
                    'before_title' => __( 'Before Title', 'auxin-news' ),
                    'after_title' => __( 'After Title', 'auxin-news' )
                )
            ),
            array(
                'heading'           => __( 'Insert news date', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'show_date',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'show_info',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Insert news author', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'show_author',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'show_info',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Insert news categories', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'show_categories',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'dependency'        => array(
                    'element'       => 'show_info',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __('Image aspect ratio', 'auxin-news'),
                'description'       => '',
                'param_name'        => 'image_aspect_ratio',
                'type'              => 'dropdown',
                'def_value'         => '0.75',
                'holder'            => '',
                'class'             => 'order',
                'value'             =>array (
                    '0.75'          => __('Horizontal 4:3' , 'auxin-news'),
                    '0.56'          => __('Horizontal 16:9', 'auxin-news'),
                    '1.00'          => __('Square 1:1'     , 'auxin-news'),
                    '1.33'          => __('Vertical 3:4'   , 'auxin-news')
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),            
            array(
                'heading'           => __('Big Image aspect ratio', 'auxin-news'),
                'description'       => '',
                'param_name'        => 'big_image_aspect_ratio',
                'type'              => 'dropdown',
                'def_value'         => '0.75',
                'holder'            => '',
                'class'             => 'order',
                'value'             =>array (
                    '0.75'          => __('Horizontal 4:3' , 'auxin-news'),
                    '0.56'          => __('Horizontal 16:9', 'auxin-news'),
                    '1.00'          => __('Square 1:1'     , 'auxin-news'),
                    '1.33'          => __('Vertical 3:4'   , 'auxin-news')
                ),
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),            
            array(
                'heading'           => __( 'Show filters', 'auxin-news' ),
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
                'heading'           => __( 'Filter by', 'auxin-news' ),
                'description'       => __( 'Filter by categories or tags', 'auxin-news' ),
                'param_name'        => 'filter_by',
                'type'              => 'dropdown',
                'def_value'         => 'news-category',
                'holder'            => 'dropdown',
                'value'             =>array (
                    'news-category' => __( 'Categories', 'auxin-news' ),
                    'news-tag'      => __( 'Tags', 'auxin-news')
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
                'heading'           => __( 'Filter button style', 'auxin-news' ),
                'description'       => __( 'Style of filter buttons.', 'auxin-news' ),
                'param_name'        => 'filter_style',
                'type'              => 'dropdown',
                'def_value'         => 'aux-slideup',
                'holder'            => '',
                'dependency'        => array(
                    'element'       => 'show_filters',
                    'value'         => '1'
                ),
                'weight'            => '',
                'group'             => 'Filter',
                'edit_field_class'  => '',
                'value'             => array (
                    'aux-slideup'   => __( 'Slide up', 'auxin-news' ),
                    'aux-fill'      => __( 'Fill', 'auxin-news' ),
                    'aux-cube'      => __( 'Cube', 'auxin-news' ),
                    'aux-underline' => __( 'Underline', 'auxin-news' ),
                    'aux-overlay'   => __( 'Float frame', 'auxin-news' ),
                    'aux-borderd'   => __( 'Borderd', 'auxin-news' ),
                    'aux-overlay aux-underline-anim'    => __( 'Float underline', 'auxin-news' )
                )
            ),
            array(
                'heading'           => __( 'Category Filter Color', 'auxin-news' ),
                'description'       => __( 'Enable category filter color', 'auxin-news' ),
                'param_name'        => 'filter_colors',
                'type'              => 'aux_switch',
                'value'         => '1',
                'holder'            => '',
                'dependency'        => array(
                    'element' => 'filter_by',
                    'value'   => 'news-category'
                ),
                'weight'            => '',
                'group'             => 'Filter',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Extra class name', 'auxin-news' ),
                'description'       => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'auxin-news' ),
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

add_filter( 'auxin_master_array_shortcodes', 'auxin_get_recent_news_master_array', 10, 1 );


/**
 * Element without loop and column
 * The front-end output of this element is returned by the following function
 *
 * @param  array  $atts              The array containing the parsed values from shortcode, it should be same as defined params above.
 * @param  string $shortcode_content The shorcode content
 * @return string                    The output of element markup
 */
function auxin_widget_recent_news_callback( $atts, $shortcode_content = null ){

    $default_atts = array(
        'title'                       => '',
        'num'                         => '5',   // max generated entry
        'header_position'             => 'top',
        'cat'                         => ' ',
        'only_posts__in'              => '',   // display only these post IDs. array or string comma separated
        'include'                     => '',    // include these post IDs in result too. array or string comma separated
        'exclude'                     => '',    // exclude these post IDs from result. array or string comma separated
        'preloadable'                 => false,
        'preload_preview'             => true,
        'preload_bgcolor'             => '',
        'show_header'                 => true,
        'show_image'                  => true,
        'show_title'                  => true,
        'words_num'                   => '',
        'show_badge'                  => false,
        'show_info'                   => true,
        'display_like'                => false,
        'display_comments'            => false,
        'author_or_readmore'          => '',
        'show_filters'                => true,
        'image_aspect_ratio'          => 0.662,
        'big_image_aspect_ratio'      => 0.662,
        'offset'                      => '',
        'paged'                       => '',
        'order_by'                    => 'date',
        'order'                       => 'DESC',
        'exclude_without_media'       => 0,
        'exclude_custom_post_formats' => 0,
        'exclude_quote_link'          => 0,
        'exclude_post_formats_in'     => array(), // the list od post formats to exclude
        'content'                     => 0,
        'big_content'                 => 25,
        'main_desktop_cnum'           => 7,
        'main_tablet_cnum'            => 7,
        'main_phone_cnum'             => 12,
        'side_desktop_cnum'           => 5,
        'side_tablet_cnum'            => 5,
        'side_phone_cnum'             => 12,
        'info_position'               => 'after_title',
        'show_date'                   => true,
        'filter_style'                => 'aux-slideup',
        'filter_by'                   => 'news-category',
        'show_author'                 => true,
        'show_categories'             => true,
        'exclude_without_media'       => false,
        'filter_colors'               => true,
        'header_args'                 => array(
        'show_image'                  => true,
        'inside_mode'                 => false
        ),
        'extra_classes'               => '',
        'extra_column_classes'        => '',
        'custom_el_id'                => '',
        'universal_id'                => '',
        'wp_query_args'               => array(), // additional wp_query args
        'reset_query'                 => true,
        'custom_wp_query'             => '',
        'query_args'                  => array(),
        'loadmore_type'               => '', // 'next' (more button), 'infinite-scroll', 'next-prev'
        'loadmore_per_page'           => '',
        'base'                        => 'aux_recent_news',
        'base_class'                  => 'aux-widget-recent-news'
    );

    $result = auxin_get_widget_scafold( $atts, $default_atts, $shortcode_content );

    if ( isset( $atts['show_image'] ) ) {
        $result['header_args']['show_image'] = $atts['show_image'];
    }

    if ( 'news-1' === auxin_get_option( 'news_index_template_type', 'news-default' ) ) {
        $result['header_args']['inside_mode'] = true;
    }

    ob_start();

    // widget header ------------------------------
    echo $result['widget_header'];

    require_once( AUXNEW_PUB_DIR . '/includes/templates-news.php'    );

    echo auxin_news_element( $result['parsed_atts'] );
    echo '<script type="text/javascript">var ' . $result['parsed_atts']['universal_id'] . 'AjaxConfig = ' . wp_json_encode( $result['parsed_atts'] ) . ';</script>';
    // widget footer ------------------------------
    echo $result['widget_footer'];

    return ob_get_clean();
}
