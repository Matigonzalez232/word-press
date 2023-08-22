<?php
/**
 * Add news setting metabox Model
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
*/

function auxin_metabox_fields_news_options(){

    $model         = new Auxin_Metabox_Model();
    $model->id     = 'news-options';
    $model->title  = __('News Setting', 'auxin-news' );
    $model->fields = array(

        array(
            'title'         => __('Author Name', 'auxin-news'),
            'description'   => '',
            'id'            => 'news_author',
            'id_deprecated' => 'customer_job',
            'type'          => 'text',
            'default'       => ''
        )

    );

    return $model;
}
