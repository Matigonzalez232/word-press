<?php get_header(); ?>


<main>
    <div class="row justify-content-center">
        <?php

        $args = array(
            'post_type'        => 'productos',
            'order'            => "DESC",
            'post_status'      => 'publish',

        );
        $productos = new WP_Query($args);

        while ($productos->have_posts()) {
            $productos->the_post();
            $folleto = get_field("folleto_producto");
            $manual = get_field("manual");
        ?>
        <div class="col-md-6">
            <div class="card">
                <h3><?php echo the_title(); ?></h3>
                <div>
                    <img src="<?php echo the_post_thumbnail_url(); ?>" alt="Imagen del producto">
                </div>
                <p><?php echo $folleto; ?></p>
                <a><?php echo $manual; ?></a>
            </div>
        </div>
            
        <?php }
        wp_reset_postdata() ?>
    </div>
</main>



<?php get_footer(); ?>