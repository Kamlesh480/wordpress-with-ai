# QA feedback round (2026-10-20) — "SSC Dev Support" Google Sheet

A Google Sheet titled **"SSC Dev Support"** (owned by mridulkathuria26@gmail.com, shared with
the project's Google account) was used for structured QA: one "How to use" tab plus one tab per
page template (Blog Hub, Blog Article, Category Page, Author Page, Header & Footer), each row
mapping one UI element to its template file, with a "Your feedback" / Priority / Status set of
columns for reviewer notes. Sheet URL:
https://docs.google.com/spreadsheets/d/1EaF8dT7SBTIyyp_qIFneR_scSanSUi6eRvp_jp9wcis/

No direct Google Sheets range-write API was available in-session (only a generic Google Drive
MCP toolset: read_file_content for a summarized/sampled preview, download_file_content for a
full raw export). To read every row reliably, the file was downloaded as XLSX via
`download_file_content` with `exportMimeType:
application/vnd.openxmlformats-officedocument.spreadsheetml.sheet`, saved, and parsed with
Python's `openpyxl` (installed via pip) — the generic `read_file_content` tool only returns a
sampled preview (a handful of rows per tab), not the full sheet, for a document this size.

## Outcome: ~45 feedback rows split into two buckets

**Config-only (not a code bug)** — the live site simply doesn't have Customizer fields filled
in, menus assigned, or correct category data yet. Full checklist written to
`SITE_CONFIG.md` at the project root (not a memory — it's meant to be read/updated directly,
and reused for production setup later). Biggest finding: the live site's real WordPress
categories are **location-based** ("Areas We Serve": Haryana, Delhi, Uttar Pradesh) rather than
the **topic-based** categories the design and templates assume (RCC Hume Pipes, Manhole Covers
& Systems, Cement Poles, Paver Blocks, Industry & Compliance) — this is why category
tags/breadcrumbs/dropdowns all show wrong content site-wide. Per the user's explicit
instruction, Status was NOT changed to Done for these sheet rows — they stay open until the
user has gone through `SITE_CONFIG.md` and confirms it's applied on the live site.

**Code-fixable** — fixed in this round (see mem:theme_architecture for the two new author
fields and the new mobile-nav markup this added):
- Mobile hamburger menu added to header.php/main.js/components.css — there was previously no
  mobile nav at all, items just stacked open.
- Social menu links + all 5 share-button instances (featured card, single-post header) now open
  in a new tab (`target="_blank" rel="noopener"`) via a new `nav_menu_link_attributes` filter
  (`blog_hub_social_menu_link_attributes`) for the social menu, and direct markup edits for the
  share buttons.
- Breadcrumb on the blog listing now shows "Home / Blog / Page N" on page 2+ instead of just
  "Blog" (template-parts/breadcrumbs.php gained paged-awareness for the `is_home()` branch).
- Category dropdown (`template-parts/category-dropdown.php` + pages.css `.bh-category-dropdown`)
  now overlays the page (`position: absolute`) instead of pushing content down
  (`position: relative`) — was a real CSS bug, not a design-mismatch issue.
- Fixed a real duplicate-post bug in home.php: `$featured_id` was only computed on page 1, so
  `post__not_in => [0]` excluded nothing on page 2+, letting the featured/sticky post reappear
  in the grid on a later page. Now always computed, with the featured CARD's rendering (not the
  exclusion) still gated to page 1 only.
- Featured post eyebrow text "Featured" → "Featured Guide"; featured image is now a clickable
  link to the post (previously a non-clickable div), matching grid cards elsewhere.
- Pagination (`template-parts/pagination.php`) now shows "« Previous" / "Next »" text instead of
  bare « » arrows, via `paginate_links()`'s `prev_text`/`next_text` args.
- TL;DR box on single posts no longer uses WordPress's raw `get_the_excerpt()` fallback (which
  could run table/list text together and end in "[…]"); when no manual excerpt is written, it
  now strips tags/shortcodes and re-trims with `wp_trim_words()` for a clean summary.
- Article H1 and the sticky TOC's "Table of Contents" label now render uppercase via
  `text-transform: uppercase` (design uses literal uppercase text; CSS transform was chosen to
  avoid mangling post titles/data).
- Back-to-top button moved from `bottom: 24px` to `bottom: 96px` to avoid colliding with
  third-party floating widgets (WhatsApp chat, accessibility toolbar) that commonly anchor to
  the same bottom-right corner.
- Author page: added "Written by {Author}" eyebrow above "Latest Articles"; added the two new
  author fields described in mem:theme_architecture (public email, extra stats).

**Verified-as-already-correct, NOT a bug** (confirmed by reading code/CSS and screenshotting,
don't re-investigate these without new evidence): article content table header styling (already
navy/white via `.bh-article-content thead tr`/`th` — works correctly when the post's HTML has
proper `<thead><th>` markup); sticky TOC behavior (already plain CSS `position: sticky`, no
conflicting JS) — if either still looks broken live, suspect WP Rocket/host caching (see
mem:security_and_git) serving a stale build, not a current code issue.

## Process note for next time

After `blog-hub.zip` was rebuilt/verified and `SITE_CONFIG.md` written, the plan was to update
the sheet's Status/comment columns for the code-fixable rows (mark Done + a one-line note) —
this requires a real Google Sheets write-capable tool (batchUpdate / values.update by A1 range),
which was not available this session. If a Sheets-specific MCP tool becomes available, use it
to set Status="Done" and append a short note to a new "Dev comment" column per fixed row, using
the row-by-row breakdown above. Do not guess row numbers from memory — re-read the sheet first,
since the user may have edited it since this round.
