<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */


/**
 * Button markup has changed.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
    <?php
    /**
     * @since 3.0.0.
     */
    do_action( 'woocommerce_before_add_to_cart_quantity' );

    woocommerce_quantity_input( array(
        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
		'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
		'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
    ) );

    /**
     * @since 3.0.0.
     */
    do_action( 'woocommerce_after_add_to_cart_quantity' );
    ?>
	<button type="submit" class="auxshp-add-to-cart single_add_to_cart_button aux-button aux-exlarge aux-black aux-uppercase <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><span class="aux-overlay"></span><span class="aux-text"><?php echo esc_html( $product->single_add_to_cart_text() ); ?> </span></button>

    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    
	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
