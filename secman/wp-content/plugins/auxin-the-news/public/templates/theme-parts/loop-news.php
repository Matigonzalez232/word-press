<?php
/**
 * Loops through all posts, taxes, .. and display posts
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */

// get template type id
$template_type_id = auxin_get_option( 'news_index_template_type', 'news-default' );
// get template type
$template_type    = strstr( $template_type_id, '-', true );

// A temporary condition that will change to the type of templates in the future
if( function_exists( 'auxin_widget_recent_news_callback' ) ){
	$args = array(
		'title'                 => '',
		'show_header'           => auxin_get_option( 'news_index_big_post_display', '1' ),
		'show_filters'          => false,
		'column_media_count'    => 2,
		'author_or_readmore'    => auxin_get_option( 'news_index_post_author_or_readmore', 'none' ),
		'num'                   => get_option( 'posts_per_page' ),
		'show_image'            => auxin_get_option( 'news_index_post_image_display', '1' ),
		'show_title'            => auxin_get_option( 'news_index_post_title_display', '1' ),
		'show_info'             => auxin_get_option( 'news_index_post_info_display', '1' ),
		'info_position'         => auxin_get_option( 'news_index_post_info_position', 'after_title' ),
		'show_date'             => auxin_get_option( 'news_index_post_date_display', '1' ),
		'show_author'           => auxin_get_option( 'news_index_post_author_display', '1' ),
		'show_categories'       => auxin_get_option( 'news_index_post_category_display', '1' ),
		'exclude_without_media' => auxin_get_option( 'news_index_post_exclude_no_media', false ),
		'paged'                 => max( 1, get_query_var('paged'), get_query_var('page') ), // 'paged' for archive pages and 'page' for single pages
		'use_wp_query'          => true,
		'header_args'           => array(
			'show_image'  => auxin_get_option( 'news_index_big_post_image_display', '1' ),
			'inside_mode' => false
	    ),
	);

	if ( 'news-1' === $template_type_id ) {
	    $args['header_args']['inside_mode'] = true;
	}
    // get the shortcode base portfolio page
    $result = auxin_news_element( $args );
} else {
    global $query_string;

    $pere_page = auxin_get_option( 'portfolio_archive_items_perpage', 12 );
    $q_args = '&paged='. $paged. '&posts_per_page='. $pere_page;
    // query the posts
    query_posts( $query_string . $q_args );
    // does this query has result?
    $result = have_posts();
}

// if it is not a shortcode base news layout
if( true === $result ){
    while ( have_posts() ) : the_post();
        auxnew_get_template_part( 'theme-parts/entry/news' );
    endwhile; // end of the loop.

// if it is a shortcode base news layout
} elseif( false !== $result && '' !== $result ){
    echo $result;

// if result not found
} else {
    include locate_template( 'templates/theme-parts/content-none.php' );
}

auxin_the_paginate_nav(
    array( 'css_class' => esc_attr( auxin_get_option('archive_pagination_skin') ) )
);
