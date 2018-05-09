<?php

/**
 *-------------------- Button Colors -----------------------------*
 */
$wp_customize->add_section('ghost_colors', array(
    'title'    => __('Ghost Class', 'acf_color_three'),
    'priority' => 3,
    'panel' => 'button_options',

));

/**
 *-------------------- Background Colors -----------------------------*
 */
$wp_customize->add_setting('button_bg_color3', array(
    'default' => ''
));
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'button_bg_color3',
        array(
            'label'      => __( 'Background Color', 'acf_color_three' ),
            'section'    => 'ghost_colors',
            'settings'   => 'button_bg_color3'
        )
    )
);

/**
 *-------------------- Text Colors -----------------------------*
 */
$wp_customize->add_setting('button_txt_color3', array(
    'default' => ''
));
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'button_txt_color3',
        array(
            'label'      => __( 'Text Color', 'acf_color_three' ),
            'section'    => 'ghost_colors',
            'settings'   => 'button_txt_color3'
        )
    )
);

/**
 *-------------------- Background Hover Colors -----------------------------*
 */
$wp_customize->add_setting('button_bg_hover3', array(
    'default' => ''
));
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'button_bg_hover3',
        array(
            'label'      => __( 'Background Hover Color', 'acf_color_three' ),
            'section'    => 'ghost_colors',
            'settings'   => 'button_bg_hover3'
        )
    )
);

/**
 *-------------------- Text Hover Colors -----------------------------*
 */
$wp_customize->add_setting('button_txt_hover3', array(
    'default' => ''
));
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'button_txt_hover3',
        array(
            'label'      => __( 'Text Hover Color', 'acf_color_three' ),
            'section'    => 'ghost_colors',
            'settings'   => 'button_txt_hover3'
        )
    )
);

/**
 *-------------------- Button Border Color -----------------------------*
 */
$wp_customize->add_setting('button_border_color3', array(
    'default' => ''
));
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'button_border_color3',
        array(
            'label'      => __( 'Button Border Color', 'acf_color_three' ),
            'section'    => 'ghost_colors',
            'settings'   => 'button_border_color3'
        )
    )
);

/**
 *-------------------- Font Size -----------------------------*
 */
$wp_customize->add_setting('ghost_font_size', array(
    'default'        => '20px',
));

$wp_customize->add_control('ghost_font_size', array(
    'label'      => __('Font Size', 'font_size'),
    'description'=> __('Include unit of measurement example: px, rem, em, %'),
    'section'    => 'ghost_colors',
    'settings'   => 'ghost_font_size',
));

/**
 *-------------------- Button Size -----------------------------*
 */
$wp_customize->add_setting( 'ghost_button_size', array(
        'default'    => '.75rem 1.5rem',
        'type'       => 'theme_mod',
    )
);
$wp_customize->add_control('ghost_button_size', array(
    'label'      => __('Button Padding', 'button_size'),
    'description'=> __('Example: Padding: 10px 5px 10px 5px;
                            Include: px, rem, em, %'),
    'section'    => 'ghost_colors',
    'settings'   => 'ghost_button_size',
));

/**
 *-------------------- Button Spacing -----------------------------*
 */
$wp_customize->add_setting( 'ghost_button_spacing', array(
        'default'    => '1.5rem',
        'type'       => 'theme_mod',
    )
);
$wp_customize->add_control('ghost_button_spacing', array(
    'label'      => __('Button Margin', 'button_size'),
    'description'=> __('Example: Margin: 10px 5px 10px 5px;
                            Include: px, rem, em, %'),
    'section'    => 'ghost_colors',
    'settings'   => 'ghost_button_spacing',
));

/**
 *-------------------- Button Font Family -----------------------------*
 */


$url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAIVfsLS5EQwq3AyOJiEX6LquZuW-rCPyk";
$json = file_get_contents($url);
$json_data = json_decode($json, true);
$itemsArray3 = $json_data[items];
$fonts = array(
    'default' => 'Default',
);

//Loop Through all Google Fonts
foreach ($itemsArray3 as $key => $value) {
    $font_select3 = $value["family"];
    array_push($fonts, $font_select3);
}

$wp_customize->add_setting( 'ghost_font_family',
    array(
        'default'    => 'default',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        //'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
    )
);
$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'ghost_font_family',
    array(
        'label'      => __( 'Button Font Family', 'font_family' ),
        'description'=> __('<a href="https://fonts.google.com/" target="_blank">View Google Fonts</a> to pick the style you need.'),
        'settings'   => 'ghost_font_family',
        'priority'   => 10,
        'section'    => 'ghost_colors',
        'type'    => 'select',
        'choices' => $fonts,
    )
) );
