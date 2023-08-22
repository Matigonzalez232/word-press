<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Price Filter Widget and related functions.
 *
 * Generates a range slider to filter products by price.
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */
class AUXSHP_WC_Widget_Price_Filter extends WC_Widget_Price_Filter {

  /**
   * Output widget.
   *
   * @see WP_Widget
   *
   * @param array $args
   * @param array $instance
   */
  
  public function widget( $args, $instance ) {
    global $wp;

    if ( ! is_shop() && ! is_product_taxonomy() ) {
      return;
    }

    if ( ! wc()->query->get_main_query()->post_count ) {
      return;
    }

    wp_enqueue_script( 'wc-price-slider' );

    // Find min and max price in current result set.
    $prices = $this->get_filtered_price();
    $min    = floor( $prices->min_price );
    $max    = ceil( $prices->max_price );

    if ( $min === $max ) {
      return;
    }

    $this->widget_start( $args, $instance );

    if ( '' === get_option( 'permalink_structure' ) ) {
      $form_action = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
    } else {
      $form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
    }

    $min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : apply_filters( 'woocommerce_price_filter_widget_min_amount', $min );
    $max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : apply_filters( 'woocommerce_price_filter_widget_max_amount', $max );

    echo '<form method="get" action="' . esc_url( $form_action ) . '">
      <div class="price_slider_wrapper price_slider_amount">
        <div class="price_label" style="display:none;">
          <span class="from"></span><span class="to"></span>
        </div>
        <div class="price_slider" style="display:none;">
        </div>
        <div class="price_slider_amount">
          <input type="text" id="min_price" name="min_price" value="' . esc_attr( $min_price ) . '" data-min="' . esc_attr( apply_filters( 'woocommerce_price_filter_widget_min_amount', $min ) ) . '" placeholder="' . esc_attr__( 'Min price', 'auxin-shop' ) . '" />
          <input type="text" id="max_price" name="max_price" value="' . esc_attr( $max_price ) . '" data-max="' . esc_attr( apply_filters( 'woocommerce_price_filter_widget_max_amount', $max ) ) . '" placeholder="' . esc_attr__( 'Max price', 'auxin-shop' ) . '" />
          <button type="submit" class="button aux-button aux-large aux-black aux-uppercase aux-outline"><span class="aux-overlay"></span><span class="aux-text">' . esc_html__( 'Filter', 'auxin-shop' ) . '</span></button>
          ' . wc_query_string_form_fields( null, array( 'min_price', 'max_price' ), '', true ) . '
          <div class="clear"></div>
        </div>
      </div>
    </form>';

    $this->widget_end( $args );
  }

  /**
   * Get filtered min price for current products.
   * @return int
   */
  protected function get_filtered_price() {
    global $wpdb;

    $args       = wc()->query->get_main_query()->query_vars;
    $tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
    $meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

    if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
      $tax_query[] = array(
        'taxonomy' => $args['taxonomy'],
        'terms'    => array( $args['term'] ),
        'field'    => 'slug',
      );
    }

    foreach ( $meta_query + $tax_query as $key => $query ) {
      if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
        unset( $meta_query[ $key ] );
      }
    }

    $meta_query = new WP_Meta_Query( $meta_query );
    $tax_query  = new WP_Tax_Query( $tax_query );

    $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
    $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

    $sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
    $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
    $sql .= "   WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
          AND {$wpdb->posts}.post_status = 'publish'
          AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
          AND price_meta.meta_value > '' ";
    $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

    if ( $search = WC_Query::get_main_search_query_sql() ) {
      $sql .= ' AND ' . $search;
    }

    return $wpdb->get_row( $sql );
  }
}
