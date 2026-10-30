<?php
/**
 * Template Name: About Us
 *
 * Assign this to a Page from the editor's "Template" dropdown. All of the
 * "Who We Are" copy — intro paragraph, heading, sub-heading, body text,
 * vision line, checklist — comes from the_content() (the normal page
 * editor); the template wraps it in the two-column layout and places the
 * "Who We Are" photo (its own meta box) in the second column. Only the
 * page-header image, the gallery photo, and the "Find Us" map are separate
 * fields, since those aren't part of the body copy itself.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$page_hero_image    = get_post_meta( get_the_ID(), 'blog_hub_page_hero_image', true );
	$gallery_image      = get_post_meta( get_the_ID(), 'blog_hub_about_gallery_image', true );
	$map_embed          = get_theme_mod( 'blog_hub_map_embed', '' );
	$email              = get_theme_mod( 'blog_hub_contact_email', '' );
	$address            = get_theme_mod( 'blog_hub_address', '' );

	// The intro paragraph (full-width, above the two-column "Who We Are"
	// block) is just the first block of the_content(); everything after it
	// goes in the left column next to the gallery photo. Splitting on the
	// first </p> keeps this simple without needing a second editor field.
	$content       = apply_filters( 'the_content', get_the_content() );
	$split_at      = strpos( $content, '</p>' );
	if ( false !== $split_at ) {
		$intro_html = substr( $content, 0, $split_at + 4 );
		$rest_html  = substr( $content, $split_at + 4 );
	} else {
		$intro_html = $content;
		$rest_html  = '';
	}
	?>

	<section class="bh-ms-page-hero">
		<?php if ( $page_hero_image ) : ?>
			<img class="bh-ms-page-hero__bg" src="<?php echo esc_url( $page_hero_image ); ?>" alt="">
		<?php endif; ?>
		<div class="bh-ms-page-hero__overlay" aria-hidden="true"></div>
		<div class="bh-ms-page-hero__inner">
			<h1 class="bh-ms-page-hero__title"><?php the_title(); ?></h1>
			<span class="bh-ms-rule" aria-hidden="true"></span>
		</div>
	</section>

	<div class="bh-ms-intro">
		<?php echo $intro_html; // phpcs:ignore WordPress.Security.EscapeOutput -- the_content filter already sanitizes/KSES's this. ?>
	</div>

	<div class="bh-ms-who-we-are">
		<div class="bh-ms-who-we-are__inner">
			<div class="bh-ms-who-we-are__copy">
				<?php echo $rest_html; // phpcs:ignore WordPress.Security.EscapeOutput -- the_content filter already sanitizes/KSES's this. ?>
			</div>
			<?php if ( $gallery_image ) : ?>
				<div class="bh-ms-who-we-are__image">
					<img src="<?php echo esc_url( $gallery_image ); ?>" alt="">
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( $map_embed || $email || $address ) : ?>
		<section class="bh-ms-find-us">
			<div class="bh-ms-find-us__inner">
				<?php if ( $map_embed ) : ?>
					<div class="bh-ms-find-us__map">
						<?php echo $map_embed; // phpcs:ignore WordPress.Security.EscapeOutput -- sanitized by blog_hub_sanitize_map_embed() to a Google Maps <iframe> only. ?>
					</div>
				<?php endif; ?>
				<div class="bh-ms-find-us__copy">
					<h3><?php esc_html_e( "Didn't Find What You Were Looking For?", 'blog-hub' ); ?></h3>
					<?php if ( $email ) : ?>
						<p>
							<?php
							echo wp_kses_post(
								sprintf(
									/* translators: %s: contact email link. */
									__( 'Write to us at %s', 'blog-hub' ),
									'<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>'
								)
							);
							?>
						</p>
					<?php endif; ?>
					<p><?php esc_html_e( 'Help us know your need so that we manufacture what you want.', 'blog-hub' ); ?></p>
					<?php if ( $address ) : ?>
						<p><strong><?php esc_html_e( 'Contact us at:', 'blog-hub' ); ?></strong> <?php echo nl2br( esc_html( $address ) ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php
endwhile;

get_footer();
