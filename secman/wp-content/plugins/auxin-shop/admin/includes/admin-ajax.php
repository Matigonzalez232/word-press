<?php
/**
 * Admin Ajax handlers
 *
 * 
 * @package    
 * @license    LICENSE.txt
 * @author     averta <info@averta.net>
 * @link       https://bitbucket.org/averta/
 * @copyright  (c) 2010-2023 averta <info@averta.net>
 */

function auxin_advanced_recent_products_ajax_handler() {

    // Check nonce
    if ( ! isset( $_POST['n'] ) || ! wp_verify_nonce( $_POST['n'], 'aux_ajax_filterable_product' ) ) {
        wp_send_json_error( 'Nonce check failed!', 403 );
    }
    
    $args = auxin_sanitize_input( $_POST['args'] );

    if ( isset( $_POST['term'] ) && $_POST['term'] != 'all' ) {
        $args['terms'] = sanitize_text_field( $_POST['term'] );
    }

    if ( isset( $_POST['taxonomy'] ) ){
        $args['taxonomy'] = sanitize_text_field( $_POST['taxonomy'] );
    }

    if ( isset( $_POST['paged'] ) ){
        $args['paged'] = sanitize_text_field( $_POST['paged'] );
    }
    
    if( isset( $_POST['sort'] ) ) {

        $sort_type = $_POST['sort'];

        if ( ! empty ( $sort_type ) ) {
            
            switch( $sort_type ) {
                case 'date':
                    $args['order_by'] = 'date ID';
                    $args['order']   = 'DESC';
                    break;
                case 'popularity':
                    $args['order_by'] = 'meta_value_num';
                    $args['meta_key'] = 'total_sales';
                    $args['order']   = 'DESC';
                    break;
                case 'rating':
                    $args['order_by'] = 'meta_value_num';
                    $args['meta_key'] = '_wc_average_rating';
                    $args['order']   = 'DESC';
                    break;
                case 'price':
                    $args['order_by'] = 'meta_value_num';
                    $args['meta_key'] = '_price';

                    if ( 'high' === $args['sortOrder'] ) {
                        $args['order']   = 'ASC';
                    } else {
                        $args['order']   = 'DESC';
                    }
                    break;
                default:
                    $args['order_by'] = 'date';
                    break;
            }

        }

    }


    include auxin_get_template_file( $args['template_part_file'], '', $args['extra_template_path'] );
    $output = auxin_advanced_recent_products( $args );
    wp_send_json_success($output);
    exit();


}

add_action( 'wp_ajax_aux_advacned_recent_product_filter_content', 'auxin_advanced_recent_products_ajax_handler' );
add_action( 'wp_ajax_nopriv_aux_advacned_recent_product_filter_content', 'auxin_advanced_recent_products_ajax_handler' );


function auxin_quicklook_ajax_handler() {
    
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'aux-quicklook-' . $_POST['productID'] ) ) {
        wp_send_json_error( 'Nonce check failed!', 403 );
    }   

    include auxin_get_template_file( 'template-quicklook', '', AUXSHP_PUB_DIR . '/templates/elements' );
    $output = auxin_quicklook_template( absint( $_POST['productID'] ),  sanitize_text_field( $_POST['productType'] ) );
    wp_send_json_success($output);
    exit();
}

add_action( 'wp_ajax_aux_quick_look_content', 'auxin_quicklook_ajax_handler' );
add_action( 'wp_ajax_nopriv_aux_quick_look_content', 'auxin_quicklook_ajax_handler' );


function auxin_parallax_products_handler() {
    // Check nonce
    if ( ! isset( $_POST['n'] ) || ! wp_verify_nonce( $_POST['n'], 'aux_ajax_parallax_product' ) ) {
        wp_send_json_error( 'Nonce check failed!', 403 );
    }

    $args = auxin_sanitize_input( $_POST['args'] );

    if ( isset( $_POST['term'] ) && $_POST['term'] != 'all' ) {
        $args['terms'] = sanitize_text_field( $_POST['term'] );
    }
    $args['skip_wrapper'] = true;
    
    $output = auxin_widget_products_parallax_callback( $args );
    wp_send_json_success($output);
    exit();

}

add_action( 'wp_ajax_auxin_parallax_products_handler', 'auxin_parallax_products_handler' );
add_action( 'wp_ajax_nopriv_auxin_parallax_products_handler', 'auxin_parallax_products_handler' );