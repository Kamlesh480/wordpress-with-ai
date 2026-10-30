<?php
/**
 * Template Name: Contact Us
 *
 * The contact form itself is intentionally NOT hand-built in this theme —
 * form submission needs real spam protection and email delivery, which
 * WPForms (already installed on the live/staging site) already handles
 * reliably. Create the form in WPForms matching the design's fields (Name,
 * Company Name, Email, Phone Number, Query, consent), then paste its
 * shortcode into the Customizer field below. Office locations are a
 * Customizer repeater-style field (one per line: label | address | map
 * embed URL) since there are only ever a handful of these and they change
 * rarely — not worth a full custom post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$page_hero_image = get_post_meta( get_the_ID(), 'blog_hub_page_hero_image', true );
	$intro_heading    = get_theme_mod( 'blog_hub_contact_intro_heading', '' );
	$form_shortcode   = get_theme_mod( 'blog_hub_contact_form_shortcode', '' );
	$email            = get_theme_mod( 'blog_hub_contact_email', '' );
	$phone            = get_theme_mod( 'blog_hub_contact_phone', '' );
	$phone_2          = get_theme_mod( 'blog_hub_contact_phone_2', '' );
	$address          = get_theme_mod( 'blog_hub_address', '' );
	$offices_raw      = get_theme_mod( 'blog_hub_contact_offices', '' );
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

	<section class="bh-ms-contact">
		<div class="bh-ms-contact__inner">
			<div class="bh-ms-contact__copy">
				<?php if ( $intro_heading ) : ?>
					<h2><?php echo esc_html( $intro_heading ); ?></h2>
					<span class="bh-ms-rule" aria-hidden="true"></span>
				<?php endif; ?>

				<?php the_content(); ?>

				<?php if ( $phone || $phone_2 ) : ?>
					<ul class="bh-ms-contact__details">
						<?php if ( $phone ) : ?>
							<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><?php echo esc_html( $phone ); ?></a></li>
						<?php endif; ?>
						<?php if ( $phone_2 ) : ?>
							<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone_2 ) ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><?php echo esc_html( $phone_2 ); ?></a></li>
						<?php endif; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $email ) : ?>
					<a class="bh-ms-contact__row" href="mailto:<?php echo esc_attr( $email ); ?>"><i class="fa-solid fa-envelope" aria-hidden="true"></i><?php echo esc_html( $email ); ?></a>
				<?php endif; ?>

				<?php if ( $address ) : ?>
					<span class="bh-ms-contact__row bh-ms-contact__row--caps"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><?php echo esc_html( $address ); ?></span>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'social' ) ) : ?>
					<div class="bh-ms-contact__social">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social',
								'container'      => false,
								'items_wrap'     => '%3$s',
								'fallback_cb'    => false,
							)
						);
						?>
					</div>
				<?php endif; ?>
			</div>

			<div class="bh-ms-contact__form">
				<?php if ( $form_shortcode ) : ?>
					<?php echo do_shortcode( $form_shortcode ); ?>
				<?php else : ?>
					<p><?php esc_html_e( 'Contact form not configured yet — paste a WPForms shortcode into Customizer > Contact Details > Contact form shortcode.', 'blog-hub' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if ( $offices_raw ) : ?>
		<section class="bh-ms-offices">
			<div class="bh-ms-offices__grid">
				<?php foreach ( explode( "\n", $offices_raw ) as $line ) : ?>
					<?php
					$line = trim( $line );
					if ( ! $line ) {
						continue;
					}
					$parts = array_map( 'trim', explode( '|', $line, 3 ) );
					if ( count( $parts ) < 3 ) {
						continue;
					}
					list( $label, $office_address, $map_url ) = $parts;
					?>
					<div class="bh-ms-office">
						<iframe title="<?php echo esc_attr( $label ); ?>" src="<?php echo esc_url( $map_url ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
						<pre class="bh-ms-office__address"><strong><?php echo esc_html( $label ); ?>:</strong> <?php echo esc_html( $office_address ); ?></pre>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php
endwhile;

get_footer();
