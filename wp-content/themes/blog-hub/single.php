<?php
/**
 * Single blog post template.
 *
 * Layout source: design team's "Blog Article.dc.html" — header, hero image,
 * TL;DR box, two-column body (article + sticky TOC/CTA rail), author card,
 * back-to-top, end CTA, related articles.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$post_id     = get_the_ID();
	$author_id   = get_post_field( 'post_author', $post_id );
	$cats        = get_the_category( $post_id );
	$primary_cat = ! empty( $cats ) ? $cats[0] : null;
	$reading_min = blog_hub_reading_time( $post_id );
	$permalink   = get_permalink( $post_id );

	$toc = blog_hub_toc_from_content( get_the_content() );
	?>

	<nav class="bh-breadcrumb" aria-label="Breadcrumb">
		<div class="bh-container">
			<ol>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
				<li><span aria-hidden="true">/</span></li>
				<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog</a></li>
				<?php if ( $primary_cat ) : ?>
					<li><span aria-hidden="true">/</span></li>
					<li><a href="<?php echo esc_url( get_category_link( $primary_cat ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a></li>
				<?php endif; ?>
				<li><span aria-hidden="true">/</span></li>
				<li aria-current="page"><?php the_title(); ?></li>
			</ol>
		</div>
	</nav>

	<article>

		<header class="bh-article-header">
			<div class="bh-article-header__inner">
				<?php if ( $primary_cat ) : ?>
					<a class="bh-cat-tag" href="<?php echo esc_url( get_category_link( $primary_cat ) ); ?>"><?php echo esc_html( strtoupper( $primary_cat->name ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- pre-escaped by get_the_category(). ?></a>
				<?php endif; ?>
				<h1 class="bh-article-header__title"><?php echo esc_html( strtoupper( get_the_title() ) ); ?></h1>
				<div class="bh-article-byline">
					<?php echo get_avatar( $author_id, 44, '', '', array( 'class' => 'bh-avatar' ) ); ?>
					<div>
						<span class="bh-article-byline__name">By <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php the_author(); ?></a></span>
						<span class="bh-article-byline__meta">
							Published <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></time>
							<?php if ( get_the_modified_date( 'c' ) !== get_the_date( 'c' ) ) : ?>
								&middot; Updated <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date( 'M j, Y' ) ); ?></time>
							<?php endif; ?>
							&middot; <?php echo esc_html( $reading_min ); ?> min read
						</span>
					</div>
					<div class="bh-share bh-share--article">
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( $permalink ); ?>" aria-label="Share on Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
						<a href="https://wa.me/?text=<?php echo rawurlencode( get_the_title() . ' ' . $permalink ); ?>" aria-label="Share on WhatsApp"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
						<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( $permalink ); ?>" aria-label="Share on LinkedIn"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a>
						<a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( $permalink ); ?>" aria-label="Share on X"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
					</div>
				</div>
			</div>
		</header>

		<div class="bh-container">
			<div class="bh-article-hero">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large' ); ?>
				<?php else : ?>
					<i class="fa-regular fa-image" aria-hidden="true"></i>
					<span><?php the_title(); ?>, hero photograph</span>
				<?php endif; ?>
			</div>
		</div>

		<?php
		$excerpt = get_the_excerpt();
		if ( $excerpt ) :
			?>
			<div class="bh-article-tldr-wrap">
				<div class="bh-article-tldr">
					<span class="bh-article-tldr__label">TL;DR</span>
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
							<nav class="bh-toc" aria-label="Table of contents">
								<span class="bh-toc__label">Table of Contents</span>
								<ul>
									<?php foreach ( $toc['items'] as $item ) : ?>
										<li><a href="#<?php echo esc_attr( $item['id'] ); ?>" data-toc-target="<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
									<?php endforeach; ?>
								</ul>
							</nav>
						<?php endif; ?>

						<div class="bh-rail-cta">
							<span class="bh-rail-cta__label">Need a Quote?</span>
							<p>Send us your product, grade and quantity for a price and delivery date.</p>
							<a class="bh-btn bh-btn--small" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">REQUEST A QUOTE</a>
						</div>
					</aside>

				</div>

				<div class="bh-author-card">
					<?php echo get_avatar( $author_id, 64, '', '', array( 'class' => 'bh-avatar bh-avatar--lg' ) ); ?>
					<div class="bh-author-card__body">
						<span class="bh-author-card__name">
							<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php the_author(); ?></a>
							<i class="fa-solid fa-circle-check" aria-hidden="true" title="Verified author"></i>
						</span>
						<?php $bio_line = blog_hub_author_bio_line( $author_id ); ?>
						<?php if ( $bio_line ) : ?>
							<span class="bh-author-card__title"><?php echo esc_html( $bio_line ); ?></span>
						<?php endif; ?>
						<?php $author_desc = get_the_author_meta( 'description', $author_id ); ?>
						<?php if ( $author_desc ) : ?>
							<p><?php echo esc_html( $author_desc ); ?></p>
						<?php endif; ?>
						<?php $tags = blog_hub_author_tags( $author_id ); ?>
						<?php if ( ! empty( $tags ) ) : ?>
							<div class="bh-author-card__tags">
								<?php foreach ( $tags as $tag ) : ?>
									<span class="bh-pill"><?php echo esc_html( $tag ); ?></span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
					<a class="bh-author-card__link" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">VIEW PROFILE &rarr;</a>
				</div>
			</div>
		</section>

		<button type="button" class="bh-back-to-top" aria-label="Back to top" data-blog-hub-back-to-top>
			<i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
		</button>

		<section class="bh-project-cta bh-project-cta--split">
			<div class="bh-container bh-project-cta__grid">
				<div class="bh-project-cta__media">Delivery photograph</div>
				<div class="bh-project-cta__copy">
					<h2 class="bh-project-cta__title" style="text-align:left;">READY TO ORDER YOUR NEXT RUN?</h2>
					<p class="bh-project-cta__desc" style="text-align:left;margin-left:0;">Tell us the product, grade and quantity you need — we will come back with a price and a delivery date.</p>
					<a class="bh-btn" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">REQUEST A QUOTE</a>
				</div>
			</div>
		</section>

		<?php
		$related = blog_hub_related_posts( $post_id, 3 );
		if ( ! empty( $related ) ) :
			?>
			<section class="bh-related">
				<div class="bh-container">
					<h2 class="bh-related__title">Related Articles</h2>
					<div class="bh-related__grid">
						<?php foreach ( $related as $related_post ) : ?>
							<?php $related_cats = get_the_category( $related_post->ID ); ?>
							<article class="bh-related-card">
								<div class="bh-related-card__media">
									<?php if ( has_post_thumbnail( $related_post->ID ) ) : ?>
										<?php echo get_the_post_thumbnail( $related_post->ID, 'medium_large' ); ?>
									<?php else : ?>
										<span><?php echo esc_html( get_the_title( $related_post->ID ) ); ?> photograph</span>
									<?php endif; ?>
								</div>
								<div class="bh-related-card__body">
									<?php if ( ! empty( $related_cats ) ) : ?>
										<a class="bh-cat-tag" href="<?php echo esc_url( get_category_link( $related_cats[0] ) ); ?>"><?php echo esc_html( strtoupper( $related_cats[0]->name ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- pre-escaped by get_the_category(). ?></a>
									<?php endif; ?>
									<h3><a href="<?php echo esc_url( get_permalink( $related_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $related_post->ID ) ); ?></a></h3>
									<span class="bh-related-card__author">By <a href="<?php echo esc_url( get_author_posts_url( $related_post->post_author ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', $related_post->post_author ) ); ?></a></span>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

	</article>

	<?php
endwhile;

get_footer();
