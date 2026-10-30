<?php
/**
 * Real site homepage ("/"). Intended to replace a page-builder-built
 * homepage once Settings > Reading is switched to use it — see this
 * theme's `.serena/memories/project_overview.md` for the earlier
 * architecture note about NOT touching the live homepage until explicitly
 * told to switch over.
 *
 * Content sections pull from, in order: Customizer fields (hero, about
 * teaser, "why choose us", end CTA — short copy that rarely changes),
 * dedicated custom post types registered in inc/main-site.php (Products,
 * Applications, Client Logos, Testimonials — repeating content a content
 * editor adds/removes over time, same workflow as adding a blog post), and
 * real WP_Query data for the blog teaser (same pattern as the rest of this
 * theme — no separate "blog teaser" content to maintain by hand).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$hero_text        = get_theme_mod( 'blog_hub_home_hero_text', '' );
$hero_button_text = get_theme_mod( 'blog_hub_home_hero_button_text', '' );
$hero_button_url  = get_theme_mod( 'blog_hub_home_hero_button_url', '' );
$hero_image       = get_theme_mod( 'blog_hub_home_hero_image', '' );

$about_text = get_theme_mod( 'blog_hub_home_about_text', '' );

$cta_heading     = get_theme_mod( 'blog_hub_home_cta_heading', '' );
$cta_button_text = get_theme_mod( 'blog_hub_home_cta_button_text', '' );
$cta_button_url  = get_theme_mod( 'blog_hub_home_cta_button_url', '' );
$cta_image       = get_theme_mod( 'blog_hub_home_cta_image', '' );

$products = get_posts(
	array(
		'post_type'      => 'bh_product',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

$applications = get_posts(
	array(
		'post_type'      => 'bh_application',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

$client_logos = get_posts(
	array(
		'post_type'      => 'bh_client_logo',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

$testimonials = get_posts(
	array(
		'post_type'      => 'bh_testimonial',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

$reasons = blog_hub_get_reasons();

$blog_posts = get_posts(
	array(
		'posts_per_page'      => 4,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	)
);
?>

<section class="bh-ms-hero">
	<?php if ( $hero_image ) : ?>
		<img class="bh-ms-hero__bg" src="<?php echo esc_url( $hero_image ); ?>" alt="" aria-hidden="true">
	<?php endif; ?>
	<div class="bh-ms-hero__overlay" aria-hidden="true"></div>
	<div class="bh-ms-hero__inner">
		<?php if ( $hero_text ) : ?>
			<h1 class="bh-ms-hero__title"><?php echo wp_kses_post( nl2br( esc_html( $hero_text ) ) ); ?></h1>
			<span class="bh-ms-rule" aria-hidden="true"></span>
		<?php endif; ?>
		<?php if ( $hero_button_text && $hero_button_url ) : ?>
			<a class="bh-ms-hero__btn" href="<?php echo esc_url( $hero_button_url ); ?>"><?php echo esc_html( $hero_button_text ); ?></a>
		<?php endif; ?>
	</div>
</section>

<?php if ( ! empty( $products ) ) : ?>
	<section class="bh-ms-section">
		<div class="bh-ms-head">
			<span class="bh-ms-eyebrow"><?php esc_html_e( 'See Our Work', 'blog-hub' ); ?></span>
			<h2 class="bh-ms-heading"><?php esc_html_e( 'Our Products', 'blog-hub' ); ?></h2>
			<span class="bh-ms-rule" aria-hidden="true"></span>
		</div>
		<div class="bh-ms-products">
			<?php foreach ( $products as $product ) : ?>
				<?php $link = get_post_meta( $product->ID, 'blog_hub_product_link', true ); ?>
				<div class="bh-ms-product">
					<a class="bh-ms-product__media<?php echo has_post_thumbnail( $product ) ? '' : ' bh-ms-product__media--empty'; ?>" href="<?php echo $link ? esc_url( $link ) : '#'; ?>">
						<?php if ( has_post_thumbnail( $product ) ) : ?>
							<?php echo get_the_post_thumbnail( $product, 'medium' ); ?>
						<?php else : ?>
							<i class="fa-regular fa-image" aria-hidden="true"></i>
						<?php endif; ?>
					</a>
					<h3 class="bh-ms-product__title">
						<a href="<?php echo $link ? esc_url( $link ) : '#'; ?>"><?php echo esc_html( get_the_title( $product ) ); ?></a>
					</h3>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( $about_text || has_post_thumbnail() ) : ?>
	<section class="bh-ms-about">
		<div class="bh-ms-about__inner">
			<?php
			$gallery_ids = array();
			if ( function_exists( 'get_theme_mod' ) ) {
				for ( $i = 1; $i <= 4; $i++ ) {
					$img = get_theme_mod( "blog_hub_home_about_image_{$i}", '' );
					if ( $img ) {
						$gallery_ids[] = $img;
					}
				}
			}
			?>
			<?php if ( ! empty( $gallery_ids ) ) : ?>
				<div class="bh-ms-about__gallery">
					<?php foreach ( $gallery_ids as $img_url ) : ?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="">
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="bh-ms-about__copy">
				<span class="bh-ms-eyebrow"><?php esc_html_e( 'Get to Know Us', 'blog-hub' ); ?></span>
				<h2 class="bh-ms-heading bh-ms-heading--on-dark"><?php esc_html_e( 'About Us', 'blog-hub' ); ?></h2>
				<span class="bh-ms-rule" aria-hidden="true"></span>
				<?php if ( $about_text ) : ?>
					<p><?php echo wp_kses_post( $about_text ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $applications ) || ! empty( $reasons ) ) : ?>
	<section class="bh-ms-applications">
		<?php if ( ! empty( $applications ) ) : ?>
			<div class="bh-ms-head">
				<h2 class="bh-ms-heading" style="font-size:18px;"><?php esc_html_e( 'Applications', 'blog-hub' ); ?></h2>
				<span class="bh-ms-rule" aria-hidden="true"></span>
			</div>
			<div class="bh-ms-applications__grid">
				<?php foreach ( $applications as $application ) : ?>
					<div class="bh-ms-flip" tabindex="0" aria-label="<?php echo esc_attr( get_the_title( $application ) ); ?>">
						<div class="bh-ms-flip__inner">
							<div class="bh-ms-flip__face bh-ms-flip__front">
								<?php if ( has_post_thumbnail( $application ) ) : ?>
									<?php echo get_the_post_thumbnail( $application, 'medium' ); ?>
								<?php endif; ?>
								<span><?php echo esc_html( get_the_title( $application ) ); ?></span>
							</div>
							<div class="bh-ms-flip__face bh-ms-flip__back">
								<p><?php echo esc_html( wp_strip_all_tags( $application->post_content ) ); ?></p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $reasons ) ) : ?>
			<div class="bh-ms-head" style="margin-top:40px;">
				<h2 class="bh-ms-heading" style="font-size:18px;"><?php esc_html_e( 'Why Choose Us?', 'blog-hub' ); ?></h2>
				<span class="bh-ms-rule" aria-hidden="true"></span>
			</div>
			<div class="bh-ms-reasons">
				<?php foreach ( $reasons as $reason ) : ?>
					<div class="bh-ms-reason">
						<i class="<?php echo esc_attr( $reason['icon'] ); ?>" aria-hidden="true"></i>
						<h3><?php echo esc_html( $reason['title'] ); ?></h3>
						<p><?php echo esc_html( $reason['text'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</section>
<?php endif; ?>

<?php if ( ! empty( $client_logos ) ) : ?>
	<section class="bh-ms-section">
		<h2 class="bh-ms-heading" style="text-align:center;"><?php esc_html_e( 'Our Clients', 'blog-hub' ); ?></h2>
		<div class="bh-ms-clients" data-blog-hub-clients data-visible-count="5">
			<button type="button" class="bh-ms-clients__nav" aria-label="<?php esc_attr_e( 'Previous clients', 'blog-hub' ); ?>" data-clients-prev>
				<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
			</button>
			<div class="bh-ms-clients__track" data-clients-track>
				<?php foreach ( $client_logos as $client ) : ?>
					<div class="bh-ms-clients__logo">
						<?php if ( has_post_thumbnail( $client ) ) : ?>
							<?php echo get_the_post_thumbnail( $client, 'medium', array( 'alt' => get_the_title( $client ) ) ); ?>
						<?php else : ?>
							<span class="bh-ms-clients__logo-placeholder"><?php echo esc_html( get_the_title( $client ) ); ?></span>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<button type="button" class="bh-ms-clients__nav" aria-label="<?php esc_attr_e( 'Next clients', 'blog-hub' ); ?>" data-clients-next>
				<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
			</button>
		</div>
		<div class="bh-ms-clients__dots" data-clients-dots aria-hidden="true">
			<?php foreach ( $client_logos as $i => $client ) : ?>
				<span></span>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $blog_posts ) ) : ?>
	<section class="bh-ms-blog-teaser">
		<h2 class="bh-ms-heading" style="text-align:center;"><?php esc_html_e( 'Blogs', 'blog-hub' ); ?></h2>
		<div class="bh-ms-blog-teaser__grid">
			<?php foreach ( $blog_posts as $blog_post ) : ?>
				<article class="bh-ms-blog-card">
					<a href="<?php echo esc_url( get_permalink( $blog_post ) ); ?>">
						<?php if ( has_post_thumbnail( $blog_post ) ) : ?>
							<?php echo get_the_post_thumbnail( $blog_post, 'medium' ); ?>
						<?php endif; ?>
					</a>
					<div class="bh-ms-blog-card__body">
						<h3 class="bh-ms-blog-card__title">
							<a href="<?php echo esc_url( get_permalink( $blog_post ) ); ?>"><?php echo esc_html( get_the_title( $blog_post ) ); ?></a>
						</h3>
						<p class="bh-ms-blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $blog_post ), 14 ) ); ?></p>
						<a href="<?php echo esc_url( get_permalink( $blog_post ) ); ?>" style="font-size:11px;color:#5047ae;"><?php esc_html_e( 'Read More', 'blog-hub' ); ?></a>
						<div class="bh-ms-blog-card__meta">
							<?php echo get_avatar( $blog_post->post_author, 28 ); ?>
							<span style="display:grid;line-height:1.5;">
								<span style="font-size:12px;color:var(--gold-500);"><?php echo esc_html( get_the_author_meta( 'display_name', $blog_post->post_author ) ); ?></span>
								<span style="font-size:12px;"><?php echo esc_html( get_the_date( '', $blog_post ) ); ?></span>
							</span>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $testimonials ) ) : ?>
	<section class="bh-ms-section">
		<div class="bh-ms-head">
			<span class="bh-ms-eyebrow"><?php esc_html_e( 'Our Testimonials', 'blog-hub' ); ?></span>
			<h2 class="bh-ms-heading"><?php esc_html_e( 'What People Say', 'blog-hub' ); ?></h2>
		</div>
		<div class="bh-ms-testimonials__grid">
			<?php foreach ( $testimonials as $testimonial ) : ?>
				<?php
				$location = get_post_meta( $testimonial->ID, 'blog_hub_testimonial_location', true );
				$rating   = (int) get_post_meta( $testimonial->ID, 'blog_hub_testimonial_rating', true );
				if ( ! $rating ) {
					$rating = 5;
				}
				?>
				<div class="bh-ms-testimonial">
					<span class="bh-ms-testimonial__stars" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: star rating out of 5 */ __( '%d out of 5 stars', 'blog-hub' ), $rating ) ); ?>">
						<?php echo esc_html( str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ) ); ?>
					</span>
					<p class="bh-ms-testimonial__text"><?php echo esc_html( wp_strip_all_tags( $testimonial->post_content ) ); ?></p>
					<div class="bh-ms-testimonial__person">
						<?php if ( has_post_thumbnail( $testimonial ) ) : ?>
							<?php echo get_the_post_thumbnail( $testimonial, 'thumbnail' ); ?>
						<?php endif; ?>
						<span>
							<strong><?php echo esc_html( get_the_title( $testimonial ) ); ?></strong>
							<?php if ( $location ) : ?>
								<span><?php echo esc_html( $location ); ?></span>
							<?php endif; ?>
						</span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( $cta_heading && $cta_button_text && $cta_button_url ) : ?>
	<section class="bh-ms-cta"<?php echo $cta_image ? ' style="background-image:url(' . esc_url( $cta_image ) . ')"' : ''; ?>>
		<div class="bh-ms-cta__overlay" aria-hidden="true"></div>
		<div class="bh-ms-cta__inner">
			<i class="fa-solid fa-file-signature" aria-hidden="true"></i>
			<h2 class="bh-ms-cta__heading"><?php echo esc_html( $cta_heading ); ?></h2>
			<a class="bh-ms-cta__btn" href="<?php echo esc_url( $cta_button_url ); ?>"><?php echo esc_html( $cta_button_text ); ?></a>
		</div>
	</section>
<?php endif; ?>

<?php get_footer(); ?>
