<?php
/**
 * Template Name: News Blog
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */
get_header();
global $post;

// The list of content locations in blog page templates
$location_list = array(
    'above-full',       // Page builder content on above of template with full width
    'above-boxed',      // Page builder content on above of template with boxed width
    'above-in-frame',   // Page builder content right before template content
    'below-in-frame',   // Page builder content right after template content
    'below-boxed',      // Page builder content below template content with boxed width
    'below-full',       // Page builder content below template content with full width
    'none'              // Skip Page builder content
);

$page_content_location = auxin_get_post_meta( $post, 'aux_page_template_content_location', 'above-in-frame' );
if( ! in_array( $page_content_location, $location_list ) ){
    $page_content_location = 'above-in-frame';
}

// Get the page content
if( 'none' !== $page_content_location ){
    ob_start();
    the_content();
    $content = ob_get_clean();
} else {
    $content = '';
}

// Retrieve the content with corresponding wrappers
$the_content_markup = apply_filters( 'auxin_news_page_template_content_markup', '', $content, $page_content_location );

// Retrieve the content class name status
$the_content_class  = empty( $the_content_markup ) ? 'aux-content-empty' : 'aux-content-' .  $page_content_location;
?>
    <main id="main" <?php auxin_content_main_class( $the_content_class ); ?> >
        <div class="aux-wrapper">
            <?php if( in_array( $page_content_location, array( 'above-full', 'above-boxed' ) ) == $page_content_location ){ echo $the_content_markup; } ?>

            <div class="aux-container aux-fold clearfix">
                <div id="primary" class="aux-primary" >
                    <div class="content" role="main" data-target="archive">

                    <?php
                    echo auxin_get_the_archive_slider( 'post', 'content' );
                    if( 'above-in-frame' == $page_content_location ){ echo $the_content_markup; }

                    $args = array(
                        'title'                 => '',
                        'show_header'           => auxin_get_option( 'news_index_big_post_display', '1' ),
                        'show_filters'          => false,
                        'reset_query'           => true,
                        'show_image'            => auxin_get_option( 'news_index_post_image_display', '1' ),
                        'show_title'            => auxin_get_option( 'news_index_post_title_display', '1' ),
                        'show_info'             => auxin_get_option( 'news_index_post_info_display', '1' ),
                        'info_position'         => auxin_get_option( 'news_index_post_info_position', 'after_title' ),
                        'show_date'             => auxin_get_option( 'news_index_post_date_display', '1' ),
                        'show_author'           => auxin_get_option( 'news_index_post_author_display', '1' ),
                        'show_categories'       => auxin_get_option( 'news_index_post_category_display', '1' ),
                        'exclude_without_media' => auxin_get_option( 'news_index_post_exclude_no_media', false ),
                        'big_content'           => 55,
                        'content'               => 40,
                        'paged'                 => max( 1, get_query_var('paged'), get_query_var('page') ),
                        'reset_query'           => false,
                        'paginate'              => true,
                        'header_args'           => array(
                            'show_image'  => auxin_get_option( 'news_index_big_post_image_display', '1' ),
                            'inside_mode' => false
                        ),
                    );
   
                    // get the shortcode base portfolio page
                    echo auxin_news_element( $args );    
                    
                    auxin_the_paginate_nav(
                        array( 'css_class' => esc_attr( auxin_get_option('archive_pagination_skin') ) )
                    );                                        

                    if( 'below-in-frame' == $page_content_location ){ echo $the_content_markup; }
                    ?>
                    </div><!-- end content -->

                </div><!-- end primary -->

                <?php get_sidebar(); ?>

            </div><!-- end container -->
            <?php if( in_array( $page_content_location, array( 'below-full', 'below-boxed' ) ) == $page_content_location ){ echo $the_content_markup; } ?>

   
        </div><!-- end wrapper -->
    </main><!-- end main -->



<?php get_sidebar('footer'); ?>
<?php get_footer(); ?>