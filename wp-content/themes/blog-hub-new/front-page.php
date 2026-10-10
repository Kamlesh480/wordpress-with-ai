<?php
/**
 * Front page template — automatically used for the site's homepage when
 * "A static page" is selected under Settings > Reading, or by default for
 * the latest-posts homepage. Hero, featured post, latest posts grid,
 * categories, newsletter.
 *
 * All copy comes from the Customizer (Front Page Hero section) or site
 * identity, with sensible fallbacks — nothing here is hardcoded to a
 * specific business.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$hero_title   = get_theme_mod( 'blog_hub_hero_title', '' );
$hero_eyebrow = get_theme_mod( 'blog_hub_hero_eyebrow', '' );
$hero_intro   = get_theme_mod( 'blog_hub_hero_intro', '' );

// A static front page's own pagination ("/page/2/") is carried in the
// `page` query var, not `paged` — `paged` is reserved for whichever
// sub-loop a template queries manually, which is exactly what we do below.
// (See https://developer.wordpress.org/reference/functions/get_query_var/
// and WP_Query::parse_query() — `is_front_page() && is_paged()` is the
// documented way to detect this.)
$paged         = max( (int) get_query_var( 'page' ), (int) get_query_var( 'paged' ), 1 );
$is_first_page = ( 1 === $paged );

// Featured post (page 1 only): the most recent "sticky" post, falling back
// to the latest post.
$featured_id = 0;
if ( $is_first_page ) {
	$featured_query = new WP_Query(
		array(
			'posts_per_page'      => 1,
			'post__in'            => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1,
		)
	);
	if ( ! $featured_query->have_posts() ) {
		$featured_query = new WP_Query( array( 'posts_per_page' => 1 ) );
	}
	$featured_id = $featured_query->have_posts() ? $featured_query->posts[0]->ID : 0;
}

// Latest posts grid, excluding the featured post, paged.
$latest_query = new WP_Query(
	array(
		'posts_per_page' => 12,
		'post__not_in'   => array( $featured_id ),
		'paged'          => $paged,
	)
);
?>

<section class="bh-hero">
	<div class="bh-container">
		<?php if ( $hero_eyebrow ) : ?>
			<span class="bh-hero__eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></span>
		<?php endif; ?>
		<h1 class="bh-hero__title">
			<?php if ( $is_first_page ) : ?>
				<?php echo esc_html( $hero_title ? $hero_title : get_bloginfo( 'name' ) ); ?>
			<?php else : ?>
				<?php
				/* translators: %d: page number. */
				echo esc_html( sprintf( __( 'Blog — Page %d', 'blog-hub' ), $paged ) );
				?>
			<?php endif; ?>
		</h1>
		<div class="bh-hero__rule"></div>
	</div>
</section>

<?php if ( $is_first_page && $hero_intro ) : ?>
	<section class="bh-intro">
		<div class="bh-container">
			<div class="bh-intro__text"><?php echo wp_kses_post( wpautop( $hero_intro ) ); ?></div>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/category-dropdown' ); ?>

<?php if ( $featured_id ) : ?>
	<section class="bh-featured">
		<div class="bh-container">
			<span class="bh-featured__eyebrow"><?php esc_html_e( 'Featured', 'blog-hub' ); ?></span>
			<article class="bh-featured__card">
				<div class="bh-featured__media">
					<?php if ( has_post_thumbnail( $featured_id ) ) : ?>
						<?php echo get_the_post_thumbnail( $featured_id, 'large' ); ?>
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
						<span><?php esc_html_e( 'By', 'blog-hub' ); ?> <a href="<?php echo esc_url( get_author_posts_url( get_post_field( 'post_author', $featured_id ) ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', get_post_field( 'post_author', $featured_id ) ) ); ?></a></span>
						<span class="bh-meta__sep">&middot;</span>
						<span><?php echo esc_html( get_the_date( '', $featured_id ) ); ?></span>
						<span class="bh-meta__sep">&middot;</span>
						<span>
							<?php
							$reading_min = blog_hub_reading_time( $featured_id );
							/* translators: %d: estimated reading time in minutes. */
							echo esc_html( sprintf( _n( '%d min read', '%d min read', $reading_min, 'blog-hub' ), $reading_min ) );
							?>
						</span>
					</div>
					<div class="bh-featured__actions">
						<a class="bh-btn" href="<?php echo esc_url( get_permalink( $featured_id ) ); ?>"><?php esc_html_e( 'Read More', 'blog-hub' ); ?></a>
					</div>
				</div>
			</article>
		</div>
	</section>
<?php endif; ?>

<?php if ( $is_first_page ) : ?>
	<?php get_template_part( 'template-parts/cta-inline' ); ?>
<?php endif; ?>

<section class="bh-latest-posts">
	<div class="bh-container">
		<?php if ( $is_first_page ) : ?>
			<div class="bh-section-head">
				<h2 class="bh-section-head__title"><?php esc_html_e( 'Latest Posts', 'blog-hub' ); ?></h2>
				<div class="bh-section-head__rule"></div>
			</div>
		<?php endif; ?>

		<?php
		get_template_part(
			'template-parts/posts-grid',
			null,
			array(
				'query'         => $latest_query,
				'empty_message' => __( 'No posts yet — publish your first post to see it here.', 'blog-hub' ),
				'show_count'    => ! $is_first_page,
				'heading'       => $is_first_page ? '' : __( 'Older Posts', 'blog-hub' ),
			)
		);
		?>
	</div>
</section>

<?php get_template_part( 'template-parts/category-list' ); ?>

<?php get_template_part( 'template-parts/newsletter' ); ?>

<?php get_template_part( 'template-parts/cta-end' ); ?>

<?php get_footer(); ?>
