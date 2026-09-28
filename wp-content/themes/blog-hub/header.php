<?php
/**
 * Theme header.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'blog-hub' ); ?>>
<?php wp_body_open(); ?>

<header class="bh-topbar">
	<div class="bh-container bh-topbar__inner">
		<a href="mailto:info@shubhsanskarconcrete.com">
			<i class="fa-regular fa-envelope" aria-hidden="true"></i>
			info@shubhsanskarconcrete.com
		</a>
		<div class="bh-topbar__links">
			<a href="tel:+919876543210">
				<i class="fa-solid fa-phone" aria-hidden="true"></i>
				+91 98765 43210
			</a>
			<a href="tel:+919876543211">
				<i class="fa-solid fa-phone" aria-hidden="true"></i>
				+91 98765 43211
			</a>
		</div>
	</div>
</header>

<nav class="bh-nav">
	<div class="bh-container bh-nav__inner">
		<a class="bh-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="bh-brand__mark">SS</span>
			<span>
				<span class="bh-brand__name">SHUBH SANSKAR</span>
				<span class="bh-brand__sub">CONCRETE</span>
			</span>
		</a>
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'bh-menu',
					'fallback_cb'    => false,
				)
			);
		} else {
			?>
			<ul class="bh-menu">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a></li>
				<li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">ABOUT US</a></li>
				<li><a href="<?php echo esc_url( home_url( '/products' ) ); ?>">OUR PRODUCTS</a></li>
				<li><a class="is-current" href="<?php echo esc_url( home_url( '/blog' ) ); ?>">BLOG</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">CONTACT US</a></li>
			</ul>
			<?php
		}
		?>
	</div>
</nav>
