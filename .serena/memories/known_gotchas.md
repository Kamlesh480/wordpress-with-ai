# Known Gotchas / Bugs Already Found and Fixed

Real WordPress/theme pitfalls hit during development — check these before "discovering" them
again.

## Double-HTML-escaping categories

`get_the_category()` and `get_categories()` both return **pre-escaped** `name` properties
(e.g. "Manhole Covers &amp; Systems"). Wrapping the name in `esc_html()` again causes visible
double-escaping (`&amp;amp;`). Affected files use a `phpcs:ignore WordPress.Security.EscapeOutput`
comment and plain `echo`/`strtoupper()` instead — this is intentional, not a missed-escaping bug.
Applies to: `content-card.php`, `content-single.php`, `related-posts.php`, `home.php`
(featured card), `category-dropdown.php`, `category-list.php`, `category-switcher.php`.

## `page` vs `paged` query var

A **static front page's own pagination** uses the `page` query var, not `paged` (which is
reserved for manually-constructed sub-loops). This only matters if something is literally
`front-page.php` — now moot since that file is deleted and `home.php` (a genuine "Posts page"
context) correctly uses plain `paged`.

## WordPress template hierarchy hard limit

A page set as "Posts page" (Settings > Reading) **always** renders via `home.php`/`index.php`,
ignoring any Page Template assigned in the editor. Not configurable. This is why the rich
Blog Hub layout had to live in `home.php`, not a custom page template. See
mem:theme_architecture.

## wp_nav_menu() social icons bug (fixed)

Using `link_before`/`link_after` args on `wp_nav_menu()` to wrap item titles in
`.screen-reader-text` makes the **entire link invisible** (icon included) if you also try to
inject an icon via a title filter — the filter's icon output gets wrapped in the hidden span
too. Fix: remove `link_before`/`link_after` from the `wp_nav_menu()` call entirely, and have
the `nav_menu_item_title` filter (`blog_hub_social_menu_icon()` in functions.php) return
**both** the visible `<i>` icon AND a separate hidden accessible-text span in one return value.

## Missing `.sub-menu` CSS

`wp_nav_menu()` outputs correct nested `<ul><li><ul class="sub-menu">` markup for dropdown
menus by default, but WordPress ships **no CSS** for `.sub-menu` — without explicit flyout/
dropdown CSS it renders as a flat inline/stacked list. `components.css` now has the full
`.bh-menu .sub-menu` dropdown system plus a mobile stacked fallback.

## Image cropping / object-fit

Featured images in card grids need `object-fit: cover` on the real `<img>`; the original CSS
only styled the **empty placeholder** state (dashed border, centered icon), so a real uploaded
image rendered uncropped with the placeholder border still visible. Fixed via `--empty`
modifier classes (`bh-post-card__media--empty`, `bh-featured__media--empty`,
`bh-related-card__media--empty`) separating the two states.

## Footer gaps that looked like theme bugs but weren't

"Important Links" column not showing = **no menu assigned** to the `footer` theme location
(the `has_nav_menu('footer')` gate was correct code, just nothing registered). Always check
Appearance > Menus location assignment before assuming the template is broken.

## Breadcrumbs were missing on 3 of 4 listing-style templates (fixed)

`template-parts/breadcrumbs.php` originally only worked for single posts. It's now
context-aware (`is_home()` / `is_category()` / `is_author()` / else) and wired into
`home.php`, `category.php`, and `author.php` as well as `single.php`. If a new archive-style
template is ever added, remember to call this shared part rather than writing new breadcrumb
markup inline — `author.php` originally had an inline duplicate that was removed in favor of
reusing this file.

## WP-Staging plugin generates runtime files

`wp-content/wp-staging/` is auto-created by the WP-Staging plugin for cleanup-job cache/lock
files (e.g. `*.sse.cache.php`, `.htaccess`, `index.php` placeholders). These are transient and
churn on every staging run — gitignored, not project source. If it reappears in `git status`,
that's expected; just confirm `.gitignore` still excludes `wp-content/wp-staging/`.

## Overlapping WhatsApp button on staging/live is a plugin, not the theme

The live/staging site has the **Social Chat** plugin (`wp-whatsapp-chat`, QuadLayers, markup
class `qlwapp`) active. It renders its own green WhatsApp pill fixed at the bottom-right,
directly on top of the theme's `.bh-floating-actions` stack (footer.php / components.css),
which looks like a theme overlap bug. The theme's own stack (WhatsApp circle above Call
circle, 12px gap) only shows the WhatsApp button when the Customizer WhatsApp number is set;
with it blank, only the Call circle renders. Fix is config: deactivate Social Chat and fill
the WhatsApp number field — not a CSS change.

## `.bh-back-to-top` class clash (fixed 2026-11-15)

`article.css` (enqueued on every page, not just single posts) styles `.bh-back-to-top` as a
fixed floating button with `opacity: 0` until `.is-visible`. The footer reused the same class
but toggled the `hidden` attribute instead, so the footer button was permanently invisible.
Footer button is now `.bh-footer__totop`. Don't reuse class names across article.css and
components.css — both load globally.

## Sticky table headers inside core table blocks

Core's `.wp-block-table` wrapper has `overflow-x: auto`, which silently disables
`position: sticky` on `thead th`. article.css sets it to `overflow: visible` ≥768px. Sticky
offsets must clear the fixed header (64px in scrolled state, +32px with the admin bar).

## Extra elements on staging that come from plugins, not the theme

Green bottom-left call button = **Call Now Button** plugin (script from callnowbutton.com, not
visible in server HTML). "Related Posts:" thumbnail strip inside articles = **YARPP**. Both
should be deactivated; the theme has its own equivalents.

## Don't use the_custom_logo() inside the theme's brand links
`the_custom_logo()` outputs its own `<a>`; the theme already wraps the logo in `<a class="bh-brand">` / `.bh-footer__logo-link`, so it gives nested anchors (invalid HTML, which browsers split apart). Use `blog_hub_logo_img()` instead. Also: without `add_theme_support( 'custom-logo' )` the Customizer has no Logo field and `has_custom_logo()` is always false, which is why the logo never showed on staging before v1.0.2.

## get_the_category() is alphabetical, not "first ticked"
`get_the_category()` returns terms sorted by name, so `$cats[0]` is NOT the main category ("Blogs" or "Delhi" beat every topic name). Always use `blog_hub_primary_category( $post_id )` (functions.php, v1.0.3): Yoast/Rank Math Primary if set → first category that isn't blogs/uncategorized/areas-we-serve or a child of areas-we-serve → `$cats[0]`. Used by content-card, content-single, home.php featured, related-posts, breadcrumbs and the breadcrumb JSON-LD.

## Never put HTML tags in Customizer control descriptions
WP prints `description` unescaped. The Map embed control's text mentioned `<iframe ...>`, which rendered a real empty iframe that covered the textarea, so nothing could be pasted on staging (fixed v1.0.4). Write "embed code" in words instead.

## Staging/live permalinks contain %category% — never bulk-change Yoast Primary
Post URLs look like `/blogs/<slug>/` (Yoast Primary category in the permalink). Most posts have Yoast Primary = Blogs or a location; changing it changes live URLs. `blog_hub_primary_category()` (v1.0.6) only trusts a Yoast Primary that is a topic, so labels show the topic without touching Primary. Staging got its topic categories assigned 15 Nov 2026 via the REST API from the logged-in wp-admin tab (categories 299/300/302/303/304); production not yet.

- **Sticky inside overflow boxes (v1.0.12):** any ancestor with overflow other than visible (core `.wp-block-table` uses overflow-x:auto) makes `position: sticky` stick to that box instead of the page, so table headers scroll away. Keep `.wp-block-table` overflow visible and make tables fit by wrapping instead.
- **Google Docs editing via Chrome:** `cmd+Down` jumps to end of the whole doc; screenshots right after a scroll can be stale (wait 1s); drag-dropping an image drops at the mouse point, not the caret, so put the caret on an empty line and drop exactly there.

## Production runs Blog Hub ONLY on blog URLs (19 Nov 2026)
- Active theme on production = **Neve**. Plugin `ssc-blog-theme-switch` (repo: wp-content/plugins/) filters `template`/`stylesheet` (+ pre_option_) to Blog Hub for: posts page (+/page/N), posts (except posts whose categories are all in the "areas-we-serve" tree), category (except area tree), tag, author. Tools → Blog Theme Switch: "Edit Blog Hub settings" (per-admin, 2h, whole site = Blog Hub for that admin so the Customizer saves into theme_mods_blog-hub) and "Go live"/"Turn off".
- NEVER let the Customizer think Blog Hub is a *previewed inactive* theme: Publish would `switch_theme()` the whole site. The plugin treats `customize_theme=blog-hub` as its own, blocks Themes→Activate and Live Preview of Blog Hub, and refuses option writes that make Blog Hub active.
- `site_logo` option (core block sync) overrides EVERY theme's custom_logo → plugin 1.0.1 returns the active theme's own stored custom_logo on non-blog URLs.
- Site Title / Tagline / Site Icon are core options shared with Neve: don't change them for the blog.
- On production these plugins stay active for the Neve pages, so Blog Hub neutralises them on its own pages: Call Now Button + Social Chat (hidden via CSS), YARPP (the_content filter removed).
- Old production posts contain Elementor blocks with fixed px widths, pasted computed inline styles and Word tables: article.css has ≤767px guards for all of these. Re-run the 36-post phone sweep after article CSS changes.
- WP Rocket combines CSS on production: theme asset URLs don't appear in cached HTML; detect the theme via body class `wp-theme-blog-hub`. Bypass cache with any query string. Clear cache: admin-bar link with `purge_cache&type=all`.
- (v2, 19 Nov 2026) The Areas We Serve section (page `areas-we-serve`, its child pages, location posts, area categories) is now ALSO served with Blog Hub on production (plugin 1.1.0). Areas dropdown/footer come from the real child pages; never hardcode city slugs (non-existent /areas-we-serve/<city>/ gets redirected by WordPress to a same-named image). Neve's `page-templates/template-pagebuilder-full-width.php` path exists in Blog Hub too, for Elementor state pages.

