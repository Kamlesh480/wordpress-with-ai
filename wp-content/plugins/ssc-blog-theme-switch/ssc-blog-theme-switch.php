<?php
/**
 * Plugin Name: SSC Blog Theme Switch
 * Description: Serves the Blog Hub theme only on the blog (blog listing, blog posts, blog category/tag/author pages). Every other URL keeps the site's active theme (Neve + Elementor) untouched. Settings: Tools → Blog Theme Switch. Deactivate this plugin to put the whole site back on the active theme instantly.
 * Version: 1.2.1
 * Author: Shubh Sanskar Concrete
 * License: GPL-2.0-or-later
 *
 * How it works: WordPress reads the active theme from the `template` and
 * `stylesheet` options. For blog requests this plugin answers those reads
 * with the Blog Hub theme, so WordPress loads Blog Hub (templates, styles,
 * functions.php and its own Customizer settings, stored separately as
 * theme_mods_blog-hub). Nothing is written to the database to switch, so the
 * active theme and its settings are never changed.
 *
 * Two switches (Tools → Blog Theme Switch):
 * - "Live": visitors get Blog Hub on blog URLs. Off by default.
 * - "Edit Blog Hub" (per admin, 2 hours): that admin sees the WHOLE site and
 *   wp-admin as Blog Hub, so its Customizer settings and menu locations can be
 *   filled in before going live. Visitors are not affected.
 */

defined( 'ABSPATH' ) || exit;

const SSC_BTS_LIVE_OPTION = 'ssc_bts_live';
const SSC_BTS_EDIT_META   = 'ssc_bts_edit_until';

/**
 * Blog Hub's folder name: "blog-hub" when installed from blog-hub.zip,
 * "blog-hub-new" in the local development checkout. '' if not installed.
 */
function ssc_bts_target_theme() {
	static $target = null;
	if ( null !== $target ) {
		return $target;
	}
	$target  = '';
	$version = '0';
	$root    = WP_CONTENT_DIR . '/themes';
	// If both folders exist (local development), use the newer version.
	foreach ( array( 'blog-hub', 'blog-hub-new' ) as $slug ) {
		if ( ! file_exists( "$root/$slug/style.css" ) || ! file_exists( "$root/$slug/functions.php" ) ) {
			continue;
		}
		$data = get_file_data( "$root/$slug/style.css", array( 'Version' => 'Version' ) );
		if ( '' === $target || version_compare( (string) $data['Version'], $version, '>' ) ) {
			$target  = $slug;
			$version = (string) $data['Version'];
		}
	}
	return $target;
}

/**
 * True when the current request is a background/API request that must keep
 * the active theme (REST, AJAX, cron, XML-RPC, CLI, feeds handled by core).
 */
function ssc_bts_is_background_request() {
	if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
		return true;
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	return false !== strpos( $uri, '/wp-json/' ) || isset( $_GET['rest_route'] ) || false !== strpos( $uri, 'wp-cron.php' ) || false !== strpos( $uri, 'admin-ajax.php' );
}

/** Is the "Edit Blog Hub" mode on for the logged-in user? */
function ssc_bts_edit_mode_on() {
	if ( ! function_exists( 'wp_get_current_user' ) || ! did_action( 'plugins_loaded' ) ) {
		return false;
	}
	$user = wp_get_current_user();
	if ( ! $user || ! $user->exists() || ! user_can( $user, 'manage_options' ) ) {
		return false;
	}
	return (int) get_user_meta( $user->ID, SSC_BTS_EDIT_META, true ) > time();
}

/**
 * Is this front-end URL part of the blog?
 * Served with Blog Hub: the posts page (+ /page/N), all posts, category /
 * tag / author pages, and the whole Areas We Serve section (the
 * "areas-we-serve" page and every page under it; its location posts are
 * posts, so they are covered above). Everything else keeps the active theme.
 * (1.1.0: Areas We Serve added at the stakeholder's request, 19 Nov 2026.)
 */
function ssc_bts_is_blog_url() {
	global $wp_rewrite;
	if ( ! $wp_rewrite instanceof WP_Rewrite ) {
		return null; // Too early to tell; caller must not cache this.
	}

	$uri       = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
	$path      = (string) wp_parse_url( $uri, PHP_URL_PATH );
	$home_path = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	if ( '' !== $home_path && 0 === strpos( $path, $home_path ) ) {
		$path = substr( $path, strlen( $home_path ) );
	}
	$path = trim( $path, '/' );
	if ( '' === $path ) {
		// Previews of unpublished drafts open at /?page_id=N&preview=true (or
		// ?p=N for posts), so the address has no /lp/ or /blog/ path to match.
		// Look the post up instead (1.2.1). Published posts' previews keep
		// their normal address and are matched further down.
		return ssc_bts_is_blog_preview();
	}

	// Areas We Serve page and all its sub-pages (/areas-we-serve/delhi/ ...),
	// and the landing pages section (/lp/ and every page under it, 1.2.0).
	foreach ( array( 'areas-we-serve', 'lp' ) as $section_slug ) {
		$section_page = get_page_by_path( $section_slug );
		if ( $section_page && 'publish' === $section_page->post_status ) {
			$section_path = trim( get_page_uri( $section_page ), '/' );
			if ( $path === $section_path || 0 === strpos( $path, $section_path . '/' ) ) {
				return true;
			}
		}
	}

	// Blog listing (Settings → Reading → Posts page) and its pagination.
	$posts_page = (int) get_option( 'page_for_posts' );
	if ( $posts_page ) {
		$blog_path = trim( get_page_uri( $posts_page ), '/' );
		if ( '' !== $blog_path && preg_match( '#^' . preg_quote( $blog_path, '#' ) . '(/page/\d+)?$#', $path ) ) {
			return true;
		}
	}

	$category_base = trim( (string) get_option( 'category_base' ), '/' );
	$category_base = '' !== $category_base ? $category_base : 'category';
	$tag_base      = trim( (string) get_option( 'tag_base' ), '/' );
	$tag_base      = '' !== $tag_base ? $tag_base : 'tag';
	$author_base   = trim( (string) $wp_rewrite->author_base, '/' );

	if ( 0 === strpos( $path . '/', $category_base . '/' ) ) {
		$slugs = array_values( array_filter( explode( '/', substr( $path, strlen( $category_base ) ) ), static function ( $s ) {
			return '' !== $s && 'page' !== $s && ! ctype_digit( $s );
		} ) );
		if ( ! $slugs ) {
			return false;
		}
		return (bool) get_term_by( 'slug', end( $slugs ), 'category' );
	}
	if ( 0 === strpos( $path . '/', $tag_base . '/' ) || 0 === strpos( $path . '/', $author_base . '/' ) ) {
		return true;
	}

	// Any single post (blog posts and Areas We Serve location posts).
	$post_id = url_to_postid( home_url( '/' . $path . '/' ) );
	return $post_id && 'post' === get_post_type( $post_id );
}

/**
 * Is this a preview of a draft that Blog Hub serves once published: a blog
 * post, or a page under Areas We Serve or LP? Only for logged-in editors
 * (WordPress only shows previews to them anyway).
 */
function ssc_bts_is_blog_preview() {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only routing decision; WordPress checks preview access itself.
	if ( empty( $_GET['preview'] ) || ! function_exists( 'is_user_logged_in' ) || ! is_user_logged_in() ) {
		return false;
	}
	$id = 0;
	foreach ( array( 'preview_id', 'page_id', 'p' ) as $key ) {
		if ( ! empty( $_GET[ $key ] ) ) {
			$id = absint( $_GET[ $key ] );
			break;
		}
	}
	// phpcs:enable
	$post = $id ? get_post( $id ) : null;
	if ( ! $post || ! current_user_can( 'edit_post', $post->ID ) ) {
		return false;
	}
	if ( 'post' === $post->post_type ) {
		return true;
	}
	if ( 'page' !== $post->post_type ) {
		return false;
	}
	$ancestors = array_map( 'intval', get_post_ancestors( $post ) );
	foreach ( array( 'areas-we-serve', 'lp' ) as $section_slug ) {
		$section_page = get_page_by_path( $section_slug );
		if ( $section_page && ( (int) $section_page->ID === (int) $post->ID || in_array( (int) $section_page->ID, $ancestors, true ) ) ) {
			return true;
		}
	}
	return false;
}

/** Decide once per request whether to serve Blog Hub. */
function ssc_bts_should_switch() {
	static $decision = null;
	if ( null !== $decision ) {
		return $decision;
	}
	if ( '' === ssc_bts_target_theme() || ( defined( 'DOING_CRON' ) && DOING_CRON ) || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
		return false;
	}
	// Leave the Customizer's previews of OTHER themes alone. A preview marker
	// naming Blog Hub itself is ours (edit mode): it must not make WordPress
	// treat Blog Hub as an inactive theme, or Publish would activate it.
	$previewing = isset( $_REQUEST['customize_theme'] ) ? sanitize_key( wp_unslash( $_REQUEST['customize_theme'] ) ) : '';
	if ( '' === $previewing && isset( $_REQUEST['theme'] ) && false !== strpos( (string) ( $_SERVER['REQUEST_URI'] ?? '' ), 'customize.php' ) ) {
		$previewing = sanitize_key( wp_unslash( $_REQUEST['theme'] ) );
	}
	if ( '' !== $previewing && $previewing !== ssc_bts_target_theme() ) {
		return $decision = false;
	}
	// Edit mode covers ALL of that admin's requests, including admin-ajax and
	// REST: the Customizer saves over admin-ajax, and must save into Blog
	// Hub's settings, never the active theme's.
	if ( ssc_bts_edit_mode_on() ) {
		return $decision = true;
	}
	if ( ssc_bts_is_background_request() ) {
		if ( did_action( 'plugins_loaded' ) ) {
			$decision = false;
		}
		return false;
	}
	if ( is_admin() ) {
		// Only cache once the user is known (edit mode depends on it).
		if ( did_action( 'plugins_loaded' ) ) {
			$decision = false;
		}
		return false;
	}
	if ( ! get_option( SSC_BTS_LIVE_OPTION ) ) {
		if ( did_action( 'plugins_loaded' ) ) {
			$decision = false;
		}
		return false;
	}
	$is_blog = ssc_bts_is_blog_url();
	if ( null === $is_blog ) {
		return false;
	}
	return $decision = $is_blog;
}

function ssc_bts_filter_theme( $value ) {
	return ssc_bts_should_switch() ? ssc_bts_target_theme() : $value;
}
foreach ( array( 'pre_option_template', 'pre_option_stylesheet', 'template', 'stylesheet' ) as $ssc_bts_hook ) {
	add_filter( $ssc_bts_hook, 'ssc_bts_filter_theme', 1000 );
}
unset( $ssc_bts_hook );

/*
 * Logo isolation. WordPress mirrors the logo into one site-wide option
 * (`site_logo`) and lets it override every theme's own logo setting. Setting
 * Blog Hub's logo would therefore also give the active theme (Neve) a logo it
 * never had (new `wp-custom-logo` body class, extra logo variants). On pages
 * NOT served with Blog Hub, report the active theme's own stored logo instead.
 */
add_filter( 'theme_mod_custom_logo', static function ( $value ) {
	if ( ssc_bts_should_switch() ) {
		return $value;
	}
	$mods = get_option( 'theme_mods_' . get_option( 'stylesheet' ) );
	return ( is_array( $mods ) && ! empty( $mods['custom_logo'] ) ) ? $mods['custom_logo'] : false;
}, 20 );

/* ---------------------------------------------------------------------------
 * Safety net: while this plugin is active, Blog Hub can never become the
 * site-wide theme (that would replace the home page and every page's
 * header/footer). Deactivate this plugin first if that is ever wanted.
 * ------------------------------------------------------------------------- */

function ssc_bts_is_blog_hub_slug( $slug ) {
	return in_array( (string) $slug, array( 'blog-hub', 'blog-hub-new' ), true );
}

// 1. Themes screen "Activate" and the Customizer "Live Preview" of Blog Hub.
add_action( 'load-themes.php', static function () {
	if ( isset( $_GET['action'], $_GET['stylesheet'] ) && 'activate' === $_GET['action'] && ssc_bts_is_blog_hub_slug( sanitize_key( wp_unslash( $_GET['stylesheet'] ) ) ) ) {
		wp_die( 'Blog Hub must not be activated for the whole site while the “SSC Blog Theme Switch” plugin is active. It is already used on the blog. To edit its settings use Tools → Blog Theme Switch.', 'Blocked', array( 'back_link' => true ) );
	}
} );
add_action( 'load-customize.php', static function () {
	if ( isset( $_GET['theme'] ) && ssc_bts_is_blog_hub_slug( sanitize_key( wp_unslash( $_GET['theme'] ) ) ) && ! ssc_bts_edit_mode_on() ) {
		wp_safe_redirect( admin_url( 'tools.php?page=ssc-blog-theme-switch' ) );
		exit;
	}
} );

// 2. Last resort: refuse any write that would make Blog Hub the active theme.
foreach ( array( 'template', 'stylesheet' ) as $ssc_bts_opt ) {
	add_filter( "pre_update_option_{$ssc_bts_opt}", static function ( $new_value, $old_value, $option ) {
		if ( ! ssc_bts_is_blog_hub_slug( $new_value ) ) {
			return $new_value;
		}
		global $wpdb;
		// Keep the real stored value (get_option() is filtered by this plugin).
		$stored = $wpdb->get_var( $wpdb->prepare( "SELECT option_value FROM {$wpdb->options} WHERE option_name = %s", $option ) );
		return null !== $stored ? $stored : $old_value;
	}, 1, 3 );
}
unset( $ssc_bts_opt );

/* ---------------------------------------------------------------------------
 * Admin: Tools → Blog Theme Switch
 * ------------------------------------------------------------------------- */

add_action( 'admin_menu', static function () {
	add_management_page( 'Blog Theme Switch', 'Blog Theme Switch', 'manage_options', 'ssc-blog-theme-switch', 'ssc_bts_render_page' );
} );

add_action( 'admin_post_ssc_bts', static function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Not allowed.' );
	}
	check_admin_referer( 'ssc_bts' );
	$do   = isset( $_POST['do'] ) ? sanitize_key( $_POST['do'] ) : '';
	$user = get_current_user_id();
	$to   = admin_url( 'tools.php?page=ssc-blog-theme-switch' );
	switch ( $do ) {
		case 'live_on':
			update_option( SSC_BTS_LIVE_OPTION, 1, true );
			break;
		case 'live_off':
			update_option( SSC_BTS_LIVE_OPTION, 0, true );
			break;
		case 'edit_on':
			update_user_meta( $user, SSC_BTS_EDIT_META, time() + 2 * HOUR_IN_SECONDS );
			$to = admin_url( 'customize.php' );
			break;
		case 'edit_off':
			delete_user_meta( $user, SSC_BTS_EDIT_META );
			break;
	}
	if ( function_exists( 'rocket_clean_domain' ) && in_array( $do, array( 'live_on', 'live_off' ), true ) ) {
		rocket_clean_domain(); // WP Rocket: drop cached pages so visitors see the change.
	}
	wp_safe_redirect( $to );
	exit;
} );

// While editing, say so on every admin screen so it isn't left on by mistake.
add_action( 'admin_notices', static function () {
	if ( ssc_bts_edit_mode_on() ) {
		printf(
			'<div class="notice notice-warning"><p><strong>Blog Theme Switch:</strong> you are editing <strong>Blog Hub</strong> (only you see the site with Blog Hub right now). Do not use Appearance → Widgets in this mode. <a href="%s">Finish editing</a></p></div>',
			esc_url( admin_url( 'tools.php?page=ssc-blog-theme-switch' ) )
		);
	}
} );

function ssc_bts_render_page() {
	$target  = ssc_bts_target_theme();
	$live    = (bool) get_option( SSC_BTS_LIVE_OPTION );
	$editing = ssc_bts_edit_mode_on();
	$button  = static function ( $do, $label, $primary = false ) {
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline-block;margin-right:8px">';
		wp_nonce_field( 'ssc_bts' );
		echo '<input type="hidden" name="action" value="ssc_bts"><input type="hidden" name="do" value="' . esc_attr( $do ) . '">';
		submit_button( $label, $primary ? 'primary' : 'secondary', 'submit', false );
		echo '</form>';
	};
	echo '<div class="wrap"><h1>Blog Theme Switch</h1>';
	if ( '' === $target ) {
		echo '<div class="notice notice-error"><p>The Blog Hub theme is not installed. Upload blog-hub.zip in Appearance → Themes → Add New (do <strong>not</strong> activate it).</p></div></div>';
		return;
	}
	echo '<p>Blog Hub theme found: <code>' . esc_html( $target ) . '</code>. Active site theme: <code>' . esc_html( (string) wp_get_theme( get_option( 'stylesheet' ) )->get( 'Name' ) ) . '</code> (unchanged by this plugin).</p>';
	echo '<p>Blog URLs (served with Blog Hub when live): the posts page and its pagination, blog posts, category / tag / author pages, and the whole Areas We Serve section (page, sub-pages, location posts). Not switched: home page and all other pages.</p>';

	echo '<h2>1. Blog Hub settings</h2>';
	if ( $editing ) {
		echo '<p><strong>Editing is ON</strong> for you: wp-admin and the whole site show Blog Hub for you only. Use Appearance → Customize and Appearance → Menus (Manage Locations). <strong>Do not use Appearance → Widgets.</strong></p>';
		$button( 'edit_off', 'Finish editing', true );
	} else {
		echo '<p>Fill in Blog Hub’s own Customizer settings (logo, phones, email, map, newsletter, menus) without changing the live theme.</p>';
		$button( 'edit_on', 'Edit Blog Hub settings (opens Customizer)' );
	}

	echo '<h2>2. Live for visitors</h2>';
	echo '<p>Status: ' . ( $live ? '<strong style="color:#008a20">LIVE</strong>: visitors see Blog Hub on blog URLs.' : '<strong>Not live</strong>: visitors see the active theme everywhere.' ) . '</p>';
	$live ? $button( 'live_off', 'Turn off (whole site back to the active theme)' ) : $button( 'live_on', 'Go live on blog URLs', true );
	echo '<p class="description">Switching clears the WP Rocket cache when WP Rocket is active.</p></div>';
}

register_deactivation_hook( __FILE__, static function () {
	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}
} );
