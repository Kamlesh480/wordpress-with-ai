<?php
/**
 * Fallback template — the last resort when no more specific template
 * (front-page, home, single, page, category, archive, author, search,
 * 404...) matches the current request.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="bh-latest-posts">
	<div class="bh-container">
		<?php get_template_part( 'template-parts/posts-grid' ); ?>
	</div>
</section>

<?php get_footer(); ?>
