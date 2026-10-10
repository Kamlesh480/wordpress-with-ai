<?php
/**
 * A grid of post cards from the current main query, with pagination.
 * Used by index.php, archive.php, category.php, author.php and front-page.php.
 *
 * @param array $args {
 *     @type WP_Query $query          Query to loop over. Defaults to the global $wp_query.
 *     @type string   $empty_message  Message shown when the query has no posts.
 *     @type bool     $show_count     Show a "Showing X–Y of Z" line above the grid. Default false.
 *     @type string   $heading        Optional heading shown above the grid, next to the count.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$query         = isset( $args['query'] ) ? $args['query'] : $GLOBALS['wp_query'];
$empty_message = isset( $args['empty_message'] ) ? $args['empty_message'] : __( 'No posts yet.', 'blog-hub' );
$show_count    = ! empty( $args['show_count'] );
$heading       = isset( $args['heading'] ) ? $args['heading'] : '';

if ( ! $query->have_posts() ) {
	?>
	<p class="bh-empty-message"><?php echo esc_html( $empty_message ); ?></p>
	<?php
	return;
}

if ( $show_count || $heading ) :
	$current_page = max( 1, (int) $query->get( 'paged' ) );
	$per_page     = max( 1, (int) $query->get( 'posts_per_page' ) );
	$total        = (int) $query->found_posts;
	$range_start  = ( ( $current_page - 1 ) * $per_page ) + 1;
	$range_end    = min( $total, $current_page * $per_page );
	?>
	<div class="bh-posts-grid__header">
		<?php if ( $heading ) : ?>
			<h2 class="bh-posts-grid__heading"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php if ( $show_count && $total > 0 ) : ?>
			<span class="bh-posts-grid__count">
				<?php
				/* translators: 1: first post number shown, 2: last post number shown, 3: total number of posts. */
				echo esc_html( sprintf( __( 'Showing %1$d–%2$d of %3$d articles', 'blog-hub' ), $range_start, $range_end, $total ) );
				?>
			</span>
		<?php endif; ?>
	</div>
<?php endif; ?>

<div class="bh-posts-grid">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		get_template_part( 'template-parts/content-card' );
	endwhile;
	?>
</div>

<?php get_template_part( 'template-parts/pagination', null, array( 'query' => $query ) ); ?>

<?php
wp_reset_postdata();
