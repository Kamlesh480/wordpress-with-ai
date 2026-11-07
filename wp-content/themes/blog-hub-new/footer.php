<?php
/**
 * Theme footer (unified site-wide footer — Nov 2026 redesign).
 *
 * Site name/tagline come from Site Identity; contact details, social links,
 * and WhatsApp number are set via the Customizer / Menus screen. The
 * Products and "From the Blog" columns reuse the same helpers as the
 * header (see inc/site-header-footer.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bh_address         = get_theme_mod( 'blog_hub_address', '' );
$bh_email           = get_theme_mod( 'blog_hub_contact_email', '' );
$bh_phone           = get_theme_mod( 'blog_hub_contact_phone', '' );
$bh_phone_2         = get_theme_mod( 'blog_hub_contact_phone_2', '' );
$bh_map_embed       = get_theme_mod( 'blog_hub_map_embed', '' );
$bh_whatsapp_number = get_theme_mod( 'blog_hub_whatsapp_number', '' );
$bh_whatsapp_href   = $bh_whatsapp_number ? 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $bh_whatsapp_number ) : '';
?>

<section class="bh-quote-strip" aria-label="<?php esc_attr_e( 'Request a quote', 'blog-hub' ); ?>">
	<div class="bh-container bh-quote-strip__inner">
		<p><?php esc_html_e( 'Need pipes or covers for a project? Tell us what you need.', 'blog-hub' ); ?></p>
		<div class="bh-quote-strip__actions">
			<a class="bh-btn bh-btn--dark" href="<?php echo esc_url( blog_hub_find_page_url( 'template-contact.php' ) ); ?>"><?php esc_html_e( 'Request a Quote', 'blog-hub' ); ?></a>
			<?php if ( $bh_phone || $bh_phone_2 ) : ?>
				<a class="bh-btn bh-btn--gold" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_phone ? $bh_phone : $bh_phone_2 ) ); ?>">
					<i class="fa-solid fa-phone" aria-hidden="true"></i><?php esc_html_e( 'Call Now', 'blog-hub' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>

<footer class="bh-footer">
	<div class="bh-footer__top">
		<div class="bh-container bh-footer__grid">

			<div class="bh-footer__brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="bh-footer__logo-link">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<span class="bh-brand__name"><?php bloginfo( 'name' ); ?></span>
					<?php endif; ?>
				</a>
				<?php if ( get_bloginfo( 'description' ) ) : ?>
					<p class="bh-footer__tagline"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
				<?php if ( has_nav_menu( 'social' ) ) : ?>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'social',
							'container'      => false,
							'menu_class'     => 'bh-footer__social',
							'fallback_cb'    => false,
						)
					);
					?>
				<?php endif; ?>
			</div>

			<nav class="bh-footer__col" aria-label="<?php esc_attr_e( 'Products', 'blog-hub' ); ?>">
				<h3 class="bh-footer__heading"><?php esc_html_e( 'Products', 'blog-hub' ); ?></h3>
				<ul class="bh-footer__links">
					<?php foreach ( blog_hub_footer_products() as $product ) : ?>
						<li><a href="<?php echo esc_url( $product['url'] ); ?>"><?php echo esc_html( $product['label'] ); ?></a></li>
					<?php endforeach; ?>
					<li><a class="bh-footer__links-all" href="<?php echo esc_url( blog_hub_header_products_url() ); ?>"><?php esc_html_e( 'View All Products', 'blog-hub' ); ?> &rarr;</a></li>
				</ul>
			</nav>

			<nav class="bh-footer__col" aria-label="<?php esc_attr_e( 'Company', 'blog-hub' ); ?>">
				<h3 class="bh-footer__heading"><?php esc_html_e( 'Company', 'blog-hub' ); ?></h3>
				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'bh-footer__links',
							'fallback_cb'    => false,
						)
					);
					?>
				<?php endif; ?>
				<h3 class="bh-footer__heading bh-footer__heading--sub"><?php esc_html_e( 'Areas We Serve', 'blog-hub' ); ?></h3>
				<ul class="bh-footer__areas">
					<?php foreach ( blog_hub_header_areas() as $city ) : ?>
						<li><a href="<?php echo esc_url( blog_hub_header_area_url( $city ) ); ?>"><?php echo esc_html( $city ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<?php $bh_footer_cats = blog_hub_footer_blog_categories(); ?>
			<?php if ( ! empty( $bh_footer_cats ) ) : ?>
				<nav class="bh-footer__col" aria-label="<?php esc_attr_e( 'Blog categories', 'blog-hub' ); ?>">
					<h3 class="bh-footer__heading"><?php esc_html_e( 'From the Blog', 'blog-hub' ); ?></h3>
					<ul class="bh-footer__links">
						<?php foreach ( $bh_footer_cats as $cat ) : ?>
							<li><a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
						<?php endforeach; ?>
						<li><a class="bh-footer__links-all" href="<?php echo esc_url( blog_hub_find_blog_url() ); ?>"><?php esc_html_e( 'View All Articles', 'blog-hub' ); ?> &rarr;</a></li>
					</ul>
				</nav>
			<?php endif; ?>

			<div class="bh-footer__contact">
				<h3 class="bh-footer__heading"><?php esc_html_e( 'Contact', 'blog-hub' ); ?></h3>
				<?php if ( $bh_phone || $bh_phone_2 ) : ?>
					<a class="bh-btn bh-btn--gold bh-footer__call" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_phone ? $bh_phone : $bh_phone_2 ) ); ?>">
						<i class="fa-solid fa-phone" aria-hidden="true"></i><?php esc_html_e( 'Call Now', 'blog-hub' ); ?>
					</a>
				<?php endif; ?>
				<ul class="bh-footer__contact-list">
					<?php if ( $bh_phone || $bh_phone_2 ) : ?>
						<li>
							<i class="fa-solid fa-phone" aria-hidden="true"></i>
							<span>
								<?php if ( $bh_phone ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_phone ) ); ?>"><?php echo esc_html( $bh_phone ); ?></a><?php endif; ?>
								<?php if ( $bh_phone_2 ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_phone_2 ) ); ?>"><?php echo esc_html( $bh_phone_2 ); ?></a><?php endif; ?>
							</span>
						</li>
					<?php endif; ?>
					<?php if ( $bh_email ) : ?>
						<li><i class="fa-solid fa-envelope" aria-hidden="true"></i><a href="mailto:<?php echo esc_attr( $bh_email ); ?>"><?php echo esc_html( $bh_email ); ?></a></li>
					<?php endif; ?>
					<?php if ( $bh_address ) : ?>
						<li><i class="fa-solid fa-location-dot" aria-hidden="true"></i><address><?php echo nl2br( esc_html( $bh_address ) ); ?></address></li>
					<?php endif; ?>
					<?php if ( $bh_whatsapp_href ) : ?>
						<li><i class="fa-brands fa-whatsapp" aria-hidden="true"></i><a href="<?php echo esc_url( $bh_whatsapp_href ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp Us', 'blog-hub' ); ?></a></li>
					<?php endif; ?>
				</ul>
				<?php if ( $bh_map_embed ) : ?>
					<div class="bh-footer__map">
						<?php echo $bh_map_embed; // phpcs:ignore WordPress.Security.EscapeOutput -- sanitized by blog_hub_sanitize_map_embed() to a Google Maps <iframe> only. ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
				<div class="bh-footer__widgets">
					<?php dynamic_sidebar( 'footer-widgets' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="bh-footer__bottom">
		<div class="bh-container bh-footer__bottom-inner">
			<p class="bh-footer__copy">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'blog-hub' ); ?></p>
			<ul class="bh-footer__legal">
				<li><a href="#privacy-policy"><?php esc_html_e( 'Privacy Policy', 'blog-hub' ); ?></a></li>
				<li><a href="#terms"><?php esc_html_e( 'Terms', 'blog-hub' ); ?></a></li>
			</ul>
			<button type="button" class="bh-back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'blog-hub' ); ?>" data-bh-to-top hidden>
				<i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
			</button>
		</div>
	</div>
</footer>

<?php if ( $bh_whatsapp_href || $bh_phone || $bh_phone_2 ) : ?>
	<div class="bh-floating-actions" data-bh-floating>
		<?php if ( $bh_whatsapp_href ) : ?>
			<a class="bh-floating-actions__btn bh-floating-actions__btn--whatsapp" href="<?php echo esc_url( $bh_whatsapp_href ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'WhatsApp us', 'blog-hub' ); ?>">
				<i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
			</a>
		<?php endif; ?>
		<?php if ( $bh_phone || $bh_phone_2 ) : ?>
			<a class="bh-floating-actions__btn bh-floating-actions__btn--call" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_phone ? $bh_phone : $bh_phone_2 ) ); ?>" aria-label="<?php esc_attr_e( 'Call now', 'blog-hub' ); ?>">
				<i class="fa-solid fa-phone" aria-hidden="true"></i>
			</a>
		<?php endif; ?>
	</div>

	<div class="bh-sticky-contact" data-bh-sticky-contact>
		<?php if ( $bh_phone || $bh_phone_2 ) : ?>
			<a class="bh-sticky-contact__btn bh-sticky-contact__btn--call" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_phone ? $bh_phone : $bh_phone_2 ) ); ?>">
				<i class="fa-solid fa-phone" aria-hidden="true"></i><?php esc_html_e( 'Call', 'blog-hub' ); ?>
			</a>
		<?php endif; ?>
		<?php if ( $bh_whatsapp_href ) : ?>
			<a class="bh-sticky-contact__btn bh-sticky-contact__btn--whatsapp" href="<?php echo esc_url( $bh_whatsapp_href ); ?>" target="_blank" rel="noopener">
				<i class="fa-brands fa-whatsapp" aria-hidden="true"></i><?php esc_html_e( 'WhatsApp', 'blog-hub' ); ?>
			</a>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
