<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$custom_result = auxin_is_true( auxin_get_option('product_index_custom_result', '0') );
$first = ( $per_page * $current ) - $per_page + 1;
$last  = min( $total, $per_page * $current );

if ( $custom_result ) { 
	$text = auxin_get_option('product_index_custom_result_input', '');
	$replace = array(
		'{{TOTAL}}' => '<span class="total">' . $total . '</span>',
		'{{FIRST}}' => '<span class="first">' . $first . '</span>',
		'{{LAST}}'	=> '<span class="last">' . $total . '</span>',
	);
	$output =  strtr( $text, $replace );
?>
	<p class="woocommerce-result-count"><?php echo $output;?></p>
<?php } else { ?>
	<p class="woocommerce-result-count">
		<?php
		// phpcs:disable WordPress.Security
		if ( 1 === intval( $total ) ) {
			_e( 'Showing the single result', 'auxin-shop' );
		} elseif ( $total <= $per_page || -1 === $per_page ) {
			/* translators: %d: total results */
			printf( _n( 'Showing all %d result', 'Showing all %d results', $total, 'auxin-shop' ), $total );
		} else {
			$first = ( $per_page * $current ) - $per_page + 1;
			$last  = min( $total, $per_page * $current );
			/* translators: 1: first result 2: last result 3: total results */
			printf( _nx( 'Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'auxin-shop' ), $first, $last, $total );
		}
		// phpcs:enable WordPress.Security
		?>
	</p>
<?php } ?>
