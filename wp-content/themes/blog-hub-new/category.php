<?php
/**
 * Category archive — header with description and a jump-to-category
 * dropdown, article count, post grid, category list and CTAs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

global $wp_query;
$article_count = (int) $wp_query->found_posts;
?>

<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

<header class="bh-category-header">
	<div class="bh-container bh-category-header__inner">
		<div class="bh-category-header__copy">
			<span class="bh-page-header__eyebrow"><?php esc_html_e( 'Blog Category', 'blog-hub' ); ?></span>
			<h1 class="bh-page-header__title"><?php single_cat_title(); ?></h1>
			<?php if ( category_description() ) : ?>
				<div class="bh-page-header__desc"><?php echo wp_kses_post( category_description() ); ?></div>
			<?php endif; ?>
		</div>
		<?php get_template_part( 'template-parts/category-switcher' ); ?>
	</div>
</header>

<section class="bh-latest-posts">
	<div class="bh-container">
		<?php
		get_template_part(
			'template-parts/posts-grid',
			null,
			array(
				'empty_message' => __( 'No posts in this category yet.', 'blog-hub' ),
				'show_count'    => false,
				/* translators: %d: number of articles in this category. */
				'heading'       => sprintf( _n( '%d Article', '%d Articles', $article_count, 'blog-hub' ), $article_count ),
			)
		);
		?>
	</div>
</section>

<?php get_template_part( 'template-parts/cta-end' ); ?>

<?php get_footer(); ?>
