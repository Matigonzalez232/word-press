<?php

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

// theme name
if( ! defined( 'THEME_NAME' ) ){
    $theme_data = wp_get_theme();
    define( 'THEME_NAME', $theme_data->Name );
}


define( 'AUXNEW_VERSION'        , '1.6.5' );

define( 'AUXNEW_SLUG'           , 'auxin-news' );


define( 'AUXNEW_DIR'            , dirname( plugin_dir_path( __FILE__ ) ) );
define( 'AUXNEW_URL'            , plugins_url( '', plugin_dir_path( __FILE__ ) ) );
define( 'AUXNEW_BASE_NAME'      , plugin_basename( AUXNEW_DIR ) . '/auxin-the-news.php' ); // auxin-the-newss/auxin-the-newss.php


define( 'AUXNEW_ADMIN_DIR'      , AUXNEW_DIR . '/admin' );
define( 'AUXNEW_ADMIN_URL'      , AUXNEW_URL . '/admin' );

define( 'AUXNEW_INC_DIR'        , AUXNEW_DIR . '/includes' );
define( 'AUXNEW_INC_URL'        , AUXNEW_URL . '/includes' );

define( 'AUXNEW_PUB_DIR'        , AUXNEW_DIR . '/public' );
define( 'AUXNEW_PUB_URL'        , AUXNEW_URL . '/public' );
