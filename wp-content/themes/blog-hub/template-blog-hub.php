<?php
/**
 * Template Name: Blog Hub
 * Description: The blog landing page — hero, featured post, latest posts grid, categories, newsletter.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Featured post: the most recent "sticky" post, falling back to the latest post.
$featured_query = new WP_Query(
	array(
		'posts_per_page'      => 1,
		'post__in'             => get_option( 'sticky_posts' ),
		'ignore_sticky_posts'  => 1,
	)
);
if ( ! $featured_query->have_posts() ) {
	$featured_query = new WP_Query( array( 'posts_per_page' => 1 ) );
}
$featured_id = $featured_query->have_posts() ? $featured_query->posts[0]->ID : 0;

// Latest posts grid, excluding the featured post, paged.
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$latest_query = new WP_Query(
	array(
		'posts_per_page' => 18,
		'post__not_in'   => array( $featured_id ),
		'paged'          => $paged,
	)
);
?>

<nav class="bh-breadcrumb" aria-label="Breadcrumb">
	<div class="bh-container">
		<ol>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
			<li><span aria-hidden="true">/</span></li>
			<li aria-current="page">Blog</li>
		</ol>
	</div>
</nav>

<section class="bh-hero">
	<div class="bh-container">
		<span class="bh-hero__eyebrow">The Shubh Sanskar Blog</span>
		<h1 class="bh-hero__title">Concrete &amp; Construction<br>Insights</h1>
		<div class="bh-hero__rule"></div>
	</div>
</section>

<section class="bh-intro">
	<div class="bh-container">
		<p class="bh-intro__text">
			Since 2010 we have manufactured precast concrete products for municipal and private infrastructure across
			India. This blog shares what that time on the casting floor has taught us — grade selection for RCC hume
			pipes, manhole cover and chamber specification, cement pole installation and paver block laying practice.
			Browse the guides below, see the full range in <a href="<?php echo esc_url( home_url( '/products' ) ); ?>">our products</a>,
			read more <a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">about the company</a>, or
			<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">request a quote</a> for your next order.
		</p>
		<div class="bh-intro__categories">
			<a class="bh-btn-categories" href="#bh-categories">
				<i class="fa-solid fa-bars" aria-hidden="true"></i>
				Browse Categories
				<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</section>

<?php if ( $featured_id ) : ?>
<section class="bh-featured">
	<div class="bh-container">
		<span class="bh-featured__eyebrow">Featured Guide</span>
		<article class="bh-featured__card">
			<div class="bh-featured__media">
				<?php if ( has_post_thumbnail( $featured_id ) ) : ?>
					<?php echo get_the_post_thumbnail( $featured_id, 'large' ); ?>
				<?php else : ?>
					<i class="fa-regular fa-image" aria-hidden="true"></i>
					<span><?php echo esc_html( get_the_title( $featured_id ) ); ?> photograph</span>
				<?php endif; ?>
			</div>
			<div class="bh-featured__body">
				<?php
				$cats = get_the_category( $featured_id );
				if ( ! empty( $cats ) ) :
					?>
					<a class="bh-cat-tag" href="<?php echo esc_url( get_category_link( $cats[0] ) ); ?>"><?php echo strtoupper( $cats[0]->name ); // phpcs:ignore WordPress.Security.EscapeOutput -- get_the_category() names are pre-escaped for display. ?></a>
				<?php endif; ?>
				<h2 class="bh-featured__title"><a href="<?php echo esc_url( get_permalink( $featured_id ) ); ?>"><?php echo esc_html( get_the_title( $featured_id ) ); ?></a></h2>
				<p class="bh-featured__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $featured_id ), 28 ) ); ?></p>
				<div class="bh-meta">
					<span>By <a href="<?php echo esc_url( get_author_posts_url( get_post_field( 'post_author', $featured_id ) ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', get_post_field( 'post_author', $featured_id ) ) ); ?></a></span>
					<span class="bh-meta__sep">&middot;</span>
					<span><?php echo esc_html( get_the_date( 'M j, Y', $featured_id ) ); ?></span>
					<span class="bh-meta__sep">&middot;</span>
					<span><?php echo esc_html( blog_hub_reading_time( $featured_id ) ); ?> min read</span>
				</div>
				<div class="bh-featured__actions">
					<a class="bh-btn" href="<?php echo esc_url( get_permalink( $featured_id ) ); ?>">READ MORE</a>
					<div class="bh-share">
						<a href="https://wa.me/?text=<?php echo rawurlencode( get_the_title( $featured_id ) . ' ' . get_permalink( $featured_id ) ); ?>" aria-label="Share on WhatsApp"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
						<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( get_permalink( $featured_id ) ); ?>" aria-label="Share on LinkedIn"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a>
						<a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_permalink( $featured_id ) ); ?>" aria-label="Share on X"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
					</div>
				</div>
			</div>
		</article>
	</div>
</section>
<?php endif; ?>

<section class="bh-cta-strip">
	<div class="bh-container bh-cta-strip__inner">
		<div class="bh-cta-strip__text">
			<i class="fa-solid fa-truck-ramp-box" aria-hidden="true"></i>
			<span>Need pricing on RCC hume pipes, manhole covers or paver blocks?</span>
		</div>
		<a class="bh-btn" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">REQUEST A QUOTE</a>
	</div>
</section>

<section class="bh-latest-posts">
	<div class="bh-container">
		<div class="bh-section-head">
			<span class="bh-section-head__eyebrow">Fresh from the Casting Floor</span>
			<h2 class="bh-section-head__title">LATEST POSTS</h2>
			<div class="bh-section-head__rule"></div>
		</div>

		<?php if ( $latest_query->have_posts() ) : ?>
			<div class="bh-posts-grid">
				<?php
				while ( $latest_query->have_posts() ) :
					$latest_query->the_post();
					$post_id = get_the_ID();
					$cats    = get_the_category();
					?>
					<article class="bh-post-card">
						<div class="bh-post-card__media">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large' ); ?>
							<?php else : ?>
								<i class="fa-regular fa-image" aria-hidden="true"></i>
								<span><?php echo ! empty( $cats ) ? strtoupper( $cats[0]->name ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput -- get_the_category() names are pre-escaped for display. ?> photograph</span>
							<?php endif; ?>
						</div>
						<div class="bh-post-card__body">
							<?php if ( ! empty( $cats ) ) : ?>
								<a class="bh-cat-tag" href="<?php echo esc_url( get_category_link( $cats[0] ) ); ?>"><?php echo strtoupper( $cats[0]->name ); // phpcs:ignore WordPress.Security.EscapeOutput -- get_the_category() names are pre-escaped for display. ?></a>
							<?php endif; ?>
							<h3 class="bh-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="bh-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
							<div class="bh-meta">
								<span>By <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a></span>
								<span class="bh-meta__sep">&middot;</span>
								<span><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
								<span class="bh-meta__sep">&middot;</span>
								<span><?php echo esc_html( blog_hub_reading_time( $post_id ) ); ?> min read</span>
							</div>
							<a class="bh-post-card__more" href="<?php the_permalink(); ?>">
								Read full article <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php if ( $latest_query->max_num_pages > 1 ) : ?>
				<nav class="bh-pagination" aria-label="Posts pagination">
					<?php
					echo paginate_links(
						array(
							'total'   => $latest_query->max_num_pages,
							'current' => $paged,
							'mid_size'  => 1,
							'prev_text' => '&laquo;',
							'next_text' => '&raquo;',
						)
					);
					?>
				</nav>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<p style="text-align:center;color:var(--bh-muted);">No posts yet — publish your first guide to see it here.</p>
		<?php endif; ?>
	</div>
</section>

<section class="bh-categories" id="bh-categories">
	<div class="bh-container">
		<div class="bh-section-head">
			<span class="bh-section-head__eyebrow">Topics</span>
			<h2 class="bh-section-head__title">BROWSE BY CATEGORY</h2>
			<div class="bh-section-head__rule"></div>
		</div>

		<?php
		$categories = get_categories(
			array(
				'orderby' => 'count',
				'order'   => 'DESC',
				'hide_empty' => false,
			)
		);
		if ( ! empty( $categories ) ) :
			?>
			<div class="bh-category-list">
				<?php foreach ( $categories as $cat ) : ?>
					<a class="bh-category-card" href="<?php echo esc_url( get_category_link( $cat ) ); ?>">
						<i class="fa-solid fa-layer-group bh-category-card__icon" aria-hidden="true"></i>
						<span class="bh-category-card__body">
							<span class="bh-category-card__title"><?php echo esc_html( $cat->name ); ?></span>
							<?php if ( $cat->description ) : ?>
								<span class="bh-category-card__desc"><?php echo esc_html( $cat->description ); ?></span>
							<?php endif; ?>
						</span>
						<span class="bh-category-card__count">
							<?php echo esc_html( $cat->count ); ?> ARTICLES
							<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<section class="bh-newsletter">
	<div class="bh-container">
		<i class="fa-regular fa-envelope-open" aria-hidden="true"></i>
		<h2 class="bh-newsletter__title">GET NEW GUIDES IN YOUR INBOX</h2>
		<p class="bh-newsletter__desc">One email when we publish a new guide on precast concrete products. No spam, unsubscribe any time.</p>
		<form method="post" action="#">
			<label class="screen-reader-text" for="bh-newsletter-email">Email address</label>
			<input type="email" id="bh-newsletter-email" name="email" placeholder="you@example.com" required>
			<button type="submit" class="bh-btn">Subscribe</button>
		</form>
		<p class="bh-newsletter__disclaimer">By subscribing you agree to our <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>">privacy policy</a>.</p>
	</div>
</section>

<section class="bh-links-line">
	<div class="bh-container">
		<p>
			Ready to order? Explore <a href="<?php echo esc_url( home_url( '/products' ) ); ?>">our precast products</a>,
			learn <a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">about Shubh Sanskar Concrete</a>, or
			<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">contact our team</a> for a quote.
		</p>
	</div>
</section>

<?php get_footer(); ?>
