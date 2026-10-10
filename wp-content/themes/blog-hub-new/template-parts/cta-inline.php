<?php
/**
 * Inline CTA strip, shown between blog listing sections (e.g. "Need pricing
 * on X, Y or Z? Request a quote."). Only renders when configured via
 * Customize > Blog CTA Banners.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text        = get_theme_mod( 'blog_hub_inline_cta_text', '' );
$button_text = get_theme_mod( 'blog_hub_inline_cta_button_text', '' );
$button_url  = get_theme_mod( 'blog_hub_inline_cta_button_url', '' );

if ( ! $text ) {
	return;
}
?>
<section class="bh-cta-strip">
	<div class="bh-container bh-cta-strip__inner">
		<div class="bh-cta-strip__text">
			<i class="fa-solid fa-truck-ramp-box" aria-hidden="true"></i>
			<span><?php echo esc_html( $text ); ?></span>
		</div>
		<?php if ( $button_text && $button_url ) : ?>
			<a class="bh-btn" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a>
		<?php endif; ?>
	</div>
</section>
