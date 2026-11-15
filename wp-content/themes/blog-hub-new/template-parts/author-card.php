<?php
/**
 * Author bio card shown at the end of a single post: name + verified tick,
 * role line (profile "Title" plus the first "extra stat", e.g.
 * "Site Engineer, Quality Control · 13 years on site"), bio, and expertise
 * chips. Every piece except the name is optional and simply omitted if the
 * author hasn't filled it in on Users > Profile.
 *
 * @param array $args { @type int $author_id }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$author_id = isset( $args['author_id'] ) ? (int) $args['author_id'] : get_the_author_meta( 'ID' );
$bio       = blog_hub_author_bio( $author_id );
$tags      = blog_hub_author_expertise( $author_id );

$role_parts = array();
$job_title  = blog_hub_author_title( $author_id );
if ( $job_title ) {
	$role_parts[] = $job_title;
}
$stats = blog_hub_author_extra_stats( $author_id );
if ( ! empty( $stats ) ) {
	$role_parts[] = trim( $stats[0]['value'] . ' ' . strtolower( $stats[0]['label'] ) );
}
?>
<div class="bh-author-card">
	<?php echo get_avatar( $author_id, 64, '', '', array( 'class' => 'bh-avatar bh-avatar--lg' ) ); ?>
	<div class="bh-author-card__body">
		<span class="bh-author-card__name">
			<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></a>
			<i class="fa-solid fa-circle-check" aria-hidden="true"></i>
			<span class="screen-reader-text"><?php esc_html_e( 'Verified author', 'blog-hub' ); ?></span>
		</span>
		<?php if ( $role_parts ) : ?>
			<span class="bh-author-card__title"><?php echo esc_html( implode( ' · ', $role_parts ) ); ?></span>
		<?php endif; ?>
		<?php if ( $bio ) : ?>
			<p><?php echo esc_html( $bio ); ?></p>
		<?php endif; ?>
		<?php if ( $tags ) : ?>
			<div class="bh-author-card__tags">
				<?php foreach ( $tags as $tag ) : ?>
					<span class="bh-pill"><?php echo esc_html( $tag ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<a class="bh-author-card__link" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
		<?php esc_html_e( 'View profile', 'blog-hub' ); ?> &rarr;
	</a>
</div>
