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
