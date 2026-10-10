<?php
/**
 * "Browse Categories" dropdown — a <details>/<summary> disclosure listing
 * "All Posts" plus every category, so visitors can jump straight to one
 * without a full page of category cards.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories = get_categories(
	array(
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => true,
	)
);

$blog_page_id = get_option( 'page_for_posts' );
$all_posts_url = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/' );
?>
<nav class="bh-category-dropdown-nav" aria-label="<?php esc_attr_e( 'Blog categories', 'blog-hub' ); ?>">
	<div class="bh-container">
		<details class="bh-category-dropdown">
			<summary>
				<i class="fa-solid fa-list" aria-hidden="true"></i>
				<span><?php esc_html_e( 'Browse Categories', 'blog-hub' ); ?></span>
				<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
			</summary>
			<ul>
				<li><a href="<?php echo esc_url( $all_posts_url ); ?>"><?php esc_html_e( 'All Posts', 'blog-hub' ); ?></a></li>
				<?php foreach ( $categories as $cat ) : ?>
					<li><a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo $cat->name; // phpcs:ignore WordPress.Security.EscapeOutput -- get_categories() names are pre-escaped for display. ?></a></li>
				<?php endforeach; ?>
			</ul>
		</details>
	</div>
</nav>
