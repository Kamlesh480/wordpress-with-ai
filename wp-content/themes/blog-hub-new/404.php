<?php
/**
 * 404 error page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="bh-404">
	<div class="bh-container">
		<span class="bh-404__code">404</span>
		<h1 class="bh-404__title"><?php esc_html_e( 'Page Not Found', 'blog-hub' ); ?></h1>
		<p class="bh-404__desc"><?php esc_html_e( "The page you're looking for doesn't exist or has moved.", 'blog-hub' ); ?></p>
		<a class="bh-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'blog-hub' ); ?></a>

		<?php get_search_form(); ?>
	</div>
</section>

<?php get_footer(); ?>
