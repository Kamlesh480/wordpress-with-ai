# Blog Hub — Site Configuration Checklist

This is a step-by-step checklist for configuring the Blog Hub theme's content and
settings through wp-admin — NOT theme code. Everything here is intentionally kept
out of the theme (per the "presentation only, no hardcoded business data" spec), so
it must be set per-environment: once on staging, then again on production when the
theme goes live there.

Use this after uploading `blog-hub.zip` via **Appearance > Themes > Upload Theme**.

**How to use this file:** every setting below has a "**Paste this value:**" line in
a code block. Copy that text as-is into the matching field in wp-admin. Where a
real asset (a logo file, a real phone number) is needed instead of placeholder
text, that's called out explicitly — replace it with your own before going live,
but the placeholder is safe to use on staging to see everything working end to end.

Status: ⬜ = not yet done · ✅ = done. Update the checkboxes as you go so this stays
a living record of what's configured on each environment.

---

## 1. Site Identity (Appearance > Customize > Site Identity)

- ⬜ **Logo** — upload the actual "SS" monogram / Shubh Sanskar Concrete logo image
  file (PNG or SVG, ~240×60px works well). Until this is set, the header falls
  back to showing the site name as plain text, which is what's currently
  happening. *(No text value to paste — this one needs the real logo image file
  from whoever has the brand assets.)*

- ⬜ **Site Title**
  Paste this value:
  ```
  Shubh Sanskar Concrete
  ```

- ⬜ **Tagline**
  Paste this value:
  ```
  Building Trust, Creating Products
  ```

## 2. Contact Details (Appearance > Customize > Contact Details)

All of these are optional — nothing in the header/footer renders until they're
filled in. This explains most of the "missing" feedback on the Header & Footer tab.
**Replace the placeholder phone/email below with the real business contact details
before this goes live** — these are safe placeholders for staging only.

- ⬜ **Email**
  Paste this value:
  ```
  info@shubhsanskarconcrete.com
  ```

- ⬜ **Phone**
  Paste this value:
  ```
  +91 98765 43210
  ```

- ⬜ **Phone 2** *(shown as a second number in the header top bar only — the
  footer only ever shows one phone number, matching the design)*
  Paste this value:
  ```
  +91 98765 43211
  ```

- ⬜ **Address**
  Paste this value:
  ```
  Precast Works, Industrial Area, Indore, Madhya Pradesh 452001
  ```

- ⬜ **Map embed** — go to Google Maps → search your real address → Share →
  Embed a map → copy the `<iframe ...></iframe>` code it gives you, and paste
  that whole thing in. Only a genuine Google Maps embed iframe is accepted by
  the theme; anything else is stripped for security, so don't try to paste a
  shortened link or a different embed provider here.
  **Note:** the embed currently configured locally for testing uses fake
  coordinates and returns a 400 error in the browser console — don't reuse it,
  generate a fresh one from Google Maps for your real address.
  *(No single safe placeholder to paste here — this one genuinely needs a real
  address's embed code, even for staging, or just leave it blank to hide the
  "Find Us" column until you have one.)*

## 3. Front Page Hero (Appearance > Customize > Front Page Hero)

These control the Blog Hub (`/blog/`) page 1 copy.

- ⬜ **Eyebrow text**
  Paste this value:
  ```
  THE SHUBH SANSKAR BLOG
  ```

- ⬜ **Heading** — page 1's H1. If left blank, falls back to the Posts page's
  own title, then the site name.
  Paste this value:
  ```
  Concrete & Construction Insights
  ```

- ⬜ **Intro paragraph** — short paragraph under the heading. Basic HTML links
  are allowed, so you can link words straight to your products/about/quote
  pages (edit the `href` values to your real page URLs before using).
  Paste this value:
  ```
  Since 2010 we have manufactured precast concrete products for contractors and municipal projects across the region. Browse our guides below, explore our <a href="/our-products/">products</a>, or <a href="/contact-us/">get a quote</a>.
  ```

- ⬜ **Latest Posts eyebrow text** *(new field, added to fix a feedback item)* —
  a short label above "Latest Posts" on page 1.
  Paste this value:
  ```
  Fresh from the Casting Floor
  ```

- ⬜ **Newsletter form action URL** — the submission endpoint your email service
  (Mailchimp, Brevo, etc.) gives you. The whole newsletter block stays hidden
  until this is set, so leave it blank if you don't have one yet.
  Paste this value (example only — replace with your own Mailchimp/Brevo form
  action URL, this placeholder will not actually work):
  ```
  https://shubhsanskarconcrete.us1.list-manage.com/subscribe/post?u=XXXXXXXX&id=YYYYYYYY
  ```

- ⬜ **Secondary links line** — a short sentence with links shown near the
  bottom of the blog listing. Basic HTML allowed; edit the `href` values to
  your real page URLs.
  Paste this value:
  ```
  Ready to order? Explore <a href="/our-products/">our precast products</a>, learn <a href="/about-us/">about Shubh Sanskar Concrete</a>, or <a href="/contact-us/">contact our team</a> for a quote.
  ```

## 4. Blog CTA Banners (Appearance > Customize > Blog CTA Banners)

These are the "Request a Quote" strips/banners the feedback sheet flagged as
missing. **Both parts of each pair (text/heading AND button text/link) must be
filled in together, or that whole block stays hidden** — this is why point 4 can
look confusing: a lone button text with no link (or vice versa) will never show up.

- ⬜ **Inline banner text** — short strip shown after the featured post, on
  page 1 of the Blog Hub only.
  Paste this value:
  ```
  Need pricing on RCC hume pipes, manhole covers, or paver blocks?
  ```

- ⬜ **Inline banner button text**
  Paste this value:
  ```
  Request a Quote
  ```

- ⬜ **Inline banner button link** — point this at your real contact/quote page.
  Paste this value (edit the path if your quote page URL is different):
  ```
  /contact-us/
  ```

- ⬜ **End-of-page CTA heading** — the larger dark banner shown at the bottom
  of the Blog Hub, Blog Article, Category, and Author pages.
  Paste this value:
  ```
  Have a Project to Discuss?
  ```

- ⬜ **End-of-page CTA description**
  Paste this value:
  ```
  Tell us about your site requirements and our team will help you choose the right precast products, grades, and delivery timeline.
  ```

- ⬜ **End-of-page CTA button text**
  Paste this value:
  ```
  Request a Quote
  ```

- ⬜ **End-of-page CTA button link** — same real contact/quote page as above.
  Paste this value (edit the path if different):
  ```
  /contact-us/
  ```

## 5. Menus (Appearance > Menus)

Create these three menus if they don't exist, add items, then assign each to its
theme location at the bottom of the menu editor (find this via the "Manage
Locations" tab, or the dropdown at the bottom of the menu editor screen).

- ⬜ **Primary Navigation** → location: **Primary**. Shown in the header.
  Suggested menu items, in this order (use "Custom Links" or your existing
  Pages — edit each URL to match your real pages):
  ```
  Home            → /
  About Us        → /about-us/
  Our Products    → /our-products/   (add sub-items under this one for each product line, e.g. RCC Hume Pipes, Manhole Covers, Paver Blocks, Cement Poles)
  Blog            → /blog/
  Contact Us      → /contact-us/
  ```
  The current page highlights itself automatically in gold — no manual setup
  needed for that part.

- ⬜ **Footer Links** → location: **Footer**. Populates the "Important Links"
  footer column. The same 5 items as Primary Navigation above is a reasonable
  default — you can literally duplicate that menu and rename the copy, then
  assign the copy to the Footer location.

- ⬜ **Social Links** → location: **Social**. Each item's URL determines its
  icon automatically (Facebook, Instagram, LinkedIn, YouTube, WhatsApp, etc. —
  anything else falls back to a generic chain-link icon). Add one item per
  real social profile your business has, for example:
  ```
  Facebook    → https://facebook.com/shubhsanskarconcrete
  Instagram   → https://instagram.com/shubhsanskarconcrete
  LinkedIn    → https://linkedin.com/company/shubhsanskarconcrete
  WhatsApp    → https://wa.me/919876543210
  ```
  Only add the ones you actually have — don't paste placeholder social links
  live, since they'll be public-facing broken links.

**Mobile note:** the primary menu now has a hamburger toggle below 720px width
(fixed in this round of changes) — no config needed, just confirm it after
uploading.

## 6. Categories (Posts > Categories)

**Important — this is the biggest content gap found during QA.** The live site's
actual WordPress categories are **location-based** ("Areas We Serve": Haryana,
Delhi, Uttar Pradesh), not the **topic-based** categories the design and the blog
templates assume. This is why category tags/breadcrumbs/dropdowns show the wrong
thing everywhere on the live site.

- ⬜ Create these topic categories under **Posts > Categories > Add New Category**
  (if they don't already exist alongside the location ones):
  ```
  Name: RCC Hume Pipes
  Slug: rcc-hume-pipes
  Description: Grade selection, jointing method, and handling guidance for RCC hume pipes.

  Name: Manhole Covers & Systems
  Slug: manhole-covers-systems
  Description: Frame and cover selection, chamber depths, and municipal specification notes.

  Name: Cement Poles
  Slug: cement-poles
  Description: Pole sections, load ratings, and installation practice for rural and urban lines.

  Name: Paver Blocks
  Slug: paver-blocks
  Description: Interlocking block grades, laying patterns, and site preparation guidance.

  Name: Industry & Compliance
  Slug: industry-compliance
  Description: IS codes, testing standards, and quality control across our casting yard.
  ```
  (These descriptions double as the "Description" field mentioned below — paste
  each one into its matching category's Description box.)

- ⬜ Re-assign each blog post to its correct **topic** category (not a location
  category) as the primary/first category — the theme always uses a post's
  FIRST assigned category for its tag, breadcrumb, and card label. Go to
  **Posts > All Posts**, open each post, and under "Categories" check the
  correct topic box (and uncheck the location-only one if it's currently first).

- ⬜ Decide whether "Areas We Serve" / location categories should stay as a
  *separate* taxonomy or page structure outside the blog, rather than mixed
  into the same WordPress category system the blog templates read from. This
  is a structural decision, not something to paste a value for — flag it to
  whoever owns the site's overall content structure if you're unsure.

## 7. Author Profiles (Users > Profile, for each author)

Scroll to the **"Blog Hub Author Profile"** section on each author's profile
screen (Users > All Users > click a name > scroll down). Example values below
are for the demo author "Ramesh Patidar" used during development — replace the
name/details with your real author's information.

- ⬜ **Title**
  Paste this value:
  ```
  Site Engineer, Quality Control
  ```

- ⬜ **Pull quote**
  Paste this value:
  ```
  Half the site problems we see were decided on paper, weeks before the pour.
  ```

- ⬜ **LinkedIn URL**
  Paste this value (edit to the real profile URL):
  ```
  https://www.linkedin.com/in/ramesh-patidar
  ```

- ⬜ **Expertise tags** — comma-separated.
  Paste this value:
  ```
  RCC Hume Pipes, Manhole Systems, IS Code Compliance
  ```

- ⬜ **"At a glance" facts** — one short fact per line.
  Paste this value:
  ```
  Diploma in Civil Engineering
  Certified on IS 458 & IS 1726 testing
  Covers Indore – Bhopal sites
  Joined Shubh Sanskar in 2013
  ```

- ⬜ **"Request a Quote" button link** — leave blank to hide the button.
  Paste this value (edit the path if different):
  ```
  /contact-us/
  ```

- ⬜ **Public contact email** *(new field, added to fix a privacy issue)* —
  **must be set**, or the author page falls back to the site-wide Customizer
  contact email. It will NEVER show the author's real WordPress login email.
  Paste this value (edit to the real public email for this author):
  ```
  ramesh@shubhsanskarconcrete.com
  ```

- ⬜ **Extra profile stats** *(new field, added to fix a feedback item)* — one
  per line, as `value | label`.
  Paste this value:
  ```
  13 | Years on Site
  400+ | Site Deliveries Overseen
  ```

- ⬜ **Biographical Info** (WordPress's own built-in field, same screen) — the
  author's actual bio, shown in the About section. Feedback noted this
  currently shows the *company tagline* instead of a real author bio on the
  live site — make sure each author has their own bio text here, not shared
  company copy.
  Paste this value:
  ```
  Ramesh joined Shubh Sanskar Concrete in 2013 and now leads site quality control across our RCC hume pipe and manhole system deliveries. He has walked drainage lines from Indore to Bhopal and signs off every batch before it leaves the yard.
  ```

- ⬜ **Gravatar** — WordPress has no built-in photo upload; author photos come
  from Gravatar (gravatar.com, tied to the account's email) or an avatar
  plugin. Without one, a generic grey silhouette shows. *(No text value to
  paste — create a free account at gravatar.com using this author's exact
  WordPress login email, upload a photo there.)*

## 8. Widgets (Appearance > Widgets)

Both are optional — leave empty if you don't need them yet.

- ⬜ **Footer Widgets** area — shown as an extra footer column if populated.
  Add any standard widget (e.g. a "Text" widget with a short note, or a
  "Custom HTML" widget).
- ⬜ **Single Post Rail** area — shown in the sticky right rail on single blog
  posts. A good default is a "Custom HTML" widget with a simple quote-request
  prompt, e.g.:
  ```
  <div style="text-align:center;padding:16px;border:1px solid #ddd;">
    <p>Need a custom quote?</p>
    <a href="/contact-us/">Talk to our team →</a>
  </div>
  ```

## 9. Settings > Reading

- ⬜ **Your homepage displays** → select:
  ```
  A static page
  ```
- ⬜ **Homepage** → select the existing Elementor-built homepage from the
  dropdown. **Do not change this to anything else** — the live homepage must
  stay untouched.
- ⬜ **Posts page** → select (or create) the page that should host the Blog
  Hub design — e.g. a page simply titled "Blog". This makes it render at
  whatever that page's URL is (typically `/blog/`), using the theme's
  `home.php` (see the theme's own `.serena/memories/project_overview.md` for
  why that file, not `front-page.php`, is the one that matters).
- ⬜ **Blog pages show at most** → a number, e.g.
  ```
  12
  ```
  This controls posts per page on Category and Author archive pages (the main
  Blog Hub listing always shows 12 regardless of this setting).

---

## Known non-issues (verified during this QA round, no action needed)

- Share buttons (Facebook/WhatsApp/LinkedIn/X) now open in a new tab as of this
  round of fixes — already covered, not a config item.
- The article content table header (dark navy row with white text) already
  renders correctly when the post's table HTML includes proper `<thead><th>`
  markup — if a specific table still looks wrong, check that post's HTML in the
  editor rather than assuming a theme bug.
- The sticky Table of Contents rail already uses standard CSS `position: sticky`
  and scroll-spy highlighting — this part is not a caching issue.

---

## Troubleshooting: Table of Contents links don't scroll anywhere

**What "working" looks like:** on a single blog post, clicking an item in the
right-hand "Table of Contents" box should smoothly scroll the page down to that
section's heading.

**If clicking does nothing:**

1. **Check how that specific post was written.** The Table of Contents only
   reliably works for headings written as a plain **Heading 2** in WordPress's
   own editor (the Block editor, or Classic editor). If the post's body (or
   just that one section) was built with **Elementor** instead, its heading
   widgets can bypass the normal process the theme uses to make a heading
   clickable.
   - **Going forward, for new blog posts:** write the body in the standard
     WordPress editor with real **Heading 2** blocks for each section — not
     Elementor — so the Table of Contents, reading time, and other theme
     features all work exactly as intended, with no extra steps.
   - **For existing Elementor-built posts:** the theme now auto-repairs this
     in the browser (added in this round of fixes — it matches each Table of
     Contents entry to the heading with the same visible text on the page,
     even if that heading came from Elementor, and makes it clickable). If a
     link still doesn't work after this fix, it usually means the entry's text
     in the Table of Contents doesn't exactly match the heading's visible text
     on the page (e.g. extra spacing, different capitalization) — editing the
     heading so its text matches exactly (or re-typing the section as a plain
     Heading 2) resolves it.
2. **If it still doesn't work after checking the above**, that's worth flagging
   as a real bug rather than a content issue — note which specific post/URL
   and which specific Table of Contents entry doesn't scroll.

---

## When setting this up on production

Repeat this entire checklist on the production environment once staging is
verified — none of these settings carry over automatically between environments.
**Before going live, swap every placeholder value above (phone numbers, emails,
addresses, social links, newsletter URL) for the real business details** — the
values in this file are safe, working examples for staging, not final production
content. Keep a copy of this file's checkboxes (or a duplicate) per environment so
it's clear what's been configured where.
