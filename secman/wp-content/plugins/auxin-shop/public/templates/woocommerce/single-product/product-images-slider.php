<?php
/**
 * Master Slider.
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product;

?>
<div class="images ms-product-slider woocommerce-product-gallery auxshp-lightbox">

	<?php

	$attachment_ids = $product->get_gallery_image_ids();

    if ( ! $attachment_ids ) {
        $attachment_ids = array();
    }

	array_unshift( $attachment_ids , get_post_thumbnail_id() );

	$image_count        = count( $attachment_ids );
	
	$column_media_width =  auxin_get_content_column_width( 2 );
	$image_aspect_ratio = 1;
	
	$center_controls    = 'true';
	$show_thumbs        = 'true';
	$enable_arrows      = auxin_is_true( auxin_get_option('product_single_template_slider_arrow', 0) ) ? 'true' : 'false' ;
	$auto_hide_arrow 	= auxin_is_true( auxin_get_option('product_single_template_slider_hide_arrow', 0) ) ? 'true' : 'false' ; 
	
    if ( 'default' == $template = auxin_get_post_meta( $product->get_id(), '_product_single_template', 'default' ) ) {
    	$template = auxin_get_option( 'product_single_template', 'slider' );
    }

    if ( 'wide-center' == $template ) {
    	
		$center_controls    = 'false';
		$enable_arrows      = 'true';
		$column_media_width = auxin_get_content_column_width( 1 );
		$image_aspect_ratio = 0.56;

    } elseif ( 'wide' == $template ) {
		
		$center_controls    = 'false';
		$enable_arrows      = 'true';
		$show_thumbs        = 'false';
		$column_media_width = auxin_get_content_column_width( 1 );
		$image_aspect_ratio = 0.56;
	}

	$enable_thumbnail = apply_filters( 'msp_woocommerce_display_thumbnail_for_single_product_slider', $show_thumbs );
	$thumb_dir        = auxin_get_option('product_single_slider_thumb_dir', 'h');
	$thumb_margin     = auxin_get_option('product_single_slider_thumb_margin', '5');
	$thumb_width 	  = auxin_get_option('product_single_slider_thumb_width', '80');
	$thumb_height     = auxin_get_option('product_single_slider_thumb_height', '80');
	$thumb_space      = auxin_get_option('product_single_slider_thumb_space', '5');
			
	if ( 'v' === $thumb_dir ) {
		$thumb_align = 'left';
	} else {
		$thumb_align = 'bottom';
	}

	$large_single_size  	= apply_filters( 'single_product_large_single_size', 'shop_single' );
	$slide_image_dimensions = wc_get_image_size( $large_single_size );

	if ( $image_count > 1 ) {

		$slider_params = array(

			'id'            => $product->get_id(),     // slider id
			'uid'           => '',      // an unique and temporary id 
			'class'         => 'auxshp-lightbox',      // a class that adds to slider wrapper
			'margin'        => 0,  

			'inline_style'  => '',
			'bg_color'      => '',
			'bg_image'      => '',

			'slider_type'   => 'custom',   // values: custom, flickr, facebook, post

			'width'         => $column_media_width,     // base width of slides. It helps the slider to resize in correct ratio.
			'height'        => $image_aspect_ratio * $column_media_width,     // base height of slides, It helps the slider to resize in correct ratio.

			'start'         => 1,
			'space'         => 0,

			'grab_cursor'   => 'true',  // Whether the slider uses grab mouse cursor
			'swipe'         => 'true',  // Whether the drag/swipe navigation is enabled

			'wheel'         => 'false', // Enables mouse scroll wheel navigation
			'mouse'         => 'true',  // Whether the user can use mouse drag navigation

			'crop' 			 => 'false', // Automatically crop slide images?

			'autoplay'      => 'false', // Enables the autoplay slideshow
			'loop'          => 'false', // 
			'shuffle'       => 'false', // Enables the shuffle slide order
			'preload'       =>  2,

			'wrapper_width' => '',
    		'wrapper_width_unit' => 'px',

			'layout'        => 'fillwidth',

			'fullscreen_margin' => 0,

			'height_limit'  => 'false', // It force the slide to use max height value as its base specified height value.
			'auto_height'   => 'false',
			'smooth_height' => 'true',
			
			'end_pause'     => 'false',
			'over_pause'    => 'false',

			'fill_mode'     => 'fill',
			'center_controls'=> $center_controls,

			'layers_mode'   => 'center',// It accepts two values "center" and "full"
			'hide_layers'   => 'false',

			'instant_show_layers' => 'false',

			'speed'         => 17,

			'skin'          => 'ms-skin-default', // slider skin. should be seperated by space - should be started by ms-skin
			'template'      => '',
			'template_class'=> '',
			'direction'     => 'h',
			'view'          => 'basic',

			'gfonts' 		=> '',

    		'parallax_mode' => 'swipe',

			'arrows'           => $enable_arrows,  // display arrows?
			'arrows_autohide'  => $auto_hide_arrow,   // auto hide arrows?
			'arrows_overvideo' => 'true',   // visible over slide video while playing?
			'arrows_hideunder' => '',

			'bullets'          => 'false',  // display bullets?
			'bullets_autohide' => 'true',   // auto hide bullets?
			'bullets_overvideo'=> 'true',   // visible over slide video while playing?
			'bullets_direction'=> 'h',
			'bullets_align'    => 'bottom',
			'bullets_margin'   => '',
			'bullets_hideunder'=> '',
			
			'thumbs'           => $enable_thumbnail,  // display thumbnails?
			'thumbs_autohide'  => 'false',   // auto hide thumbs?
			'thumbs_overvideo' => 'true',   // visible over slide video while playing?
			'thumbs_direction' => $thumb_dir,      // direction of control
			'thumbs_type'      => 'thumbs',
			'thumbs_speed'     => 17,       // scrolling speed. It accepts float values between 0 and 100
			'thumbs_inset'     => 'false',   // insert thumbs inside slider
			'thumbs_align'     => $thumb_align,
			'thumbs_margin'    => $thumb_margin,
			'thumbs_width'     => $thumb_width,
			'thumbs_height'    => $thumb_width,
			'thumbs_space'     => $thumb_space,
			'thumbs_hideunder' => '',
			'thumbs_fillmode'  => 'fill',

			'scroll'           => 'false',  // display scrollbar?
			'scroll_autohide'  => 'true',   // auto hide scroll?
			'scroll_overvideo' => 'true',   // visible over slide video while playing?
			'scroll_direction' => 'h',      // direction of control
			'scroll_align'     => 'top',
			'scroll_inset'     => 'true',
			'scroll_margin'    => '',
			'scroll_color'     => '#3D3D3D',
			'scroll_hideunder' => '',
			'scroll_width' 	 => '',

			'circletimer'          => 'false',  // display circletimer?
			'circletimer_autohide' => 'true',   // auto hide circletimer?
			'circletimer_overvideo'=> 'true',   // visible over slide video while playing?
			'circletimer_color'    => '#A2A2A2',// color of circle timer
			'circletimer_radius'   => 4,        // radius of circle timer in pixels
			'circletimer_stroke'   => 10,       // the stroke of circle timer in pixels
			'circletimer_margin'   => '',
			'circletimer_hideunder'=> '',

			'timebar'          => 'false',   // display timebar?
			'timebar_autohide' => 'true',   // auto hide timebar?
			'timebar_overvideo'=> 'true',   // visible over slide video while playing?
			'timebar_align'    => 'bottom',
			'timebar_color'    => '#FFFFFF',
			'timebar_hideunder'=> '',
			'timebar_width' 	 => '',
			

			'slideinfo'          => 'false',   // display timebar?
			'slideinfo_autohide' => 'true',   // auto hide timebar?
			'slideinfo_overvideo'=> 'true',   // visible over slide video while playing?
			'slideinfo_direction'=> 'h',
			'slideinfo_align'    => 'bottom',
			'slideinfo_inset'    => 'false',
			'slideinfo_margin'   => '',
			'slideinfo_hideunder'=> '',
			'slideinfo_width'	 => '',
			'slideinfo_height'   => ''
		);

		$slider_params = apply_filters( 'msp_woocommerce_single_product_slider_params', $slider_params, $product );

		// create ms_slider shortcode
		$slider_attrs = '';
		foreach ( $slider_params as $attr => $attr_value ) {
			$slider_attrs .= sprintf( '%s="%s" ', $attr, esc_attr( $attr_value ) );
		}

		$slides = '';

		if ( $attachment_ids ) {

			$loop = 0;

			foreach ( $attachment_ids as $attachment_id ) {

				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$image_title = esc_attr( get_the_title( $attachment_id ) );
				$image_alt   = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
				$image_src   = msp_get_the_resized_image_src( $image_link, $column_media_width, $image_aspect_ratio * $column_media_width, true );

				$attachment_count = count( $product->get_gallery_image_ids() );

				if ( $attachment_count > 0 ) {
					$gallery = "&#91;product-gallery&#93;";
				} else {
					$gallery = '';
				}


				$slide_options = array( 
					'src'       => $image_src,
					'css_class' => 'ms-zoom',

					'title'     => $image_title, // image and link title
					'alt'       => $image_alt, // image alternative text
					//'link'      => $image_link,
					'rel' 		=> 'prettyPhoto' . $gallery,
					'target'    => '_blank',
					'video'     => '', // youtube or vimeo video link

					'mp4'			=> '', // self host video bg
					'webm'		=> '', // self host video bg
					'ogg'			=> '', // self host video bg

					'autopause' => 'false', 
					'mute'		=> 'true',
					'loop' 		=> 'true',

					'crop_width'  => '', // empty means auto
					'crop_height' => '', // empty means auto

					'thumb' 	=> '',
					'delay'     => '', // data-delay 
					'bgalign'	=> ''  // data-fill-mode
				);

				if( $enable_thumbnail )
					$slide_options['thumb'] = msp_get_the_resized_image_src( $image_link, $column_media_width, $image_aspect_ratio * $column_media_width, true );

				$slide_options = apply_filters( 'msp_woocommerce_single_product_slider_slide_params', $slide_options, $product );

				$slide_attrs = '';
				foreach ( $slide_options as $attr => $attr_value ) {
					$slide_attrs .= sprintf( '%s="%s" ', $attr, esc_attr( $attr_value ) );
				}

				$slides .= sprintf( '[ms_slide %s ][/ms_slide]', $slide_attrs );

				$loop++;
			}

		}



		$slider_shortcode = ! empty( $slides ) ? sprintf( '[ms_slider %s ]%s[/ms_slider]', $slider_attrs, $slides ) : '';
		echo do_shortcode( $slider_shortcode );

	} elseif( $image_count === 1 ) {

		$main_src = wp_get_attachment_image_src( $attachment_ids[0], 'large' );

		$image  = auxin_get_the_responsive_attachment(
				$attachment_ids[0],
				array(
                    'upscale'      => true,
                    'crop'         => true,
                    'add_hw'       => true, // whether add width and height attr or not
                    'attr'         => array(
										'class'                   => 'auxshp-zoom',
										'data-original-width'     => $slide_image_dimensions['width'],
										'data-original-height'    => $slide_image_dimensions['height'],
										'data-large_image_width'  => $main_src[1],
                                        'data-large_image_height' => $main_src[2],
                                        'data-original-src'       => $main_src[0],
										),
                    'size'         => array( 'width' => $column_media_width, 'height' => $column_media_width * $image_aspect_ratio ),
                    'image_sizes'  => array(
                        array( 'min' => '',      'max' => '767px', 'width' => round( 100 / 1 ).'vw' ),
                        array( 'min' => '768px', 'max' => '1025px', 'width' => round( 100 / 2 ).'vw' ),
                        array( 'min' => ''     , 'max' => '',      'width' => $column_media_width.'px' )
                    ),
                    'srcset_sizes' => array(
                        array( 'width' =>     $column_media_width, 'height' =>     $column_media_width * $image_aspect_ratio ),
                        array( 'width' => 2 * $column_media_width, 'height' => 2 * $column_media_width * $image_aspect_ratio ),
                        array( 'width' => 4 * $column_media_width, 'height' => 4 * $column_media_width * $image_aspect_ratio )
                    )
                )
			);

		$image_title = esc_attr( get_the_title( $attachment_ids[0] ) );
		$image_link  = wp_get_attachment_url( $attachment_ids[0] );
		$image_alt   = trim( strip_tags( get_post_meta( $attachment_ids[0], '_wp_attachment_image_alt', true ) ) );

		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image auxshp-zoom ms-zoom" alt="%s" title="%s">%s</a>', $image_link, $image_alt, $image_title, $image ), $product->get_id() );

	} else {
		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $product->get_id() );
	}
		
	?>

</div>
