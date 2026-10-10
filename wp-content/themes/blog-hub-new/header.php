<?php
/**
 * Theme header.
 *
 * Site name/logo come from WordPress's own Site Identity (Customizer); the
 * top contact bar and nav menu are optional and empty by default — nothing
 * here is hardcoded to any particular business.
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

<?php
$bh_contact_email = get_theme_mod( 'blog_hub_contact_email', '' );
$bh_contact_phone  = get_theme_mod( 'blog_hub_contact_phone', '' );
if ( $bh_contact_email || $bh_contact_phone ) :
	?>
	<header class="bh-topbar">
		<div class="bh-container bh-topbar__inner">
			<?php if ( $bh_contact_email ) : ?>
				<a href="mailto:<?php echo esc_attr( $bh_contact_email ); ?>">
					<i class="fa-regular fa-envelope" aria-hidden="true"></i>
					<?php echo esc_html( $bh_contact_email ); ?>
				</a>
			<?php endif; ?>
			<?php if ( $bh_contact_phone ) : ?>
				<div class="bh-topbar__links">
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_contact_phone ) ); ?>">
						<i class="fa-solid fa-phone" aria-hidden="true"></i>
						<?php echo esc_html( $bh_contact_phone ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</header>
<?php endif; ?>

<nav class="bh-nav">
	<div class="bh-container bh-nav__inner">
		<a class="bh-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="bh-brand__name"><?php bloginfo( 'name' ); ?></span>
				<?php if ( get_bloginfo( 'description' ) ) : ?>
					<span class="bh-brand__sub"><?php bloginfo( 'description' ); ?></span>
				<?php endif; ?>
			<?php endif; ?>
		</a>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'bh-menu',
				'fallback_cb'    => false,
			)
		);
		?>
	</div>
</nav>
