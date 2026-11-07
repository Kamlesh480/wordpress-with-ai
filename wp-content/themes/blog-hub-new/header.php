<?php
/**
 * Theme header (unified site-wide header — Nov 2026 redesign).
 *
 * Site name/logo come from WordPress's own Site Identity (Customizer). The
 * Products and Areas We Serve mega-menus are intentionally hardcoded (see
 * blog_hub_header_product_categories() / blog_hub_header_areas() in
 * functions.php) since those destination pages don't exist on this site yet
 * — update that one array when they do. The Blog dropdown and "current page"
 * highlighting are the only genuinely dynamic pieces.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bh_contact_email   = get_theme_mod( 'blog_hub_contact_email', '' );
$bh_contact_phone   = get_theme_mod( 'blog_hub_contact_phone', '' );
$bh_contact_phone_2 = get_theme_mod( 'blog_hub_contact_phone_2', '' );
$bh_call_number     = $bh_contact_phone ? $bh_contact_phone : $bh_contact_phone_2;
$bh_call_tel        = $bh_call_number ? preg_replace( '/[^0-9+]/', '', $bh_call_number ) : '';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'blog-hub' ); ?>>
<?php wp_body_open(); ?>

<a class="bh-skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'blog-hub' ); ?></a>

<header class="bh-header" data-bh-header>
	<?php if ( $bh_contact_email || $bh_contact_phone || $bh_contact_phone_2 ) : ?>
		<div class="bh-topbar" data-bh-topbar>
			<div class="bh-container bh-topbar__inner">
				<?php if ( $bh_contact_email ) : ?>
					<a href="mailto:<?php echo esc_attr( $bh_contact_email ); ?>">
						<i class="fa-solid fa-envelope" aria-hidden="true"></i>
						<?php echo esc_html( $bh_contact_email ); ?>
					</a>
				<?php endif; ?>
				<?php if ( $bh_contact_phone || $bh_contact_phone_2 ) : ?>
					<div class="bh-topbar__links">
						<?php if ( $bh_contact_phone ) : ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_contact_phone ) ); ?>">
								<i class="fa-solid fa-phone" aria-hidden="true"></i>
								<?php echo esc_html( $bh_contact_phone ); ?>
							</a>
						<?php endif; ?>
						<?php if ( $bh_contact_phone_2 ) : ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_contact_phone_2 ) ); ?>">
								<i class="fa-solid fa-phone" aria-hidden="true"></i>
								<?php echo esc_html( $bh_contact_phone_2 ); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<nav class="bh-nav" aria-label="<?php esc_attr_e( 'Primary', 'blog-hub' ); ?>">
		<div class="bh-container bh-nav__inner">
			<a class="bh-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<span class="bh-brand__text">
						<span class="bh-brand__name"><?php bloginfo( 'name' ); ?></span>
						<?php if ( get_bloginfo( 'description' ) ) : ?>
							<span class="bh-brand__sub"><?php bloginfo( 'description' ); ?></span>
						<?php endif; ?>
					</span>
				<?php endif; ?>
			</a>

			<ul class="bh-menu" data-bh-menu>
				<?php foreach ( blog_hub_header_nav_items() as $bh_item ) : ?>
					<li class="bh-menu__item<?php echo $bh_item['current'] ? ' is-current' : ''; ?><?php echo $bh_item['has_dropdown'] ? ' bh-menu__item--dropdown' : ''; ?>">
						<?php if ( $bh_item['has_dropdown'] ) : ?>
							<button type="button" class="bh-menu__link bh-menu__toggle" aria-expanded="false" aria-controls="bh-dd-<?php echo esc_attr( $bh_item['key'] ); ?>">
								<?php echo esc_html( $bh_item['label'] ); ?>
								<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
							</button>
							<?php blog_hub_render_header_dropdown( $bh_item['key'] ); ?>
						<?php else : ?>
							<a class="bh-menu__link" href="<?php echo esc_url( $bh_item['url'] ); ?>"<?php echo $bh_item['current'] ? ' aria-current="page"' : ''; ?>>
								<?php echo esc_html( $bh_item['label'] ); ?>
							</a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php if ( $bh_call_tel ) : ?>
				<a class="bh-nav__call" href="tel:<?php echo esc_attr( $bh_call_tel ); ?>">
					<i class="fa-solid fa-phone" aria-hidden="true"></i>
					<span><?php esc_html_e( 'Call Now', 'blog-hub' ); ?></span>
				</a>
			<?php endif; ?>

			<button type="button" class="bh-nav__toggle" aria-expanded="false" aria-controls="bh-mobile-menu" data-bh-burger>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'blog-hub' ); ?></span>
				<i class="fa-solid fa-bars" aria-hidden="true"></i>
			</button>
		</div>
	</nav>
</header>
<div class="bh-header-spacer" data-bh-header-spacer aria-hidden="true"></div>

<div class="bh-mobile-backdrop" data-bh-backdrop hidden></div>
<div class="bh-mobile-menu" id="bh-mobile-menu" data-bh-mobile-menu role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site menu', 'blog-hub' ); ?>" hidden>
	<div class="bh-mobile-menu__head">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="bh-brand__name"><?php bloginfo( 'name' ); ?></span>
			<?php endif; ?>
		</a>
		<button type="button" class="bh-mobile-menu__close" aria-label="<?php esc_attr_e( 'Close menu', 'blog-hub' ); ?>" data-bh-close>
			<i class="fa-solid fa-xmark" aria-hidden="true"></i>
		</button>
	</div>
	<nav class="bh-mobile-menu__nav" aria-label="<?php esc_attr_e( 'Mobile', 'blog-hub' ); ?>">
		<ul>
			<?php foreach ( blog_hub_header_nav_items() as $bh_item ) : ?>
				<li class="bh-mobile-menu__item">
					<?php if ( $bh_item['has_dropdown'] ) : ?>
						<button type="button" class="bh-mobile-menu__link bh-mobile-menu__toggle" aria-expanded="false" aria-controls="bh-m-dd-<?php echo esc_attr( $bh_item['key'] ); ?>">
							<?php echo esc_html( $bh_item['label'] ); ?>
							<i class="fa-solid fa-plus" aria-hidden="true"></i>
						</button>
						<?php blog_hub_render_mobile_header_dropdown( $bh_item['key'] ); ?>
					<?php else : ?>
						<a class="bh-mobile-menu__link" href="<?php echo esc_url( $bh_item['url'] ); ?>"<?php echo $bh_item['current'] ? ' aria-current="page"' : ''; ?>>
							<?php echo esc_html( $bh_item['label'] ); ?>
						</a>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
	<div class="bh-mobile-menu__contact">
		<span class="bh-mobile-menu__contact-label"><?php esc_html_e( 'Contact Us', 'blog-hub' ); ?></span>
		<?php if ( $bh_contact_phone ) : ?>
			<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_contact_phone ) ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><?php echo esc_html( $bh_contact_phone ); ?></a>
		<?php endif; ?>
		<?php if ( $bh_contact_phone_2 ) : ?>
			<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $bh_contact_phone_2 ) ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><?php echo esc_html( $bh_contact_phone_2 ); ?></a>
		<?php endif; ?>
		<?php if ( $bh_contact_email ) : ?>
			<a href="mailto:<?php echo esc_attr( $bh_contact_email ); ?>"><i class="fa-solid fa-envelope" aria-hidden="true"></i><?php echo esc_html( $bh_contact_email ); ?></a>
		<?php endif; ?>
	</div>
</div>
