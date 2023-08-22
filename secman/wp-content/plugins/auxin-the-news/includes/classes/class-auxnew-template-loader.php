<?php
/**
 * Template Loader
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


class Auxnew_Template_Loader {

    /**
     * The array of templates that this plugin tracks.
     */
    public $templater, $registerList;
    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __construct() {
        // Load template
        add_filter( 'template_include' , array( $this, 'template_loader' ) );

        // Add news page templates
        if( class_exists( 'Auxin_Page_Template' ) ){
            Auxin_Page_Template::get_instance();

            add_filter( 'auxin/core_elements/page_templates/file_names', function( $templates ){
                $templates['blog-type-news.php'] = __('News Archive', 'auxin-news' );
                return $templates;
            });

            add_filter( 'auxin/core_elements/page_templates/directories', function( $directories ){
                $directories[] = AUXNEW_PUB_DIR . '/templates/';
                return $directories;
            });
        }
    }

    /**
     * Load a template.
     *
     * @param mixed $template
     * @return string
     */
    public static function template_loader( $template ) {
        $find = array();
        $file = '';

        if ( is_embed() ) {
            return $template;
        }

        if ( is_single() && get_post_type() == 'news' ) {

            $find[] = AUXNEW()->template_path() . 'single-news.php';

        } elseif ( is_tax( get_object_taxonomies( 'news' ) ) ) {

            $term   = get_queried_object();

            if ( is_tax( 'news-category' ) || is_tax( 'news-tag' ) ) {
                $file = 'taxonomy-' . $term->taxonomy . '.php';
            } elseif ( !is_search() ) {
                $file = 'archive-news.php';
            }

            $find[] = AUXNEW()->template_path() . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
            $find[] = AUXNEW()->template_path() . 'taxonomy-' . $term->taxonomy . '.php';
            $find[] = AUXNEW()->template_path() . $file;

        } elseif ( is_post_type_archive( 'news' ) && !is_search() ) {

            $find[] = AUXNEW()->template_path() . 'archive-news.php';
        }

        $find      = array_unique( $find );

        if ( $find && $templates = locate_template( array_unique( $find ) ) ) {
            return $templates;
        }

        foreach ( $find as $file ) {
            if( file_exists( $file ) ){
                $template = $file;
                break;
            }
        }

        return $template;
    }
}

Auxnew_Template_Loader::get_instance();
