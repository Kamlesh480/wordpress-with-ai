<?php
/**
 * One post card for a grid (blog index, category/archive listings).
 * Expects the loop to already be on the current post (the_post() called).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cats        = get_the_category();
$primary_cat = ! empty( $cats ) ? $cats[0] : null;
$reading_min = blog_hub_reading_time( get_the_ID() );
?>
<article <?php post_class( 'bh-post-card' ); ?>>
	<div class="bh-post-card__media">
		<a href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large' ); ?>
			<?php endif; ?>
		</a>
	</div>
	<div class="bh-post-card__body">
		<?php if ( $primary_cat ) : ?>
			<a class="bh-cat-tag" href="<?php echo esc_url( get_category_link( $primary_cat ) ); ?>"><?php echo strtoupper( $primary_cat->name ); // phpcs:ignore WordPress.Security.EscapeOutput -- get_the_category() names are pre-escaped for display. ?></a>
		<?php endif; ?>
		<h3 class="bh-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="bh-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
		<div class="bh-meta">
			<span><?php esc_html_e( 'By', 'blog-hub' ); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a></span>
			<span class="bh-meta__sep">&middot;</span>
			<span><?php echo esc_html( get_the_date() ); ?></span>
			<span class="bh-meta__sep">&middot;</span>
			<span>
				<?php
				/* translators: %d: estimated reading time in minutes. */
				echo esc_html( sprintf( _n( '%d min read', '%d min read', $reading_min, 'blog-hub' ), $reading_min ) );
				?>
			</span>
		</div>
		<a class="bh-post-card__more" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Read full article', 'blog-hub' ); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
		</a>
	</div>
</article>
