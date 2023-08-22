<?php
/**
 * Admin Hooks
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */
/**
 * Triggers an action after plugin was updated to new version.
 *
 * @return void
 */
function auxnew_after_plugin_update(){
    if( AUXNEW_VERSION !== get_transient( 'auxin_' . AUXNEW_SLUG . '_version' ) ){
        set_transient( 'auxin_' . AUXNEW_SLUG . '_version', AUXNEW_VERSION, MONTH_IN_SECONDS );

        do_action( 'auxin_plugin_updated', true, AUXNEW_SLUG, AUXNEW_VERSION, AUXNEW_BASE_NAME );
    }
}
add_action( "admin_init", "auxnew_after_plugin_update");

/**
 *  Set the uncategorized category for newset portfolios
 * @return void
 */
add_action( 'save_post_news' , 'auxin_set_uncategorized_term' , 10, 2 );