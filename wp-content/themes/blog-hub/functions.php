<?php
/**
 * Blog Hub theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BLOG_HUB_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function blog_hub_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'blog-hub' ),
			'footer'  => __( 'Footer Links', 'blog-hub' ),
		)
	);
}
add_action( 'after_setup_theme', 'blog_hub_setup' );

/**
 * Enqueue styles and scripts.
 */
function blog_hub_assets() {
	wp_enqueue_style(
		'blog-hub-fonts',
		get_template_directory_uri() . '/assets/fonts/fonts.css',
		array(),
		BLOG_HUB_VERSION
	);

	wp_enqueue_style(
		'blog-hub-fontawesome',
		get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.min.css',
		array(),
		BLOG_HUB_VERSION
	);

	wp_enqueue_style(
		'blog-hub-tokens',
		get_template_directory_uri() . '/assets/tokens.css',
		array(),
		BLOG_HUB_VERSION
	);

	wp_enqueue_style(
		'blog-hub-style',
		get_template_directory_uri() . '/assets/blog-hub.css',
		array( 'blog-hub-fonts', 'blog-hub-fontawesome', 'blog-hub-tokens' ),
		BLOG_HUB_VERSION
	);

	wp_enqueue_style(
		'blog-hub-article',
		get_template_directory_uri() . '/assets/article.css',
		array( 'blog-hub-style' ),
		BLOG_HUB_VERSION
	);

	wp_enqueue_script(
		'blog-hub-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		BLOG_HUB_VERSION,
		true
	);

	if ( is_singular( 'post' ) ) {
		wp_enqueue_script(
			'blog-hub-article',
			get_template_directory_uri() . '/assets/js/article.js',
			array(),
			BLOG_HUB_VERSION,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'blog_hub_assets' );

/**
 * Register the "Blog Hub" custom category-cards helper: article count per category.
 */
function blog_hub_category_article_count( $term_id ) {
	$term = get_term( $term_id );
	if ( ! $term || is_wp_error( $term ) ) {
		return 0;
	}
	return (int) $term->count;
}

/**
 * Estimated reading time for a post, in whole minutes (min 1), based on a
 * 200 words-per-minute average reading speed.
 */
function blog_hub_reading_time( $post_id ) {
	$content    = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	return max( 1, (int) ceil( $word_count / 200 ) );
}

/**
 * Build a table of contents from the H2 headings in a post's rendered content,
 * injecting an id="" on each heading so the TOC links (and CSS scroll-spy) work.
 *
 * @return array{content: string, items: array<array{id: string, label: string}>}
 */
function blog_hub_toc_from_content( $content ) {
	$items = array();

	if ( ! preg_match_all( '/<h2[^>]*>(.*?)<\/h2>/is', $content, $matches, PREG_OFFSET_CAPTURE ) ) {
		return array(
			'content' => $content,
			'items'   => $items,
		);
	}

	$used_ids = array();
	$offset   = 0;

	foreach ( $matches[0] as $i => $match ) {
		list( $full_tag, $pos ) = $match;
		$label = wp_strip_all_tags( $matches[1][ $i ][0] );
		$slug  = sanitize_title( $label );

		$id = $slug;
		$n  = 2;
		while ( isset( $used_ids[ $id ] ) ) {
			$id = $slug . '-' . $n;
			++$n;
		}
		$used_ids[ $id ] = true;

		$items[] = array(
			'id'    => $id,
			'label' => $label,
		);

		// Inject id="" into the opening <h2> tag (only if it doesn't already have one).
		if ( false === strpos( $full_tag, ' id=' ) ) {
			$replacement = preg_replace( '/<h2/i', '<h2 id="' . esc_attr( $id ) . '"', $full_tag, 1 );
			$real_pos    = $pos + $offset;
			$content     = substr_replace( $content, $replacement, $real_pos, strlen( $full_tag ) );
			$offset     += strlen( $replacement ) - strlen( $full_tag );
		}
	}

	return array(
		'content' => $content,
		'items'   => $items,
	);
}

/**
 * The author bio fields used in the article author card: job title / years
 * of experience and up to three topic tags, stored as user meta so they can
 * be filled in per-author from wp-admin (Users > Edit User).
 */
function blog_hub_author_bio_line( $user_id ) {
	return get_user_meta( $user_id, 'blog_hub_bio_line', true );
}

function blog_hub_author_tags( $user_id ) {
	$tags = get_user_meta( $user_id, 'blog_hub_tags', true );
	return $tags ? array_filter( array_map( 'trim', explode( ',', $tags ) ) ) : array();
}

/**
 * Related posts: other published posts sharing the current post's primary
 * category, most recent first, excluding the current post.
 */
function blog_hub_related_posts( $post_id, $count = 3 ) {
	$cats = get_the_category( $post_id );
	if ( empty( $cats ) ) {
		return array();
	}

	return get_posts(
		array(
			'category__in'   => array( $cats[0]->term_id ),
			'post__not_in'   => array( $post_id ),
			'posts_per_page' => $count,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'ignore_sticky_posts' => true,
		)
	);
}

/**
 * Author bio fields on the user profile screen: a one-line title (e.g.
 * "Site Engineer, Quality Control · 13 years on site") and comma-separated
 * topic tags shown on the article author card.
 */
function blog_hub_author_profile_fields( $user ) {
	?>
	<h2><?php esc_html_e( 'Blog Hub Author Bio', 'blog-hub' ); ?></h2>
	<table class="form-table">
		<tr>
			<th><label for="blog_hub_bio_line"><?php esc_html_e( 'Bio line', 'blog-hub' ); ?></label></th>
			<td>
				<input type="text" name="blog_hub_bio_line" id="blog_hub_bio_line" class="regular-text"
					value="<?php echo esc_attr( blog_hub_author_bio_line( $user->ID ) ); ?>">
				<p class="description"><?php esc_html_e( 'e.g. "Site Engineer, Quality Control · 13 years on site"', 'blog-hub' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="blog_hub_tags"><?php esc_html_e( 'Topic tags', 'blog-hub' ); ?></label></th>
			<td>
				<input type="text" name="blog_hub_tags" id="blog_hub_tags" class="regular-text"
					value="<?php echo esc_attr( get_user_meta( $user->ID, 'blog_hub_tags', true ) ); ?>">
				<p class="description"><?php esc_html_e( 'Comma-separated, e.g. "RCC Hume Pipes, Manhole Systems, IS Code Compliance"', 'blog-hub' ); ?></p>
			</td>
		</tr>
	</table>
	<?php
}
add_action( 'show_user_profile', 'blog_hub_author_profile_fields' );
add_action( 'edit_user_profile', 'blog_hub_author_profile_fields' );

function blog_hub_save_author_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return;
	}
	if ( isset( $_POST['blog_hub_bio_line'] ) ) {
		update_user_meta( $user_id, 'blog_hub_bio_line', sanitize_text_field( wp_unslash( $_POST['blog_hub_bio_line'] ) ) );
	}
	if ( isset( $_POST['blog_hub_tags'] ) ) {
		update_user_meta( $user_id, 'blog_hub_tags', sanitize_text_field( wp_unslash( $_POST['blog_hub_tags'] ) ) );
	}
}
add_action( 'personal_options_update', 'blog_hub_save_author_profile_fields' );
add_action( 'edit_user_profile_update', 'blog_hub_save_author_profile_fields' );
