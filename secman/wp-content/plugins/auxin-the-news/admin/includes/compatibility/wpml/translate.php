<?php

/**
 * Make our widgets compatible with WPML elementor list
 *
 * @param array $widgets
 * @return array
 */
function auxnews_wpml_widgets_to_translate_list( $widgets ) {

    $widgets[ 'aux_recent_news' ] = array(
       'conditions' => array( 'widgetType' => 'aux_recent_news' ),
       'fields'     => array(
          array(
             'field'       => 'title',
             'type'        => __( 'Widget Title', 'auxin-news' ),
             'editor_type' => 'LINE'
          ),
       ),
    );
 
    return $widgets;
 }
 
 /**
  * Add filter on wpml elementor widgets node when init action.
  *
  * @return void
  */
 function auxnews_wpml_widgets_to_translate_filter(){
     add_filter( 'wpml_elementor_widgets_to_translate', 'auxnews_wpml_widgets_to_translate_list' );
 }
 add_action( 'init', 'auxnews_wpml_widgets_to_translate_filter' );
 
 