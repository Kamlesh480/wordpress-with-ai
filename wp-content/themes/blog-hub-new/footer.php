<?php
/**
 * Theme footer.
 *
 * Site name/tagline come from Site Identity; contact details and a social
 * links menu are optional, set via the Customizer and Menus screen. A
 * site-wide footer widget area is also available (Appearance > Widgets).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bh_address = get_theme_mod( 'blog_hub_address', '' );
$bh_email   = get_theme_mod( 'blog_hub_contact_email', '' );
$bh_phone   = get_theme_mod( 'blog_hub_contact_phone', '' );
?>

<footer class="bh-footer">
	<div class="bh-footer__top">
		<div class="bh-container bh-footer__grid">
			<div class="bh-footer__brand">
				<span class="bh-brand__name"><?php bloginfo( 'name' ); ?></span>
				<?php if ( get_bloginfo( 'description' ) ) : ?>
					<p class="bh-footer__tagline"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<div>
					<h3 class="bh-footer__heading"><?php esc_html_e( 'Links', 'blog-hub' ); ?></h3>
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
				</div>
			<?php endif; ?>

			<?php if ( $bh_address || $bh_email || $bh_phone ) : ?>
				<div>
					<h3 class="bh-footer__heading"><?php esc_html_e( 'Contact Us', 'blog-hub' ); ?></h3>
					<ul class="bh-footer__contact">
						<?php if ( $bh_address ) : ?>
							<li>
								<i class="fa-solid fa-location-dot" aria-hidden="true"></i>
								<span><?php echo nl2br( esc_html( $bh_address ) ); ?></span>
							</li>
						<?php endif; ?>
						<?php if ( $bh_phone ) : ?>
							<li>
								<i class="fa-solid fa-phone" aria-hidden="true"></i>
								<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_phone ) ); ?>"><?php echo esc_html( $bh_phone ); ?></a>
							</li>
						<?php endif; ?>
						<?php if ( $bh_email ) : ?>
							<li>
								<i class="fa-regular fa-envelope" aria-hidden="true"></i>
								<a href="mailto:<?php echo esc_attr( $bh_email ); ?>"><?php echo esc_html( $bh_email ); ?></a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>

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
			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'social',
						'container'      => false,
						'menu_class'     => 'bh-footer__social',
						'fallback_cb'    => false,
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>',
					)
				);
				?>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
