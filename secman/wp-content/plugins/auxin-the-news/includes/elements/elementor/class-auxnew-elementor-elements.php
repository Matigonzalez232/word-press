<?php
namespace Auxin\Plugin\News\Elementor;

/**
 * Auxin Elementor Elements
 *
 * Custom Elementor extension.
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Main Auxin Elementor Elements Class
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
        $this->dir_path = AUXNEW_INC_DIR . '/elements/elementor';

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

        // let Elementor pro override single news template
        add_filter( 'elementor/theme/need_override_location', array( $this, 'aux_elementor_pro_override_templates' ) );
        // Register Widget Styles
        // add_action( 'elementor/frontend/after_enqueue_styles'   , array( $this, 'widget_styles' ) );

        // Register Widget Scripts
        // add_action( 'elementor/frontend/after_register_scripts' , array( $this, 'widget_scripts' ) );

        // Register Admin Scripts
        // add_action( 'elementor/editor/before_enqueue_scripts'   , array( $this, 'editor_scripts' ) );
    }

    /**
     * Register widgets
     *
     * Register all widgets which are in widgets list.
     *
     * @access public
     */
    public function register_widgets( $widgets ) {

        $widgets['610'] = array(
            'file'  => $this->dir_path . '/widgets/recent-news.php',
            'class' => __NAMESPACE__ . '\Elements\Recent_News'
        );

        $widgets['620'] = array(
            'file'  => $this->dir_path . '/widgets/recent-news-big-grid.php',
            'class' => __NAMESPACE__ . '\Elements\Recent_News_Big_Grid_Big_Grid'
        );

        $widgets['630'] = array(
            'file'  => $this->dir_path . '/widgets/recent-news-grid.php',
            'class' => __NAMESPACE__ . '\Elements\Recent_News_Grid_Carousel'
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
     * Override news templates
     *
     * Let Elementor Pro override news templates
     *
     * @access public
     */
    public function aux_elementor_pro_override_templates( $need_override_location ) {
        
        return ( ( ( is_single() && get_post_type() == 'news' ) || is_post_type_archive( 'news' ) ) || $need_override_location );
    }

}

Elements::instance();
