<?php

function auxin_news_element( $args = array() ) {

	global $post;

	$defaults = array(
		'title'                 => '',              // Latest News
		'title_before'          => '<h3 class="aux-news-element-title widget-title aux-h3">',
		'title_after'           => '</h3>',         // Latest News
		'template'              => 'default',
		'only_posts__in'        => '',
		'include'               => '',
		'exclude'               => '',
		'order_by'              => '',
		'order'                 => '',
		'show_image'            => true,            // false
		'show_title'            => true,            // bool
		'words_num'             => '',            // bool
		'show_info'             => true,            // bool
		'show_meta'             => true,            // bool
		'show_badge'            => false,            // bool
		'info_position'         => 'after_title',   // before-title
		'show_categories'       => true,            // bool
		'show_tag'              => true,            // bool
		'show_date'             => true,            // bool
		'show_author'           => true,            // bool
		'header_show_image'     => true,            // bool
		'show_like'             => true,            // bool
		'content'               => 15,
		'big_content'           => 25,
		'cat'                   => ' ',
		'more_text'             => ' ...',
		'show_filters'          => true,            // filters in side title
		'filter_colors'         => true,            // enable colors for filters
		'filter_by'             => 'news-category',
		'filter_style'          => 'aux-slideup',
		'pagination'            => 'arrow',         // number, bullet
		'pagination_pos'        => 'left',          // center, right
		'author_or_readmore'    => '',              // bool
		'display_comments'      => false,
		'show_comments'         => true,
		'display_like'          => false,
		'image_aspect_ratio'    => 0.662,           // Based on magazine demo. Needs option
		'big_image_aspect_ratio'=> 0.662,           // Based on magazine demo. Needs option
		'column_media_count'    => 3,               //
		'exclude_without_media' => false,           // bool
		'query_args'            => array(),         // Custom WP Query args
        'preloadable'           => false,
        'preload_preview'       => true,
        'preload_bgcolor'       => '',
		'show_header'           => true,            // Show Header or not
		'header_position'       => 'top',           // side
		'skip_wrappers'         => false,
        'main_desktop_cnum'      => 7,
        'main_tablet_cnum'      => 7,
        'main_phone_cnum'       => 12,
        'side_desktop_cnum'     => 5,
        'side_tablet_cnum'      => 5,
        'side_phone_cnum'       => 12,
		'universal_id'          => 0,
		'num'                   => 8,
		'tax_args'              => '',
		'use_wp_query'          => false,
		'loadmore_type'         => '',
		'paged'                 => '',
		'offset'                => '',
		'paginate'              => false,
		'reset_query'           => false,
		'header_args'           => array(
			'column_media_count'  => 1,
			'image_aspect_ratio'  => 0.662,
			'show_title'          => true,
			'words_num'           => '',
			'show_image'          => true,
			'show_info'           => true,
			'show_meta'           => true,
			'show_badge'          => false,
			'show_date'           => true,
			'show_author'         => true,
			'show_comments_count' => false,
			'show_categories'     => true,
			'more_text'           => ' ...',
			'content'             => 45,
			'inside_mode'         => false
		)
	);

	if ( isset( $args['header_args'] ) ) {
		$args['header_args'] = wp_parse_args( $args['header_args'], $defaults['header_args'] );
	}

	$args = wp_parse_args( $args, $defaults );

    // post-column needs to have below variables
    if(  $args['author_or_readmore'] == 'readmore') {
        $show_readmore      = true;
        $show_author_footer = false;
    } elseif( $args['author_or_readmore'] == 'author') {
        $show_readmore      = false;
        $show_author_footer = true;
    } else {
        $show_readmore      = false;
        $show_author_footer = false;
    }

	$args['header_args']['info_position']      = $args['info_position'];
	$args['header_args']['show_title']         = $args['show_title'];
	$args['header_args']['words_num']          = $args['words_num'];
	$args['header_args']['show_info']          = $args['show_info'];
	$args['header_args']['show_meta']          = $args['show_meta'];
	$args['header_args']['show_date']          = $args['show_date'];
	$args['header_args']['show_author']        = $args['show_author'];
	$args['header_args']['show_badge']         = $args['show_badge'];
	$args['header_args']['show_categories']    = $args['show_categories'];
	$args['header_args']['show_image']         = $args['show_image'];
	$args['header_args']['image_aspect_ratio'] = $args['big_image_aspect_ratio'];
	$args['header_args']['show_readmore']      = $show_readmore;
	$args['header_args']['show_author_footer'] = $show_author_footer;
	$args['header_args']['display_like']       = $args['display_like'];
	$args['header_args']['show_comments']      = $args['show_comments'];
	$args['header_args']['display_comments']   = $args['display_comments'];
	$args['header_args']['preloadable']        = $args['preloadable'];
	$args['header_args']['preload_preview']    = $args['preload_preview'];
	$args['header_args']['preload_bgcolor']    = $args['preload_bgcolor'];

	if ( 'news-1' === $args['template'] ) {
		$args['header_args']['inside_mode'] = true;
	}

	if ( 0 !== $args['big_content'] ) {
		$args['header_args']['content'] = $args['big_content'];
	}

	$column_media_width = auxin_get_content_column_width( $args['column_media_count'] );

	$container_class    = 'auxin-news-element aux-ajax-view';

    if( empty(  $args['cat'] ) ||  $args['cat'] == " " || ( is_array(  $args['cat'] ) && in_array( " ",  $args['cat'] ) ) ) {
        $tax_args = array();
    } else {
        $tax_args = array(
            array(
                'taxonomy' => 'news-category',
                'field'    => 'term_id',
                'terms'    => ! is_array(  $args['cat'] ) ? explode( ",",  $args['cat'] ) :  $args['cat']
            )
        );
	}



	if( ! $args['use_wp_query'] ) {
		// create wp_query to get latest items -----------
		$query_args = array(
			'post_type'             => 'news',
			'posts_per_page'        => $args['num'],
			'orderby'               => $args['order_by'],
			'order'                 => $args['order'],
			'tax_query'             => $tax_args,
			'offset'                => $args['offset'],
			'paged'                 => $args['paged'],
			'post_status'           => 'publish',
			'ignore_sticky_posts'   => 1,

			'include_posts__in'     => $args['include'], // include posts in this list
			'posts__not_in'         => $args['exclude'], // exclude posts in this list
			'posts__in'             => $args['only_posts__in'], // only posts in this

			'exclude_without_media' => $args['exclude_without_media']
		);

		// ---------------------------------------------------------------------

		// add the additional query args if available
		if( $args['query_args'] ){
			$query_args = wp_parse_args( $query_args, $args['query_args'] );
		}

		// pass the args through the auxin query parser
		$wp_query = new WP_Query( auxin_parse_query_args( $query_args ) );
	} else {
		global $wp_query;
	}

	ob_start();

	if ( $wp_query->have_posts() ) {

		echo ! $args['skip_wrappers'] ? sprintf( '<div data-element-id="%s" class="%s">', esc_attr( $args['universal_id'] ), esc_attr( $container_class ) ) : '';

		if ( ( ! empty( $args['title'] ) || $args['show_filters'] ) && ! $args['skip_wrappers'] ) : ?>

			<div class="aux-row aux-news-element-header">
				<?php if ( ! empty( $args['title'] ) ) : ?>
					<div class="aux-1-2 auxnew-header-col">
						<div class="aux-news-element-title-wrapper">
							<?php echo $args['title_before'] . esc_html( $args['title'] ) . $args['title_after']; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $args['show_filters'] ) : ?>
					<div class="aux-1-2 auxnew-header-col">
						<div class="auxnews-tax-filters">
							<?php auxnew_element_category_filters( $post, $args['filter_by'], $args['filter_style'], $args['filter_colors'], $args['cat'] ); ?>
						</div>
					</div>
				<?php endif; ?>
				<hr class="auxin-news-header-sep">
			</div>

			<div class="aux-news-element-main">

		<?php endif; ?>

		<?php
		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			if ( ! has_post_thumbnail($post) && $args['exclude_without_media'] ) {
				continue;
			}

			$featured_color = get_post_meta( $post->ID, 'auxin_featured_color_enabled', true ) ? get_post_meta( $post->ID, 'auxin_featured_color', true ) : auxin_get_option( 'post_single_featured_color' );
			$cat_terms      = get_the_terms( $post->ID, 'news-category' );

			if ( ( 0 === $wp_query->current_post ) && $args['show_header'] && ! auxin_is_true($args['skip_wrappers']) ) {
				if ( 'side' === $args['header_position'] ) : ?>
					<div class="aux-row aux-news-side">
						<div class="aux-<?php echo esc_attr( $args['main_desktop_cnum'] ); ?>-12 aux-tb-<?php echo esc_attr( $args['main_tablet_cnum'] ); ?>-12 aux-mb-<?php echo esc_attr( $args['main_phone_cnum'] ); ?>-12 auxnew-main-post">
				<?php endif; ?>
				<article <?php post_class( 'aux-ajax-item aux-news-big-article' ); ?>>
					<div class="auxnew-big-post">
					<?php
					echo auxnew_element_big_post( $post, $args['header_args'] );
					?>
					</div>
				</article>
					<?php if ( 'side' === $args['header_position'] && $args['show_header'] ) : ?>
							</div>
							<div class="aux-<?php echo esc_attr( $args['side_desktop_cnum'] ); ?>-12 aux-tb-<?php echo esc_attr( $args['side_tablet_cnum'] ); ?>-12 aux-mb-<?php echo esc_attr( $args['side_phone_cnum'] ); ?>-12 auxnew-side-posts">
					<?php endif;
			} else { ?>

			<article <?php post_class( 'aux-ajax-item aux-news-small-article' ); ?>>
				<div class="aux-row aux-small-posts">
				<?php if ( $args['show_image'] ) : ?>
					<div class="aux-2-5 aux-thumbnail-col">
						<div class="entry-media">
							<?php

							if ( has_post_thumbnail( $post ) ) {

								$image_id = get_post_thumbnail_id( $post->ID );
								$main_src = wp_get_attachment_image_src( $image_id, 'full' );

								$attachment_props = array(
									'quality'         => 100,
									'upscale'         => true,
									'crop'            => true,
									'preloadable'     =>  $args['preloadable'],
									'preload_preview' =>  $args['preload_preview'],
									'preload_bgcolor' =>  $args['preload_bgcolor'],
									'add_hw'          => true, // whether add width and height attr or not
									'size'            => array( 'width' => $column_media_width, 'height' => $column_media_width * $args['image_aspect_ratio'] ),
									'image_sizes'     => 'auto',
									'srcset_sizes'    => 'auto'
						        ); ?>
						        <a href="<?php the_permalink(); ?>">
						        	<?php echo auxin_get_the_responsive_attachment( $image_id, $attachment_props ); ?>
						        </a>
						    <?php } else { ?>
						        <div class="entry-media">
	                                <div class="aux-media-frame aux-media-image">
	                                    <a href="<?php the_permalink(); ?>">
	                                        <img src="<?php  echo AUXIN_URL . 'images/welcome/image-frame.svg'; ?>" class="auxin-attachment auxin-featured-image attachment-1024x1024" alt="news default image" >
	                                    </a>
	                                </div>
	                            </div>
						    <?php } ?>
						</div>
					</div>
				<?php endif; ?>
					<div class="aux-col aux-entry-col <?php echo has_post_thumbnail() && $args['show_image'] ? 'aux-3-5' : ''; ?>">
						<div class="entry-main">
							<?php if ( ! empty( $cat_terms ) && auxin_is_true( $args['show_badge'] ) ) { ?>
								<span class="entry-badge aux-featured-color" data-featured-color="<?php echo !empty( $featured_color ) ? esc_html( $featured_color ) : ''; ?>">
									<a href="<?php the_permalink(); ?>"><?php echo esc_html( $cat_terms[0]->name ); ?></a>
								</span>
							<?php } ?>
							<?php if ( $args['show_title'] && ( 'after_title' === $args['info_position'] || ! $args['show_info'] ) ) : ?>
								<header class="entry-header">
									<h3 class="entry-title aux-h3">
										<a href="<?php the_permalink(); ?>"><?php
										echo empty( $args['words_num'] ) ? get_the_title() : wp_trim_words( get_the_title(), $args['words_num'] );
										?></a>
									</h3>
								</header>
							<?php endif; ?>
							<?php if ( $args['show_info'] ) : ?>
						        <div class="entry-info">
						        <?php if ( $args['show_date'] ) : ?>
						        	<div class="entry-date"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" title="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php echo get_the_date(); ?></time></div>
						        <?php endif; ?>
						        <?php if ( $args['show_categories'] ) : ?>
						            <?php $tax_name = 'news-category';
										if( $cat_terms ) : ?>
						        			<span class="entry-tax">
											  <?php foreach( $cat_terms as $term ){
											      echo '<a href="'. get_term_link( $term->slug, $tax_name ) .'" class="no-bullet" title="'.esc_attr__( "View all posts in ", 'auxin-news' ). esc_attr( $term->name ) .'" rel="category" >'. esc_html( $term->name ) .'</a>';
											  } ?>
						        			</span>
										<?php endif; ?>
						        <?php endif; ?>
						        <?php if ( $args['show_author'] ) : ?>
							        <div class="entry-author">
							            <span class="meta-sep"><?php esc_html_e( "by", 'auxin-news' ); ?></span>
							            <span class="author vcard">
											<?php 
                                            $author_link = add_query_arg( 'post_type', 'news', get_author_posts_url( get_the_author_meta( 'ID' ) ) );
                                            ?>
							                <a href="<?php echo esc_url( $author_link ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'auxin-news' ), get_the_author() ) ); ?>" >
							                    <?php the_author(); ?></a>
							            </span>
							        </div>
						        <?php endif; ?>
						        <?php if ( post_type_supports( $post->post_type, 'comments' ) ) {
						            if ( $args['header_args']['show_comments_count'] ) : ?>
						            <div class="entry-comments">
						                <span class="meta-sep"><?php esc_html_e( "with", 'auxin-news' ); ?></span>
						                <span class="meta-comment"><?php comments_number( __( 'No Comment', 'auxin-news' ), __( 'One Comment', 'auxin-news' ), __('% Comments', 'auxin-news' ) );?></span>
						            </div>
						            <?php endif; } ?>

						        <?php edit_post_link( __( "Edit", 'auxin-news'), '<i> | </i>', '' ); ?>

						    	</div>
							<?php endif; ?>
							<?php if ( $args['show_title'] && 'before_title' === $args['info_position'] ) : ?>
								<header class="entry-header">
									<h3 class="entry-title aux-h3">
									<a href="<?php the_permalink(); ?>"><?php
										echo empty( $args['words_num'] ) ? get_the_title() : wp_trim_words( get_the_title(), $args['words_num'] );
									?></a>
									</h3>
								</header>
							<?php endif; ?>
							<?php if ( 0 !== intval( $args['content'] ) ) : ?>
								<div class="entry-content">
									<?php
									if ( 'content' === $args['content'] ) {
										the_content();
									} elseif ( 'excerpt' === $args['content'] ) {
										the_excerpt();
									} else {
										echo wp_trim_words( get_the_content(), $args['content'], $args['more_text'] );
									}
									?>
								</div>
							<?php endif; ?>

				            <?php if( $show_readmore || $show_author_footer ) {?>
				                <footer class="entry-meta">
				                    <?php if( $show_readmore ) {?>
				                    <div class="readmore">
				                        <a href="<?php the_permalink(); ?>" class="aux-read-more"><?php echo esc_html( auxin_get_option( 'post_index_read_more_text' ) ); ?></a>
				                    </div>
				                    <?php
				                    } elseif ( $show_author_footer ) { ?>
				                    <div class="author vcard">
				                        <?php echo get_avatar( get_the_author_meta("user_email"), 40 ); ?>
				                        <span class="meta-sep"><?php esc_html_e("by", THEME_DOMAIN); ?></span>
										<?php 
										$author_link = add_query_arg( 'post_type', 'news', get_author_posts_url( get_the_author_meta( 'ID' ) ) );
										?>
				                        <a href="<?php echo esc_url( $author_link ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', THEME_DOMAIN), get_the_author() ) ); ?>" >
				                            <?php the_author(); ?>
				                        </a>
				                    </div>
				                    <?php }

				                    if ( $args['show_comments'] && comments_open() ) {
				                    ?>
				                    <div class="comments-iconic">
				                        <?php
				                            if( auxin_is_true( $args['display_like'] ) ){
				                                if(function_exists('wp_ulike')) wp_ulike( 'get', array( 'style' => 'wpulike-heart', 'button_type' => 'image', 'wrapper_class' => 'aux-wpulike' ) );
				                            }

				                            if( isset($args['display_comments'] ) && auxin_is_true( $args['display_comments'] ) ){
				                        ?>
				                            <a href="<?php the_permalink(); ?>#comments" class="meta-comment" >
				                                <span class="auxicon-comment"></span><span class="comments-number"><?php echo get_comments_number(); ?></span>
				                            </a>
				                        <?php
				                            }
				                        ?>
				                    </div>
				                    <?php
				                    } elseif( auxin_is_true( $args['display_like'] ) && (function_exists('wp_ulike') ) ){ ?>
				                    <div class="comments-iconic">
				                        <?php wp_ulike( 'get' , array( 'style' => 'wpulike-heart', 'button_type' => 'image', 'wrapper_class' => 'aux-wpulike' ) ); ?>
				                    </div>
				                   <?php } ?>
				                </footer>
				            <?php } ?>
						</div>
					</div>
				</div>
			</article>
	<?php 	}

		}

		if ( 'side' === $args['header_position'] && $args['show_header']) : ?>
				</div>
			</div>
		<?php endif;

        if( ! $args['skip_wrappers'] ) {
            // End tag for aux-ajax-view wrapper & Execute load more functionality
            echo '</div>' . auxin_get_load_more_controller( $args['loadmore_type'] );

        } else {
            // Get post counter in the query
            echo '<span class="aux-post-count hidden">'.$wp_query->post_count.'</span>';
			echo '<span class="aux-all-posts-count hidden">'.$wp_query->found_posts.'</span>';
        }

        if( $args['paginate'] ) {
        	// generate the archive pagination
	        auxin_the_paginate_nav(
	            array(
	                'css_class' => esc_attr( auxin_get_option('archive_pagination_skin') ),
	                'wp_query'  => $wp_query
	            )
	        );
        }

	    if( $args['reset_query'] ){
	        wp_reset_query();
	    }

	    // return false if no result found
	    if( ! $wp_query->have_posts() ){
	        ob_get_clean();
	        return false;
		}

		return ob_get_clean();

	}

}


function auxnew_element_category_filters( $post, $filter_by = 'news-category', $style, $colors = true, $cat = ' ' ) {

	$html       = array();
	$color      = '';

    $terms = get_terms(
        array(
            'taxonomy'   => $filter_by,
            'orderby'    => 'count',
            'hide_empty' => true
        )
    );

	if ( $terms ) {

        ?><div class="aux-filters aux-ajax-filters <?php echo $style; ?> aux-togglable" data-n="<?php echo wp_create_nonce('aux_ajax_filter_request'); ?>"><div class="aux-select-overlay"></div><ul><?php
        echo '<li data-filter="all"><a href="#"><span data-select="' . __( 'all', 'auxin-news' ) . '">' . __( 'all', 'auxin-news' ) . '</span></a></li>';

        foreach ( $terms as $term ) {
			if ( $colors ) {
				$term_color = get_term_meta( $term->term_id, 'auxnew_cat_color', true );
				$color = $term_color ? 'style="color: ' . esc_attr( $term_color ) . '"' : '';
			}
            if( (! is_array( $cat) ) && !( empty( $cat ) || $cat == " " ) ) {
                $cat = array( $cat );
            }
            if ( ( empty( $cat ) || $cat == " " || ( is_array( $cat ) && in_array( " ", $cat ) ) ) || in_array( $term->term_id, $cat ) ) {
                echo '<li data-filter="' . $term->term_id . '"><a href="#" ' . $color . '><span data-select="' . $term->name . '">' . $term->name . '</span></a></li>';
        	}
        }


        ?></ul></div><?php

    }

}


function auxnew_element_big_post( $post, $args = array() ) {

	$defaults = array(
		'column_media_count'  => 1,
		'image_aspect_ratio'  => 0.662,
		'show_title'          => true,
		'words_num'           => '',
		'show_image'          => true,
		'show_info'           => true,
		'show_meta'           => true,
		'show_date'           => true,
		'show_badge'          => false,
		'show_author'         => true,
		'show_comments_count' => false,
		'show_categories'     => true,
		'show_readmore'       => true,
		'show_author_footer'  => false,
		'display_comments'    => true,
		'show_comments'       => true,
		'display_like'        => true,
		'info_position'       => 'after_title',
		'more_text'           => ' ...',
		'content'             => 45,
		'inside_mode'         => false,
		'preloadable'         => false,
		'preload_preview'     => true,
		'preload_bgcolor'     => '',
	);

	$res = wp_parse_args( $args, $defaults );

	$media_class = '';

	if ( $res['inside_mode'] ) {
		$res['content'] = 0;
		$media_class = ' title-inside';
	}

	$column_media_width = auxin_get_content_column_width( $res['column_media_count'], 0 );
	$image_aspect_ratio = $res['image_aspect_ratio'];


	$featured_color     = get_post_meta( $post->ID, 'auxin_featured_color_enabled', true ) ? get_post_meta( $post->ID, 'auxin_featured_color', true ) : auxin_get_option( 'post_single_featured_color' );
	$cat_terms          = get_the_terms( $post->ID, 'news-category' );

	if ( has_post_thumbnail() && $res['show_image'] ) : ?>

		<div class="entry-media <?php echo esc_attr( $media_class ); ?>">
		<?php
		$image_id = get_post_thumbnail_id( $post );

		$main_src = wp_get_attachment_image_src( $image_id, 'full' );

		$attachment_props = array(
			'quality'         => 100,
			'upscale'         => true,
			'crop'            => true,
			'preloadable'     =>  $args['preloadable'],
			'preload_preview' =>  $args['preload_preview'],
			'preload_bgcolor' =>  $args['preload_bgcolor'],
			'add_hw'          => true, // whether add width and height attr or not
			'size'            => array( 'width' => $column_media_width, 'height' => $column_media_width * $image_aspect_ratio ),
			'image_sizes'     => 'auto',
			'srcset_sizes'    => 'auto'
        );

        echo auxin_get_the_responsive_attachment( $image_id, $attachment_props );
        echo '</div>';
	endif; ?>

	<div class="entry-main">
		<?php if ( $res['inside_mode'] ) :?>
			<div class="header-inner">
		<?php endif; ?>

			<?php if ( ! empty( $cat_terms ) && auxin_is_true( $args['show_badge'] ) ) { ?>
				<span class="entry-badge aux-featured-color" data-featured-color="<?php echo !empty( $featured_color ) ? esc_html( $featured_color ) : ''; ?>">
					<a href="<?php the_permalink(); ?>"><?php echo esc_html( $cat_terms[0]->name ); ?></a>
				</span>
			<?php } ?>

			<?php if ( $res['show_title'] && ( 'after_title' === $args['info_position'] || ! $args['show_info'] ) ) : ?>
				<header class="entry-header">
					<div class="entry-title">
						<h4 class="aux-h4"><a href="<?php the_permalink(); ?>"><?php
							echo empty( $res['words_num'] ) ? get_the_title() : wp_trim_words( get_the_title(), $res['words_num'] );
						?></a></h4>
					</div>
				</header>
			<?php endif; ?>

			<?php if ( $res['show_info'] ) : ?>
		        <div class="entry-info">
		        <?php if ( $res['show_date'] ) : ?>
		        	<div class="entry-date"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" title="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php echo get_the_date(); ?></time></div>
		        <?php endif; ?>
		        <?php if ( $res['show_categories'] ) : ?>
		        <span class="entry-tax">
		            <?php $tax_name = 'news-category';
		                  if( $cat_terms ){
		                      foreach( $cat_terms as $term ){
		                          echo '<a href="'. get_term_link( $term->slug, $tax_name ) .'" class="no-bullet" title="'.esc_attr__( "View all posts in ", 'auxin-news' ). esc_attr( $term->name ) .'" rel="category" >'. esc_html( $term->name ) .'</a>';
		                      }
		                  }
		            ?>
		        </span>
		        <?php endif; ?>
		        <?php if ( $res['show_author'] ) : ?>
			        <div class="entry-author">
			            <span class="meta-sep"><?php esc_html_e( "by", 'auxin-news' ); ?></span>
			            <span class="author vcard">
							<?php 
							$author_link = add_query_arg( 'post_type', 'news', get_author_posts_url( get_the_author_meta( 'ID' ) ) );
							?>
			                <a href="<?php echo esc_url( $author_link ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'auxin-news' ), get_the_author() ) ); ?>" >
			                    <?php the_author(); ?></a>
			            </span>
			        </div>
		        <?php endif; ?>
		        <?php if ( post_type_supports( $post->post_type, 'comments' ) ) {
		            if ( $res['show_comments_count'] ) : ?>
		            <div class="entry-comments">
		                <span class="meta-sep"><?php esc_html_e( "with", 'auxin-news' ); ?></span>
		                <span class="meta-comment"><?php comments_number( __( 'No Comment', 'auxin-news' ), __( 'One Comment', 'auxin-news' ), __('% Comments', 'auxin-news' ) );?></span>
		            </div>
		        <?php endif; } ?>

		        <?php edit_post_link( __( "Edit", 'auxin-news' ), '<i> | </i>', '' ); ?>

		    	</div>
			<?php endif; ?>

			<?php if ( $res['show_title'] && 'before_title' === $res['info_position'] ) : ?>
				<header class="entry-header">
					<div class="entry-title">
						<h4 class="aux-h4">
							<a href="<?php the_permalink(); ?>"><?php
								echo empty( $res['words_num'] ) ? get_the_title() : wp_trim_words( get_the_title(), $res['words_num'] );
							?></a>
						</h4>
					</div>
				</header>
			<?php endif; ?>

			<?php if ( 0 !== intval( $res['content'] ) ) : ?>
				<div class="entry-content">
					<?php
					if ( 'content' === $res['content'] ) {
						the_content();
					} elseif ( 'excerpt' === $res['content'] ) {
						the_excerpt();
					} else {
						echo wp_trim_words( get_the_content(), $res['content'], $res['more_text'] );
					}
					?>
				</div>
			<?php endif; ?>

            <?php if( $res['show_readmore'] || $res['show_author_footer'] ) {?>
                <footer class="entry-meta">
                    <?php if( $res['show_readmore'] ) {?>
                    <div class="readmore">
                        <a href="<?php the_permalink(); ?>" class="aux-read-more"><?php echo esc_html( auxin_get_option( 'post_index_read_more_text' ) ); ?></a>
                    </div>
                    <?php
                    } elseif ( $res['show_author_footer'] ) { ?>
                    <div class="author vcard">
                        <?php echo get_avatar( get_the_author_meta("user_email"), 40 ); ?>
                        <span class="meta-sep"><?php esc_html_e("by", THEME_DOMAIN); ?></span>
						<?php 
						$author_link = add_query_arg( 'post_type', 'news', get_author_posts_url( get_the_author_meta( 'ID' ) ) );
						?>
                        <a href="<?php echo esc_url( $author_link ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', THEME_DOMAIN), get_the_author() ) ); ?>" >
                            <?php the_author(); ?>
                        </a>
                    </div>
                    <?php }

                    if ( $res['show_comments'] && comments_open() ) {
                    ?>
                    <div class="comments-iconic">
                        <?php
                            if( auxin_is_true(  $res['display_like'] ) ){
                                if(function_exists('wp_ulike')) wp_ulike( 'get', array( 'style' => 'wpulike-heart', 'button_type' => 'image', 'wrapper_class' => 'aux-wpulike' ) );
                            }

                            if( isset( $res['display_comments'] ) && auxin_is_true(  $res['display_comments'] ) ){
                        ?>
                            <a href="<?php the_permalink(); ?>#comments" class="meta-comment" >
                                <span class="auxicon-comment"></span><span class="comments-number"><?php echo get_comments_number(); ?></span>
                            </a>
                        <?php
                            }
                        ?>
                    </div>
                    <?php
                    } elseif( auxin_is_true( $res['display_like'] ) && (function_exists('wp_ulike') ) ){ ?>
                    <div class="comments-iconic">
                        <?php wp_ulike( 'get' , array( 'style' => 'wpulike-heart', 'button_type' => 'image', 'wrapper_class' => 'aux-wpulike' ) ); ?>
                    </div>
                   <?php } ?>
                </footer>
            <?php } ?>
		<?php if ( ! $res['inside_mode'] ) : ?>
		<hr class="auxnew-big-sep">
		<?php endif; ?>
		<?php if ( $res['inside_mode'] ) :?>
			</div>
		<?php endif; ?>

	</div>

<?php
}


function auxin_big_grid_element( $args = array() ) {

	$defaults = array(
		'title'           => '',
		'layout'          => 'row-3',
		'order_by'        => 'ASC',
		'order'           => 'date',
		'only_posts__in'  => '',
		'include'         => '',
		'exclude'         => '',
		'offset'          => '',
		'show_title'      => true,
		'words_num'       => '',
		'show_info'       => true,
		'info_position'   => 'after_title',
		'show_date'       => true,
		'show_author'     => true,
		'show_categories' => true,
		'extra_classes'   => true,
		'space'           => false,
		'num'             => 3,
		'tablet_num'      => 3,
		'mobile_num'      => 3,
	);

	$args = wp_parse_args( $args, $defaults );

	$posts = get_posts(
		array(
			'post_type'      => 'news',
			'posts_per_page' => $args['num'],
			'order'          => $args['order'],
			'order_by'       => $args['order_by'],
			'include'        => $args['include'],
			'exclude'        => $args['exclude'],
			'exclude'        => $args['exclude'],
			'offset'         => $args['offset'],
			'only_posts__in' => $args['only_posts__in'],
		)
	 );

	if ( 'row' === $args['layout'] ) {
		auxnew_grid_template_row( $args, $posts );
	} else {
		auxnew_grid_template_grid( $args, $posts );
	}

}

function auxnew_grid_template_row( $args, $posts ) {

	$num = $args['num'];
	$tb_num = $args['tablet_num'];
	$mb_num = $args['mobile_num'];
	?>
	<div class="auxnew-grid">
		<div class="auxnew-grid-row">

			<?php
			$index = 0;
			foreach ( $posts as $post ) {

				if ( ! has_post_thumbnail( $post ) ) {
					continue;
				}

				if ( $index % $num ) {
					echo '<div class="aux-de-col' . esc_attr( $num ) . ' aux-tb-col' . esc_attr( $tb_num ) . ' aux-mb-col' . esc_attr( $mb_num ) . '">';
				}
				?>

					<div class="aux-col">;

					</div>

				<?php
				if ( $index % $num ) {
					echo '</div>';
				}

				$index++;
			}
			?>
			</div>
		</div>
	</div>
<?php
}