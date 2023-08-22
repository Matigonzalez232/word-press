<?php
/**
 * Defining main constants for plugin
 *
 * 
 * @package    
 * @license    LICENSE.txt
 * @author     averta <info@averta.net>
 * @link       https://bitbucket.org/averta/
 * @copyright  (c) 2010-2023 averta <info@averta.net>
 *
 */

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

// theme name
if( ! defined( 'THEME_NAME' ) ){
    $theme_data = wp_get_theme();
    define( 'THEME_NAME', $theme_data->Name );
}


define( 'AUXSHP_VERSION'        , '2.0.0' );

define( 'AUXSHP_SLUG'           , 'auxin-shop' );
define( 'AUXSHP_TEXT_DOMAIN'    , 'auxin-shop' );


define( 'AUXSHP_DIR'            , dirname( plugin_dir_path( __FILE__ ) ) );
define( 'AUXSHP_URL'            , plugins_url( '', plugin_dir_path( __FILE__ ) ) );
define( 'AUXSHP_BASE_NAME'      , plugin_basename( AUXSHP_DIR ) . '/auxin-shop.php' ); // auxin-shop/auxin-shop.php


define( 'AUXSHP_ADMIN_DIR'      , AUXSHP_DIR . '/admin' );
define( 'AUXSHP_ADMIN_URL'      , AUXSHP_URL . '/admin' );

define( 'AUXSHP_INC_DIR'        , AUXSHP_DIR . '/includes' );
define( 'AUXSHP_INC_URL'        , AUXSHP_URL . '/includes' );

define( 'AUXSHP_PUB_DIR'        , AUXSHP_DIR . '/public' );
define( 'AUXSHP_PUB_URL'        , AUXSHP_URL . '/public' );
