<?php
/**
 * Plugin Name: SSC Landing Pages
 * Description: Product landing pages under /lp/. Every page under the "LP" page (slug "lp") is kept out of search engines (noindex, follow) and out of the XML sitemaps, and gets a "Landing Page Sections" box in the editor: one panel per section of the product page design, each optional section with its own on/off switch. The Blog Hub theme renders these pages; the SSC Blog Theme Switch plugin serves Blog Hub on /lp/ in production. Team guide: LANDING_PAGES_GUIDE.md in the project repo.
 * Version: 1.1.0
 * Author: Shubh Sanskar Concrete
 * License: GPL-2.0-or-later
 *
 * Why a plugin and not the theme: on production the active theme is Neve and
 * Blog Hub is only swapped in on some front-end URLs. wp-admin runs Neve, so
 * meta boxes registered by Blog Hub would never appear in the page editor.
 * This plugin works under any theme.
 *
 * Data: one post meta per field, "ssc_lp_<section>_<field>". List fields are
 * one item per line, columns separated by " | ".
 */

defined( 'ABSPATH' ) || exit;

const SSC_LP_PARENT_SLUG = 'lp';
const SSC_LP_SAVED_META  = '_ssc_lp_saved';

/* ========================================================================
 * Section schema — single source of truth for the editor box, saving,
 * defaults (placeholder content for new pages) and visibility.
 *
 * Section keys:
 *   label     Panel title in the editor.
 *   optional  true = has a "Show this section" switch.
 *   on        Default state of that switch for new pages.
 *   toc       Label in the "Product index" sidebar ('' = not listed).
 *   needs     Field(s) that must be filled for the section to appear.
 *   fields    key => [ label, type, default, help ]
 *             types: text, textarea, rich (textarea, links allowed),
 *                    lines (one item per line, " | " between columns),
 *                    url, image, checkbox
 * ===================================================================== */

function ssc_lp_sections() {
	return array(
		'hero'          => array(
			'label'    => '1. Hero (top of the page)',
			'optional' => false,
			'toc'      => '',
			'needs'    => array(),
			'fields'   => array(
				'eyebrow'     => array( 'Small gold line above the title', 'text', 'PRECAST CONCRETE PRODUCT', '' ),
				'title'       => array( 'Title (H1)', 'text', '', 'Leave blank to use the page title.' ),
				'intro'       => array( 'Intro text', 'textarea', '[One or two sentences: what the product is, what it is used for, where it is made.]', '' ),
				'specs'       => array( 'Key facts (grid of 4 boxes)', 'lines', "Standard | [IS code]\nClasses | [Classes or grades]\nSizes | [Size range]\nType | [Product type]", 'One per line: Label | Value. Four works best.' ),
				'image'       => array( 'Hero image', 'image', '', 'Leave blank to use the page\'s Featured image.' ),
				'image_alt'   => array( 'Hero image description (alt text)', 'text', '', 'Describe what the photo shows, e.g. "Stacked RCC pipes in the stocking yard".' ),
				'button_text' => array( 'Main button text', 'text', 'REQUEST A QUOTE', 'The button scrolls down to the enquiry form.' ),
				'hide_call'   => array( 'Hide the "Call" button', 'checkbox', '', 'The Call button uses the phone number from the site settings.' ),
				'crumb'       => array( 'Breadcrumb middle link', 'text', 'Products | /products/', 'Label | Link. Shown as Home / Products / page title. Leave blank to show Home / page title.' ),
			),
		),
		'index'         => array(
			'label'    => '2. Product index (sticky sidebar on large screens)',
			'optional' => true,
			'on'       => true,
			'toc'      => '',
			'needs'    => array(),
			'fields'   => array(
				'subtitle' => array( 'Line under "PRODUCT INDEX"', 'text', '[Product name] · [Standard]', 'The list itself is built automatically from the sections that are switched on.' ),
			),
		),
		'overview'      => array(
			'label'    => '3. Overview',
			'optional' => false,
			'toc'      => 'Overview',
			'needs'    => array( 'heading' ),
			'fields'   => array(
				'eyebrow' => array( 'Small gold label', 'text', 'OVERVIEW', '' ),
				'heading' => array( 'Heading', 'text', 'WHAT ARE [PRODUCT]?', '' ),
				'text'    => array( 'Text', 'textarea', '[A short paragraph explaining what the product is and why it is used.]', 'Leave an empty line between paragraphs.' ),
			),
		),
		'applications'  => array(
			'label'    => '4. Applications (picture cards)',
			'optional' => true,
			'on'       => true,
			'toc'      => 'Applications',
			'needs'    => array( 'items' ),
			'fields'   => array(
				'eyebrow' => array( 'Small gold label', 'text', 'APPLICATIONS', '' ),
				'heading' => array( 'Heading', 'text', 'WHERE [PRODUCT] ARE USED', '' ),
				'items'   => array( 'Cards', 'lines', "[Use 1] | [One-line description] | \n[Use 2] | [One-line description] | \n[Use 3] | [One-line description] | \n[Use 4] | [One-line description] | ", 'One card per line: Name | Description | Image URL. No image URL = grey "image needed" box.' ),
			),
		),
		'types'         => array(
			'label'    => '5. Types and applications (comparison cards)',
			'optional' => true,
			'on'       => true,
			'toc'      => 'Types & applications',
			'needs'    => array( 'items' ),
			'fields'   => array(
				'eyebrow' => array( 'Small gold label', 'text', 'TYPES', '' ),
				'heading' => array( 'Heading', 'text', 'TYPES AND APPLICATIONS', '' ),
				'intro'   => array( 'Intro text', 'textarea', 'Match the type to the load your line will carry. Confirm the final choice with your project engineer.', '' ),
				'items'   => array( 'Cards', 'lines', "[Type 1] | [LIGHT DUTY] | [Load condition] | [Use]; [Use]; [Use] | [When to choose it]\n[Type 2] | [MEDIUM DUTY] | [Load condition] | [Use]; [Use]; [Use] | [When to choose it]\n[Type 3] | [HEAVY DUTY] | [Load condition] | [Use]; [Use]; [Use] | [When to choose it]", 'One card per line: Name | Tag | Load condition | Uses separated by ; | Choose it when…' ),
			),
		),
		'classes'       => array(
			'label'    => '6. Class comparison (small table)',
			'optional' => true,
			'on'       => true,
			'toc'      => 'Class comparison',
			'needs'    => array( 'rows' ),
			'fields'   => array(
				'eyebrow' => array( 'Small gold label', 'text', 'CLASSES', '' ),
				'heading' => array( 'Heading', 'text', '[CLASS 1], [CLASS 2] AND [CLASS 3] COMPARED', '' ),
				'intro'   => array( 'Intro text', 'textarea', '[One or two sentences explaining the classes.]', '' ),
				'columns' => array( 'Column headings', 'text', 'Class | Duty level | Range', 'Separated by |' ),
				'rows'    => array( 'Rows', 'lines', "[Class 1] | [Duty] | [Range]\n[Class 2] | [Duty] | [Range]\n[Class 3] | [Duty] | [Range]", 'One row per line, same number of columns as the headings.' ),
				'note'    => array( 'Note under the table', 'rich', '', 'Optional. To add a link, put the link text in [square brackets] and the address right after it in (round brackets). Example: Need help choosing a class? [Read the guide](/blogs/choose-np2-np3-np4-rcc-hume-pipe-class/)' ),
			),
		),
		'specs'         => array(
			'label'    => '7. Technical specifications (big table)',
			'optional' => false,
			'toc'      => 'Specifications',
			'needs'    => array( 'rows' ),
			'fields'   => array(
				'eyebrow'    => array( 'Small gold label', 'text', 'TECHNICAL SPECIFICATIONS', '' ),
				'heading'    => array( 'Heading', 'text', 'SIZES AND SPECIFICATIONS', '' ),
				'note'       => array( 'Note above the table', 'text', 'Dimensions in mm. NA: not manufactured in this class.', '' ),
				'first_cols' => array( 'First column headings', 'text', 'Size (mm) | Length (mm)', 'The plain columns on the left, separated by |' ),
				'groups'     => array( 'Column groups (optional)', 'text', '[CLASS 1] | [CLASS 2]', 'Gold group headings, e.g. NP2 CLASS | NP3 CLASS | NP4 CLASS. Leave blank for a simple table.' ),
				'sub_cols'   => array( 'Columns inside each group', 'text', 'Thickness (mm) | Weight (kg)', 'Repeated under every group, separated by |' ),
				'rows'       => array( 'Rows', 'lines', "[size] | [length] | [value] | [value] | [value] | [value]\n[size] | [length] | [value] | [value] | [value] | [value]", 'One row per line. Number of values = first columns + (groups × columns inside each group).' ),
				'cta_text'   => array( 'Line next to the buttons under the table', 'text', 'Send us the size, class and quantity you need.', 'Leave blank to hide the buttons under the table.' ),
			),
		),
		'drawing'       => array(
			'label'    => '8. Technical drawing',
			'optional' => true,
			'on'       => false,
			'toc'      => 'Technical drawing',
			'needs'    => array( 'heading' ),
			'fields'   => array(
				'eyebrow' => array( 'Small gold label', 'text', 'TECHNICAL DRAWING', '' ),
				'heading' => array( 'Heading', 'text', '[PRODUCT] DIMENSIONED DRAWING', '' ),
				'image'   => array( 'Drawing image', 'image', '', 'SVG, PNG or JPG. No image = grey "drawing needed" box.' ),
				'alt'     => array( 'Drawing description (alt text)', 'text', '[Describe the drawing]', '' ),
			),
		),
		'compliance'    => array(
			'label'    => '9. Standards & compliance (dark band)',
			'optional' => true,
			'on'       => true,
			'toc'      => 'Standards & quality',
			'needs'    => array( 'rows' ),
			'fields'   => array(
				'eyebrow' => array( 'Small gold label', 'text', 'QUALITY', '' ),
				'heading' => array( 'Heading', 'text', 'STANDARDS & COMPLIANCE', '' ),
				'text'    => array( 'Text', 'textarea', '[One sentence about how quality is checked.]', '' ),
				'rows'    => array( 'Rows', 'lines', "Standard | [IS code]\nTesting | [How each lot is tested]\nTest certificates | [Available on request]", 'One per line: Label | Value' ),
			),
		),
		'manufacturing' => array(
			'label'    => '10. Manufacturing & quality testing',
			'optional' => true,
			'on'       => true,
			'toc'      => 'Manufacturing & testing',
			'needs'    => array( 'steps' ),
			'fields'   => array(
				'eyebrow'      => array( 'Small gold label', 'text', 'MANUFACTURING', '' ),
				'heading'      => array( 'Heading', 'text', 'HOW [PRODUCT] ARE MADE AND TESTED', '' ),
				'steps_title'  => array( 'Process sub-heading', 'text', 'Manufacturing process', '' ),
				'steps'        => array( 'Process steps', 'lines', "[Step title] | [What happens in this step]\n[Step title] | [What happens in this step]\n[Step title] | [What happens in this step]", 'One step per line: Title | Description. Numbered automatically.' ),
				'image'        => array( 'Photo next to the steps', 'image', '', '' ),
				'image_alt'    => array( 'Photo description (alt text)', 'text', '', '' ),
				'caption'      => array( 'Photo caption', 'text', '', '' ),
				'tests_title'  => array( 'Testing sub-heading', 'text', 'Quality testing', '' ),
				'tests_note'   => array( 'Testing note', 'text', '[Which standard the tests follow.]', '' ),
				'tests'        => array( 'Tests table', 'lines', "[Test name] | [What it checks]\n[Test name] | [What it checks]", 'One per line: Test | What it checks. Leave blank to hide the testing part.' ),
			),
		),
		'video'         => array(
			'label'    => '11. Product video',
			'optional' => true,
			'on'       => false,
			'toc'      => '',
			'needs'    => array( 'heading' ),
			'fields'   => array(
				'heading' => array( 'Heading', 'text', '[PRODUCT] VIDEO', '' ),
				'youtube' => array( 'YouTube link', 'url', '', 'e.g. https://www.youtube.com/watch?v=… The player only loads when the visitor clicks play.' ),
			),
		),
		'installation'  => array(
			'label'    => '12. Installation steps',
			'optional' => true,
			'on'       => false,
			'toc'      => 'Installation',
			'needs'    => array( 'steps' ),
			'fields'   => array(
				'eyebrow' => array( 'Small gold label', 'text', 'INSTALLATION', '' ),
				'heading' => array( 'Heading', 'text', 'INSTALLING [PRODUCT]', '' ),
				'steps'   => array( 'Steps', 'lines', "[Installation step]\n[Installation step]", 'One step per line. Numbered automatically.' ),
			),
		),
		'maintenance'   => array(
			'label'    => '13. Maintenance guide (accordion)',
			'optional' => true,
			'on'       => true,
			'toc'      => 'Maintenance',
			'needs'    => array( 'items' ),
			'fields'   => array(
				'heading' => array( 'Heading', 'text', 'MAINTENANCE GUIDE', '' ),
				'text'    => array( 'Text', 'textarea', '[One sentence introducing the maintenance tips.]', '' ),
				'items'   => array( 'Tips', 'lines', "[Tip title] | [Tip text]\n[Tip title] | [Tip text]\n[Tip title] | [Tip text]", 'One per line: Title | Text. The first one is shown open.' ),
			),
		),
		'customisation' => array(
			'label'    => '14. Custom requirement strip',
			'optional' => true,
			'on'       => true,
			'toc'      => '',
			'needs'    => array( 'heading' ),
			'fields'   => array(
				'heading'     => array( 'Heading', 'text', 'NEED A SPECIFIC REQUIREMENT?', '' ),
				'text'        => array( 'Text', 'textarea', 'If your project needs a size or specification outside the table above, share your drawing or details and our team will review what can be made.', '' ),
				'button_text' => array( 'Button text', 'text', 'DISCUSS YOUR REQUIREMENT', 'Scrolls to the enquiry form.' ),
			),
		),
		'price'         => array(
			'label'    => '15. Price information',
			'optional' => true,
			'on'       => false,
			'toc'      => '',
			'needs'    => array( 'heading' ),
			'fields'   => array(
				'eyebrow' => array( 'Small gold label', 'text', 'PRICING', '' ),
				'heading' => array( 'Heading', 'text', '[PRICE INFORMATION]', '' ),
				'text'    => array( 'Text', 'textarea', '', '' ),
				'factors' => array( 'What affects the price', 'lines', "[Price factor]\n[Price factor]", 'One per line. Leave blank to hide the list.' ),
			),
		),
		'clients'       => array(
			'label'    => '16. Client logos strip',
			'optional' => true,
			'on'       => true,
			'toc'      => '',
			'needs'    => array( 'items' ),
			'fields'   => array(
				'heading' => array( 'Label', 'text', 'TRUSTED BY CONTRACTORS AND INFRASTRUCTURE COMPANIES', '' ),
				'items'   => array( 'Logos', 'lines', "[Client name] | \n[Client name] | \n[Client name] | \n[Client name] | \n[Client name] | \n[Client name] | ", 'One per line: Client name | Logo image URL. No URL = grey box with the name.' ),
			),
		),
		'projects'      => array(
			'label'    => '17. Projects',
			'optional' => true,
			'on'       => false,
			'toc'      => '',
			'needs'    => array( 'items' ),
			'fields'   => array(
				'heading' => array( 'Heading', 'text', 'PROJECTS', '' ),
				'items'   => array( 'Projects', 'lines', '[Client] · [Project name and location] | ', 'One per line: Caption | Image URL' ),
			),
		),
		'faq'           => array(
			'label'    => '18. FAQ',
			'optional' => false,
			'toc'      => 'FAQ',
			'needs'    => array( 'items' ),
			'fields'   => array(
				'eyebrow' => array( 'Small gold label', 'text', 'FAQ', '' ),
				'heading' => array( 'Heading', 'text', 'FREQUENTLY ASKED QUESTIONS', '' ),
				'note'    => array( 'Note next to the heading', 'rich', '', 'Optional. To add a link, put the link text in [square brackets] and the address right after it in (round brackets). Example: Looking for rates? See the [price list](/blogs/hume-pipe-price-list/).' ),
				'items'   => array( 'Questions', 'lines', "[Question?] | [Answer]\n[Question?] | [Answer]\nHow do I request a quote? | Send the enquiry form below or call us.", 'One per line: Question | Answer' ),
			),
		),
		'articles'      => array(
			'label'    => '19. Related articles',
			'optional' => true,
			'on'       => false,
			'toc'      => '',
			'needs'    => array( 'items' ),
			'fields'   => array(
				'heading' => array( 'Heading', 'text', 'RELATED ARTICLES', '' ),
				'items'   => array( 'Articles', 'lines', "[Article title] | /blogs/[article-slug]/\n[Article title] | /blogs/[article-slug]/", 'One per line: Title | Link' ),
			),
		),
		'related'       => array(
			'label'    => '20. Related products (cards)',
			'optional' => true,
			'on'       => true,
			'toc'      => '',
			'needs'    => array( 'items' ),
			'fields'   => array(
				'heading' => array( 'Heading', 'text', 'RELATED PRODUCTS', '' ),
				'items'   => array( 'Products', 'lines', "[Product] | [Short description] | /[product-page]/ | | View [product]\n[Product] | [Short description] | /[product-page]/ | | View [product]", 'One per line: Name | Description | Link | Image URL | Link text' ),
			),
		),
		'areas'         => array(
			'label'    => '21. Areas served',
			'optional' => true,
			'on'       => false,
			'toc'      => '',
			'needs'    => array( 'items' ),
			'fields'   => array(
				'heading' => array( 'Heading', 'text', 'We serve customers in', '' ),
				'items'   => array( 'Areas', 'lines', "Haryana | /areas-we-serve/haryana/\nDelhi | /areas-we-serve/delhi/\nUttar Pradesh | /areas-we-serve/uttar-pradesh/", 'One per line: Name | Link' ),
			),
		),
		'enquiry'       => array(
			'label'    => '22. Enquiry / Request a quote (bottom of the page)',
			'optional' => false,
			'toc'      => 'Request a quote',
			'needs'    => array(),
			'fields'   => array(
				'eyebrow'   => array( 'Small gold label', 'text', 'ENQUIRY', '' ),
				'heading'   => array( 'Heading', 'text', 'REQUEST A QUOTE', '' ),
				'text'      => array( 'Text', 'textarea', 'Share your class, size, quantity and delivery location and our team will prepare a quotation.', 'Phone, WhatsApp, email and address are added automatically from the site settings.' ),
				'shortcode' => array( 'Form shortcode', 'text', '', 'Paste the WPForms shortcode, e.g. [wpforms id="123" title="false"].' ),
			),
		),
	);
}

/* ========================================================================
 * Which pages are landing pages
 * ===================================================================== */

/** The "LP" parent page, or null. */
function ssc_lp_parent_page() {
	static $page = false;
	if ( false === $page ) {
		$found = get_page_by_path( SSC_LP_PARENT_SLUG );
		$page  = ( $found && 'page' === $found->post_type ) ? $found : null;
	}
	return $page;
}

/** IDs of the LP parent page and every page under it. */
function ssc_lp_page_ids() {
	static $ids = null;
	if ( null !== $ids ) {
		return $ids;
	}
	$ids    = array();
	$parent = ssc_lp_parent_page();
	if ( ! $parent ) {
		return $ids;
	}
	$ids[]    = (int) $parent->ID;
	$children = get_pages(
		array(
			'child_of'    => $parent->ID,
			'post_status' => array( 'publish', 'draft', 'pending', 'private', 'future' ),
		)
	);
	foreach ( $children as $child ) {
		$ids[] = (int) $child->ID;
	}
	return $ids;
}

/** Is this post the LP page or a page under it? */
function ssc_lp_is_landing_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	return $post_id && in_array( $post_id, ssc_lp_page_ids(), true );
}

/** Is the current front-end request a landing page? */
function ssc_lp_is_current_request() {
	return is_page() && ssc_lp_is_landing_page( get_queried_object_id() );
}

/* ========================================================================
 * Reading the fields (used by the theme template)
 * ===================================================================== */

/**
 * One field's value. Pages never saved with this box yet return the
 * schema default (the placeholder content), so a brand-new landing page
 * shows the full template with [placeholders] to overwrite.
 */
function ssc_lp_field( $section, $field, $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	if ( ! get_post_meta( $post_id, SSC_LP_SAVED_META, true ) ) {
		return ssc_lp_default( $section, $field );
	}
	return (string) get_post_meta( $post_id, "ssc_lp_{$section}_{$field}", true );
}

function ssc_lp_default( $section, $field ) {
	$sections = ssc_lp_sections();
	if ( 'on' === $field ) {
		return ! empty( $sections[ $section ]['on'] ) ? '1' : '';
	}
	return isset( $sections[ $section ]['fields'][ $field ][2] ) ? (string) $sections[ $section ]['fields'][ $field ][2] : '';
}

/** A list field as rows of trimmed columns (padded to $cols). */
function ssc_lp_rows( $section, $field, $cols = 1, $post_id = 0 ) {
	$rows = array();
	foreach ( preg_split( '/\r\n|\r|\n/', ssc_lp_field( $section, $field, $post_id ) ) as $line ) {
		if ( '' === trim( $line ) ) {
			continue;
		}
		$parts = array_map( 'trim', explode( '|', $line ) );
		$rows[] = array_pad( $parts, $cols, '' );
	}
	return $rows;
}

/** A " | "-separated single-line field as an array. */
function ssc_lp_cols( $section, $field, $post_id = 0 ) {
	$value = trim( ssc_lp_field( $section, $field, $post_id ) );
	return '' === $value ? array() : array_map( 'trim', explode( '|', $value ) );
}

/** Should this section be shown? (switch on + required fields filled) */
function ssc_lp_section_on( $section, $post_id = 0 ) {
	$sections = ssc_lp_sections();
	if ( ! isset( $sections[ $section ] ) ) {
		return false;
	}
	$def = $sections[ $section ];
	if ( ! empty( $def['optional'] ) && ! ssc_lp_field( $section, 'on', $post_id ) ) {
		return false;
	}
	foreach ( $def['needs'] as $field ) {
		if ( '' === trim( ssc_lp_field( $section, $field, $post_id ) ) ) {
			return false;
		}
	}
	return true;
}

/** Allowed HTML for "rich" fields (short notes with links). */
function ssc_lp_rich_kses() {
	return array(
		'a'      => array( 'href' => true, 'target' => true, 'rel' => true ),
		'strong' => array(),
		'em'     => array(),
		'br'     => array(),
	);
}

/* ========================================================================
 * Noindex + sitemaps
 * ===================================================================== */

// Core robots meta (used when no SEO plugin takes over).
add_filter(
	'wp_robots',
	static function ( $robots ) {
		if ( ssc_lp_is_current_request() ) {
			unset( $robots['index'], $robots['max-image-preview'] );
			$robots['noindex'] = true;
			$robots['follow']  = true;
		}
		return $robots;
	},
	999
);

// Yoast SEO robots meta.
add_filter(
	'wpseo_robots',
	static function ( $robots ) {
		return ssc_lp_is_current_request() ? 'noindex, follow' : $robots;
	},
	999
);
add_filter(
	'wpseo_robots_array',
	static function ( $robots ) {
		if ( ssc_lp_is_current_request() ) {
			$robots['index']  = 'noindex';
			$robots['follow'] = 'follow';
		}
		return $robots;
	},
	999
);

// Also as an HTTP header, so caches and non-HTML fetches carry it too.
add_action(
	'template_redirect',
	static function () {
		if ( ssc_lp_is_current_request() && ! headers_sent() ) {
			header( 'X-Robots-Tag: noindex, follow', true );
		}
	}
);

// The "LP" page itself is only a folder for the landing pages: send visitors
// of /lp/ to the homepage instead of showing an empty product template.
add_action(
	'template_redirect',
	static function () {
		$parent = ssc_lp_parent_page();
		if ( $parent && is_page( $parent->ID ) && ! is_preview() ) {
			wp_safe_redirect( home_url( '/' ), 302 );
			exit;
		}
	},
	5
);

// Keep landing pages out of Yoast's sitemap…
add_filter(
	'wpseo_exclude_from_sitemap_by_post_ids',
	static function ( $ids ) {
		return array_values( array_unique( array_merge( (array) $ids, ssc_lp_page_ids() ) ) );
	}
);

// …and out of WordPress's own sitemap (wp-sitemap.xml).
add_filter(
	'wp_sitemaps_posts_query_args',
	static function ( $args, $post_type ) {
		if ( 'page' === $post_type && ssc_lp_page_ids() ) {
			$args['post__not_in'] = array_merge( isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array(), ssc_lp_page_ids() );
		}
		return $args;
	},
	10,
	2
);

/* ========================================================================
 * Editor box
 * ===================================================================== */

/** Show the box on pages under LP (not on the LP parent itself). */
function ssc_lp_box_applies( $post ) {
	$parent = ssc_lp_parent_page();
	return $parent && (int) $post->ID !== (int) $parent->ID && ( ssc_lp_is_landing_page( $post->ID ) || (int) $post->post_parent === (int) $parent->ID );
}

add_action(
	'add_meta_boxes_page',
	static function ( $post ) {
		if ( ssc_lp_box_applies( $post ) ) {
			add_meta_box( 'ssc_lp_fields', 'Landing Page Sections', 'ssc_lp_render_meta_box', 'page', 'normal', 'high' );
		}
	}
);

/*
 * Landing pages use WordPress's simple (classic) edit screen instead of the
 * block editor: there the "Landing Page Sections" box sits right under the
 * title, instead of in a collapsed "Meta Boxes" bar at the bottom of the
 * block editor where editors miss it. The main content editor is removed
 * too: the landing page design doesn't use it (all content is in the box),
 * and without it there's no "Edit with Elementor" button either.
 * A brand-new page opens in the block editor; once it's saved with Parent =
 * LP and reloaded, it switches to this screen.
 */
add_filter(
	'use_block_editor_for_post',
	static function ( $use, $post ) {
		return ( $post && 'page' === $post->post_type && ssc_lp_box_applies( $post ) ) ? false : $use;
	},
	100,
	2
);

add_action(
	'load-post.php',
	static function () {
		$post = isset( $_GET['post'] ) ? get_post( (int) $_GET['post'] ) : null; // phpcs:ignore WordPress.Security.NonceVerification -- read-only screen setup.
		if ( $post && 'page' === $post->post_type && ssc_lp_box_applies( $post ) ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}
);

add_action(
	'admin_enqueue_scripts',
	static function ( $hook ) {
		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || 'page' !== get_post_type() ) {
			return;
		}
		wp_enqueue_media();
		wp_add_inline_style( 'wp-admin', ssc_lp_admin_css() );
		wp_add_inline_script( 'jquery-core', ssc_lp_admin_js() );
	}
);

function ssc_lp_render_meta_box( $post ) {
	wp_nonce_field( 'ssc_lp_save', 'ssc_lp_nonce' );
	$is_new = ! get_post_meta( $post->ID, SSC_LP_SAVED_META, true );
	echo '<div class="ssc-lp-box">';
	echo '<p class="ssc-lp-intro">This page is a <strong>landing page</strong>: hidden from Google (noindex) and left out of the sitemap automatically. Open a section below to edit it. Optional sections have a <strong>Show this section</strong> switch. Anything in <code>[square brackets]</code> is placeholder text to replace. Lists: <strong>one item per line</strong>, columns separated by <code>|</code>.</p>';
	if ( $is_new ) {
		echo '<p class="ssc-lp-notice">New landing page: every field is pre-filled with placeholder content. Replace it, switch off what you don\'t need, then click Update / Publish.</p>';
	}
	echo '<p class="ssc-lp-intro"><strong>Why are some sections "Hidden"?</strong> Technical drawing, Video, Installation, Price, Projects, Related articles and Areas served start switched off because most products don\'t need them. To use one, open it and tick <strong>Show this section</strong>.</p>';
	foreach ( ssc_lp_sections() as $skey => $section ) {
		$on = ssc_lp_field( $skey, 'on', $post->ID );
		echo '<details class="ssc-lp-section' . ( ! empty( $section['optional'] ) && ! $on ? ' is-off' : '' ) . '">';
		echo '<summary><span class="ssc-lp-title">' . esc_html( $section['label'] ) . '</span>';
		echo '<span class="ssc-lp-badge">' . ( empty( $section['optional'] ) ? 'Always shown' : ( $on ? 'Shown' : 'Hidden' ) ) . '</span></summary>';
		echo '<div class="ssc-lp-fields">';
		if ( ! empty( $section['optional'] ) ) {
			$name = "ssc_lp_{$skey}_on";
			echo '<label class="ssc-lp-switch"><input type="checkbox" name="' . esc_attr( $name ) . '" value="1" ' . checked( '1', $on, false ) . '> <strong>Show this section</strong></label>';
		}
		foreach ( $section['fields'] as $fkey => $field ) {
			list( $label, $type, , $help ) = $field;
			$name  = "ssc_lp_{$skey}_{$fkey}";
			$value = ssc_lp_field( $skey, $fkey, $post->ID );
			echo '<div class="ssc-lp-field ssc-lp-field--' . esc_attr( $type ) . '">';
			if ( 'checkbox' === $type ) {
				echo '<label><input type="checkbox" name="' . esc_attr( $name ) . '" value="1" ' . checked( '1', $value, false ) . '> ' . esc_html( $label ) . '</label>';
			} else {
				echo '<label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label>';
				if ( in_array( $type, array( 'textarea', 'rich', 'lines' ), true ) ) {
					$rows = 'lines' === $type ? max( 3, min( 14, substr_count( $value, "\n" ) + 2 ) ) : 3;
					echo '<textarea class="widefat' . ( 'lines' === $type ? ' code' : '' ) . '" rows="' . (int) $rows . '" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $value ) . '</textarea>';
				} elseif ( 'image' === $type ) {
					echo '<span class="ssc-lp-image"><input class="widefat" type="url" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="Image URL"> <button type="button" class="button ssc-lp-pick" data-target="' . esc_attr( $name ) . '">Choose image</button></span>';
				} else {
					echo '<input class="widefat" type="' . ( 'url' === $type ? 'url' : 'text' ) . '" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
				}
			}
			if ( $help ) {
				echo '<p class="description">' . esc_html( $help ) . '</p>';
			}
			echo '</div>';
		}
		echo '</div></details>';
	}
	echo '</div>';
}

add_action(
	'save_post_page',
	static function ( $post_id ) {
		if ( ! isset( $_POST['ssc_lp_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ssc_lp_nonce'] ) ), 'ssc_lp_save' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
		foreach ( ssc_lp_sections() as $skey => $section ) {
			$fields = $section['fields'];
			if ( ! empty( $section['optional'] ) ) {
				$fields['on'] = array( '', 'checkbox', '', '' );
			}
			foreach ( $fields as $fkey => $field ) {
				$name = "ssc_lp_{$skey}_{$fkey}";
				$raw  = isset( $_POST[ $name ] ) ? wp_unslash( $_POST[ $name ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput -- sanitized per type below.
				switch ( $field[1] ) {
					case 'url':
					case 'image':
						$value = esc_url_raw( trim( $raw ) );
						break;
					case 'checkbox':
						$value = $raw ? '1' : '';
						break;
					case 'rich':
						$value = wp_kses( trim( $raw ), ssc_lp_rich_kses() );
						break;
					case 'textarea':
					case 'lines':
						$value = sanitize_textarea_field( $raw );
						break;
					default:
						$value = sanitize_text_field( $raw );
				}
				// Saved even when empty: an emptied field must stay empty, not
				// fall back to the placeholder default.
				update_post_meta( $post_id, $name, $value );
			}
		}
		update_post_meta( $post_id, SSC_LP_SAVED_META, '1' );
	}
);

/** Mark landing pages in the Pages list. */
add_filter(
	'display_post_states',
	static function ( $states, $post ) {
		if ( 'page' === $post->post_type && ssc_lp_is_landing_page( $post->ID ) ) {
			$states['ssc_lp'] = 'Landing page · noindex';
		}
		return $states;
	},
	10,
	2
);

function ssc_lp_admin_css() {
	return '
#ssc_lp_fields .inside{margin:0;padding:0 12px 12px}
.ssc-lp-intro{margin:12px 0}
.ssc-lp-notice{margin:0 0 12px;padding:10px 12px;background:#fcf9e8;border-left:4px solid #c9b379}
.ssc-lp-section{border:1px solid #dcdcde;border-radius:4px;margin:0 0 8px;background:#fff}
.ssc-lp-section>summary{cursor:pointer;padding:10px 12px;display:flex;justify-content:space-between;align-items:center;gap:12px;font-weight:600;list-style:none}
.ssc-lp-section>summary::-webkit-details-marker{display:none}
.ssc-lp-section>summary::before{content:"\25B8";margin-right:6px;color:#8c8f94}
.ssc-lp-section[open]>summary::before{content:"\25BE"}
.ssc-lp-title{flex:1}
.ssc-lp-badge{font-size:11px;font-weight:600;padding:2px 8px;border-radius:10px;background:#e7f5ea;color:#1e6b33}
.ssc-lp-section.is-off .ssc-lp-badge{background:#f0f0f1;color:#646970}
.ssc-lp-section.is-off>summary .ssc-lp-title{color:#646970}
.ssc-lp-fields{padding:4px 12px 12px;border-top:1px solid #f0f0f1}
.ssc-lp-switch{display:block;margin:10px 0 4px;padding:8px 10px;background:#f6f7f7;border-radius:4px}
.ssc-lp-field{margin-top:12px}
.ssc-lp-field>label{display:block;font-weight:600;margin-bottom:4px}
.ssc-lp-field--checkbox>label{font-weight:400}
.ssc-lp-field textarea.code{font-family:Menlo,Consolas,monospace;font-size:12px;white-space:pre;overflow-x:auto}
.ssc-lp-image{display:flex;gap:6px}
';
}

function ssc_lp_admin_js() {
	return <<<'JS'
jQuery(function ($) {
	$(document).on('click', '.ssc-lp-pick', function (e) {
		e.preventDefault();
		var target = document.getElementById($(this).data('target'));
		var frame = wp.media({ title: 'Choose image', button: { text: 'Use this image' }, multiple: false, library: { type: 'image' } });
		frame.on('select', function () {
			var a = frame.state().get('selection').first().toJSON();
			target.value = a.url;
		});
		frame.open();
	});
	$(document).on('change', '.ssc-lp-switch input', function () {
		var box = $(this).closest('.ssc-lp-section');
		box.toggleClass('is-off', !this.checked);
		box.find('.ssc-lp-badge').text(this.checked ? 'Shown' : 'Hidden');
	});
});
JS;
}
