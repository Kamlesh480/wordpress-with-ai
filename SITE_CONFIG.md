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

**Latest update (15 Nov 2026):** the "SSC - Staging vs Design" feedback round. The code fixes
ship in theme version **1.0.13** (1.0.2 added the full logo image; 1.0.3 fixed which category labels a post; 1.0.4 fixed the Map embed box being impossible to type in; 1.0.5 limited category lists to topic categories; 1.0.6 ignores a Yoast Primary of Blogs/location; 1.0.7 newsletter section works with a WPForms form; 1.0.8 sticky header for old tables without a header row; 1.0.9/1.0.10/1.0.11 "changes log 16/11/26" round, see section 15; 1.0.12/1.0.13 Blog Page TL;DR width + sticky table header on phones, see section 16); everything that still needs doing in wp-admin is collected
in **section 14** at the bottom of this file — start there if you're picking this up fresh.

---

## 1. Site Identity (Appearance > Customize > Site Identity)

- ⬜ **Logo** — **one complete image**: gold "SS" mark + white "Shubh Sanskar Concrete"
  wordmark baked into the picture (1920×367). Live-site file (confirmed 22 Oct and 15 Nov 2026):
  `https://shubhsanskarconcrete.com/wp-content/uploads/2024/11/25.png.webp`
  (the `.png` version of the same file also works).
  - Download it, then **Customize → Site Identity → Select logo → upload**, and click
    **Skip cropping** (cropping would cut off the wordmark). Set the image's alt text to
    "Shubh Sanskar Concrete".
  - The theme shows this image **on its own** in the header, the mobile menu and the footer.
    It does *not* print the Site Title text next to it, so the name never appears twice.
  - The Logo field only appears in the Customizer from theme **v1.0.2** onward (earlier
    versions never switched WordPress's logo feature on).
  - The dark `bottom.png` version (light backgrounds) is not needed: every place the
    theme shows the logo has a dark navy background.
  Until the logo is set, the header falls back to showing the Site Title + Tagline as text.

- ⬜ **Site Title** — confirmed against the live site (22 Oct 2026), no change from below.
  Still needed even with the logo image: it's used for the footer copyright line, browser
  tab titles, search results / social shares, and the logo's alt text.
  Paste this value:
  ```
  Shubh Sanskar Concrete
  ```

- ⬜ **Tagline** — **decided (15 Nov 2026 feedback round):** use the design's line below.
  It shows in gold under the footer description (the logo image doesn't contain it, so it
  isn't duplicated), and next to the header name only when no logo image is set. (The live site currently shows "Leading Precast Concrete Products
  Manufacturer" here — replace it.)
  Paste this value:
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
  +91 70421 03883
  ```

- ⬜ **Phone 2** *(shown in the header top bar and, as of 15 Nov 2026, also in the
  footer Contact column — both numbers are tap-to-call links)* — real number
  confirmed live (22 Oct 2026); note the live header actually lists this number
  first, ahead of Phone 1 — check if that order matters once the theme is live.
  Paste this value:
  ```
  +91 92170 21955
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
  **✅ Value found (15 Nov 2026):** this is the exact embed the live site's footer uses for
  the "Shubh Sanskar Concrete (I) Pvt. Ltd." Google listing. Tested: the theme accepts it.
  Paste this value (all on one line, including `<iframe` and `</iframe>`):
  ```
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3511.49717518003!2d77.3151602!3d28.343814799999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6ccb2537e0f3383!2sShubh%20Sanskar%20Concrete%20(I)%20Pvt.%20Ltd.!5e0!3m2!1sen!2sin!4v1655551436468!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  ```
  If the field comes back empty after Publish, the paste wasn't a complete Google Maps
  iframe (the theme silently drops anything else).

- ⬜ **WhatsApp number** — digits only, with country code, no spaces or `+`.
  Powers the floating WhatsApp button (every page, bottom-right) and the
  mobile sticky Call/WhatsApp bar. Leave blank to hide both.
  Paste this value (edit to your real WhatsApp Business number):
  ```
  919217021955
  ```

- ⬜ **Footer description** *(new, 15 Nov 2026)* — short line under the footer logo;
  the Tagline (section 1) appears below it in gold.
  Paste this value:
  ```
  Precast concrete maker in Faridabad, Haryana. Since 2010.
  ```

- ⬜ **Opening hours** *(new, 15 Nov 2026)* — shown with a clock icon in the footer
  Contact column. Leave blank to hide.
  Paste this value:
  ```
  Mon to Sat, 9 am to 6 pm
  ```

- ⬜ **Footer certificate badge** *(new, 15 Nov 2026)* — **leave blank for now.**
  Only upload an image here once there is a real, current certificate (ISO / BIS etc.);
  when blank, nothing is shown.

*(No field needed for **Get Directions** — the footer builds that Google Maps link
automatically from the Address above.)*

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

- ✅ **Newsletter form shortcode** *(new, theme v1.0.7)* — **decided 15 Nov 2026: use WPForms**
  (no email-service account needed). A WPForms form "Newsletter signup" (one Email field +
  Subscribe) emails each sign-up to `shubhsanskarconcrete@gmail.com`; WPForms Lite does not
  store entries, so the inbox *is* the list. Someone copies the addresses into a mailing tool
  when the first newsletter goes out. **Staging: done** (form ID 8090). For production, import
  the same form (WPForms → Tools → Import; export it from staging via WPForms → Tools →
  Export) and paste its shortcode, e.g.:
  ```
  [wpforms id="8090" title="false"]
  ```
  (the ID will differ on production — copy it from WPForms → All Forms).

- ⬜ **Newsletter form action URL** — leave blank while the WPForms shortcode above is used.
  Only for a later switch to Mailchimp/Brevo: paste that service's form action URL here and
  clear the shortcode (the theme's own form sends the field as `EMAIL`, which both expect).

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

- ⬜ **End-of-page CTA image (blog articles)** *(new, 15 Nov 2026)* — upload a wide
  delivery/yard photo (landscape, roughly 4:3). On article pages the band then shows
  the photo on the left and the heading + gold button on the right, matching the
  design. Without an image the band stays centered. The heading always displays in
  capitals automatically — type it in normal case.

## 5. Menus (Appearance > Menus)

> **Update (15 Nov 2026):** only the **Social Links** menu is still used. The header
> navigation and the footer "Company" column are now built into the theme to match the
> design exactly (header: Home, Products, Areas We Serve, About Us, Blog, Contact;
> footer Company: Home, About Us, Areas We Serve, Blog, Contact). The Primary and Footer
> menus below can stay as they are — the theme simply ignores them. Renaming or
> reordering those links is now a developer change.

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
  X (Twitter) → https://twitter.com/sscconcrete   (confirmed 15 Nov 2026: this is the
                handle in the live site's own header social icons; the old
                twitter.com/shubhsanskarc link in one post is outdated)
  ```
  **Required for the footer's round social icons** (feedback item, 15 Nov 2026) — if no
  menu is assigned to the **Social** location, the icons simply don't appear. Each icon
  gets a screen-reader label automatically from the menu item's title, so title the items
  "Facebook", "Instagram", "LinkedIn", "X".
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
  Description: NP2 to NP4 pipe specifications, sizes, price lists, testing and culvert use.
  Covers: NP2/NP3/NP4 pipes, specifications, price lists, testing, culverts, manufacturing
  Posts assigned: 20
  Related product page: https://shubhsanskarconcrete.com/rcc-pipes/

  Name: Manhole & Drain Covers
  Slug: manhole-drain-covers
  Description: SFRC and concrete manhole covers, drain covers and load classes for roads and sites.
  Covers: SFRC and concrete manhole covers, drain covers, saucer drain
  Posts assigned: 9
  Related product page: https://shubhsanskarconcrete.com/sfrc-manhole-cover/

  Name: Paver Blocks & Kerb Stones
  Slug: paver-blocks-kerb-stones
  Description: Interlocking paver grades, designs and prices, kerb stones and laying guidance.
  Covers: Interlocking pavers, paver price and design, kerb stones, interlocking tiles
  Posts assigned: 7
  Related product page: https://shubhsanskarconcrete.com/cement-paver-blocks/

  Name: Road Safety & Street Products
  Slug: road-safety-street-products
  Description: Concrete jersey barriers, bollards and tree guards for roads and public spaces.
  Covers: Jersey barriers, bollards, tree guards
  Posts assigned: 3
  Related product page: https://shubhsanskarconcrete.com/concrete-road-barriers/

  Name: Precast Basics & Guides
  Slug: precast-basics-guides
  Description: Precast and RCC basics, HSN codes and buying guides that cover more than one product.
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
  category) as the primary category — the theme labels a post (tag, breadcrumb, card) with its Yoast
  Primary category if that is a topic, otherwise its first category that isn't Blogs /
  Uncategorized / a location (theme v1.0.6+). Don't change Yoast Primary on old posts:
  the permalinks include the category. See section 14 for the quick bulk-edit method. Go to
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
matching the Home.dc.html design supplied for this round.

**Correction (14 Nov 2026):** an earlier version of this note said the new homepage only
goes live once Settings > Reading is changed. **That is wrong.** The theme's
`front-page.php` takes over the site's front page as soon as the theme is uploaded and
active — whatever page Settings > Reading points at (confirmed on staging). So:
**uploading this theme to production replaces the live Elementor homepage immediately.**
Fill in this section on staging, get the homepage approved, and only then upload the
theme to production. (Ask your developer if the old homepage must stay live after the
upload — that needs a small code change.)

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

## 13. Site-wide Header & Footer (Nov 2026 redesign)

As of this round, **every page on the site shares one header and one footer**
(no per-page variants) — matching the latest design the stakeholder approved
(`SSC Header.dc.html` / `SSC Footer.dc.html`). Most of it pulls from fields
you've already filled in above; a few pieces are new or work differently from
before.

- ⬜ **Primary Navigation menu** (Appearance > Menus) is no longer used to
  build the main nav — the header now has its own fixed structure (Home,
  Products, Areas We Serve, About Us, Blog, Contact — order updated 15 Nov 2026)
  to match the design exactly. The Products dropdown has a second level: hover a
  product to see its types (RCC Pipes → NP2 / NP3 / NP4) plus a "Go to …" link. If you need to rename or reorder these, that's a code change, not
  a wp-admin setting — ask your developer.
- ⬜ **Products** and **Areas We Serve** dropdowns show a hardcoded list of
  categories/cities with links to pages on the **live site**
  (`shubhsanskarconcrete.com/rcc-pipes/`, `/areas-we-serve/faridabad/`, etc.)
  — these pages don't exist on this WordPress site yet. This was a deliberate
  choice to match the design immediately rather than block on building those
  pages first. **Action needed later:** once those product/area pages exist
  (here or still on the live site), tell your developer to update the link
  list in `inc/site-header-footer.php` (`blog_hub_header_product_categories()`
  and `blog_hub_header_areas()`).
- ⬜ **Blog dropdown** (header) and **"From the Blog"** column (footer) *are*
  fully dynamic — nothing to configure, they automatically show your most
  recent real posts and categories.
- ⬜ **Call Now button** (header, floating button, footer, sticky mobile bar)
  all use the same **Phone** / **Phone 2** fields from section 2 above —
  nothing new to set.
- ⬜ **Request a Quote** button (the strip just above the footer) links to
  whichever page uses the **"Contact Us"** template — make sure that page is set
  up per section 12 above. The strip appears on every page **except blog
  articles**, which end with their own call-to-action band instead.
- ⬜ **Floating WhatsApp/Call buttons** and the **mobile sticky contact bar**
  both depend on the new **WhatsApp number** field in section 2 — fill that
  in to show the WhatsApp button/bar; leave it blank to show Call-only (or
  hide the floating buttons entirely if Phone is also blank).

---

## 14. "SSC - Staging vs Design" feedback round (15 Nov 2026)

Source: the *SSC - Staging vs Design* review doc (14 pages, header/footer/blog/article).
Every item is either **fixed in theme code** (ships in theme **v1.0.8** — just upload the new
`blog-hub.zip`) or **needs a wp-admin change** (checklist below).

### Fixed in theme code (nothing to do except upload the theme)

- Logo → the full brand image (mark + wordmark) shows on its own in header, mobile menu and
  footer, sized to fit (v1.0.2). Before this the Customizer had no Logo field at all.
- Customize → Contact Details → **Map embed** box was hidden behind a blank area (its help
  text contained a literal iframe tag, which the browser turned into a real empty frame), so
  nothing could be pasted. Fixed in v1.0.4.
- Category label → a post ticked with both "Blogs" and a topic now shows the topic (WordPress
  sorts categories alphabetically, so "Blogs" used to win). Yoast Primary is respected (v1.0.3).
- "Categories don't have the right icons" (feedback p.6–7) → root cause is content: staging
  only has Blogs / Haryana / Delhi / Uttar Pradesh / Areas We Serve, which aren't topics, so
  every card gets the generic stack icon. Fixed in code (v1.0.5): Browse by Category, the
  category dropdown/switcher and the footer "From the Blog" now list **only topic
  categories** (Blogs, Uncategorized and location categories are left out; if no topic
  category exists yet they fall back to showing everything). Each card's description now
  sits on its own line under the name, as in the design. **The icons appear once the five
  topic categories below are created and have posts.**
- Category icons → also for the approved names: road barrier for Road Safety & Street
  Products, open book for Precast Basics & Guides (v1.0.3).
- Header menu order → Home, Products, Areas We Serve, About Us, Blog, Contact.
- Products dropdown → two levels (product → its types, e.g. RCC Pipes → NP2/NP3/NP4, with
  "Go to …" link); the mobile menu lists the types under their product too.
- Footer Company links → Home, About Us, Areas We Serve, Blog, Contact (no menu needed).
- Footer Contact column → both phone numbers as tap-to-call links, **Get Directions** link
  under the address (opens Google Maps), opening hours, map, then WhatsApp Us.
- Footer brand column → description line + gold tagline + social icons + certificate badge
  slot (all from settings below).
- Square **back-to-top** button in the footer bottom bar (it existed but was invisible due to
  a CSS clash — fixed).
- "Concrete Drain Covers" and other product names stay on one line in the footer.
- Browse by Category → each topic gets its own icon (pipes, manholes, poles, paver blocks,
  compliance) automatically from the category name.
- Article TL;DR → when no excerpt is written, the automatic summary now ends on a full
  sentence (no "…").
- Article tables → the header row stays visible below the site header while scrolling; the
  Table of Contents no longer slides under the header either.
- Article author box → role line, verified tick, topic chips, and spacing above the dark band.
- Article call-to-action band → uppercase heading, gold button, photo on the left (needs the
  new image setting below).
- Article ending order → author box → call-to-action band → Related Articles → footer; the
  extra "Need pipes or covers?" strip no longer appears on articles.

### Reference article for the team (staging, 15 Nov 2026)

**https://shubhsanskarconcrete.com/staging-test-789/blogs/choose-np2-np3-np4-rcc-hume-pipe-class/**
— "NP2, NP3 or NP4? How to Choose the Right RCC Hume Pipe Class". Built to show every
article feedback item working; copy its setup when writing new posts:
- **Category:** RCC Hume Pipes (topic) + Blogs → gold label and breadcrumb show the topic.
- **Excerpt:** 2 sentences written by hand → shown as the TL;DR, no "…".
- **Editor:** WordPress block editor (not Elementor). Headings as H2 → Table of Contents.
  Tables made with the **Table block with "Header section" switched on** → sticky header row.
- **Featured image:** a real yard photo with alt text.
- **Author:** Shubhankar → author box with tick, role line (profile *Title* + first stat)
  and topic chips. Title set 15 Nov 2026 to the section 7 value.
- End of page: author box → split CTA band with photo → Related Articles → footer.
- Theme v1.0.8 also gives the old Elementor posts' tables (no header row) a sticky first row.
- ⚠️ Author profile still shows two unverified claims from before: the stat "400+ site
  deliveries overseen" and the bio "India's leading manufacturers…" (section 7 says not to
  use either). Replace them under Users → Shubhankar when real values are confirmed.

### To do in wp-admin (staging now, production later)

**Plugins** (Plugins → Installed Plugins):
- ⬜ Deactivate **Call Now Button** — it adds the extra green call button at the bottom
  left. The theme already has its own call + WhatsApp buttons (bottom right).
- ⬜ Deactivate **YARPP – Yet Another Related Posts Plugin** — it adds the old
  "Related Posts:" thumbnail strip inside articles. The theme's own "Related Articles"
  section replaces it.
- ⬜ Keep **Social Chat (WP WhatsApp Chat)** deactivated (see section 13 / known gotcha:
  its WhatsApp bubble overlaps the theme's buttons).

**Appearance → Customize:**
- ⬜ **Site Identity → Logo**: upload the complete logo image `25.png.webp` (section 1) →
  **Skip cropping**. It replaces the text name in header, mobile menu and footer.
- ⬜ **Site Identity → Site Title** = `Shubh Sanskar Concrete` (the footer copyright line
  "© {year} Shubh Sanskar Concrete. All rights reserved." uses this; the year updates itself).
- ⬜ **Site Identity → Tagline** = `Building Trust, Creating Products` (section 1).
- ⬜ **Contact Details** → Email, Phone, Phone 2, Address, Map embed, WhatsApp, and the new
  **Footer description**, **Opening hours** (leave **Footer certificate badge** blank) —
  section 2. *This is what replaces the wrong "Madhya Pradesh" address, "+91 98765 43210"
  phone and "info@…" email currently on staging.*
- ⬜ **Front Page Hero → Intro paragraph** — the paragraph under the Blog page title (section 3).
- ⬜ **Blog CTA Banners** → the four end-of-page CTA fields + the new **End-of-page CTA
  image** (section 4).

**Appearance → Menus:**
- ⬜ Create/assign the **Social Links** menu to the **Social** location (section 5) — makes
  the Facebook / Instagram / LinkedIn / X icons appear in the footer.

**Posts → Categories** (section 6 — the biggest content gap):
- ⬜ Create the **five approved topic categories** from section 6 (Posts → Categories →
  Add New Category: Name, Slug, Description): **RCC & Hume Pipes**, **Manhole & Drain
  Covers**, **Paver Blocks & Kerb Stones**, **Road Safety & Street Products**, **Precast
  Basics & Guides**. Don't delete Blogs / Areas We Serve / Haryana / Delhi / Uttar Pradesh.
- ⬜ Move each of the posts into its topic, following the post-by-post mapping in
  `SSC Site Config Checklist - Live Values.xlsx`, tab "6 Post Mapping". Fastest way:
  Posts → All Posts → tick all the posts for one topic → Bulk actions **Edit** → Apply →
  tick the topic under Categories → **Update** (this *adds* the topic; existing
  categories stay, which is fine). Repeat per topic.
- ✅ **Done on staging (15 Nov 2026):** categories renamed to the approved names
  (Paver Blocks & Kerb Stones, Manhole & Drain Covers) and all 43 posts given their topic
  (Pipes 20, Manhole & Drain Covers 9, Paver & Kerb 7, Road Safety 3, Precast Basics 4).
  Blogs / location categories were kept on every post. "Cement Poles" exists but has no
  posts, so it stays hidden. **Production still needs the same work.**
- ⚠️ **Do NOT change Yoast's "Primary" category on existing posts.** Most posts have Primary
  = Blogs or a location, and the permalinks contain the category (e.g.
  `/blogs/all-about-jersey-barrier/`), so changing Primary would change live URLs and break
  links/SEO. Theme v1.0.6 handles it instead: a Yoast Primary that isn't a topic is ignored
  and the topic is shown.
- This single change fixes: the "BLOGS" label on article titles and cards, the footer
  "From the Blog" list (currently Blogs / haryana / Delhi…), the Browse by Category list
  and its icons/descriptions, the breadcrumbs, and Related Articles.
- *Theme note (v1.0.3, v1.0.6):* WordPress lists a post's categories alphabetically, so the theme no
  longer just takes "the first one". It uses the Yoast/Rank Math Primary category if set
  *and it's a topic*, otherwise the first category that isn't Blogs, Uncategorized or a location. Keeping
  "Blogs" ticked therefore no longer shows "BLOGS".

**Posts → each article (optional):**
- ⬜ **Excerpt = the TL;DR box.** Each article starts with a "TL;DR" summary box. By default
  the theme writes it automatically from the article's opening sentences. To write it
  yourself: open the post → right-hand sidebar, **Post** tab → **Excerpt** (or "Add an
  excerpt…" under the title area / Screen Options → Excerpt in the classic editor) → type
  1–2 sentences → **Update**. Do this only for posts whose automatic summary reads badly
  (e.g. it starts with an intro paragraph instead of the answer). The same text is also used
  on the blog listing cards.

**Users → Profile (each author)** — section 7:
- ⬜ Fill in **Title** (role line, e.g. `Site Engineer, Quality Control`), **Extra profile stats**
  (first line also appears in the role line, e.g. `13 | Years on Site`), **Expertise tags**
  (the topic chips, comma-separated) and **Biographical Info**.

**Newsletter ("Get new guides in your inbox", Blog page, before the quote CTA):**
- ✅ Staging done 15 Nov 2026 via WPForms (section 3). Production: import the form and paste
  its shortcode in Front Page Hero → Newsletter form shortcode.

**After all of the above:** clear the cache (WP Rocket → Clear cache, plus host cache),
then hard-refresh (Cmd + Shift + R) before reviewing.

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


## 15. "changes log 16/11/26" feedback round (17 Nov 2026)

All verified on staging (theme v1.0.11). Proof with screenshots: Google Doc *SSC - Staging vs
Design*, tab **"Fixes 17/11/26"**. Reference article:
https://shubhsanskarconcrete.com/staging-test-789/blogs/choose-np2-np3-np4-rcc-hume-pipe-class/

| # | Item | Fix |
|---|---|---|
| 1 | Products dropdown right box on every category | Code: sub-items = published **child pages** of each product page; box + "›" only when a category has some. The old hardcoded NP2/NP3/NP4 links pointed to pages that don't exist. To add sub-items, publish pages with the product page as Parent (e.g. "NP2 Pipes" under "RCC Pipes"). |
| 5 | Call + WhatsApp both bottom-right | Code (v1.0.11): Call bottom-left, WhatsApp bottom-right, **always fixed in the bottom corners** (also over the footer, as in the design). Footer content gets just enough side padding on narrower screens to stay clear of them; TOC box ends above them; mobile unchanged (sticky bar). |
| 6 | Fake phone/email | Admin (done on staging): Contact Details → real phones/email (section 2). |
| 7 | Wrong address | Admin (done on staging): real Faridabad address (section 2). |
| 9 | No company in copyright | Admin (done on staging): **Site Title was empty** → "Shubh Sanskar Concrete". |
| 10 | No FAQ | Content: Heading + Group block with CSS class `bh-faqs` + one Details block per question, at the end of the post (before the author box). |
| 12 | End order | Code (v1.0.10), confirmed against the Figma article design (SSC Page Designs, node 2020:3): body ending with the FAQ → author box → CTA band → Related Articles → footer. **No quote strip on articles** (it stays on all other pages). |

**Production:** after uploading v1.0.11, repeat items 6, 7 and 9 in Customize (Site Identity + Contact Details).

### Design vs feedback: where they differ and what we followed (also in the Google Doc, "Fixes 17/11/26" tab)
1. **End of article** → **design** (Figma article frame, node 2020:3): FAQ → author box → CTA band → Related Articles → footer, no quote strip on articles.
2. **Call button position** → **feedback**: Call bottom-left, WhatsApp bottom-right (the changes log says the design's both-right layout was wrong).
3. **Products dropdown sub-items** → **feedback**: only real published child pages are shown; the design's NP2/NP3/NP4 appear once those pages exist under RCC Pipes.
4. **Blog category names** → **approved mapping (2 Nov 2026)**, not the design's placeholder names; no cement-pole posts, so that category stays hidden.

### Products dropdown sub-pages (staging, 17 Nov 2026)
Published on staging as child pages of **RCC Pipes** (Page Attributes → Parent = RCC Pipes, Order 1-3):
**NP2 Pipes** (`/rcc-pipes/np2-pipes/`), **NP3 Pipes** (`/rcc-pipes/np3-pipes/`), **NP4 Pipes** (`/rcc-pipes/np4-pipes/`).
Short factual text (IS 458 class definitions, no prices) plus links to the class-choice guide and Contact. They make the
design's two-level dropdown appear for RCC Pipes. They use the theme's basic page template (no product-page design yet);
**not on production** — recreate there (or design proper product sub-pages) before launch. Any other product gets the same
right-hand box as soon as a page is published with it as Parent.

## 16. "Blog Page" tab follow-up (17 Nov 2026), theme v1.0.12 / v1.0.13
Code only, nothing to set in wp-admin. Live on staging; solutions with screenshots are under each pointer in the
Google Doc's "Blog Page" tab.

| Feedback | Fix |
|---|---|
| "Box width should match with page width" (TL;DR box) | TL;DR box is now as wide as the featured image and the article text (container width, 1122px on desktop), and all three line up on tablet and mobile too (the article body no longer pads the sides twice). **Differs from Figma** (TL;DR 780px there); changed as per this feedback. |
| "Tables: the header isn't sticky the right way… cuts off from the top" | Header row sticks right under the site header at every width. On phones, tables were inside WordPress's sideways-scroll box, which stopped the header row sticking; that box is removed and cells wrap instead, so tables fit the screen. Old Elementor/Word tables without a header row use their first row (as in 1.0.8). |
| (found while testing, logged-in only) | Site header now sits below the WP admin bar instead of under it, and table header rows / the contents box clear both. Visitors are not affected. |

**Production:** just upload v1.0.13 (no admin settings for this round).

