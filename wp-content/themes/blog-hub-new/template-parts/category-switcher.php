<?php
/**
 * A <select> dropdown for jumping to another category, shown alongside the
 * category archive header.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories    = get_categories(
	array(
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => true,
	)
);
$current       = get_queried_object();
$current_id    = ( $current instanceof WP_Term ) ? $current->term_id : 0;
$blog_page_id  = get_option( 'page_for_posts' );
$all_posts_url = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/' );

if ( empty( $categories ) ) {
	return;
}
?>
<label class="bh-category-switcher">
	<span class="bh-category-switcher__label"><?php esc_html_e( 'Category', 'blog-hub' ); ?></span>
	<select onchange="if(this.value) window.location.href=this.value">
		<option value="<?php echo esc_url( $all_posts_url ); ?>"><?php esc_html_e( 'All Posts', 'blog-hub' ); ?></option>
		<?php foreach ( $categories as $cat ) : ?>
			<option value="<?php echo esc_url( get_category_link( $cat ) ); ?>" <?php selected( $cat->term_id, $current_id ); ?>>
				<?php echo $cat->name; // phpcs:ignore WordPress.Security.EscapeOutput -- get_categories() names are pre-escaped for display. ?>
			</option>
		<?php endforeach; ?>
	</select>
</label>
