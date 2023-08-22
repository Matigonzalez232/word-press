<?php
/**
 * Admin Ajax handlers
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */

function auxin_news_ajax_filter_get_content() {

    // Check nonce
    if ( ! isset( $_POST['n'] ) || ! wp_verify_nonce( $_POST['n'], 'aux_ajax_filter_request' ) ) {
        wp_send_json_error( 'Nonce check failed!', 403 );
    }

    $args = auxin_sanitize_input( $_POST['args'] );
    $args['cat'] = ( 'all' === $_POST['term'] ) ? '' : sanitize_text_field( $_POST['term'] );
    $args['show_filters']  = false;
    $args['header_args']['inside_mode']  = false;
    global $aux_content_width;
    $aux_content_width = $args['content_width'];

    include AUXNEW_PUB_DIR . '/includes/templates-news.php';
    echo auxin_news_element( $args );
    exit();

}

add_action( 'wp_ajax_news_filter_get_content', 'auxin_news_ajax_filter_get_content' );
add_action( 'wp_ajax_nopriv_news_filter_get_content', 'auxin_news_ajax_filter_get_content' );