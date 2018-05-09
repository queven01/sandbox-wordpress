<?php
/**
 * Template for the inventory page.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


$the_query = get_the_query();
$page_args = get_template_arguments();


// Get our pagination links for the current context
$paginate = array(
'base'               => add_query_arg( 'page_num', '%#%' ),
'format'             => '?page_num=%#%',
'total'              => $the_query->max_num_pages,
'current'            => get_request_var( 'page_num', 1 ),
'end_size'           => 1,
'mid_size'           => 2,
'prev_next'          => true,
'prev_text'          => __( 'Previous', 'cdemo' ),
'next_text'          => __( 'Next', 'cdemo' ),
'type'               => 'array'
);

$paginate = paginate_links( $paginate );
$category = $the_query->get( 'post_type' );


$args = array(
    'category'  => $category,
    'page_args' => $page_args,
    'the_query' => $the_query
);

?>


<?php get_header( $args ); ?>


<div class="container">

    <h1><?php the_title(); ?></h1>

    <div class="row">

        <?php $show_filters = sanitize_checkbox( $page_args['show_filters'] ); ?>

        <?php if ( $show_filters ) : ?>

            <input type="checkbox" id="cdemo-search-toggle" />

            <div class="visible-xs">

                <label id="cdemo-search-open" for="cdemo-search-toggle">
                    <span class="glyphicon glyphicon-search"></span>
                </label>

            </div>

            <div id="cdemo-search-form" class="col-sm-4">

                <div class="cdemo-search-form">

                    <p class="hidden-xs text-uppercase">
                        <?php _e( 'Search Inventory', 'cdemo' ); ?>
                    </p>

                    <div class="visible-xs">

                        <div class="clearfix">

                            <p class="text-uppercase text-muted">

                                <label id="cdemo-search-close" for="cdemo-search-toggle">

                                    <span><?php _e( 'Search Inventory', 'cdemo' ); ?></span>

                                    <span class="pull-right">
                                        <span class="glyphicon-remove glyphicon"></span>
                                    </span>

                                </label>

                            </p>

                        </div>

                    </div>

                    <!-- search-box -->
                    <form id="cdemo-search-box" action="<?php echo esc_url( search_url() ); ?>">

                        <div class="form-group">

                            <div class="input-group">

                                <input name="keyword"
                                       value="<?php esc_attr_e( $the_query->get( 'keyword' ) ); ?>"
                                       class="form-control"
                                       placeholder="<?php _e( 'Search', 'cdemo' ); ?>" />

                                <div class="input-group-btn">

                                    <button class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>

                                </div>

                            </div>

                        </div>

                        <?php if ( is_listing( $category ) ) : // Remember the selected category ?>
                            <input type="hidden" name="vehicle_category" value="<?php esc_attr_e( $category ); ?>">
                        <?php endif; ?>

                    </form><!-- /search-box -->

                    <!-- advanced-search-form -->
                    <form id="cdemo-advanced-search-form" action="<?php echo esc_url( search_url() ); ?>">

                        <div class="form-group">

                            <div class="form-field">

                             <span id="category-label-wrap">

                                 <label class="label" for="vehicle-category">
                                     <?php _e( 'Category', 'cdemo' ); ?>
                                 </label>

                             </span>

                                <select data-selectize
                                        name="vehicle_category"
                                        id="vehicle-category">

                                    <option value="all"><?php _e( 'All Inventory', 'cdemo' ); ?></option>

                                    <?php foreach ( get_listing_post_type_objects() as $type ) : ?>

                                        <option value="<?php esc_attr_e( $type->name ); ?>"
                                            <?php selected( $type->name, is_listing( $category ) ? $category : '' ); ?>>
                                            <?php esc_html_e( $type->labels->name ); ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>

                        <?php render_ui_search_fields( is_string( $category ) ? $category : 'global', $the_query ); ?>

                        <div class="form-group">

                            <button type="submit" class="search-submit btn btn-primary">
                                <?php _e( 'Search', 'cdemo' ); ?>
                            </button>

                        </div>

                    </form><!-- /advanced-search-form -->

                </div>

            </div>

        <?php endif; ?>

        <div id="cdemo-search-results" class="<?php echo $show_filters ? 'col-sm-8' : 'col-sm-12'; ?>">

            <div class="cdemo-search-results">

                <?php if ( $the_query->have_posts() ) : ?>

                    <div>

                        <?php if ( sanitize_checkbox( $page_args['show_sort'] ) ) : ?>

                            <div id="cdemo-search-view-controls">
                                <?php get_template( 'search-view-controls' ); ?>
                            </div>

                        <?php endif; ?>

                        <div class="found-posts text-muted">
                            <?php echo sprintf( __( '%d results found', 'cdemo' ), $the_query->found_posts ); ?>
                        </div>

                        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                            <?php get_template( 'search-result', null, true, false ); ?>
                           
                            <?php wp_reset_postdata(); ?>

                        <?php endwhile; ?>

                        <?php if ( !empty( $paginate ) ) : ?>

                            <ul class="pagination pull-right">
                                <?php print_list( $paginate, '<li>', '</li>' ); ?>
                            </ul>

                            <div class="clearfix"></div>

                        <?php endif; ?>

                    </div>

                <?php else: ?>

                    <div class="no-results-msg">
                        <p class="text-center"><?php _e( 'Oops we weren\'t able to find what you were looking for', 'cdemo' ); ?></p>
                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>
</div>

<?php get_footer( $args ); ?>
