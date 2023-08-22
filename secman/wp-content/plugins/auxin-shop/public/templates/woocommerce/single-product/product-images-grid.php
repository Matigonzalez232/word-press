<?php
/**
 * Master Slider.
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    global $post, $woocommerce, $product;

    $attachments_ids    = $product->get_gallery_image_ids();
    $large_single_size  = apply_filters( 'single_product_large_single_size', 'shop_single' );
    $image_size         = wc_get_image_size( $large_single_size );
    $cols               = 2;
    $tcols              = 2;
    $mcols              = 1;

    if ( 'default' == $image_aspect_ratio = auxin_get_post_meta( $product->get_id(), '_product_image_aspect_ratio', 'default' ) ) {
        $image_aspect_ratio = auxin_get_option( 'product_image_aspect_ratio', 0.56 );
    }

    $crop               = true;
    $layout             = 'fitRows';

    if ( 'default' == $space = auxin_get_post_meta( $product->get_id(), '_product_grid_space', 'default' ) ) {
        $space = auxin_get_option( 'product_grid_space', 30 );
    }

    if ( 'default' == $cols = auxin_get_post_meta( $product->get_id(), '_product_grid_column_number', 'default' ) ) {
        $cols = auxin_get_option( 'product_grid_column_number', 4 );
    }

    $tcols = 'inherit' == auxin_get_post_meta( $product->get_id(), '_product_grid_column_number_tablet', 'default' ) ? $cols : auxin_get_post_meta( $product->get_id(), '_product_grid_column_number_tablet', 'default' );

    if ( 'default' == $tcols ) {

        $tcols = 'inherit' == auxin_get_option( 'product_grid_column_number_tablet' ) ? $cols : auxin_get_option( 'product_grid_column_number_tablet' );
    }


    if ( 'default' == $mcols = auxin_get_post_meta( $product->get_id(), '_product_grid_column_number_mobile', 'default' ) ) {
        $mcols = auxin_get_option( 'product_grid_column_number_mobile', 2 );
    }

    $column_media_width = auxin_get_content_column_width( $cols );
    $grid_classnames    = 'aux-de-col' . $cols . ' ' . 'aux-tb-col' . $tcols . ' ' . 'aux-mb-col' . $mcols ;

    if ( 'default' == $grid_type = auxin_get_post_meta( $product->get_id(), '_product_grid_template_type', 'default' ) ) {
        $grid_type = auxin_get_option( 'product_grid_template_type', 'grid' );
    }

    if ( 'masonry' == $grid_type ) {

        $image_aspect_ratio = 0;
        $crop = false;
        $layout = 'masonry';

    } else {
        $grid_classnames .= ' aux-match-height';
    }

    $grid_attr = 'data-lazyload="true" data-space="' . $space . '" data-pagination="false" data-deeplink="false" data-layout="'. $layout .'"';

    if ( 'default' == $lightbox_enabled = auxin_get_post_meta( $product->get_id(), '_product_single_lightbox_enabled', 'default' ) ) {
        $lightbox_enabled = auxin_get_option( 'product_single_lightbox_enabled', '1' );
    }

    if ( $attachments_ids ) : ?>

<div class="auxshp-product-grid auxshp-lightbox woocommerce-product-gallery">
    <div class="aux-isotope-layout aux-layout-grid aux-isotope-animated aux-no-gutter aux-row <?php echo esc_attr( $grid_classnames ); ?> clearfix" <?php echo $grid_attr; ?> >
        <div class="aux-items-loading">
            <div class="aux-loading-loop">
              <svg class="aux-circle" width="100%" height="100%" viewBox="0 0 42 42">
                <circle class="aux-stroke-bg" r="20" cx="21" cy="21" fill="none"></circle>
                <circle class="aux-progress" r="20" cx="21" cy="21" fill="none" transform="rotate(-90 21 21)"></circle>
              </svg>
            </div>
        </div>
    
    <?php
    foreach ( $attachments_ids as $image_id ) {

        if( ! $image_id ) continue;

        $image_primary_meta = wp_get_attachment_metadata( $image_id );

        $main_src           = wp_get_attachment_image_src( $image_id, 'full' );

        $lightbox_attrs     = 'data-elementor-open-lightbox="no" class="auxshp-lightbox-btn aux-hide-text" data-original-src="' . $main_src[0] . '" data-original-width="' . $image_primary_meta['width'] . '" data-original-height="' . $image_primary_meta['height'] . '" ' . 'data-caption="' . auxin_attachment_caption( $image_id ) . '"';

        $attachment_props = array(
                            'upscale'      => true,
                            'crop'         => $crop,
                            'add_hw'       => true, // whether add width and height attr or not
                            'attr'         => array(
                                                'class'                   => 'wp-post-image',
                                                'data-original-width'     => $image_primary_meta['width'],
                                                'data-original-height'    => $image_primary_meta['height'],
                                                'data-original-src'       => $main_src[0],
                                                ),
                            'media_size'         => array( 'width' => $column_media_width, 'height' => $column_media_width * $image_aspect_ratio ),
                            'image_sizes'  => array(
                                array( 'min' => '',      'max' => '767px', 'width' => round( 100 / $tcols ).'vw' ),
                                array( 'min' => '768px', 'max' => '1025px', 'width' => round( 100 / $mcols ).'vw' ),
                                array( 'min' => ''     , 'max' => '',      'width' => $column_media_width.'px' )
                            ),
                            'srcset_sizes' => array(
                                array( 'width' =>     $column_media_width, 'height' =>     $column_media_width * $image_aspect_ratio ),
                                array( 'width' => 2 * $column_media_width, 'height' => 2 * $column_media_width * $image_aspect_ratio ),
                                array( 'width' => 4 * $column_media_width, 'height' => 4 * $column_media_width * $image_aspect_ratio )
                            )
                        ); ?>
        <div class="aux-iso-item aux-loading aux-col">

            <figure class="auxin-attachment woocommerce-product-gallery__image">
                <?php if ( auxin_is_true( $lightbox_enabled ) ) : ?>
                    <a href="<?php echo $main_src[0]; ?>" <?php echo $lightbox_attrs; ?> >open</a>
                <?php endif; ?>
                <?php echo auxin_get_the_responsive_attachment( $image_id, $attachment_props ); ?>
            </figure>


        </div>
        <?php } ?>
    </div>
</div>

<?php endif; ?>
