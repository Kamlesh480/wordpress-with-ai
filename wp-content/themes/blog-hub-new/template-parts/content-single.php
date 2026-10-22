<?php
/**
 * Single post content: header, hero image, TL;DR, two-column body with
 * sticky TOC rail, author card, related articles.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id     = get_the_ID();
$author_id   = get_post_field( 'post_author', $post_id );
$cats        = get_the_category( $post_id );
$primary_cat = ! empty( $cats ) ? $cats[0] : null;
$reading_min = blog_hub_reading_time( $post_id );
$permalink   = get_permalink( $post_id );

$toc = blog_hub_toc_from_content( get_the_content() );
?>

<article>

	<header class="bh-article-header">
		<div class="bh-article-header__inner">
			<?php if ( $primary_cat ) : ?>
				<a class="bh-cat-tag" href="<?php echo esc_url( get_category_link( $primary_cat ) ); ?>"><?php echo strtoupper( $primary_cat->name ); // phpcs:ignore WordPress.Security.EscapeOutput -- get_the_category() names are pre-escaped for display. ?></a>
			<?php endif; ?>
			<h1 class="bh-article-header__title"><?php the_title(); ?></h1>
			<div class="bh-article-byline">
				<?php echo get_avatar( $author_id, 44, '', '', array( 'class' => 'bh-avatar' ) ); ?>
				<div>
					<span class="bh-article-byline__name"><?php esc_html_e( 'By', 'blog-hub' ); ?> <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php the_author(); ?></a></span>
					<span class="bh-article-byline__meta">
						<?php esc_html_e( 'Published', 'blog-hub' ); ?> <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						<?php if ( get_the_modified_date( 'c' ) !== get_the_date( 'c' ) ) : ?>
							&middot; <?php esc_html_e( 'Updated', 'blog-hub' ); ?> <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date() ); ?></time>
						<?php endif; ?>
						&middot;
						<?php
						/* translators: %d: estimated reading time in minutes. */
						echo esc_html( sprintf( _n( '%d min read', '%d min read', $reading_min, 'blog-hub' ), $reading_min ) );
						?>
					</span>
				</div>
				<div class="bh-share bh-share--article">
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( $permalink ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on Facebook', 'blog-hub' ); ?>"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
					<a href="https://wa.me/?text=<?php echo rawurlencode( get_the_title() . ' ' . $permalink ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on WhatsApp', 'blog-hub' ); ?>"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
					<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( $permalink ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'blog-hub' ); ?>"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a>
					<a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( $permalink ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on X', 'blog-hub' ); ?>"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="bh-container">
			<div class="bh-article-hero">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php
	// A manually-written excerpt is used as-is; WordPress's auto-generated
	// fallback is plain-text-stripped and re-trimmed to a clean word count so
	// it reads as a short summary instead of a raw content fragment (which
	// can otherwise run table/list text together and end mid-sentence).
	$has_manual_excerpt = has_excerpt( $post_id );
	$excerpt            = $has_manual_excerpt
		? get_the_excerpt()
		: wp_trim_words( wp_strip_all_tags( strip_shortcodes( get_the_content() ) ), 32 );
	if ( $excerpt ) :
		?>
		<div class="bh-article-tldr-wrap">
			<div class="bh-article-tldr">
				<span class="bh-article-tldr__label"><?php esc_html_e( 'TL;DR', 'blog-hub' ); ?></span>
				<p><?php echo esc_html( $excerpt ); ?></p>
			</div>
		</div>
	<?php endif; ?>

	<section class="bh-article-body-section">
		<div class="bh-container">
			<div class="bh-article-layout">

				<div class="bh-article-content">
					<?php echo apply_filters( 'the_content', $toc['content'] ); // phpcs:ignore WordPress.Security.EscapeOutput -- the_content filter chain handles sanitization/escaping. ?>
				</div>

				<aside class="bh-article-rail" data-blog-hub-article-rail>
					<?php if ( ! empty( $toc['items'] ) ) : ?>
						<nav class="bh-toc" aria-label="<?php esc_attr_e( 'Table of contents', 'blog-hub' ); ?>">
							<span class="bh-toc__label"><?php esc_html_e( 'Table of Contents', 'blog-hub' ); ?></span>
							<ul>
								<?php foreach ( $toc['items'] as $item ) : ?>
									<li><a href="#<?php echo esc_attr( $item['id'] ); ?>" data-toc-target="<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</nav>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'single-rail' ) ) : ?>
						<?php dynamic_sidebar( 'single-rail' ); ?>
					<?php endif; ?>
				</aside>

			</div>

			<?php get_template_part( 'template-parts/author-card', null, array( 'author_id' => $author_id ) ); ?>
		</div>
	</section>

	<button type="button" class="bh-back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'blog-hub' ); ?>" data-blog-hub-back-to-top>
		<i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
	</button>

	<?php get_template_part( 'template-parts/cta-end' ); ?>

	<?php get_template_part( 'template-parts/related-posts', null, array( 'post_id' => $post_id ) ); ?>

</article>
