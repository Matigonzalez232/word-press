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
 * Elementor 'Recent_News' widget.
 *
 * Elementor widget that displays an 'Recent_News' with lightbox.
 *
 * @since 1.0.0
 */
class Recent_News extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve 'Recent_News' widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aux_recent_news';
    }

    /**
     * Get widget title.
     *
     * Retrieve 'Recent_News' widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Recent News', 'auxin-news' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve 'Recent_News' widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-posts-group auxin-badge-pro';
    }

    /**
     * Get widget categories.
     *
     * Retrieve 'Recent_News' widget icon.
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
     * Retrieve 'Recent_News' widget icon.
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
     * Register 'Recent_News' widget controls.
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

        $this->add_control(
            'header_position',
            array(
                'label'       => __('Load More Type','auxin-news' ),
                'type'        => 'aux-visual-select',
                'options'     => array(
                    'top'       => array(
                            'label' => __( 'Top Header', 'auxin-news' ),
                            'image' =>  AUXNEW_ADMIN_URL . '/assets/images/visual-select/recent-news-1.svg'
                    ),
                    'side'       => array(
                            'label' => __( 'Side Header', 'auxin-news' ),
                            'image' =>  AUXNEW_ADMIN_URL . '/assets/images/visual-select/recent-news-2.svg'
                    )
                ),
                'default'     => 'top'
            )
        );

        $this->add_responsive_control(
            'main_columns',
            array(
                'label'          => __( 'Big Column Width', 'auxin-news' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => '7',
                'tablet_default' => '7',
                'mobile_default' => '12',
                'options'        => array(
                    '1'  => '1/12',
                    '2'  => '2/12',
                    '3'  => '3/12',
                    '4'  => '4/12',
                    '5'  => '5/12',
                    '6'  => '6/12',
                    '7'  => '7/12',
                    '8'  => '8/12',
                    '9'  => '9/12',
                    '10' => '10/12',
                    '11' => '11/12',
                    '12' => '12/12'
                ),
                'frontend_available' => true,
                'condition'   => array(
                    'header_position' => 'side',
                )
            )
        );

        $this->add_responsive_control(
            'side_columns',
            array(
                'label'          => __( 'Side Column Width', 'auxin-news' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => '5',
                'tablet_default' => '5',
                'mobile_default' => '12',
                'options'        => array(
                    '1'  => '1/12',
                    '2'  => '2/12',
                    '3'  => '3/12',
                    '4'  => '4/12',
                    '5'  => '5/12',
                    '6'  => '6/12',
                    '7'  => '7/12',
                    '8'  => '8/12',
                    '9'  => '9/12',
                    '10' => '10/12',
                    '11' => '11/12',
                    '12' => '12/12'
                ),
                'frontend_available' => true,
                'condition'   => array(
                    'header_position' => 'side',
                )
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  filter_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'filter_section',
            array(
                'label' => __('Filter', 'auxin-news' ),
                'tab'   => Controls_Manager::TAB_LAYOUT
            )
        );

        $this->add_control(
            'show_filters',
            array(
                'label'        => __( 'Show filters', 'auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'title',
            array(
                'label'       => __('Widget Title','auxin-news' ),
                'type'        => Controls_Manager::TEXT,
                'condition'   => array(
                    'show_filters' => 'yes',
                )
            )
        );

        // $this->add_control(
        //     'filter_by',
        //     array(
        //         'label'       => __( 'Filter by', 'auxin-news' ),
        //         'description' => __( 'Filter by categories or tags', 'auxin-news' ),
        //         'type'        => Controls_Manager::SELECT,
        //         'default'     => 'news-category',
        //         'options'     => array(
        //             'news-category' => __( 'Categories', 'auxin-news' ),
        //             'news-tag'      => __( 'Tags', 'auxin-news')
        //         ),
        //         'condition'   => array(
        //             'show_filters' => 'yes',
        //         )
        //     )
        // );

        $this->add_control(
            'filter_colors',
            array(
                'label'        =>  __( 'Category Filter Color', 'auxin-news' ),
                'description'  => __( 'Enable category filter color', 'auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                // 'condition'   => array(
                //     'filter_by' => array( 'news-category' ),
                // )
            )
        );

        $this->add_control(
            'filter_style',
            array(
                'label'       => __( 'Filter button style', 'auxin-news' ),
                'description' => __( 'Style of filter buttons.', 'auxin-news' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'aux-slideup',
                'options'     => array(
                    'aux-slideup'   => __( 'Slide up', 'auxin-news' ),
                    'aux-fill'      => __( 'Fill', 'auxin-news' ),
                    'aux-cube'      => __( 'Cube', 'auxin-news' ),
                    'aux-underline' => __( 'Underline', 'auxin-news' ),
                    'aux-overlay'   => __( 'Float frame', 'auxin-news' ),
                    'aux-borderd'   => __( 'Borderd', 'auxin-news' ),
                    'aux-overlay aux-underline-anim'    => __( 'Float underline', 'auxin-news' )
                ),
                'condition'   => array(
                    'show_filters' => 'yes',
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
            'show_image',
            array(
                'label'        => __( 'Show posts image', 'auxin-news' ),
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
                    'show_image' => 'yes',
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
            'show_header',
            array(
                'label'        => __( 'Show big post', 'auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'show_title',
            array(
                'label'        => __( 'Insert news title', 'auxin-news' ),
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
                    'show_title' => 'yes',
                )
            )
        );

        $this->add_control(
            'show_info',
            array(
                'label'        => __( 'Insert news info', 'auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'info_position',
            array(
                'label'       => __('Post info position', 'auxin-news' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'after_title',
                'options'     => array(
                    'before_title' => __( 'Before Title', 'auxin-news' ),
                    'after_title' => __( 'After Title', 'auxin-news' )
                ),
                'condition'   => array(
                    'show_info' => 'yes',
                )
            )
        );

        $this->add_control(
            'show_categories',
            array(
                'label'        => __( 'Insert news categories', 'auxin-news' ),
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
            'show_author',
            array(
                'label'        => __( 'Insert news author', 'auxin-news' ),
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
            'show_date',
            array(
                'label'        => __( 'Insert news date', 'auxin-news' ),
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
            'author_or_readmore',
            array(
                'label'       => __('Display author or read more', 'auxin-news'),
                'label_block' => true,
                'description' => __('Specifies whether to show author or read more on each post.', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'none',
                'options'     => array(
                    'readmore' => __('Read More', 'auxin-news'),
                    'author'   => __('Author Name', 'auxin-news'),
                    'none'     => __('None', 'auxin-news')
                ),
                'label_block' => true
            )
        );

        $this->add_control(
            'display_comments',
            array(
                'label'        => __('Display Comments Number', 'auxin-news' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'auxin-news' ),
                'label_off'    => __( 'Off', 'auxin-news' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'   => array(
                    'author_or_readmore!' => 'none',
                )
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
                'default'      => 'no',
                'condition'   => array(
                    'author_or_readmore!' => 'none',
                )
            )
        );

        $this->add_control(
            'big_content',
            array(
                'label'       => __( 'Big Post Content Length', 'auxin-news' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '25',
                'condition'   => array(
                    'show_header' => 'yes',
                )
            )
        );

        $this->add_control(
            'content',
            array(
                'label'       => __( 'Content Length', 'auxin-news' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '0',
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
                    'show_image' => 'yes',
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
                    'custom' => __('Custom'         , 'auxin-news')
                ),
                'condition' => array(
                    'show_image' => 'yes',
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
            'big_image_aspect_ratio',
            array(
                'label'       => __('Big Post Image aspect ratio', 'auxin-news'),
                'type'        => Controls_Manager::SELECT,
                'default'     => '0.75',
                'options'     => array(
                    '0.75'   => __('Horizontal 4:3' , 'auxin-news'),
                    '0.56'   => __('Horizontal 16:9', 'auxin-news'),
                    '1.00'   => __('Square 1:1'     , 'auxin-news'),
                    '1.33'   => __('Vertical 3:4'   , 'auxin-news'),
                    'custom' => __('Custom'         , 'auxin-news')
                ),
                'condition' => array(
                    'show_image' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'big_image_aspect_ratio_custom',
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
                    'big_image_aspect_ratio' => 'custom',
                ),
            )
        );

        $this->add_responsive_control(
            'img_border_radius',
            array(
                'label'      => __( 'Border Radius', 'auxin-news' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .entry-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ),
                'condition'  => array(
                    'show_image' => 'yes',
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
                    'show_title' => 'yes',
                ),
            )
        );

        $this->add_control(
            'big_title',
            [
                'label' => __( 'Big Post Title', 'auxin-news' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition' => array(
                    'show_header' => 'yes',
                    'show_title'  => 'yes',
                ),
            ]
        );

        $this->start_controls_tabs( 'big_title_colors' );

        $this->start_controls_tab(
            'big_title_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-news' ),
                'condition' => array(
                    'show_header' => 'yes',
                    'show_title'  => 'yes',
                ),
            )
        );

        $this->add_control(
            'big_title_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .auxnew-big-post .entry-title a' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_header' => 'yes',
                    'show_title'  => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'big_title_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-news' ),
                'condition' => array(
                    'show_header' => 'yes',
                    'show_title'  => 'yes',
                ),
            )
        );

        $this->add_control(
            'big_title_hover_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .auxnew-big-post .entry-title a:hover' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_header' => 'yes',
                    'show_title'  => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'big_title_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .auxnew-big-post .entry-title, {{WRAPPER}} .auxnew-big-post .entry-title a',
                'condition' => array(
                    'show_header' => 'yes',
                    'show_title'  => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'big_title_margin_bottom',
            array(
                'label' => __( 'Bottom space', 'auxin-news' ),
                'type' => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .auxnew-big-post .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'show_header' => 'yes',
                    'show_title'  => 'yes',
                ),
            )
        );

        $this->add_control(
            'normal_title',
            [
                'label' => __( 'Normal Title', 'auxin-news' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition' => array(
                    'show_header' => 'yes',
                    'show_title'  => 'yes',
                ),
            ]
        );

        $this->start_controls_tabs( 'title_colors' );

        $this->start_controls_tab(
            'title_color_normal',
            array(
                'label' => __( 'Normal' , 'auxin-news' ),
                'condition' => array(
                    'show_title' => 'yes',
                ),
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-small-posts .entry-title a' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_title' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-news' ),
                'condition' => array(
                    'show_title' => 'yes',
                ),
            )
        );

        $this->add_control(
            'title_hover_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-small-posts .entry-title a:hover' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'show_title' => 'yes',
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
                'selector' => '{{WRAPPER}} .aux-small-posts .entry-title',
                'condition' => array(
                    'show_title' => 'yes',
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
                    '{{WRAPPER}} .aux-small-posts .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'show_title' => 'yes',
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
                    'show_info' => 'yes'
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
                'tab'       => Controls_Manager::TAB_STYLE
            )
        );

        $this->add_control(
            'content_color',
            array(
                'label' => __( 'Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .entry-content' => 'color: {{VALUE}};',
                )
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'content_typography',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .entry-content'
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
                )
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  content_style_section
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
                'label' => __( 'Normal' , 'auxin-news' ),
                'condition' => array(
                    'show_title' => 'yes',
                ),
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
                    '{{WRAPPER}} .entry-badge a' => 'color: {{VALUE}};',
                )
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'badge_color_hover',
            array(
                'label' => __( 'Hover' , 'auxin-news' ),
                'condition' => array(
                    'show_title' => 'yes',
                ),
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
                    '{{WRAPPER}} .entry-badge a:hover' => 'color: {{VALUE}};',
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
        /*  filter_style_section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'filter_style_section',
            array(
                'label'     => __( 'Filter', 'auxin-news' ),
                'tab'       => Controls_Manager::TAB_STYLE
            )
        );

        $this->add_control(
            'filter_title_color',
            array(
                'label' => __( 'Title Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-news-element-title' => 'color: {{VALUE}};',
                )
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'filter_title_typography',
                'label' => __( 'Title Typography', 'auxin-news' ),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .aux-news-element-title'
            )
        );


        $this->add_control(
            'filter_item_color',
            array(
                'label' => __( 'Filters Color', 'auxin-news' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .aux-filters li > a' => 'color: {{VALUE}};',
                )
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'filter_item_typography',
                'label' => __( 'Filters Typography', 'auxin-news' ),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .aux-filters li > a'
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
        'header_position'             => $settings['header_position'],
        'main_desktop_cnum'           => $settings['main_columns'],
        'main_tablet_cnum'            => $settings['main_columns_tablet'],
        'main_phone_cnum'             => $settings['main_columns_mobile'],
        'side_desktop_cnum'           => $settings['side_columns'],
        'side_tablet_cnum'            => $settings['side_columns_tablet'],
        'side_phone_cnum'             => $settings['side_columns_mobile'],

        // Filter section
        'show_filters'                => $settings['show_filters'],
        'title'                       => $settings['title'],
        'filter_by'                   => 'news-category'/*$settings['filter_by']*/,
        'filter_colors'               => $settings['filter_colors'],
        'filter_style'                => $settings['filter_style'],

        // Display section
        'preloadable'                 => $settings['preloadable'],
        'preload_preview'             => $settings['preload_preview'],
        'preload_bgcolor'             => $settings['preload_bgcolor'],
        'show_header'                 => $settings['show_header'],
        'show_image'                  => $settings['show_image'],
        'show_title'                  => $settings['show_title'],
        'words_num'                   => $settings['words_num'],
        'show_info'                   => $settings['show_info'],
        'show_badge'                  => $settings['show_badge'],
        'info_position'               => $settings['info_position'],
        'display_comments'            => $settings['display_comments'],
        'display_like'                => $settings['display_like'],
        'show_categories'             => $settings['show_categories'],
        'show_author'                 => $settings['show_author'],
        'show_date'                   => $settings['show_date'],
        'author_or_readmore'          => $settings['author_or_readmore'],
        'content'                     => $settings['content'],
        'big_content'                 => $settings['big_content'],

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

        // Image section
        'image_aspect_ratio'          => $settings['image_aspect_ratio'] === 'custom' ? $settings['image_aspect_ratio_custom']['size'] : $settings['image_aspect_ratio'],
        'big_image_aspect_ratio'      => $settings['big_image_aspect_ratio'] === 'custom' ? $settings['big_image_aspect_ratio_custom']['size'] : $settings['big_image_aspect_ratio'],

    );

    echo auxin_widget_recent_news_callback( $args );

  }

}
