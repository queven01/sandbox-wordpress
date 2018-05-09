<?php
/**
 *-------------------- Button Colors -----------------------------*
 */
$wp_customize->add_section('heading_two', array(
    'title'    => __('Header Two', 'acf_theme'),
    'priority' => 1,
    'panel' => 'heading_options',

));


/**
 *-------------------- Text Colors -----------------------------*
 */
$wp_customize->add_setting('heading_two_color', array(
    'default' => ''
));
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'heading_two_color',
        array(
            'label'      => __( 'Text Color', 'acf_theme' ),
            'section'    => 'heading_two',
            'settings'   => 'heading_two_color'
        )
    )
);

/**
 *-------------------- Font Size -----------------------------*
 */
$wp_customize->add_setting('heading_two_size', array(
    'default'        => '20px',
));

$wp_customize->add_control('heading_two_size', array(
    'label'      => __('Font Size', 'header_font_size'),
    'description'=> __('Include unit of measurement example: px, rem, em, %'),
    'section'    => 'heading_two',
    'settings'   => 'heading_two_size',
));

/**
 *-------------------- Font Spacing -----------------------------*
 */
$wp_customize->add_setting( 'heading_two_margin', array(
        'default'    => '1.5rem',
        'type'       => 'theme_mod',
    )
);
$wp_customize->add_control('heading_two_margin', array(
    'label'      => __('Header Margin', 'header_margin'),
    'description'=> __('Example: Margin: 10px 5px 10px 5px;
                            Include: px, rem, em, %'),
    'section'    => 'heading_two',
    'settings'   => 'heading_two_margin',
));

/**
 *-------------------- Button Font Family -----------------------------*
 */
//Google API Fonts
$url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAIVfsLS5EQwq3AyOJiEX6LquZuW-rCPyk";
$json = file_get_contents($url);
$json_data = json_decode($json, true);
$itemsArray = $json_data[items];
$fonts = array(
    'default' => 'Default',
);

//Loop Through all Google Fonts
foreach ($itemsArray as $key => $value) {
    $font_select = $value["family"];
    array_push($fonts, $font_select);
}

$wp_customize->add_setting( 'heading_two_font_family',
    array(
        'default'    => 'default',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        //'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
    )
);
$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'heading_two_font_family',
    array(
        'label'      => __( 'Header Two Font Family', 'header_font_family' ),
        'description'=> __('<a href="https://fonts.google.com/" target="_blank">View Google Fonts</a> to pick the style you need.'),
        'settings'   => 'heading_two_font_family',
        'priority'   => 10,
        'section'    => 'heading_two',
        'type'    => 'select',
        'choices' => $fonts,
    )
) );
