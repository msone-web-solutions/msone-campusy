# Handoff: Genius Course Design System

## Overview

A complete design system and website recreation for **Genius Course**, an education and
training brand: an online course marketplace with a small book shop attached. The package
covers the visual foundations (tokens), 24 reusable components, and a click-through
recreation of the marketing site across 8 screens plus a login popup.

The design's identity rests on **one blue-to-teal gradient reused in four distinct roles**.
Get that right and the rest follows; get it wrong and nothing looks like the brand.

## About the design files

**The files in this bundle are design references created in HTML.** They are prototypes
showing intended look and behaviour — not production code to copy directly.

Your task is to **recreate these designs in the target codebase's existing environment**
(React, Vue, Svelte, SwiftUI, native, whatever is in use), using its established patterns,
component library and conventions. If no environment exists yet, choose the framework that
best suits the project and implement the designs there.

The React components in `components/` are deliberately simple and style-inline. Treat them
as a precise specification of values and structure, not as an implementation to lift.

## Fidelity

**High fidelity.** Every colour, gradient stop, radius, padding, font size and line-height
in this package is the source template's own authored value, not an approximation.

How they were obtained: the template's `style.css` is served without cross-origin access
headers, so it could not be read as text. Instead the original page markup was injected
into a probe page that loads the live stylesheet, and every value was read back from
`getComputedStyle` on the real elements, including `::before`/`::after` pseudo-elements.

**What that method could not reach**, and where you should therefore use judgement:

- **`:hover` and `:focus` rules.** Computed styles cannot be read for a state the browser
  is not in. Hover behaviour below is inferred from static evidence — chiefly
  `background-size: 200% auto` on gradient fills and `opacity: 0` on overlay layers, both
  of which only make sense as hover mechanics. Every such inference is labelled *(inferred)*.
- **`responsive.css`.** Loaded by the source but never measured. No breakpoint values are
  known; the responsive behaviour in this package is its own reasonable choice.
- **Two deliberate additions**, called out where they appear: a focus ring on form fields
  (the source defines none) and an optional dark scrim for photographic sections
  (off by default).

Recreate pixel-perfectly using the codebase's existing libraries where they fit.

---

## Design tokens

### Colour

The two brand hues are **never** used as a flat fill on a large surface. They exist to be
blended. Teal appears alone in exactly three places: course category labels, the 50px rule
under a section heading, and teacher designations.

| Role | Hex | Notes |
|---|---|---|
| Brand blue | `#01a6fd` | gradient stop |
| Brand teal | `#17d0cf` | gradient stop; also standalone accent |
| Gradient-border start | `#10abff` | second gradient only |
| Gradient-border end | `#1beabd` | second gradient only |
| Heading ink | `#333333` | every heading |
| Body | `#777777` | the `body` element's own colour |
| Muted | `#989898` | dates, counts, designations, separator rules |
| Eyebrow | `#a9a3a3` | hero kicker only |
| Rating star | `#ffc926` | |
| Trend badge (inline) | `#ff5c26` | |
| Trend ribbon (corner) | `#ff5a00` | |
| FAQ tab, inactive | `#006dad` | |
| Quote glyph | `#125693` | |
| FAQ answer text | `#67a0c9` | on the photographic FAQ ground only |
| Page | `#ffffff` | |
| Alt band | `#f7f7f7` | also chip fill |
| Product card | `#f1f1f3` | the only tinted card |
| Form field | `#eeeeee` | |
| Search field | `#f9f9f9` | |
| Hairline | `#cccccc` | the only divider colour |
| Image hover scrim | `rgba(0,0,0,.65)` | best-course thumbnails |
| Textarea over photo | `rgba(255,255,255,.78)` | |
| Hero illustration ground | `#0d6fb8` | behind `sd-1.jpg` |

### The gradient — read this before building anything

```css
--gradient: linear-gradient(to right, #01a6fd 0%, #17d0cf 51%, #01a6fd 100%);
--gradient-size: 200% auto;
--gradient-opacity: .9;
```

The repeated start stop and the 51% midpoint are deliberate. Paired with
`background-size: 200% auto`, sliding `background-position` from `left center` to
`right center` animates the fill **without a colour change**. That is the brand's hover
mechanic *(inferred, but the 200% sizing has no other purpose)*.

Gradient fills render at `opacity: .9`, not 1.

A second, separate gradient exists for exactly one element — the white event-date tile:

```css
--gradient-border: linear-gradient(69deg, #10abff, #1beabd);
```

**Its four roles.** Implement all four; missing any of them loses the brand:

1. **Fill** — buttons, submit buttons, price tags, the play button, the login popup header.
2. **Ring** — a 4px *transparent* border with the gradient as the background and
   `background-origin: border-box`, on contact icons; and a full circle 5px larger than a
   teacher portrait on every side.
3. **Clipped to type** — `background-clip: text` + `-webkit-text-fill-color: transparent`
   on the 60px category glyphs and the 40px counter glyphs, so the glyph *is* the gradient.
   The only place the gradient becomes type.
4. **Layer behind white** — at `z-index: -1` under the 10px-radius event-date tile, so the
   gradient reads as a coloured edge around white.

### Typography

**Roboto only**, across an unusually wide weight range. Google Fonts:
`Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,300;1,400`.

**Line-heights are absolute pixel values throughout, never ratios.**

| Role | Size / line-height | Weight |
|---|---|---|
| Hero headline | 90px / 108px | **100** |
| Compact hero (`.secoud-title`) | 70px / 84px | 100 |
| Eyebrow flanking dots | 70px / 1 | 400 |
| Event date numeral | 50px / 50px | 700 |
| Section heading | 38px / 45.6px | 300 |
| Counter figure | 30px / 27px | 700 |
| Accordion question | 26px / 36.4px | 400 |
| Testimonial quote | 25px / 35px | 300 *italic* |
| `h4` | 24px / 28.8px | 500 |
| Card title, About lede | 22px / 30px | 500 |
| Submit button | 18px / 25.2px | 700 |
| News / teacher / category title | 18px / 21.6px | 700 |
| Body | 16px / 22.4px | 400 |
| Nav link, log-in | 15px / 21px | 500 |
| Course category / author, date, metrics | 14px / 19.6px | 700 / 400 |
| Designation, testimonial attribution, event month | 13px / 18.2px | 700 / 300 |
| COURSE DETAIL, "Start from", corner ribbon | 12px / 16.8px | 700 |
| Inline TRENDING badge | 11px | 700 |

**The hero eyebrow's 7px letter-spacing is the only tracking in the system.** It is flanked
on each side by a pair of 70px teal full stops as decorative punctuation.

**Headings carry a bold run inside a light line, and its position is not fixed.** In the
markup it is a bare `<span>` inside the `h2`. Copy each heading's split from the source
rather than assuming light-then-bold:

| Rendered | Markup |
|---|---|
| **Inventive** Solution / for **Education** | `<span>Inventive</span> Solution <br> for <span>Education</span>` |
| **Popular** Courses. | `<span>Popular</span> Courses.` |
| **Search** Genius Courses. | `<span>Search</span> Genius Courses.` |
| We are **Genius Course** work since 1980. | `We are <span>Genius Course</span> work since 1980.` |
| **Download** Genius Application on **PlayStore.** | `<span>Download</span> Genius Application on <span>PlayStore.</span>` |
| Browse Our** Best Course.** | `Browse Our<span> Best Course.</span>` |
| Frequently** Ask & Questions** | `Frequently<span> Ask &amp; Questions</span>` |
| Browse **By Category.** | `Browse <span>By Category.</span>` |
| Latest **News.** / Upcoming **Events.** / Latest **Video.** | `Latest <span>News.</span>` |
| Genius **Best Products.** / Genius **Teachers.** | `Genius <span>Teachers.</span>` |
| Students **Testimonial.** | `Students <span>Testimonial.</span>` |
| **Get in Touch** | `<span>Get in Touch</span>` |

Note that the space sometimes sits **inside** the span and sometimes outside. Reproduce it
as written.

**Every section heading ends in a full stop.** Without exception. It is a typographic
device, not a sentence ending.

### Spacing

Section padding, vertical: **125px standard**, with four documented exceptions — 110px (FAQ),
105px (teachers), 100px (products and several bands), 60px (sponsors).

Container **1170px**, gutter **30px**.

Utility steps the source ships: 5, 8, 10, 15, 20, 25, 30, 35, 45, 65px.

| Measure | Value |
|---|---|
| Course card (carousel) | 370px |
| Search bar | 700px |
| Subscribe form | 735px |
| Testimonial | 850px |
| News thumbnail | 120 × 120px |
| Event date tile | 95 × 84px |
| Sponsor logo cell | 180px |
| Sub-menu | 300px |
| Teacher gradient ring | portrait + 5px on every side |
| Button height | 56px (incl. its 2px border), line-height 52px, padding `0 25px` |
| Submit button / search field | 60px |
| Form field | 50px, padding 15px |
| Textarea | 100px min |
| Play button, add-to-cart | 40px circle |
| Contact icon | 60px, 4px border |
| Card text panel | `20px 25px 30px` |
| Teacher card | `20px 30px 30px` |
| Product card | `25px 20px` |
| Nav link | `7px 15px 10px` |
| Chip | `5px 15px` |

### Radii

**4px is the house default** — buttons, cards, images, sub-menu, fields, tabs.

| Value | Used for |
|---|---|
| 3px | trend badge, metric chips |
| 4px | everything else |
| 5px | search field, testimonial block |
| 10px | event date tile only |
| 40px | contact icon |
| 100% | play button, cart button, teacher ring, list bullets |

**Nothing is a pill.** There is no fully-rounded control anywhere.

### Elevation

**This is effectively a shadowless design.** There is exactly one shadow in the measured CSS:

```css
box-shadow: 0 5px 10px 0 rgba(83,82,82,.1);  /* nav dropdown only */
```

Cards have **no shadow and no border**. Separation comes from the alternating section
grounds and from generous whitespace. Do not add elevation.

### Borders

- **2px teal** on the primary button. Note it carries *both* that border and a gradient
  fill, so the border reads as a slightly darker edge.
- **1px `#cccccc`** dividers.
- **4px transparent** for gradient-ringed icons.
- **3px teal** bar marking an open FAQ answer.
- Meta separators are **1px × 15px pseudo-element rules**, not pipe characters.
- The sponsor strip divides logos with **1px × 80px** rules.

### Motion

```css
transition: .3s ease-in-out;          /* the house transition, on nearly everything */
transition: background 1s ease-out;   /* gradient fills — they slide, not recolour */
```

No bounces, springs or staggered entrances. The source animates counters up from zero on
scroll and runs Owl carousels on autoplay.

---

## Screens / views

All eight screens share the same chrome: a transparent header overlaying a coloured hero,
and the footer. Interior pages open with a 430px-tall photographic banner
(`banner/hb-2.jpg`) carrying a 70px compact hero title.

### 1. Home — `ui_kits/website/home.jsx`

**Purpose:** sell the catalogue and capture a registration.

**Section order, verified against the source.** Reproduce this exactly:

1. **Hero slider** — full bleed, 760px. Ground: `banner/sd-1.jpg`, a flat blue rocket
   illustration on `#0d6fb8` — **not** a photograph, so **no scrim**. Header overlays it.
   Content is left-aligned with the eyebrow offset 42px (`.ml42`): eyebrow, the 90px/100
   headline, then an **outlined** button (transparent, 2px teal border, white label —
   *not* gradient-filled; this is the only button in the design without the fill).
   The source runs four slides; slide 3 carries a countdown timer.
2. **Sponsor strip** — 60px padding, six logos in a row, each cell 180px, divided by
   1px × 80px `#cccccc` rules. Logos at 75% opacity, full on hover *(inferred)*.
3. **Popular Courses** — 100px padding, eyebrow + heading, three wide course cards in a
   30px-gutter row. The source uses an Owl carousel.
4. **About + free registration** — `#f7f7f7`. Two columns: left is eyebrow, heading, a
   22px/500 ink lede, a 16px body paragraph, a teal-bullet list, then two buttons
   side by side ("About Us" gradient, "contact us" outlined). Right is a white card
   holding a three-field form (name, email, course select) and a gradient submit button.
5. **Search + counters + app** — **one** section, ground `banner/hb-2.jpg`. Contains, in
   order: centred eyebrow + heading in white, the 700px search bar, the four-up counter
   strip, and then **the app-download block inside the same band** (mockup image left,
   white heading + body + teal-bullet list + gradient button + three app-store glyphs
   right). This nesting is easy to get wrong — the app block is *not* its own section, so
   its type is white.
6. **Latest** — `#f7f7f7`, 100px padding, three equal columns: Latest **News.** (two news
   rows), Upcoming **Events.** (three event rows), Latest **Video.** (poster with a 40px
   gradient play button, title, body). Each column ends in a bold ink text link.
7. **Genius Best Products.** — 100px padding, four product cards on the `#f1f1f3` ground.
8. **Browse Our Best Course.** — `#f7f7f7`, centred heading, eight compact course cards
   four-up.
9. **FAQ** — ground `banner/fq-1.jpg`, 110px padding. Centred white eyebrow + heading, the
   tab strip, then two columns of accordion, then two outlined buttons.
10. **Browse By Category.** — 100px padding, eight category tiles four-up, each a
    gradient-clipped 60px Flaticon glyph over an 18px/500 label.
11. **Students Testimonial.** — `#f7f7f7`, centred. A single 850px quote block with dots
    beneath to switch between three quotes.
12. **Genius Teachers.** — 105px padding, four teacher cards, then an "All teacher" button.
13. **Contact** — `#f7f7f7`. Left: eyebrow, heading, body, three gradient-ringed contact
    blocks. Right: a four-field message form.
14. **Footer** — darkened photographic ground (`banner/bt.png` over `#1b1b1b` at 70%
    black). Centred logo, one mission sentence, a 735px subscribe form, three social
    glyphs, then copyright and three legal links above a 1px white-15% rule.

### 2. Course index — `pages.jsx` → `CourseScreen`

Banner "Browse Our** Best Course.**". Then: a centred 700px search bar, a category tab
strip (`ALL` plus the distinct categories), a centred result count in 14px muted, three
wide course cards, then eight compact cards four-up. Filters live on title text and
category. Empty state is a centred sentence.

### 3. Teachers — `TeacherScreen`

Banner "Genius **Teachers.**". Eight teacher cards four-up at 105px padding, then the
counter strip on `banner/hb-2.jpg`.

### 4. Blog — `BlogScreen`

Banner "Latest **News.**". Six news rows in an auto-fit grid, 300px minimum track.

### 5. Shop — `ShopScreen`

Banner "Genius **Best Products.**". A row showing the product count left and a cart count
right (teal bag glyph), then eight product cards four-up. Clicking a card increments the
cart.

### 6. About — `AboutScreen`

Banner "We are Genius **Course.**". Then the about split (image left, copy right), the
category grid on `#f7f7f7`, and the sponsor strip.

### 7. FAQ — `FaqScreen`

Banner "Frequently** Ask & Questions**". The tab strip, then a single 760px accordion column
in the ink tone (this page has a white ground, unlike the home band). Below, on `#f7f7f7`,
a centred 560px "Make a **Question**" form.

### 8. Contact — `ContactScreen`

Banner "**Get in Touch**". The two-column contact layout with a four-field form.

### 9. Login popup — `login.jsx`

A 480px modal over a 70%-black scrim, 60px from the top. Header is the gradient at
`opacity: .9` with a square logo, a 28px/100 heading ("**Login** Your Account." — bold run
on "Login"), and a 14px white sub-line. Body: a `#3b5998` Facebook button (50px, 4px
radius), a centred "OR SIGN IN" divider in 14px bold muted, two fields, the gradient submit
button, then two 12px muted footnotes. Validates that both fields are non-empty.

---

## Components

Twenty-four components in three groups. Each is documented in `components_core.md`, `components_cards.md` and
`components_layout.md` — usage notes, the full props contract, and the reference
implementation. **Read those; they carry the per-component detail this README summarises.**

**`components/core/`** — `Button`, `SubmitButton`, `SectionTitle` (+ `Em`), `HeroTitle`,
`Input`, `Rating`, `Badge`, `MetaLine`, `BulletList`

**`components/cards/`** — `CourseCard`, `BestCourseCard`, `NewsCard`, `EventCard`,
`ProductCard`, `TeacherCard`, `TestimonialSlide`, `CategoryTile`

**`components/layout/`** — `SiteHeader`, `HeroSlide`, `Section` (+ `Grid`), `Tabs`,
`Accordion`, `CounterStrip`, `SearchBar`, `ContactAddress`, `SiteFooter`

### Component notes that are easy to get wrong

**`Button`** — a caret (`fas fa-caret-right`) is part of the component, not an option: nearly
every button in the source carries one. Four variants: `gradient` (the default, used almost
everywhere), `outline` (the source's bare `.genius-btn` — transparent, 2px teal border,
**white** label, as on the hero), `outlineInk` (same shape, ink label, for light grounds),
`onDark` (white border and label).

**`SectionTitle` / `Em`** — the bold run is placed by the author, anywhere in the line. See
the heading table above.

**`CourseCard`** — has **no card surface at all**: no background, no border, no shadow.
Structure comes from a 4px-radius image with a gradient price tag pinned 20px from its
top-left, then the meta line, stars, a 22px title underlined by a 50×3px gradient rule, and
grey metric chips. The COURSE DETAIL link is hidden until hover *(inferred from `opacity: 0`)*.

**`BestCourseCard`** — unlike the above, this one *does* have a white 4px-radius text panel.
On hover the thumbnail takes the 65%-black scrim and the stars plus the COURSE DETAIL link
fade in over it *(inferred)*. A 45°-rotated `#ff5a00` ribbon marks a trending item; its
parent needs `overflow: hidden`. Its meta line is **regular** weight, not bold — the one
difference from `CourseCard`.

**`CounterStrip`** — the figure is **split in two**: the source writes
`<span class="counter-count">5 </span><span>M+</span>`, so "5" is 30px/700 and "M+" is
16px/400. The glyph is gradient-clipped. Icons in order: `flaticon-graduation-hat`,
`flaticon-book`, `flaticon-favorites-button`, `flaticon-group`.

**`EventCard`** — the date tile is a 95×84 white block at 10px radius sitting **on top of**
a 69° gradient layer at `z-index: -1`, so the gradient reads as a coloured edge.

**`Accordion`** — questions are an unusually large 26px at **regular** weight with no
chevron, plus/minus or divider. The open answer is marked only by a 3px teal bar down its
left edge. Resist adding an icon.

**`SiteHeader`** — transparent, overlays the hero, white links. It has **no light variant**
because the source has none. The gradient pill behind a nav link appears **on hover only** —
the source does not mark the current page. Cart and search are 42px circles outlined in teal.

**`TestimonialSlide`** — no card, no avatar. Centred 25px/300 italic ink on the page ground,
with a bolded middle clause (every testimonial in the source emphasises its middle clause),
a name/designation line separated by a 1px rule, and a 40px navy quote glyph lower-right.

**`SiteFooter`** — **no link columns.** The absence of them is the design.

---

## Interactions & behaviour

### Navigation
- Header nav switches screens. Two items carry dropdowns (Home → four variations;
  Pages → Teacher, Course, Course Details, Blog, FAQ). Dropdown reveal is
  `opacity`/`visibility` over `.3s ease-in-out`.
- Home-page cards navigate: course cards → course index, news → blog, products → shop,
  category tiles → course index.
- "log in" opens the modal.

### Hover states *(all inferred — see Fidelity)*
| Element | Behaviour |
|---|---|
| Gradient-filled element | slides `background-position` left → right |
| Nav link, FAQ tab, sub-menu item | fades a gradient layer in behind the label |
| Card title | turns teal `#17d0cf` |
| Course image | scales ~1.06 |
| Best-course thumbnail | 65% black scrim; stars + COURSE DETAIL fade in |
| Add-to-cart circle | swaps white ground for the gradient, glyph goes white |
| Teacher portrait | social glyphs fade in centred over the photo |
| Sponsor logo | opacity 0.75 → 1 |
| Footer link, social glyph | goes teal |

### Press states
**None exist in the source** — no `:active` rule was found. Use the hover state.

### Focus states
**Also absent.** This package adds a 2px teal outline on form fields for keyboard
accessibility. **Keep it** — implement your codebase's standard focus treatment if it has one.

### Forms
- No visible labels. The placeholder carries the field name; a trailing `*` marks required
  (`"Your@email.com*"`, `"Your password*"`).
- The home registration form, contact form, FAQ question form and footer subscribe all
  confirm inline on submit in this prototype. Wire them to your real endpoints.
- Login validates that both fields are non-empty and shows the error in `#ff5c26`.

### Responsive
`responsive.css` was not readable, so **no source breakpoints are known.** This package uses
wrapping auto-fit grids whose track minimum is derived from the design width at the 1170px
container, so narrow viewports drop to fewer columns rather than squeezing in more, thinner
ones. Replace with the codebase's own breakpoint system.

---

## State management

The prototype keeps everything in local component state. A real implementation needs:

| State | Type | Drives |
|---|---|---|
| `screen` | string | which view is shown (router in production) |
| `login` | boolean | login modal visibility |
| `user` | object / null | authenticated user |
| `query` | string | course search text; carried from the hero into the course index |
| `cart` | number | cart count in the shop header |
| `registered` | boolean | registration confirmation |
| `messageSent` | boolean | contact/FAQ confirmation; reset on navigation |
| `cat` | string | course index category filter |
| `tab` | string | FAQ tab; resets the open accordion index |
| `open` | number | open accordion index, `-1` for none |
| `testi` | number | active testimonial |

Data fetching in production: course catalogue (with category + text filter), teacher roster,
blog index, product catalogue, FAQ content per tab, and form submission endpoints.

---

## Assets

**No binaries are included.** The source host serves the demo without cross-origin access
headers, so nothing could be downloaded, and nothing has been redrawn or approximated.
Every asset is referenced from its original URL under:

```
https://jthemes.net/themes/html/genius-course/assets/img/
```

`assets/README.md` in this bundle carries the full inventory. Key items:

- **Logo** — `logo/logo.png` is the only lockup, and it is a *light* mark, so it appears
  solely on dark or gradient grounds. There is no dark-on-light version. `logo/p-logo.jpg`
  is a square variant used once, in the login popup. Both `SiteHeader` and `SiteFooter` fall
  back to the word "Genius" in Roboto bold when no logo is supplied.
- **Hero** — `banner/sd-1.jpg` is **slide 1**, the rocket illustration. (`banner/s-4.jpg` is
  slide 2, `banner/s-3.jpg` slide 3.)
- **Section grounds** — `banner/hb-2.jpg`, `banner/fq-1.jpg`, `banner/cf-1.png`,
  `banner/bt.png`.
- **Content** — `course/c-1..3.jpg`, `course/bc-1..8.jpg`, `teacher/tb-1..4.png`
  (transparent PNGs, cut to circles), `product/bp-1..4.png` (transparent packshots),
  `blog/lb-1..2.jpg`, `about/abt.jpg`, `about/ab-2.png`, `banner/v-1.jpg`,
  `sponsor/s-1..6.jpg`.

Replace all of these with the client's own licensed assets — the vendor ships these as demo
stock and they are not redistributable.

### Icons — two real fonts, neither substituted

1. **Font Awesome 5 Free** for all UI glyphs. In use: `fa-caret-right` (in almost every
   button), `fa-arrow-right`, `fa-bolt`, `fa-star`, `fa-user`, `fa-comment-dots`,
   `fa-cart-plus`, `fa-play`, `fa-search`, `fa-shopping-bag`, `fa-map-marker-alt`,
   `fa-phone`, `fa-envelope`, `fa-times`, `fa-chevron-left`/`right`, plus `fab` marks for
   Facebook, Twitter, Google Plus, Apple, Android and Windows.
2. **Flaticon**, a bespoke icon font, for the subject-category and counter glyphs — **these
   are the ones that wear the gradient.** Classes present: `flaticon-technology`,
   `flaticon-technology-1`, `flaticon-technology-2`, `flaticon-app-store`,
   `flaticon-artist-tools`, `flaticon-business`, `flaticon-dna`, `flaticon-cogwheel`,
   `flaticon-favorites-button`, `flaticon-group`, `flaticon-book`,
   `flaticon-graduation-hat`.

Both are currently linked from the source host. **Self-host them, or substitute Flaticon
with an equivalent set** — its licence travels with the purchased template, so check what
the client actually owns. UI glyphs are single-colour and inherit their context; category
and counter glyphs are always gradient-filled.

---

## Content and copy

Copy in this package is the source template's own, reproduced verbatim so you can see
length and rhythm. Most body text is untranslated Lorem ipsum — replace it, but keep the
structural habits:

- Third person and impersonal for description; "we" when the institution speaks.
- Eyebrows uppercase and declarative: EDUCATION & TRAINING ORGANIZATION, LEARN NEW SKILLS,
  SEARCH OUR COURSES, GENIUS CATEGORIES, WHAT THEY SAY ABOUT US, GENIUS STAFFS,
  GENIUS COURSE FAQ, SORT ABOUT US, CONTACT US.
- Numbers with European decimal points and loose precision: "1.220", "122.500+", "5 M+",
  "125k Unrolled".
- Contact details labelled by rank, not channel: "Primary:", "Second:".
- **No emoji**, and no unicode characters used as icons.

**Typos in the source are real, not house style** — fix them in new copy: "Unrolled"
(for Enrolled), "Aducation", "Califorinia", "Enginering", "SORT ABOUT US" (for Short),
"Consectuerer", "All teacher", "archieve" (in the logo tagline).

**Casing is inconsistent in the source** and should not be copied: button labels run
"Our Courses", "About Us", "contact us", "GET THE APP NOW", "LOg in Now". Write new labels
in Title Case.

---

## Files in this bundle

| Path | What it is |
|---|---|
| `styles.css` | The single entry point. `@import`s only — link this one file. |
| `tokens/colors.css` | Palette and semantic aliases. |
| `tokens/typography.css` | Roboto, weights, px sizes, absolute line-heights. |
| `tokens/spacing.css` | Utility steps, section rhythm, container, component padding. |
| `tokens/effects.css` | Radii, **the gradient and its variants**, the one shadow, motion. |
| `tokens/fonts.css` | Roboto from Google Fonts. |
| `tokens/base.css` | Element defaults. |
| `components_core.md` | The 9 primitives: usage notes, props contract and source for each. |
| `components_cards.md` | The 8 card components, same format. |
| `components_layout.md` | The 9 layout and chrome components, same format. |
| `ui_kits/website/index.html` | **Open this first** — the click-through prototype. |
| `ui_kits/website/home.jsx` | The home page, all 14 sections. |
| `ui_kits/website/pages.jsx` | The seven interior screens. |
| `ui_kits/website/shell.jsx` | Footer wrapper, `PageTop` banner, sponsor strip. |
| `ui_kits/website/login.jsx` | The login modal. |
| `ui_kits/website/data.js` | All copy and image URLs, verbatim from the source. |
| `ui_kits/website/README.md` | Screen map, what is interactive, fidelity notes. |
| `_ds_bundle.js` | Compiled components, so the prototype runs offline from this folder. |
| `assets/README.md` | Full asset and icon inventory. |
| `design_guide.md` | The design guide: content fundamentals, visual foundations, iconography. |

**Where to start:** open `ui_kits/website/index.html` in a browser to see the whole thing
working, then read `design_guide.md` for the reasoning behind the values, then the entry for
any component you are about to build in the relevant `components_*.md`.

### A note on the bundle namespace

The prototype's components are read from `window.RaqueDesignSystem_94a18b`. That name comes
from an earlier project title and is misleading, but it is consistent throughout. Ignore it
when porting — it is an artefact of the prototype environment, not part of the design.
