# Project Overview

This repo is a **local WordPress development environment** (Docker-based) used to build a
standalone, portable classic PHP theme called **"Blog Hub"** for a live WordPress site,
**shubhsanskarconcrete.com** (a precast concrete products manufacturer: cement poles, RCC
Hume pipes, manhole covers/systems, paver blocks).

The design source is a Figma file ("Blog Hub"), file key `yUmP3AiIyUoSXWWK9qXW6A`. Several
pages were also exported as standalone `.dc.html` files at the repo root for reference:
`Blog Hub.dc.html`, `Blog Hub Page 2.dc.html`, `Blog Category.dc.html`, `Blog Author.dc.html`,
`Blog Article.dc.html` (+ a duplicate `Blog Article.dc (1).html`).

## Deployment model

The theme is developed locally, packaged as a theme ZIP (`blog-hub.zip` at the repo root,
git-ignored, rebuilt on demand — never commit it), and uploaded via
**Appearance > Themes > Upload Theme** on the live site to swap the UI without touching
existing database content.

## Critical architecture decision: Home page vs Blog page

The live site's existing **Home page is Elementor-built and must stay untouched** at `/`.
The new Blog Hub design lives at **`/blog/`** instead (set as the WordPress "Posts page" under
Settings > Reading, with Homepage left on the existing Elementor page).

This has a real WordPress implication: **a page assigned as the "Posts page" always renders via
`home.php`/`index.php` and ignores any Page Template assigned to it** — this is a hard
WordPress limitation, not a config mistake. Originally `front-page.php` held the rich Blog Hub
layout, but since a Posts page never uses `front-page.php`, that file was **deleted** and its
entire content merged into `home.php`, to avoid it silently hijacking the real homepage if
Settings > Reading is ever reconfigured. See mem:theme_architecture.

## Local dev stack

Docker Compose: `bloghub_wp` (WordPress + Apache, bind-mounted `wp-content`), `bloghub_db`
(MariaDB), `bloghub_pma` (phpMyAdmin). wp-cli is installed inside `bloghub_wp` for all WP
management (menus, options, users, themes). Local site: `http://localhost:8080`.

See mem:theme_architecture, mem:figma_and_tools, mem:known_gotchas, mem:security_and_git,
mem:qa_feedback_round_2026-10.
