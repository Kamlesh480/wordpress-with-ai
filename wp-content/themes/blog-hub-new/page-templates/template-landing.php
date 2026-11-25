<?php
/**
 * Template Name: Landing Page
 *
 * Product landing page ("Industrial product page" design, Product Page - RCC
 * Pipes v2). Used automatically for every page under /lp/ (inc/landing-pages.php).
 * All content comes from the "SSC Landing Pages" plugin's section fields;
 * optional sections render only when switched on and filled in. The site's
 * global header and footer wrap it as on every other page.
 *
 * Order: breadcrumb · hero · [main column: overview, applications, types,
 * classes, specifications, drawing, compliance, manufacturing (+testing),
 * video, installation, maintenance, customisation, price, clients, projects,
 * FAQ | sticky product index] · related articles · related products ·
 * areas served · enquiry.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$bh_phone     = get_theme_mod( 'blog_hub_contact_phone', '' );
	$bh_phone_2   = get_theme_mod( 'blog_hub_contact_phone_2', '' );
	$bh_whatsapp  = preg_replace( '/[^0-9]/', '', (string) get_theme_mod( 'blog_hub_whatsapp_number', '' ) );
	$bh_email     = get_theme_mod( 'blog_hub_contact_email', '' );
	$bh_address   = get_theme_mod( 'blog_hub_address', '' );
	$bh_tel       = static function ( $n ) {
		return 'tel:' . preg_replace( '/[^0-9+]/', '', (string) $n );
	};
	$bh_call      = $bh_phone ? $bh_phone : $bh_phone_2;
	$bh_quote_txt = blog_hub_lp( 'hero', 'button_text' ) ? blog_hub_lp( 'hero', 'button_text' ) : __( 'REQUEST A QUOTE', 'blog-hub' );
	$bh_title     = blog_hub_lp( 'hero', 'title' ) ? blog_hub_lp( 'hero', 'title' ) : get_the_title();

	// Buttons used in several sections.
	$bh_btn_quote = static function ( $text = '' ) use ( $bh_quote_txt ) {
		echo '<a class="bh-lp-btn bh-lp-btn--primary" href="#enquiry">' . esc_html( $text ? $text : $bh_quote_txt ) . '</a>';
	};
	$bh_btn_call  = static function () use ( $bh_call, $bh_tel ) {
		if ( $bh_call ) {
			echo '<a class="bh-lp-btn bh-lp-btn--outline" href="' . esc_attr( $bh_tel( $bh_call ) ) . '"><i class="fa-solid fa-phone" aria-hidden="true"></i>' . esc_html__( 'CALL', 'blog-hub' ) . '</a>';
		}
	};

	// Product index: every switched-on section with a TOC label.
	$bh_toc_ids = array(
		'overview'      => 'overview',
		'applications'  => 'applications',
		'types'         => 'types',
		'classes'       => 'classes',
		'specs'         => 'specifications',
		'drawing'       => 'drawing',
		'compliance'    => 'quality',
		'manufacturing' => 'manufacturing',
		'installation'  => 'installation',
		'maintenance'   => 'maintenance',
		'faq'           => 'faq',
	);
	$bh_toc       = array();
	$bh_sections  = function_exists( 'ssc_lp_sections' ) ? ssc_lp_sections() : array();
	foreach ( $bh_toc_ids as $bh_key => $bh_id ) {
		if ( blog_hub_lp_on( $bh_key ) && ! empty( $bh_sections[ $bh_key ]['toc'] ) ) {
			$bh_toc[ $bh_id ] = $bh_sections[ $bh_key ]['toc'];
		}
	}
	$bh_toc['enquiry'] = __( 'Request a quote', 'blog-hub' );
	$bh_show_toc       = blog_hub_lp_on( 'index' );

	// Hero image: field, else featured image.
	$bh_hero_img = blog_hub_lp( 'hero', 'image' );
	$bh_hero_alt = blog_hub_lp( 'hero', 'image_alt' );
	if ( ! $bh_hero_img && has_post_thumbnail() ) {
		$bh_hero_img = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		if ( ! $bh_hero_alt ) {
			$bh_hero_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
		}
	}
	$bh_crumb = blog_hub_lp_cols( 'hero', 'crumb' );
	?>

	<main id="main-content" class="bh-lp">

		<nav class="bh-lp-crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'blog-hub' ); ?>">
			<ol class="bh-lp-wrap">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'blog-hub' ); ?></a></li>
				<?php if ( ! empty( $bh_crumb[0] ) ) : ?>
					<li aria-hidden="true">/</li>
					<li><a href="<?php echo blog_hub_lp_href( isset( $bh_crumb[1] ) ? $bh_crumb[1] : '/' ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in helper. ?>"><?php echo esc_html( $bh_crumb[0] ); ?></a></li>
				<?php endif; ?>
				<li aria-hidden="true">/</li>
				<li aria-current="page"><?php echo esc_html( wp_strip_all_tags( $bh_title ) ); ?></li>
			</ol>
		</nav>

		<!-- 1. Hero -->
		<section class="bh-lp-hero" aria-labelledby="product-h1">
			<div class="bh-lp-wrap bh-lp-hero__grid">
				<div class="bh-lp-hero__copy">
					<div class="bh-lp-head">
						<?php if ( blog_hub_lp( 'hero', 'eyebrow' ) ) : ?>
							<span class="bh-lp-eyebrow"><?php echo esc_html( blog_hub_lp( 'hero', 'eyebrow' ) ); ?></span>
						<?php endif; ?>
						<h1 id="product-h1" class="bh-lp-h1"><?php echo esc_html( $bh_title ); ?></h1>
						<?php blog_hub_lp_paragraphs( blog_hub_lp( 'hero', 'intro' ), 'bh-lp-hero__intro' ); ?>
					</div>
					<?php $bh_specs = blog_hub_lp_rows( 'hero', 'specs', 2 ); ?>
					<?php if ( $bh_specs ) : ?>
						<dl class="bh-lp-keyspecs">
							<?php foreach ( $bh_specs as $bh_row ) : ?>
								<div><dt><?php echo esc_html( $bh_row[0] ); ?></dt><dd><?php echo esc_html( $bh_row[1] ); ?></dd></div>
							<?php endforeach; ?>
						</dl>
					<?php endif; ?>
					<div class="bh-lp-actions">
						<?php
						$bh_btn_quote();
						if ( ! blog_hub_lp( 'hero', 'hide_call' ) ) {
							$bh_btn_call();
						}
						?>
					</div>
				</div>
				<div class="bh-lp-hero__media">
					<?php if ( $bh_hero_img ) : ?>
						<img src="<?php echo esc_url( $bh_hero_img ); ?>" alt="<?php echo esc_attr( $bh_hero_alt ); ?>" width="638" height="480" fetchpriority="high">
					<?php else : ?>
						<?php blog_hub_lp_image_placeholder( __( 'Hero image: set the Featured image or the Hero image field', 'blog-hub' ) ); ?>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<div class="bh-lp-layout<?php echo $bh_show_toc ? ' has-toc' : ''; ?>">
			<div class="bh-lp-main">

				<?php if ( blog_hub_lp_on( 'overview' ) ) : ?>
					<!-- 3. Overview -->
					<section id="overview" class="bh-lp-sec" aria-labelledby="overview-h">
						<div class="bh-lp-wrap">
							<?php blog_hub_lp_head( 'overview', 'overview' ); ?>
							<div class="bh-lp-prose"><?php blog_hub_lp_paragraphs( blog_hub_lp( 'overview', 'text' ) ); ?></div>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'applications' ) ) : ?>
					<!-- 4. Applications -->
					<section id="applications" class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="applications-h">
						<div class="bh-lp-wrap">
							<?php blog_hub_lp_head( 'applications', 'applications' ); ?>
							<ul class="bh-lp-apps">
								<?php foreach ( blog_hub_lp_rows( 'applications', 'items', 3 ) as $bh_row ) : ?>
									<li class="bh-lp-app">
										<?php if ( $bh_row[2] ) : ?>
											<img src="<?php echo esc_url( $bh_row[2] ); ?>" alt="<?php echo esc_attr( $bh_row[0] ); ?>" loading="lazy">
										<?php else : ?>
											<?php blog_hub_lp_image_placeholder( $bh_row[0] ); ?>
										<?php endif; ?>
										<div class="bh-lp-app__body">
											<h3><?php echo esc_html( $bh_row[0] ); ?></h3>
											<?php if ( $bh_row[1] ) : ?>
												<p><?php echo esc_html( $bh_row[1] ); ?></p>
											<?php endif; ?>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'types' ) ) : ?>
					<!-- 5. Types and applications -->
					<section id="types" class="bh-lp-sec bh-lp-sec--rule bh-lp-sec--cream" aria-labelledby="types-h">
						<div class="bh-lp-wrap">
							<?php blog_hub_lp_head( 'types', 'types', 'intro' ); ?>
							<div class="bh-lp-types">
								<?php foreach ( blog_hub_lp_rows( 'types', 'items', 5 ) as $bh_row ) : ?>
									<article class="bh-lp-type">
										<div class="bh-lp-type__head">
											<h3><?php echo esc_html( $bh_row[0] ); ?></h3>
											<?php if ( $bh_row[1] ) : ?>
												<span><?php echo esc_html( $bh_row[1] ); ?></span>
											<?php endif; ?>
										</div>
										<?php if ( $bh_row[2] ) : ?>
											<dl class="bh-lp-type__load">
												<dt><?php esc_html_e( 'LOAD CONDITION', 'blog-hub' ); ?></dt>
												<dd><?php echo esc_html( $bh_row[2] ); ?></dd>
											</dl>
										<?php endif; ?>
										<?php $bh_uses = array_filter( array_map( 'trim', explode( ';', $bh_row[3] ) ) ); ?>
										<?php if ( $bh_uses ) : ?>
											<div class="bh-lp-type__uses">
												<span><?php esc_html_e( 'TYPICAL APPLICATIONS', 'blog-hub' ); ?></span>
												<ul class="bh-lp-checks">
													<?php foreach ( $bh_uses as $bh_use ) : ?>
														<li><i class="fa-solid fa-check" aria-hidden="true"></i><?php echo esc_html( $bh_use ); ?></li>
													<?php endforeach; ?>
												</ul>
											</div>
										<?php endif; ?>
										<?php if ( $bh_row[4] ) : ?>
											<p class="bh-lp-type__when"><strong><?php esc_html_e( 'Choose it when:', 'blog-hub' ); ?></strong> <?php echo esc_html( $bh_row[4] ); ?></p>
										<?php endif; ?>
									</article>
								<?php endforeach; ?>
							</div>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'classes' ) ) : ?>
					<!-- 6. Class comparison -->
					<?php
					$bh_cols = blog_hub_lp_cols( 'classes', 'columns' );
					$bh_rows = blog_hub_lp_rows( 'classes', 'rows', max( 1, count( $bh_cols ) ) );
					?>
					<section id="classes" class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="classes-h">
						<div class="bh-lp-wrap">
							<?php blog_hub_lp_head( 'classes', 'classes', 'intro' ); ?>
							<div class="bh-lp-table-scroll">
								<table class="bh-lp-table">
									<?php if ( $bh_cols ) : ?>
										<thead><tr>
											<?php foreach ( $bh_cols as $bh_col ) : ?>
												<th scope="col"><?php echo esc_html( $bh_col ); ?></th>
											<?php endforeach; ?>
										</tr></thead>
									<?php endif; ?>
									<tbody>
										<?php foreach ( $bh_rows as $bh_row ) : ?>
											<tr>
												<?php foreach ( $bh_row as $bh_i => $bh_cell ) : ?>
													<?php if ( 0 === $bh_i ) : ?>
														<th scope="row"><?php echo esc_html( $bh_cell ); ?></th>
													<?php else : ?>
														<td><?php echo esc_html( $bh_cell ); ?></td>
													<?php endif; ?>
												<?php endforeach; ?>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<?php if ( blog_hub_lp( 'classes', 'note' ) ) : ?>
								<p class="bh-lp-note"><?php echo blog_hub_lp_rich( 'classes', 'note' ); // phpcs:ignore WordPress.Security.EscapeOutput -- KSES'd. ?></p>
							<?php endif; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'specs' ) ) : ?>
					<!-- 7. Technical specifications -->
					<?php
					$bh_first  = blog_hub_lp_cols( 'specs', 'first_cols' );
					$bh_groups = blog_hub_lp_cols( 'specs', 'groups' );
					$bh_subs   = $bh_groups ? blog_hub_lp_cols( 'specs', 'sub_cols' ) : array();
					$bh_ncols  = count( $bh_first ) + count( $bh_groups ) * max( 1, count( $bh_subs ) );
					$bh_rows   = blog_hub_lp_rows( 'specs', 'rows', max( 1, $bh_ncols ) );
					$bh_nfirst = max( 1, count( $bh_first ) );
					$bh_nsub   = max( 1, count( $bh_subs ) );
					?>
					<section id="specifications" class="bh-lp-sec bh-lp-sec--rule bh-lp-sec--tint" aria-labelledby="specifications-h">
						<div class="bh-lp-wrap">
							<?php blog_hub_lp_head( 'specs', 'specifications' ); ?>
							<?php if ( blog_hub_lp( 'specs', 'note' ) ) : ?>
								<p class="bh-lp-small"><?php echo esc_html( blog_hub_lp( 'specs', 'note' ) ); ?></p>
							<?php endif; ?>
							<div class="bh-lp-spec" tabindex="0" role="region" aria-label="<?php echo esc_attr( blog_hub_lp( 'specs', 'heading' ) ); ?>">
								<table class="bh-lp-spec__table<?php echo $bh_groups ? ' has-groups' : ''; ?>">
									<thead>
										<?php if ( $bh_groups ) : ?>
											<tr>
												<?php foreach ( $bh_first as $bh_i => $bh_col ) : ?>
													<th scope="col" rowspan="2" class="<?php echo 0 === $bh_i ? 'is-first' : ''; ?>"><?php echo esc_html( $bh_col ); ?></th>
												<?php endforeach; ?>
												<?php foreach ( $bh_groups as $bh_col ) : ?>
													<th scope="colgroup" colspan="<?php echo (int) $bh_nsub; ?>" class="is-group"><?php echo esc_html( $bh_col ); ?></th>
												<?php endforeach; ?>
											</tr>
											<tr class="is-sub">
												<?php foreach ( $bh_groups as $bh_g ) : ?>
													<?php foreach ( $bh_subs as $bh_j => $bh_col ) : ?>
														<th scope="col" class="is-num<?php echo 0 === $bh_j ? ' is-start' : ''; ?>"><?php echo esc_html( $bh_col ); ?></th>
													<?php endforeach; ?>
												<?php endforeach; ?>
											</tr>
										<?php else : ?>
											<tr>
												<?php foreach ( $bh_first as $bh_i => $bh_col ) : ?>
													<th scope="col" class="<?php echo 0 === $bh_i ? 'is-first' : ''; ?>"><?php echo esc_html( $bh_col ); ?></th>
												<?php endforeach; ?>
											</tr>
										<?php endif; ?>
									</thead>
									<tbody>
										<?php foreach ( $bh_rows as $bh_row ) : ?>
											<tr>
												<?php foreach ( $bh_row as $bh_i => $bh_cell ) : ?>
													<?php
													if ( 0 === $bh_i ) {
														echo '<th scope="row" class="is-first">' . esc_html( $bh_cell ) . '</th>';
														continue;
													}
													$bh_cls = array();
													if ( $bh_groups && $bh_i >= $bh_nfirst ) {
														$bh_cls[] = 'is-num';
														if ( 0 === ( $bh_i - $bh_nfirst ) % $bh_nsub ) {
															$bh_cls[] = 'is-start';
														}
													}
													if ( 'NA' === strtoupper( $bh_cell ) ) {
														$bh_cls[] = 'is-na';
													}
													echo '<td class="' . esc_attr( implode( ' ', $bh_cls ) ) . '">' . esc_html( $bh_cell ) . '</td>';
													?>
												<?php endforeach; ?>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<?php if ( blog_hub_lp( 'specs', 'cta_text' ) ) : ?>
								<div class="bh-lp-cta-row">
									<p><?php echo esc_html( blog_hub_lp( 'specs', 'cta_text' ) ); ?></p>
									<div class="bh-lp-actions"><?php $bh_btn_quote(); $bh_btn_call(); ?></div>
								</div>
							<?php endif; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'drawing' ) ) : ?>
					<!-- 8. Technical drawing -->
					<section id="drawing" class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="drawing-h">
						<div class="bh-lp-wrap">
							<?php blog_hub_lp_head( 'drawing', 'drawing' ); ?>
							<?php if ( blog_hub_lp( 'drawing', 'image' ) ) : ?>
								<img class="bh-lp-drawing" src="<?php echo esc_url( blog_hub_lp( 'drawing', 'image' ) ); ?>" alt="<?php echo esc_attr( blog_hub_lp( 'drawing', 'alt' ) ); ?>" loading="lazy">
							<?php else : ?>
								<?php blog_hub_lp_image_placeholder( __( 'Technical drawing', 'blog-hub' ), '16-9' ); ?>
							<?php endif; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'compliance' ) ) : ?>
					<!-- 9. Standards & compliance -->
					<section id="quality" class="bh-lp-sec bh-lp-sec--dark" aria-labelledby="quality-h">
						<div class="bh-lp-wrap bh-lp-split">
							<div class="bh-lp-split__a">
								<?php blog_hub_lp_head( 'compliance', 'quality', 'text' ); ?>
							</div>
							<dl class="bh-lp-split__b bh-lp-deflist">
								<?php foreach ( blog_hub_lp_rows( 'compliance', 'rows', 2 ) as $bh_row ) : ?>
									<div><dt><?php echo esc_html( $bh_row[0] ); ?></dt><dd><?php echo esc_html( $bh_row[1] ); ?></dd></div>
								<?php endforeach; ?>
							</dl>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'manufacturing' ) ) : ?>
					<!-- 10. Manufacturing & testing -->
					<section id="manufacturing" class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="manufacturing-h">
						<div class="bh-lp-wrap bh-lp-stack">
							<?php blog_hub_lp_head( 'manufacturing', 'manufacturing' ); ?>
							<div class="bh-lp-mfg">
								<div class="bh-lp-mfg__steps">
									<?php if ( blog_hub_lp( 'manufacturing', 'steps_title' ) ) : ?>
										<h3 class="bh-lp-h3"><?php echo esc_html( blog_hub_lp( 'manufacturing', 'steps_title' ) ); ?></h3>
									<?php endif; ?>
									<ol class="bh-lp-steps">
										<?php foreach ( blog_hub_lp_rows( 'manufacturing', 'steps', 2 ) as $bh_i => $bh_row ) : ?>
											<li>
												<span class="bh-lp-steps__n"><?php echo esc_html( sprintf( /* translators: %d: step number */ __( 'STEP %d', 'blog-hub' ), $bh_i + 1 ) ); ?></span>
												<span class="bh-lp-steps__body">
													<strong><?php echo esc_html( $bh_row[0] ); ?></strong>
													<?php if ( $bh_row[1] ) : ?>
														<span><?php echo esc_html( $bh_row[1] ); ?></span>
													<?php endif; ?>
												</span>
											</li>
										<?php endforeach; ?>
									</ol>
								</div>
								<figure class="bh-lp-mfg__media">
									<?php if ( blog_hub_lp( 'manufacturing', 'image' ) ) : ?>
										<img src="<?php echo esc_url( blog_hub_lp( 'manufacturing', 'image' ) ); ?>" alt="<?php echo esc_attr( blog_hub_lp( 'manufacturing', 'image_alt' ) ); ?>" loading="lazy">
									<?php else : ?>
										<?php blog_hub_lp_image_placeholder( __( 'Production or yard photo', 'blog-hub' ), '4-5' ); ?>
									<?php endif; ?>
									<?php if ( blog_hub_lp( 'manufacturing', 'caption' ) ) : ?>
										<figcaption><?php echo esc_html( blog_hub_lp( 'manufacturing', 'caption' ) ); ?></figcaption>
									<?php endif; ?>
								</figure>
							</div>
							<?php $bh_tests = blog_hub_lp_rows( 'manufacturing', 'tests', 2 ); ?>
							<?php if ( $bh_tests ) : ?>
								<div class="bh-lp-tests">
									<?php if ( blog_hub_lp( 'manufacturing', 'tests_title' ) ) : ?>
										<h3 class="bh-lp-h3"><?php echo esc_html( blog_hub_lp( 'manufacturing', 'tests_title' ) ); ?></h3>
									<?php endif; ?>
									<?php if ( blog_hub_lp( 'manufacturing', 'tests_note' ) ) : ?>
										<p class="bh-lp-small"><?php echo esc_html( blog_hub_lp( 'manufacturing', 'tests_note' ) ); ?></p>
									<?php endif; ?>
									<div class="bh-lp-table-scroll">
										<table class="bh-lp-table bh-lp-table--tests">
											<thead><tr><th scope="col"><?php esc_html_e( 'Test', 'blog-hub' ); ?></th><th scope="col"><?php esc_html_e( 'What it checks', 'blog-hub' ); ?></th></tr></thead>
											<tbody>
												<?php foreach ( $bh_tests as $bh_row ) : ?>
													<tr><th scope="row"><?php echo esc_html( $bh_row[0] ); ?></th><td><?php echo esc_html( $bh_row[1] ); ?></td></tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'video' ) ) : ?>
					<!-- 11. Product video (player loads on click) -->
					<?php $bh_yt = blog_hub_lp_youtube_id( blog_hub_lp( 'video', 'youtube' ) ); ?>
					<section class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="video-h">
						<div class="bh-lp-wrap">
							<div class="bh-lp-head"><h2 id="video-h" class="bh-lp-h2"><?php echo esc_html( blog_hub_lp( 'video', 'heading' ) ); ?></h2></div>
							<?php if ( $bh_yt ) : ?>
								<button type="button" class="bh-lp-video" data-bh-lp-video="<?php echo esc_attr( $bh_yt ); ?>" aria-label="<?php esc_attr_e( 'Play video', 'blog-hub' ); ?>">
									<img src="<?php echo esc_url( 'https://i.ytimg.com/vi/' . $bh_yt . '/hqdefault.jpg' ); ?>" alt="" loading="lazy">
									<span class="bh-lp-video__play" aria-hidden="true"><i class="fa-solid fa-play"></i></span>
								</button>
							<?php else : ?>
								<div class="bh-lp-video bh-lp-video--empty"><?php esc_html_e( 'VIDEO NEEDED: paste a YouTube link in the Product video section.', 'blog-hub' ); ?></div>
							<?php endif; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'installation' ) ) : ?>
					<!-- 12. Installation -->
					<section id="installation" class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="installation-h">
						<div class="bh-lp-wrap">
							<?php blog_hub_lp_head( 'installation', 'installation' ); ?>
							<ol class="bh-lp-steps">
								<?php foreach ( blog_hub_lp_rows( 'installation', 'steps', 1 ) as $bh_i => $bh_row ) : ?>
									<li>
										<span class="bh-lp-steps__n"><?php echo esc_html( sprintf( /* translators: %d: step number */ __( 'STEP %d', 'blog-hub' ), $bh_i + 1 ) ); ?></span>
										<span class="bh-lp-steps__body"><span><?php echo esc_html( implode( ' | ', array_filter( $bh_row ) ) ); ?></span></span>
									</li>
								<?php endforeach; ?>
							</ol>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'maintenance' ) ) : ?>
					<!-- 13. Maintenance guide -->
					<section id="maintenance" class="bh-lp-sec bh-lp-sec--rule bh-lp-sec--cream" aria-labelledby="maintenance-h">
						<div class="bh-lp-wrap bh-lp-split">
							<div class="bh-lp-split__a bh-lp-head">
								<h2 id="maintenance-h" class="bh-lp-h2 bh-lp-h2--sm"><?php echo esc_html( blog_hub_lp( 'maintenance', 'heading' ) ); ?></h2>
								<?php blog_hub_lp_paragraphs( blog_hub_lp( 'maintenance', 'text' ), 'bh-lp-small' ); ?>
							</div>
							<div class="bh-lp-split__b bh-lp-accordion">
								<?php foreach ( blog_hub_lp_rows( 'maintenance', 'items', 2 ) as $bh_i => $bh_row ) : ?>
									<details name="bh-lp-maintenance"<?php echo 0 === $bh_i ? ' open' : ''; ?>>
										<summary><span><?php echo esc_html( $bh_row[0] ); ?></span><i class="fa-solid fa-chevron-down" aria-hidden="true"></i></summary>
										<p><?php echo esc_html( $bh_row[1] ); ?></p>
									</details>
								<?php endforeach; ?>
							</div>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'customisation' ) ) : ?>
					<!-- 14. Custom requirement strip -->
					<section class="bh-lp-sec bh-lp-sec--rule bh-lp-sec--slim" aria-labelledby="custom-h">
						<div class="bh-lp-wrap bh-lp-custom">
							<div>
								<h2 id="custom-h" class="bh-lp-h2 bh-lp-h2--xs"><?php echo esc_html( blog_hub_lp( 'customisation', 'heading' ) ); ?></h2>
								<?php blog_hub_lp_paragraphs( blog_hub_lp( 'customisation', 'text' ) ); ?>
							</div>
							<div class="bh-lp-actions">
								<?php $bh_btn_call(); ?>
								<a class="bh-lp-btn bh-lp-btn--outline" href="#enquiry"><?php echo esc_html( blog_hub_lp( 'customisation', 'button_text' ) ? blog_hub_lp( 'customisation', 'button_text' ) : __( 'DISCUSS YOUR REQUIREMENT', 'blog-hub' ) ); ?></a>
							</div>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'price' ) ) : ?>
					<!-- 15. Price information -->
					<section class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="price-h">
						<div class="bh-lp-wrap">
							<?php blog_hub_lp_head( 'price', 'price', 'text' ); ?>
							<?php $bh_factors = blog_hub_lp_rows( 'price', 'factors', 1 ); ?>
							<?php if ( $bh_factors ) : ?>
								<ul class="bh-lp-lines">
									<?php foreach ( $bh_factors as $bh_row ) : ?>
										<li><?php echo esc_html( implode( ' | ', array_filter( $bh_row ) ) ); ?></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'clients' ) ) : ?>
					<!-- 16. Client logos -->
					<section class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="clients-h">
						<div class="bh-lp-wrap">
							<h2 id="clients-h" class="bh-lp-label"><?php echo esc_html( blog_hub_lp( 'clients', 'heading' ) ); ?></h2>
							<ul class="bh-lp-clients">
								<?php foreach ( blog_hub_lp_rows( 'clients', 'items', 2 ) as $bh_row ) : ?>
									<li class="<?php echo $bh_row[1] ? 'has-logo' : ''; ?>">
										<?php if ( $bh_row[1] ) : ?>
											<img src="<?php echo esc_url( $bh_row[1] ); ?>" alt="<?php echo esc_attr( $bh_row[0] ); ?>" loading="lazy">
										<?php else : ?>
											<?php echo esc_html( $bh_row[0] ); ?>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'projects' ) ) : ?>
					<!-- 17. Projects -->
					<section class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="projects-h">
						<div class="bh-lp-wrap">
							<div class="bh-lp-head"><h2 id="projects-h" class="bh-lp-h2"><?php echo esc_html( blog_hub_lp( 'projects', 'heading' ) ); ?></h2></div>
							<div class="bh-lp-projects">
								<?php foreach ( blog_hub_lp_rows( 'projects', 'items', 2 ) as $bh_row ) : ?>
									<figure>
										<?php if ( $bh_row[1] ) : ?>
											<img src="<?php echo esc_url( $bh_row[1] ); ?>" alt="<?php echo esc_attr( $bh_row[0] ); ?>" loading="lazy">
										<?php else : ?>
											<?php blog_hub_lp_image_placeholder( __( 'Project photo', 'blog-hub' ), '16-9' ); ?>
										<?php endif; ?>
										<figcaption><?php echo esc_html( $bh_row[0] ); ?></figcaption>
									</figure>
								<?php endforeach; ?>
							</div>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( blog_hub_lp_on( 'faq' ) ) : ?>
					<!-- 18. FAQ -->
					<section id="faq" class="bh-lp-sec bh-lp-sec--rule bh-lp-sec--cream" aria-labelledby="faq-h">
						<div class="bh-lp-wrap bh-lp-stack">
							<div class="bh-lp-faq-head">
								<?php blog_hub_lp_head( 'faq', 'faq' ); ?>
								<?php if ( blog_hub_lp( 'faq', 'note' ) ) : ?>
									<p class="bh-lp-note"><?php echo blog_hub_lp_rich( 'faq', 'note' ); // phpcs:ignore WordPress.Security.EscapeOutput -- KSES'd. ?></p>
								<?php endif; ?>
							</div>
							<div class="bh-lp-accordion bh-lp-accordion--faq">
								<?php foreach ( blog_hub_lp_rows( 'faq', 'items', 2 ) as $bh_row ) : ?>
									<details name="bh-lp-faq">
										<summary><h3><?php echo esc_html( $bh_row[0] ); ?></h3><i class="fa-solid fa-plus" aria-hidden="true"></i></summary>
										<p><?php echo esc_html( $bh_row[1] ); ?></p>
									</details>
								<?php endforeach; ?>
							</div>
						</div>
					</section>
				<?php endif; ?>

			</div>

			<?php if ( $bh_show_toc ) : ?>
				<aside class="bh-lp-toc" aria-label="<?php esc_attr_e( 'Product contents', 'blog-hub' ); ?>">
					<nav aria-labelledby="bh-lp-toc-h">
						<div class="bh-lp-toc__head">
							<span id="bh-lp-toc-h"><?php esc_html_e( 'PRODUCT INDEX', 'blog-hub' ); ?></span>
							<?php if ( blog_hub_lp( 'index', 'subtitle' ) ) : ?>
								<strong><?php echo esc_html( blog_hub_lp( 'index', 'subtitle' ) ); ?></strong>
							<?php endif; ?>
						</div>
						<ol>
							<?php $bh_n = 0; ?>
							<?php foreach ( $bh_toc as $bh_id => $bh_label ) : ?>
								<li><a href="#<?php echo esc_attr( $bh_id ); ?>" data-bh-lp-toc="<?php echo esc_attr( $bh_id ); ?>"<?php echo 'enquiry' === $bh_id ? ' class="is-strong"' : ''; ?>><span><?php echo esc_html( str_pad( (string) ++$bh_n, 2, '0', STR_PAD_LEFT ) ); ?></span><?php echo esc_html( $bh_label ); ?></a></li>
							<?php endforeach; ?>
						</ol>
					</nav>
				</aside>
			<?php endif; ?>
		</div>

		<?php if ( blog_hub_lp_on( 'articles' ) ) : ?>
			<!-- 19. Related articles -->
			<section class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="articles-h">
				<div class="bh-lp-wrap">
					<div class="bh-lp-head"><h2 id="articles-h" class="bh-lp-h2 bh-lp-h2--sm"><?php echo esc_html( blog_hub_lp( 'articles', 'heading' ) ); ?></h2></div>
					<ul class="bh-lp-articles">
						<?php foreach ( blog_hub_lp_rows( 'articles', 'items', 2 ) as $bh_row ) : ?>
							<li><a href="<?php echo blog_hub_lp_href( $bh_row[1] ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in helper. ?>"><?php echo esc_html( $bh_row[0] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( blog_hub_lp_on( 'related' ) ) : ?>
			<!-- 20. Related products -->
			<section class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="related-h">
				<div class="bh-lp-wrap">
					<div class="bh-lp-head"><h2 id="related-h" class="bh-lp-h2"><?php echo esc_html( blog_hub_lp( 'related', 'heading' ) ); ?></h2></div>
					<div class="bh-lp-related">
						<?php foreach ( blog_hub_lp_rows( 'related', 'items', 5 ) as $bh_row ) : ?>
							<a class="bh-lp-product" href="<?php echo blog_hub_lp_href( $bh_row[2] ? $bh_row[2] : '#' ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in helper. ?>">
								<?php if ( $bh_row[3] ) : ?>
									<img src="<?php echo esc_url( $bh_row[3] ); ?>" alt="<?php echo esc_attr( $bh_row[0] ); ?>" loading="lazy">
								<?php else : ?>
									<?php blog_hub_lp_image_placeholder( $bh_row[0] ); ?>
								<?php endif; ?>
								<span class="bh-lp-product__body">
									<span class="bh-lp-product__name"><?php echo esc_html( $bh_row[0] ); ?></span>
									<?php if ( $bh_row[1] ) : ?>
										<span class="bh-lp-product__desc"><?php echo esc_html( $bh_row[1] ); ?></span>
									<?php endif; ?>
									<span class="bh-lp-product__cta"><?php echo esc_html( $bh_row[4] ? $bh_row[4] : __( 'View product', 'blog-hub' ) ); ?> &rarr;</span>
								</span>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( blog_hub_lp_on( 'areas' ) ) : ?>
			<!-- 21. Areas served -->
			<section class="bh-lp-sec bh-lp-sec--rule" aria-labelledby="areas-h">
				<div class="bh-lp-wrap">
					<h2 id="areas-h" class="bh-lp-h3"><?php echo esc_html( blog_hub_lp( 'areas', 'heading' ) ); ?></h2>
					<ul class="bh-lp-areas">
						<?php foreach ( blog_hub_lp_rows( 'areas', 'items', 2 ) as $bh_row ) : ?>
							<li><a href="<?php echo blog_hub_lp_href( $bh_row[1] ? $bh_row[1] : '#' ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in helper. ?>"><?php echo esc_html( $bh_row[0] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>
		<?php endif; ?>

		<!-- 22. Enquiry -->
		<section id="enquiry" class="bh-lp-sec bh-lp-sec--rule bh-lp-sec--tint" aria-labelledby="enquiry-h">
			<div class="bh-lp-wrap bh-lp-enquiry">
				<div class="bh-lp-enquiry__info">
					<?php blog_hub_lp_head( 'enquiry', 'enquiry', 'text' ); ?>
					<?php if ( $bh_phone ) : ?>
						<a class="bh-lp-contact bh-lp-contact--dark" href="<?php echo esc_attr( $bh_tel( $bh_phone ) ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><span><small><?php esc_html_e( 'Call', 'blog-hub' ); ?></small><?php echo esc_html( $bh_phone ); ?></span></a>
					<?php endif; ?>
					<?php if ( $bh_phone_2 ) : ?>
						<a class="bh-lp-contact" href="<?php echo esc_attr( $bh_tel( $bh_phone_2 ) ); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><span><small><?php esc_html_e( 'Call', 'blog-hub' ); ?></small><?php echo esc_html( $bh_phone_2 ); ?></span></a>
					<?php endif; ?>
					<?php if ( $bh_whatsapp ) : ?>
						<a class="bh-lp-contact" href="<?php echo esc_url( 'https://wa.me/' . $bh_whatsapp ); ?>" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i><span><small><?php esc_html_e( 'WhatsApp', 'blog-hub' ); ?></small>+<?php echo esc_html( $bh_whatsapp ); ?></span></a>
					<?php endif; ?>
					<?php if ( $bh_email ) : ?>
						<a class="bh-lp-contact-line" href="<?php echo esc_attr( 'mailto:' . antispambot( $bh_email ) ); ?>"><i class="fa-regular fa-envelope" aria-hidden="true"></i><?php echo esc_html( antispambot( $bh_email ) ); ?></a>
					<?php endif; ?>
					<?php if ( $bh_address ) : ?>
						<address class="bh-lp-contact-line"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><?php echo esc_html( $bh_address ); ?></address>
					<?php endif; ?>
				</div>
				<div class="bh-lp-enquiry__form">
					<?php if ( blog_hub_lp( 'enquiry', 'shortcode' ) ) : ?>
						<?php echo do_shortcode( blog_hub_lp( 'enquiry', 'shortcode' ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- shortcode output (WPForms) escapes itself. ?>
					<?php else : ?>
						<p class="bh-lp-form-missing"><strong><?php esc_html_e( 'FORM NEEDED', 'blog-hub' ); ?></strong><?php esc_html_e( 'Paste the WPForms shortcode in the "Enquiry" section of this page.', 'blog-hub' ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>

	</main>
	<?php
endwhile;

get_footer();
