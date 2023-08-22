<?php
/**
 * Auxin Quicklook Template
 *
 * Contains the markup for the quicklook feature
 *
 *
 * @author  Averta
 * @version 1
 */



function auxin_quicklook_template( $id , $type ){
    ob_start();

    global $product, $post;

    $post = get_post( $id );

    if ( 'simple' === $type ) {
         $product = new WC_Product( $id );
    } else if ( 'variable' === $type ){
        $product = new WC_Product_Variable( $id );
    } else if ( 'grouped' === $type ){
        $product = new WC_Product_Grouped( $id );
    } else if ( 'external' === $type ) {
        $product = new WC_Product_External( $id );
    }

    $attachment_ids = auxshp_get_gallery_image_ids($product);

    if ( ! $attachment_ids ) {
        $attachment_ids = array();
    }

    $image_count        = count( $attachment_ids );

    $attachment_args = array(
        'size'  => array(
            'width' => '500',
            'height' => '500',

        ),
        'preload_preview' => false
    );

    echo '<div class="aux-quicklook-image">';

    if ( 0 != $image_count ) {

        echo '<div class="aux-quicklook-carousel" data-navigation="perpage" data-loop="true" data-space="0" data-auto-height="false">';

            if ( $product->get_image_id() ) {
                echo '<div class="aux-mc-item">';
                    echo auxin_get_the_responsive_attachment( $product->get_image_id(), $attachment_args);
                echo '</div>';
            }
            
            foreach( $attachment_ids as $attachment_id ){
                echo '<div class="aux-mc-item">';
                    echo auxin_get_the_responsive_attachment( $attachment_id, $attachment_args);
                echo '</div>';
            }

            echo '<div class="aux-carousel-controls">';
                echo '<div class="aux-next-arrow aux-arrow-nav"><button class="aux-arrow-nav-btn" type="button"><i class="auxicon-chevron-right-2"></i></button></div>';
                echo '<div class="aux-prev-arrow aux-arrow-nav"><button class="aux-arrow-nav-btn" type="button"><i class="auxicon-chevron-left-2"></i></button></div>';
            echo '</div>';

        echo '</div>';

    } else {
        echo '<div class="aux-quicklook-featured-img">';
            echo auxin_get_the_responsive_attachment( get_post_thumbnail_id( $product->get_id() ), $attachment_args);
        echo '</div>';
    }

    echo '</div>';

    echo '<div class="aux-quicklook-summary aux-quicklook-summary-' . esc_html($type) . '">';
        do_action( 'quicklook_product_summary' );

    echo '</div>';

    echo '<div class="aux-quicklook-end-bar">';

        echo sprintf( '<a class="%s" href="%s">%s</a>', 'aux-quicklook-more-link', esc_url( $product->get_permalink() ), __( 'More Information', 'auxin-shop' ) );

        auxshp_template_single_wishlist_share();
        do_action( 'quicklook_after_product_summary' );

    echo '</div>';

    return ob_get_clean();
}
