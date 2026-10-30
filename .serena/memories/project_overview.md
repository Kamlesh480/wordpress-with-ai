# Project Overview

This repo is a **local WordPress development environment** (Docker-based) used to build a
standalone, portable classic PHP theme called **"Blog Hub"** for a live WordPress site,
**shubhsanskarconcrete.com** (a precast concrete products manufacturer: cement poles, RCC
Hume pipes, manhole covers/systems, paver blocks).

The design source is a Figma file ("Blog Hub"), file key `yUmP3AiIyUoSXWWK9qXW6A`. Several
pages were also exported as standalone `.dc.html` files at the repo root for reference:
`Blog Hub.dc.html`, `Blog Hub Page 2.dc.html`, `Blog Category.dc.html`, `Blog Author.dc.html`,
`Blog Article.dc.html` (+ a duplicate `Blog Article.dc (1).html`). Added 2026-10-27 for the
site's main pages (not Figma-sourced this time): `Home.dc.html`, `About Us.dc.html`,
`Contact Us.dc.html`, plus matching full-page SVG screenshot exports (`Homepage.svg`,
`About us page.svg`, `Contact us page.svg`) — those SVGs are just embedded raster screenshots
for a quick visual sanity check, not real vector/structural data; the `.dc.html` files are the
authoritative source for exact copy, colors, and layout.

## Deployment model

The theme is developed locally, packaged as a theme ZIP (`blog-hub.zip` at the repo root,
git-ignored, rebuilt on demand — never commit it), and uploaded via
**Appearance > Themes > Upload Theme** on the live site to swap the UI without touching
existing database content.

## Critical architecture decision: Home page vs Blog page

The live site's existing **Home page is Elementor-built**. For most of this project it had to
stay completely untouched at `/`, with the Blog Hub design living at **`/blog/`** instead (set
as the WordPress "Posts page" under Settings > Reading).

This has a real WordPress implication: **a page assigned as the "Posts page" always renders via
`home.php`/`index.php` and ignores any Page Template assigned to it** — this is a hard
WordPress limitation, not a config mistake. Blog Hub's own rich layout therefore lives entirely
in `home.php` (not `front-page.php`) — see mem:theme_architecture for that template's contents.

**`front-page.php` now exists again (added 2026-10-27)** — don't delete it thinking it's the
old mistake described above. It was deliberately reintroduced to hold a brand-new real homepage
(hero, products, about teaser, applications, client logos, blog teaser, testimonials, closing
CTA — see mem:theme_architecture "Main-site pages" for the full breakdown), built from a
`Home.dc.html` design export, explicitly intended to **eventually replace** the Elementor
homepage. As of 2026-10-27 it is built and tested locally but is **NOT live** — Settings >
Reading → Homepage must stay pointed at the existing Elementor page until the new homepage is
reviewed and the switch is explicitly approved; `SITE_CONFIG.md` section 10 has a loud warning
about this exact point. `home.php` (Blog Hub) and `front-page.php` (main homepage) are two
separate files serving two separate, unrelated purposes — don't conflate them.

## Local dev stack

Docker Compose: `bloghub_wp` (WordPress + Apache, bind-mounted `wp-content`), `bloghub_db`
(MariaDB), `bloghub_pma` (phpMyAdmin). wp-cli is installed inside `bloghub_wp` for all WP
management (menus, options, users, themes). Local site: `http://localhost:8080`.

See mem:theme_architecture, mem:figma_and_tools, mem:known_gotchas, mem:security_and_git,
mem:qa_feedback_round_2026-10.
