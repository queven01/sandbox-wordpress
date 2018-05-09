<?php
/**
 * Functions for handling field autocomplete functionality.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Get all values for a field. Allows meta fields to be narrowed down by searching within other linked meta field values.
 *
 * @global $wpdb
 *
 * @param string $field
 * @param string $types
 * @param array  $search
 * @param bool   $skip_empty
 * @param string $order
 *
 * @since 1.0.0
 * @return array
 */
function get_field_values( $field, $types = '', $search = array(), $skip_empty = false, $order = 'asc' ) {
    global $wpdb;

    $types = maybe_implode( wrap_quotes( esc_sql( $types ) ), ',' );
    $field = wrap_quotes( sanitize_key( $field ) );

    $sql   = "SELECT DISTINCT m.meta_value FROM $wpdb->postmeta m";
    $where = array(
        "( m.meta_key = $field AND p.post_type IN( $types )",
        " TRIM(m.meta_value) != '' "
    );

    $where[0] .= " AND m.meta_key = $field )";
    $joins = array(
        " INNER JOIN {$wpdb->posts} p ON m.post_id = p.ID "
    );

    if ( !empty( $search ) ) {
        $ctr = 1;

        foreach ( $search as $key => $value ) {

            // Skip empty fields if $skip_empty is true
            if ( empty( $value ) && $skip_empty ) {
                continue;
            }

            $value = maybe_implode( wrap_quotes( esc_sql( maybe_parse_list( $value ) ) ), ',' );
            $key   = wrap_quotes( sanitize_key( $key ) );

            // Re-alias and join the table back onto itself
            $joins[] = " INNER JOIN $wpdb->postmeta m$ctr ON m$ctr.post_id = p.ID ";
            // Add a WHERE AND clause
            $where[] = "( m$ctr.meta_key = $key AND m$ctr.meta_value IN( $value ) )";
            // Increment our table alias counter
            $ctr++;
        }
    }

    $sql .= implode( ' ', $joins ) . "WHERE " . implode( ' AND ', $where );
    $sql .= " ORDER BY m.meta_value " . ( strtolower( $order ) === 'asc' ? 'ASC' : 'DESC' );

    return $wpdb->get_col( $sql );
}

