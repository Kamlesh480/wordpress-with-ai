<?php
/**
 * Template Name: Full Width
 * Description: A page template with no title header and a wider content
 * area — useful for landing pages, page-builder content, or custom layouts
 * assembled with blocks.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main-content" class="bh-full-width">
		<?php the_content(); ?>
	</main>
	<?php
endwhile;

get_footer();
