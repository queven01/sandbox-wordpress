<?php
/**
 *-------------------- Header View Selection -----------------------------*
 */
$wp_customize->add_section('header_option', array(
    'title'    => __('Header Options', 'acf_theme'),
    'priority' => 1,

));

$wp_customize->add_setting( 'header_view',
    array(
        'default'    => 'default',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        //'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
    )
);
$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'header_view',
    array(
        'label'      => __( 'Header Selection', 'header_view' ),
        'settings'   => 'header_view',
        'priority'   => 10,
        'section'    => 'header_option',
        'type'    => 'select',
        'choices'  => array(
            'header_one'  => 'Header 1',
            'header_two' => 'Header 2',
            'header_three' => 'Header 3',
            'header_four' => 'Header 4',
        ),
    )
) );
/**
 *-------------------- Sticky Navigation -----------------------------*
 */
$wp_customize->add_setting('fixed', array(
    'default' => ''
));

$wp_customize->add_control('fixed', array(
    'label'    => __('Sticky Navigation'),
    'section'  => 'header_option',
    'type'     => 'checkbox',
    'settings' => 'fixed',
));

/**
 *-------------------- Transparent Navigation -----------------------------*
 */
$wp_customize->add_setting('transparent', array(
    'default' => ''
));

$wp_customize->add_control('transparent', array(
    'label'    => __('Transparent Navigation'),
    'section'  => 'header_option',
    'type'     => 'checkbox',
    'settings' => 'transparent',
));

/**
 *-------------------- Text Colors -----------------------------*
 */
$wp_customize->add_setting('header_text_color', array(
    'default' => ''
));
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'header_text_color',
        array(
            'label'      => __( 'Text Color', 'acf_theme' ),
            'section'    => 'header_option',
            'settings'   => 'header_text_color'
        )
    )
);

/**
 *-------------------- Text Hover Colors -----------------------------*
 */
$wp_customize->add_setting('header_text_color_hover', array(
    'default' => ''
));
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'header_text_color_hover',
        array(
            'label'      => __( 'Text Hover Color', 'acf_theme' ),
            'section'    => 'header_option',
            'settings'   => 'header_text_color_hover'
        )
    )
);

/**
 *-------------------- Background Colors -----------------------------*
 */
$wp_customize->add_setting('header_background', array(
    'default' => ''
));
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'header_background',
        array(
            'label'      => __( 'Background Color', 'acf_theme' ),
            'section'    => 'header_option',
            'settings'   => 'header_background'
        )
    )
);

/**
 *-------------------- Show Top Bar -----------------------------*
 */
$wp_customize->add_setting('top_bar', array(
    'default' => ''
));

$wp_customize->add_control('top_bar', array(
    'label'    => __('Display Top Bar'),
    'section'  => 'header_option',
    'type'     => 'checkbox',
    'settings' => 'top_bar',
));

/**
 *-------------------- Top Bar Phone Number -----------------------------*
 */
$wp_customize->add_setting('phone_number', array(
    'default' => ''
));

$wp_customize->add_control('phone_number', array(
    'label'      => __('Phone Number', 'acf_theme'),
    'section'    => 'header_option',
    'settings'   => 'phone_number',
));

/**
 *-------------------- Top Bar Address -----------------------------*
 */
$wp_customize->add_setting('address', array(
    'default' => ''
));

$wp_customize->add_control('address', array(
    'label'      => __('Address', 'acf_theme'),
    'section'    => 'header_option',
    'settings'   => 'address',
));

/**
 *-------------------- Top Bar Background Colors -----------------------------*
 */
$wp_customize->add_setting('top_bar_background', array(
    'default' => ''
));
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'top_bar_background',
        array(
            'label'      => __( 'Top Bar Background Color', 'acf_theme' ),
            'section'    => 'header_option',
            'settings'   => 'top_bar_background'
        )
    )
);
