<?php
/**
 * Unified site-wide header/footer (Nov 2026 redesign).
 *
 * The Products and Areas We Serve lists below are hardcoded on purpose: the
 * design links to live pages (shubhsanskarconcrete.com/rcc-pipes/, etc.)
 * that don't exist as WordPress pages on this site yet. Once they do, point
 * these URLs at them (or rebuild this as real WordPress menus) — until then
 * this is the single place to edit the category/area list and links.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Where the live site's Products/Areas pages are expected to eventually
 * live. Swap this for the real base once those sections exist here.
 */
function blog_hub_live_base_url() {
	return 'https://shubhsanskarconcrete.com/';
}

/**
 * Product categories for the header's "Products" mega-menu and the
 * footer's "Products" column. Matches the live site's current category
 * list — edit here when products are added/renamed.
 */
function blog_hub_header_product_categories() {
	$base = blog_hub_live_base_url();
	return array(
		array(
			'slug' => 'rcc-pipes',
			'name' => __( 'RCC Pipes', 'blog-hub' ),
			'subs' => array(
				array( 'label' => __( 'NP2 Pipes', 'blog-hub' ), 'slug' => 'np2-pipes' ),
				array( 'label' => __( 'NP3 Pipes', 'blog-hub' ), 'slug' => 'np3-pipes' ),
				array( 'label' => __( 'NP4 Pipes', 'blog-hub' ), 'slug' => 'np4-pipes' ),
			),
		),
		array( 'slug' => 'rcc-manhole-system', 'name' => __( 'RCC Manhole System', 'blog-hub' ), 'subs' => array() ),
		array( 'slug' => 'sfrc-manhole-cover', 'name' => __( 'SFRC Manhole Cover', 'blog-hub' ), 'subs' => array() ),
		array( 'slug' => 'concrete-drain-covers', 'name' => __( 'Concrete Drain Covers', 'blog-hub' ), 'subs' => array() ),
		array( 'slug' => 'cement-paver-blocks', 'name' => __( 'Cement Paver Blocks', 'blog-hub' ), 'subs' => array() ),
		array( 'slug' => 'concrete-kerb-stone', 'name' => __( 'Concrete Kerb Stone', 'blog-hub' ), 'subs' => array() ),
		array( 'slug' => 'precast-drain', 'name' => __( 'Precast Drain', 'blog-hub' ), 'subs' => array() ),
		array( 'slug' => 'concrete-road-barriers', 'name' => __( 'Concrete Road Barriers', 'blog-hub' ), 'subs' => array() ),
		array( 'slug' => 'rcc-tree-guards', 'name' => __( 'RCC Tree Guards', 'blog-hub' ), 'subs' => array() ),
		array( 'slug' => 'garden-bench', 'name' => __( 'Garden Bench', 'blog-hub' ), 'subs' => array() ),
		array( 'slug' => 'customized-products', 'name' => __( 'Customized Products', 'blog-hub' ), 'subs' => array() ),
	);
}

/**
 * Cities for the header's "Areas We Serve" dropdown and footer list.
 */
function blog_hub_header_areas() {
	return array( 'Faridabad', 'Delhi', 'Gurgaon', 'Noida', 'Ghaziabad' );
}

function blog_hub_header_area_url( $city ) {
	return blog_hub_live_base_url() . 'areas-we-serve/' . sanitize_title( $city ) . '/';
}

function blog_hub_header_products_url() {
	return blog_hub_live_base_url() . 'products/';
}

function blog_hub_header_areas_url() {
	return blog_hub_live_base_url() . 'areas-we-serve/';
}

/**
 * The top-level nav structure shared by the desktop and mobile menus. Each
 * item is either a plain link or a dropdown (Products, Areas We Serve,
 * Blog) whose body is rendered separately by blog_hub_render_header_dropdown().
 */
function blog_hub_header_nav_items() {
	$current = blog_hub_current_nav_key();

	return array(
		array( 'key' => 'home', 'label' => __( 'Home', 'blog-hub' ), 'url' => home_url( '/' ), 'has_dropdown' => false, 'current' => 'home' === $current ),
		array( 'key' => 'about', 'label' => __( 'About Us', 'blog-hub' ), 'url' => blog_hub_find_page_url( 'template-about.php' ), 'has_dropdown' => false, 'current' => 'about' === $current ),
		array( 'key' => 'products', 'label' => __( 'Products', 'blog-hub' ), 'url' => blog_hub_header_products_url(), 'has_dropdown' => true, 'current' => 'products' === $current ),
		array( 'key' => 'areas', 'label' => __( 'Areas We Serve', 'blog-hub' ), 'url' => blog_hub_header_areas_url(), 'has_dropdown' => true, 'current' => 'areas' === $current ),
		array( 'key' => 'contact', 'label' => __( 'Contact', 'blog-hub' ), 'url' => blog_hub_find_page_url( 'template-contact.php' ), 'has_dropdown' => false, 'current' => 'contact' === $current ),
		array( 'key' => 'blog', 'label' => __( 'Blog', 'blog-hub' ), 'url' => blog_hub_find_blog_url(), 'has_dropdown' => true, 'current' => 'blog' === $current ),
	);
}

/**
 * Figures out which nav item should be marked current for this request.
 * Front page -> Home; otherwise matches the page template actually in use,
 * falling back to the blog listing/single-post context.
 */
function blog_hub_current_nav_key() {
	if ( is_front_page() ) {
		return 'home';
	}
	if ( is_page_template( 'page-templates/template-about.php' ) ) {
		return 'about';
	}
	if ( is_page_template( 'page-templates/template-contact.php' ) ) {
		return 'contact';
	}
	if ( is_home() || is_singular( 'post' ) || is_category() || is_author() || is_archive() ) {
		return 'blog';
	}
	return '';
}

/**
 * Finds the first published page using a given page template, so the nav
 * can link to it without the content team having to configure a menu.
 * Returns the home URL as a harmless fallback if no such page exists yet.
 */
function blog_hub_find_page_url( $template_slug ) {
	static $cache = array();
	if ( isset( $cache[ $template_slug ] ) ) {
		return $cache[ $template_slug ];
	}
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/' . $template_slug,
			'fields'         => 'ids',
		)
	);
	$url                     = ! empty( $pages ) ? get_permalink( $pages[0] ) : home_url( '/' );
	$cache[ $template_slug ] = $url;
	return $url;
}

/**
 * The blog listing page's URL — whichever page is set as the Posts page
 * (Settings > Reading), falling back to the home URL if none is set.
 */
function blog_hub_find_blog_url() {
	$page_id = (int) get_option( 'page_for_posts' );
	return $page_id ? get_permalink( $page_id ) : home_url( '/' );
}

/**
 * Renders the dropdown panel body for a given desktop nav item key.
 */
function blog_hub_render_header_dropdown( $key ) {
	switch ( $key ) {
		case 'products':
			?>
			<div class="bh-dropdown bh-dropdown--products" id="bh-dd-products" data-bh-dropdown>
				<ul class="bh-dropdown__cats">
					<?php foreach ( blog_hub_header_product_categories() as $cat ) : ?>
						<li>
							<a href="<?php echo esc_url( blog_hub_live_base_url() . $cat['slug'] . '/' ); ?>"><?php echo esc_html( $cat['name'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				<a class="bh-dropdown__all" href="<?php echo esc_url( blog_hub_header_products_url() ); ?>">
					<?php esc_html_e( 'View All Products', 'blog-hub' ); ?>
					<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
			</div>
			<?php
			break;

		case 'areas':
			?>
			<div class="bh-dropdown bh-dropdown--areas" id="bh-dd-areas" data-bh-dropdown>
				<ul>
					<?php foreach ( blog_hub_header_areas() as $city ) : ?>
						<li><a href="<?php echo esc_url( blog_hub_header_area_url( $city ) ); ?>"><?php echo esc_html( $city ); ?></a></li>
					<?php endforeach; ?>
				</ul>
				<a class="bh-dropdown__all" href="<?php echo esc_url( blog_hub_header_areas_url() ); ?>">
					<?php esc_html_e( 'All Areas We Serve', 'blog-hub' ); ?>
					<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
			</div>
			<?php
			break;

		case 'blog':
			$recent = get_posts(
				array(
					'posts_per_page' => 4,
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);
			if ( empty( $recent ) ) {
				return;
			}
			?>
			<div class="bh-dropdown bh-dropdown--blog" id="bh-dd-blog" data-bh-dropdown>
				<span class="bh-dropdown__label"><?php esc_html_e( 'Recent Posts', 'blog-hub' ); ?></span>
				<ul>
					<?php foreach ( $recent as $post ) : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
								<?php if ( has_post_thumbnail( $post ) ) : ?>
									<?php echo get_the_post_thumbnail( $post, 'thumbnail' ); ?>
								<?php else : ?>
									<span class="bh-dropdown__thumb-empty" aria-hidden="true"><i class="fa-regular fa-image"></i></span>
								<?php endif; ?>
								<span><?php echo esc_html( get_the_title( $post ) ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
				<a class="bh-dropdown__all" href="<?php echo esc_url( blog_hub_find_blog_url() ); ?>">
					<?php esc_html_e( 'View All Blogs', 'blog-hub' ); ?>
					<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
			</div>
			<?php
			break;
	}
}

/**
 * Renders the same dropdown content for the mobile slide-in panel (plain
 * stacked links, no hover states needed).
 */
function blog_hub_render_mobile_header_dropdown( $key ) {
	switch ( $key ) {
		case 'products':
			?>
			<ul class="bh-mobile-menu__sublist" id="bh-m-dd-products" hidden>
				<?php foreach ( blog_hub_header_product_categories() as $cat ) : ?>
					<li><a href="<?php echo esc_url( blog_hub_live_base_url() . $cat['slug'] . '/' ); ?>"><?php echo esc_html( $cat['name'] ); ?></a></li>
				<?php endforeach; ?>
				<li><a class="bh-mobile-menu__sublist-all" href="<?php echo esc_url( blog_hub_header_products_url() ); ?>"><?php esc_html_e( 'View All Products', 'blog-hub' ); ?></a></li>
			</ul>
			<?php
			break;

		case 'areas':
			?>
			<ul class="bh-mobile-menu__sublist" id="bh-m-dd-areas" hidden>
				<?php foreach ( blog_hub_header_areas() as $city ) : ?>
					<li><a href="<?php echo esc_url( blog_hub_header_area_url( $city ) ); ?>"><?php echo esc_html( $city ); ?></a></li>
				<?php endforeach; ?>
				<li><a class="bh-mobile-menu__sublist-all" href="<?php echo esc_url( blog_hub_header_areas_url() ); ?>"><?php esc_html_e( 'All Areas We Serve', 'blog-hub' ); ?></a></li>
			</ul>
			<?php
			break;

		case 'blog':
			$recent = get_posts(
				array(
					'posts_per_page' => 4,
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
					'fields'         => 'ids',
				)
			);
			?>
			<ul class="bh-mobile-menu__sublist" id="bh-m-dd-blog" hidden>
				<?php foreach ( $recent as $post_id ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></li>
				<?php endforeach; ?>
				<li><a class="bh-mobile-menu__sublist-all" href="<?php echo esc_url( blog_hub_find_blog_url() ); ?>"><?php esc_html_e( 'View All Blogs', 'blog-hub' ); ?></a></li>
			</ul>
			<?php
			break;
	}
}

/**
 * Footer "Products" column — same category list as the header, flat (no
 * sub-items; those only matter in the header mega-menu).
 */
function blog_hub_footer_products() {
	$out = array();
	foreach ( array_slice( blog_hub_header_product_categories(), 0, 5 ) as $cat ) {
		$out[] = array(
			'label' => $cat['name'],
			'url'   => blog_hub_live_base_url() . $cat['slug'] . '/',
		);
	}
	return $out;
}

/**
 * Footer "From the Blog" column — the site's real categories (not the
 * hardcoded placeholder list the design mockup used), so this stays in
 * sync automatically as categories are added.
 */
function blog_hub_footer_blog_categories() {
	return get_categories(
		array(
			'number'  => 5,
			'orderby' => 'count',
			'order'   => 'DESC',
			'hide_empty' => true,
		)
	);
}
