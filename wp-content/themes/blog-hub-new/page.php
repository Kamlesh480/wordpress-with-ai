<?php
/**
 * Default template for a static Page.
 *
 * Kept intentionally minimal (no extra chrome beyond header/footer) so it
 * works both for plain content pages and as the required the_content() host
 * for page builders that render their own layout inside it.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="main-content">
		<?php if ( ! is_front_page() ) : ?>
			<header class="bh-page-header">
				<div class="bh-container">
					<h1 class="bh-page-header__title"><?php the_title(); ?></h1>
				</div>
			</header>
		<?php endif; ?>
		<div class="bh-container bh-page-content">
			<?php the_content(); ?>
		</div>
	</main>
	<?php
endwhile;

get_footer();
