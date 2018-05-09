<?php

namespace cdemo;

?>

<script type="application/ld+json">

{
	"@context": "http://schema.org",
    "@type": "ItemList",
    "numberOfItems": "<?php esc_attr_e( $the_query->post_count ); ?>",
    "itemListElement": [
        <?php while ( $the_query->have_posts() ) { $the_query->the_post();

		    ?>{
                "@type": "ListItem",
                "position": "<?php esc_attr_e( $the_query->current_post ); ?>",
                "url": "<?php the_permalink(); ?>"
            }<?php

		    if ( $the_query->current_post + 1 < $the_query->post_count ) {
			    echo ',';
		    }

		    wp_reset_postdata();

	    } ?>
	]
}

</script>
