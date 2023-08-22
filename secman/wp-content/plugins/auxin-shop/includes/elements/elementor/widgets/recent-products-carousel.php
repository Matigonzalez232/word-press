<?php
namespace Auxin\Plugin\Shop\Elementor\Elements;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;


if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Elementor 'RecentProductsCarousel' widget.
 *
 * Elementor widget that displays an 'RecentProductsCarousel' with lightbox.
 *
 * @since 1.0.0
 */
class RecentProductsCarousel extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve 'RecentProductsCarousel' widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aux_products_carousel';
    }

    /**
     * Get widget title.
     *
     * Retrieve 'RecentProductsCarousel' widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Products Carousel', 'auxin-shop' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve 'RecentProductsCarousel' widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-woocommerce auxin-badge-pro';
    }

    /**
     * Get widget categories.
     *
     * Retrieve 'RecentProductsCarousel' widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_categories() {
        return array( 'auxin-pro' );
    }

    /**
     * Retrieve the terms in a given taxonomy or list of taxonomies.
     *
     * Retrieve 'RecentProductsCarousel' widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_terms() {
        // Get terms
        $terms = get_terms(
            array(
                'taxonomy'   => 'product_cat',
                'orderby'    => 'count',
                'hide_empty' => true
            )
        );

        // Then create a list
        $list  = array( ' ' => __('All Categories', 'auxin-shop' ) ) ;

        if ( ! is_wp_error( $terms ) && is_array( $terms ) ){
            foreach ( $terms as $key => $value ) {
                $list[$value->term_id] = $value->name;
            }
        }

        return $list;
    }

    /**
     * Register 'RecentProductsCarousel' widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {

        /*-------------------------------------------------------------------*/
        /*  Layout TAB
        /*-------------------------------------------------------------------*/

        /*  Layout Section
        /*-------------------------------------*/

        $this->start_controls_section(
            'layout_section',
            array(
                'label' => __('Layout', 'auxin-shop' ),
                'tab'   => Controls_Manager::TAB_LAYOUT
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label'          => __( 'Columns', 'auxin-shop' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => '4',
                'tablet_default' => 'inherit',
                'mobile_default' => '1',
                'options'        => array(
                    'inherit' => __( 'Inherited from larger', 'auxin-shop' ),
                    '1'       => '1',
                    '2'       => '2',
                    '3'       => '3',
                    '4'       => '4',
                    '5'       => '5',
                    '6'       => '6'
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'carousel_space',
            array(
                'label'       => __( 'Column space', 'auxin-shop' ),
                'description' => __( 'Specifies horizontal space between items (pixel).', 'auxin-shop' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '30',
            )
        );

        $this->add_control(
            'display_title',
            array(
                'label'        => __('Display title', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'display_price',
            array(
                'label'        => __('Display products price', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'display_add_to_cart',
            array(
                'label'        => __('Display add to cart', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'display_categories',
            array(
                'label'        => __('Display Categories', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'display_share',
            array(
                'label'        => __('Display share', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'display_wishlist',
            array(
                'label'        => __('Display add to wishlist', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'display_sale_badge',
            array(
                'label'        => __('Display Sale Badge', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'display_rating',
            array(
                'label'        => __('Display Rating', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'default'      => 'no'
            )
        );

        $this->add_control(
            'display_meta_fields',
            array(
                'label'        => __('Display Meta Fields', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'default'      => 'no'
            )
        );

        $this->add_control(
            'display_quicklook',
            array(
                'label'        => __('Display Quicklook', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => 'yes',
                'default'      => 'no'
            )
        );


        $this->add_control(
            'display_featured_color',
            array(
                'label'        => __('Display Featured Color', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'default'      => 'off'
            )
        );

        $this->add_control(
            'display_content',
            array(
                'label'        => __('Display Short Description', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => 'yes',
                'default'      => 'false'
            )
        );

        $this->add_control(
            'desc_char_num',
            array(
                'label'       => __('Number of description characters', 'auxin-shop'),
                'label_block' => true,
                'type'        => Controls_Manager::NUMBER,
                'default'     => '120',
                'min'         => 1,
                'step'        => 1,
                'condition'    => array(
                    'display_content' => 'yes'
                )
            )
        );

        $this->add_control(
            'custom_image_aspect_ratio',
            array(
                'label'        => __('Use Custom Aspect Ratio','auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'image_aspect_ratio',
            array(
                'label'       => __('Image aspect ratio', 'auxin-shop'),
                'type'        => Controls_Manager::SELECT,
                'default'     => '0.75',
                'options'     => array(
                    '0.75'          => __('Horizontal 4:3' , 'auxin-shop'),
                    '0.56'          => __('Horizontal 16:9', 'auxin-shop'),
                    '1.00'          => __('Square 1:1'     , 'auxin-shop'),
                    '1.33'          => __('Vertical 3:4'   , 'auxin-shop'),
                    '1.5'           => __('Vertical 2:3'   , 'auxin-shop'),
                    'custom'        => __('Custom'   , 'auxin-shop'),
                ),
                'condition' => array(
                    'custom_image_aspect_ratio' => 'yes',
                ),
            )
        );

        $this->add_control(
            'custom_aspect_ratio',
            array(
                'label'       => __('Custom Ratio for images', 'auxin-shop'),
                'label_block' => true,
                'type'        => Controls_Manager::NUMBER,
                'default'     => '1',
                'min'         => 0,
                'step'        => 0.5,
                'condition' => array(
                    'image_aspect_ratio' => 'custom',
                ),
            )
        );

        $this->add_control(
            'preloadable',
            array(
                'label'        => __('Preload image','auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => 'yes',
                'default'      => 'no'
            )
        );

        $this->add_control(
            'preload_preview',
            array(
                'label'        => __('While loading image display','auxin-shop' ),
                'label_block'  => true,
                'type'         => Controls_Manager::SELECT,
                'options'      => auxin_get_preloadable_previews(),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => array(
                    'preloadable' => 'yes'
                )
            )
        );

        $this->add_control(
            'preload_bgcolor',
            array(
                'label'     => __( 'Placeholder color while loading image', 'auxin-shop' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => array(
                    'preloadable'     => 'yes',
                    'preload_preview' => array('simple-spinner', 'simple-spinner-light', 'simple-spinner-dark')
                )
            )
        );

        $this->end_controls_section();

        /*  Carousel Section
        /*-------------------------------------*/

        $this->start_controls_section(
            'carousel_section',
            array(
                'label' => __('Carousel', 'auxin-shop' ),
                'tab'   => Controls_Manager::TAB_LAYOUT
            )
        );

        $this->add_control(
            'carousel_navigation_control',
            array(
                'label'       => __('Navigation control', 'auxin-shop'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'bullets',
                'options'     => array(
                    'arrows'     => __('Arrows', 'auxin-shop'),
                    'bullets'    => __('Bullets', 'auxin-shop'),
                    ''           => __('None', 'auxin-shop'),
                )
            )
        );

        $this->add_control(
            'carousel_nav_control_skin',
            array(
                'label'       => __('Control Arrow Skin', 'auxin-shop'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'boxed',
                'options'     => array(
                    'boxed' => __('Boxed', 'auxin-shop'),
                    'long'  => __('Long Arrow', 'auxin-shop'),
                ),
                'condition' => array(
                    'carousel_navigation_control' => array('arrows'),
                ),
            )
        );

        $this->add_control(
            'carousel_navigation',
            array(
                'label'       => __('Navigation type', 'auxin-shop'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'peritem',
                'options'     => array(
                   'peritem' => __('Move per column', 'auxin-shop'),
                   'perpage' => __('Move per page', 'auxin-shop'),
                   'scroll'  => __('Smooth scroll', 'auxin-shop')
                )
            )
        );

        $this->add_control(
            'carousel_loop',
            array(
                'label'        => __('Loop navigation','auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => 1,
                'default'      => 0
            )
        );

        $this->add_control(
            'carousel_autoplay',
            array(
                'label'        => __('Autoplay carousel','auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => true,
                'default'      => false
            )
        );

        $this->add_control(
            'carousel_same_height',
            array(
                'label'        => __('Same Height','auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => true,
                'default'      => false
            )
        );

        $this->add_control(
            'carousel_autoplay_delay',
            array(
                'label'       => __( 'Autoplay delay', 'auxin-shop' ),
                'description' => __('Specifies the delay between auto-forwarding in seconds.', 'auxin-shop' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '2'
            )
        );

        $this->add_control(
            'carousel_nav_control_pos',
            array(
                'label'       => __('Control Position', 'auxin-shop'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'center',
                'options'     => array(
                    'center'         => __('Center', 'auxin-shop'),
                    'side'           => __('Side', 'auxin-shop'),
                ),
                'condition' => array(
                    'carousel_navigation_control' => array('arrows'),
                ),
            )
        );

        $this->end_controls_section();


        /*-------------------------------------------------------------------*/
        /*  Content TAB
        /*-------------------------------------------------------------------*/

        /*  Query Section
        /*-------------------------------------*/

        $this->start_controls_section(
            'query_section',
            array(
                'label'      => __('Query', 'auxin-shop' ),
            )
        );

        $this->add_control(
            'cat',
            array(
                'label'       => __('Categories', 'auxin-shop'),
                'description' => __('Specifies a category that you want to show posts from it.', 'auxin-shop' ),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => $this->get_terms(),
                'default'     => array( ' ' ),
            )
        );

        $this->add_control(
            'num',
            array(
                'label'       => __('Number of products to show per page', 'auxin-shop'),
                'description' => __('Leave it empty to show all items', 'auxin-shop'),
                'label_block' => true,
                'type'        => Controls_Manager::NUMBER,
                'default'     => '5',
                'min'         => 1,
                'step'        => 1
            )
        );

        $this->add_control(
            'exclude_without_media',
            array(
                'label'        => __('Exclude products without media','auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'order_by',
            array(
                'label'       => __('Order by', 'auxin-shop'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'date',
                'options'     => array(
                    'date'            => __('Date', 'auxin-shop'),
                    'menu_order date' => __('Menu Order', 'auxin-shop'),
                    'title'           => __('Title', 'auxin-shop'),
                    'ID'              => __('ID', 'auxin-shop'),
                    'rand'            => __('Random', 'auxin-shop'),
                    'comment_count'   => __('Comments', 'auxin-shop'),
                    'modified'        => __('Date Modified', 'auxin-shop'),
                    'author'          => __('Author', 'auxin-shop'),
                    'post__in'        => __('Inserted Post IDs', 'auxin-shop')
                ),
            )
        );

        $this->add_control(
            'order',
            array(
                'label'       => __('Order', 'auxin-shop'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'DESC',
                'options'     => array(
                    'DESC'          => __('Descending', 'auxin-shop'),
                    'ASC'           => __('Ascending', 'auxin-shop'),
                ),
            )
        );

        $this->add_control(
            'only_products__in',
            array(
                'label'       => __('Only products','auxin-shop' ),
                'description' => __('If you intend to display ONLY specific products, you should specify the products here. You have to insert the Products IDs that are separated by comma (eg. 53,34,87,25).', 'auxin-shop' ),
                'type'        => Controls_Manager::TEXT
            )
        );

        $this->add_control(
            'include',
            array(
                'label'       => __('Include products','auxin-shop' ),
                'description' => __('If you intend to include additional products, you should specify the products here. You have to insert the Products IDs that are separated by comma (eg. 53,34,87,25)', 'auxin-shop' ),
                'type'        => Controls_Manager::TEXT
            )
        );

        $this->add_control(
            'exclude',
            array(
                'label'       => __('Exclude products','auxin-shop' ),
                'description' => __('If you intend to exclude specific products from result, you should specify the products here. You have to insert the Products IDs that are separated by comma (eg. 53,34,87,25)', 'auxin-shop' ),
                'type'        => Controls_Manager::TEXT
            )
        );

        $this->add_control(
            'offset',
            array(
                'label'       => __('Start offset','auxin-shop' ),
                'description' => __('Number of products to displace or pass over.', 'auxin-shop' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => ''
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  title_style_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'title_style_section',
            array(
                'label'     => __( 'Title', 'auxin-shop' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'display_title' => 'yes',
                ),
            )
        );

        $this->start_controls_tabs( 'title_colors' );

        $this->start_controls_tab(
            'title_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-shop' ),
                'condition' => array(
                    'display_title' => 'yes',
                ),
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .auxshp-loop-title' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_title' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-shop' ),
                'condition' => array(
                    'display_title' => 'yes',
                ),
            )
        );

        $this->add_control(
            'title_hover_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .auxshp-loop-title:hover' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_title' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'title_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .auxshp-loop-title',
                'condition' => array(
                    'display_title' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'title_margin_bottom',
            array(
                'label' => __( 'Bottom space', 'auxin-shop' ),
                'type' => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .auxshp-loop-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'display_title' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  price_style_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'price_style_section',
            array(
                'label'     => __( 'Price', 'auxin-shop' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'display_price' => 'yes',
                ),
            )
        );

        $this->start_controls_tabs( 'price_colors' );

        $this->start_controls_tab(
            'price_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-shop' ),
                'condition' => array(
                    'display_price' => 'yes',
                ),
            )
        );

        $this->add_control(
            'price_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .woocommerce-Price-amount' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_price' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'price_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-shop' ),
                'condition' => array(
                    'display_price' => 'yes',
                ),
            )
        );

        $this->add_control(
            'price_hover_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .woocommerce-Price-amount:hover' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_price' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'price_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .woocommerce-Price-amount',
                'condition' => array(
                    'display_price' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'price_margin_bottom',
            array(
                'label' => __( 'Bottom space', 'auxin-shop' ),
                'type' => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'display_price' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  info_style_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'info_style_section',
            array(
                'label'     => __( 'Product Info', 'auxin-shop' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'display_categories' => 'yes',
                ),
            )
        );

        $this->start_controls_tabs( 'info_colors' );

        $this->start_controls_tab(
            'info_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-shop' ),
                'condition' => array(
                    'display_categories' => 'yes',
                ),
            )
        );

        $this->add_control(
            'info_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .auxshp-meta-terms > a' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_categories' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'info_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-shop' ),
                'condition' => array(
                    'display_categories' => 'yes',
                ),
            )
        );

        $this->add_control(
            'info_hover_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .auxshp-meta-terms > a:hover' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_categories' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'info_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .auxshp-meta-terms, {{WRAPPER}} .auxshp-meta-terms a',
                'condition' => array(
                    'display_categories' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'info_margin_bottom',
            array(
                'label' => __( 'Bottom space', 'auxin-shop' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100
                    )
                ),
                'selectors' => array(
                    '{{WRAPPER}} .loop-meta-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ),
                'condition' => array(
                    'display_categories' => 'yes'
                )
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  meta_fields_style_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'meta_fields_section',
            array(
                'label'     => __( 'Meta Fields', 'auxin-shop' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'display_meta_fields' => 'yes',
                ),
            )
        );

        $this->start_controls_tabs( 'meta_fields_colors' );

        $this->start_controls_tab(
            'meta_fields_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-shop' ),
                'condition' => array(
                    'display_meta_fields' => 'yes',
                ),
            )
        );

        $this->add_control(
            'meta_fields_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-shop-meta-field span' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_meta_fields' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'meta_fields_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-shop' ),
                'condition' => array(
                    'display_meta_fields' => 'yes',
                ),
            )
        );

        $this->add_control(
            'meta_fields_hover_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-shop-meta-field span:hover' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_meta_fields' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'meta_fields_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .aux-shop-meta-field span',
                'condition' => array(
                    'display_meta_fields' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'meta_fields_padding',
            array(
                'label' => __( 'Padding', 'auxin-shop' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .aux-shop-meta-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'display_meta_fields' => 'yes'
                )
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Description Style Section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'desc_style_section',
            array(
                'label'     => __( 'Description', 'auxin-shop' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'display_content' => 'yes',
                ),
            )
        );

        $this->start_controls_tabs( 'desc_colors' );

        $this->start_controls_tab(
            'desc_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-shop' ),
                'condition' => array(
                    'display_content' => 'yes',
                ),
            )
        );

        $this->add_control(
            'desc_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-shop-desc-wrapper' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_content' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'desc_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-shop' ),
                'condition' => array(
                    'display_content' => 'yes',
                ),
            )
        );

        $this->add_control(
            'desc_hover_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-shop-desc-wrapper:hover' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_content' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'desc_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .aux-shop-desc-wrapper',
                'condition' => array(
                    'display_content' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  add_to_cart_style_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'add_to_cart_section',
            array(
                'label'     => __( 'Add to cart', 'auxin-shop' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'display_add_to_cart' => 'yes',
                ),
            )
        );

        $this->start_controls_tabs( 'add_to_cart_colors' );

        $this->start_controls_tab(
            'add_to_cart_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-shop' ),
                'condition' => array(
                    'display_add_to_cart' => 'yes',
                ),
            )
        );

        $this->add_control(
            'add_to_cart_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .loop-tools-wrapper .button' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_add_to_cart' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'add_to_cart_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-shop' ),
                'condition' => array(
                    'display_add_to_cart' => 'yes',
                ),
            )
        );

        $this->add_control(
            'add_to_cart_hover_color',
            array(
                'label' => __( 'Color', 'auxin-shop' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .loop-tools-wrapper .button:hover' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'display_add_to_cart' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'add_to_cart_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .loop-tools-wrapper .button',
                'condition' => array(
                    'display_add_to_cart' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'add_to_cart_padding_top',
            array(
                'label' => __( 'Top space', 'auxin-shop' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100
                    )
                ),
                'selectors' => array(
                    '{{WRAPPER}} .loop-tools-wrapper .button' => 'padding-top: {{SIZE}}{{UNIT}};'
                ),
                'condition' => array(
                    'display_add_to_cart' => 'yes'
                )
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Rating Style Section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'rating_style_section',
            array(
                'label'     => __( 'Rating', 'auxin-shop' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'display_rating' => 'yes'
                )
            )
        );


        $this->add_control(
            'rating_empty_color',
            array(
                'label'     => __( 'Empty Color', 'auxin-shop' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-rating-box.aux-star-rating::before' => 'color: {{VALUE}} !important;'
                )
            )
        );

        $this->add_control(
            'rating_fill_color',
            array(
                'label'     => __( 'Fill Color', 'auxin-shop' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-rating-box.aux-star-rating span::before' => 'color: {{VALUE}} !important;'
                )
            )
        );

        $this->add_responsive_control(
            'rating_size',
            array(
                'label'      => __( 'Size', 'auxin-shop' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'em', 'rem' ),
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 200
                    )
                ),
                'selectors' => array(
                    '{{WRAPPER}} .aux-star-rating' => 'font-size: {{SIZE}}{{UNIT}};'
                )
            )
        );


        $this->end_controls_section();
    }

  /**
   * Render image box widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.0.0
   * @access protected
   */
  protected function render() {

    $settings = $this->get_settings_for_display();

    $args     = array(
        // Layout section
        'phone_cnum'                  => $settings['columns_mobile'],
        'tablet_cnum'                 => $settings['columns_tablet'],
        'desktop_cnum'                => $settings['columns'],
        'display_title'               => $settings['display_title'],
        'display_price'               => $settings['display_price'],
        'display_share'               => $settings['display_share'],
        'display_wishlist'            => $settings['display_wishlist'],
        'display_categories'          => $settings['display_categories'],
        'display_sale_badge'          => $settings['display_sale_badge'],
        'display_rating'              => $settings['display_rating'],
        'display_meta_fields'         => $settings['display_meta_fields'],
        'display_content'             => $settings['display_content'],
        'desc_char_num'               => $settings['desc_char_num'],
        'image_aspect_ratio'          => $settings['image_aspect_ratio'] !== 'custom' ? $settings['image_aspect_ratio'] : $settings['custom_aspect_ratio'],
        'preloadable'                 => $settings['preloadable'],
        'preload_preview'             => $settings['preload_preview'],
        'preload_bgcolor'             => $settings['preload_bgcolor'],
        'display_add_to_cart'         => $settings['display_add_to_cart'],
        'display_quicklook'           => $settings['display_quicklook'],
        'display_featured_color'      => $settings['display_featured_color'],

        // Carousel section
        'carousel_loop'               => $settings['carousel_loop'],
        'carousel_space'              => $settings['carousel_space'],
        'carousel_autoplay'           => $settings['carousel_autoplay'],
        'carousel_navigation'         => $settings['carousel_navigation'],
        'carousel_same_height'        => $settings['carousel_same_height'],
        'carousel_autoplay_delay'     => $settings['carousel_autoplay_delay'],
        'carousel_nav_control_skin'   => $settings['carousel_nav_control_skin'],
        'carousel_navigation_control' => $settings['carousel_navigation_control'],


        // Query section
        'cat'                         => $settings['cat'],
        'num'                         => $settings['num'],
        'order'                       => $settings['order'],
        'offset'                      => $settings['offset'],
        'include'                     => $settings['include'],
        'exclude'                     => $settings['exclude'],
        'order_by'                    => $settings['order_by'],
        'only_products__in'           => $settings['only_products__in'],
        'exclude_without_media'       => $settings['exclude_without_media'],
    );

    // // get the shortcode base blog page
    echo auxin_widget_products_carousel_callback( $args );

  }

}
