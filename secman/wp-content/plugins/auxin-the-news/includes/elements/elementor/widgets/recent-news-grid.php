<?php
namespace Auxin\Plugin\News\Elementor\Elements;

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
use Elementor\Group_Control_Background;


if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Elementor 'Recent_News_Grid_Carousel' widget.
 *
 * Elementor widget that displays an 'Recent_News_Grid_Carousel' with lightbox.
 *
 * @since 1.0.0
 */
class Recent_News_Grid_Carousel extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve 'Recent_News_Grid_Carousel' widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aux_recent_news_grid';
    }

    /**
     * Get widget title.
     *
     * Retrieve 'Recent_News_Grid_Carousel' widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Grid & Carousel News', 'auxin-news' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve 'Recent_News_Grid_Carousel' widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-posts-grid auxin-badge-pro';
    }

    /**
     * Get widget categories.
     *
     * Retrieve 'Recent_News_Grid_Carousel' widget icon.
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
     * Retrieve 'Recent_News_Grid_Carousel' widget icon.
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
                'taxonomy'   => 'news-category',
                'orderby'    => 'count',
                'hide_empty' => true
            )
        );

        // Then create a list
        $list  = array( ' ' => __('All Categories', 'auxin-news' ) ) ;

        if ( ! is_wp_error( $terms ) && is_array( $terms ) ){
            foreach ( $terms as $key => $value ) {
                $list[$value->term_id] = $value->name;
            }
        }

        return $list;
    }

    /**
     * Register 'Recent_News_Grid_Carousel' widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*  layout_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'layout_section',
            array(
                'label' => __('Layout', 'auxin-news' ),
                'tab'   => Controls_Manager::TAB_LAYOUT
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label'          => __( 'Columns', 'auxin-news' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => '4',
                'tablet_default' => 'inherit',
                'mobile_default' => '1',
                'options'        => array(
                    'inherit' => __( 'Inherited from larger', 'auxin-news' ),
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
            'preview_mode',
            array(
                'label'       => __('Display items as', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'grid',
                'options'     => array(
                    'grid'           => __( 'Grid', 'auxin-news' ),
                    'grid-table'     => __( 'Grid - Table Style', 'auxin-news' ),
                    'grid-modern'    => __( 'Grid - Modern Style', 'auxin-news' ),
                    'carousel-modern'=> __( 'Carousel - Modern Style', 'auxin-news' ),
                    'carousel'       => __( 'Carousel', 'auxin-news' )
                )
            )
        );

        $this->add_control(
            'content_layout',
            array(
                'label'       => __('Content layout', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'default',
                'options'     => array(
                    'default'     => __('Full Content', 'auxin-news'),
                    'entry-boxed' => __('Boxed Content', 'auxin-news')
                ),
                'condition'   => array(
                    'preview_mode' => array( 'grid', 'grid-table', 'grid-modern' ),
                )
            )
        );

        $this->add_control(
            'grid_table_hover',
            array(
                'label'       => __('Mouse Over Effect', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'label_block' => true,
                'default'     => 'bgimage-bgcolor',
                'options'     => array(
                    'bgcolor'         => __( 'Background color', 'auxin-news' ),
                    'bgimage'         => __( 'Cover image', 'auxin-news' ),
                    'bgimage-bgcolor' => __( 'Cover image or background color', 'auxin-news' ),
                    'none'            => __( 'Nothing', 'auxin-news' )
                ),
                'condition'   => array(
                    'preview_mode' => array( 'grid', 'grid-table', 'grid-modern' ),
                )
            )
        );

        $this->add_control(
            'carousel_space',
            array(
                'label'       => __( 'Column space', 'auxin-news' ),
                'description' => __( 'Specifies horizontal space between items (pixel).', 'auxin-news' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '30',
                'condition'   => array(
                    'preview_mode' => array( 'carousel-modern', 'carousel' ),
                )
            )
        );

        $this->add_control(
            'carousel_navigation',
            array(
                'label'       => __('Navigation type', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'peritem',
                'options'     => array(
                   'peritem' => __('Move per column', 'auxin-news'),
                   'perpage' => __('Move per page', 'auxin-news'),
                   'scroll'  => __('Smooth scroll', 'auxin-news')
                ),
                'condition'   => array(
                    'preview_mode' => array( 'carousel', 'carousel-modern' ),
                )
            )
        );

        $this->add_control(
            'carousel_navigation_control',
            array(
                'label'       => __('Navigation control', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'bullets',
                'options'     => array(
                    ''        => __('None', 'auxin-news'),
                    'arrows'  => __('Arrows', 'auxin-news'),
                    'bullets' => __('Bullets', 'auxin-news')
                ),
                'condition'   => array(
                    'preview_mode' => array( 'carousel', 'carousel-modern' ),
                )
            )
        );

        $this->add_control(
            'carousel_nav_control_pos',
            array(
                'label'       => __('Control Position', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'center',
                'options'     => array(
                   'center'         => __('Center', 'auxin-news'),
                   'side'           => __('Side', 'auxin-news')
                ),
                'condition'   => array(
                    'carousel_navigation_control' => 'arrows',
                )
            )
        );

        $this->add_control(
            'carousel_nav_control_skin',
            array(
                'label'       => __('Control Skin', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'boxed',
                'options'     => array(
                   'boxed' => __('boxed', 'auxin-news'),
                   'long'  => __('Long Arrow', 'auxin-news')
                ),
                'condition'   => array(
                    'carousel_navigation_control' => 'arrows',
                )
            )
        );

        $this->add_control(
            'carousel_loop',
            array(
                'label'        => __('Loop navigation','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'   => array(
                    'preview_mode' => array( 'carousel', 'carousel-modern' ),
                )
            )
        );

        $this->add_control(
            'carousel_autoplay',
            array(
                'label'        => __('Autoplay carousel','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'   => array(
                    'preview_mode' => array( 'carousel', 'carousel-modern' ),
                )
            )
        );

        $this->add_control(
            'carousel_autoplay_delay',
            array(
                'label'       => __( 'Autoplay delay', 'auxin-news' ),
                'description' => __('Specifies the delay between auto-forwarding in seconds.', 'auxin-news' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '2',
                'condition'   => array(
                    'preview_mode' => array( 'carousel', 'carousel-modern' ),
                )
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  display_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'display_section',
            array(
                'label' => __('Display', 'auxin-news' ),
                'tab'   => Controls_Manager::TAB_LAYOUT
            )
        );

        $this->add_control(
            'show_media',
            array(
                'label'        => __('Display post media (image, video, etc)','auxin-news' ),
                'label_block'  => true,
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'label_block'  => true
            )
        );

        $this->add_control(
            'preloadable',
            array(
                'label'        => __('Preload image','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => array(
                    'show_media' => 'yes',
                )
            )
        );

        $this->add_control(
            'preload_preview',
            array(
                'label'        => __('While loading image display','auxin-news' ),
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
                'label'     => __( 'Placeholder color while loading image', 'auxin-news' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => array(
                    'preloadable'     => 'yes',
                    'preload_preview' => array('simple-spinner', 'simple-spinner-light', 'simple-spinner-dark')
                )
            )
        );

        $this->add_control(
            'display_title',
            array(
                'label'        => __('Display post title', 'auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'words_num',
            array(
                'label'       => __( 'Title Trim', 'auxin-news' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '',
                'condition'   => array(
                    'display_title' => 'yes',
                )
            )
        );

        $this->add_control(
            'show_info',
            array(
                'label'        => __('Display post info','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'post_info_position',
            array(
                'label'       => __('Post info position', 'auxin-news' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'after-title',
                'options'     => array(
                    'after-title'  => __('After Title' , 'auxin-news' ),
                    'before-title' => __('Before Title', 'auxin-news' )
                ),
                'condition'   => array(
                    'show_info' => 'yes',
                )
            )
        );

        $this->add_control(
            'display_categories',
            array(
                'label'        => __('Display Categories','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'   => array(
                    'show_info' => 'yes',
                )
            )
        );

        $this->add_control(
            'show_badge',
            array(
                'label'        => __('Display Category Badge', 'auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'no'
            )
        );

        $this->add_control(
            'show_date',
            array(
                'label'        => __('Display Date','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'   => array(
                    'show_info' => 'yes',
                )
            )
        );

        $this->add_control(
            'show_content',
            array(
                'label'        => __('Display post content','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'display_like',
            array(
                'label'        => __('Display like button', 'auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'show_excerpt',
            array(
                'label'        => __('Display excerpt','auxin-news' ),
                'description'  => __('Enable it to display post summary instead of full content.','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'excerpt_len',
            array(
                'label'       => __('Excerpt length','auxin-news' ),
                'description' => __('Specify summary content in character.','auxin-news' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '160',
                'condition'   => array(
                    'show_excerpt' => 'yes',
                )
            )
        );

        $this->add_control(
            'author_or_readmore',
            array(
                'label'       => __('Display author or read more', 'auxin-news'),
                'label_block' => true,
                'description' => __('Specifies whether to show author or read more on each post.', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'readmore',
                'options'     => array(
                    'readmore' => __('Read More', 'auxin-news'),
                    'author'   => __('Author Name', 'auxin-news'),
                    'none'     => __('None', 'auxin-news')
                ),
                'label_block' => true
            )
        );

        $this->add_control(
            'content_width',
            array(
                'label'       => __('Content Width', 'auxin-news' ),
                'description' => __('Set content width on this element.', 'auxin-news' ),
                'type'        => Controls_Manager::NUMBER,
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  query_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'query_section',
            array(
                'label'      => __('Query', 'auxin-news' ),
            )
        );

        $this->add_control(
            'cat',
            array(
                'label'       => __('Categories', 'auxin-news'),
                'description' => __('Specifies a category that you want to show posts from it.', 'auxin-news' ),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => $this->get_terms(),
                'default'     => array( ' ' ),
            )
        );

        $this->add_control(
            'num',
            array(
                'label'       => __('Number of posts to show', 'auxin-news'),
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
                'label'        => __('Exclude posts without media','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'no'
            )
        );

        $this->add_control(
            'exclude_custom_post_formats',
            array(
                'label'        => __('Exclude custom post formats','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $this->add_control(
            'exclude_quote_link',
            array(
                'label'        => __('Exclude quote and link post formats','auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => array(
                    'exclude_custom_post_formats' => 'yes',
                )
            )
        );

        $this->add_control(
            'order_by',
            array(
                'label'       => __('Order by', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'date',
                'options'     => array(
                    'date'            => __('Date', 'auxin-news'),
                    'menu_order date' => __('Menu Order', 'auxin-news'),
                    'title'           => __('Title', 'auxin-news'),
                    'ID'              => __('ID', 'auxin-news'),
                    'rand'            => __('Random', 'auxin-news'),
                    'comment_count'   => __('Comments', 'auxin-news'),
                    'modified'        => __('Date Modified', 'auxin-news'),
                    'author'          => __('Author', 'auxin-news'),
                    'post__in'        => __('Inserted Post IDs', 'auxin-news')
                ),
            )
        );

        $this->add_control(
            'order',
            array(
                'label'       => __('Order', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'DESC',
                'options'     => array(
                    'DESC'          => __('Descending', 'auxin-news'),
                    'ASC'           => __('Ascending', 'auxin-news'),
                ),
            )
        );

        $this->add_control(
            'only_posts__in',
            array(
                'label'       => __('Only posts','auxin-news' ),
                'description' => __('If you intend to display ONLY specific posts, you should specify the posts here. You have to insert the post IDs that are separated by comma (eg. 53,34,87,25).', 'auxin-news' ),
                'type'        => Controls_Manager::TEXT
            )
        );

        $this->add_control(
            'include',
            array(
                'label'       => __('Include posts','auxin-news' ),
                'description' => __('If you intend to include additional posts, you should specify the posts here. You have to insert the Post IDs that are separated by comma (eg. 53,34,87,25)', 'auxin-news' ),
                'type'        => Controls_Manager::TEXT
            )
        );

        $this->add_control(
            'exclude',
            array(
                'label'       => __('Exclude posts','auxin-news' ),
                'description' => __('If you intend to exclude specific posts from result, you should specify the posts here. You have to insert the Post IDs that are separated by comma (eg. 53,34,87,25)', 'auxin-news' ),
                'type'        => Controls_Manager::TEXT
            )
        );

        $this->add_control(
            'offset',
            array(
                'label'       => __('Start offset','auxin-news' ),
                'description' => __('Number of post to displace or pass over.', 'auxin-news' ),
                'type'        => Controls_Manager::NUMBER
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  paginate_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'paginate_section',
            array(
                'label'      => __('Paginate', 'auxin-news' ),
            )
        );

        $this->add_control(
            'loadmore_type',
            array(
                'label'       => __('Load More Type','auxin-news' ),
                'type'        => 'aux-visual-select',
                'options'     => array(
                    ''       => array(
                        'label' => __('None', 'auxin-news' ),
                        'image' => AUXIN_URL . 'images/visual-select/load-more-none.svg'
                    ),
                    'scroll' => array(
                        'label' => __('Infinite Scroll', 'auxin-news' ),
                        'image' => AUXIN_URL . 'images/visual-select/load-more-infinite.svg'
                    ),
                    'next'   => array(
                        'label' => __('Next Button', 'auxin-news' ),
                        'image' => AUXIN_URL . 'images/visual-select/load-more-button.svg'
                    ),
                    'next-prev'  => array(
                        'label' => __('Next Prev', 'auxin-news' ),
                        'image' => AUXIN_URL . 'images/visual-select/load-more-next-prev.svg'
                    )
                ),
                'default'     => ''
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  image_style_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'image_style_section',
            array(
                'label'     => __( 'Image', 'auxin-news' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_media' => 'yes',
                ),
            )
        );

        $this->add_control(
            'image_aspect_ratio',
            array(
                'label'       => __('Image aspect ratio', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => '0.75',
                'options'     => array(
                    '0.75'   => __('Horizontal 4:3' , 'auxin-news'),
                    '0.56'   => __('Horizontal 16:9', 'auxin-news'),
                    '1.00'   => __('Square 1:1'     , 'auxin-news'),
                    '1.33'   => __('Vertical 3:4'   , 'auxin-news'),
                    'custom' => __('Custom'         , 'auxin-news'),
                ),
                'condition' => array(
                    'show_media' => 'yes',
                ),
            )
        );


        $this->add_responsive_control(
            'image_aspect_ratio_custom',
            array(
                'label' => __( 'Custom Aspect Ratio', 'auxin-news' ),
                'type' => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 3,
                        'step' => 0.1
                    ),
                ),
                'condition' => array(
                    'image_aspect_ratio' => 'custom',
                ),
            )
        );

        $this->add_control(
            'img_border_radius',
            array(
                'label'      => __( 'Border Radius', 'auxin-news' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .entry-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
                'condition'  => array(
                    'show_media' => 'yes',
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
                'label'     => __( 'Title', 'auxin-news' ),
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
                'label' => __( 'Normal' , 'auxin-news' ),
                'condition' => array(
                    'display_title' => 'yes',
                ),
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .entry-title a' => 'color: {{VALUE}};',
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
                'label' => __( 'Hover' , 'auxin-news' ),
                'condition' => array(
                    'display_title' => 'yes',
                ),
            )
        );

        $this->add_control(
            'title_hover_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .entry-title a:hover' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .entry-title',
                'condition' => array(
                    'display_title' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'title_margin_bottom',
            array(
                'label' => __( 'Bottom space', 'auxin-news' ),
                'type' => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'display_title' => 'yes',
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
                'label'     => __( 'Post Info', 'auxin-news' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_info' => 'yes',
                ),
            )
        );

        $this->start_controls_tabs( 'info_colors' );

        $this->start_controls_tab(
            'info_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-news' ),
                'condition' => array(
                    'show_info' => 'yes',
                ),
            )
        );

        $this->add_control(
            'info_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .entry-info a, {{WRAPPER}} .entry-info' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_info' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'info_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-news' ),
                'condition' => array(
                    'show_info' => 'yes',
                ),
            )
        );

        $this->add_control(
            'info_hover_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .entry-info a:hover' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_info' => 'yes',
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
                'selector' => '{{WRAPPER}} .entry-info, {{WRAPPER}} .entry-info a',
                'condition' => array(
                    'show_info' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'info_margin_bottom',
            array(
                'label' => __( 'Bottom space', 'auxin-news' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100
                    )
                ),
                'selectors' => array(
                    '{{WRAPPER}} .entry-info' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ),
                'condition' => array(
                    'show_info' => 'yes'
                )
            )
        );

        $this->add_responsive_control(
            'info_spacing_between',
            array(
                'label' => __( 'Space between metas', 'auxin-news' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 30
                    )
                ),
                'selectors' => array(
                    '{{WRAPPER}} .entry-info [class^="entry-"] + [class^="entry-"]:before, {{WRAPPER}} .entry-info .entry-tax a:after' =>
                    'margin-right: {{SIZE}}{{UNIT}}; margin-left: {{SIZE}}{{UNIT}};'
                ),
                'condition' => array(
                    'show_excerpt' => 'yes'
                )
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  content_style_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'content_style_section',
            array(
                'label'     => __( 'Excerpt', 'auxin-news' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_excerpt' => 'yes',
                )
            )
        );

        $this->add_control(
            'content_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .entry-content' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_excerpt' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'content_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-content',
                'condition' => array(
                    'show_excerpt' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'content_margin_bottom',
            array(
                'label' => __( 'Bottom space', 'auxin-news' ),
                'type' => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .entry-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'show_excerpt' => 'yes',
                ),
            )
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  badge_style_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'badge_style_section',
            array(
                'label'     => __( 'Badge', 'auxin-news' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_badge' => 'yes',
                )
            )
        );

        $this->start_controls_tabs( 'badge_colors' );

        $this->start_controls_tab(
            'badge_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-news' )
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'badge_background_color',
                'label' => __( 'Background', 'auxin-news' ),
                'types' => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .entry-badge',
            )
        );

        $this->add_control(
            'badge_text_color',
            array(
                'label' => __( 'Text', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .entry-badge a' => 'color: {{VALUE}} !important;',
                )
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'badge_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-news' )
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'badge_hover_background_color',
                'label' => __( 'Background', 'auxin-news' ),
                'types' => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .entry-badge:hover',
            )
        );

        $this->add_control(
            'badge_hover_text_color',
            array(
                'label' => __( 'Text', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .entry-badge a:hover' => 'color: {{VALUE}} !important;',
                )
            )
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'badge_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-badge a'
            )
        );


        $this->add_responsive_control(
            'button_padding',
            array(
                'label'      => __( 'Padding', 'auxin-news' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .entry-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                )
            )
        );

        $this->add_responsive_control(
            'badge_margin_bottom',
            array(
                'label' => __( 'Bottom space', 'auxin-news' ),
                'type' => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .entry-badge' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                )
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  meta_style_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'meta_style_section',
            array(
                'label'      => __( 'Meta', 'auxin-news' ),
                'tab'        => Controls_Manager::TAB_STYLE
            )
        );

        $this->start_controls_tabs( 'meta_colors' );

        $this->start_controls_tab(
            'meta_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-news' ),
            )
        );

        $this->add_control(
            'meta_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .entry-meta a, {{WRAPPER}} .entry-meta, {{WRAPPER}} .entry-meta span' => 'color: {{VALUE}}; background: transparent;',
                )
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'meta_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-news' )
            )
        );

        $this->add_control(
            'meta_hover_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .entry-meta a:hover, {{WRAPPER}} .entry-meta span:hover' => 'color: {{VALUE}};',
                )
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'meta_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-meta, {{WRAPPER}} .entry-meta a, {{WRAPPER}} .entry-meta span'
            )
        );

        $this->add_responsive_control(
            'meta_margin_bottom',
            array(
                'label' => __( 'Bottom space', 'auxin-news' ),
                'type' => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .entry-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
        // Display section
        'show_media'                  => $settings['show_media'],
        'preloadable'                 => $settings['preloadable'],
        'preload_preview'             => $settings['preload_preview'],
        'preload_bgcolor'             => $settings['preload_bgcolor'],
        'display_title'               => $settings['display_title'],
        'words_num'                   => $settings['words_num'],
        'show_info'                   => $settings['show_info'],
        'post_info_position'          => $settings['post_info_position'],
        'display_like'                => $settings['display_like'],
        'show_content'                => $settings['show_content'],
        'display_categories'          => $settings['display_categories'],
        'show_badge'                  => $settings['show_badge'],
        'show_date'                   => $settings['show_date'],
        'show_excerpt'                => $settings['show_excerpt'],
        'excerpt_len'                 => $settings['excerpt_len'],
        'author_or_readmore'          => $settings['author_or_readmore'],
        'content_width'               => $settings['content_width'],

        // Content Section
        'desktop_cnum'                => $settings['columns'],
        'tablet_cnum'                 => $settings['columns_tablet'],
        'phone_cnum'                  => $settings['columns_mobile'],
        'preview_mode'                => $settings['preview_mode'],
        'content_layout'              => $settings['content_layout'],
        'grid_table_hover'            => $settings['grid_table_hover'],
        'carousel_space'              => $settings['carousel_space'],
        'carousel_navigation'         => $settings['carousel_navigation'],
        'carousel_navigation_control' => $settings['carousel_navigation_control'],
        'carousel_nav_control_pos'    => $settings['carousel_nav_control_pos'],
        'carousel_nav_control_skin'   => $settings['carousel_nav_control_skin'],
        'carousel_loop'               => $settings['carousel_loop'],
        'carousel_autoplay'           => $settings['carousel_autoplay'],
        'carousel_autoplay_delay'     => $settings['carousel_autoplay_delay'],

        // Query Section
        'cat'                         => $settings['cat'],
        'num'                         => $settings['num'],
        'exclude_without_media'       => $settings['exclude_without_media'],
        'exclude_custom_post_formats' => $settings['exclude_custom_post_formats'],
        'exclude_quote_link'          => $settings['exclude_quote_link'],
        'order_by'                    => $settings['order_by'],
        'order'                       => $settings['order'],
        'only_posts__in'              => $settings['only_posts__in'],
        'include'                     => $settings['include'],
        'exclude'                     => $settings['exclude'],
        'offset'                      => $settings['offset'],

        // Paginate Section
        'loadmore_type'               => $settings['loadmore_type'],

        // Style Section
        'image_aspect_ratio'          => $settings['image_aspect_ratio'] === 'custom' ? $settings['image_aspect_ratio_custom']['size'] : $settings['image_aspect_ratio'],
    );

    // get the shortcode base blog page
    echo auxin_widget_recent_news_grid_callback( $args );

  }

}
