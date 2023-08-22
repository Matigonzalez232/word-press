<?php

class AUXSHP_Wishlist {

    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance  = null;

    function __construct() {

        add_action( 'wp_ajax_auxshp_wishlist_add',    array( $this, 'add'    ) );
        add_action( 'wp_ajax_auxshp_wishlist_remove', array( $this, 'remove' ) );

        add_action( 'wp_ajax_nopriv_auxshp_wishlist_add',    array( $this, 'add'    ) );
        add_action( 'wp_ajax_nopriv_auxshp_wishlist_remove', array( $this, 'remove' ) );

        add_action( 'auxshp_activated',   array( $this, 'init' ), 10 );
        add_action( 'auxshp_deactivated', array( $this, 'deactivate' ), 10 );

        add_shortcode( 'auxshp-wishlist-page', array( $this, 'shortcode' ) );

        add_filter( 'template_include', array( $this, 'load_template' ), 99 );

    }


    public function init() {

        $wishlist_page_id = get_option( 'auxshp_wishlist_page' );

        if ( $wishlist_page_id ) {

            $page_data = array(
                    'ID' => $wishlist_page_id,
                    'post_status'       => 'publish',
                );
            wp_update_post( $page_data );

        } else {


            $page_data = array(
                'post_status'       => 'publish',
                'post_type'         => 'page',
                'post_title'        => __( 'Wishlist', 'auxin-shop' ),
                'post_content'      => '[auxshp-wishlist-page]',
                'post_parent'       => 0,
                'comment_status'    => 'closed'
            );

            $page_id = wp_insert_post( $page_data );

            update_option( 'auxshp_wishlist_page', $page_id );

        }

    }


    public function add() {

        $product_id = absint( $_POST['product_id'] );

        if ( empty( $product_id ) || ! wp_verify_nonce( $_POST['verify_nonce'], 'remove_wishlist-' . $product_id ) ) wp_die();

        if ( is_user_logged_in() ) {

            $wishlist = $this->user_wishlist();
            $wishlist[$product_id] = current_time( 'mysql' );
            $status     = update_user_meta( get_current_user_id(), 'auxshp_wishlist_items', array_unique( array_filter( $wishlist ) ) );

            if ( $status ) {
                wp_send_json_success( array( 'status' => __( 'Remove from wishlist', 'auxin-shop' ), 'message' => '' ) );
            }

            wp_send_json_error( array( 'status' => __( 'Sorry! An error accrued', 'auxin-shop' ), 'message' => '' ) );

        }


        $wishlist = $this->cookie_wishlist();
        $wishlist[$product_id] = time();

        $cookie_status = setcookie( 'auxshp_wishlist_items', serialize( array_unique( $wishlist ) ), time() + 90 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );

        if ( $cookie_status ) {
            wp_send_json_success( array( 'status' => __( 'Remove from wishlist', 'auxin-shop' ), 'message' => '' ) );
        }

        wp_send_json_error( array( 'status' => __( 'Sorry! An error accrued', 'auxin-shop' ), 'message' => '' ) );

    }


    public function remove() {

        $product_id = absint( $_POST['product_id'] );

        if ( empty( $product_id ) || ! wp_verify_nonce( $_POST['verify_nonce'], 'remove_wishlist-' . $product_id ) ) wp_die();

        if ( is_user_logged_in() ) {

            $wishlist = $this->user_wishlist();

            if( $wishlist[$product_id] ) {
                unset( $wishlist[$product_id] );
            }

            $status = update_user_meta( get_current_user_id(), 'auxshp_wishlist_items', array_filter( $wishlist ) );

            if ( $status ) {
                wp_send_json_success( array( 'status' => __( 'Add to wishlist', 'auxin-shop' ), 'message' => '<div class="aux-row auxshp-wishlist-container aux-text-align-center">' . __( 'Your wishlist is empty.', 'auxin-shop' ) . '</div>' ) );
            }

            wp_send_json_error( array( 'status' => __( 'Sorry! An error accrued', 'auxin-shop' ), 'message' => '' ) );

        }

        $wishlist = $this->cookie_wishlist();

        if( $wishlist[$product_id] ) {
            unset( $wishlist[$product_id] );
        }

        $cookie_status = setcookie( 'auxshp_wishlist_items', serialize( $wishlist ), time() + 90 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );

        if ( $cookie_status ) {
            wp_send_json_success( array( 'status' => __( 'Add to wishlist', 'auxin-shop' ), 'message' => '<div class="aux-row auxshp-wishlist-container aux-text-align-center">' . __( 'Your wishlist is empty.', 'auxin-shop' ) . '</div>' ) );
        }

        wp_send_json_error( array( 'status' => __( 'Sorry! An error accrued', 'auxin-shop' ), 'message' => '' ) );


    }


    public function user_wishlist() {

        $wishlist = get_user_meta( get_current_user_id(), 'auxshp_wishlist_items', true );

        return is_array( $wishlist ) ? $wishlist : array( $wishlist );

    }


    public function cookie_wishlist() {

        $wishlist = isset($_COOKIE['auxshp_wishlist_items']) ? $_COOKIE['auxshp_wishlist_items'] : '' ;

        $wishlist = unserialize($wishlist);

        return is_array( $wishlist ) ? $wishlist : array( $wishlist );

    }


    public function wishlist_count() {

        if ( is_user_logged_in() ) {
            return sizeof( $this->user_wishlist() );
        }

        return sizeof( $this->cookie_wishlist() );

    }


    public function in_wishlist( $item ) {

        $wishlist = is_user_logged_in() ? $this->user_wishlist() : $this->cookie_wishlist();

        if ( array_key_exists( $item , $wishlist ) ) {
            return true;
        }

        return false;

    }


    public function shortcode( $atts ) {

        if ( is_admin() || auxin_is_true( auxin_get_option( 'product_wishlist_use_ti_plugin', false ) ) ) {
            return;
        }

        $atts = shortcode_atts( array(), $atts, 'auxshp-wishlist-page' );

        if ( is_user_logged_in() ) {
            $wishlist = $this->user_wishlist();
        } else {
            $wishlist = $this->cookie_wishlist();
        }

        //check empty wishlist status
        if( empty( $wishlist ) ){
            echo '<div class="aux-row auxshp-wishlist-container aux-text-align-center">' . __( 'Your wishlist is empty.', 'auxin-shop' ) . '</div>';
            return;
        }

?>

<div class="aux-row auxshp-wishlist-container">
    <div class="aux-shop-table-outline">
        <table class="aux-shop-table" cellspacing="0">
            <thead>
                <tr>
                    <th class="product-remove">&nbsp;</th>
                    <th class="product-name"><?php _e( 'Product', 'auxin-shop' ); ?></th>
                    <th>&nbsp;</th>
                    <th class="product-price"><?php _e( 'Price', 'auxin-shop' ); ?></th>
                    <th class="product-status"><?php _e( 'Stock Status', 'auxin-shop' ); ?></th>
                    <th class="product-add-to-cart">&nbsp;</th>
                </tr>
            </thead>
            <tbody>

<?php

        foreach ( $wishlist as $id => $date ) {
            $_product = wc_get_product( $id );

            if ( $_product && $_product->exists() ) :
                $product_permalink = $_product->get_permalink();
?>
                <tr>

                    <td class="product-remove">
                        <a href="#" class="auxshp-wishlist auxshp-is-page available-remove remove" data-auxshp-verify_nonce="<?php echo wp_create_nonce( 'remove_wishlist-' . $id ); ?>" data-auxshp-product_id="<?php echo esc_attr( $id ); ?>"><span class="aux-svg-symbol aux-medium-cross"></span></a>
                    </td>

                    <td class="product-thumbnail">
                        <?php
                            $thumbnail = $_product->get_image('thumbnail');

                            if ( ! $product_permalink ) {
                                echo $thumbnail;
                            } else {
                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                            }
                        ?>
                    </td>

                    <td style="width: 32em" class="product-name">
                        <?php
                            if ( ! $product_permalink ) {
                                echo $_product->get_name();
                            } else {
                                echo sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() );
                            }
                        ?>
                    </td>

                    <td class="product-price">
                        <?php
                            echo '<span>' . $_product->get_price_html() . '</span>';
                        ?>
                    </td>

                    <td class="product-status">
                        <?php
                            if ( $_product->is_in_stock() ) {
                                echo '<span class="in-stock" >' . __( ' In Stock', 'envy' ) . '</span>';
                            } else {
                                echo '<span class="out-of-stock" >' . __( 'Out of Stock', 'envy' ) . '</span>';
                            }
                        ?>
                    </td>

                    <td class="product-add-to-cart">
                        <?php
                            echo '<form class="cart" method="post" enctype="multipart/form-data"><button type="submit" name="add-to-cart" value="'. $id .'" class="auxshp-add-to-cart single_add_to_cart_button aux-button aux-exlarge aux-black aux-uppercase"><span class="aux-overlay"></span><span class="aux-text">Add to cart </span></button></form>';
                        ?>
                    </td>

                </tr>
<?php
            endif;
        }
?>
            </tbody>
        </table>
    </div>
</div>

<?php

    }


    public function deactivate() {

        $page_data = array(
                'ID' => get_option( 'auxshp_wishlist_page', 0 ),
                'post_status'       => 'draft',
            );
        wp_update_post( $page_data );

    }


    public function load_template( $template ) {

         global $post;

         if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, '[auxshp-wishlist-page]') ) {

             $new_template = locate_template( array( '' ) );

             if ( '' != $new_template ) {
                 return $new_template ;
             }

         }

         return $template;

    }


    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

}


global $auxshp_wishlist;

$auxshp_wishlist = AUXSHP_Wishlist::get_instance();
