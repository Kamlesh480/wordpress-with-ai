<?php
/**
 * Author bio card shown at the end of a single post.
 *
 * @param array $args { @type int $author_id }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$author_id = isset( $args['author_id'] ) ? (int) $args['author_id'] : get_the_author_meta( 'ID' );
$bio       = blog_hub_author_bio( $author_id );
?>
<div class="bh-author-card">
	<?php echo get_avatar( $author_id, 64, '', '', array( 'class' => 'bh-avatar bh-avatar--lg' ) ); ?>
	<div class="bh-author-card__body">
		<span class="bh-author-card__name">
			<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></a>
		</span>
		<?php if ( $bio ) : ?>
			<p><?php echo esc_html( $bio ); ?></p>
		<?php endif; ?>
	</div>
	<a class="bh-author-card__link" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
		<?php esc_html_e( 'View profile', 'blog-hub' ); ?> &rarr;
	</a>
</div>
