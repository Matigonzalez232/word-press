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
 * Elementor 'ProductsParallax' widget.
 *
 * Elementor widget that displays an 'ProductsParallax' with lightbox.
 *
 * @since 1.0.0
 */
class ProductsParallax extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve 'ProductsParallax' widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aux_products_parallax';
    }

    /**
     * Get widget title.
     *
     * Retrieve 'ProductsParallax' widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Products Parallax', 'auxin-shop' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve 'ProductsParallax' widget icon.
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
     * Retrieve 'ProductsParallax' widget icon.
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
     * Retrieve 'ProductsParallax' widget icon.
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
     * Register 'ProductsParallax' widget controls.
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
                'default'        => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options'        => array(
                    '1'       => '1',
                    '2'       => '2',
                    '3'       => '3',
                    '4'       => '4',
                    '5'       => '5',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'display_title',
            array(
                'label'        => __('Display title', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => 'yes',
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
                'return_value' => 'yes',
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
                'return_value' => 'yes',
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
                'return_value' => 'yes',
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
                'return_value' => 'yes',
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
                'return_value' => 'yes',
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
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'colorized_shadow',
            array(
                'label'        => __('Display Colorized Shadow', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => 'yes',
                'default'      => 'no'
            )
        );

        $this->add_control(
            'tilt',
            array(
                'label'        => __('Tilt Effect', 'auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => 'yes',
                'default'      => 'no'
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
                    '1.5'           => __('Vertical 2:3'   , 'auxin-shop')
                ),
                'condition' => array(
                    'custom_image_aspect_ratio' => 'yes',
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
                'default'     => [],
            )
        );

        $this->add_control(
            'num',
            array(
                'label'       => __('Number of posts to show', 'auxin-shop'),
                'label_block' => true,
                'type'        => Controls_Manager::NUMBER,
                'default'     => '8',
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

        /*-------------------------------------------------------------------*/
        /*  Settings TAB
        /*-------------------------------------------------------------------*/

        /*  Filters Section
        /*-------------------------------------*/

        $this->start_controls_section(
            'filters_section',
            array(
                'label'      => __('Filters', 'auxin-shop' ),
                'tab'        => Controls_Manager::TAB_SETTINGS
            )
        );

        $this->add_control(
            'show_filters',
            array(
                'label'        => __('Display filters','auxin-shop' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-shop' ),
                'label_off'    => __( 'Off', 'auxin-shop' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'filter_by',
            array(
                'label'       => __('Filter By', 'auxin-shop'),
                'description' => __('Filter by categories or tags', 'auxin-shop' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'product_cat',
                'options'     => array(
                    'product_filter'  => __('Filter', 'auxin-shop'),
                    'product_cat'     => __('Category', 'auxin-shop'),
                    'product_tag'     => __('Tag', 'auxin-shop')
                ),
                'condition' => array(
                    'show_filters' => 'yes'
                )
            )
        );

        $this->add_control(
            'filter_align',
            array(
                'label'       => __('Filter Control Alignment', 'auxin-shop'),
                'description' => __('Filter by categories or tags', 'auxin-shop' ),
                'type'        => Controls_Manager::CHOOSE,
                'style_items' => 'max-width:30%;',
                'default'     => 'aux-left',
                'options'     => array(
                    'aux-left' => array(
                        'title' => __( 'Left', 'auxin-shop' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'aux-center' => array(
                        'title' => __( 'Center', 'auxin-shop' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'aux-right' => array(
                        'title' => __( 'Right', 'auxin-shop' ),
                        'icon'  => 'eicon-text-align-right',
                    )
                ),
                'devices'      => array('desktop'),
                'condition'    => array(
                    'show_filters' => 'yes'
                )
            )
        );

        $this->add_control(
            'filter_style',
            array(
                'label'       => __('Filter Button Style', 'auxin-shop'),
                'description' => __('Style of filter buttons.', 'auxin-shop' ),
                'type'        => 'aux-visual-select',
                'default'     => 'aux-slideup',
                'style_items' => 'max-width:200px;',
                'options'     => array(
                    'aux-slideup'      => array(
                        'label'     => __('Slide up' , 'auxin-shop'),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterSlideUp2.webm webm'
                    ),
                    'aux-fill'    => array(
                        'label'     => __('Fill' , 'auxin-shop'),
                        'video_src' => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterFill.webm webm'
                    ),
                    'aux-cube'     => array(
                        'label'     => __('Cube' , 'auxin-shop'),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterCube.webm webm'
                    ),
                    'aux-underline'     => array(
                        'label'     => __('Underline' , 'auxin-shop'),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterUnderline.mp4 mp4'
                    ),
                    'aux-overlay'    => array(
                        'label'     => __('Float frame' , 'auxin-shop'),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterFloatFrame.webm webm'
                    ),
                    'aux-bordered'     => array(
                        'label'     => __('Borderd' , 'auxin-shop'),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterBordered.mp4 mp4'
                    ),
                    'aux-overlay aux-underline-anim'     => array(
                        'label'     => __('Float underline' , 'auxin-shop'),
                        'video_src'     => AUXSHP_ADMIN_URL . '/assets/images/preview/FilterUnderline.webm webm'
                    ),
                ),
                'condition' => array(
                    'show_filters' => 'yes'
                )
            )
        );
        
        $this->end_controls_section();

        /*  Parallax Section
        /*-------------------------------------*/

        $this->start_controls_section(
            'parallax_section',
            array(
                'label'      => __('Parallax', 'auxin-shop' ),
                'tab'        => Controls_Manager::TAB_SETTINGS
            )
        );

		$this->add_control(
			'wrapper_offset',
			array(
				'label' => __( 'Wrapper Start Offset', 'auxin-shop' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					)
				),
				'default' => array(
					'unit' => 'px',
					'size' => 0.5,
				),
            )
        );
        
        $this->add_control(
			'inset_offset',
			array(
				'label' => __( 'Speed', 'auxin-shop' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					)
				),
				'default' => array(
					'unit' => 'px',
					'size' => 1,
				),
            )
        );

        $this->add_control(
            'parallax_easing',
            array(
                'label'   => __( 'Easing', 'auxin-shop' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    ''                       => 'Default',
                    'initial'                => 'Initial',

                    'linear'                 => 'Linear',
                    'ease-out'               => 'Ease Out',
                    '0.19,1,0.22,1'          => 'Ease In Out',

                    '0.47,0,0.745,0.715'     => 'Sine In',
                    '0.39,0.575,0.565,1'     => 'Sine Out',
                    '0.445,0.05,0.55,0.95'   => 'Sine In Out',

                    '0.55,0.085,0.68,0.53'   => 'Quad In',
                    '0.25,0.46,0.45,0.94'    => 'Quad Out',
                    '0.455,0.03,0.515,0.955' => 'Quad In Out',

                    '0.55,0.055,0.675,0.19'  => 'Cubic In',
                    '0.215,0.61,0.355,1'     => 'Cubic Out',
                    '0.645,0.045,0.355,1'    => 'Cubic In Out',

                    '0.895,0.03,0.685,0.22'  => 'Quart In',
                    '0.165,0.84,0.44,1'      => 'Quart Out',
                    '0.77,0,0.175,1'         => 'Quart In Out',

                    '0.895,0.03,0.685,0.22'  => 'Quint In',
                    '0.895,0.03,0.685,0.22'  => 'Quint Out',
                    '0.895,0.03,0.685,0.22'  => 'Quint In Out',

                    '0.95,0.05,0.795,0.035'  => 'Expo In',
                    '0.19,1,0.22,1'          => 'Expo Out',
                    '1,0,0,1'                => 'Expo In Out',

                    '0.6,0.04,0.98,0.335'    => 'Circ In',
                    '0.075,0.82,0.165,1'     => 'Circ Out',
                    '0.785,0.135,0.15,0.86'  => 'Circ In Out',

                    '0.6,-0.28,0.735,0.045'  => 'Back In',
                    '0.175,0.885,0.32,1.275' => 'Back Out',
                    '0.68,-0.55,0.265,1.55'  => 'Back In Out'
                ),
                'selectors' => array(
                    '{{WRAPPER}} [class*="aux-parallax-column"]' => 'transition-timing-function:cubic-bezier({{VALUE}});'
                ),
                'default'      => '',
                'return_value' => ''
            )
        );

        $this->add_control(
            'parallax_transition_duration',
            array(
                'label'     => __( 'Duration', 'auxin-shop' ) . ' (ms)',
                'type'      => Controls_Manager::NUMBER,
                'default'   => '',
                'min'       => 0,
                'step'      => 100,
                'selectors'    => array(
                    '{{WRAPPER}} [class*="aux-parallax-column"]' => 'transition-duration:{{SIZE}}ms;'
                ),
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
        'phone_cnum'          => $settings['columns_mobile'],
        'tablet_cnum'         => $settings['columns_tablet'],
        'desktop_cnum'        => $settings['columns'],
        'num'                 => $settings['num'],
        'display_title'       => $settings['display_title'],
        'display_price'       => $settings['display_price'],
        'display_share'       => $settings['display_share'],
        'display_wishlist'    => $settings['display_wishlist'],
        'display_categories'  => $settings['display_categories'],
        'display_sale_badge'  => $settings['display_sale_badge'],
        'image_aspect_ratio'  => $settings['image_aspect_ratio'],
        'preloadable'         => $settings['preloadable'],
        'preload_preview'     => $settings['preload_preview'],
        'preload_bgcolor'     => $settings['preload_bgcolor'],
        'display_add_to_cart' => $settings['display_add_to_cart'],
        'display_add_to_cart' => $settings['display_add_to_cart'],
        'colorized_shadow'    => $settings['colorized_shadow'],
        'tilt'                => $settings['tilt'],

        // Parallax section
        'wrapper_offset'      => $settings['wrapper_offset']['size'],
        'inset_offset'       => $settings['inset_offset']['size'],
        
        // Filter section
        'show_filters'        => $settings['show_filters'],
        'filter_by'           => $settings['filter_by'],
        'filter_style'        => $settings['filter_style'],
        'filter_align'        => $settings['filter_align'],

        // Query section
        'cat'                 => $settings['cat'],
        'order'               => $settings['order'],
        'offset'              => $settings['offset'],
        'include'             => $settings['include'],
        'exclude'             => $settings['exclude'],
        'order_by'            => $settings['order_by'],
        'only_products__in'   => $settings['only_products__in'],
        'exclude_without_media' => $settings['exclude_without_media'],
    );

    // // get the shortcode base blog page
    echo auxin_widget_products_parallax_callback( $args );

  }

}
