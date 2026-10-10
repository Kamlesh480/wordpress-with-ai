<?php
/**
 * Blog posts index — used for the main blog listing, whether that's the
 * site homepage (Settings > Reading: "Your latest posts") or a separate
 * "Posts page" when a static front page is set.
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
			$posts_page_id = get_option( 'page_for_posts' );
			echo esc_html( $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog', 'blog-hub' ) );
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
			array( 'empty_message' => __( 'No posts yet.', 'blog-hub' ) )
		);
		?>
	</div>
</section>

<?php get_footer(); ?>
