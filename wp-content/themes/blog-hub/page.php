<?php
/**
 * Default template for a static Page.
 *
 * Kept intentionally minimal (no site chrome beyond header/footer) so it
 * works both for plain content pages and as the required the_content()
 * host for page builders (Elementor) that render their own layout inside it.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main-content">
		<?php the_content(); ?>
	</main>
	<?php
endwhile;

get_footer();
