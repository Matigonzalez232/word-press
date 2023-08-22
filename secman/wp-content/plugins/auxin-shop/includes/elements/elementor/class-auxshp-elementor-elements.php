<?php
namespace Auxin\Plugin\Shop\Elementor;

/**
 * Auxin Elementor Elements
 *
 * Custom Elementor extension.
 *
 * 
 * @package    
 * @license    LICENSE.txt
 * @author     averta <info@averta.net>
 * @link       https://bitbucket.org/averta/
 * @copyright  (c) 2010-2023 averta <info@averta.net>
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Shop Elementor Elements Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Elements {


    /**
     * Default elementor dit path
     *
     * @since 1.0.0
     *
     * @var string The defualt path to elementor dir on this plugin.
     */
    private $dir_path = '';


    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var Auxin_Elementor_Core_Elements The single instance of the class.
    */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return Auxin_Elementor_Core_Elements An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
          self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
    */
    public function init() {

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            return;
        }

        // Define elementor dir path
        $this->dir_path = AUXSHP_INC_DIR . '/elements/elementor';

        // Include core files
        $this->includes();

        // Add required hooks
        $this->hooks();
    }

    /**
     * Include Files
     *
     * Load required core files.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function includes() {

    }

    /**
     * Add hooks
     *
     * Add required hooks for extending the Elementor.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function hooks() {

        // Register controls, widgets, and categories
        add_action( 'auxin/core_elements/elementor/widgets_list', array( $this, 'register_widgets' ) );

        // Register Widget Styles
        // add_action( 'elementor/frontend/after_enqueue_styles'   , array( $this, 'widget_styles' ) );

        // Register Widget Scripts
        // add_action( 'elementor/frontend/after_register_scripts' , array( $this, 'widget_scripts' ) );

        // Register Admin Scripts
        // add_action( 'elementor/editor/before_enqueue_scripts'   , array( $this, 'editor_scripts' ) );

        // Register dynamic tags
        add_action( 'elementor/dynamic_tags/register', [ $this, 'register_tag' ] );
    }

    /**
     * Register widgets
     *
     * Register all widgets which are in widgets list.
     *
     * @access public
     */
    public function register_widgets( $widgets ) {

        $widgets['500'] = array(
            'file'  => $this->dir_path . '/widgets/recent-products-carousel.php',
            'class' => __NAMESPACE__ . '\Elements\RecentProductsCarousel'
        );

        $widgets['510'] = array(
            'file'  => $this->dir_path . '/widgets/products-parallax.php',
            'class' => __NAMESPACE__ . '\Elements\ProductsParallax'
        );

        $widgets['520'] = array(
            'file'  => $this->dir_path . '/widgets/advanced-recent-products.php',
            'class' => __NAMESPACE__ . '\Elements\AdvancedRecentProducts'
        );
        return $widgets;
    }

    /**
     * Enqueue styles.
     *
     * Enqueue all the frontend styles.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function widget_styles() {

    }

    /**
     * Enqueue scripts.
     *
     * Enqueue all the frontend scripts.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function widget_scripts() {

    }

    /**
     * Enqueue scripts.
     *
     * Enqueue all the backend scripts.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function editor_scripts() {
        // Elementor Custom Style
    }

    /**
	 * @param \Elementor\Core\DynamicTags\Manager $dynamic_tags
	 */
	public function register_tag( $dynamic_tags ) {

        $tags = array(
			'aux-products-url' => array(
                'file'  => AUXSHP_INC_DIR . '/elements/elementor/dynamic-tags/products-url.php',
				'class' => 'DynamicTags\Auxin_Products_Url',
				'group' => 'URL',
				'title' => 'URL',
			)
        );

        foreach ( $tags as $tags_type => $tags_info ) {
            if( ! empty( $tags_info['file'] ) && ! empty( $tags_info['class'] ) ){
				// In our Dynamic Tag we use a group named request-variables so we need
				// To register that group as well before the tag
				\Elementor\Plugin::instance()->dynamic_tags->register_group( $tags_info['group'] , [
					'title' => $tags_info['title']
				] );

                include_once( $tags_info['file'] );
                if( class_exists( $tags_info['class'] ) ){
                    $class_name = $tags_info['class'];
                } elseif( class_exists( __NAMESPACE__ . '\\' . $tags_info['class'] ) ){
                    $class_name = __NAMESPACE__ . '\\' . $tags_info['class'];
                }
				$dynamic_tags->register( new $class_name() );
            }
        }
	}

}

Elements::instance();