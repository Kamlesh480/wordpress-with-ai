<?php
/**
 * "Get New Guides in Your Inbox" signup band (blog page, above the links line
 * and the Request a Quote band). Renders only when there's somewhere real to
 * send sign-ups:
 *  - a WPForms shortcode (Front Page Hero > Newsletter form shortcode), or
 *  - an email-service form action URL (Front Page Hero > Newsletter form
 *    action URL).
 * Otherwise it stays hidden rather than showing a form that goes nowhere.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shortcode = get_theme_mod( 'blog_hub_newsletter_shortcode', '' );
$action    = get_theme_mod( 'blog_hub_newsletter_action', '' );
$form_html = $shortcode ? do_shortcode( $shortcode ) : '';

if ( ! $form_html && ! $action ) {
	return;
}

$privacy_url = get_privacy_policy_url();
?>
<section class="bh-newsletter">
	<div class="bh-container">
		<i class="fa-regular fa-envelope-open" aria-hidden="true"></i>
		<h2 class="bh-newsletter__title"><?php esc_html_e( 'Get New Guides in Your Inbox', 'blog-hub' ); ?></h2>
		<p class="bh-newsletter__desc"><?php esc_html_e( 'One email when we publish a new guide on precast concrete products. No spam, unsubscribe any time.', 'blog-hub' ); ?></p>
		<?php if ( $form_html ) : ?>
			<div class="bh-newsletter__form">
				<?php echo $form_html; // phpcs:ignore WordPress.Security.EscapeOutput -- WPForms renders its own escaped form markup. ?>
			</div>
		<?php else : ?>
			<form class="bh-newsletter__form" method="post" action="<?php echo esc_url( $action ); ?>">
				<label class="bh-newsletter__label" for="bh-newsletter-email"><?php esc_html_e( 'Email address', 'blog-hub' ); ?> <span aria-hidden="true">*</span></label>
				<div class="bh-newsletter__row">
					<input type="email" id="bh-newsletter-email" name="EMAIL" placeholder="<?php esc_attr_e( 'you@company.com', 'blog-hub' ); ?>" required>
					<button type="submit" class="bh-btn"><?php esc_html_e( 'Subscribe', 'blog-hub' ); ?></button>
				</div>
			</form>
		<?php endif; ?>
		<p class="bh-newsletter__disclaimer">
			<?php if ( $privacy_url ) : ?>
				<?php
				printf(
					/* translators: %s: privacy policy link. */
					esc_html__( 'By subscribing you agree to our %s.', 'blog-hub' ),
					'<a href="' . esc_url( $privacy_url ) . '">' . esc_html__( 'privacy policy', 'blog-hub' ) . '</a>'
				);
				?>
			<?php else : ?>
				<?php esc_html_e( 'We only use your email to send new guides.', 'blog-hub' ); ?>
			<?php endif; ?>
		</p>
	</div>
</section>
