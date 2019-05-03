<?php
/**
 * ACF Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ACF_Theme
 */

if ( ! function_exists( 'acf_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function acf_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ACF Theme, use a find and replace
		 * to change 'acf_theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'acf_theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'acf_theme' ),
            'media-library' => esc_html__( 'Media Library Menu', 'acf_theme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'acf_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'acf_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function acf_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'acf_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'acf_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function acf_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'acf_theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'acf_theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

    register_sidebar( array(
        'name'          => esc_html__( 'Topbar', 'acf_theme' ),
        'id'            => 'topbar-1',
        'description'   => esc_html__( 'Add widgets here.', 'acf_theme' ),
        'before_widget' => '<div class="col-md-2"><section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section></div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'acf_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function acf_theme_scripts() {
	wp_enqueue_style( 'acf_theme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'acf_theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    wp_enqueue_script( 'graphics-menu-effects', get_template_directory_uri() . '/js/graphics-menu.js', array(), true );

	wp_enqueue_script( 'acf_theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'acf_theme_scripts' );


function acf_theme_customizer_css() { ?>
    <style type="text/css">
	    /*Button Settings*/
	    <?php
	        $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAIVfsLS5EQwq3AyOJiEX6LquZuW-rCPyk";
            $json = file_get_contents($url);
            $json_data = json_decode($json, true);
            $primary_font = get_theme_mod( 'primary_font_family' );
            $primaryfontFamily = $json_data[items][$primary_font][family];
            $primaryregularURL = $json_data[items][$primary_font][files][regular];

            $secondary_font = get_theme_mod( 'secondary_font_family' );
            $secondaryfontFamily = $json_data[items][$secondary_font][family];
            $secondaryregularURL = $json_data[items][$secondary_font][files][regular];

            $ghost_font = get_theme_mod( 'ghost_font_family' );
            $ghostfontFamily = $json_data[items][$ghost_font][family];
            $ghostregularURL = $json_data[items][$ghost_font][files][regular];

            $heading_one_font = get_theme_mod( 'heading_one_font_family' );
            $heading_one_fontFamily = $json_data[items][$heading_one_font][family];
            $heading_one_regularURL = $json_data[items][$heading_one_font][files][regular];

            $heading_two_font = get_theme_mod( 'heading_two_font_family' );
            $heading_two_fontFamily = $json_data[items][$heading_two_font][family];
            $heading_two_regularURL = $json_data[items][$heading_two_font][files][regular];

            $heading_three_font = get_theme_mod( 'heading_three_font_family' );
            $heading_three_fontFamily = $json_data[items][$heading_three_font][family];
            $heading_three_regularURL = $json_data[items][$heading_three_font][files][regular];

	     ?>
	    @font-face {
		    font-family: <?php echo $primaryfontFamily; ?>;
		    src: url(<?php echo $primaryregularURL; ?>);
	    }
	    @font-face {
		    font-family: <?php echo $secondaryfontFamily; ?>;
		    src: url(<?php echo $secondaryregularURL; ?>);
	    }
	    @font-face {
		    font-family: <?php echo $ghostfontFamily; ?>;
		    src: url(<?php echo $ghostregularURL; ?>);
	    }
	    @font-face {
		    font-family: <?php echo $heading_one_fontFamily; ?>;
		    src: url(<?php echo $heading_one_regularURL; ?>);
	    }
	    @font-face {
		    font-family: <?php echo $heading_two_fontFamily; ?>;
		    src: url(<?php echo $heading_two_regularURL; ?>);
	    }
	    @font-face {
		    font-family: <?php echo $heading_three_fontFamily; ?>;
		    src: url(<?php echo $heading_three_regularURL; ?>);
	    }
	    h1{
		    font-family: <?php echo $heading_one_fontFamily; ?>;
	        margin: <?php echo get_theme_mod( 'heading_one_margin' ); ?>;
		    font-size: <?php echo get_theme_mod( 'heading_one_size' ); ?>;
		    color: <?php echo get_theme_mod( 'heading_one_color' ); ?>;
	    }
	    h2{
		    font-family: <?php echo $heading_two_fontFamily; ?>;
		    margin: <?php echo get_theme_mod( 'heading_two_margin' ); ?>;
		    font-size: <?php echo get_theme_mod( 'heading_two_size' ); ?>;
		    color: <?php echo get_theme_mod( 'heading_two_color' ); ?>;
	    }
	    h3{
		    font-family: <?php echo $heading_three_fontFamily; ?>;
		    margin: <?php echo get_theme_mod( 'heading_three_margin' ); ?>;
		    font-size: <?php echo get_theme_mod( 'heading_three_size' ); ?>;
		    color: <?php echo get_theme_mod( 'heading_three_color' ); ?>;
	    }
        .btn-primary {
            background-color: <?php echo get_theme_mod( 'button_bg_color' ); ?>;
            color: <?php echo get_theme_mod( 'button_txt_color' ); ?>;
            border-color: <?php echo get_theme_mod( 'button_border_color' ); ?>;
	        font-size: <?php echo get_theme_mod( 'primary_font_size' ); ?>;
            padding: <?php echo get_theme_mod( 'primary_button_size' ); ?>;
            margin: <?php echo get_theme_mod( 'primary_button_spacing' ); ?>;
	        font-family: <?php echo $primaryfontFamily; ?>;}

        .btn-primary:hover {
            background-color: <?php echo get_theme_mod( 'button_bg_hover' ); ?>;
            color: <?php echo get_theme_mod( 'button_txt_hover' ); ?>;
            border-color: <?php echo get_theme_mod( 'button_border_color' ); ?>; }
        .btn-secondary {
	        background-color: <?php echo get_theme_mod( 'button_bg_color2' ); ?>;
	        color: <?php echo get_theme_mod( 'button_txt_color2' ); ?>;
	        border-color: <?php echo get_theme_mod( 'button_border_color2' ); ?>;
	        font-size: <?php echo get_theme_mod( 'secondary_font_size' ); ?>;
	        padding: <?php echo get_theme_mod( 'secondary_button_size' ); ?>;
	        margin: <?php echo get_theme_mod( 'secondary_button_spacing' ); ?>;
	        font-family: <?php echo $secondaryfontFamily; ?>;}
        .btn-secondary:hover {
	        background-color: <?php echo get_theme_mod( 'button_bg_hover2' ); ?>;
	        color: <?php echo get_theme_mod( 'button_txt_hover2' ); ?>;
	        border-color: <?php echo get_theme_mod( 'button_border_color2' ); ?>; }
        .btn-ghost {
	        background-color: <?php echo get_theme_mod( 'button_bg_color3' ); ?>;
	        color: <?php echo get_theme_mod( 'button_txt_color3' ); ?>;
	        border-color: <?php echo get_theme_mod( 'button_border_color3' ); ?>;
	        font-size: <?php echo get_theme_mod( 'ghost_font_size' ); ?>;
	        padding: <?php echo get_theme_mod( 'ghost_button_size' ); ?>;
	        margin: <?php echo get_theme_mod( 'ghost_button_spacing' ); ?>;
	        font-family: <?php echo $ghostfontFamily; ?>;}
        .btn-ghost:hover {
	        background-color: <?php echo get_theme_mod( 'button_bg_hover3' ); ?>;
	        color: <?php echo get_theme_mod( 'button_txt_hover3' ); ?>;
	        border-color: <?php echo get_theme_mod( 'button_border_color3' ); ?>; }
	    /*Header Views and Styles*/
	     .site-header .main-navigation a{
		     color: <?php echo get_theme_mod( 'header_text_color' ); ?>;
		     padding: 1.5rem 1rem;
		     border-bottom: 5px solid transparent;
	     }
	    .site-header .main-navigation a:hover{
		    border-bottom: 5px solid <?php echo get_theme_mod( 'header_text_color_hover' ); ?>;
		    color: <?php echo get_theme_mod( 'header_text_color_hover' ); ?>;
	    }
	    .header-three #primary-menu li a:hover{
		    background: #0000002e;
		    color: <?php echo get_theme_mod( 'header_text_color_hover' ); ?>;
		    text-decoration: none;
	    }
	    header.site-header{
		    background: <?php echo get_theme_mod( 'header_background' ); ?>;
	    }
	    .top-bar {
		    background:<?php echo get_theme_mod( 'top_bar_background' ); ?>;
	    }
	    #collapseExample {
		    position: absolute;
		    z-index: 9;
		    left: 0px;
		    right: 0px;
		    background-color: #0000008c;
	    }
    </style>
    <?php
}
add_action( 'wp_head', 'acf_theme_customizer_css' );


//function acf_load_google_font_options($field) {
//
//    $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAIVfsLS5EQwq3AyOJiEX6LquZuW-rCPyk";
//    $json = file_get_contents($url);
//    $json_data = json_decode($json, true);
//
//    $fonts = array(
//        ' ' => 'Default',
//    );
//
//    $itemsArray = $json_data[items];
//    foreach ($itemsArray as $key => $value) {
//        $font_select = $value["family"];
//        array_push($fonts, $font_select);
//    }
//
//    $field['choices'] = $fonts;
//    return $field;
//}
//add_filter('acf/load_field/name=font_family', 'acf_load_google_font_options');
/**
 * Button on Editor
 */

function include_media_button_js_file() {
    wp_enqueue_script('media_button', '/wp-content/themes/acf_theme/js/media_button.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_media', 'include_media_button_js_file');

function add_my_media_button() {
    echo '<a href="#" id="insert-my-media" class="button insert-my-media">Add my media</a>';
}
add_action('media_buttons', 'add_my_media_button');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.∂
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function cptui_register_my_cpts() {

    /**
     * Post Type: Website Slide.
     */

    $labels = array(
        "name" => __( "Website Slide", "acf_theme" ),
        "singular_name" => __( "Website Slides", "acf_theme" ),
    );

    $args = array(
        "label" => __( "Website Slide", "acf_theme" ),
        "labels" => $labels,
        "description" => "This has all the slides",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "website_slide", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail" ),
    );

    register_post_type( "website_slide", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );


class MyNewWidget extends WP_Widget {

    function __construct() {
        // Instantiate the parent object

        $widget_options = array(
            'classname' => 'example_widget',
            'description' => 'This is an Example Widget',
        );
        parent::__construct( 'example_widget', 'Example Widget', $widget_options );
    }

    function widget( $args, $instance ) {
        // Widget output

        $title = apply_filters( 'widget_title', $instance[ 'title' ] );
        $blog_title = get_bloginfo( 'name' );
        $tagline = get_bloginfo( 'description' );
        echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>

	    <p><strong>Site Name:</strong> <?php echo $blog_title ?></p>
	    <p><strong>Tagline:</strong> <?php echo $tagline ?></p>

        <?php echo $args['after_widget'];
    }

    function form( $instance ) {
        // Output admin widget options form
        $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
	    <p>
	    <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
	    <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
	    </p><?php
    }

    function update( $new_instance, $old_instance ) {
        // Save widget options
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        return $instance;

    }
}

function myplugin_register_widgets() {
    register_widget( 'MyNewWidget' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );


/**
 * Generate breadcrumbs
 * @author CodexWorld
 * @authorURL www.codexworld.com
 */
function get_breadcrumb() {
    echo '<a href="' . get_permalink( get_option('page_for_posts' )) . '" rel="nofollow">Media Library</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        the_category(' &bull; ');
        if (is_single()) {
            echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
            the_title();
        }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}