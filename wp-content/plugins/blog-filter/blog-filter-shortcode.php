<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_shortcode('AWL-BlogFilter', 'awl_blog_filter_shortcode');
function awl_blog_filter_shortcode($atts) {
	
	ob_start();
	//js
	wp_enqueue_script('jquery');
	wp_enqueue_script('imagesloaded');
	wp_enqueue_script('awl-bf-bootstrap-js', plugin_dir_url( __FILE__ ).'js/bootstrap.min.js', array('jquery'), '' , true);
	wp_enqueue_script('awl-bf-controls-js', plugin_dir_url( __FILE__ ).'js/controls.js', array('jquery'), '', false);
	
	// css
	wp_enqueue_style('awl-bootstrap-css', plugin_dir_url( __FILE__ ).'css/bootstrap.css');
	wp_enqueue_style( 'awl-font-awesome-4-min-css', plugin_dir_url( __FILE__ ).'css/font-awesome-4.min.css' );
	wp_enqueue_style('awl-filter-css', plugin_dir_url( __FILE__ ) .'css/blog-filter-output.css');
	wp_enqueue_style('awl-hover-css', plugin_dir_url( __FILE__ ) .'css/hover.css');
	
	if(isset($atts['blog_image'])) $blog_image = $atts['blog_image']; else $blog_image = "no";
	if(isset($atts['blog_image_hover_effect'])) $blog_image_hover_effect = $atts['blog_image_hover_effect']; else $blog_image_hover_effect = "none";
	if(isset($atts['blog_title'])) $blog_title = $atts['blog_title']; else $blog_title = "no";
	if(isset($atts['blog_title_color'])) $blog_title_color = $atts['blog_title_color']; else $blog_title_color = "#000";
	if(isset($atts['blog_desc'])) $blog_desc = $atts['blog_desc']; else $blog_desc = "no";
	if(isset($atts['blog_desc_words'])) $blog_desc_words = $atts['blog_desc_words']; else $blog_desc_words = "30";
	if(isset($atts['link_open_new_tab'])) $link_open_new_tab = $atts['link_open_new_tab']; else $link_open_new_tab = "";
	if(isset($atts['blog_read_more'])) $blog_read_more = $atts['blog_read_more']; else $blog_read_more = "no";
	if(isset($atts['blog_read_more_text'])) $blog_read_more_text = $atts['blog_read_more_text']; else $blog_read_more_text = "Read More";
	if(isset($atts['blog_date'])) $blog_date = $atts['blog_date']; else $blog_date = "no";
	if(isset($atts['blog_pagination'])) $blog_pagination = $atts['blog_pagination']; else $blog_pagination = "no";
	if(isset($atts['blog_buttons_color'])) $blog_buttons_color = $atts['blog_buttons_color']; else $blog_buttons_color = "#a4a6ac";
	if(isset($atts['blog_filters'])) $blog_filters = $atts['blog_filters']; else $blog_filters = "no";
	if(isset($atts['selected_categories'])) $selected_categories = $atts['selected_categories']; else $selected_categories = "";
	if(isset($atts['custom-css'])) $custom_css = $atts['custom-css']; else $custom_css = "";
	
	//color dark code
	list($r, $g, $b) = sscanf("#EDEEF0", "#%02x%02x%02x");
	$r = $r - 24;
	$g = $g - 22;
	$b = $b - 19;
?>
	
	<style>
	
	<?php
	echo $custom_css;
	?>
	
	#bf_gallery_1 .portfolio_thumbnail {
		border-radius: 0;
		display: block;
		height: auto;
		line-height: 1.42857;
		width: 100%;
		float: left;
	}

	/* thumb spacing */
	
	#bf_gallery_1 .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
		padding-right: 5px !important;
		padding-left: 5px !important;
		padding-bottom: 5px !important;
		padding-top: 5px !important;
	}
	
	/* title box css*/

	.bf_thumb_box_1 {
		padding: inherit;
		background-color: #EDEEF0;
		border: 1px solid;
		border-color: rgba( <?php echo $r; ?>, <?php echo $g; ?>, <?php echo $b; ?> );
		/* border-color: #d5d8dd; */
	}
	
	.bf_title_box_1 {
		padding-top: 5px;
		padding-bottom: 10px;
		padding-left: 8px;
		padding-right: 8px;
	}
	.bf_title_box_2 {
		padding-top: 10px;
		padding-bottom: 10px;
		padding-left: 8px;
		padding-right: 8px;
	}
	.bf_title_1 {
		margin-top: 15px;
		margin-bottom: 15px;
		font-size: 25px;
		color : <?php echo $blog_title_color; ?>;
		font-weight: bold;
	}
	.bf_desc_1 {
		font-size: 14px;
		color: #a4a6ac;
		margin:10px 1px;
	}

	.bf_read_more_div_1 {
		text-align: right;
		margin:20px 0px 5px 0px;
	}
	.bf_read_more_1 {
		text-decoration:none;
		
	} 
	.bf_read_more_1:hover {
		text-decoration:none;
		
	}
	
	.snip0047 {
		background-color: <?php echo $blog_buttons_color; ?> !important;
	}
	
	.snip0047:focus {
		background-color: <?php echo $blog_buttons_color; ?> !important;
	}
	.snip0047:active {
		background-color: <?php echo $blog_buttons_color; ?> !important;
	}
	
	/* hover 1*/
	.simplefilter {
	  font-family: 'Raleway', Arial, sans-serif;
	  text-align: center;
	  text-transform: uppercase;
	  font-weight: 500;
	  letter-spacing: 1px;
	  padding: 0;
	  margin-top:20px;
	  margin-bottom:20px;
	}
	
	.metaInfo {
		margin-top: 10px;
		margin-bottom: 10px;
		padding: 0;
		font-size: 14px;
		font-weight: 600;
		display:inline-block;
	}
	
	.metaInfo > span {
		display: inline-block;
		margin-right: 6px;
		color: #777;
	}
	.metaInfo > span > i > .blog_cat_icon {
		height: 16px !important;
		width: 20px !important;
		opacity: 0.7;
		margin-bottom: 2px
	}
	.metaInfo > span > i > .blog_tag_icon {
		height: 22px !important;
		width: 22px !important;
		margin-bottom: 2px
		
	}
	
	.pagination {
		display: inline-block;
		padding-left: 0;
		margin: 20px 0;
		border-radius: 4px;
	}
	
	.pagination span { 
		background : <?php echo $blog_buttons_color; ?>;
		border: 1px solid #eaeaea;
		display: inline-block;
		text-align: center;
		color: #FFFFFF;
		padding: 4px 12px;
		border-radius:5px;
	}
	.pagination span:hover { 
		background : <?php echo $blog_buttons_color; ?>; 
		color : #ffffff; 
	}
	
	.pagination a {
		border: 1px solid <?php echo $blog_buttons_color; ?>;
		display: inline-block;
		text-align: center;
		color: <?php echo $blog_buttons_color; ?>;
		padding: 4px 12px;
		border-radius:5px;
	}
	
	.pagination a:hover, a:focus {
		background: <?php echo $blog_buttons_color; ?>;
		color: #FFFFFF;
		text-decoration:none;
	}
	
	</style>
	<?php
	require_once('blog-filter-output.php');
	
	return ob_get_clean();
}
?>