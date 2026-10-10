<?php
/**
 * Generic archive template — tags, date archives, custom taxonomies, and any
 * other archive type without its own more specific template file
 * (category.php and author.php take priority over this for those types).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<header class="bh-page-header">
	<div class="bh-container">
		<h1 class="bh-page-header__title"><?php the_archive_title(); ?></h1>
		<?php if ( term_description() ) : ?>
			<div class="bh-page-header__desc"><?php echo wp_kses_post( term_description() ); ?></div>
		<?php endif; ?>
	</div>
</header>

<section class="bh-latest-posts">
	<div class="bh-container">
		<?php get_template_part( 'template-parts/posts-grid' ); ?>
	</div>
</section>

<?php get_template_part( 'template-parts/cta-end' ); ?>

<?php get_footer(); ?>
