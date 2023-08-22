<?php
/**
 * Recent News Big Grid Element
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */

function auxin_get_recent_news_big_grid_master_array( $master_array ) {

    // $tags = get_terms( 'post_tag', 'orderby=count&hide_empty=0' );
    // $tags_list;
    // foreach ($tags as $key => $value) {
    //     $tags_list["$value->term_id"] = $value->name;
    // }


    $master_array['aux_recent_news_big_grid'] = array(
        'name'                          => __('Big Grid News', 'auxin-news' ),
        'auxin_output_callback'         => 'auxin_widget_recent_news_big_grid_callback',
        'base'                          => 'aux_recent_news_big_grid',
        'description'                   => __('It adds recent news in grid style.', 'auxin-news' ),
        'class'                         => 'aux-widget-recent-news-big-grid',
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
        'icon'                          => 'auxin-element auxin-tile',
        'custom_markup'                 => '',
        'js_view'                       => '',
        'html_template'                 => '',
        'deprecated'                    => '',
        'content_element'               => '',
        'as_parent'                     => '',
        'as_child'                      => '',
        'params' => array(
            array(
                'heading'          => __( 'Title','auxin-news' ),
                'description'      => __( 'Recent news title, leave it empty if you don`t need title.', 'auxin-news' ),
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
                'heading'           => __( 'Categories', 'auxin-news' ),
                'description'       => __( 'Specifies a category that you want to show posts from it.', 'auxin-news' ),
                'param_name'        => 'cat',
                'type'              => 'aux_taxonomy',
                'taxonomy'          => 'news-category',
                'def_value'         => ' ',
                'holder'            => '',
                'class'             => 'cat',
                'value'             => 'news-category',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => 'Query',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Number of news to show', 'auxin-news' ),
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
                'heading'           => __( 'Exclude news without media','auxin-news' ),
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
                'heading'           => __( 'Only posts','auxin-news' ),
                'description'       => __( 'If you intend to display ONLY specific posts, you should specify the posts here. You have to insert the post IDs that are separated by comma (eg. 53,34,87,25).', 'auxin-news' ),
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
                'heading'           => __( 'Include posts','auxin-news' ),
                'description'       => __( 'If you intend to include additional posts, you should specify the posts here. You have to insert the Post IDs that are separated by comma (eg. 53,34,87,25)', 'auxin-news' ),
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
                'heading'           => __( 'Exclude posts','auxin-news' ),
                'description'       => __( 'If you intend to exclude specific posts from result, you should specify the posts here. You have to insert the Post IDs that are separated by comma (eg. 53,34,87,25)', 'auxin-news' ),
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
                    'author'          => __( 'Author', 'auxin-news'),
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
                'heading'           => __( 'Start offset','auxin-news' ),
                'description'       => __( 'Number of post to displace or pass over.', 'auxin-news' ),
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
                'heading'          => __( 'Post Big Grid style','auxin-news' ),
                'description'      => '',
                'param_name'       => 'big_grid_style',
                'type'             => 'aux_visual_select',
                'def_value'        => 'default',
                'holder'           => '',
                'class'            => 'big_grid_style',
                'admin_label'      => false,
                'dependency'       => '',
                'weight'           => '',
                'group'            => 'Style',
                'edit_field_class' => '',
                'choices'          => array(
                    'default'    => array(
                        'label'    => __( 'Default', 'auxin-news' ),
                        'image'    => AUXNEW_ADMIN_URL . '/assets/images/visual-select/big-news-5.svg'
                    ),
                    'pattern-1'  => array(
                        'label'    => __( 'Pattern 1', 'auxin-news' ),
                        'image'    => AUXNEW_ADMIN_URL . '/assets/images/visual-select/big-news-3.svg'
                    ),
                    'pattern-2'  => array(
                        'label'    => __( 'Pattern 2', 'auxin-news' ),
                        'image'    => AUXNEW_ADMIN_URL . '/assets/images/visual-select/big-news-6.svg'
                    ),
                    'pattern-3'  => array(
                        'label'    => __( 'Pattern 3', 'auxin-news' ),
                        'image'    => AUXNEW_ADMIN_URL . '/assets/images/visual-select/big-news-7.svg'
                    ),
                    'pattern-4'  => array(
                        'label'    => __( 'Pattern 4', 'auxin-news' ),
                        'image'    => AUXNEW_ADMIN_URL . '/assets/images/visual-select/big-news-8.svg'
                    ),
                    'pattern-5'  => array(
                        'label'    => __( 'Pattern 5', 'auxin-news' ),
                        'image'    => AUXNEW_ADMIN_URL . '/assets/images/visual-select/big-news-4.svg'
                    ),
                    'pattern-6'  => array(
                        'label'    => __('Pattern 6', 'auxin-news' ),
                        'image'    => AUXNEW_ADMIN_URL . '/assets/images/visual-select/big-news-1.svg'
                    ),
                    'pattern-7'  => array(
                        'label'    => __('Pattern 7', 'auxin-news' ),
                        'image'    => AUXNEW_ADMIN_URL . '/assets/images/visual-select/big-news-2.svg'
                    ),
                )
            ),
            array(
                'heading'           => __( 'Insert post title','auxin-news' ),
                'description'       => '',
                'param_name'        => 'display_title',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => 'display_title',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '' ,
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Limit Title to Two Lines', 'auxin-news' ),
                'description'       => '',
                'param_name'        => 'title_limit',
                'type'              => 'aux_switch',
                'value'             => '1',
                'holder'            => '',
                'class'             => 'num',
                'admin_label'       => false,
                'dependency'        => '',
                'weight'            => '',
                'group'             => '',
                'edit_field_class'  => ''
            ),
            array(
                'heading'           => __( 'Insert news meta','auxin-news' ),
                'description'       => '',
                'param_name'        => 'show_info',
                'type'              => 'aux_switch',
                'value'             => '1',
                'class'             => '',
                'admin_label'       => false,
                'weight'            => '',
                'group'             => '' ,
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
                'heading'           => __( 'Extra class name','auxin-news' ),
                'description'       => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'auxin-news' ),
                'param_name'        => 'extra_classes',
                'type'              => 'textfield',
                'value'             => '',
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

add_filter( 'auxin_master_array_shortcodes', 'auxin_get_recent_news_big_grid_master_array', 10, 1 );


/**
 * Element without loop and column
 * The front-end output of this element is returned by the following function
 *
 * @param  array  $atts              The array containing the parsed values from shortcode, it should be same as defined params above.
 * @param  string $shortcode_content The shorcode content
 * @return string                    The output of element markup
 */
function auxin_widget_recent_news_big_grid_callback( $atts, $shortcode_content = null ){

    global $aux_content_width;

    // Defining default attributes
    $default_atts = array(
        'title'                 => '', // header title
        'cat'                   => ' ',
        'num'                   => '8', // max generated entry
        'title_limit'           => '1',
        'only_posts__in'        => '', // display only these post IDs. array or string comma separated
        'include'               => '',  // include these post IDs in result too. array or string comma separated
        'exclude'               => '',  // exclude these post IDs from result. array or string comma separated
        'posts_per_page'        => -1,
        'offset'                => '',
        'paged'                 => '',
        'order_by'              => 'date',
        'order'                 => 'DESC',
        'excerpt_len'           => '160',
        'exclude_without_media' => '1',
        'big_grid_style'        => '',
        'display_title'         => '1',
        'show_info'             => '1',
        'show_date'             => '1',
        'display_categories'    => '1',
        'content_width'         => '',

        'template_part_file'    => 'theme-parts/entry/post-tile',
        'extra_template_path'   => '',

        'extra_classes'         => '',
        'custom_el_id'          => '',

        'universal_id'          => '',
        'tax_args'              => '',
        'reset_query'           => true,
        'use_wp_query'          => false, // true to use the global wp_query, false to use internal custom query
        'wp_query_args'         => array(), // additional wp_query args,
        'custom_wp_query'       => '',
        'loadmore_type'         => '', // 'next' (more button), 'infinite-scroll', 'next-prev'
        'loadmore_per_page'     => '',
        'base'                  => 'aux_recent_news_big_grid',
        'base_class'            => 'aux-widget-recent-news-big-grid'
    );

    $result = auxin_get_widget_scafold( $atts, $default_atts, $shortcode_content );
    extract( $result['parsed_atts'] );


    // --------------

    ob_start();

    if( empty( $cat ) || $cat == " " || ( is_array( $cat ) && in_array( " ", $cat ) ) ) {
        $tax_args = array();
    } else {
        $tax_args = array(
            array(
                'taxonomy' => 'news-category',
                'field'    => 'term_id',
                'terms'    => ! is_array( $cat ) ? explode( ",", $cat ) : $cat
            )
        );
    }

    global $wp_query;

    if( $custom_wp_query ){
        $wp_query = $custom_wp_query;
    } elseif( ! $use_wp_query ){

        // create wp_query to get latest items -----------
        $args = array(
            'post_type'               => 'news',
            'orderby'                 => $order_by,
            'order'                   => $order,
            'offset'                  => $offset,
            'paged'                   => $paged,
            'tax_query'               => $tax_args,
            'post__not_in'            => array_filter( explode( ',', $exclude ) ),
            'post__in'                => array_filter( explode( ',', $include ) ),
            'post_status'             => 'publish',
            'posts_per_page'          => $num,
            'ignore_sticky_posts'     => 1,
            'include_posts__in'       => $include, // include posts in this liat
            'posts__not_in'           => $exclude, // exclude posts in this list
            'posts__in'               => $only_posts__in, // only posts in this list
            'exclude_without_media'   => $exclude_without_media,
        );

        // ---------------------------------------------------------------------

        // add the additional query args if available
        if( $wp_query_args ){
            $args = wp_parse_args( $args, $wp_query_args );
        }

        // pass the args through the auxin query parser
        $wp_query = new WP_Query( auxin_parse_query_args( $args ) );
    }

    // widget header ------------------------------
    echo $result['widget_header'];
    echo $result['widget_title'];

    $phone_break_point  = 767;
    $tablet_break_point = 1025;

    $show_comments      = true; // shows comments icon
    $post_counter       = !empty( $offset ) ? $offset : 0;
    $item_class         = 'aux-news-big-grid aux-image-box';
    $item_class 	   .= auxin_is_true( $title_limit ) ? ' aux-title-limit' : '';

    if( ! empty( $loadmore_type ) ) {
        $item_class        .= ' aux-ajax-item';
    }

    $container_class    = 'aux-big-grid-layout aux-ajax-view  ' . $big_grid_style;

    $have_posts = $wp_query->have_posts();

    if( $have_posts ){

        echo ! $skip_wrappers ? sprintf( '<div data-element-id="%s" class="%s">', esc_attr( $universal_id ), esc_attr( $container_class ) ) : '';

        while ( $wp_query->have_posts() ) {

            $wp_query->the_post();
            $post = $wp_query->post;

            $item_pattern_info = auxin_get_grid_pattern( $big_grid_style , $post_counter, $aux_content_width );
            $post_counter++;

            $post_vars = auxin_get_post_format_media(
                $post,
                array(
                    'request_from'    => 'archive',
                    'media_width'     => $phone_break_point,
                    'media_size'      => $item_pattern_info['size'],
                    'upscale_image'   => true,
                    'ignore_formats'  => array( '*' ),
                    'image_sizes'     => 'auto',
                    'srcset_sizes'    => 'auto'
                )
            );

            extract( $post_vars );

            $post_classes = $item_class .' '. $item_pattern_info['classname'];
            $tax_name     = 'news-category' ;

            $the_format = get_post_format( $post );

            include auxin_get_template_file( $template_part_file, '', $extra_template_path );
        }

        if( ! $skip_wrappers ) {
            // End tag for aux-ajax-view wrapper & Execute load more functionality
            echo '</div>' . auxin_get_load_more_controller( $loadmore_type );

        } else {
            // Get post counter in the query
            echo '<span class="aux-post-count hidden">'.$wp_query->post_count.'</span>';
            echo '<span class="aux-all-posts-count hidden">'.$wp_query->found_posts.'</span>';
        }

    }

    if( $reset_query ){
        wp_reset_query();
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
