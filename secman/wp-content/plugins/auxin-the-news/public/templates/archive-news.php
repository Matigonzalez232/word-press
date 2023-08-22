<?php

/**
 * Archive News
 *
 * 
 * @package    Auxin
 * @license    LICENSE.txt
 * @author     averta <info@averta.net> (www.averta.net)
 * @link       http://averta.net/phlox/
 * @copyright  (c) 2010-2023 averta <info@averta.net> (www.averta.net)
 */

get_header();?>

    <main id="main" <?php auxin_content_main_class(); ?> >
        <div class="aux-wrapper">
            <div class="aux-container aux-fold clearfix">

                <div id="primary" class="aux-primary">
                    <div class="content" role="main" data-target="archive">

<?php
                    if( have_posts() ){
                        auxnew_get_template_part( 'theme-parts/loop', 'news' );
                    } else {
                        auxnew_get_template_part( 'theme-parts/content', 'none' );
                    }
?>
                    </div><!-- end content -->
                </div><!-- end primary -->


                <?php get_sidebar(); ?>

            </div><!-- end container -->
        </div><!-- end wrapper -->
    </main><!-- end main -->

<?php get_sidebar('footer'); ?>
<?php get_footer(); ?>
