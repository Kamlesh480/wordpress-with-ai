<?php
/**
 * Numbered pagination for a post listing (index, archive, category, author,
 * front page). Uses the global $wp_query unless a specific WP_Query and/or
 * current page number is passed in $args.
 *
 * @param array $args {
 *     @type WP_Query $query   Query to read max_num_pages from. Defaults to the global $wp_query.
 *     @type int      $current The current page number. Defaults to the request's own paging
 *                              (get_query_var('page') for a static front page, 'paged' otherwise —
 *                              see front-page.php for why those differ).
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$query = isset( $args['query'] ) ? $args['query'] : $GLOBALS['wp_query'];

if ( $query->max_num_pages <= 1 ) {
	return;
}

$current = isset( $args['current'] )
	? (int) $args['current']
	: max( (int) get_query_var( 'page' ), (int) get_query_var( 'paged' ), 1 );

$links = paginate_links(
	array(
		'total'     => $query->max_num_pages,
		'current'   => $current,
		'mid_size'  => 1,
		'prev_text' => '&laquo; ' . __( 'Previous', 'blog-hub' ),
		'next_text' => __( 'Next', 'blog-hub' ) . ' &raquo;',
	)
);

if ( ! $links ) {
	return;
}
?>
<nav class="bh-pagination" aria-label="<?php esc_attr_e( 'Posts pagination', 'blog-hub' ); ?>">
	<?php echo $links; // phpcs:ignore WordPress.Security.EscapeOutput -- paginate_links() output is already safe HTML. ?>
</nav>
