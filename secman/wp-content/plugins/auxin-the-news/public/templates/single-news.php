<?php
/**
 * The Template for displaying all single news
 *
 *
 * @package    Auxin
 * @license    LICENSE.txt
 * @author
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2017
*/
$is_pass_protected = post_password_required();

get_header(); ?>
<?php //include 'slider.php'; ?>

    <main id="main" <?php auxin_content_main_class(); ?> >
        <div class="aux-wrapper">
            <div class="aux-container aux-fold">

                <div id="primary" class="aux-primary" >
                    <div class="content" role="main"  >

                        <?php if ( have_posts() && ! $is_pass_protected ) : ?>

                            <?php auxnew_get_template_part( 'theme-parts/single', get_post_type() ); ?>

                            <?php if ( post_type_supports( 'news', 'comments' ) ) : ?>
                                <?php comments_template( '/comments.php', true ); ?>
                            <?php endif; ?>

                        <?php elseif( $is_pass_protected ) : ?>

                            <?php echo get_the_password_form(); ?>

                        <?php else : ?>

                            <?php auxnew_get_template_part( 'theme-parts/content', 'none' ); ?>

                        <?php endif; ?>

                    </div><!-- end content -->

                </div><!-- end primary -->

                <?php get_sidebar(); ?>

            </div><!-- end container -->

        </div><!-- end wrapper -->
    </main><!-- end main -->

<?php get_sidebar('footer'); ?>
<?php get_footer(); ?>
