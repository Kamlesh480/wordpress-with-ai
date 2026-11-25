<?php
/**
 * Landing pages (/lp/…) — product landing page template.
 *
 * Every page under the "LP" page renders with page-templates/template-landing.php
 * automatically — nobody has to pick a template (on production the editor runs
 * Neve, which doesn't list Blog Hub's templates). The section fields, noindex
 * and sitemap exclusion live in the "SSC Landing Pages" plugin; this file picks
 * the template, loads its CSS/JS and provides small render helpers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Is the current request a landing page? */
function blog_hub_is_landing_page() {
	if ( ! is_page() ) {
		return false;
	}
	if ( function_exists( 'ssc_lp_is_current_request' ) ) {
		return ssc_lp_is_current_request();
	}
	// Plugin missing: fall back to the URL / chosen template.
	$path = trim( (string) get_page_uri( get_queried_object_id() ), '/' );
	return 'lp' === $path || 0 === strpos( $path, 'lp/' ) || is_page_template( 'page-templates/template-landing.php' );
}

add_filter(
	'template_include',
	static function ( $template ) {
		if ( blog_hub_is_landing_page() ) {
			$landing = locate_template( 'page-templates/template-landing.php' );
			if ( $landing ) {
				return $landing;
			}
		}
		return $template;
	}
);

add_filter(
	'body_class',
	static function ( $classes ) {
		if ( blog_hub_is_landing_page() ) {
			$classes[] = 'bh-is-landing';
		}
		return $classes;
	}
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! blog_hub_is_landing_page() ) {
			return;
		}
		wp_enqueue_style( 'blog-hub-landing', get_template_directory_uri() . '/assets/css/landing.css', array( 'blog-hub-main-site' ), BLOG_HUB_VERSION );
		wp_enqueue_script( 'blog-hub-landing', get_template_directory_uri() . '/assets/js/landing.js', array(), BLOG_HUB_VERSION, true );
	},
	20
);

// Belt and braces: noindex even if the plugin is ever deactivated.
add_filter(
	'wp_robots',
	static function ( $robots ) {
		if ( ! function_exists( 'ssc_lp_is_current_request' ) && blog_hub_is_landing_page() ) {
			unset( $robots['index'] );
			$robots['noindex'] = true;
			$robots['follow']  = true;
		}
		return $robots;
	},
	999
);

/* ------------------------------------------------------------------------
 * Render helpers (thin wrappers so the template works, empty, without
 * the plugin instead of fataling)
 * --------------------------------------------------------------------- */

function blog_hub_lp( $section, $field ) {
	return function_exists( 'ssc_lp_field' ) ? ssc_lp_field( $section, $field ) : '';
}

function blog_hub_lp_on( $section ) {
	return function_exists( 'ssc_lp_section_on' ) && ssc_lp_section_on( $section );
}

function blog_hub_lp_rows( $section, $field, $cols = 1 ) {
	return function_exists( 'ssc_lp_rows' ) ? ssc_lp_rows( $section, $field, $cols ) : array();
}

function blog_hub_lp_cols( $section, $field ) {
	return function_exists( 'ssc_lp_cols' ) ? ssc_lp_cols( $section, $field ) : array();
}

/**
 * A short note that may contain links. Editors write links as
 * [link text](/page-url/); plain <a> tags (KSES'd on save) still work.
 */
function blog_hub_lp_rich( $section, $field ) {
	$value = blog_hub_lp( $section, $field );
	$value = function_exists( 'ssc_lp_rich_kses' ) ? wp_kses( $value, ssc_lp_rich_kses() ) : esc_html( $value );
	return preg_replace_callback(
		'~\[([^\]]+)\]\(([^)\s]+)\)~',
		static function ( $m ) {
			return '<a href="' . blog_hub_lp_href( $m[2] ) . '">' . esc_html( $m[1] ) . '</a>';
		},
		$value
	);
}

/** Paragraphs from a plain textarea (blank line = new paragraph). */
function blog_hub_lp_paragraphs( $text, $class = 'bh-lp-text' ) {
	foreach ( preg_split( '/\n\s*\n/', trim( $text ) ) as $para ) {
		if ( '' !== trim( $para ) ) {
			echo '<p class="' . esc_attr( $class ) . '">' . nl2br( esc_html( trim( $para ) ) ) . '</p>';
		}
	}
}

/** Section heading block: eyebrow + H2 (+ optional intro). */
function blog_hub_lp_head( $section, $id, $intro_field = '' ) {
	$eyebrow = blog_hub_lp( $section, 'eyebrow' );
	$heading = blog_hub_lp( $section, 'heading' );
	echo '<div class="bh-lp-head">';
	if ( $eyebrow ) {
		echo '<span class="bh-lp-eyebrow">' . esc_html( $eyebrow ) . '</span>';
	}
	if ( $heading ) {
		echo '<h2 id="' . esc_attr( $id ) . '-h" class="bh-lp-h2">' . esc_html( $heading ) . '</h2>';
	}
	if ( $intro_field && blog_hub_lp( $section, $intro_field ) ) {
		blog_hub_lp_paragraphs( blog_hub_lp( $section, $intro_field ), 'bh-lp-lead' );
	}
	echo '</div>';
}

/** Grey "image needed" placeholder box. */
function blog_hub_lp_image_placeholder( $label, $ratio = '4-3' ) {
	echo '<div class="bh-lp-ph bh-lp-ph--' . esc_attr( $ratio ) . '" role="img" aria-label="' . esc_attr( $label ) . '"><span><strong>' . esc_html__( 'IMAGE NEEDED', 'blog-hub' ) . '</strong>' . esc_html( $label ) . '</span></div>';
}

/** Local/relative or absolute link → safe href. */
function blog_hub_lp_href( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}
	if ( '/' === $url[0] || '#' === $url[0] ) {
		return '#' === $url[0] ? esc_attr( $url ) : esc_url( home_url( $url ) );
	}
	return esc_url( $url );
}

/** YouTube video ID from a watch / share / embed URL. */
function blog_hub_lp_youtube_id( $url ) {
	if ( preg_match( '~(?:youtu\.be/|v=|embed/|shorts/)([A-Za-z0-9_-]{11})~', (string) $url, $m ) ) {
		return $m[1];
	}
	return '';
}
