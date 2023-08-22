<?php

while ( have_posts() ) : the_post();

    auxnew_get_template_part( 'theme-parts/entry/single', 'news');

endwhile; // end of the loop.
