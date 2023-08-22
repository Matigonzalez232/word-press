<?php
/**
 * Master Slider Admin Scripts Class.
 *
 * @
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

/**
 *  Class to load and print master slider panel scripts
 */
class AUXNEW_Admin_Assets {


  /**
   * __construct
   */
  function __construct() {
        // general assets
        $this->load_styles();
        $this->load_scripts();
  }


  /**
   * Styles for admin
   *
   * @return void
   */
  public function load_styles() {
    // wp_enqueue_style( AUXNEW_SLUG .'-admin-styles',   AUXNEW_ADMIN_URL . '/assets/css/msp-general.css',  array(), AUXNEW_VERSION );
  }

    /**
     * Scripts for admin
     *
     * @return void
     */
  public function load_scripts() {
    //wp_enqueue_script( AUXNEW_SLUG .'-admin-scripts', AUXNEW_ADMIN_URL . '/assets/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-dialog'), AUXNEW_VERSION, true );
  }

}
