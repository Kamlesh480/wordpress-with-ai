<?php
/**
 * Breadcrumb trail: Home / Blog / Category / Post title.
 * Used on single posts. Skips any crumb that doesn't apply.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cats        = get_the_category();
$primary_cat = ! empty( $cats ) ? $cats[0] : null;
$blog_page   = get_option( 'page_for_posts' );
?>
<nav class="bh-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'blog-hub' ); ?>">
	<div class="bh-container">
		<ol>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'blog-hub' ); ?></a></li>
			<?php if ( $blog_page ) : ?>
				<li><span aria-hidden="true">/</span></li>
				<li><a href="<?php echo esc_url( get_permalink( $blog_page ) ); ?>"><?php echo esc_html( get_the_title( $blog_page ) ); ?></a></li>
			<?php endif; ?>
			<?php if ( $primary_cat ) : ?>
				<li><span aria-hidden="true">/</span></li>
				<li><a href="<?php echo esc_url( get_category_link( $primary_cat ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a></li>
			<?php endif; ?>
			<li><span aria-hidden="true">/</span></li>
			<li aria-current="page"><?php the_title(); ?></li>
		</ol>
	</div>
</nav>
