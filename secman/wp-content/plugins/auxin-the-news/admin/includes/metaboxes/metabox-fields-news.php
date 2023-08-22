<?php
/**
 * Add metaboxes for news
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
*/

/*======================================================================*/

function auxin_push_metabox_models_news( $models ){

    include_once( 'metabox-fields-news-options.php' );

    $models[] = array(
        'model'     => auxin_metabox_fields_news_options(),
        'priority'  => 10
    );
    $models[] = array(
        'model'     => auxin_metabox_fields_general_layout(),
        'priority'  => 10
    );
    $models[] = array(
        'model'     => auxin_metabox_fields_general_advanced(),
        'priority'  => 10
    );

    return $models;
}

add_filter( 'auxin_admin_metabox_models_news', 'auxin_push_metabox_models_news' );
