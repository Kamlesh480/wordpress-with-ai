# Sheet updates to paste in manually — SSC Dev Support

I don't have a Google Sheets write tool in this session (only read access via Drive), so I
can't update Status/comment cells directly. Here's exactly what to paste into each row —
organized by tab, in the sheet's own row order. Status column = M, new "Dev comment" column =
N (add it after Status if it doesn't exist yet).

For each row below: set **Status = Done**, and paste the **Dev comment** text into column N.

---

## Header & Footer tab

| Row | Feedback | Status | Dev comment |
|---|---|---|---|
| 11 (Main nav — menu items) | No mobile hamburger menu | Done | Added a hamburger menu that opens/closes the nav below 720px width; current page now also highlights in gold. |
| 24 (Links open in — same tab) | Consider new tab for external/share links | Done | Share buttons and social menu links now open in a new tab. |

*(Rows 5-9, 10, 13-21 are config-only — left Open, see SITE_CONFIG.md.)*

## Blog Hub tab

| Row | Feedback | Status | Dev comment |
|---|---|---|---|
| 9 (Breadcrumb "Blog" on page 2+) | Should show "Home / Blog / Page 2" | Done | Breadcrumb now shows "Home / Blog / Page N" on paginated pages. |
| 14 (Browse Categories dropdown) | Shifts the page down instead of overlaying | Done | Dropdown now overlays the page instead of pushing content down. |
| 18 (Featured eyebrow) | Should say "FEATURED GUIDE" | Done | Changed "Featured" to "Featured Guide". |
| 20 (Featured image) | Not clickable | Done | Featured image now links to the article, matching grid cards. |
| 24 (Featured category tag — wrong) | — | *(config-only, see SITE_CONFIG.md — category data issue, left Open)* | |
| 25 (Latest Posts — possible bug) | Same post can appear on page 1 and page 2 | Done | Fixed — the featured/sticky post is now always excluded from the grid query, not just on page 1. |
| 33 ("Latest Posts" eyebrow) | "FRESH FROM THE CASTING FLOOR" missing | Done | Added a new Customizer field (Front Page Hero → Latest Posts eyebrow text) to set this. |
| 44 (Pagination) | Should have Previous/Next buttons, not just « » | Done | Pagination now shows "« Previous" / "Next »" text. |

*(Rows 16-17, 21, 37, 46 are config-only — categories/CTA copy — left Open, see SITE_CONFIG.md.)*

## Blog Article tab

| Row | Feedback | Status | Dev comment |
|---|---|---|---|
| 13 (H1 case) | Should be uppercase, not sentence case | Done | Title now renders uppercase via CSS. |
| 17 (Share buttons) | "Checked: opens in new tab... no change needed" | Done | Confirmed and fixed anyway — share links didn't actually have target="_blank" in code; added it to all 4 share icons + the 5th on the featured card. |
| 24 (TL;DR) | Raw auto-excerpt ends in "[…]", runs table text together | Done | When no manual excerpt is set, the summary is now built from cleanly-stripped, word-trimmed content instead of WordPress's raw auto-excerpt. |
| 26 (Table header styling) | Table header row is plain | Verified, no change needed | Checked the code and a live example — table headers already render dark navy with white text when the post's HTML has proper `<thead><th>` markup. If a specific article's table still looks wrong, check that post's HTML in the editor. |
| 29 (Sticky TOC + heading case) | TOC positioning odd; heading should be uppercase | Done (heading) / Verified (sticky) | TOC heading now renders uppercase. Checked the sticky positioning code — it's standard CSS `position: sticky` with no conflicting JS, already correct; if it still looks wrong on live, it's likely a caching issue, not a code bug. |
| 37 (Back to top) | Hidden under WhatsApp button | Done | Moved the back-to-top button higher (96px from bottom instead of 24px) so it clears other floating widgets in that corner. |

*(Rows 6, 10, 15, 22, 28, 33-34, 43-47 are config-only/content/data issues — left Open, see SITE_CONFIG.md.)*

## Category Page tab

| Row | Feedback | Status | Dev comment |
|---|---|---|---|
| 14 (Pagination) | Should have Previous/Next buttons | Done | Same pagination fix as Blog Hub — now shared code, applies here too. |

*(All other rows on this tab are the category/location-taxonomy data issue — left Open, see SITE_CONFIG.md, section 6.)*

## Author Page tab

| Row | Feedback | Status | Dev comment |
|---|---|---|---|
| 14 (Header stats) | "13 YEARS ON SITE" / "400+ SITE DELIVERIES OVERSEEN" missing | Done | Added a new optional author profile field ("Extra profile stats") so any author can add extra stat tiles like these. |
| 25 (Privacy: public email) | Publicly shows the author's real login email | Done | Added a separate "Public contact email" author field; the page no longer uses the account's login email, and falls back to the site-wide contact email if the new field is left blank. |
| 29 ("Latest Articles" eyebrow) | Needs "WRITTEN BY {AUTHOR}" | Done | Added "Written by {Author}" above the Latest Articles heading. |
| 39 (Pagination) | Needs Previous/Next buttons | Done | Same pagination fix as Blog Hub. |

*(Rows 13, 17, 24, 35 are config-only or confirmed-as-intended-by-design — left Open; see SITE_CONFIG.md, section 7, for the fields each author needs to fill in.)*

---

## Rows intentionally left Open (config, not code)

Every row not listed above as "Done" is either (a) a Customizer/menu/category setup item —
covered step-by-step in `SITE_CONFIG.md` — or (b) something already confirmed correct in code.
Per your instruction, these stay Open until you've gone through `SITE_CONFIG.md` and confirm
it's been applied on the live site — then let me know and I'll mark them Done with a comment
too (or do it directly if Sheets write access becomes available in a future session).
