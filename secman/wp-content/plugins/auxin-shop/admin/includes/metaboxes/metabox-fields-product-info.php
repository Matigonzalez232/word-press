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

function auxshp_metabox_fields_product_info(){

    $model         = new Auxin_Metabox_Model();
    $model->id     = 'product-info';
    $model->title  = __( 'Product Info', 'auxin-shop' );
    $model->fields = array();

    $model->fields[] = array(
        'title'       => __( 'Product Template'                    , 'auxin-shop' ),
        'description' => sprintf( "%s <br><br>%s" , __( 'Specifies the single product layout.', 'auxin-shop' ), sprintf( __( '%s Note%s: In order to use of "Slider", "Wide" & "Centered wide" templates, you are expected to install and activate "Master Slider" plugin.', 'auxin-shop' ), '<strong>', '</strong>' ) ),
        'id'          => '_product_single_template',
        'type'        => 'radio-image',
        'choices'     => array(
            'default' => array(
                'label'   => __( 'Theme Default'    , 'auxin-shop' ),
                'image'     => AUXIN_URL . 'images/visual-select/default4.svg'
            ),
            'slider'     => array(
                'label'     => __( 'Slider'         , 'auxin-shop' ),
                'image'     => AUXSHP_ADMIN_URL . '/assets/images/visual-select/shop-single-1.svg'
            ),
            'grid'        => array(
                'label'     => __( 'Grid gallery'   , 'auxin-shop' ),
                'image'     => AUXSHP_ADMIN_URL . '/assets/images/visual-select/shop-single-5.svg'
            ),
            'stack'        => array(
                'label'     => __( 'Stack gallery'  , 'auxin-shop' ),
                'image'     => AUXSHP_ADMIN_URL . '/assets/images/visual-select/shop-single-3.svg'
            ),
            'sticky'      => array(
                'label'     => __( 'Sticky gallery' , 'auxin-shop' ),
                'image'     => AUXSHP_ADMIN_URL . '/assets/images/visual-select/shop-single-2.svg'
            ),
            'wide'        => array(
                'label'     => __( 'Wide'           , 'auxin-shop' ),
                'image'     => AUXSHP_ADMIN_URL . '/assets/images/visual-select/shop-single-6.svg'
            ),
            'wide-center' => array(
                'label'     => __( 'Centered wide'  , 'auxin-shop' ),
                'image'     => AUXSHP_ADMIN_URL . '/assets/images/visual-select/shop-single-4.svg'
            )
        ),
        'default'   => 'default'
    );

    $model->fields[] = array(
        'title'       => __( 'Use default WooCommerce Slider', 'auxin-shop' ),
        'description' => __( 'Enable this to use default WooCommerce Slider instead of Master Slider as product images.', 'auxin-shop' ),
        'id'          => '_product_single_template_slider_type',
        'dependency'  => array(
            array(
                'id'       => '_product_single_template',
                'value'    => array( 'slider' ),
                'operator' => ''
                )
            ),
        'type'        => 'select',
        'choices'     => array(
            'default' => __( 'Theme Default' , 'auxin-shop' ),
            'yes'     => __( 'Yes'           , 'auxin-shop' ),
            'no'      => __( 'No'            , 'auxin-shop' )
            ),
        'default'     => 'default'
    );

    $model->fields[] = array(
        'title'       => __( 'Grid/Masonry template', 'auxin-shop' ),
        'description' => __( 'Choose your grid/masonry template.', 'auxin-shop' ),
        'id'          => '_product_grid_template_type',
        'dependency'  => array(
            array(
                'id'       => '_product_single_template',
                'value'    => 'grid',
                'operator' => ''
                )
            ),
        'choices'     => array(
            'default'  => array(
                'label'  => __( 'Theme Default' , 'auxin-shop' ),
                'image'  => AUXIN_URL . 'images/visual-select/default4.svg'
            ),
            'grid-1'   => array(
                'label'  => __( 'Grid' , 'auxin-shop' ),
                'image'  => AUXIN_URL . 'images/visual-select/portfolio-grid.svg'
            ),
            'masonry' => array(
                'label'  => __( 'Masonry' , 'auxin-shop' ),
                'image'  => AUXIN_URL . 'images/visual-select/portfolio-masonry.svg'
            )
        ),
        'type'        => 'radio-image',
        'default'     => 'default'
    );

    $model->fields[] = array(
        'title'       => __( 'Image Aspect Ratio', 'auxin-shop' ),
        'description' => '',
        'id'          => '_product_image_aspect_ratio',
        'dependency'  => array(
            array(
                'id'       => '_product_single_template',
                'value'    => 'grid',
                'operator' => ''
            ),
            array(
                'id'       => '_product_grid_template_type',
                'value'    => array('grid-1'),
                'operator' => '=='
            )
        ),
        'type'        => 'select',
        'choices'     => array(
            'default'       => __( 'Theme Default'  , 'auxin-shop' ),
            '0.75'          => __( 'Horizontal 4:3' , 'auxin-shop' ),
            '0.56'          => __( 'Horizontal 16:9', 'auxin-shop' ),
            '1.00'          => __( 'Square 1:1'     , 'auxin-shop' ),
            '1.33'          => __( 'Vertical 3:4'   , 'auxin-shop' )
        ),
        'default'     => 'default',
    );

    $model->fields[] = array(
        'title'       => __( 'Space', 'auxin-shop' ),
        'description' => __( 'Specifies space between items in pixels. Leave empty to use theme default', 'auxin-shop' ),
        'id'          => '_product_grid_space',
        'dependency'  => array(
                array(
                    'id'       => '_product_single_template',
                    'value'    => 'grid',
                    'operator' => ''
                ),
                array(
                    'id'      => '_product_grid_template_type',
                    'value'   => array('grid-1', 'masonry'),
                    'operator'=> '=='
                )
        ),
        'default'     => '',
        'type'        => 'text'
    );

    $model->fields[] = array(
        'title'       => __( 'Number of Columns', 'auxin-shop' ),
        'description' => '',
        'id'          => '_product_grid_column_number',
        'dependency'  => array(
            array(
                'id'       => '_product_single_template',
                'value'    => 'grid',
                'operator' => ''
            ),
            array(
                'id'      => '_product_grid_template_type',
                'value'   => array( 'grid-1', 'masonry' ),
                'operator'=> '=='
            )
        ),
        'type'        => 'select',
        'choices'     => array(
                'default' => __( 'Theme Default', 'auxin-shop' ),
                '1'  => '1', '2' => '2', '3' => '3',
                '4'  => '4', '5' => '5', '6' => '6'
            ),
        'default'     => 'default',
    );

    $model->fields[] = array(
        'title'       => __( 'Number of Columns in Tablet', 'auxin-shop' ),
        'description' => '',
        'id'          => '_product_grid_column_number_tablet',
        'dependency'  => array(
            array(
                'id'       => '_product_single_template',
                'value'    => 'grid',
                'operator' => ''
            ),
            array(
                'id'      => '_product_grid_template_type',
                'value'   => array( 'grid-1', 'masonry' ),
                'operator'=> '=='
            )
        ),
        'type'        => 'select',
        'choices'     => array(
            'default' => __( 'Theme Default'        , 'auxin-shop' ),
            'inherit' => __( 'Inherited from larger', 'auxin-shop' ),
            '1'  => '1', '2' => '2', '3' => '3',
            '4'  => '4', '5' => '5', '6' => '6'
        ),
        'default'     => 'default',
    );

    $model->fields[] = array(
        'title'       => __( 'Number of Columns in Mobile', 'auxin-shop' ),
        'description' => '',
        'id'          => '_product_grid_column_number_mobile',
        'dependency'  => array(
            array(
                'id'       => '_product_single_template',
                'value'    => 'grid',
                'operator' => ''
            ),
            array(
                'id'      => '_product_grid_template_type',
                'value'   => array('grid-1', 'masonry'),
                'operator'=> '=='
            )
        ),
        'type'        => 'select',
        'choices'     => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            '1' => '1' , '2' => '2', '3' => '3'
            ),
        'default'     => 'default',
    );

    $model->fields[] = array(
        'title'       => __( 'Sticky Side Area', 'auxin-shop' ),
        'description' => __( 'Enable it to stick the side area on page while scrolling..', 'auxin-shop' ),
        'id'          => '_sticky_sidebar',
        'dependency'  => array(
            array(
                 'id'       => '_product_single_template',
                 'value'    => array('stack', 'sticky'),
                 'operator' => ''
            )
        ),
        'type'        => 'select',
        'choices'     => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes'          , 'auxin-shop' ),
            'no'      => __( 'No'           , 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] = array(
        'title'       => __( 'Display Next & Previous portfolios', 'auxin-shop'  ),
        'description' => __( 'Enable it to display links to next and previous portfolios on single portfolio page.' ),
        'id'          => '_show_next_prev_nav',
        'dependency'  => '',
        'type'          => 'select',
        'default'       => 'default',
        'choices'       => array(
            'default'   => __('Theme Default', 'auxin-shop' ),
            'yes'   => __('Yes', 'auxin-shop' ),
            'no'   =>  __('No', 'auxin-shop' ),
        )
    );

    $model->fields[] = array(
        'title'       => __('Skin for Next & Previous Links', 'auxin-shop' ),
        'description' => __('Specifies the skin for next and previous navigation block.', 'auxin-shop' ),
        'id'          => '_next_prev_nav_skin',
        'dependency'  => array(
            array(
                 'id'      => '_show_next_prev_nav',
                 'value'   => array('default', 'yes'),
                 'operator'=> ''
            )
        ),
        'choices'     => array(
            'default'   => array(
                'label' => __('Default', 'auxin-shop' ),
                'image' => AUXIN_URL . 'images/visual-select/default3.svg'
            ),
            'minimal' => array(
                'label'     => __('Minimal (default)', 'auxin-shop' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-1.svg'
            ),
            'thumb-arrow' => array(
                'label'     => __('Thumbnail with Arrow', 'auxin-shop' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-2.svg'
            ),
            'thumb-no-arrow' => array(
                'label'     => __('Thumbnail without Arrow', 'auxin-shop' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-3.svg'
            ),
            'boxed-image' => array(
                'label'     => __('Navigation with Light Background', 'auxin-shop' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-4.svg'
            ),
            'boxed-image-dark' => array(
                'label'     => __('Navigation with Dark Background', 'auxin-shop' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-5.svg'
            ),
            'thumb-arrow-sticky' => array(
                'label'     => __('Sticky Thumbnail with Arrow', 'auxin-shop' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-6.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'default'
        );

    $model->fields[] =    array(
        'title'       => __( 'Display Single Star Ratings', 'auxin-shop' ),
        'description' => __( 'Enable it to display star ratings section in single product.', 'auxin-shop' ),
        'id'          => '_product_single_display_star_rating',
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes'          , 'auxin-shop' ),
            'no'      => __( 'No'           , 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Display Single Product Wishlist', 'auxin-shop' ),
        'description' => __( 'Enable it to display wishlist section in single product.', 'auxin-shop' ),
        'id'          => '_product_single_display_wishlist',
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes'          , 'auxin-shop' ),
            'no'      => __( 'No'           , 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Display Single Product Share', 'auxin-shop' ),
        'description' => __( 'Enable it to display Share section in single product.', 'auxin-shop' ),
        'id'          => '_product_single_display_share',
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes'          , 'auxin-shop' ),
            'no'      => __( 'No'           , 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Display Single Product SKU', 'auxin-shop' ),
        'description' => __( 'Enable it to display SKU section in single product.', 'auxin-shop' ),
        'id'          => '_product_single_display_sku',
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes'          , 'auxin-shop' ),
            'no'      => __( 'No'           , 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Display Single Product Categories', 'auxin-shop' ),
        'description' => __( 'Enable it to display category section in single product.', 'auxin-shop' ),
        'id'          => '_product_single_display_category',
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes'          , 'auxin-shop' ),
            'no'      => __( 'No'           , 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'       => __( 'Display Single Product Tags', 'auxin-shop' ),
        'description' => __( 'Enable it to display Tag section in single product.', 'auxin-shop' ),
        'id'          => '_product_single_display_tag',
        'type'        => 'select',
        'choices' => array(
            'default' => __( 'Theme Default', 'auxin-shop' ),
            'yes'     => __( 'Yes'          , 'auxin-shop' ),
            'no'      => __( 'No'           , 'auxin-shop' ),
            ),
        'default'     => 'default'
    );

    $model->fields[] =    array(
        'title'         => __('Custom Featured Color?', 'auxin-shop'),
        'description'   => __('By default custom feature color of all products are the same as the color defined in theme options. You have to enable this option if you want to define custom feature color for this product.', 'auxin-shop'),
        'id'            => 'auxin_product_featured_color_enabled',
        'type'          => 'switch',
        'default'       => 0
    );
    
    $model->fields[] =    array(
        'title'         => __('Featured Color', 'auxin-shop'),
        'description'   => __('Custom featured color for this post.', 'auxin-shop'),
        'id'            => 'auxin_product_featured_color',
        'dependency'    => array(
            array(
                'id'       => 'auxin_product_featured_color_enabled',
                'value'    => '1',
                'operator' => '=='
            )
        ),
        'type'          => 'color',
        'default'       => esc_attr( auxin_get_option('product_single_featured_color', '#1bb0ce') )
    );

    return $model;
}
