<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Recent Reviews Widget.
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */
class AUXSHP_WC_Widget_Recent_Reviews extends WC_Widget_Recent_Reviews {

  /**
   * Output widget.
   *
   * @see WP_Widget
   *
   * @param array $args
   * @param array $instance
   */
  
   public function widget( $args, $instance ) {
    global $comments, $comment;

    if ( $this->get_cached_widget( $args ) ) {
      return;
    }

    ob_start();

    $number   = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
    $comments = get_comments( array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'product', 'parent' => 0 ) );

    if ( $comments ) {
      $this->widget_start( $args, $instance );

      echo '<ul class="product_list_widget">';

      foreach ( (array) $comments as $comment ) {

        $_product = wc_get_product( $comment->comment_post_ID );

        $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

        $rating_html = wc_get_rating_html( $rating );
        ?>
        <li>
        <div class="auxshp-card-items">
          <a class="auxshp-card-items-img" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) );?>">  <?php echo $_product->get_image();?>          
          </a>
          <div class="auxshp-card-items-info">
            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) );?>"><?php echo wp_kses_post( $_product->get_name() );?></a>
              <?php echo $rating_html;?>
              <span class="reviewer"><?php echo sprintf( esc_html__( 'by %s', 'auxin-shop' ), get_comment_author() );?></span>
          </div>
        </div>
        </li>
        <?php
      }

      echo '</ul>';

      $this->widget_end( $args );
    }

    $content = ob_get_clean();

    echo $content;

    $this->cache_widget( $args, $content );
  }
}
