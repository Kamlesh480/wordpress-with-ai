<?php
/**
 * Main-site pages (Home / About Us / Contact Us) — custom post types for the
 * homepage's repeating content sections (Products, Applications, Client
 * logos, Testimonials), plus their Customizer fields. Kept in its own file
 * since functions.php was already large before this was added.
 *
 * Each CPT is intentionally minimal (a title, a featured image, and at most
 * two plain meta fields) — there is no business logic here, just a familiar
 * wp-admin list/edit screen so the content team can add, edit, reorder, or
 * remove items the same way they already do with blog posts.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Homepage "Our Products" grid items.
 */
function blog_hub_register_product_cpt() {
	register_post_type(
		'bh_product',
		array(
			'labels'       => array(
				'name'          => __( 'Products', 'blog-hub' ),
				'singular_name' => __( 'Product', 'blog-hub' ),
				'add_new_item'  => __( 'Add New Product', 'blog-hub' ),
				'edit_item'     => __( 'Edit Product', 'blog-hub' ),
				'menu_name'     => __( 'Products (Homepage)', 'blog-hub' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'menu_icon'    => 'dashicons-admin-generic',
			'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
			'has_archive'  => false,
			'rewrite'      => false,
		)
	);
}
add_action( 'init', 'blog_hub_register_product_cpt' );

/**
 * Homepage "Applications" flip cards.
 */
function blog_hub_register_application_cpt() {
	register_post_type(
		'bh_application',
		array(
			'labels'       => array(
				'name'          => __( 'Applications', 'blog-hub' ),
				'singular_name' => __( 'Application', 'blog-hub' ),
				'add_new_item'  => __( 'Add New Application', 'blog-hub' ),
				'edit_item'     => __( 'Edit Application', 'blog-hub' ),
				'menu_name'     => __( 'Applications (Homepage)', 'blog-hub' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'menu_icon'    => 'dashicons-admin-site-alt3',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'has_archive'  => false,
			'rewrite'      => false,
		)
	);
}
add_action( 'init', 'blog_hub_register_application_cpt' );

/**
 * Homepage "Our Clients" logo carousel items.
 */
function blog_hub_register_client_logo_cpt() {
	register_post_type(
		'bh_client_logo',
		array(
			'labels'       => array(
				'name'          => __( 'Client Logos', 'blog-hub' ),
				'singular_name' => __( 'Client Logo', 'blog-hub' ),
				'add_new_item'  => __( 'Add New Client Logo', 'blog-hub' ),
				'edit_item'     => __( 'Edit Client Logo', 'blog-hub' ),
				'menu_name'     => __( 'Client Logos (Homepage)', 'blog-hub' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'menu_icon'    => 'dashicons-businessman',
			'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
			'has_archive'  => false,
			'rewrite'      => false,
		)
	);
}
add_action( 'init', 'blog_hub_register_client_logo_cpt' );

/**
 * Homepage testimonials.
 */
function blog_hub_register_testimonial_cpt() {
	register_post_type(
		'bh_testimonial',
		array(
			'labels'       => array(
				'name'          => __( 'Testimonials', 'blog-hub' ),
				'singular_name' => __( 'Testimonial', 'blog-hub' ),
				'add_new_item'  => __( 'Add New Testimonial', 'blog-hub' ),
				'edit_item'     => __( 'Edit Testimonial', 'blog-hub' ),
				'menu_name'     => __( 'Testimonials', 'blog-hub' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => true,
			'menu_icon'    => 'dashicons-format-quote',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'has_archive'  => false,
			'rewrite'      => false,
		)
	);
}
add_action( 'init', 'blog_hub_register_testimonial_cpt' );

/**
 * Meta boxes: Product -> link URL; Application -> (uses editor for
 * description, no extra meta needed); Testimonial -> location + star rating;
 * Page -> optional page-header background image, only shown when the About
 * Us or Contact Us page template is selected (those are the only templates
 * with a full-width image hero banner).
 */
function blog_hub_main_site_meta_boxes() {
	add_meta_box(
		'blog_hub_product_link',
		__( 'Product Link', 'blog-hub' ),
		'blog_hub_render_product_link_meta_box',
		'bh_product',
		'side'
	);
	add_meta_box(
		'blog_hub_testimonial_details',
		__( 'Testimonial Details', 'blog-hub' ),
		'blog_hub_render_testimonial_meta_box',
		'bh_testimonial',
		'side'
	);

	$template = get_page_template_slug();
	if ( in_array( $template, array( 'page-templates/template-about.php', 'page-templates/template-contact.php' ), true ) ) {
		add_meta_box(
			'blog_hub_page_hero_image',
			__( 'Page Header Image', 'blog-hub' ),
			'blog_hub_render_page_hero_image_meta_box',
			'page',
			'side'
		);
	}
	if ( 'page-templates/template-about.php' === $template ) {
		add_meta_box(
			'blog_hub_about_gallery_image',
			__( '"Who We Are" Photo', 'blog-hub' ),
			'blog_hub_render_about_gallery_image_meta_box',
			'page',
			'side'
		);
	}
}
add_action( 'add_meta_boxes', 'blog_hub_main_site_meta_boxes' );

function blog_hub_render_product_link_meta_box( $post ) {
	wp_nonce_field( 'blog_hub_save_product_link', 'blog_hub_product_link_nonce' );
	$link = get_post_meta( $post->ID, 'blog_hub_product_link', true );
	?>
	<p>
		<label for="blog_hub_product_link"><?php esc_html_e( 'Where this product card links to:', 'blog-hub' ); ?></label>
		<input type="url" id="blog_hub_product_link" name="blog_hub_product_link" class="widefat"
			value="<?php echo esc_attr( $link ); ?>" placeholder="https://&hellip;">
	</p>
	<?php
}

function blog_hub_render_page_hero_image_meta_box( $post ) {
	wp_nonce_field( 'blog_hub_save_page_hero_image', 'blog_hub_page_hero_image_nonce' );
	$image_url = get_post_meta( $post->ID, 'blog_hub_page_hero_image', true );
	?>
	<p>
		<label for="blog_hub_page_hero_image"><?php esc_html_e( 'Background image URL for the dark banner at the top of this page:', 'blog-hub' ); ?></label>
		<input type="url" id="blog_hub_page_hero_image" name="blog_hub_page_hero_image" class="widefat"
			value="<?php echo esc_attr( $image_url ); ?>" placeholder="https://&hellip;">
	</p>
	<p class="description"><?php esc_html_e( 'Upload the image to the Media Library first, then paste its URL here. Leave blank for a plain navy background.', 'blog-hub' ); ?></p>
	<?php
}

function blog_hub_render_about_gallery_image_meta_box( $post ) {
	wp_nonce_field( 'blog_hub_save_about_gallery_image', 'blog_hub_about_gallery_image_nonce' );
	$image_url = get_post_meta( $post->ID, 'blog_hub_about_gallery_image', true );
	?>
	<p>
		<label for="blog_hub_about_gallery_image"><?php esc_html_e( 'Photo shown next to the "Who We Are" text:', 'blog-hub' ); ?></label>
		<input type="url" id="blog_hub_about_gallery_image" name="blog_hub_about_gallery_image" class="widefat"
			value="<?php echo esc_attr( $image_url ); ?>" placeholder="https://&hellip;">
	</p>
	<p class="description"><?php esc_html_e( 'Upload the image to the Media Library first, then paste its URL here.', 'blog-hub' ); ?></p>
	<?php
}

function blog_hub_render_testimonial_meta_box( $post ) {
	wp_nonce_field( 'blog_hub_save_testimonial_details', 'blog_hub_testimonial_details_nonce' );
	$location = get_post_meta( $post->ID, 'blog_hub_testimonial_location', true );
	$rating   = get_post_meta( $post->ID, 'blog_hub_testimonial_rating', true );
	if ( '' === $rating ) {
		$rating = 5;
	}
	?>
	<p>
		<label for="blog_hub_testimonial_location"><?php esc_html_e( 'Location (e.g. "Delhi")', 'blog-hub' ); ?></label>
		<input type="text" id="blog_hub_testimonial_location" name="blog_hub_testimonial_location" class="widefat"
			value="<?php echo esc_attr( $location ); ?>">
	</p>
	<p>
		<label for="blog_hub_testimonial_rating"><?php esc_html_e( 'Star rating (1-5)', 'blog-hub' ); ?></label>
		<input type="number" id="blog_hub_testimonial_rating" name="blog_hub_testimonial_rating" class="widefat"
			min="1" max="5" value="<?php echo esc_attr( $rating ); ?>">
	</p>
	<p class="description"><?php esc_html_e( 'Write the testimonial text itself in the main content editor above.', 'blog-hub' ); ?></p>
	<?php
}

function blog_hub_save_main_site_meta_boxes( $post_id ) {
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if (
		isset( $_POST['blog_hub_product_link_nonce'] )
		&& wp_verify_nonce( wp_unslash( $_POST['blog_hub_product_link_nonce'] ), 'blog_hub_save_product_link' )
		&& isset( $_POST['blog_hub_product_link'] )
	) {
		update_post_meta( $post_id, 'blog_hub_product_link', esc_url_raw( wp_unslash( $_POST['blog_hub_product_link'] ) ) );
	}

	if (
		isset( $_POST['blog_hub_testimonial_details_nonce'] )
		&& wp_verify_nonce( wp_unslash( $_POST['blog_hub_testimonial_details_nonce'] ), 'blog_hub_save_testimonial_details' )
	) {
		if ( isset( $_POST['blog_hub_testimonial_location'] ) ) {
			update_post_meta( $post_id, 'blog_hub_testimonial_location', sanitize_text_field( wp_unslash( $_POST['blog_hub_testimonial_location'] ) ) );
		}
		if ( isset( $_POST['blog_hub_testimonial_rating'] ) ) {
			$rating = max( 1, min( 5, (int) $_POST['blog_hub_testimonial_rating'] ) );
			update_post_meta( $post_id, 'blog_hub_testimonial_rating', $rating );
		}
	}

	if (
		isset( $_POST['blog_hub_page_hero_image_nonce'] )
		&& wp_verify_nonce( wp_unslash( $_POST['blog_hub_page_hero_image_nonce'] ), 'blog_hub_save_page_hero_image' )
		&& isset( $_POST['blog_hub_page_hero_image'] )
	) {
		update_post_meta( $post_id, 'blog_hub_page_hero_image', esc_url_raw( wp_unslash( $_POST['blog_hub_page_hero_image'] ) ) );
	}

	if (
		isset( $_POST['blog_hub_about_gallery_image_nonce'] )
		&& wp_verify_nonce( wp_unslash( $_POST['blog_hub_about_gallery_image_nonce'] ), 'blog_hub_save_about_gallery_image' )
		&& isset( $_POST['blog_hub_about_gallery_image'] )
	) {
		update_post_meta( $post_id, 'blog_hub_about_gallery_image', esc_url_raw( wp_unslash( $_POST['blog_hub_about_gallery_image'] ) ) );
	}
}
add_action( 'save_post', 'blog_hub_save_main_site_meta_boxes' );

/**
 * Customizer: homepage hero, about-teaser, "why choose us" reasons, and the
 * end-of-page CTA banner. All optional/plain text — these are short,
 * rarely-changed pieces of copy, so a CPT would be overkill here.
 */
function blog_hub_main_site_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'blog_hub_homepage',
		array(
			'title'    => __( 'Homepage', 'blog-hub' ),
			'priority' => 29,
		)
	);

	$wp_customize->add_setting( 'blog_hub_home_hero_text', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_home_hero_text',
		array(
			'label'       => __( 'Hero heading', 'blog-hub' ),
			'description' => __( 'The large heading over the homepage hero image, e.g. "Building Trust, Creating Products — Products that last as long as our vision."', 'blog-hub' ),
			'section'     => 'blog_hub_homepage',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting( 'blog_hub_home_hero_button_text', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_home_hero_button_text',
		array(
			'label'   => __( 'Hero button text', 'blog-hub' ),
			'section' => 'blog_hub_homepage',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_home_hero_button_url', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_home_hero_button_url',
		array(
			'label'   => __( 'Hero button link', 'blog-hub' ),
			'section' => 'blog_hub_homepage',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting( 'blog_hub_home_hero_image', array( 'default' => '' ) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'blog_hub_home_hero_image',
			array(
				'label'   => __( 'Hero background image', 'blog-hub' ),
				'section' => 'blog_hub_homepage',
			)
		)
	);

	$wp_customize->add_setting( 'blog_hub_home_about_text', array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
	$wp_customize->add_control(
		'blog_hub_home_about_text',
		array(
			'label'       => __( 'About Us teaser text', 'blog-hub' ),
			'description' => __( 'Short paragraph shown in the "About Us" teaser section (basic HTML links allowed).', 'blog-hub' ),
			'section'     => 'blog_hub_homepage',
			'type'        => 'textarea',
		)
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		$wp_customize->add_setting( "blog_hub_home_about_image_{$i}", array( 'default' => '' ) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"blog_hub_home_about_image_{$i}",
				array(
					/* translators: %d: gallery image number (1-4). */
					'label'   => sprintf( __( 'About Us gallery image %d', 'blog-hub' ), $i ),
					'section' => 'blog_hub_homepage',
				)
			)
		);
	}

	for ( $i = 1; $i <= 4; $i++ ) {
		$wp_customize->add_setting( "blog_hub_reason_{$i}_icon", array( 'default' => '' ) );
		$wp_customize->add_control(
			"blog_hub_reason_{$i}_icon",
			array(
				/* translators: %d: reason number (1-4). */
				'label'       => sprintf( __( 'Reason %d — icon class', 'blog-hub' ), $i ),
				'description' => __( 'A Font Awesome class, e.g. "fa-solid fa-palette".', 'blog-hub' ),
				'section'     => 'blog_hub_homepage',
				'type'        => 'text',
			)
		);
		$wp_customize->add_setting( "blog_hub_reason_{$i}_title", array( 'default' => '' ) );
		$wp_customize->add_control(
			"blog_hub_reason_{$i}_title",
			array(
				/* translators: %d: reason number (1-4). */
				'label'   => sprintf( __( 'Reason %d — title', 'blog-hub' ), $i ),
				'section' => 'blog_hub_homepage',
				'type'    => 'text',
			)
		);
		$wp_customize->add_setting( "blog_hub_reason_{$i}_text", array( 'default' => '' ) );
		$wp_customize->add_control(
			"blog_hub_reason_{$i}_text",
			array(
				/* translators: %d: reason number (1-4). */
				'label'   => sprintf( __( 'Reason %d — description', 'blog-hub' ), $i ),
				'section' => 'blog_hub_homepage',
				'type'    => 'textarea',
			)
		);
	}

	$wp_customize->add_setting( 'blog_hub_home_cta_heading', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_home_cta_heading',
		array(
			'label'       => __( 'End-of-page CTA heading', 'blog-hub' ),
			'description' => __( 'e.g. "Help us know what you want?" Leave blank to hide this banner.', 'blog-hub' ),
			'section'     => 'blog_hub_homepage',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_home_cta_button_text', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_home_cta_button_text',
		array(
			'label'   => __( 'End-of-page CTA button text', 'blog-hub' ),
			'section' => 'blog_hub_homepage',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_home_cta_button_url', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_home_cta_button_url',
		array(
			'label'   => __( 'End-of-page CTA button link', 'blog-hub' ),
			'section' => 'blog_hub_homepage',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting( 'blog_hub_home_cta_image', array( 'default' => '' ) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'blog_hub_home_cta_image',
			array(
				'label'   => __( 'End-of-page CTA background image', 'blog-hub' ),
				'section' => 'blog_hub_homepage',
			)
		)
	);
}
add_action( 'customize_register', 'blog_hub_main_site_customize_register' );

/**
 * Customizer: Contact Us page specifics — a heading for the intro copy
 * block, the WPForms shortcode for the actual form, and the office/factory
 * locations list (one per line: Label | Address | Google Maps embed URL).
 * Added to the existing "Contact Details" section rather than a new one,
 * since it's still all "how someone reaches us" content.
 */
function blog_hub_contact_page_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'blog_hub_contact_intro_heading', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_contact_intro_heading',
		array(
			'label'   => __( 'Contact page — intro heading', 'blog-hub' ),
			'section' => 'blog_hub_contact',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_contact_form_shortcode', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_contact_form_shortcode',
		array(
			'label'       => __( 'Contact form shortcode', 'blog-hub' ),
			'description' => __( 'Paste the WPForms shortcode for the contact form, e.g. [wpforms id="123"].', 'blog-hub' ),
			'section'     => 'blog_hub_contact',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting( 'blog_hub_contact_offices', array( 'default' => '' ) );
	$wp_customize->add_control(
		'blog_hub_contact_offices',
		array(
			'label'       => __( 'Office / factory locations', 'blog-hub' ),
			'description' => __( 'One per line, as: Label | Address | Google Maps embed URL. Get the embed URL from Google Maps → Share → Embed a map → copy just the src="..." value.', 'blog-hub' ),
			'section'     => 'blog_hub_contact',
			'type'        => 'textarea',
		)
	);
}
add_action( 'customize_register', 'blog_hub_contact_page_customize_register' );

/**
 * Helper: this theme's 4 "why choose us" reasons as a plain array, skipping
 * any reason left completely blank.
 */
function blog_hub_get_reasons() {
	$reasons = array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$title = get_theme_mod( "blog_hub_reason_{$i}_title", '' );
		if ( ! $title ) {
			continue;
		}
		$reasons[] = array(
			'icon'  => get_theme_mod( "blog_hub_reason_{$i}_icon", 'fa-solid fa-circle-check' ),
			'title' => $title,
			'text'  => get_theme_mod( "blog_hub_reason_{$i}_text", '' ),
		);
	}
	return $reasons;
}
