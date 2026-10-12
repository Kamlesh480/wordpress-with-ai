<?php
/**
 * A short, centered line of text with links shown near the bottom of the
 * blog listing (e.g. "Explore our products, learn about us..."). Only
 * renders if configured via Customize > Front Page Hero.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text = get_theme_mod( 'blog_hub_links_line', '' );
if ( ! $text ) {
	return;
}
?>
<section class="bh-links-line">
	<div class="bh-container">
		<p><?php echo wp_kses_post( $text ); ?></p>
	</div>
</section>
