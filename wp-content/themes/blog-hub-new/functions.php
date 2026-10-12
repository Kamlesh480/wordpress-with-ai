<?php
/**
 * Blog Hub theme functions.
 *
 * Presentation only: no custom post types, no taxonomies, no database schema
 * changes. Everything here reads existing WordPress data (posts, pages,
 * categories, authors, menus) — switching away from this theme later leaves
 * the site's content fully intact.
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
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'blog-hub' ),
			'footer'  => __( 'Footer Links', 'blog-hub' ),
			'social'  => __( 'Social Links', 'blog-hub' ),
		)
	);
}
add_action( 'after_setup_theme', 'blog_hub_setup' );

/**
 * Widget areas.
 */
function blog_hub_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer Widgets', 'blog-hub' ),
			'id'            => 'footer-widgets',
			'description'   => __( 'Optional widgets shown in the footer, alongside the Links and Contact Us columns.', 'blog-hub' ),
			'before_widget' => '<div class="bh-footer__widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="bh-footer__heading">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Single Post Rail', 'blog-hub' ),
			'id'            => 'single-rail',
			'description'   => __( 'Optional widgets in the sticky sidebar on single posts, below the Table of Contents — a call-to-action, ad, or anything else.', 'blog-hub' ),
			'before_widget' => '<div class="bh-rail-cta">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="bh-rail-cta__label">',
			'after_title'   => '</span>',
		)
	);
}
add_action( 'widgets_init', 'blog_hub_widgets_init' );

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
		get_template_directory_uri() . '/assets/css/tokens.css',
		array(),
		BLOG_HUB_VERSION
	);

	wp_enqueue_style(
		'blog-hub-components',
		get_template_directory_uri() . '/assets/css/components.css',
		array( 'blog-hub-fonts', 'blog-hub-fontawesome', 'blog-hub-tokens' ),
		BLOG_HUB_VERSION
	);

	wp_enqueue_style(
		'blog-hub-article',
		get_template_directory_uri() . '/assets/css/article.css',
		array( 'blog-hub-components' ),
		BLOG_HUB_VERSION
	);

	wp_enqueue_style(
		'blog-hub-pages',
		get_template_directory_uri() . '/assets/css/pages.css',
		array( 'blog-hub-article' ),
		BLOG_HUB_VERSION
	);

	wp_enqueue_style(
		'blog-hub-style',
		get_stylesheet_uri(),
		array( 'blog-hub-pages' ),
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
 * Estimated reading time for a post, in whole minutes (min 1), based on a
 * 200 words-per-minute average reading speed. Pure presentation helper —
 * computed on the fly from existing post_content, nothing stored.
 */
function blog_hub_reading_time( $post_id ) {
	$content    = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	return max( 1, (int) ceil( $word_count / 200 ) );
}

/**
 * Build a table of contents from the H2 headings in a post's rendered content,
 * injecting an id="" on each heading so the TOC links (and CSS scroll-spy)
 * work. Reads post_content, returns a modified copy — nothing is saved back
 * to the database.
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
 * Related posts: other published posts sharing the current post's primary
 * category, most recent first, excluding the current post. Reads existing
 * category/post data only.
 */
function blog_hub_related_posts( $post_id, $count = 3 ) {
	$cats = get_the_category( $post_id );
	if ( empty( $cats ) ) {
		return array();
	}

	return get_posts(
		array(
			'category__in'        => array( $cats[0]->term_id ),
			'post__not_in'        => array( $post_id ),
			'posts_per_page'      => $count,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'ignore_sticky_posts' => true,
		)
	);
}

/**
 * Author bio line shown on the article author card. Uses WordPress's
 * built-in "Biographical Info" field (user_description) so the theme has
 * no custom schema to migrate if it's ever replaced — nothing here is
 * theme-specific user meta.
 */
function blog_hub_author_bio( $user_id ) {
	return get_the_author_meta( 'description', $user_id );
}

/**
 * Optional extra fields on the author profile page: a one-line title
 * (e.g. "Site Engineer, Quality Control"), a pull-quote, a LinkedIn URL, and
 * up to a few expertise tags. Stored as user meta — if this theme is ever
 * replaced, these fields simply go unused rather than breaking anything,
 * since nothing else in WordPress reads or depends on them.
 */
function blog_hub_author_title( $user_id ) {
	return get_user_meta( $user_id, 'blog_hub_author_title', true );
}

function blog_hub_author_quote( $user_id ) {
	return get_user_meta( $user_id, 'blog_hub_author_quote', true );
}

function blog_hub_author_linkedin( $user_id ) {
	return get_user_meta( $user_id, 'blog_hub_author_linkedin', true );
}

function blog_hub_author_expertise( $user_id ) {
	$tags = get_user_meta( $user_id, 'blog_hub_author_expertise', true );
	return $tags ? array_filter( array_map( 'trim', explode( ',', $tags ) ) ) : array();
}

/**
 * Short "at a glance" facts shown in the author sidebar (e.g. a
 * qualification, a certification, a coverage area, years of experience) —
 * one per line. Optional; the sidebar card simply shows fewer rows if unset.
 */
function blog_hub_author_highlights( $user_id ) {
	$raw = get_user_meta( $user_id, 'blog_hub_author_highlights', true );
	if ( ! $raw ) {
		return array();
	}
	return array_values( array_filter( array_map( 'trim', explode( "\n", $raw ) ) ) );
}

/**
 * Optional link for the "Request a Quote" button in the author sidebar.
 */
function blog_hub_author_cta_url( $user_id ) {
	return get_user_meta( $user_id, 'blog_hub_author_cta_url', true );
}

function blog_hub_author_profile_fields( $user ) {
	?>
	<h2><?php esc_html_e( 'Blog Hub Author Profile', 'blog-hub' ); ?></h2>
	<table class="form-table">
		<tr>
			<th><label for="blog_hub_author_title"><?php esc_html_e( 'Title', 'blog-hub' ); ?></label></th>
			<td>
				<input type="text" name="blog_hub_author_title" id="blog_hub_author_title" class="regular-text"
					value="<?php echo esc_attr( blog_hub_author_title( $user->ID ) ); ?>">
				<p class="description"><?php esc_html_e( 'e.g. "Site Engineer, Quality Control"', 'blog-hub' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="blog_hub_author_quote"><?php esc_html_e( 'Pull quote', 'blog-hub' ); ?></label></th>
			<td>
				<input type="text" name="blog_hub_author_quote" id="blog_hub_author_quote" class="regular-text"
					value="<?php echo esc_attr( blog_hub_author_quote( $user->ID ) ); ?>">
				<p class="description"><?php esc_html_e( 'An optional short quote shown on the author page.', 'blog-hub' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="blog_hub_author_linkedin"><?php esc_html_e( 'LinkedIn URL', 'blog-hub' ); ?></label></th>
			<td>
				<input type="url" name="blog_hub_author_linkedin" id="blog_hub_author_linkedin" class="regular-text"
					value="<?php echo esc_attr( blog_hub_author_linkedin( $user->ID ) ); ?>">
			</td>
		</tr>
		<tr>
			<th><label for="blog_hub_author_expertise"><?php esc_html_e( 'Expertise tags', 'blog-hub' ); ?></label></th>
			<td>
				<input type="text" name="blog_hub_author_expertise" id="blog_hub_author_expertise" class="regular-text"
					value="<?php echo esc_attr( get_user_meta( $user->ID, 'blog_hub_author_expertise', true ) ); ?>">
				<p class="description"><?php esc_html_e( 'Comma-separated, e.g. "RCC Hume Pipes, Manhole Systems, IS Code Compliance"', 'blog-hub' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="blog_hub_author_highlights"><?php esc_html_e( '"At a glance" facts', 'blog-hub' ); ?></label></th>
			<td>
				<textarea name="blog_hub_author_highlights" id="blog_hub_author_highlights" class="large-text" rows="4"><?php echo esc_textarea( get_user_meta( $user->ID, 'blog_hub_author_highlights', true ) ); ?></textarea>
				<p class="description"><?php esc_html_e( 'One short fact per line, e.g. "Diploma in Civil Engineering". Shown as a bulleted list in the author sidebar.', 'blog-hub' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="blog_hub_author_cta_url"><?php esc_html_e( '"Request a Quote" button link', 'blog-hub' ); ?></label></th>
			<td>
				<input type="url" name="blog_hub_author_cta_url" id="blog_hub_author_cta_url" class="regular-text"
					value="<?php echo esc_attr( blog_hub_author_cta_url( $user->ID ) ); ?>">
				<p class="description"><?php esc_html_e( 'Leave blank to hide the button.', 'blog-hub' ); ?></p>
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
	$fields = array( 'blog_hub_author_title', 'blog_hub_author_quote', 'blog_hub_author_expertise' );
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_user_meta( $user_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
	if ( isset( $_POST['blog_hub_author_linkedin'] ) ) {
		update_user_meta( $user_id, 'blog_hub_author_linkedin', esc_url_raw( wp_unslash( $_POST['blog_hub_author_linkedin'] ) ) );
	}
	if ( isset( $_POST['blog_hub_author_highlights'] ) ) {
		update_user_meta( $user_id, 'blog_hub_author_highlights', sanitize_textarea_field( wp_unslash( $_POST['blog_hub_author_highlights'] ) ) );
	}
	if ( isset( $_POST['blog_hub_author_cta_url'] ) ) {
		update_user_meta( $user_id, 'blog_hub_author_cta_url', esc_url_raw( wp_unslash( $_POST['blog_hub_author_cta_url'] ) ) );
	}
}
add_action( 'personal_options_update', 'blog_hub_save_author_profile_fields' );
add_action( 'edit_user_profile_update', 'blog_hub_save_author_profile_fields' );

/**
 * JSON-LD structured data (schema.org), output in wp_head. Pulls entirely
 * from existing WordPress data (site identity, posts, authors, categories,
 * theme mods) — nothing hardcoded to a specific business, and nothing is
 * stored; the graph is rebuilt fresh on every request.
 */
function blog_hub_breadcrumb_schema() {
	$items   = array();
	$blog_id = get_option( 'page_for_posts' );

	$items[] = array(
		'@type'    => 'ListItem',
		'position' => 1,
		'name'     => __( 'Home', 'blog-hub' ),
		'item'     => home_url( '/' ),
	);

	if ( is_singular( 'post' ) ) {
		if ( $blog_id ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => count( $items ) + 1,
				'name'     => get_the_title( $blog_id ),
				'item'     => get_permalink( $blog_id ),
			);
		}
		$cats = get_the_category();
		if ( ! empty( $cats ) ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => count( $items ) + 1,
				'name'     => $cats[0]->name,
				'item'     => get_category_link( $cats[0] ),
			);
		}
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => count( $items ) + 1,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	} elseif ( is_category() ) {
		if ( $blog_id ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => count( $items ) + 1,
				'name'     => get_the_title( $blog_id ),
				'item'     => get_permalink( $blog_id ),
			);
		}
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => count( $items ) + 1,
			'name'     => single_cat_title( '', false ),
			'item'     => get_category_link( get_queried_object_id() ),
		);
	} elseif ( is_author() ) {
		if ( $blog_id ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => count( $items ) + 1,
				'name'     => get_the_title( $blog_id ),
				'item'     => get_permalink( $blog_id ),
			);
		}
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => count( $items ) + 1,
			'name'     => get_the_author_meta( 'display_name', get_queried_object_id() ),
			'item'     => get_author_posts_url( get_queried_object_id() ),
		);
	} elseif ( $blog_id && is_home() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => count( $items ) + 1,
			'name'     => get_the_title( $blog_id ),
			'item'     => get_permalink( $blog_id ),
		);
	}

	if ( count( $items ) < 2 ) {
		return null;
	}

	return array(
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);
}

function blog_hub_schema_graph() {
	$graph = array();

	if ( is_front_page() || is_home() ) {
		$graph[] = array(
			'@type' => 'WebSite',
			'name'  => get_bloginfo( 'name' ),
			'url'   => home_url( '/' ),
		);

		$email = get_theme_mod( 'blog_hub_contact_email', '' );
		$org   = array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
			'url'   => home_url( '/' ),
		);
		if ( $email ) {
			$org['email'] = $email;
		}
		$graph[] = $org;
	}

	if ( is_singular( 'post' ) ) {
		global $post;
		$author_id = get_post_field( 'post_author', $post->ID );
		$graph[]   = array(
			'@type'         => 'BlogPosting',
			'headline'      => get_the_title(),
			'datePublished' => get_the_date( 'c' ),
			'dateModified'  => get_the_modified_date( 'c' ),
			'author'        => array(
				'@type' => 'Person',
				'name'  => get_the_author_meta( 'display_name', $author_id ),
			),
			'publisher'     => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
			),
		);
	}

	if ( is_category() ) {
		$graph[] = array(
			'@type' => 'CollectionPage',
			'name'  => single_cat_title( '', false ),
			'url'   => get_category_link( get_queried_object_id() ),
		);
	}

	if ( is_author() ) {
		$author_id = get_queried_object_id();
		$expertise = blog_hub_author_expertise( $author_id );
		$person    = array(
			'@type' => 'Person',
			'name'  => get_the_author_meta( 'display_name', $author_id ),
			'url'   => get_author_posts_url( $author_id ),
		);
		$title = blog_hub_author_title( $author_id );
		if ( $title ) {
			$person['jobTitle'] = $title;
		}
		if ( ! empty( $expertise ) ) {
			$person['knowsAbout'] = $expertise;
		}
		$graph[] = $person;
	}

	$breadcrumbs = blog_hub_breadcrumb_schema();
	if ( $breadcrumbs ) {
		$graph[] = $breadcrumbs;
	}

	return $graph;
}

function blog_hub_output_schema() {
	if ( is_admin() || is_search() || is_404() ) {
		return;
	}
	$graph = blog_hub_schema_graph();
	if ( empty( $graph ) ) {
		return;
	}
	echo '<script type="application/ld+json">' . wp_json_encode(
		array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		)
	) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- wp_json_encode() output is safe JSON, not HTML.
}
add_action( 'wp_head', 'blog_hub_output_schema' );

/**
 * Only allow a Google Maps <iframe> embed (the exact markup Google's own
 * "Share > Embed a map" panel outputs) — admin-only input (Customizer
 * requires manage_options already), but still worth constraining to the
 * one known-safe shape rather than accepting arbitrary HTML/script.
 */
function blog_hub_sanitize_map_embed( $input ) {
	if ( ! $input ) {
		return '';
	}
	if ( ! preg_match( '/^<iframe\s[^>]*src=["\']https:\/\/www\.google\.com\/maps\/embed[^"\']*["\'][^>]*><\/iframe>$/i', trim( $input ) ) ) {
		return '';
	}
	return wp_kses(
		$input,
		array(
			'iframe' => array(
				'src'             => true,
				'width'           => true,
				'height'          => true,
				'style'           => true,
				'allowfullscreen' => true,
				'loading'         => true,
				'referrerpolicy'  => true,
			),
		)
	);
}

/**
 * Optional site-wide contact details (top bar, footer) via the Customizer.
 * Stored as theme_mods — standard WordPress mechanism, automatically scoped
 * to whichever theme is active, nothing to migrate if this theme is removed.
 */
function blog_hub_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'blog_hub_contact',
		array(
			'title'    => __( 'Contact Details', 'blog-hub' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting( 'blog_hub_contact_email', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_contact_email',
		array(
			'label'   => __( 'Contact email', 'blog-hub' ),
			'section' => 'blog_hub_contact',
			'type'    => 'email',
		)
	);

	$wp_customize->add_setting( 'blog_hub_contact_phone', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_contact_phone',
		array(
			'label'   => __( 'Contact phone', 'blog-hub' ),
			'section' => 'blog_hub_contact',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_contact_phone_2', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_contact_phone_2',
		array(
			'label'       => __( 'Second contact phone (optional)', 'blog-hub' ),
			'description' => __( 'Shown alongside the first phone number in the top bar.', 'blog-hub' ),
			'section'     => 'blog_hub_contact',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_address', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_address',
		array(
			'label'   => __( 'Address (shown in footer)', 'blog-hub' ),
			'section' => 'blog_hub_contact',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'blog_hub_map_embed',
		array(
			'default'           => '',
			'sanitize_callback' => 'blog_hub_sanitize_map_embed',
		)
	);
	$wp_customize->add_control(
		'blog_hub_map_embed',
		array(
			'label'       => __( 'Map embed (footer "Find Us")', 'blog-hub' ),
			'description' => __( 'Paste a Google Maps embed code (the <iframe ...> from Maps\' Share > Embed a map). Leave blank to hide the "Find Us" footer column.', 'blog-hub' ),
			'section'     => 'blog_hub_contact',
			'type'        => 'textarea',
		)
	);

	// Front page hero + intro.
	$wp_customize->add_section(
		'blog_hub_front_page',
		array(
			'title'    => __( 'Front Page Hero', 'blog-hub' ),
			'priority' => 31,
		)
	);

	$wp_customize->add_setting( 'blog_hub_hero_eyebrow', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_hero_eyebrow',
		array(
			'label'   => __( 'Eyebrow text (shown above the heading)', 'blog-hub' ),
			'section' => 'blog_hub_front_page',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_hero_title', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_hero_title',
		array(
			'label'       => __( 'Heading', 'blog-hub' ),
			'description' => __( 'Defaults to the site title if left blank.', 'blog-hub' ),
			'section'     => 'blog_hub_front_page',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_hero_intro', array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control(
		'blog_hub_hero_intro',
		array(
			'label'   => __( 'Intro paragraph (basic HTML links allowed)', 'blog-hub' ),
			'section' => 'blog_hub_front_page',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting( 'blog_hub_newsletter_action', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_newsletter_action',
		array(
			'label'       => __( 'Newsletter form action URL', 'blog-hub' ),
			'description' => __( 'Where the email signup form on the front page submits to (your email service provider). Leave blank to hide the newsletter section.', 'blog-hub' ),
			'section'     => 'blog_hub_front_page',
			'type'        => 'url',
		)
	);

	$wp_customize->add_setting( 'blog_hub_links_line', array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control(
		'blog_hub_links_line',
		array(
			'label'       => __( 'Secondary links line (basic HTML links allowed)', 'blog-hub' ),
			'description' => __( 'A short line of text with links shown near the bottom of the blog listing, e.g. "Explore our products, learn about us, or contact our team." Leave blank to hide it.', 'blog-hub' ),
			'section'     => 'blog_hub_front_page',
			'type'        => 'textarea',
		)
	);

	// Blog-wide CTA banners: an inline strip (shown on the blog listing pages)
	// and a larger end-of-page CTA (shown on blog listings and single posts).
	// Both are optional — nothing renders unless a heading is set.
	$wp_customize->add_section(
		'blog_hub_cta',
		array(
			'title'    => __( 'Blog CTA Banners', 'blog-hub' ),
			'priority' => 32,
		)
	);

	$wp_customize->add_setting( 'blog_hub_inline_cta_text', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_inline_cta_text',
		array(
			'label'       => __( 'Inline banner text', 'blog-hub' ),
			'description' => __( 'A short strip shown between sections on blog listing pages, e.g. "Need a quote? Get in touch." Leave blank to hide it.', 'blog-hub' ),
			'section'     => 'blog_hub_cta',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_inline_cta_button_text', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_inline_cta_button_text',
		array(
			'label'   => __( 'Inline banner button text', 'blog-hub' ),
			'section' => 'blog_hub_cta',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_inline_cta_button_url', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_inline_cta_button_url',
		array(
			'label'   => __( 'Inline banner button link', 'blog-hub' ),
			'section' => 'blog_hub_cta',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting( 'blog_hub_end_cta_title', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_end_cta_title',
		array(
			'label'       => __( 'End-of-page CTA heading', 'blog-hub' ),
			'description' => __( 'A larger call-to-action shown at the bottom of blog pages, e.g. "Have a project to discuss?" Leave blank to hide it.', 'blog-hub' ),
			'section'     => 'blog_hub_cta',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_end_cta_text', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_end_cta_text',
		array(
			'label'   => __( 'End-of-page CTA description', 'blog-hub' ),
			'section' => 'blog_hub_cta',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting( 'blog_hub_end_cta_button_text', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_end_cta_button_text',
		array(
			'label'   => __( 'End-of-page CTA button text', 'blog-hub' ),
			'section' => 'blog_hub_cta',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_end_cta_button_url', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_end_cta_button_url',
		array(
			'label'   => __( 'End-of-page CTA button link', 'blog-hub' ),
			'section' => 'blog_hub_cta',
			'type'    => 'url',
		)
	);
}
add_action( 'customize_register', 'blog_hub_customize_register' );

/**
 * Icon-only social links menu: replaces each menu item's visible text with
 * a Font Awesome icon matched from the link's domain (facebook.com,
 * x.com/twitter.com, instagram.com, linkedin.com, youtube.com, etc.),
 * falling back to a generic link icon for anything unrecognized. The menu
 * item's title stays available to screen readers via footer.php's
 * link_before/link_after wrapper — only the visible label changes here.
 */
function blog_hub_social_menu_icon( $title, $item, $args ) {
	if ( empty( $args->theme_location ) || 'social' !== $args->theme_location ) {
		return $title;
	}

	$url  = $item->url;
	$host = strtolower( (string) wp_parse_url( $url, PHP_URL_HOST ) );

	$icon_map = array(
		'facebook.com'  => 'fa-brands fa-facebook-f',
		'x.com'         => 'fa-brands fa-x-twitter',
		'twitter.com'   => 'fa-brands fa-x-twitter',
		'instagram.com' => 'fa-brands fa-instagram',
		'linkedin.com'  => 'fa-brands fa-linkedin-in',
		'youtube.com'   => 'fa-brands fa-youtube',
		'pinterest.com' => 'fa-brands fa-pinterest-p',
		'tiktok.com'    => 'fa-brands fa-tiktok',
		'wa.me'         => 'fa-brands fa-whatsapp',
		'whatsapp.com'  => 'fa-brands fa-whatsapp',
	);

	$icon_class = 'fa-solid fa-link';
	foreach ( $icon_map as $domain => $class ) {
		if ( false !== strpos( $host, $domain ) ) {
			$icon_class = $class;
			break;
		}
	}

	// Icon stays visible; the real link text moves into a screen-reader-only
	// span (footer.php's link_before/link_after wraps icon menus generally,
	// but the social menu needs the icon itself to stay visible — handled
	// here instead so this filter only runs for the 'social' location).
	return '<i class="' . esc_attr( $icon_class ) . '" aria-hidden="true"></i><span class="screen-reader-text">' . esc_html( $title ) . '</span>';
}
add_filter( 'nav_menu_item_title', 'blog_hub_social_menu_icon', 10, 3 );
