<?php get_header(); ?>


<main>
    <div class="row justify-content-center">
        <?php

        $args = array(
            'post_type'        => 'financiacion',
            'order'            => "DESC",
            'post_status'      => 'publish',

        );
        $financiacion = new WP_Query($args);

        while ($financiacion->have_posts()) {
            $financiacion->the_post();
            $folleto = get_field("folleto_banco");
            $link_banco = get_field("link_banco");
        ?>
        <div class="col-md-6">
            <h3><?php echo the_title(); ?></h3>
            <div>
                <img src="<?php echo the_post_thumbnail_url(); ?>" alt="Imagen del producto">
            </div>
            <p><?php echo $folleto; ?></p>
            <a><?php echo $link_banco; ?></a>
        </div>
            
        <?php }
        wp_reset_postdata() ?>
    </div>
</main>



<?php get_footer(); ?>