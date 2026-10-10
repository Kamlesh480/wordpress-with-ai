<?php
/**
 * "Browse by Category" card list — every category with at least one post.
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

if ( empty( $categories ) ) {
	return;
}
?>
<section class="bh-categories" id="bh-categories">
	<div class="bh-container">
		<div class="bh-section-head">
			<span class="bh-section-head__eyebrow"><?php esc_html_e( 'Topics', 'blog-hub' ); ?></span>
			<h2 class="bh-section-head__title"><?php esc_html_e( 'Browse by Category', 'blog-hub' ); ?></h2>
			<div class="bh-section-head__rule"></div>
		</div>

		<div class="bh-category-list">
			<?php foreach ( $categories as $cat ) : ?>
				<a class="bh-category-card" href="<?php echo esc_url( get_category_link( $cat ) ); ?>">
					<i class="fa-solid fa-layer-group bh-category-card__icon" aria-hidden="true"></i>
					<span class="bh-category-card__body">
						<span class="bh-category-card__title"><?php echo $cat->name; // phpcs:ignore WordPress.Security.EscapeOutput -- get_categories() names are pre-escaped for display. ?></span>
						<?php if ( $cat->description ) : ?>
							<span class="bh-category-card__desc"><?php echo esc_html( $cat->description ); ?></span>
						<?php endif; ?>
					</span>
					<span class="bh-category-card__count">
						<?php
						/* translators: %d: number of articles in this category. */
						echo esc_html( sprintf( _n( '%d article', '%d articles', $cat->count, 'blog-hub' ), $cat->count ) );
						?>
						<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
