<?php
/**
 * Load admin related classes & functions
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */

// load admin related functions
include_once( 'admin-the-functions.php' );


do_action( 'auxnew_admin_functions_loaded' );

// load compatibility files
include_once( 'compatibility/wpml/translate.php' );

// load admin related functions
include_once( 'admin-hooks.php' );

// load metaboxes
include_once( 'metaboxes/index.php' );
