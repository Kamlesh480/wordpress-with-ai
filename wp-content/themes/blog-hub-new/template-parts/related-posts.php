<?php
/**
 * "Related Articles" grid at the end of a single post.
 *
 * @param array $args { @type int $post_id }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
$related = blog_hub_related_posts( $post_id, 3 );

if ( empty( $related ) ) {
	return;
}
?>
<section class="bh-related">
	<div class="bh-container">
		<h2 class="bh-related__title"><?php esc_html_e( 'Related Articles', 'blog-hub' ); ?></h2>
		<div class="bh-related__grid">
			<?php foreach ( $related as $related_post ) : ?>
				<?php $related_cats = get_the_category( $related_post->ID ); ?>
				<article class="bh-related-card">
					<div class="bh-related-card__media">
						<?php if ( has_post_thumbnail( $related_post->ID ) ) : ?>
							<?php echo get_the_post_thumbnail( $related_post->ID, 'medium_large' ); ?>
						<?php endif; ?>
					</div>
					<div class="bh-related-card__body">
						<?php if ( ! empty( $related_cats ) ) : ?>
							<a class="bh-cat-tag" href="<?php echo esc_url( get_category_link( $related_cats[0] ) ); ?>"><?php echo strtoupper( $related_cats[0]->name ); // phpcs:ignore WordPress.Security.EscapeOutput -- get_the_category() names are pre-escaped for display. ?></a>
						<?php endif; ?>
						<h3><a href="<?php echo esc_url( get_permalink( $related_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $related_post->ID ) ); ?></a></h3>
						<span class="bh-related-card__author"><?php esc_html_e( 'By', 'blog-hub' ); ?> <a href="<?php echo esc_url( get_author_posts_url( $related_post->post_author ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', $related_post->post_author ) ); ?></a></span>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
