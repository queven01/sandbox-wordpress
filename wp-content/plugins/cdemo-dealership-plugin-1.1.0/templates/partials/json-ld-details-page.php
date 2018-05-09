<?php

namespace cdemo;

?>

<?php while( have_posts() ) : the_post(); ?>

    <script type="application/ld+json">

        {
            "@context": "http://schema.org",
            "@type": "Vehicle",
            "name": "<?php the_title(); ?>",
            "model": "<?php esc_attr_e( get_post_meta( get_the_ID(), 'model', true ) ); ?>",
            "image": "<?php echo esc_url( get_post_image_url() ); ?>",
            "url": "<?php echo esc_url( get_the_permalink() ); ?>",
            "description": "<?php the_content(); ?>",
            "modelDate": "<?php esc_attr_e( get_post_meta( get_the_ID(), 'year_manufactured', true ) ); ?>",
            "vehicleIdentificationNumber": "<?php esc_attr_e( get_post_meta( get_the_ID(), 'vin', true ) ); ?>"
        }

    </script>

    <?php wp_reset_postdata(); ?>

<?php endwhile; ?>