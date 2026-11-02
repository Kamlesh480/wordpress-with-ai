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

**Live-values audit (added 2026-11-02):** many placeholder values below have been replaced
with real values pulled from the live site (shubhsanskarconcrete.com) on 22–23 Oct 2026, per
`SSC Site Config Checklist - Live Values.xlsx`. Anything still marked **NEEDS DECISION** or
**NEEDS INPUT** below is a real open question from that audit, not a placeholder — resolve it
before going live, don't just paste something in to clear the checkbox.

---

## 1. Site Identity (Appearance > Customize > Site Identity)

- ⬜ **Logo** — the live site already has two real logo files (confirmed 22 Oct 2026):
  - Header logo (dark background): `https://shubhsanskarconcrete.com/wp-content/uploads/2024/11/25.png`
    — gold "SS" mark + white wordmark. Use this one in the theme's header logo slot;
    set its alt text to "Shubh Sanskar Concrete" (live site has no alt text set).
  - Footer / light-background logo: `https://shubhsanskarconcrete.com/wp-content/uploads/2024/11/bottom.png`
    (dark version of the same mark) — only needed if the theme has a second logo slot
    for a light background.
  Until the header logo is set, the header falls back to showing the site name as
  plain text.

- ⬜ **Site Title** — confirmed against the live site (22 Oct 2026), no change from below.
  Paste this value:
  ```
  Shubh Sanskar Concrete
  ```

- ⬜ **Tagline** — **NEEDS DECISION**: the live site currently shows "Leading Precast
  Concrete Products Manufacturer" in this slot, but the design and business context use
  the line below. Confirm which one to actually use before pasting.
  Paste this value (pending confirmation):
  ```
  Building Trust, Creating Products
  ```

## 2. Contact Details (Appearance > Customize > Contact Details)

All of these are optional — nothing in the header/footer renders until they're
filled in. This explains most of the "missing" feedback on the Header & Footer tab.
**Replace the placeholder phone/email below with the real business contact details
before this goes live** — these are safe placeholders for staging only.

- ⬜ **Email** — real address confirmed on the live header/footer/`/contact/` (22 Oct 2026),
  replacing the old placeholder.
  Paste this value:
  ```
  shubhsanskarconcrete@gmail.com
  ```

- ⬜ **Phone** — real number confirmed live (22 Oct 2026), replacing the placeholder.
  Paste this value:
  ```
  +91 7042103883
  ```

- ⬜ **Phone 2** *(shown as a second number in the header top bar only — the
  footer only ever shows one phone number, matching the design)* — real number
  confirmed live (22 Oct 2026); note the live header actually lists this number
  first, ahead of Phone 1 — check if that order matters once the theme is live.
  Paste this value:
  ```
  +91 9217021955
  ```

- ⬜ **Address** — real address confirmed on the live footer and `/contact/` (22 Oct 2026),
  replacing the placeholder (which had the wrong city/state entirely).
  Paste this value:
  ```
  33, Sohna Rd, Opposite Devilal Garden, Ballabhgarh, Faridabad, Haryana 121004
  ```
  **NEEDS DECISION:** the live `/contact/` page also lists two factory addresses (45 KM,
  Village Gadpuri, Mathura Road, NH-19, Palwal 121102; and Village Alawalpur,
  Amarpur-Palwal Road, Palwal 121102) not mentioned in the business context notes —
  confirm whether either factory address should also appear in the footer or schema
  (they're already used in section 12's office/factory list below).

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
  **NEEDS INPUT:** the live footer already has a working Google Map embed for "Shubh
  Sanskar Concrete (I) Pvt. Ltd." — inspect that embed on the live site, or re-generate
  a fresh one from Google Maps for the same business listing, and paste its iframe here.

## 3. Front Page Hero (Appearance > Customize > Front Page Hero)

These control the Blog Hub (`/blog/`) page 1 copy.

- ⬜ **Eyebrow text** — live `/blog/` currently has none; this is a proposed value
  pending approval, not yet confirmed.
  Paste this value:
  ```
  THE SHUBH SANSKAR BLOG
  ```

- ⬜ **Heading** — page 1's H1. If left blank, falls back to the Posts page's
  own title, then the site name. Live `/blog/` currently just shows "Blog" as its H1.
  Paste this value:
  ```
  CONCRETE & CONSTRUCTION INSIGHTS
  ```

- ⬜ **Intro paragraph** — short paragraph under the heading. Basic HTML links
  are allowed, so you can link words straight to your products/about/quote
  pages. Live `/blog/` currently has none (only a meta description). Draft below
  uses the real page slugs (`/products/`, `/contact/`) and the real founding year/
  location from the business context — **needs approval** before pasting.
  Paste this value:
  ```
  Since 2010 we have manufactured RCC pipes and other precast concrete products in Faridabad, Haryana. These guides cover how to choose, specify and order them. Browse our <a href="/products/">products</a> or <a href="/contact/">contact us</a> for your project.
  ```

- ⬜ **Latest Posts eyebrow text** *(new field, added to fix a feedback item)* —
  a short label above "Latest Posts" on page 1.
  Paste this value:
  ```
  Fresh from the Casting Floor
  ```

- ⬜ **Newsletter form action URL** — **NEEDS INPUT, currently blocked**: the live site has
  no newsletter signup anywhere, and no email-service provider has been decided yet. The
  whole newsletter block stays hidden until this is set, so leave it blank until a provider
  (Mailchimp, Brevo, etc.) is chosen — or decide to skip the newsletter for launch entirely.
  Paste this value (example only — replace with your own Mailchimp/Brevo form
  action URL, this placeholder will not actually work):
  ```
  https://shubhsanskarconcrete.us1.list-manage.com/subscribe/post?u=XXXXXXXX&id=YYYYYYYY
  ```

- ⬜ **Secondary links line** — a short sentence with links shown near the
  bottom of the blog listing. Basic HTML allowed. Updated below to the real page
  slugs (`/products/`, `/about/`, `/contact/`) — **needs approval**, draft text only.
  Paste this value:
  ```
  Ready to order? Explore <a href="/products/">our precast products</a>, learn <a href="/about/">about Shubh Sanskar Concrete</a>, or <a href="/contact/">contact our team</a> for a quote.
  ```

## 4. Blog CTA Banners (Appearance > Customize > Blog CTA Banners)

These are the "Request a Quote" strips/banners the feedback sheet flagged as
missing. **Both parts of each pair (text/heading AND button text/link) must be
filled in together, or that whole block stays hidden** — this is why point 4 can
look confusing: a lone button text with no link (or vice versa) will never show up.

- ⬜ **Inline banner text** — short strip shown after the featured post, on
  page 1 of the Blog Hub only. Live site has no CTA banners at all today. Draft
  below deliberately avoids any price or delivery-time promise — **needs approval**.
  Paste this value:
  ```
  Need pricing on RCC hume pipes or other precast products? Send us your requirement.
  ```

- ⬜ **Inline banner button text**
  Paste this value:
  ```
  Request a Quote
  ```

- ⬜ **Inline banner button link** — point this at your real contact/quote page.
  **NEEDS CONFIRMATION:** the live site has no dedicated quote page — `/contact/` is the
  only enquiry page, and its real slug is `/contact/`, not `/contact-us/`. The audit also
  suggests adding a UTM tag to track clicks from this specific banner.
  Paste this value (edit if a dedicated quote page is created later):
  ```
  https://shubhsanskarconcrete.com/contact/?utm_source=blog&utm_medium=inline_cta
  ```

- ⬜ **End-of-page CTA heading** — the larger dark banner shown at the bottom
  of the Blog Hub, Blog Article, Category, and Author pages. Wording confirmed against
  the live-values audit's proposal (22 Oct 2026) — live site has no CTA banners today.
  Paste this value:
  ```
  Have a Project to Discuss?
  ```

- ⬜ **End-of-page CTA description** — **needs approval**: the original design copy
  promised a price and delivery date; the draft below deliberately drops that promise
  since neither is confirmed yet.
  Paste this value:
  ```
  Tell us the product, grade and quantity you need and our team will get back to you.
  ```

- ⬜ **End-of-page CTA button text**
  Paste this value:
  ```
  Request a Quote
  ```

- ⬜ **End-of-page CTA button link** — same real contact/quote page as above.
  **NEEDS CONFIRMATION** — see the Inline banner button link note above; same real slug
  and UTM-tagging logic applies, with a different UTM tag to tell the two banners apart.
  Paste this value:
  ```
  https://shubhsanskarconcrete.com/contact/?utm_source=blog&utm_medium=end_cta
  ```

## 5. Menus (Appearance > Menus)

Create these three menus if they don't exist, add items, then assign each to its
theme location at the bottom of the menu editor (find this via the "Manage
Locations" tab, or the dropdown at the bottom of the menu editor screen).

- ⬜ **Primary Navigation** → location: **Primary**. Shown in the header. The live site's
  actual menu structure is already built (confirmed 22 Oct 2026) — reproduce it rather
  than the guesses below (real slugs, real 11-item Products dropdown, and a real
  **Areas We Serve** top-level item the original design mockup left out by mistake but
  the live site keeps):
  ```
  Home            → /
  About Us        → /about/
  Products        → /products/   (dropdown, 11 real sub-items: /rcc-pipes/, /rcc-manhole-system/,
                     /sfrc-manhole-cover/, /concrete-drain-covers/, /cement-paver-blocks/,
                     /concrete-kerb-stone/, /precast-drain/, /concrete-road-barriers/,
                     /rcc-tree-guards/, /garden-bench/, /customized-products/)
  Areas We Serve  → /areas-we-serve/
  Contact         → /contact/
  Blog            → /blog/
  ```
  **Note:** the live order is Contact then Blog; the original Figma design showed Blog
  before Contact — no decision has been made on which order to keep, confirm before
  building this menu. The current page highlights itself automatically in gold — no
  manual setup needed for that part.

- ⬜ **Footer Links** → location: **Footer**. Populates the "Important Links"
  footer column. **NEEDS DECISION:** the live footer currently repeats the entire
  primary menu structure, including all 11 product sub-items, but the design mockup's
  footer only shows 5 short links with no product sub-items — decide which to use rather
  than assuming either is correct. The live footer also has one extra link,
  **RCC Hume Pipe** → `/rcc-hume-pipe/`, that isn't in any menu — check whether that page
  is actually live or just redirects before deciding whether to carry it over.

- ⬜ **Social Links** → location: **Social**. Each item's URL determines its
  icon automatically (Facebook, Instagram, LinkedIn, YouTube, WhatsApp, etc. —
  anything else falls back to a generic chain-link icon). Real profiles confirmed live
  (22 Oct 2026):
  ```
  Facebook    → https://www.facebook.com/shubhsanskarconcrete
  Instagram   → https://www.instagram.com/shubhsanskarconcrete/
  LinkedIn    → https://www.linkedin.com/company/shubhsanskarconcrete/
  X (Twitter) → https://twitter.com/sscconcrete   NEEDS DECISION: an older post on the
                site instead links to twitter.com/shubhsanskarc — confirm which handle
                is actually current before using either.
  ```
  No YouTube channel found live — leave it out unless one actually exists. No public
  WhatsApp number was found on the live site either (see Contact Details → WhatsApp,
  NEEDS INPUT in section 8) — don't invent one.

**Mobile note:** the primary menu now has a hamburger toggle below 720px width
(fixed in this round of changes) — no config needed, just confirm it after
uploading.

## 6. Categories (Posts > Categories)

**Important — this is the biggest content gap found during QA.** The live site's
actual WordPress categories are **location-based** ("Areas We Serve": Haryana,
Delhi, Uttar Pradesh), not the **topic-based** categories the design and the blog
templates assume. This is why category tags/breadcrumbs/dropdowns show the wrong
thing everywhere on the live site.

**Live audit update (22 Oct 2026):** a full audit of the live site's 43 published posts
(all by one author) replaced the guessed topic-category list below with 5 categories
matched to the actual product lines and existing post content, plus a post-by-post
mapping for every one of the 43 posts.

**✅ Approved by the user, 2026-11-02** — both the 5-category list and the full post
mapping in `SSC Site Config Checklist - Live Values.xlsx` (tab "6 Post Mapping") are
confirmed. What's left is the mechanical work of actually creating these categories and
re-assigning all 43 posts in wp-admin (or via wp-cli) on each environment — still
tracked with ⬜ below per environment, plus the 37-vs-36 post-count discrepancy noted
below, which should be resolved during that work rather than before it.

- ⬜ Create these topic categories under **Posts > Categories > Add New Category**
  (if they don't already exist alongside the location ones) — **supersedes** the
  category names originally guessed for this section:
  ```
  Name: RCC & Hume Pipes
  Slug: rcc-hume-pipes
  Covers: NP2/NP3/NP4 pipes, specifications, price lists, testing, culverts, manufacturing
  Posts assigned: 20
  Related product page: https://shubhsanskarconcrete.com/rcc-pipes/

  Name: Manhole & Drain Covers
  Slug: manhole-drain-covers
  Covers: SFRC and concrete manhole covers, drain covers, saucer drain
  Posts assigned: 9
  Related product page: https://shubhsanskarconcrete.com/sfrc-manhole-cover/

  Name: Paver Blocks & Kerb Stones
  Slug: paver-blocks-kerb-stones
  Covers: Interlocking pavers, paver price and design, kerb stones, interlocking tiles
  Posts assigned: 7
  Related product page: https://shubhsanskarconcrete.com/cement-paver-blocks/

  Name: Road Safety & Street Products
  Slug: road-safety-street-products
  Covers: Jersey barriers, bollards, tree guards
  Posts assigned: 3
  Related product page: https://shubhsanskarconcrete.com/concrete-road-barriers/

  Name: Precast Basics & Guides
  Slug: precast-basics-guides
  Covers: General precast/RCC explainers, HSN code, company price list — posts that
  don't belong to one specific product
  Posts assigned: 5
  Related product page: https://shubhsanskarconcrete.com/products/
  ```

- ⬜ Keep these existing live categories rather than deleting them:
  ```
  Blogs (id 6, 36 posts)            → keep, demote to SECOND category on every post
                                       (the topic category goes first)
  Areas we Serve (id 296, 0 posts)  → keep as the parent of the location categories;
                                       never set as a post's first category
  Haryana / Delhi / Uttar Pradesh
    (ids 293/294/295, 3/2/2 posts)  → keep, with the topic category first and the
                                       location category second, for the 7 real
                                       service-area posts
  Uncategorized (id 1, 0 posts)     → leave unused
  ```

- ⬜ Re-assign each blog post to its correct **topic** category (not a location
  category) as the primary/first category — the theme always uses a post's
  FIRST assigned category for its tag, breadcrumb, and card label. Go to
  **Posts > All Posts**, open each post, and under "Categories" check the
  correct topic box (and uncheck the location-only one if it's currently first).
  The full post-by-post mapping (one row per live post URL → topic category →
  cluster role) is in `SSC Site Config Checklist - Live Values.xlsx`, tab
  **"6 Post Mapping"** — don't re-derive this from scratch, that mapping is the
  source of truth once approved. Note: it flags one audit URL that couldn't be
  matched against the 36 posts currently in "Blogs" (37 audit URLs vs. 36 live
  posts) — resolve that discrepancy before relying on the mapping as complete.

- ⬜ Decide whether "Areas We Serve" / location categories should stay as a
  *separate* taxonomy or page structure outside the blog, rather than mixed
  into the same WordPress category system the blog templates read from. This
  is a structural decision, not something to paste a value for — flag it to
  whoever owns the site's overall content structure if you're unsure.

## 7. Author Profiles (Users > Profile, for each author)

Scroll to the **"Blog Hub Author Profile"** section on each author's profile
screen (Users > All Users > click a name > scroll down).

**Live audit update (22–23 Oct 2026):** there is exactly one author with posts on the
live site — **Shubhankar Gupta** (login `seo_admnuser`, nickname "SSC", 43 posts). Two
other admin accounts have no posts. The example values originally in this section were
for a demo author ("Ramesh Patidar") used during development — replace them with the
real values below once each open decision is resolved; several genuinely need a human
call, not a guess.

- ⬜ **Author archive URL — NEEDS ACTION:** WordPress builds the author archive URL from
  the login username, which is `seo_admnuser` here — that login name would be publicly
  exposed at `/author/seo_admnuser/`. Either hide author archives in Yoast, or have the
  developer change the author slug, before this goes live.

- ⬜ **Title**
  Paste this value (proposed, matches the existing Yoast author title closely):
  ```
  Manufacturer of RCC Pipes, Manhole Covers and Precast Concrete Products
  ```

- ⬜ **Pull quote** — **NEEDS INPUT**, not in the live profile today. Do not invent one —
  leave blank until a real quote from Shubhankar is provided.

- ⬜ **LinkedIn URL** — **NEEDS DECISION**: the live profile's LinkedIn field currently
  points at the company page (`https://www.linkedin.com/company/shubhsanskarconcrete/`),
  not a personal profile. Decide whether to use a personal LinkedIn URL or keep the
  company page here.

- ⬜ **Expertise tags** — comma-separated.
  Paste this value (based on the 5 topic categories in section 6):
  ```
  RCC pipes, manhole covers, paver blocks
  ```

- ⬜ **"At a glance" facts / Extra profile stats** — one per line, as `value | label`.
  Only one stat has a defensible number so far — **do not invent the others**:
  ```
  2010 | Company Established
  ```
  "Deliveries overseen" — **NEEDS INPUT, blocked**: no confirmed figure exists; leave
  this stat out entirely rather than guessing a number.

- ⬜ **"Request a Quote" button link** — leave blank to hide the button.
  Paste this value:
  ```
  /contact/
  ```

- ⬜ **Public contact email** *(new field, added to fix a privacy issue)* —
  **must be set**, or the author page falls back to the site-wide Customizer
  contact email. It will NEVER show the author's real WordPress login email.
  **NEEDS DECISION** between the two real addresses found live — the account's actual
  login email (`seo@shubhsanskarconcrete.com`) or the site-wide contact address
  (`shubhsanskarconcrete@gmail.com`, see section 2). Pick one rather than defaulting.

- ⬜ **Biographical Info** (WordPress's own built-in field, same screen) — the
  author's actual bio, shown in the About section. **Needs a rewrite, not just a
  paste:** the live bio (and the matching Yoast author description) currently opens
  with "India's leading manufacturers of RCC Hume Pipes, SFRC Manhole Chamber, cement
  drain covers..." — the business context explicitly bars pan-India leadership claims
  like this, so this can't just be copied over as-is. Write a replacement bio for
  Shubhankar personally (not shared company copy) before pasting anything here.

- ⬜ **Gravatar / profile photo** — **NEEDS INPUT**: not checked yet whether a photo or
  Gravatar already exists for this account. WordPress has no built-in photo upload;
  author photos come from Gravatar (gravatar.com, tied to the account's email) or an
  avatar plugin. Without one, a generic grey silhouette shows.

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
    <a href="/contact/">Talk to our team →</a>
  </div>
  ```
- ⬜ **Chat button** — the live site already runs the "Social Chat" plugin (confirmed
  22 Oct 2026); keep it if it fits the new design. **NEEDS INPUT:** its WhatsApp number
  isn't public anywhere on the live site — get the real number before configuring it on
  this theme rather than reusing a placeholder.

## 9. Settings > Reading

**Live audit update (confirmed in wp-admin, 23 Oct 2026): all four settings below are
already correctly set on the live site — no change needed here**, only listed for
reference/consistency with the local environment.

- ✅ **Your homepage displays** → confirmed set to:
  ```
  A static page
  ```
- ✅ **Homepage** → confirmed set to the existing Elementor-built page, titled "Home".
  **Until the new homepage (section 10 below) is reviewed and approved, leave this as
  is.** The theme now also has its own real homepage (`front-page.php`) ready to go —
  see the big warning at the top of section 10 for exactly how and when to switch this
  over. Do not switch it over as part of routine config work.
- ✅ **Posts page** → confirmed set to the page titled "Blog" (renders at `/blog/`),
  using the theme's `home.php` (see the theme's own
  `.serena/memories/project_overview.md` for why that file, not `front-page.php`, is
  the one that matters — and note `home.php` and `front-page.php` are two different
  files serving two different purposes, both explained there).
- ✅ **Blog pages show at most** → confirmed set to:
  ```
  10
  ```
  This controls posts per page on Category and Author archive pages (the main
  Blog Hub listing always shows 12 regardless of this setting). Keep this value unless
  the theme design calls for a different number.

## 10. Homepage (Appearance > Customize > Homepage, plus three new content areas in the wp-admin sidebar)

⚠️ **Before touching Settings > Reading to make this the live homepage:** the
theme can now build a complete new homepage (hero, products, about teaser,
applications, clients, blog teaser, testimonials, a closing call-to-action),
matching the Home.dc.html design supplied for this round. **It is NOT live
yet** — it only becomes the real homepage once someone deliberately changes
Settings > Reading → Homepage to point at it, which nobody should do until
this page has been reviewed on staging and the switch is explicitly approved.
Until then, building/configuring it here is completely safe — it has no
effect on the live site's real homepage.

**Customizer fields** (Appearance > Customize > Homepage):

- ⬜ **Hero heading**
  Paste this value:
  ```
  "Building Trust, Creating Products"
  Products that last as long as our vision.
  ```
- ⬜ **Hero button text**
  Paste this value:
  ```
  View Products
  ```
- ⬜ **Hero button link** — point this at your real products page.
  Paste this value (edit the path if different):
  ```
  /products/
  ```
- ⬜ **Hero background image** — upload a wide, dark-toned photo (precast
  pipes/yard work well, matching the original design's grayscale-filtered
  photo treatment).
- ⬜ **About Us teaser text** — basic HTML links allowed.
  Paste this value:
  ```
  In the world of precast concrete industries, Shubh Sanskar is a trusted Indian Brand since 2010. We as a company started with one RCC pipe manufacturing plant and now striving and thriving in many more domains of the concrete industry. <a href="/about/">Read more.</a>
  ```
  *(link slug corrected to `/about/` per the live menu audit, 22 Oct 2026 — the live
  page is not at `/about-us/`)*
- ⬜ **About Us gallery images 1–4** — four square-ish photos shown in a 2×2
  grid next to the About teaser text.
- ⬜ **Reason 1–4 — icon / title / description** (the "Why Choose Us" row):
  Paste these values (one set per reason):
  ```
  Reason 1 icon:  fa-solid fa-palette
  Reason 1 title: Customization
  Reason 1 text:  We deliver concrete products tailor-made for your requirements. This is what we work for.

  Reason 2 icon:  fa-solid fa-certificate
  Reason 2 title: Quality
  Reason 2 text:  Quality control is carried out by our team of engineers and experts, ensuring that we deliver what we promise.

  Reason 3 icon:  fa-solid fa-hammer
  Reason 3 title: Durability
  Reason 3 text:  With proper tests, controls, and material inspection we ensure that every item we make is durable to withstand the industry standards.

  Reason 4 icon:  fa-solid fa-scale-balanced
  Reason 4 title: Affordable
  Reason 4 text:  Affordable Products because we don't make products, we make relationships. Making our customers our priority.
  ```
- ⬜ **End-of-page CTA heading**
  Paste this value:
  ```
  Help us know what you want?
  ```
- ⬜ **End-of-page CTA button text**
  Paste this value:
  ```
  Get in touch
  ```
- ⬜ **End-of-page CTA button link** — point this at your real contact page.
  Paste this value (corrected to the real live slug, `/contact/`, per the menu audit,
  22 Oct 2026 — not `/contact-us/`):
  ```
  /contact/
  ```
- ⬜ **End-of-page CTA background image** — optional; leave blank for a plain
  navy background.

**New content areas** (left-hand wp-admin sidebar — each works exactly like
adding a blog post: a title, a featured image, and sometimes one or two extra
fields in a box on the right):

- ⬜ **Products (Homepage)** — one entry per product card in the "Our
  Products" grid. Fill in: Title (e.g. "RCC Hume Pipes"), a Featured Image,
  and the "Product Link" field (where the card links to — the product's real
  page, wherever that ends up living).
- ⬜ **Applications (Homepage)** — the flip-card tiles (Railway, Roadways,
  Telecommunication, Housing, etc.). Fill in: Title, a Featured Image (front
  of the card), and the main content box (back of the card — a short
  paragraph, shown when hovered/tapped).
- ⬜ **Client Logos (Homepage)** — the scrolling client-logo strip. Fill in:
  Title (the company name, used for accessible alt text) and a Featured
  Image (the logo itself, ideally a transparent PNG). Add as many as you
  like — the carousel pages through them automatically once there are more
  than 5.
- ⬜ **Testimonials** — fill in: Title (the person's name), a Featured Image
  (their photo), the main content box (the testimonial text itself), and in
  the sidebar box: Location (e.g. "Delhi") and Star rating (1–5, defaults
  to 5).

## 11. About Us page

- ⬜ Create a Page (or use an existing one), set its **Template** (in the
  Page Attributes box) to **"About Us"**.
- ⬜ Write the page content directly in the page's own content editor — this
  theme does not have separate fields for this copy, since it's the page's
  actual body copy. The template automatically splits it: your **first
  paragraph** becomes the full-width intro right under the banner, and
  everything after that becomes the two-column "Who We Are" section (text on
  the left, photo on the right — see the next bullet for the photo). A plain
  bulleted list automatically gets checkmark icons, no manual formatting
  needed. Suggested starting content:
  ```
  Starting as a one-item RCC pipe plant in 2010, Shubh Sanskar Concrete has now become the upcoming leading industry in the domain of concrete manufacturers in India. From being the manufacturer of RCC Pipes, Manhole Chambers, Coping stones, paver blocks, and many more products to delving into becoming a Customized Concrete Product Manufacturer, we have expanded our field of interest to cater to the needs of customers.

  Who We Are

  The leading customized precast concrete product manufacturing company.

  Young India's young company, we are a team of young enthusiasts backed by the experience of people working in the concrete industry for over a decade.

  Our Vision is to build better products for the betterment of India's Infrastructure and make a mark at World Level.

  - We are the Leading Manufacturer of RCC Pipes, Manhole Systems, Precast Concrete Drain and Drain Cover, Cable Covers, and Coping Stones.
  - We are a Customized Concrete Product Manufacturer.
  ```
  Tip: type/paste this as plain text in the block editor — "Who We Are" as a
  Heading block, "The leading customized..." line as a smaller Heading
  block, the rest as Paragraph blocks, and the last two lines as a bulleted
  List block.
- ⬜ **Page Header Image** (meta box on the right side of the page editor,
  only appears once the About Us template is selected) — a wide background
  photo for the dark "ABOUT US" banner at the top. Paste a Media Library
  image URL.
- ⬜ **"Who We Are" Photo** (meta box right below Page Header Image, same
  spot) — the photo shown next to the "Who We Are" text (e.g. a photo of
  your products/site). Paste a Media Library image URL. Leave blank and that
  column is simply skipped (text goes full width).
- ⬜ The "Didn't Find What You Were Looking For?" section at the bottom
  reuses the **same Contact Details** (Email, Address, Map embed) already
  set up in section 2 — nothing new to configure there, it'll pick those up
  automatically.

## 12. Contact Us page

- ⬜ Create a Page (or use an existing one), set its **Template** to
  **"Contact Us"**.
- ⬜ **Page Header Image** (same meta box as About Us) — a wide background
  photo for the dark "CONTACT US" banner.
- ⬜ **Contact page — intro heading** (Customizer > Contact Details)
  Paste this value:
  ```
  Contact us through this form!
  ```
- ⬜ Write the short intro paragraph in the page's own content editor (the
  "We're here to help you with your real estate or construction project…"
  copy) — same as About Us, this is body content, not a separate field.
- ⬜ **Contact form shortcode** (Customizer > Contact Details) — **this is
  the one piece that needs a decision before the page works end-to-end.**
  1. Build a form in **WPForms** (already installed on this site) with the
     fields: Name*, Company Name, Email*, Phone Number*, Query* (a
     paragraph/textarea field), plus WPForms' own built-in spam protection
     (reCAPTCHA or similar — don't rebuild that by hand).
  2. Set up WPForms' notification email to send to your real inbox, and a
     confirmation message for the visitor.
  3. Copy the shortcode WPForms gives you (Embed button, or from the forms
     list — looks like `[wpforms id="123"]`) and paste it into this field.
  Until this is set, the page shows a plain placeholder message instead of a
  broken or fake-looking form — safe to leave blank while WPForms is being
  set up.
- ⬜ **Office / factory locations** (Customizer > Contact Details) — one line
  per location, as `Label | Address | Google Maps embed URL`. Get the embed
  URL from Google Maps → Share → Embed a map → copy just the `src="..."`
  value out of the `<iframe>` code (not the whole iframe tag, just that one
  URL). **Confirmed against the live audit (22 Oct 2026, tab "1-2 Logo and Contact")
  — addresses below match the real Office and two Factory locations found on the live
  `/contact/` page**, but the real embed URLs still need to be generated (the audit
  found a working map embed already exists live for "Shubh Sanskar Concrete (I) Pvt.
  Ltd." — reuse that listing when generating each embed).
  Paste this value (addresses confirmed; replace each embed URL with a real one):
  ```
  Office | 33, Sohna Rd, Opposite Devilal Garden, Ballabgarh, Faridabad, 121004, Haryana | https://www.google.com/maps/embed?pb=PASTE_YOUR_REAL_EMBED_PARAMETERS_HERE
  Factory | 45 KM, Village Gadpuri, Mathura Road, NH-19, Palwal, 121102, Haryana | https://www.google.com/maps/embed?pb=PASTE_YOUR_REAL_EMBED_PARAMETERS_HERE
  Factory | Village Alawalpur, Amarpur-Palwal road, Palwal, 121102, Haryana | https://www.google.com/maps/embed?pb=PASTE_YOUR_REAL_EMBED_PARAMETERS_HERE
  ```

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
