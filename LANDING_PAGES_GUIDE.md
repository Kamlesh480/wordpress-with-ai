# How to create a product landing page

For whoever builds landing pages in WordPress. You don't need any code: everything is filled in on the page's edit screen.

---

## What a landing page is

- It's a product page built from our **product page design** (the "RCC Pipes" design): hero, key facts, specification table, FAQ, quote form and so on.
- It lives under **`/lp/`**, e.g. `shubhsanskarconcrete.com/lp/rcc-pipes-offer/`.
- It's **hidden from Google** automatically (noindex) and left out of the sitemap. It's meant for ads, email and WhatsApp campaigns, not search.
- The site's normal **header and footer** appear on it automatically.
- You never pick a design or template. **Any page placed under the "LP" page gets the landing page design.**

**Example to copy from:** open **Pages → RCC Pipes** (under LP). Every section is filled in and switched on there.

---

## Before you start (one-time, ask the admin if unsure)

- [ ] The **SSC Landing Pages** plugin is active (Plugins → Installed Plugins).
- [ ] A page called **LP** exists (Pages → All Pages). Its address must be `/lp/`. Don't edit or delete it: it's the folder that holds all landing pages.
- [ ] You have the **form shortcode**: `[wpforms id="7207" title="false"]` (the existing Contact form). See "The quote form" at the bottom.

---

## Create a landing page: step by step

**First, three quick settings in the normal editor:**

1. **Pages → Add New.** **Don't** click "Edit with Elementor".
2. **Title:** the product name, e.g. `RCC Pipes`. It's used as the big heading unless you set a different Hero title later.
3. **In the right-hand panel (Page tab):**
   - **Parent** → choose **LP**. This one setting makes it a landing page.
   - **Slug** → e.g. `rcc-pipes-offer`. The page will be at `/lp/rcc-pipes-offer/`. Use lowercase and hyphens, and keep it short.
4. Click **Save draft**, then **reload the page** (Cmd+R / Ctrl+R).

**After the reload, the screen changes** to WordPress's simpler edit screen, built just for landing pages:
- The **title** at the top.
- Right under it, the **Landing Page Sections** box, where all the content goes.
- On the right: **Publish**, **Page Attributes** (Parent = LP) and **Featured image**.
- There's no big text editor any more. Landing pages don't use it, so it's hidden on purpose.

**Then fill it in:**

5. **Featured image** (right side): the main product photo shown in the hero.
   Landscape, about 4:3, at least 1280 px wide. Set its **Alternative text** in the Media Library.
6. **Fill in the sections** in the Landing Page Sections box (next section of this guide).
7. Click **Preview** and check the page (see the checklist at the end).
8. Click **Publish**, or **Update** if it's already published.

The Pages list shows **"Landing page · noindex"** next to the page. That's how you know it's set up right.

---

## Filling in the sections

The box has **22 panels**, one per section of the design, in the same order as on the page. Click a panel's title to open it.

### Three rules

1. **Anything in `[square brackets]` is placeholder text.** A new page starts with every field pre-filled, so you can see what goes where. Replace all of it before publishing.
2. **Lists: one item per line.** When an item has several parts, separate them with a **`|`** (vertical bar, Shift + backslash). Example for a FAQ:
   ```
   What is a hume pipe? | Another name for an RCC pipe.
   Do you deliver to Delhi? | Yes, across Delhi NCR.
   ```
   Each field's grey help text tells you which parts go in which order.
3. **Sections you don't need: untick "Show this section".**
   - The panel's badge changes to **Hidden**.
   - A section also hides itself if its main list or heading is left empty.
   - Sections marked **Always shown** (Hero, Overview, Specifications, FAQ, Enquiry) can't be switched off; fill them in.
   - **7 sections start Hidden on a new page:** Technical drawing, Video, Installation, Price, Projects, Related articles and Areas served. Most products don't need them. To use one, open it and tick **Show this section**. (That's why a new page has fewer sections than the RCC Pipes example, where everything is switched on.)

### Images

- **Single image fields** (hero image, drawing, manufacturing photo): click **Choose image** and pick or upload it in the Media Library.
- **Images inside lists** (application cards, related products, client logos, projects): paste the image's address in the right column.
  - To get the address: **Media → Library → click the image → Copy URL to clipboard**.
  - If you leave it empty, a grey "IMAGE NEEDED" box shows instead, so you can publish before all photos are ready. Fill them in later.

### Section by section

| # | Section | What to fill | Format of list fields |
|---|---|---|---|
| 1 | **Hero** (always shown) | Gold line, title (blank = page title), intro text, key facts, button text. Hero image = Featured image. Tick "Hide the Call button" to remove the Call button. Breadcrumb middle link: `Products \| /products/` | Key facts: `Label \| Value`, 4 lines works best |
| 2 | **Product index** | Line under "PRODUCT INDEX", e.g. `RCC Pipes · IS 458:2021`. The list builds itself from the sections that are switched on. Only shows on large screens. | — |
| 3 | **Overview** (always shown) | Gold label, heading, text. Empty line = new paragraph. | — |
| 4 | **Applications** | Picture cards | `Name \| Description \| Image URL` |
| 5 | **Types and applications** | Comparison cards | `Name \| Tag \| Load condition \| use; use; use \| Choose it when…` (uses separated by `;`) |
| 6 | **Class comparison** | Small table. Column headings: `Class \| Duty level \| Range`. Note under the table can contain a link. | One row per line, same number of parts as the headings |
| 7 | **Technical specifications** (always shown) | Big table. See "The specification table" below. | One row per line |
| 8 | **Technical drawing** | Heading + drawing image + description | — |
| 9 | **Standards & compliance** | Dark band: heading, text, rows | `Label \| Value` |
| 10 | **Manufacturing & testing** | Steps (numbered automatically), photo + caption, tests table. Leave tests empty to hide that part. | Steps: `Title \| Description` · Tests: `Test \| What it checks` |
| 11 | **Product video** | Heading + YouTube link. The video only loads when someone clicks play. | — |
| 12 | **Installation** | Steps, numbered automatically | One step per line |
| 13 | **Maintenance guide** | Fold-out tips; the first one starts open | `Title \| Text` |
| 14 | **Custom requirement strip** | Heading, text, button text. The button scrolls to the form. | — |
| 15 | **Price information** | Heading, text, price factors | One factor per line |
| 16 | **Client logos** | Label + logos | `Client name \| Logo URL` |
| 17 | **Projects** | Project photos with captions | `Caption \| Image URL` |
| 18 | **FAQ** (always shown) | Questions and answers. Optional note next to the heading (links allowed). | `Question \| Answer` |
| 19 | **Related articles** | Links to blog posts | `Title \| /blogs/post-slug/` |
| 20 | **Related products** | Product cards | `Name \| Description \| Link \| Image URL \| Link text` |
| 21 | **Areas served** | Location buttons | `Name \| Link` |
| 22 | **Enquiry** (always shown) | Heading, text, **form shortcode**. Phone numbers, WhatsApp, email and address come from the site settings automatically. | — |

**Links** in list fields can be short, like `/rcc-pipes/`, or full, like `https://…`.

**Adding a link inside a note** (the class comparison note and the FAQ note): put the link text in **[square brackets]**, followed straight away by the address in **(round brackets)**:
```
Need help choosing a class? [Read the guide](/blogs/choose-np2-np3-np4-rcc-hume-pipe-class/)
```
That shows as: Need help choosing a class? <u>Read the guide</u>, where "Read the guide" is clickable. No space between `]` and `(`.

### The specification table

It's the most complex field, so here is the RCC Pipes example. The table has plain columns on the left, then gold **groups** that each contain the same sub-columns:

| Field | What was typed |
|---|---|
| First column headings | `Internal diameter (mm) \| Length (mm)` |
| Column groups | `NP2 CLASS \| NP3 CLASS \| NP4 CLASS` |
| Columns inside each group | `Wall thickness (mm) \| Weight (kg)` |
| Rows | `150 mm \| 2000 \| 25 \| 74.11 \| 25 \| 75.51 \| 25 \| 76.35` (one line per size) |

Each row needs **2 + (3 groups × 2 columns) = 8 values**, in the order the columns appear.

- Type `NA` for sizes not made in a class; it's shown greyed out.
- For a **simple table** with no groups, leave "Column groups" empty and put all headings in "First column headings".
- **Copying from Excel or Google Sheets:** paste the rows into a plain text editor, replace the tab characters with ` | `, then paste the result into the Rows field.

---

## Before you publish: checklist

- [ ] **No `[square brackets]` left anywhere.** Use Preview, then Cmd+F / Ctrl+F for `[`.
- [ ] Sections you don't need are **switched off**.
- [ ] The **Featured image** is set and every list image either has a URL or is intentionally left as "IMAGE NEEDED".
- [ ] The **form** shows in the Enquiry section, not "FORM NEEDED". **Send one test enquiry** and check it arrives.
- [ ] **Request a Quote** buttons jump down to the form, and **Call** buttons dial the right number (try on a phone).
- [ ] You checked the page **on a phone** (or narrow the browser window). The big table scrolls sideways on phones; that's expected.
- [ ] The page's **Parent is LP** and the Pages list shows **"Landing page · noindex"**.

## Sharing the link

For ads and campaigns, add tracking tags to the link so enquiries can be traced to the campaign:
```
https://shubhsanskarconcrete.com/lp/rcc-pipes-offer/?utm_source=google&utm_medium=cpc&utm_campaign=rcc-pipes-nov
```

## Don'ts

- **Don't change the Parent away from LP.** The page would lose the design and become visible to Google.
- **Don't add landing pages to the site menus.** They're for campaigns only.
- **Don't use Elementor** on landing pages.
- **Don't change the URL slug after ads are live.** Old links would break.
- **Don't delete or rename the LP page.**

## Something's wrong?

| Problem | Fix |
|---|---|
| No "Landing Page Sections" box, still the normal block editor | Parent isn't saved as LP yet. Set Parent = LP, click **Save draft**, then **reload** the edit screen. Also check the SSC Landing Pages plugin is active. |
| The big text editor is missing | Expected on landing pages: all content goes in the Landing Page Sections box. |
| A link in a note shows as plain text with brackets | Check there's no space between `]` and `(`, e.g. `[price list](/blogs/price-list/)`. |
| Page shows the old site design | Ask the admin: the **SSC Blog Theme Switch** plugin must be version 1.2.0 or later and set to **Live**. Then clear the cache (WP Rocket → Clear cache). |
| A section doesn't appear | Check "Show this section" is ticked **and** its main list or heading isn't empty. |
| Table columns are shifted | That row has too few or too many `\|` parts. Count them against the headings. |
| "FORM NEEDED" shows | Paste the WPForms shortcode in panel 22 (Enquiry). |
| Changes don't show on the live site | Clear the cache (WP Rocket → Clear cache), or add `?nocache=1` to the end of the URL to check. |

---

## The quote form

**Use the existing Contact form.** Paste this into panel 22 (Enquiry) → Form shortcode:
```
[wpforms id="7207" title="false"]
```

- It's the same form as on the `/contact/` page: **Name\***, **Company Name**, **Email\***, **Phone Number\***, **Query\***, with reCAPTCHA spam protection.
- The landing page restyles it automatically to match the design: short fields two per row, navy button, full width on phones. Nothing needs changing in WPForms.
- Because the form has no Product / Size / Quantity / Location fields, adapt the **Enquiry text** in panel 22 to match. For example: *"Tell us the product, size, quantity and delivery location in your query and our team will prepare a quotation."*
- Enquiries go wherever form 7207's notifications are set (WPForms → form 7207 → Settings → Notifications), the same as for the Contact page.
- **Don't edit form 7207 for a landing page.** It's live on the Contact page, so any change shows there too. If landing pages later need extra fields, **duplicate** it (WPForms → All Forms → hover → Duplicate), edit the copy, and use the copy's shortcode.

## For the developer: deploying

| What | Where it lives | How it ships |
|---|---|---|
| Theme **Blog Hub v1.0.29+** (template, styles) | `wp-content/themes/blog-hub-new/` | Upload as `blog-hub.zip` |
| Plugin **SSC Landing Pages v1.1.0** (sections box, noindex, sitemap) | `wp-content/plugins/ssc-landing-pages/` | Zip the folder and upload under Plugins → Add New → Upload |
| Plugin **SSC Blog Theme Switch v1.2.0** | `wp-content/plugins/ssc-blog-theme-switch/` | Same way; it now also serves Blog Hub on `/lp/` |

After uploading:
1. Create the **LP** page: title `LP`, slug `lp`, no content, published.
2. Make sure `robots.txt` doesn't block `/lp/`. Google has to be able to read the noindex tag.
3. Clear WP Rocket's cache.
