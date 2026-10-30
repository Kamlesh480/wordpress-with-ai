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
- ⬜ **Homepage** → **until the new homepage (section 10 below) is reviewed
  and approved, leave this selecting the existing Elementor-built homepage.**
  The theme now also has its own real homepage (`front-page.php`) ready to go
  — see the big warning at the top of section 10 for exactly how and when to
  switch this over. Do not switch it over as part of routine config work.
- ⬜ **Posts page** → select (or create) the page that should host the Blog
  Hub design — e.g. a page simply titled "Blog". This makes it render at
  whatever that page's URL is (typically `/blog/`), using the theme's
  `home.php` (see the theme's own `.serena/memories/project_overview.md` for
  why that file, not `front-page.php`, is the one that matters — and note
  `home.php` and `front-page.php` are two different files serving two
  different purposes, both explained there).
- ⬜ **Blog pages show at most** → a number, e.g.
  ```
  12
  ```
  This controls posts per page on Category and Author archive pages (the main
  Blog Hub listing always shows 12 regardless of this setting).

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
  In the world of precast concrete industries, Shubh Sanskar is a trusted Indian Brand since 2010. We as a company started with one RCC pipe manufacturing plant and now striving and thriving in many more domains of the concrete industry. <a href="/about-us/">Read more.</a>
  ```
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
  Paste this value (edit the path if different):
  ```
  /contact-us/
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
  URL).
  Paste this value (edit the addresses/URLs to your real ones):
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
