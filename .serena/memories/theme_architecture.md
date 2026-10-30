# Theme Architecture — Blog Hub

Theme lives at `wp-content/themes/blog-hub-new/` (packaged into the zip as `blog-hub/`).
Classic PHP theme (no block editor / FSE), built to spec: fully dynamic/data-driven,
presentation-only. All business content (contact info, hero copy, CTA banners, map embed)
comes from the WordPress Customizer, Site Identity, nav menus, or native post/user data —
never hardcoded. The one exception, added 2026-10-27: `inc/main-site.php` registers 4 minimal
custom post types for the homepage's repeating content sections (Products, Applications,
Client Logos, Testimonials) — see "Main-site pages" section below for why and how these are
kept deliberately thin (title + featured image + at most two plain meta fields each, no
business logic beyond that).

## Template files

- `style.css` — theme header (`Theme Name: Blog Hub`, `Version: 1.0.0`).
- `functions.php` (~750 lines) — theme setup, nav menu locations (`primary`, `footer`,
  `social`), widget areas (`footer-widgets`, `single-rail`), asset enqueueing, Customizer
  registration, author-profile custom fields, JSON-LD schema output, helper functions
  (reading time, TOC extraction, related posts).
- `header.php` — optional topbar (email + **two** phone numbers via `blog_hub_contact_phone`
  and `blog_hub_contact_phone_2`), then `wp_nav_menu('primary')` wrapped in a `.bh-nav__menu`
  div with a `.bh-nav__toggle` hamburger button (shown only via CSS below 720px; toggled by
  `main.js`, see assets/js/ below) — fixed 2026-10-20, there was previously no mobile menu at
  all (primary nav items just stacked open on small screens).
- `footer.php` — 4 conditional columns (brand / "Important Links" menu / "Contact Us" /
  "Find Us" map embed) + footer-widgets sidebar, bottom bar with copyright + social icons menu.
- `home.php` — **the real blog listing template** (see mem:project_overview for why). Contains
  breadcrumb, hero, intro (page 1 only), category-dropdown, featured post card with share
  icons (page 1 only), inline CTA (page 1 only), latest-posts grid ("Older Posts" + "Showing
  X–Y of Z" counter on page 2+), category-list, newsletter, links-line, end CTA. Used both when
  a static page is set as "Posts page" AND as the fallback when Reading is set to
  "Your latest posts".
- `front-page.php` — the real site homepage (re-added 2026-10-27; see "Main-site pages"
  section below and mem:project_overview for the full history — this is NOT the same file
  that was deleted earlier in the project, it serves a different, new purpose).
- `single.php` → `template-parts/breadcrumbs.php` + `template-parts/content-single.php`
  (header with category/title/meta/share icons, featured image, TL;DR callout, two-column body
  with sticky TOC rail built from `blog_hub_toc_from_content()`, `single-rail` widget area,
  author-card, back-to-top button, end CTA, related-posts grid). Rich content blocks (steps,
  stats, FAQ `<details>`/`<summary>` accordion, pull-quotes, tables) are just standard
  post-content HTML styled by `article.css` — no dedicated PHP partials needed for those.
- `page.php` — minimal, skips the page-title header on `is_front_page()`.
- `category.php` — breadcrumb, header (eyebrow/title/description), category-switcher dropdown,
  posts grid with article-count heading, end CTA.
- `archive.php` — generic fallback for tags/date archives.
- `author.php` — breadcrumb, profile header (avatar/title/LinkedIn/article count), two-column
  about section (bio/quote/expertise pills) + "{Name} at a Glance" sidebar card (highlights
  list, "Talk to {Name}" contact block, optional "Request a Quote" CTA button), posts grid,
  end CTA.
- `404.php`, `search.php` — standard fallbacks.
- `index.php` — bare fallback, calls `posts-grid`.
- `page-templates/template-full-width.php` — selectable custom page template.

## template-parts/ (shared partials)

`breadcrumbs.php` is a single, **context-aware** partial handling 4 different contexts via
`is_home()` / `is_category()` / `is_author()` / else-single-post — do not duplicate inline
breadcrumb markup in any template; always call this part. Trail logic: Home / Blog (index,
current) · Home / Blog / Category (category archive, current) · Home / Blog / Author name
(author archive, current) · Home / Blog / Category / Post title (single post).

Other parts: `content-single.php`, `content-card.php` (grid post card), `related-posts.php`,
`author-card.php`, `newsletter.php`, `pagination.php`, `posts-grid.php` (accepts `show_count`/
`heading` args), `category-list.php`, `category-dropdown.php`, `category-switcher.php`,
`cta-inline.php`, `cta-end.php` (Customizer-driven, render nothing if unconfigured),
`links-line.php` (short centered text+links strip, Customizer-driven).

## Main-site pages (Home / About Us / Contact Us) — added 2026-10-27

A second, parallel design (navy `#1f1c44` / gold `#c9b379` — same token palette as Blog Hub,
confirmed to be the exact same hex values, so no new tokens were needed) for the site's actual
main pages, built from `Home.dc.html` / `About Us.dc.html` / `Contact Us.dc.html` design
exports plus matching full-page SVG screenshots at the repo root. Header/footer are shared
with Blog Hub (same `header.php`/`footer.php`, confirmed already generic enough — no changes
needed beyond adding "Areas We Serve" to the live primary nav menu between Products and
Contact, matching the real site).

- `front-page.php` — the real homepage. Hero (Customizer: `blog_hub_home_hero_text` text +
  optional image + button), Products grid (from the `bh_product` CPT), About teaser (text +
  up to 4 gallery images, all Customizer), Applications (from the `bh_application` CPT,
  rendered as pure-CSS 3D flip cards — hover/focus, no JS), "Why Choose Us" (4 plain
  Customizer fields via `blog_hub_get_reasons()`), Client logos (from the `bh_client_logo`
  CPT, JS carousel in `assets/js/main-site.js`), Blog teaser (real `get_posts()` query, same
  pattern as the rest of the theme — not a separate content type), Testimonials (from the
  `bh_testimonial` CPT), closing CTA banner (Customizer).
- `page-templates/template-about.php` — selectable "About Us" page template. Dark page-header
  banner (background image via per-page post meta `blog_hub_page_hero_image`, its own meta
  box only shown when this or the Contact template is selected), then the page's own
  `the_content()` for the "Who We Are" body copy (intentionally NOT a separate field — this is
  normal page content), then a "Find Us" section reusing the SAME site-wide Contact Details
  Customizer fields (email/address/map embed) as the footer — nothing new to configure there.
- `page-templates/template-contact.php` — selectable "Contact Us" page template. Same
  page-header banner pattern. The contact FORM itself is deliberately NOT hand-built — it
  embeds a WPForms shortcode pasted into a new Customizer field
  (`blog_hub_contact_form_shortcode`); if blank, the template shows a plain "not configured
  yet" message instead of a broken/fake form (`do_shortcode()` on an unregistered shortcode
  tag is a safe no-op, confirmed by testing locally where WPForms isn't installed). Office/
  factory locations are a `blog_hub_contact_offices` Customizer textarea, one per line as
  `Label | Address | Google Maps embed URL` — a repeater CPT was considered overkill for a
  handful of rarely-changing addresses.

### New custom post types (`inc/main-site.php`)

`bh_product` (title, featured image, `blog_hub_product_link` meta — a plain URL, deliberately
NOT assumed to point at a page this theme builds), `bh_application` (title, featured image,
post content = the flip-card's back-face description), `bh_client_logo` (title = company name
for alt text, featured image = the logo), `bh_testimonial` (title = person's name, featured
image = their photo, post content = the quote, meta: `blog_hub_testimonial_location`,
`blog_hub_testimonial_rating` 1-5). All four are `show_ui => true` but `public => false` (no
public archive/single templates needed — they're only ever looped over from front-page.php).

### A real bug worth remembering: empty-image items disappearing from the DOM entirely

The client-logo carousel's JS counts `track.children` to know how many total logos exist (for
paging/wraparound math) and to find the dots row via `carousel.parentElement.querySelector(...)`
(the dots sit as a sibling of the carousel strip, not a descendant — `carousel.querySelector()`
on the narrower element silently returns null and the active-dot highlighting breaks with no
console error). The PHP template was first written to only output an `<img>` when
`has_post_thumbnail()` was true, which meant a client-logo CPT entry with no image yet
contributed ZERO elements to the track — breaking the count and the whole carousel for any
site that hasn't uploaded every logo yet. Fixed by always rendering a wrapper `<div>` per
entry (with a dashed-border placeholder + the title as text when no image is set, same pattern
as `bh-ms-product__media--empty` elsewhere) so the JS's child-count always matches the real
number of content entries regardless of whether each one has media yet.

## assets/css/

`tokens.css` is the single source of truth for design tokens (`--navy-900`, `--gold-500`,
`--cream-100`, spacing/typography scale) — never redefine tokens elsewhere.
`components.css` (nav/menu dropdowns, footer, cards, buttons), `pages.css` (page headers,
author/category page layout), `article.css` (single-post TOC/callouts/FAQ/steps),
`main-site.css` (added 2026-10-27 — Home/About/Contact page layout only, not shared with the
Blog Hub listing/article templates).

## Author custom fields (user meta, optional, theme-specific)

`blog_hub_author_title`, `blog_hub_author_quote`, `blog_hub_author_linkedin`,
`blog_hub_author_expertise` (comma-separated tags), `blog_hub_author_highlights`
(newline-separated "at a glance" facts), `blog_hub_author_cta_url` ("Request a Quote" button
link). Edited via Profile screen fields added by `blog_hub_author_profile_fields()` /
`blog_hub_save_author_profile_fields()` in functions.php. Bio itself reuses WP's native
`description` user field, not a custom one.

Added 2026-10-20 (QA round against the "SSC Dev Support" feedback sheet):
- `blog_hub_author_public_email` — the email shown publicly on the author page, read via
  `blog_hub_author_public_email( $user_id )`, which falls back to the site-wide Customizer
  `blog_hub_contact_email` if unset. Deliberately replaces using
  `get_the_author_meta( 'user_email', ... )` directly in author.php, which was a real privacy
  bug: it publicly exposed the author's actual WordPress login email.
- `blog_hub_author_extra_stats` — newline-separated `value | label` pairs (e.g.
  `13 | Years on Site`), read via `blog_hub_author_extra_stats( $user_id )`, rendered as
  additional stat tiles next to "Articles Published" in the author header.

## Customizer sections

`blog_hub_contact` (email, phone ×2, address, map embed — `blog_hub_sanitize_map_embed()`
only allows a genuine Google Maps embed `<iframe>`, regex + `wp_kses()`), `blog_hub_front_page`
(hero eyebrow/title/intro, newsletter action URL, links-line text, and — added 2026-10-20 —
`blog_hub_latest_posts_eyebrow`, an optional label shown above "Latest Posts" on Blog Hub page
1), `blog_hub_cta` (inline + end-of-page CTA banners, both optional). Added 2026-10-27:
`blog_hub_homepage` (hero text/button/image, about-teaser text + 4 gallery images, 4 "why
choose us" reason fields, end-CTA heading/button/image — all read by front-page.php) and 3
new fields folded into the existing `blog_hub_contact` section rather than a new one, since
they're still "how someone reaches us" content: `blog_hub_contact_intro_heading`,
`blog_hub_contact_form_shortcode`, `blog_hub_contact_offices`.

See mem:known_gotchas for the double-escaping and pagination-var bugs tied to this structure.
See mem:security_and_git for a full list of what's git-ignored and why (the project root also
now has a `SITE_CONFIG.md` checklist for all the Customizer/menu/category/author-profile setup
needed per environment — not theme code, see that file directly).
