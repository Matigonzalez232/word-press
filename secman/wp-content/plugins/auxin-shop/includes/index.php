<?php
// General functions
include_once( 'general-functions.php' );
// Reorder hooks in WooCommerce
include_once( 'general-hooks.php' );
// Reorder hooks in WooCommerce
include_once( 'woo-hooks.php' );
// Hook in WooCommerce
include_once( 'woo-functions.php' );
// Ajax functions for plugin functionality (e.g. wishlist)
include_once( 'auxshp-ajax.php' );

include_once( 'classes/wishlist/class-auxshp-wishlist.php' );
include_once( 'classes/wishlist/class-auxshp-yiwl-importer.php' );


// load elements
include_once( 'elements/recent-products-carousel.php' );
include_once( 'elements/products-parallax.php' );
include_once( 'elements/advanced-recent-products.php' );

include_once( 'elements/elementor/class-auxshp-elementor-elements.php' );
