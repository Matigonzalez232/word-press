<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

/*
** Auxin Changes:

* Added auxin grid system with our default class names
*/


do_action( 'woocommerce_before_cart' ); ?>

<div class="aux-row">
	<div class="aux-4-6 aux-tb-1 aux-mb-1">
		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>
			<h2><?php _e( 'Shopping bag', 'auxin-shop' ); ?></h2>
			<div class="aux-shop-table-outline">

				<table class="aux-shop-table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
					<thead>
						<tr>
							<th class="product-remove">&nbsp;</th>
							<th class="product-name"><?php _e( 'Product', 'auxin-shop' ); ?></th>
							<th class="product-thumbnail">&nbsp;</th>
							<th class="product-price"><?php _e( 'Price', 'auxin-shop' ); ?></th>
							<th class="product-quantity"><?php _e( 'Quantity', 'auxin-shop' ); ?></th>
							<th class="product-subtotal"><?php _e( 'Subtotal', 'auxin-shop' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php do_action( 'woocommerce_before_cart_contents' ); ?>

						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							/**
							 * Filter the product name.
							 *
							 * @since 7.8.0
							 * @param string $product_name Name of the product in the cart.
							 */
							$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>
								<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

									<td class="product-remove">
										<?php
											// @codingStandardsIgnoreLine
											echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
												'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
												esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
												/* translators: %s is the product name */
												esc_attr( sprintf( __( 'Remove %s from cart', 'auxin-shop' ), $product_name ) ),
												esc_attr( $product_id ),
												esc_attr( $_product->get_sku() )
											), $cart_item_key );
										?>
									</td>

									<td class="product-thumbnail">
										<?php
											$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key );

											if ( ! $product_permalink ) {
												echo $thumbnail; // PHPCS: XSS ok.
											} else {
												printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
											}
										?>
									</td>

									<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'auxin-shop' ); ?>">
										<?php
											if ( ! $product_permalink ) {
												/**
												 * Filter the product name.
												 *
												 * @since 7.8.0
												 * @param string $product_name Name of the product in the cart.
												 * @param array $cart_item The product in the cart.
												 * @param string $cart_item_key Key for the product in the cart.
												 */
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $product_name, $cart_item, $cart_item_key ) . '&nbsp;' );
											} else {
												/**
												 * Filter the product name.
												 *
												 * @since 7.8.0
												 * @param string $product_url URL the product in the cart.
												 */
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $product_name ), $cart_item, $cart_item_key ) );
											}

											do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
											// Meta data.
											echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok. 

											// Backorder notification
											if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'auxin-shop' ) . '</p>', $product_id ) );
											}
										?>
									</td>

									<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'auxin-shop' ); ?>">
										<?php
											echo '<b>' . apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) . '</b>';
										?>
									</td>

									<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'auxin-shop' ); ?>">
										<?php
											if ( $_product->is_sold_individually() ) {
												$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
											} else {
												$product_quantity = woocommerce_quantity_input( array(
													'input_name'  => "cart[{$cart_item_key}][qty]",
													'input_value' => $cart_item['quantity'],
													'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
													'min_value'   => '0',
													'product_name' => $product_name,
												), $_product, false );
											}

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
										?>
									</td>

									<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'auxin-shop' ); ?>">
										<?php
											echo '<b>' . apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) . '</b>';
										?>
									</td>

								</tr>
								<?php
							}
						}
						?>

						<?php do_action( 'woocommerce_cart_contents' ); ?>

					</tbody>
				</table>

			</div>
			<div class="aux-row aux-cart-buttons">
				<div class="aux-3-5 aux-mb-1">
					<div class="coupon">
					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="aux-input-group">
						<input type="text" name="coupon_code" class="aux-input-text aux-large aux-fill" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'auxin-shop' ); ?>" />
						<input type="submit" class="button  aux-button aux-large aux-uppercase aux-dark-gray <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'auxin-shop' ); ?>" />
						</div>
						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					<?php } ?>
					</div>
				</div>
				<div class="aux-2-5 aux-mb-1">
					<input type="submit" class="button right aux-button aux-large aux-outline aux-tower-gray aux-uppercase <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'auxin-shop' ); ?>" />
				</div>
			</div>

			<?php do_action( 'woocommerce_cart_actions' ); ?>

			<?php wp_nonce_field( 'woocommerce-cart' ); ?>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>

			<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</form>
	</div>
	<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

	<div class="cart-collaterals aux-2-6 aux-tb-1 aux-mb-1">
		<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
		?>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
