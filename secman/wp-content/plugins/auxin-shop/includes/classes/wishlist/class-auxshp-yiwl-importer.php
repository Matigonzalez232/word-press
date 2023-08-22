<?php 

class AUXSHP_YIWL_Importer {

    function __construct() {

        $yiwl_db_version = get_option( 'yith_wcwl_db_version', 0 );

        if ( version_compare( $yiwl_db_version ,  '2.0.0', '<' ) || 'yes' === get_option( '', 'no' ) ) {
            return;
        }

        $this->update_options();
        $this->integrate();

    }


    public function update_options() {

        $price_show          = get_option( 'yith_wcwl_price_show',               'yes' );
        $remove_after_add    = get_option( 'yith_wcwl_remove_after_add_to_cart', 'yes' );
        $date_show           = get_option( 'yith_wcwl_show_dateadded',           'yes' );
        $stock_show          = get_option( 'yith_wcwl_stock_show',               'yes' );

        auxin_update_option( 'auxshp_wl_show_price',       $price_show );
        auxin_update_option( 'auxshp_wl_remove_after_add', $remove_after_add );
        auxin_update_option( 'auxshp_wl_date_show',        $price_show );
        auxin_update_option( 'auxshp_wl_stock_show',       $price_show );

    }


    public function get_wishlist_data() {

        global $wpdb;

        $prefix = $wpdb->prefix;

        $table = $prefix . 'yith_wcwl';

        $query = "SELECT user_id, prod_id, dateadded FROM $table";

        return $wpdb->get_results( $query, ARRAY_A );
    }


    public function integrate() {

        $yiwl_data = $this->get_wishlist_data();

        $all_data = array();

        if ( is_array( $yiwl_data ) && ! empty( $yiwl_data ) ) {
            
            foreach ( $yiwl_data as $index => $data_arr ) {

                $all_data[$data_arr['user_id']][$data_arr['prod_id']] = $data_arr['dateadded'];

            }

        }

        foreach ( $all_data as $user_id => $metadata ) {

            $meta = get_user_meta( $user_id, 'auxshp_wishlist_items', true );
            $meta = !empty( $meta ) ? $meta : [];
            update_user_meta( $user_id, 'auxshp_wishlist_items', array_filter( array_merge( $meta, $metadata ) ) );

        }

    }


}


function auxshp_yiwl_importer_caller() {
    return new AUXSHP_YIWL_Importer;
}

add_action( 'auxshp_activated', 'auxshp_yiwl_importer_caller', 10 );