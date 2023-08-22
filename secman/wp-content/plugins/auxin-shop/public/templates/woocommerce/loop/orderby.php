<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$orderby_slug = ! empty( $_GET['orderby'] ) ? $_GET['orderby'] : '';
$orderby_name = __( 'Default', 'auxin-shop' );

if( ! empty( $orderby_slug ) ) {
	foreach ( $catalog_orderby_options as $slug => $name ){
		if( $slug === $orderby_slug ){
			$orderby_name = $name;
			break;
		}
	}
}

$extra_classes = auxin_is_true( auxin_get_option('product_index_sort_dropdown_modern_skin', 'no') ) ? ' aux-has-arrow aux-sort-filter aux-sort-shop-page' : '';
?>

<div class="woocommerce-ordering aux-filters aux-dropdown-filter aux-right<?php echo esc_attr( $extra_classes ); ?>">
	<span class="aux-filter-by"><?php esc_html_e( 'Sort By:', 'auxin-shop' ); ?>
		<span class="aux-filter-name">
			<span class="aux-filter-name-current"><?php echo $orderby_name; ?></span>
			<i class="aux-indicator auxicon-chevron-down-1"></i>
		</span>
	</span>
    <ul>
		<?php foreach ( $catalog_orderby_options as $slug => $name ) { ?>
			<li class="aux-filter-item" <?php selected( $orderby_slug, $slug );?> >
				<a href="<?php echo add_query_arg( 'orderby', $slug );?>">
					<span><?php echo esc_html( $name ); ?></span>
				</a>
			</li>
		<?php } ?>
    </ul>
</div>
