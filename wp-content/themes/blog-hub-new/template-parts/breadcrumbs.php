<?php
/**
 * Breadcrumb trail: Home / Blog / Category.
 * Used on the blog listing (Home / Blog, Blog as the current crumb), single
 * posts (Home / Blog / Category; the title is the H1 below), category archives
 * (Home / Blog / Category, with the category itself as the current,
 * non-linked crumb), and author archives (Home / Blog / Author name).
 * Skips any crumb that doesn't apply.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_category    = is_category();
// Areas We Serve location posts and area categories: Home / Areas We Serve / State.
$bh_area_cat = null;
if ( is_singular( 'post' ) && blog_hub_is_area_post( get_queried_object_id() ) ) {
	$bh_area_cat = blog_hub_area_post_category( get_queried_object_id() );
} elseif ( $is_category && in_array( (int) get_queried_object_id(), blog_hub_area_category_ids(), true ) ) {
	$bh_area_cat = get_queried_object();
}
$is_author      = is_author();
$is_blog_index  = is_home();
$primary_cat    = ( $is_category || $is_author || $is_blog_index ) ? null : blog_hub_primary_category();
$blog_page      = get_option( 'page_for_posts' );
$blog_page_name = $blog_page ? get_the_title( $blog_page ) : __( 'Blog', 'blog-hub' );
$paged          = max( (int) get_query_var( 'paged' ), 1 );
?>
<nav class="bh-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'blog-hub' ); ?>">
	<div class="bh-container">
		<ol>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'blog-hub' ); ?></a></li>
			<?php if ( $bh_area_cat ) : ?>
				<?php
				$bh_trail = blog_hub_area_trail( $bh_area_cat );
				$bh_last  = count( $bh_trail ) - 1;
				foreach ( $bh_trail as $bh_i => $bh_item ) :
					?>
					<li><span aria-hidden="true">/</span></li>
					<?php if ( $is_category && $bh_i === $bh_last ) : ?>
						<li aria-current="page"><?php echo esc_html( $bh_item[0] ); ?></li>
					<?php else : ?>
						<li><a href="<?php echo esc_url( $bh_item[1] ); ?>"><?php echo esc_html( $bh_item[0] ); ?></a></li>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php elseif ( $is_blog_index && $paged > 1 ) : ?>
				<li><span aria-hidden="true">/</span></li>
				<li><a href="<?php echo esc_url( $blog_page ? get_permalink( $blog_page ) : home_url( '/' ) ); ?>"><?php echo esc_html( $blog_page_name ); ?></a></li>
				<li><span aria-hidden="true">/</span></li>
				<li aria-current="page">
					<?php
					/* translators: %d: page number. */
					echo esc_html( sprintf( __( 'Page %d', 'blog-hub' ), $paged ) );
					?>
				</li>
			<?php elseif ( $is_blog_index ) : ?>
				<li><span aria-hidden="true">/</span></li>
				<li aria-current="page"><?php echo esc_html( $blog_page_name ); ?></li>
			<?php else : ?>
				<?php if ( $blog_page ) : ?>
					<li><span aria-hidden="true">/</span></li>
					<li><a href="<?php echo esc_url( get_permalink( $blog_page ) ); ?>"><?php echo esc_html( get_the_title( $blog_page ) ); ?></a></li>
				<?php endif; ?>
				<?php if ( $is_category ) : ?>
					<li><span aria-hidden="true">/</span></li>
					<li aria-current="page"><?php single_cat_title(); ?></li>
				<?php elseif ( $is_author ) : ?>
					<li><span aria-hidden="true">/</span></li>
					<li aria-current="page"><?php the_author_meta( 'display_name', get_queried_object_id() ); ?></li>
				<?php else : ?>
					<?php
					// Posts stop at the category: the post title is the H1 right
					// below, and repeating it made the trail wrap into a tall
					// block on phones. The JSON-LD breadcrumb keeps the full
					// trail (blog_hub_breadcrumb_schema()).
					if ( $primary_cat ) :
						?>
						<li><span aria-hidden="true">/</span></li>
						<li><a href="<?php echo esc_url( get_category_link( $primary_cat ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a></li>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		</ol>
	</div>
</nav>
