<?php
/**
 * Search results.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<header class="bh-page-header">
	<div class="bh-container">
		<h1 class="bh-page-header__title">
			<?php
			/* translators: %s: the search query. */
			printf( esc_html__( 'Search results for: %s', 'blog-hub' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
			?>
		</h1>
	</div>
</header>

<section class="bh-latest-posts">
	<div class="bh-container">
		<?php
		get_template_part(
			'template-parts/posts-grid',
			null,
			array( 'empty_message' => __( 'Nothing found for that search.', 'blog-hub' ) )
		);
		?>
	</div>
</section>

<?php get_footer(); ?>
