<?php
/**
 * Default template fallback.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="bh-container" style="padding-block:64px;">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article style="margin-bottom:48px;">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div><?php the_excerpt(); ?></div>
			</article>
			<?php
		endwhile;
		?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing found.', 'blog-hub' ); ?></p>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
