<?php
/**
 * Dark end-of-page CTA band, shown at the bottom of blog listing pages and
 * single posts. Only renders when configured via Customize > Blog CTA
 * Banners.
 *
 * Two layouts:
 * - default: centered ("Have a project to discuss?") — blog listing pages.
 * - split:   image on the left, copy + gold button on the right — single
 *            posts. Falls back to the centered layout when no image is set,
 *            so a missing photo never leaves an empty box on the page.
 *
 * @param array $args { @type string $layout 'default'|'split' }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title       = get_theme_mod( 'blog_hub_end_cta_title', '' );
$text        = get_theme_mod( 'blog_hub_end_cta_text', '' );
$button_text = get_theme_mod( 'blog_hub_end_cta_button_text', '' );
$button_url  = get_theme_mod( 'blog_hub_end_cta_button_url', '' );
$image_url   = get_theme_mod( 'blog_hub_end_cta_image', '' );
$is_split    = isset( $args['layout'] ) && 'split' === $args['layout'] && $image_url;

if ( ! $title ) {
	return;
}
?>
<?php if ( $is_split ) : ?>
	<section class="bh-project-cta bh-project-cta--split">
		<div class="bh-container bh-project-cta__grid">
			<div class="bh-project-cta__media">
				<img src="<?php echo esc_url( $image_url ); ?>" alt="" loading="lazy">
			</div>
			<div class="bh-project-cta__copy">
				<h2 class="bh-project-cta__title"><?php echo esc_html( $title ); ?></h2>
				<?php if ( $text ) : ?>
					<p class="bh-project-cta__desc"><?php echo esc_html( $text ); ?></p>
				<?php endif; ?>
				<?php if ( $button_text && $button_url ) : ?>
					<p><a class="bh-btn bh-btn--gold" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php else : ?>
	<section class="bh-project-cta">
		<div class="bh-container">
			<i class="fa-regular fa-comments" aria-hidden="true"></i>
			<h2 class="bh-project-cta__title"><?php echo esc_html( $title ); ?></h2>
			<div class="bh-project-cta__rule"></div>
			<?php if ( $text ) : ?>
				<p class="bh-project-cta__desc"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
			<?php if ( $button_text && $button_url ) : ?>
				<a class="bh-btn bh-btn--gold" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
