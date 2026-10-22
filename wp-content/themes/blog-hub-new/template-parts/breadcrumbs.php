<?php
/**
 * Breadcrumb trail: Home / Blog / Category / Post title.
 * Used on the blog listing (Home / Blog, Blog as the current crumb), single
 * posts (Home / Blog / Category / Post title), category archives
 * (Home / Blog / Category, with the category itself as the current,
 * non-linked crumb), and author archives (Home / Blog / Author name).
 * Skips any crumb that doesn't apply.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_category    = is_category();
$is_author      = is_author();
$is_blog_index  = is_home();
$cats           = ( $is_category || $is_author || $is_blog_index ) ? array() : get_the_category();
$primary_cat    = ! empty( $cats ) ? $cats[0] : null;
$blog_page      = get_option( 'page_for_posts' );
$blog_page_name = $blog_page ? get_the_title( $blog_page ) : __( 'Blog', 'blog-hub' );
$paged          = max( (int) get_query_var( 'paged' ), 1 );
?>
<nav class="bh-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'blog-hub' ); ?>">
	<div class="bh-container">
		<ol>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'blog-hub' ); ?></a></li>
			<?php if ( $is_blog_index && $paged > 1 ) : ?>
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
					<?php if ( $primary_cat ) : ?>
						<li><span aria-hidden="true">/</span></li>
						<li><a href="<?php echo esc_url( get_category_link( $primary_cat ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a></li>
					<?php endif; ?>
					<li><span aria-hidden="true">/</span></li>
					<li aria-current="page"><?php the_title(); ?></li>
				<?php endif; ?>
			<?php endif; ?>
		</ol>
	</div>
</nav>
