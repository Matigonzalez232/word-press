<?php
namespace Auxin\Plugin\Shop\Elementor\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Auxin_Products_Url extends Tag {

	public function get_name() {
		return 'aux-products-url';
	}

	public function get_title() {
		return __( 'Products URL', 'auxin-shop' );
	}

	public function get_group() {
		return 'URL';
	}

	public function get_categories() {
		return [
			TagsModule::URL_CATEGORY
		];
    }

	public function is_settings_required() {
		return true;
	}

	protected function register_controls() {
		$this->add_control(
			'key',
			[
				'label'   => __( 'Product ID', 'auxin-shop' ),
				'type'    => Controls_Manager::NUMBER,
            ]
        );
	}

	protected function get_post_url() {
		if( $key = $this->get_settings( 'key' ) ){
			return get_permalink( $key );
		}

		return '';
	}

	public function get_value() {
		return $this->get_post_url();
	}

	public function render() {
		echo $this->get_post_url();
	}

}
