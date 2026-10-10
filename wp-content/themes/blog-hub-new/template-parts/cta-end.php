<?php
/**
 * Dark, centered end-of-page CTA ("Have a project to discuss?" style),
 * shown at the bottom of blog listing pages and single posts. Only renders
 * when configured via Customize > Blog CTA Banners.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title       = get_theme_mod( 'blog_hub_end_cta_title', '' );
$text        = get_theme_mod( 'blog_hub_end_cta_text', '' );
$button_text = get_theme_mod( 'blog_hub_end_cta_button_text', '' );
$button_url  = get_theme_mod( 'blog_hub_end_cta_button_url', '' );

if ( ! $title ) {
	return;
}
?>
<section class="bh-project-cta">
	<div class="bh-container">
		<i class="fa-regular fa-comments" aria-hidden="true"></i>
		<h2 class="bh-project-cta__title"><?php echo esc_html( $title ); ?></h2>
		<div class="bh-project-cta__rule"></div>
		<?php if ( $text ) : ?>
			<p class="bh-project-cta__desc"><?php echo esc_html( $text ); ?></p>
		<?php endif; ?>
		<?php if ( $button_text && $button_url ) : ?>
			<a class="bh-btn bh-btn--outline" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a>
		<?php endif; ?>
	</div>
</section>
