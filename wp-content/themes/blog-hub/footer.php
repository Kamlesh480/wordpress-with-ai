<?php
/**
 * Theme footer.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="bh-project-cta">
	<div class="bh-container">
		<i class="fa-regular fa-comments" aria-hidden="true"></i>
		<h2 class="bh-project-cta__title">HAVE A PROJECT TO<br>DISCUSS?</h2>
		<div class="bh-project-cta__rule"></div>
		<p class="bh-project-cta__desc">Tell us the product, grade and quantity you need — we will come back with a price and a delivery date.</p>
		<a class="bh-btn bh-btn--outline" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">REQUEST A QUOTE</a>
	</div>
</section>

<footer class="bh-footer">
	<div class="bh-footer__top">
		<div class="bh-container bh-footer__grid">
			<div class="bh-footer__brand">
				<span class="bh-brand__mark">SS</span>
				<span class="bh-brand__name">SHUBH SANSKAR</span>
				<span class="bh-brand__sub">CONCRETE</span>
				<p class="bh-footer__tagline">Building Trust, Creating Products</p>
			</div>

			<div>
				<h3 class="bh-footer__heading">Important Links</h3>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'bh-footer__links',
							'fallback_cb'    => false,
						)
					);
				} else {
					?>
					<ul class="bh-footer__links">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">About Us</a></li>
						<li><a href="<?php echo esc_url( home_url( '/products' ) ); ?>">Our Products</a></li>
						<li><a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">Blog</a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact Us</a></li>
					</ul>
					<?php
				}
				?>
			</div>

			<div>
				<h3 class="bh-footer__heading">Contact Us</h3>
				<ul class="bh-footer__contact">
					<li>
						<i class="fa-solid fa-location-dot" aria-hidden="true"></i>
						<span>Precast Works, Industrial Area, Madhya Pradesh, India</span>
					</li>
					<li>
						<i class="fa-solid fa-phone" aria-hidden="true"></i>
						<a href="tel:+919876543210">+91 98765 43210</a>
					</li>
					<li>
						<i class="fa-regular fa-envelope" aria-hidden="true"></i>
						<a href="mailto:info@shubhsanskarconcrete.com">info@shubhsanskarconcrete.com</a>
					</li>
				</ul>
			</div>

			<div>
				<h3 class="bh-footer__heading">Find Us</h3>
				<div class="bh-footer__map">Embedded map</div>
			</div>
		</div>
	</div>

	<div class="bh-footer__bottom">
		<div class="bh-container bh-footer__bottom-inner">
			<p class="bh-footer__copy">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Shubh Sanskar Concrete. All rights reserved.</p>
			<div class="bh-footer__social">
				<a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
				<a href="#" aria-label="X"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
				<a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
				<a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
