<?php
/**
 * Template Name: Page Builder Full Width
 *
 * Same file name as the live site's Neve template, so pages built in
 * Elementor with "Page Builder Full Width" (e.g. the Areas We Serve state
 * pages) keep their full-width layout when served with Blog Hub: the
 * Elementor content runs edge to edge between the header and footer, with
 * no extra page title or container (Elementor provides both).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main-content" class="bh-page-builder">
		<?php the_content(); ?>
	</main>
	<?php
endwhile;

get_footer();
