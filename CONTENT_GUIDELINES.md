# Blog content guidelines (for the content team)

How to write and edit blog posts and Areas We Serve location posts so they display correctly in the
new blog design (Blog Hub theme) and pass SEO checks. **These are content tasks done in wp-admin by the
content team. They are not theme code or site settings.**

Created 19 Nov 2026 from the "Prod Feedback" tab of the *SSC - Staging vs Design* Google Doc. Each
section names the feedback item it answers.

---

## 1. Headings (needed for the Table of Contents)

*Feedback: "No table of contents on 8 blogs".*

- The Table of Contents is built automatically from the post's **H2 headings**. A post with no H2 has
  no Table of Contents.
- Use real headings, not bold paragraphs: in the block editor choose the **Heading** block, level
  **H2**, for each main section; **H3** for sub-sections inside it. In Elementor use the **Heading**
  widget with HTML tag **H2**.
- Write headings as plain sentences ("How to choose the right class"), 3 to 8 words, no full stop.
- Do not put the post title inside the content as a heading: the title is shown automatically.

## 2. Links inside the text

*Feedback: "Web addresses used as link text" (paver-block-price, manufacturing-of-interlocking-tiles,
concrete-manhole-cover-designs).*

- Link **words**, never a pasted web address. Write "see our RCC pipe price list", select
  "RCC pipe price list" and add the link. Do not write `https://shubhsanskarconcrete.com/...` in the
  text.
- Link text must say where the link goes ("Contact us", "NP3 pipe specification"), not "click here".
- Internal links: use the page's normal address, e.g. `/contact/`, `/products/`, `/rcc-pipes/`.
  **Use `/contact/` for quotes and enquiries** (`/contact-us/` does not exist).
- The theme already styles links (darker colour, underline, hover); do not change link colours by hand.

## 3. No contact block at the end of posts

*Feedback: "Old contact block at the end of 31 blogs", "Phone numbers do not match", "Wrong X handle
inside blog text".*

- Do **not** add "For more info please contact us on: email / phones / social links" at the end of a
  post. Every blog page already shows the contact details, a "Request a Quote" band and the footer.
- Remove the existing block from the 31 posts that still have it (it has old numbers
  99990 62399 / 98107 56705, and twitter.com/shubhsanskarc, which is a broken X account).
- If a phone number is ever needed in the text, use only the official ones:
  **+91 70421 03883** and **+91 92170 21955**. X (Twitter) account: **x.com/sscconcrete**.

## 4. FAQ section (accordion)

*Feedback: "FAQ is plain text, and only 3 blogs have one", "FAQs missing before author section" (e.g.
hsn-code-of-cement), and the schema item "FAQ schema but no FAQ on the page" (all-about-rcc-pipes).*

- Put the FAQ at the **end of the article text**. The theme then shows, in this order: FAQ, author box,
  "Have a project to discuss?" band, Related Articles.
- Build it like this in the block editor:
  1. A **Heading** block (H2): `Frequently Asked Questions`.
  2. A **Group** block around the questions, with **Additional CSS class** `bh-faqs`
     (Block settings > Advanced > Additional CSS class).
  3. Inside the group, one **Details** block per question: the summary line is the question, the
     content is the answer (1 to 3 sentences).
- Do not write questions as bold lines: they must be Details blocks so they open and close.
- If a post has FAQ schema (Yoast FAQ / structured data) the same questions must be visible on the page.
  Either add the visible FAQ as above or remove the FAQ schema (all-about-rcc-pipes has schema but no
  visible FAQ).
- Posts that need an FAQ in this format: all-about-jersey-barrier (10 questions),
  all-about-sfrc-manhole-covers (10), np-3-hume-pipe-and-np4-hume-pipe (9) are plain text today;
  hsn-code-of-cement has none.

## 5. Pull quote (quote card)

*Feedback: "Quote strip is missing".*

- The design shows a quote card (cream box, gold quote mark, italic text, "— Name, Job title") just
  before the FAQ. The theme adds it automatically from the **author's profile**:
  Users > Profile > **Pull quote** (one sentence, under 20 words) and **Job title**.
- Nothing shows if the author has no pull quote. Example (from the design):
  *"Half the site problems we see were decided on paper, weeks before the pour."*
- A quote can also be added inside an article with the **Quote** block; it gets the same card style.

## 6. Images: alt text

*Feedback: "Images with no alt text" (every blog has 3 or more; paver-block-design has 14).*

- Every image needs **alt text** (Media Library > the image > Alternative Text, or the Image block
  sidebar). Describe what the photo shows, in 5 to 15 words, without "image of".
  - Good: "Stacked NP3 RCC hume pipes in the casting yard"
  - Good: "Interlocking paver blocks laid in a herringbone pattern on a driveway"
  - Bad: "image1", "paver", "pipe.jpg"
- Purely decorative images (dividers, background shapes) can have empty alt text.

## 7. Excerpt (TL;DR box)

*Feedback: "Excerpt is empty" (RCC Drainage Pipes).*

- The **Excerpt** field (post sidebar > Excerpt) is shown as the **TL;DR** box under the featured image.
- Write 1 to 2 full sentences (under 50 words) that answer the post's main question. Example:
  "Pick the pipe class by the load above it, not by its size. NP2 suits light-traffic culverts, NP3
  roads used by loaded trucks, and NP4 very heavy loads such as railway crossings."
- If left empty the theme builds one from the first sentences, which often reads badly.

## 8. Yoast SEO: focus keyphrase

*Feedback: "No keywords on 12 of 43 posts".*

- Every post needs a **Focus keyphrase** in the Yoast box under the editor: the main search phrase,
  2 to 4 words, e.g. "NP3 pipe price list", "SFRC manhole cover", "paver block design".
- Use it in the title, the first paragraph and one H2 (naturally, once each).
- Keep the Yoast **meta description** at 120 to 155 characters.

## 9. Author box claims

*Feedback: "Author box claims".*

- The author box shows the author's **Biographical Info**, **Job title** and **Expertise**
  (Users > Profile).
- Do not use claims that can't be backed up ("India's leading manufacturer", "400+ site deliveries")
  unless there is proof. Prefer facts: "Manufacturer of RCC pipes, manhole covers and precast concrete
  products in Faridabad since 2010."
- The "400+ Site Deliveries Overseen" stat is deliberately **not** set on production.

## 10. Areas We Serve location posts

*Feedback: "Area posts are normal blog posts", "Category haryana is in small letters".*

- Location posts ("Hume Pipes in Delhi") must be filed **only** under the state category inside
  "Areas we Serve" (Delhi, Haryana, Uttar Pradesh). Do not also tick "Blogs" or a topic category:
  that would make them show up as blog posts.
- The theme keeps them out of the blog listing, the Blog menu and Related Articles, and shows
  Home > Areas We Serve > State as the breadcrumb.
- Category names are shown in breadcrumbs: write them with capitals ("Haryana", not "haryana").
  Change the **Name**, never the **Slug** (the slug is part of the post addresses).

## 11. Pages the footer expects

*Feedback: "Privacy Policy and Terms go nowhere".*

- The footer shows **Privacy Policy** and **Terms** links only when those pages exist:
  - Privacy: publish the page and select it in Settings > Privacy.
  - Terms: publish a page with the address `/terms/` (or `/terms-and-conditions/`).
- Until then the links are hidden (they used to point at "#").

---

**Who does what:** content (text, headings, links, images, alt text, excerpts, FAQs, keyphrases, author
bios) = content team, following this file. Theme code and site settings = development (see
`SITE_CONFIG.md`).
