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
 * list — edit here when products are added/renamed. Each category's
 * sub-items ('subs') are NOT listed here: they are the published child
 * pages of that category's page (see blog_hub_product_subpages()), so the
 * menu never links to pages that don't exist.
 */
function blog_hub_header_product_categories() {
	$cats = array(
		array( 'slug' => 'rcc-pipes', 'name' => __( 'RCC Pipes', 'blog-hub' ) ),
		array( 'slug' => 'rcc-manhole-system', 'name' => __( 'RCC Manhole System', 'blog-hub' ) ),
		array( 'slug' => 'sfrc-manhole-cover', 'name' => __( 'SFRC Manhole Cover', 'blog-hub' ) ),
		array( 'slug' => 'concrete-drain-covers', 'name' => __( 'Concrete Drain Covers', 'blog-hub' ) ),
		array( 'slug' => 'cement-paver-blocks', 'name' => __( 'Cement Paver Blocks', 'blog-hub' ) ),
		array( 'slug' => 'concrete-kerb-stone', 'name' => __( 'Concrete Kerb Stone', 'blog-hub' ) ),
		array( 'slug' => 'precast-drain', 'name' => __( 'Precast Drain', 'blog-hub' ) ),
		array( 'slug' => 'concrete-road-barriers', 'name' => __( 'Concrete Road Barriers', 'blog-hub' ) ),
		array( 'slug' => 'rcc-tree-guards', 'name' => __( 'RCC Tree Guards', 'blog-hub' ) ),
		array( 'slug' => 'garden-bench', 'name' => __( 'Garden Bench', 'blog-hub' ) ),
		array( 'slug' => 'customized-products', 'name' => __( 'Customized Products', 'blog-hub' ) ),
	);
	foreach ( $cats as $k => $cat ) {
		$cats[ $k ]['subs'] = blog_hub_product_subpages( $cat['slug'] );
	}
	return $cats;
}

/**
 * Published child pages of a product category page (e.g. pages whose parent
 * is /rcc-pipes/), in menu order. Empty when the category page doesn't exist
 * on this site or has no published children.
 *
 * @param string $slug Category page slug.
 * @return array[] Each { label, url }.
 */
function blog_hub_product_subpages( $slug ) {
	static $cache = array();
	if ( isset( $cache[ $slug ] ) ) {
		return $cache[ $slug ];
	}
	$subs   = array();
	$parent = get_page_by_path( $slug );
	if ( $parent && 'publish' === $parent->post_status ) {
		$children = get_pages(
			array(
				'parent'      => $parent->ID,
				'post_status' => 'publish',
				'sort_column' => 'menu_order,post_title',
			)
		);
		foreach ( $children as $child ) {
			$subs[] = array(
				'label' => get_the_title( $child ),
				'url'   => get_permalink( $child ),
			);
		}
	}
	$cache[ $slug ] = $subs;
	return $subs;
}

/**
 * Cities for the header's "Areas We Serve" dropdown and footer list.
 */
/**
 * Areas We Serve links for the header dropdown, mobile menu and footer: the
 * published child pages of the "areas-we-serve" page (Delhi, Haryana, ...),
 * as [ label, url ]. Built from real pages so every link exists (a fixed city
 * list linked to /areas-we-serve/noida/ etc., which don't exist as pages, and
 * WordPress redirected those to similarly named images).
 */
function blog_hub_header_areas() {
	$areas = array();
	foreach ( blog_hub_product_subpages( 'areas-we-serve' ) as $area ) {
		$label = $area['label'];
		if ( strtolower( $label ) === $label ) {
			$label = ucwords( $label ); // e.g. a page titled "haryana".
		}
		$areas[] = array( 'label' => $label, 'url' => $area['url'] );
	}
	return $areas;
}

/** True on the Areas We Serve page, its sub-pages, and posts / categories in the "areas-we-serve" category tree. */
function blog_hub_is_areas_context() {
	$root = get_page_by_path( 'areas-we-serve' );
	if ( $root && is_page() ) {
		$id = get_queried_object_id();
		return $id === $root->ID || in_array( $root->ID, get_post_ancestors( $id ), true );
	}
	$area_cat = get_category_by_slug( 'areas-we-serve' );
	if ( ! $area_cat ) {
		return false;
	}
	if ( is_category() ) {
		$cat = get_queried_object();
		return $cat->term_id === $area_cat->term_id || cat_is_ancestor_of( $area_cat, $cat );
	}
	if ( is_singular( 'post' ) ) {
		$cats = get_the_category( get_queried_object_id() );
		foreach ( $cats as $cat ) {
			if ( $cat->term_id !== $area_cat->term_id && ! cat_is_ancestor_of( $area_cat, $cat ) ) {
				return false;
			}
		}
		return (bool) $cats;
	}
	return false;
}

function blog_hub_header_area_url( $city ) {
	return blog_hub_live_base_url() . 'areas-we-serve/' . sanitize_title( $city ) . '/';
}

/**
 * URL of a product category page, or of one of its sub-types when
 * $sub_slug is given (e.g. /rcc-pipes/np2-pipes/).
 */
function blog_hub_product_url( $slug, $sub_slug = '' ) {
	return blog_hub_live_base_url() . $slug . '/' . ( $sub_slug ? $sub_slug . '/' : '' );
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
		array( 'key' => 'products', 'label' => __( 'Products', 'blog-hub' ), 'url' => blog_hub_header_products_url(), 'has_dropdown' => true, 'current' => 'products' === $current ),
		array( 'key' => 'areas', 'label' => __( 'Areas We Serve', 'blog-hub' ), 'url' => blog_hub_header_areas_url(), 'has_dropdown' => true, 'current' => 'areas' === $current ),
		array( 'key' => 'about', 'label' => __( 'About Us', 'blog-hub' ), 'url' => blog_hub_find_page_url( 'template-about.php' ), 'has_dropdown' => false, 'current' => 'about' === $current ),
		array( 'key' => 'blog', 'label' => __( 'Blog', 'blog-hub' ), 'url' => blog_hub_find_blog_url(), 'has_dropdown' => true, 'current' => 'blog' === $current ),
		array( 'key' => 'contact', 'label' => __( 'Contact', 'blog-hub' ), 'url' => blog_hub_find_page_url( 'template-contact.php' ), 'has_dropdown' => false, 'current' => 'contact' === $current ),
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
	if ( blog_hub_is_areas_context() ) {
		return 'areas';
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
			<?php
			$bh_cats     = blog_hub_header_product_categories();
			$bh_has_subs = (bool) array_filter( wp_list_pluck( $bh_cats, 'subs' ) );
			$bh_first    = ! empty( $bh_cats[0]['subs'] );
			?>
			<div class="bh-dropdown bh-dropdown--products<?php echo $bh_first ? '' : ' is-collapsed'; ?>" id="bh-dd-products" data-bh-dropdown>
				<div class="bh-dropdown__body">
					<ul class="bh-dropdown__cats">
						<?php foreach ( $bh_cats as $i => $cat ) : ?>
							<li>
								<a class="bh-dropdown__cat<?php echo ( 0 === $i && $bh_first ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( blog_hub_product_url( $cat['slug'] ) ); ?>" data-bh-cat="<?php echo esc_attr( $cat['slug'] ); ?>">
									<span><?php echo esc_html( $cat['name'] ); ?></span>
									<?php if ( ! empty( $cat['subs'] ) ) : ?>
										<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
									<?php endif; ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php if ( $bh_has_subs ) : ?>
					<div class="bh-dropdown__subs">
						<?php foreach ( $bh_cats as $i => $cat ) : ?>
							<?php
							if ( empty( $cat['subs'] ) ) {
								continue;
							}
							?>
							<div class="bh-dropdown__subpanel" data-bh-subpanel="<?php echo esc_attr( $cat['slug'] ); ?>"<?php echo ( 0 === $i ) ? '' : ' hidden'; ?>>
								<span class="bh-dropdown__subhead"><?php echo esc_html( $cat['name'] ); ?></span>
								<ul>
									<?php foreach ( $cat['subs'] as $sub ) : ?>
										<li><a href="<?php echo esc_url( $sub['url'] ); ?>"><?php echo esc_html( $sub['label'] ); ?></a></li>
									<?php endforeach; ?>
								</ul>
								<a class="bh-dropdown__goto" href="<?php echo esc_url( blog_hub_product_url( $cat['slug'] ) ); ?>">
									<?php
									/* translators: %s: product category name */
									printf( esc_html__( 'Go to %s', 'blog-hub' ), esc_html( $cat['name'] ) );
									?>
									<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
								</a>
							</div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
				</div>
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
					<?php foreach ( blog_hub_header_areas() as $area ) : ?>
						<li><a href="<?php echo esc_url( $area['url'] ); ?>"><?php echo esc_html( $area['label'] ); ?></a></li>
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
					<li>
						<a href="<?php echo esc_url( blog_hub_product_url( $cat['slug'] ) ); ?>"><?php echo esc_html( $cat['name'] ); ?></a>
						<?php if ( ! empty( $cat['subs'] ) ) : ?>
							<ul class="bh-mobile-menu__subsub">
								<?php foreach ( $cat['subs'] as $sub ) : ?>
									<li><a href="<?php echo esc_url( $sub['url'] ); ?>"><?php echo esc_html( $sub['label'] ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
				<li><a class="bh-mobile-menu__sublist-all" href="<?php echo esc_url( blog_hub_header_products_url() ); ?>"><?php esc_html_e( 'View All Products', 'blog-hub' ); ?></a></li>
			</ul>
			<?php
			break;

		case 'areas':
			?>
			<ul class="bh-mobile-menu__sublist" id="bh-m-dd-areas" hidden>
				<?php foreach ( blog_hub_header_areas() as $area ) : ?>
					<li><a href="<?php echo esc_url( $area['url'] ); ?>"><?php echo esc_html( $area['label'] ); ?></a></li>
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
 * Footer "Company" column — fixed list matching the design, built from the
 * same page lookups as the header nav (no Appearance > Menus setup needed).
 */
function blog_hub_footer_company_links() {
	return array(
		array( 'label' => __( 'Home', 'blog-hub' ), 'url' => home_url( '/' ) ),
		array( 'label' => __( 'About Us', 'blog-hub' ), 'url' => blog_hub_find_page_url( 'template-about.php' ) ),
		array( 'label' => __( 'Areas We Serve', 'blog-hub' ), 'url' => blog_hub_header_areas_url() ),
		array( 'label' => __( 'Blog', 'blog-hub' ), 'url' => blog_hub_find_blog_url() ),
		array( 'label' => __( 'Contact', 'blog-hub' ), 'url' => blog_hub_find_page_url( 'template-contact.php' ) ),
	);
}

/**
 * Footer "From the Blog" column — the site's real categories (not the
 * hardcoded placeholder list the design mockup used), so this stays in
 * sync automatically as categories are added.
 */
function blog_hub_footer_blog_categories() {
	return blog_hub_topic_categories( 5 );
}
