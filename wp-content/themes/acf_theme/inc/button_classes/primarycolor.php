 <?php

 /**
  *-------------------- Button Colors -----------------------------*
  */
 $wp_customize->add_section('primary_colors', array(
     'title'    => __('Primary Class', 'acf_theme'),
     'priority' => 1,
     'panel' => 'button_options',

 ));

 /**
  *-------------------- Background Colors -----------------------------*
  */
 $wp_customize->add_setting('button_bg_color', array(
     'default' => ''
 ));
 $wp_customize->add_control(
     new WP_Customize_Color_Control(
         $wp_customize,
         'button_bg_color',
         array(
             'label'      => __( 'Background Color', 'acf_theme' ),
             'section'    => 'primary_colors',
             'settings'   => 'button_bg_color'
         )
     )
 );

 /**
  *-------------------- Text Colors -----------------------------*
  */
 $wp_customize->add_setting('button_txt_color', array(
     'default' => ''
 ));
 $wp_customize->add_control(
     new WP_Customize_Color_Control(
         $wp_customize,
         'button_txt_color',
         array(
             'label'      => __( 'Text Color', 'acf_theme' ),
             'section'    => 'primary_colors',
             'settings'   => 'button_txt_color'
         )
     )
 );

 /**
  *-------------------- Background Hover Colors -----------------------------*
  */
 $wp_customize->add_setting('button_bg_hover', array(
     'default' => ''
 ));
 $wp_customize->add_control(
     new WP_Customize_Color_Control(
         $wp_customize,
         'button_bg_hover',
         array(
             'label'      => __( 'Background Hover Color', 'acf_theme' ),
             'section'    => 'primary_colors',
             'settings'   => 'button_bg_hover'
         )
     )
 );

 /**
  *-------------------- Text Hover Colors -----------------------------*
  */
 $wp_customize->add_setting('button_txt_hover', array(
     'default' => ''
 ));
 $wp_customize->add_control(
     new WP_Customize_Color_Control(
         $wp_customize,
         'button_txt_hover',
         array(
             'label'      => __( 'Text Hover Color', 'acf_theme' ),
             'section'    => 'primary_colors',
             'settings'   => 'button_txt_hover'
         )
     )
 );

 /**
  *-------------------- Button Border Color -----------------------------*
  */
 $wp_customize->add_setting('button_border_color', array(
     'default' => ''
 ));
 $wp_customize->add_control(
     new WP_Customize_Color_Control(
         $wp_customize,
         'button_border_color',
         array(
             'label'      => __( 'Button Border Color', 'acf_theme' ),
             'section'    => 'primary_colors',
             'settings'   => 'button_border_color'
         )
     )
 );

 /**
  *-------------------- Font Size -----------------------------*
  */
 $wp_customize->add_setting('primary_font_size', array(
     'default'        => '20px',
 ));

 $wp_customize->add_control('primary_font_size', array(
     'label'      => __('Font Size', 'font_size'),
     'description'=> __('Include unit of measurement example: px, rem, em, %'),
     'section'    => 'primary_colors',
     'settings'   => 'primary_font_size',
 ));

 /**
  *-------------------- Button Size -----------------------------*
  */
 $wp_customize->add_setting( 'primary_button_size', array(
         'default'    => '.75rem 1.5rem',
         'type'       => 'theme_mod',
     )
 );
 $wp_customize->add_control('primary_button_size', array(
     'label'      => __('Button Padding', 'button_size'),
     'description'=> __('Example: Padding: 10px 5px 10px 5px;
                            Include: px, rem, em, %'),
     'section'    => 'primary_colors',
     'settings'   => 'primary_button_size',
 ));

 /**
  *-------------------- Button Spacing -----------------------------*
  */
 $wp_customize->add_setting( 'primary_button_spacing', array(
         'default'    => '1.5rem',
         'type'       => 'theme_mod',
     )
 );
 $wp_customize->add_control('primary_button_spacing', array(
     'label'      => __('Button Margin', 'button_size'),
     'description'=> __('Example: Margin: 10px 5px 10px 5px;
                            Include: px, rem, em, %'),
     'section'    => 'primary_colors',
     'settings'   => 'primary_button_spacing',
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

 $wp_customize->add_setting( 'primary_font_family',
     array(
         'default'    => 'default',
         'type'       => 'theme_mod',
         'capability' => 'edit_theme_options',
         //'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
     )
 );
 $wp_customize->add_control( new WP_Customize_Control(
     $wp_customize,
     'primary_font_family',
     array(
         'label'      => __( 'Button Font Family', 'font_family' ),
         'description'=> __('<a href="https://fonts.google.com/" target="_blank">View Google Fonts</a> to pick the style you need.'),
         'settings'   => 'primary_font_family',
         'priority'   => 10,
         'section'    => 'primary_colors',
         'type'    => 'select',
         'choices' => $fonts,
     )
 ) );
