<?php

namespace cdemo;

?>

<div class="wrap cdemo-admin-page cdemo-new-listing">

    <h2><?php _e( 'Add Listing', 'cdemo' ); ?></h2>

    <div class="wrapper">

        <h3><?php _e( 'What type of listing would you like to add?', 'cdemo' ); ?></h3>

        <div class="inside">

            <ul>

                <?php foreach ( active_listing_types() as $type ) : $post_type = get_post_type_object( $type ); ?>

                    <li>

                        <a href="<?php echo esc_url( admin_url( 'post-new.php' ) . '?post_type=' . $post_type->name  ); ?>">
                            <span class="listing-icon post-type-<?php echo $type ?>"></span>
                            <h3 class="post-type-label"><?php esc_html_e( $post_type->labels->singular_name ) ; ?></h3>
                        </a>

                    </li>

                <?php endforeach; ?>

            </ul>

            <div class="clear"></div>

        </div>

    </div>

</div>
