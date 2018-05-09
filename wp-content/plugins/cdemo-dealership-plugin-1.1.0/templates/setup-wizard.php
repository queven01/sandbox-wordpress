<?php

namespace cdemo;
?>

<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo esc_url( resolve_url( 'assets/lib/bootstrap/css/bootstrap.min.css' ) ); ?>" />
        <link rel="stylesheet" href="<?php echo esc_url( resolve_url( 'assets/admin/css/setup-wizard.css' ) ); ?>" />
    </head>
    <body>

        <div id="setup-wizard" class="">

            <div class="row">

                <div class="col-sm-12">

                    <h1 class="cdemo-logo">
                        <img src="<?php echo resolve_url( 'assets/images/cdemo-logo.png' ); ?>"/>
                        <img src="<?php echo resolve_url( 'assets/images/cdemo-logo_alt.png' ); ?>"/>
                    </h1>
                    
                    <div id="form-wrapper">

                        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php?action=cdemo_setup_wizard' ) ); ?>">

                            <div class="inner">

                                <?php
                                switch ( absint( $_GET[ 'step' ] ) ) :

                                    case 2 :
                                        ?>

                                        <h3><?php esc_html_e( get_option( Options::COMPANY_NAME ) ); ?></h3>
                                        <hr>
                                        <p>
                                            <label for="measurement-units"><?php _e( 'Please select your unit of measurement', 'cdemo' ); ?></label>
                                            <?php
                                            render_select_box( new Field( array (
                                                'render_callback' => 'cdemo\render_select_box',
                                                'attributes' => array (
                                                    'id' => 'measurement-units',
                                                    'name' => 'measurement_units',
                                                    'class' => 'form-control'
                                                ),
                                                'config' => array (
                                                    'options' => array (
                                                        array (
                                                            'title' => __( 'Metric', 'cdemo' ),
                                                            'attributes' => array ( 'value' => 'metric' )
                                                        ),
                                                        array (
                                                            'title' => __( 'Imperial', 'cdemo' ),
                                                            'attributes' => array ( 'value' => 'imperial' )
                                                        )
                                                    )
                                                )
                                            ) ) );
                                            ?>

                                        </p>
                                        <p>
                                            <label for="currency-code"><?php _e( 'Please select your currency', 'cdemo' ); ?></label>
                                            <?php
                                            render_select_box( new Field( array (
                                                'render_callback' => 'cdemo\render_select_box',
                                                'attributes' => array (
                                                    'id' => 'currency-code',
                                                    'name' => 'currency_code',
                                                    'class' => 'form-control'
                                                ),
                                                'config' => array (
                                                    'options' => array (
                                                        array (
                                                            'title' => __( 'Dollars (Canadian)', 'cdemo' ),
                                                            'attributes' => array ( 'value' => 'cad' )
                                                        ),
                                                        array (
                                                            'title' => __( 'Dollars (United States)', 'cdemo' ),
                                                            'attributes' => array ( 'value' => 'usd' )
                                                        )
                                                    )
                                                )
                                            ) ) );
                                            ?>

                                        </p>

                                        <?php
                                        break;

                                    case 1 :
                                    default :
                                        ?>
                                        <div class="form-group">
                                        <label for="company-name"><?php _e( 'What is your company name?', 'cdemo' ); ?></label>
                                        <?php
                                        render_text_field( new Field( array (
                                            'render_callback' => 'cdemo\render_text_field',
                                            'attributes' => array (
                                                'id' => 'company-name',
                                                'name' => 'company_name',
                                                'class' => 'form-control'
                                            )
                                        ) ) );
                                        ?>
                                        </div>
                                        <?php break; ?>

                                <?php endswitch; ?>

                                <input type="hidden" name="step" value="<?php esc_attr_e( absint( $_GET[ 'step' ] ) ); ?>">

                                <?php wp_nonce_field( 'setup_wizard_next', 'setup_wizard_nonce' ); ?>

                                <p class="navigation">
                                    <button class="btn btn-default"><?php _e( 'Save & Next', 'cdemo' ); ?></button>
                                </p>

                            </div>

                        </form>
                    </div>
                    
                    <div class="center">
                        <a href="<?php echo admin_url( 'admin.php?page=cdemo-new-listing' ); ?>"><?php _e( 'Skip setup wizard', 'cdemo' ); ?></a>
                    </div>
                    
                    
                    
                </div>

            </div>



        </div>

        <script src="<?php echo esc_url( resolve_url( 'assets/admin/js/setup-wizard.js' ) ); ?>"></script>

    </body>
</html>
