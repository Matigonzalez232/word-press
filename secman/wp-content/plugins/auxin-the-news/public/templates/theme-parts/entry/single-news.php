<?php global $post, $aux_content_width;

    $post_vars               = auxin_get_post_format_media( $post, array( 'request_from' => 'single' ) );
    extract( $post_vars );

    // Get the alignment of the title in page content
    if( 'default' === $title_alignment = auxin_get_post_meta( $post, 'page_content_title_alignment', 'default' ) ){
        $title_alignment = auxin_get_option( 'news_single_title_alignment' );
    }
    $title_alignment = 'default' === $title_alignment ? '' : 'aux-text-align-' .$title_alignment;

    $post_content_style      = auxin_get_post_meta( $post, 'news_content_style', 'default' );
    if( 'default' == $post_content_style ){
        $post_content_style  = auxin_get_option( 'news_single_content_style' );
    }
    $post_extra_classes      = 'narrow' == $post_content_style ? 'aux-narrow-context' : '';
?>
                                    <article <?php post_class( $post_extra_classes ); ?> >

                                            <?php if ( $has_attach ) : ?>
                                            <div class="entry-media">
                                                <?php echo $the_media; ?>
                                            </div>
                                            <?php endif; ?>

                                            <div class="entry-main">
                                                <header class="entry-header <?php echo esc_attr( $title_alignment ); ?>">
                                                    <h2 class="entry-title <?php echo $show_title ? '' : ' aux-visually-hide'; ?>">
                                                        <?php
                                                        $post_title = !empty( $the_name ) ? esc_html( $the_name ) : get_the_title();

                                                        if( ! empty( $the_link ) ){
                                                            echo '<cite><a href="'.esc_url( $the_link ).'" title="'.esc_attr( $post_title ).'">'.$post_title.'</a></cite>';
                                                        } else {
                                                            echo $post_title;
                                                        }
                                                        ?>
                                                    </h2>
                                                </header>

                                                <?php
                                                if( auxin_is_true( auxin_get_option( 'show_news_single_meta_info' ) ) ){
                                                ?>
                                                <div class="entry-info <?php echo esc_attr( $title_alignment ); ?>">
                                                    <?php
                                                    if ( auxin_is_true( auxin_get_option( 'aux_news_meta_date_show', true ) ) ) {
                                                    ?>
                                                    <div class="entry-date"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php the_date(); ?></time></div>
                                                    <?php }
                                                    if ( auxin_is_true( auxin_get_option( 'aux_news_meta_author_show' ) ) ) {
                                                    ?>
                                                    <div class="entry-author">
                                                        <span class="meta-sep"><?php esc_html_e( "by", 'auxin-news' ); ?></span>
                                                        <span class="author vcard">
                                                            <?php 
                                                            $author_link = add_query_arg( 'post_type', 'news', get_author_posts_url( get_the_author_meta( 'ID' ) ) );
                                                            ?>
                                                            <a href="<?php echo esc_url( $author_link ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'auxin-news' ), get_the_author() ) ); ?>" >
                                                                <?php the_author(); ?>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <?php }
                                                    if ( post_type_supports( 'news', 'comments' ) ) {
                                                        if ( auxin_is_true( auxin_get_option( 'aux_news_meta_comments_show' ) ) ) {
                                                        ?>
                                                        <div class="entry-comments">
                                                            <span class="meta-sep"><?php esc_html_e( "with", 'auxin-news' ); ?></span>
                                                            <span class="meta-comment"><?php comments_number( __('No Comment', 'auxin-news' ), __('One Comment', 'auxin-news' ), __('% Comments', 'auxin-news' ) );?></span>
                                                        </div>
                                                        <?php }
                                                    }
                                                    if ( auxin_is_true( auxin_get_option( 'aux_news_meta_categories_show' ) ) ) {
                                                    ?>
                                                    <span class="entry-tax">
                                                        <?php // the_category(' '); we can use this template tag, but customizable way is needed! ?>
                                                        <?php $tax_name = 'news-category';
                                                              if( $cat_terms = get_the_terms( $post->ID, $tax_name ) ){
                                                                  foreach( $cat_terms as $term ){
                                                                      echo '<a href="'. get_term_link( $term->slug, $tax_name ) .'" title="'.esc_attr__( "View all posts in ", 'auxin-news' ). esc_attr( $term->name ) .'" rel="category" >'. esc_html( $term->name ) .'</a>';
                                                                  }
                                                              }
                                                        ?>
                                                    </span>
                                                    <?php }
                                                        edit_post_link(__( "Edit", 'auxin-news' ), '<i> | </i>', '');

                                                        if( auxin_is_true( auxin_get_option( 'show_news_post_like_button', true ) ) ){
                                                            if( function_exists('wp_ulike') ){
                                                                wp_ulike( 'get', array( 'style' => 'wpulike-heart', 'button_type' => 'image', 'wrapper_class' => 'aux-wpulike' ) );
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <?php
                                                }
                                                ?>

                                                <div class="entry-content">
                                                    <?php
                                                    the_content( __( 'Continue reading', 'auxin-news' ) );
                                                    // clear the floated elements at the end of content
                                                    echo '<div class="clear"></div>';
                                                    // create pagination for page content
                                                    wp_link_pages( array( 'before' => '<div class="page-links"><span>' . esc_html__( 'Pages:', 'auxin-news' ) .'</span>', 'after' => '</div>' ) );
                                                    ?>
                                                </div>

                                                <?php
                                                $show_share_links = auxin_get_option( 'show_news_single_tags_section', true );
                                                $the_tags         = get_the_term_list( $post->ID, 'news-tag', '<span>'. esc_html__( "Tags: ", 'auxin-news' ). '</span>', '<i>, </i>', '');

                                                if( $show_share_links ){
                                                ?>
                                                <footer class="entry-meta">
                                                <?php if( $the_tags ){ ?>
                                                        <div class="entry-tax">
                                                            <?php echo $the_tags; ?>
                                                        </div>
                                                <?php } else { ?>
                                                        <div class="entry-tax"><span><?php esc_html_e("Tags: No tags", 'auxin-news' ); ?></span></div>
                                                <?php }
                                                if ( auxin_get_option( 'show_news_post_share_button', true ) ) {
                                                    $data_text = ( 'text' === $share_type = auxin_get_option( 'news_post_share_button_type', 'icon' ) ) ? 'data-text="' . esc_attr__( 'Share', THEME_DOMAIN ) . '"' : '';
                                                    $icon_class = ( $share_type == 'text' ) ? 'aux-has-text' : 'aux-icon ' . auxin_get_option( 'news_post_share_button_icon', 'auxicon-share' );
                                                ?>
                                                    <div class="aux-post-share">
                                                         <div class="aux-tooltip-socials aux-tooltip-dark aux-socials aux-icon-left aux-medium aux-tooltip-social-no-text" <?php echo $data_text; ?> >
                                                             <span class="<?php echo esc_attr( $icon_class ); ?>" <?php echo $data_text;?>></span>
                                                         </div>
                                                     </div>
                                                <?php }
                                                if ( auxin_get_option( 'show_news_post_like_button', 1 )  ) {
                                                        if ( function_exists( 'wp_ulike' ) ) {
                                                            add_filter( 'wp_ulike_add_templates_args', 'auxnew_change_like_icon', 1, 1 );
                                                            wp_ulike( 'get', array( 'style' => 'wpulike-heart', 'button_type' => 'image', 'wrapper_class' => 'aux-wpulike' ) );
                                                            remove_filter( 'wp_ulike_add_templates_args', 'auxnew_change_like_icon', 1 );
                                                        }
                                                    }
                                                    ?>

                                                </footer>
                                                <?php } ?>
                                            </div>


                                            <?php // get related posts
                                            // get next/prev news button
                                            if( 'default' == $display_next_pre = auxin_get_post_meta( $post->ID, '_show_next_prev_nav', 'default' ) ){
                                                $display_next_pre = auxin_get_option( 'show_news_single_next_prev_nav', false );
                                            }

                                            if( auxin_is_true( $display_next_pre ) ) {
                                                echo '<div class="aux-next-prev-posts-container">';
                                                if( 'default' == $next_prev_skin = auxin_get_post_meta( $post->ID, '_next_prev_nav_skin', 'default' ) ){
                                                    $next_prev_skin = auxin_get_option( 'news_single_next_prev_nav_skin', false );
                                                }
                                                auxin_single_page_navigation( array(
                                                    'prev_text'      => __( 'Previous News', 'auxin-news' ),
                                                    'next_text'      => __( 'Next News'    , 'auxin-news' ),
                                                    'taxonomy'       => 'news-category',
                                                    'skin'           => $next_prev_skin // minimal, thumb-no-arrow, thumb-arrow, boxed-image
                                                ));
                                                echo '</div>';
                                            }


                                            if( function_exists( 'rp4wp_children' ) ){
                                                echo '<div class="aux-related-posts-container">' . rp4wp_children( false, false ) . '</div>';
                                            }
                                            ?>


                                            <?php if( auxin_get_option( 'show_news_author_section', 1 ) ) { ?>
                                            <div class="entry-author-container">
                                                <div class="entry-author-info">
                                                        <div class="author-avatar">
                                                            <?php echo get_avatar( get_the_author_meta( "user_email" ), auxin_get_option( 'aux_news_avatar_size', 100 ) ); ?>
                                                        </div><!-- #author-avatar -->
                                                        <div class="author-description">
                                                            <dl>
                                                                <dt>
                                                                    <?php 
                                                                    $author_link = add_query_arg( 'post_type', 'news', get_author_posts_url( get_the_author_meta( 'ID' ) ) );
                                                                    ?>
                                                                    <a href="<?php echo esc_url( $author_link ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'auxin-news' ), get_the_author() ) ); ?>" >
                                                                        <?php the_author(); ?>
                                                                    </a>
                                                                </dt>
                                                                <dd>
                                                                <?php if( get_the_author_meta('skills') ) { ?>
                                                                    <span><?php the_author_meta('skills');?></span>
                                                                <?php }
                                                                if( auxin_get_option( 'show_news_author_section_text' ) && ( get_the_author_meta('user_description') ) ) {
                                                                    ?>
                                                                    <p><?php the_author_meta('user_description');?>.</p>
                                                                    <?php } ?>
                                                                </dd>
                                                            </dl>
                                                            <?php if( auxin_get_option( 'show_news_author_section_social' ) ) {
                                                                auxin_the_socials( array(
                                                                    'css_class' => ' aux-author-socials',
                                                                    'size'      => 'medium',
                                                                    'direction' => 'horizontal',
                                                                    'social_list'   => array(
                                                                        'facebook'   => get_the_author_meta('facebook'),
                                                                        'twitter'    => get_the_author_meta('twitter'),
                                                                        'googleplus' => get_the_author_meta('googleplus'),
                                                                        'flickr'     => get_the_author_meta('flickr'),
                                                                        'dribbble'   => get_the_author_meta('dribbble'),
                                                                        'delicious'  => get_the_author_meta('delicious'),
                                                                        'pinterest'  => get_the_author_meta('pinterest'),
                                                                        'github'     => get_the_author_meta('github')
                                                                    ),
                                                                    'social_list_type'   => 'site',
                                                                    'fill_social_values' => false
                                                                ));
                                                            }
                                                            ?>
                                                        </div><!-- #author-description -->

                                                </div> <!-- #entry-author-info -->
                                            </div> <!-- #entry-author-container -->
                                            <?php } ?>

                                       </article>
