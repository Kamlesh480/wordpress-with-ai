<?php
/**
 * Single post template — thin wrapper around template-parts/content-single.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/breadcrumbs' );
	get_template_part( 'template-parts/content-single' );
endwhile;

get_footer();
