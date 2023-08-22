<?php
/**
 * Load frontend scripts and styles
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */

/**
* Constructor
*/
class AUXNEW_Frontend_Assets {


	/**
	 * Construct
	 */
	public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'load_assets'  ) );
	}

    /**
     * Styles for admin
     *
     * @return void
     */
    public function load_assets() {
        wp_enqueue_style( AUXNEW_SLUG . '-main', get_template_directory_uri() . '/css/news.css', array(), AUXNEW_VERSION, 'all' );
        wp_enqueue_script( AUXNEW_SLUG .'-main', AUXNEW_PUB_URL . '/assets/js/news.js', array( 'jquery' ), AUXNEW_VERSION, true );
        wp_localize_script( AUXNEW_SLUG .'-main', 'auxnew', array(
                'ajax_url'          => admin_url( 'admin-ajax.php' )
            )
        );
    }

}
return new AUXNEW_Frontend_Assets();





