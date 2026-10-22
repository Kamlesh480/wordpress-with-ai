---
name: update-blog-hub-theme
description: End-to-end workflow for making any change to the Blog Hub WordPress theme (wp-content/themes/blog-hub-new/) — reads Serena project memories first for full context, implements and verifies the change locally, rebuilds blog-hub.zip, and updates the memories afterward. Use for any feature, fix, or content/structure change to this theme, or when asked to update/rebuild the theme zip.
argument-hint: "[describe the change you want made, e.g. \"add an Instagram feed section to the footer\"]"
---

# Update the Blog Hub Theme

This project is a **portable classic PHP WordPress theme** ("Blog Hub") built for
shubhsanskarconcrete.com, developed in a local Docker WordPress environment and shipped to the
live site as a single uploadable ZIP (`blog-hub.zip` at the repo root). This skill is the
standard workflow for **any** change to the theme — a new section, a bug fix, a design-parity
fix against Figma, a Customizer field, anything. Follow every step in order; don't skip the
memory read at the start or the rebuild/memory-update at the end.

## Input

Change requested: $ARGUMENTS

If this is empty or too vague to act on (e.g. just "update the theme"), ask the user what
specifically should change before doing anything else.

## 0. Load full project context from Serena memory — do this before writing any code

This project's accumulated knowledge (architecture, prior decisions, known gotchas, Figma/tool
notes, security & git setup) lives in Serena's memory system at `.serena/memories/`, not in this
file. Read it fully before touching code:

1. Confirm the Serena MCP tools are available this session. They are deferred — if
   `mcp__serena__*` tools haven't surfaced yet, use `ToolSearch` with a query like
   `"select:mcp__serena__read_memory"` (or `"serena"`) to load them.
2. `mcp__serena__list_memories()` to see the current set of memory files (expect at least
   `project_overview`, `theme_architecture`, `known_gotchas`, `figma_and_tools`,
   `security_and_git` — there may be more by the time you read this).
3. `mcp__serena__read_memory(name)` for **every** listed file. These are short, dense, and
   written exactly for this purpose — don't skim or sample, read them all. Pay particular
   attention to:
   - `theme_architecture` — which template file or template-part owns the area you're about
     to touch, and where Customizer settings already exist vs. need adding.
   - `known_gotchas` — bugs already found and fixed once (double-escaping categories, the
     `page`/`paged` query-var trap, `wp_nav_menu()` icon/hidden-span pitfalls, missing
     `.sub-menu` CSS, image `object-fit`, footer menu-assignment). Don't reintroduce these or
     waste time rediscovering them.
   - `security_and_git` — what's gitignored and why, and the standing requirement to scan for
     secrets before any commit/push.
4. If Serena is not reachable at all in this session (connection failure, not just
   not-yet-loaded), fall back to reading the files directly with Read:
   `.serena/memories/*.md`, and tell the user Serena wasn't reachable rather than silently
   skipping this step.
5. If the requested change touches Figma design parity, also check whether the relevant page/
   section was already pulled and summarized in `figma_and_tools` or in the `.dc.html` exports
   at the repo root before making a fresh Figma MCP call — Figma is on a tight rate limit
   (~20 calls/month), so reuse what's already known first.

Do not proceed to implementation until this step is done.

## 1. Understand where the change belongs

Using what you just read from `theme_architecture`, work out:

- Which template file(s) (`header.php`, `footer.php`, `home.php`, `single.php`, `category.php`,
  `author.php`, etc.) or `template-parts/*.php` own the affected area.
- Whether the content involved is genuinely new business/presentation data. If so, it belongs
  in a **Customizer setting** (see `blog_hub_customize_register()` in `functions.php` for the
  existing pattern/sections) or, for per-author content, a **user-meta field** (see
  `blog_hub_author_profile_fields()`), never hardcoded. This theme is explicitly spec'd as
  presentation-only, no CPTs or business logic locking data to the theme.
- Whether a shared `template-parts/` partial already exists for this kind of content (e.g.
  breadcrumbs, CTA banners, posts grid) before writing new inline markup — reuse over
  duplication, matching how `breadcrumbs.php` was made context-aware rather than copy-pasted
  across `home.php`/`category.php`/`author.php`/`single.php`.
- Relevant design tokens in `assets/css/tokens.css` — never redefine color/spacing tokens
  elsewhere; add new component CSS to `components.css`, `pages.css`, or `article.css` per the
  existing split.

## 2. Implement the change

Standard engineering practice for this codebase:

- Sanitize/escape all dynamic output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`, or a
  custom sanitize callback like `blog_hub_sanitize_map_embed()` for structured HTML such as
  iframes). Watch for the double-escaping trap on category names documented in
  `known_gotchas` — `get_the_category()`/`get_categories()` names are already escaped.
- No new abstractions beyond what the change needs; match the plain, direct style already in
  the theme's PHP files.
- If adding a Customizer field or user-meta field, follow the existing registration pattern
  exactly (section/setting/control triplet, or the profile-fields table row + save-handler
  entry) rather than inventing a new mechanism.

## 3. Verify locally before packaging

This project has a running local Docker WordPress stack (`bloghub_wp`, `bloghub_db`,
`bloghub_pma`) — use it, don't just eyeball the diff:

1. Lint every PHP file you touched:
   `docker exec bloghub_wp php -l /var/www/html/wp-content/themes/blog-hub-new/<path>`
2. If you added/changed a Customizer or user-meta field, set a test value via wp-cli
   (`docker exec bloghub_wp wp theme mod set ...` / `wp user meta update ...`) and confirm it
   renders with `curl -s http://localhost:8080/<path>/ | grep ...` or a Playwright screenshot.
3. Re-check pages you *didn't* directly edit but that share the touched template-part or CSS
   (e.g. a breadcrumbs change must be re-verified on the blog listing, category, author, and
   single-post pages, not just the one you were focused on) — regressions across shared
   partials are the most common way small changes break unrelated pages here.
4. If the change claims to match a Figma design, do a final visual check (screenshot or
   careful HTML diff) against the design reference rather than assuming the code is correct
   because it compiles.

## 4. Rebuild `blog-hub.zip`

The zip is git-ignored and always rebuilt fresh — never hand-edited or patched in place:

```bash
rm -f /Users/kamlesh/Documents/dev/wordpress/blog-hub.zip
rm -rf /tmp/theme-package && mkdir -p /tmp/theme-package
cp -R /Users/kamlesh/Documents/dev/wordpress/wp-content/themes/blog-hub-new /tmp/theme-package/blog-hub
cd /tmp/theme-package && find . -name ".DS_Store" -delete
zip -r -X /Users/kamlesh/Documents/dev/wordpress/blog-hub.zip blog-hub
rm -rf /tmp/theme-package
```

Then verify it's actually in sync before telling anyone it's ready:

```bash
cd /tmp && rm -rf zip-verify && mkdir zip-verify && cd zip-verify
unzip -q /Users/kamlesh/Documents/dev/wordpress/blog-hub.zip
diff -rq /Users/kamlesh/Documents/dev/wordpress/wp-content/themes/blog-hub-new blog-hub
cd /tmp && rm -rf zip-verify
```

`diff -rq` must report zero differences. Never tell the user the zip is updated without having
just run this rebuild — an earlier zip silently going stale after a code change is a real
failure mode on this project.

## 5. Guide the person uploading it to the live site

The zip is uploaded via **Appearance > Themes > Upload Theme** on the live WordPress site —
this instantly swaps the active theme's files without touching existing database content
(posts, pages, users, settings). After upload:

- If the change added or depends on a **Customizer setting** (contact info, CTA banner text,
  map embed, links-line, etc.), tell the uploader to go to **Appearance > Customize** on the
  live site and fill in the equivalent field(s) — Customizer settings are per-site database
  values, not shipped in the theme code, so they must be re-entered on live exactly as they
  were set up locally for testing.
- If the change added or depends on a **nav menu location** (e.g. a new footer column tied to
  `has_nav_menu('footer')`), tell the uploader to check **Appearance > Menus** and assign the
  right menu to that location — a correctly-coded, correctly-gated section will render nothing
  if no menu is assigned, which has been mistaken for a theme bug before (see
  `known_gotchas`).
- If the change added a new **author profile field** (e.g. another `blog_hub_author_*` user
  meta), tell the uploader that each author will need to fill in the new field(s) on their
  **Users > Profile** screen on the live site.
- Remind them: the live Home page (`/`) is Elementor-built and must stay untouched; the Blog
  Hub design lives at `/blog/` via Settings > Reading → Posts page (see `project_overview` for
  why this split exists and why `home.php`, not `front-page.php`, is the file that matters).
- If the live site uses WP Rocket / host-level caching (see `security_and_git`), remind them a
  theme switch can require a full cache clear (or WP Rocket deactivate/reactivate) to avoid
  serving a stale broken page to logged-out visitors.

## 6. Update Serena memories — do this after every change, before finishing

Keep `.serena/memories/` accurate so the next person (or the next session) has full context
without re-deriving it. Use the Serena MCP memory tools (`mcp__serena__*`), not direct file
edits, so cross-references stay consistent:

1. Work out what actually changed and which memory file(s) it affects:

   | Change | Likely file(s) |
   |---|---|
   | New template file, template-part, Customizer section/field, or user-meta field | `theme_architecture` |
   | A bug found and fixed, or a WordPress/plugin gotcha discovered | `known_gotchas` |
   | New Figma node referenced, new `.dc.html` export added, a tool/MCP server added or swapped | `figma_and_tools` |
   | A decision about site architecture, deployment, or what the project even is | `project_overview` |
   | Anything touching git remotes, SSH keys, gitignore rules, or secret handling | `security_and_git` |

   Most changes touch exactly one file. If something doesn't fit any existing file well, it's
   fine to create a new one with `mcp__serena__write_memory` — but check the existing five
   first, since most theme changes are really just additions to `theme_architecture`.

2. For each affected file: `mcp__serena__read_memory(name)` first, then make the smallest
   correct edit — `mcp__serena__edit_memory` for a small, localized addition (one bullet, one
   row), or `mcp__serena__write_memory` with the full updated content for a larger addition.
   Never write a memory file from scratch without reading the current version first.
3. Match the existing writing style: state facts plainly ("Added `blog_hub_cta_badge` theme mod
   controlling the end-CTA ribbon text" not "We thought it would be nice to add..."), no
   conversational framing, no referencing "this task" or a ticket/PR number — these files should
   read the same a year from now. Keep tables as tables, bullet lists as bullet lists, matching
   the surrounding section.
4. Reference other memories using Serena's `mem:<name>` prefix (e.g. `see mem:known_gotchas`),
   matching the existing files — not freeform links. If a shell/Bash tool is available, run
   `uvx --from git+https://github.com/oraios/serena serena memories check .` from the repo root
   to confirm no broken `mem:` references were introduced; this is a read-only check.
5. Never delete an existing memory file or remove another project's entry from the global
   Serena project registry — this machine has multiple unrelated projects registered with
   Serena; only touch this project's own memories.

Report back in one or two lines: which memory file(s) you updated and the one-line gist of the
change — don't restate the whole diff.
