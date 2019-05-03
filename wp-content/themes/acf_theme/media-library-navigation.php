<?php
/**
 * Created by PhpStorm.
 * User: strathcom
 * Date: 2019-04-29
 * Time: 2:52 PM
 */
?>

<!--	<div class="row widget-area graphics-display">-->
<!--        --><?php //dynamic_sidebar( 'topbar-1' ); ?>
<!--	</div>-->

<nav class="media-library-navigation">
	<div class="row">
		<div class="col-md-3">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'media-library',
                'menu_id'        => 'media-library-nav',
            ));
            ?>
		</div>
		<div class="col-md-1">
			<form method="post">
				<input type="checkbox" name="checkedBox" value="1" onChange="this.form.submit()"
				       class="<?php if($condition == true) { echo 'classname'; } ?>" />
			</form>
            <?php
            switch($_POST['checkedBox']){
                case '1':
                    // do Something for Best seller
                    $operators_select = ",OR";
                    break;
                default:
                    // Something went wrong or form has been tampered.
                    $operators_select = ",AND";
            }
            ?>
			<h4>Searching as <?php echo $operators_select ?></h4>
		</div>
		<div class="col-md-8">
			<?php
                echo do_shortcode('[searchandfilter fields="search,wpdmcategory,post_tag" headings=",Categories,Tags" order_by="count" types=",checkbox,checkbox" operators='. $operators_select .' submit_label="Filter" show_count=",1,1" empty_search_url="/media-library/" class="media-library-search"]');
            ?>
			<a href="/media-library/" class="btn btn-primary" style="display: inline-block;">Reset</a>
		</div>
	</div>
</nav>



