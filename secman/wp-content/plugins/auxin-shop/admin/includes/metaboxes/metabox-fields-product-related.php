<?php
/**
 * Layout option for pages
 *
 * 
 * @package    
 * @license    LICENSE.txt
 * @author     averta <info@averta.net>
 * @link       https://bitbucket.org/averta/
 * @copyright  (c) 2010-2023 averta <info@averta.net>
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


/*==================================================================================================

    Add Page Option meta box

 *=================================================================================================*/

function auxshp_metabox_fields_product_related(){

    $model         = new Auxin_Metabox_Model();
    $model->id     = 'product-related';
    $model->title  = __( 'Related Products', 'auxin-shop' );
    $model->fields = array();

    $model->fields[] = array(
        'title'       => __( 'Display Related Products', 'auxin-shop' ),
        'description' => __( 'Enable it to display related products section on single product page.', 'auxin-shop' ),
        'id'          => '_show_product_related_posts',
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes', 'auxin-shop' ),
            'no'      => __( 'No', 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] = array(
        'title'       => __( 'Label of Related Section', 'auxin-shop' ),
        'description' => __( 'Specifies the label of related items section. Leave empty to use theme default.', 'auxin-shop' ),
        'id'          => '_product_related_posts_label',
        'dependency'  => array(
            array(
                 'id'      => '_show_product_related_posts',
                 'value'   => array( 'default', 'yes' ),
                 'operator'=> ''
            )
        ),
        'type'        => 'text'
    );

    $model->fields[] =    array(
        'title'       => __( 'Related Items Type', 'auxin-shop' ),
        'description' => __( 'Specifies the appearance type for related product element.', 'auxin-shop' ),
        'id'          => '_product_related_posts_preview_mode',
        'dependency'  => array(
            array(
                 'id'      => '_show_product_related_posts',
                 'value'   => array( 'default', 'yes' ),
                 'operator'=> ''
            )
        ),
        'choices'     => array(
            'default'   => __( 'Theme Default', 'auxin-shop' ),
            'grid'      => 'Grid',
            'carousel'  => 'Carousel'
        ),
        'type'        => 'select',
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Number of Columns', 'auxin-shop' ),
        'description' => '',
        'id'          => '_product_related_posts_column_number',
        'dependency'  => array(
            array(
                 'id'      => '_show_product_related_posts',
                 'value'   => array( 'default', 'yes' ),
                 'operator'=> ''
            )
        ),
        'type'        => 'select',
        'choices'     => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            '1' => '1', '2' => '2', '3' => '3', '4' => '4'
        ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Number of carousel pages', 'auxin-shop' ),
        'description' => 'Select this regarding to number of columns options',
        'id'          => '_product_related_posts_carousel_pages',
        'dependency'  => array(
            array(
                'id'      => '_show_product_related_posts',
                'value'   => array( 'default', 'yes' ),
                'operator'=> ''
            ),
            array(
                'id'       => '_product_related_posts_preview_mode',
                'value'    => array('carousel'),
                'operator' => ''
            )
        ),
        'type'        => 'select',
        'choices'     => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            '2' => '2', '3' => '3', '4' => '4'
        ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Auto Play Carousel', 'auxin-shop' ),
        'description' => 'Start Carousel automatically',
        'id'          => '_product_related_posts_carousel_autoplay',
        'dependency'  => array(
            array(
                'id'      => '_show_product_related_posts',
                'value'   => array( 'default', 'yes' ),
                'operator'=> ''
            ),
            array(
                'id'       => '_product_related_posts_preview_mode',
                'value'    => array('carousel'),
                'operator' => ''
            )
        ),
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes', 'auxin-shop' ),
            'no'      => __( 'No', 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Align Center', 'auxin-shop' ),
        'description' => __( 'Enable it to make related products section text center.', 'auxin-shop' ),
        'id'          => '_product_related_posts_align_center',
        'dependency'  => array(
            array(
                 'id'      => '_show_product_related_posts',
                 'value'   => array( 'default', 'yes' ),
                 'operator'=> ''
            )
        ),
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes', 'auxin-shop' ),
            'no'      => __( 'No', 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Full Width Related Section', 'auxin-shop' ),
        'description' => __( 'Enable it to make related products section full width.', 'auxin-shop' ),
        'id'          => '_product_related_posts_full_width',
        'dependency'  => array(
            array(
                 'id'      => '_show_product_related_posts',
                 'value'   => array( 'default', 'yes' ),
                 'operator'=> ''
            )
        ),
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes', 'auxin-shop' ),
            'no'      => __( 'No', 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Snap Related Items', 'auxin-shop' ),
        'description' => __( 'Enable it to remove space between related product items.', 'auxin-shop' ),
        'id'          => '_product_related_posts_snap_items',
        'dependency'  => array(
            array(
                 'id'      => '_show_product_related_posts',
                 'value'   => array( 'default', 'yes' ),
                 'operator'=> ''
            )
        ),
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes', 'auxin-shop' ),
            'no'      => __( 'No', 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Display Product Categories', 'auxin-shop' ),
        'description' => __( 'Enable it to display the categories of each product item in related products section.', 'auxin-shop' ),
        'id'          => '_product_related_posts_display_categories',
        'dependency'  => array(
            array(
                 'id'      => '_show_product_related_posts',
                 'value'   => array( 'default', 'yes' ),
                 'operator'=> ''
            )
        ),
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes', 'auxin-shop' ),
            'no'      => __( 'No', 'auxin-shop' ),
            ),
        'default'     => 'default'
    ); 

    $model->fields[] =    array(
        'title'       => __( 'Display Product Star Review', 'auxin-shop' ),
        'description' => __( 'Enable it to display the star reviews of each product item in related products section.', 'auxin-shop' ),
        'id'          => '_product_related_posts_display_stars',
        'dependency'  => array(
            array(
                 'id'      => '_show_product_related_posts',
                 'value'   => array( 'default', 'yes' ),
                 'operator'=> ''
            )
        ),
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes', 'auxin-shop' ),
            'no'      => __( 'No', 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    // Not important, maybe next version
    // $model->fields[] = array(
    //     'title'       => __( 'Custom Related Products', 'auxin-shop' ),
    //     'description' => __( 'Show selected products as related products.', 'auxin-shop' ),
    //     'id'          => 'custom_product_related_posts',
    //     'section'     => 'product-related',
    //     'dependency'  => '',
    //     'default'     => '1',
    //     'type'        => 'select2'
    // );


    return $model;
}
