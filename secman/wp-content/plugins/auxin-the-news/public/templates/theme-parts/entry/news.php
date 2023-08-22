<?php global $post, $more, $aux_content_width; $more = 0; // to enable read more tag

    $post_vars   = auxin_get_post_format_media( $post, array(
        'request_from' => 'archive',
        'crop'         => true, // 'true' hard crop, 'false' soft crop, array the crop focus point
        'image_sizes'  => array(
            array( 'min' => '',      'max' => '1025px', 'width' => '80vw' ),
            array( 'min' => ''     , 'max' => '',      'width' => round( $aux_content_width ).'px' )
        ),
        'srcset_sizes'  => array(
            array( 'width' =>     500 , 'height' => 'auto' ),
            array( 'width' =>     $aux_content_width, 'height' => 'auto' ),
            array( 'width' => 2 * $aux_content_width, 'height' => 'auto' )
        )
    ) );
    extract( $post_vars );
?>
                        <article <?php post_class(); ?> >
                            <?php if ( $has_attach ) : ?>
                            <div class="entry-media">

                                <?php echo $the_media; ?>

                            </div>
                            <?php endif; ?>

                            <div class="entry-main">

                                <header class="entry-header"> 
                                <?php 
                                if( $show_title ) { ?> 
                                    <h3 class="entry-title">
                                        <a href="<?php echo !empty( $the_link ) ? esc_url( $the_link ) : esc_url( get_permalink() ); ?>">
                                            <?php echo !empty( $the_name ) ? $the_name : get_the_title(); ?>
                                        </a>
                                    </h3> 
                                <?php 
                                } ?> 
                                </header>

                                <div class="entry-info">
                                    <div class="entry-date">
                                        <a href="<?php the_permalink(); ?>">
                                            <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" title="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php the_date(); ?></time>
                                        </a>
                                    </div>
                                    <span class="meta-sep"><?php esc_html_e("by", 'auxin-news' ); ?></span>
                                    <span class="author vcard">
                                        <?php 
                                        $author_link = add_query_arg( 'post_type', 'news', get_author_posts_url( get_the_author_meta( 'ID' ) ) );
                                        ?>
                                        <a href="<?php echo esc_url( $author_link ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'auxin-news'  ), get_the_author() ) ); ?>" >
                                            <?php the_author(); ?>
                                        </a>
                                    </span>
                                    <?php if ( post_type_supports( 'news', 'comments' ) && comments_open() ){ /* just display comments number if the comments is not closed. */?>
                                    <span class="meta-sep"><?php esc_html_e( "with", 'auxin-news'  ); ?></span>
                                    <a href="<?php the_permalink(); ?>#comments" class="meta-comment" ><?php comments_number( __( 'No Comment', 'auxin-news'  ), __( 'One Comment', 'auxin-news'  ), __( '% Comments', 'auxin-news'  ) );?></a>
                                    <?php } ?>
                                    <span class="entry-tax">
                                        <?php // the_category(' '); we can use this template tag, but customizable way is needed! ?>
                                        <?php $tax_name = 'news-category';
                                              if( $cat_terms = get_the_terms( $post->ID, $tax_name ) ){
                                                  foreach( $cat_terms as $term ){
                                                      echo '<a href="'. esc_url( get_term_link( $term->slug, $tax_name ) ) .'" title="'.esc_attr__( "View all news in ", 'auxin-news'  ). esc_attr( $term->name ) .'" rel="category" >'. esc_html( $term->name ) .'</a>';
                                                  }
                                              }
                                        ?>
                                    </span>
                                    <?php edit_post_link( esc_html__( "Edit", 'auxin-news'  ), '<i> | </i>', ''); ?>
                                </div>

                                <div class="entry-content">
                                    <?php

                                    $content_listing_type   = is_tax( 'news-category' ) || is_tax( 'news-tag' ) ? auxin_get_option( 'news_taxonomy_archive_content_on_listing' ) : auxin_get_option( 'news_content_on_listing' );
                                    $content_listing_length = is_tax( 'news-category' ) || is_tax( 'news-tag' ) ? auxin_get_option( 'news_taxonomy_archive_on_listing_length', 255 ) :
                                                              auxin_get_option( 'news_content_on_listing_length', 255 );

                                    if( has_excerpt() ){
                                        the_excerpt();
                                    } elseif( $content_listing_type == 'full' ) {
                                        the_content( __( 'Continue Reading', 'auxin-news'  ) );
                                    } else {
                                        auxin_the_trim_excerpt( null, $content_listing_length, null, false, 'p' );
                                    }

                                    // clear the floated elements at the end of content
                                    echo '<div class="clear"></div>';

                                    // create pagination for page content
                                    wp_link_pages( array( 'before' => '<div class="page-links"><span>' . esc_html__( 'Pages:', 'auxin-news' ) .'</span>', 'after' => '</div>' ) );
                                    ?>
                                </div>

                                <footer class="entry-meta">
                                    <div class="readmore">
                                        <a href="<?php the_permalink(); ?>" class="aux-read-more aux-outline aux-large"><?php esc_html_e("Read More", 'auxin-news' ); ?></a>
                                    </div>
                                </footer>

                            </div>

                        </article>
