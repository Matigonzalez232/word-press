<?php
/**
 * Load general functions, hooks and shortcodes
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */

// commeon functions
include_once( 'general-functions.php' );
include_once( 'general-hooks.php' );

// load shortcode files
include_once( 'general-shortcodes.php' );
include_once( 'classes/class-auxnew-template-loader.php' );

// load elements
include_once( 'elements/recent-news.php' );
include_once( 'elements/recent-news-grid.php' );
include_once( 'elements/recent-news-big-grid.php' );

// load elementor widgets
include_once( 'elements/elementor/class-auxnew-elementor-elements.php' );