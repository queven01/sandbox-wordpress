<?php

namespace cdemo;

?>


<div class="row">
    <div class="col-xs-6">
        <div class="left per-page">

            <?php $per_page = get_request_var( 'limit' ); ?>

            <label class="label" for="limit"> <?php _e( 'Per page', 'cdemo' ); ?></label>
            
            <select name="limit" id="limit" class="form-control search-view-control" data-selectize>
                <option value="10"  <?php selected( 10,  $per_page ); ?>><?php _e( '10',  'cdemo' ); ?></option>
                <option value="25"  <?php selected( 25,  $per_page ); ?>><?php _e( '25',  'cdemo' ); ?></option>
                <option value="50"  <?php selected( 50,  $per_page ); ?>><?php _e( '50',  'cdemo' ); ?></option>
                <option value="100" <?php selected( 100, $per_page ); ?>><?php _e( '100', 'cdemo' ); ?></option>
            </select>

        </div>
    </div>
    <div class="col-xs-6">
        <div class="right per-page">
            
            <label class="label" for="sortby"> <?php _e( 'Sorting', 'cdemo' ); ?></label>
            
            <div class="pull-right">

                <?php $orderby = get_request_var( 'sortby' ); ?>

                <select name="sortby" class="form-control search-view-control" data-selectize>
                    <option value="date"  <?php selected( 'date',  $orderby ); ?>><?php _e( 'Date', 'cdemo' ); ?></option>
                    <option value="title" <?php selected( 'title', $orderby ); ?>><?php _e( 'A-Z',    'cdemo' ); ?></option>
                    <option value="price" <?php selected( 'price', $orderby ); ?>><?php _e( 'Price',  'cdemo' ); ?></option>
                </select>

                <span class="input-group-btn">

                    <?php $order = strtolower( get_request_var( 'sort', 'desc' ) ); ?>

                    <button name="sort"
                            value="<?php esc_attr_e( $order == 'desc' ? 'asc' : 'desc' ); ?>"
                            class="btn btn-default order search-view-control"
                            data-order-desc="asc"
                            data-order-asc="desc">

                        <span class="glyphicon <?php echo $order == 'desc' ? 'glyphicon-sort-by-attributes-alt' : 'glyphicon-sort-by-attributes'; ?>"
                              data-sort-asc="glyphicon glyphicon-sort-by-attributes"
                              data-sort-desc="glyphicon glyphicon-sort-by-attributes-alt"></span>

                    </button>

                </span>

            </div>
        </div>
	</div>

    <div class="clearfix"></div>
</div>
