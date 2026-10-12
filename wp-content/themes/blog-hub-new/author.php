<?php
/**
 * Author archive — profile header with stats, a two-column bio with an
 * "at a glance" contact card, then a grid of their posts.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$author_id   = get_queried_object_id();
$author_name = get_the_author_meta( 'display_name', $author_id );
$bio         = blog_hub_author_bio( $author_id );
$title       = blog_hub_author_title( $author_id );
$quote       = blog_hub_author_quote( $author_id );
$linkedin    = blog_hub_author_linkedin( $author_id );
$expertise   = blog_hub_author_expertise( $author_id );
$highlights  = blog_hub_author_highlights( $author_id );
$cta_url     = blog_hub_author_cta_url( $author_id );
$website     = get_the_author_meta( 'user_url', $author_id );
$email       = get_the_author_meta( 'user_email', $author_id );
$phone       = get_theme_mod( 'blog_hub_contact_phone', '' );
$post_count  = count_user_posts( $author_id, 'post' );

global $wp_query;
?>

<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

<section class="bh-author-header">
	<div class="bh-container bh-author-header__grid">
		<?php echo get_avatar( $author_id, 200, '', '', array( 'class' => 'bh-author-header__avatar' ) ); ?>
		<div class="bh-author-header__copy">
			<span class="bh-page-header__eyebrow" style="text-align:left;"><?php esc_html_e( 'Author', 'blog-hub' ); ?></span>
			<h1 class="bh-author-header__name"><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></h1>
			<?php if ( $title ) : ?>
				<p class="bh-author-header__title"><?php echo esc_html( $title ); ?></p>
			<?php endif; ?>
			<?php if ( $linkedin ) : ?>
				<div class="bh-author-header__links">
					<a href="<?php echo esc_url( $linkedin ); ?>" aria-label="<?php
						/* translators: %s: author's display name. */
						echo esc_attr( sprintf( __( '%s on LinkedIn', 'blog-hub' ), get_the_author_meta( 'display_name', $author_id ) ) );
					?>"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a>
				</div>
			<?php endif; ?>
			<div class="bh-author-header__stats">
				<div>
					<span class="bh-author-header__stat-value"><?php echo esc_html( $post_count ); ?></span>
					<span class="bh-author-header__stat-label"><?php esc_html_e( 'Articles Published', 'blog-hub' ); ?></span>
				</div>
			</div>
		</div>
	</div>
</section>

<?php if ( $bio || $quote || ! empty( $expertise ) ) : ?>
	<section class="bh-author-about">
		<div class="bh-container bh-author-about__grid">
			<div class="bh-author-about__body">
				<?php if ( $bio ) : ?>
					<span class="bh-page-header__eyebrow" style="text-align:left;"><?php esc_html_e( 'About', 'blog-hub' ); ?></span>
					<p class="bh-author-about__bio"><?php echo esc_html( $bio ); ?></p>
				<?php endif; ?>
				<?php if ( $quote ) : ?>
					<blockquote class="bh-author-about__quote">
						<p>&ldquo;<?php echo esc_html( $quote ); ?>&rdquo;</p>
					</blockquote>
				<?php endif; ?>
				<?php if ( ! empty( $expertise ) ) : ?>
					<div class="bh-author-about__expertise">
						<span><?php esc_html_e( 'Expertise:', 'blog-hub' ); ?></span>
						<?php foreach ( $expertise as $tag ) : ?>
							<span class="bh-pill"><?php echo esc_html( $tag ); ?></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<aside class="bh-author-glance">
				<h3>
					<?php
					/* translators: %s: author's display name. */
					echo esc_html( sprintf( __( '%s at a Glance', 'blog-hub' ), $author_name ) );
					?>
				</h3>
				<?php if ( ! empty( $highlights ) ) : ?>
					<ul class="bh-author-glance__highlights">
						<?php foreach ( $highlights as $fact ) : ?>
							<li><i class="fa-solid fa-circle-check" aria-hidden="true"></i><span><?php echo esc_html( $fact ); ?></span></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php if ( $email || $phone || $website ) : ?>
					<div class="bh-author-glance__contact">
						<span class="bh-author-glance__contact-label">
							<?php
							/* translators: %s: author's display name. */
							echo esc_html( sprintf( __( 'Talk to %s', 'blog-hub' ), $author_name ) );
							?>
						</span>
						<?php if ( $phone ) : ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><?php echo esc_html( $phone ); ?></a>
						<?php endif; ?>
						<?php if ( $email ) : ?>
							<a href="mailto:<?php echo esc_attr( $email ); ?>"><i class="fa-regular fa-envelope" aria-hidden="true"></i><?php echo esc_html( $email ); ?></a>
						<?php endif; ?>
						<?php if ( $website ) : ?>
							<a href="<?php echo esc_url( $website ); ?>" rel="nofollow"><i class="fa-solid fa-globe" aria-hidden="true"></i><?php echo esc_html( $website ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php if ( $cta_url ) : ?>
					<a class="bh-btn bh-author-glance__cta" href="<?php echo esc_url( $cta_url ); ?>"><?php esc_html_e( 'Request a Quote', 'blog-hub' ); ?></a>
				<?php endif; ?>
			</aside>
		</div>
	</section>
<?php endif; ?>

<section class="bh-latest-posts">
	<div class="bh-container">
		<div class="bh-section-head">
			<h2 class="bh-section-head__title"><?php esc_html_e( 'Latest Articles', 'blog-hub' ); ?></h2>
			<div class="bh-section-head__rule"></div>
		</div>
		<?php
		get_template_part(
			'template-parts/posts-grid',
			null,
			array(
				/* translators: %s: author's display name. */
				'empty_message' => sprintf( __( '%s hasn\'t published anything yet.', 'blog-hub' ), get_the_author_meta( 'display_name', $author_id ) ),
			)
		);
		?>
	</div>
</section>

<?php get_template_part( 'template-parts/cta-end' ); ?>

<?php get_footer(); ?>
