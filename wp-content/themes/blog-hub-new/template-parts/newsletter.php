<?php
/**
 * Email newsletter signup band. Only renders if an action URL is set in the
 * Customizer (Front Page Hero > Newsletter form action URL) — otherwise the
 * theme has no working destination for the form and stays silent.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$action = get_theme_mod( 'blog_hub_newsletter_action', '' );
if ( ! $action ) {
	return;
}
?>
<section class="bh-newsletter">
	<div class="bh-container">
		<i class="fa-regular fa-envelope-open" aria-hidden="true"></i>
		<h2 class="bh-newsletter__title"><?php esc_html_e( 'Get New Posts in Your Inbox', 'blog-hub' ); ?></h2>
		<p class="bh-newsletter__desc"><?php esc_html_e( 'One email when we publish something new. No spam, unsubscribe any time.', 'blog-hub' ); ?></p>
		<form method="post" action="<?php echo esc_url( $action ); ?>">
			<label class="screen-reader-text" for="bh-newsletter-email"><?php esc_html_e( 'Email address', 'blog-hub' ); ?></label>
			<input type="email" id="bh-newsletter-email" name="email" placeholder="<?php esc_attr_e( 'you@example.com', 'blog-hub' ); ?>" required>
			<button type="submit" class="bh-btn"><?php esc_html_e( 'Subscribe', 'blog-hub' ); ?></button>
		</form>
	</div>
</section>
