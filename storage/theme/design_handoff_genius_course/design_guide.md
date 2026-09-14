# Genius Course Design System

Genius Course is an education and training brand: an online course marketplace with a
small book shop attached. One product surface — a marketing and catalogue website —
covering a home page, course index and detail, teacher roster and profiles, a blog, a
shop with checkout, an FAQ, About and Contact. There is no application, no logged-in
area beyond a login popup, and no mobile product.

The brand's whole visual identity rests on one thing: a single blue-to-teal gradient,
reused in four distinct roles. It fills buttons and price tags, forms a ring around
contact icons, gets clipped to the shape of subject glyphs so the icon itself is a
gradient, and sits as a coloured layer behind a white tile so the tile reads as
gradient-edged. Around it the page is almost austere — white and one pale grey,
shadowless cards, 4px corners, and headline type that swings from hairline 100 to
bold 700 inside a single line.

## Sources

- **https://jthemes.net/themes/html/genius-course/index-2.html** — the "Home Page 2"
  variation, the page given as the brief.
- **`uploads/Home Page 2.html`** — the user-supplied page source (a browser "save page"
  copy). This is what made accurate work possible; see below.
- **`assets/css/style.css`** on the same host — the value ground truth, read by
  measurement rather than as text.
- Sibling pages linked from the source's own navigation: `index-1.html`, `index-3.html`,
  `index-4.html`, `about.html`, `shop.html`, `contact.html`, `teacher.html`,
  `teacher-details.html`, `blog.html`, `blog-single.html`, `course.html`,
  `course-details.html`, `faq.html`, `check-out.html`, plus an `RTL_Genius/` mirror.
- The template is by **Jthemes Studio**. Its JS stack, named in the markup: Bootstrap,
  jQuery, Owl Carousel, meanmenu, video.js, lightbox, animate.css, a countdown plugin and
  a jQuery UI datepicker. It ships a colour switcher with eight alternate palettes
  (`color-2.css` … `color-9.css`); this system documents the default palette only.

### How the values were obtained

The host blocks both routes to the CSS text: `style.css` cannot be fetched as text, and
`cssRules` is inaccessible on the cross-origin stylesheet. A first attempt at guessing
class names found 11 usable hits out of ~100 candidates — not enough to build on.

What worked: the user supplied the page source, which gave the real class names and
markup. That markup was injected into a probe page that loads the live `style.css`, and
every value was then read back from `getComputedStyle` on the real elements, including
`::before`/`::after` pseudo-elements. So the colours, gradient stops, radii, paddings,
font sizes and the absolute line-heights in `tokens/` are the template's authored values,
not estimates.

**What that method cannot reach**, and is therefore documented as absent rather than
invented:

- **`:hover` and `:focus` rules.** Computed styles cannot be read for a state the browser
  is not in. Hover behaviour below was inferred from the static evidence — chiefly the
  `background-size: 200% auto` on gradient fills and the `opacity: 0` on overlay layers,
  both of which only make sense as hover mechanics — and every such inference is labelled.
- **`responsive.css`.** Loaded by the source but never measured, so no breakpoint values
  are known.
- **Asset binaries.** Referenced by URL; see `assets/README.md`.

## Content fundamentals

**Register.** Institutional and impersonal. The brand speaks as "we" about its mission and
almost never addresses the reader as "you": *"We take our mission of increasing global
access to quality education seriously. We connect learners to the best universities and
institutions from around the world."* Section headings are bare noun phrases.

**Every section heading ends in a full stop.** Without exception: "Popular Courses.",
"Latest News.", "Upcoming Events.", "Latest Video.", "Genius Best Products.",
"Browse Our Best Course.", "Students Testimonial.", "Genius Teachers.",
"Browse By Category." The stop is a typographic device, not a sentence ending — treat it
as part of the style.

**Headings carry a bold run inside a light line**, and its position is not fixed. In the
markup it is a bare `<span>` inside the `h2`, and it appears at the start
("**Popular** Courses."), the middle ("We are **Genius Course** work since 1980."), the end
("Browse Our** Best Course.**"), twice ("**Inventive** Solution for **Education**") or over
the whole line ("**Get in Touch**"). Sometimes the space sits inside the span, sometimes
outside. This weight contrast is the single most recognisable thing about the brand's
typography — copy each heading's split from the source rather than assuming light-then-bold.

**Eyebrows are uppercase and declarative**, sitting above the heading:
EDUCATION & TRAINING ORGANIZATION, LEARN NEW SKILLS, SEARCH OUR COURSES, GENIUS CATEGORIES,
WHAT THEY SAY ABOUT US, GENIUS STAFFS, GENIUS COURSE FAQ, SORT ABOUT US, CONTACT US.

**Casing is inconsistent in the source** and should not be copied into new work. Button
labels run "Our Courses", "About Us", "contact us", "GET THE APP NOW", "All teacher",
"LOg in Now", "log in" — Title Case, lowercase and uppercase all appear. Nav items mix
"About Us" with "shop". Write new labels in Title Case.

**Numbers are written with European decimal points and loose precision**: "1.220",
"1.015", "122.500+", "15.000+", "7.500+", "5 M+", "125k Unrolled", "More Than 122K Online
Available Courses". Prices are two-decimal dollars: "$99.00", "Start from $55.25". Dates
are "26 April 2018", "30 Sept 2018".

**Contact details are labelled by rank, not by channel**: "Primary:" and "Second:" prefix
both the address and phone lines rather than naming what they are.

**Testimonials bold their middle clause** — every one of them: *"This was our first time
lorem ipsum and we **were very pleased with the whole experience**. Your price was lower
than other companies."* Curly quotation marks are kept in the copy.

**No emoji anywhere**, and no unicode characters used as icons. The only text symbols in
chrome are the separators drawn as 1px pseudo-element rules between meta items — not pipe
characters.

**Typos in the source are real, not house style**: "Unrolled" (for Enrolled), "Aducation",
"Califorinia", "Enginering", "SORT ABOUT US" (for Short), "student-qoute", "thumbnile",
"secound", "Consectuerer", "All teacher". Correct them in new copy.

Most body text in the source is untranslated Lorem ipsum, so it is evidence of length and
rhythm only, not of voice.

## Visual foundations

**Colour.** Two hues define the brand — `#01a6fd` blue and `#17d0cf` teal — and neither is
used as a flat fill on a large surface. They exist to be blended. Teal does appear alone,
in exactly three places: course category labels, the 50px rule under a section heading, and
teacher designations.

Ink is `#333333` for every heading. The `body` element is `#777777`, and `#989898` covers
all meta — dates, counts, designations, and the separator rules. The hero eyebrow uses a
warmer `#a9a3a3`.

Accents are narrow and each has one job: `#ffc926` for rating stars, `#ff5c26` for the
inline TRENDING badge, `#ff5a00` for the corner ribbon on a best-course thumbnail,
`#006dad` for an inactive FAQ tab, `#125693` for the decorative quote glyph, and
`#67a0c9` for FAQ answer text on the photographic FAQ ground.

Surfaces: white alternating with `#f7f7f7`. Two further tints exist — `#f1f1f3` for a
product card and `#eeeeee` for a form field, with `#f9f9f9` for search fields. `#cccccc`
is the only hairline colour.

**The gradient.** `linear-gradient(to right, #01a6fd 0%, #17d0cf 51%, #01a6fd 100%)`.
The repeated start stop and the 51% midpoint are deliberate: paired with
`background-size: 200% auto`, sliding `background-position` from left to right animates
the fill without a colour change. That is the brand's hover mechanic. A second, separate
gradient — `linear-gradient(69deg, #10abff, #1beabd)` — exists solely as the layer behind
the white event-date tile.

Its four roles:

1. **Fill** — buttons, submit buttons, price tags, the play button, the login popup header.
2. **Ring** — a 4px transparent border with the gradient as `background-origin: border-box`,
   on contact icons; and a full circle 5px larger than a teacher portrait.
3. **Clipped to type** — `background-clip: text` on the 60px Flaticon category glyphs, so
   the glyph itself is the gradient. The only place the gradient becomes type.
4. **Layer behind white** — at `z-index: -1` under the 10px-radius event-date tile.

Gradient fills sit at `opacity: .9`, not 1.

**Type.** Roboto only, with an unusually wide weight range. The hero headline is 90px at
weight **100** — a hairline at display size — with its closing words at 700. Section
headings are 38px/300 with closing words at 700. Card titles are 22px/500. List titles
(news, teachers, categories) are 18px/700. Body is 16px/22.4. Meta is 14px/700 for
categories and authors, 14px/400 for dates and counts. The smallest sizes are 13px
(designations, testimonial attribution), 12px (COURSE DETAIL, "Start from") and 11px
(the TRENDING badge).

**Line-heights are absolute pixel values throughout**, never ratios: 108px on the hero,
45.6px on section headings, 30px on card titles, 35px on quotes, 22.4px on body, 52px on
buttons, 60px on controls. The hero eyebrow's **7px letter-spacing is the only tracking in
the system**, and it is flanked by two 70px teal full stops as decorative punctuation.

**Spacing.** Sections are padded 125px vertically as standard, with four documented
exceptions: 110px (FAQ), 105px (teachers), 100px (products and several bands), 60px
(sponsors). The container is 1170px with a 30px gutter. The utility steps the source ships
are 5, 8, 10, 15, 20, 25, 30, 35, 45 and 65px. Course cards are 370px wide in the
carousel; search bars 700px; the subscribe form 735px; testimonials 850px.

**Corners.** 4px is the house default and covers buttons, cards, images, the sub-menu,
fields and tabs. 3px for small chips and badges, 5px for search fields and the testimonial
block, 10px for the event-date tile, 40px for contact icons, and true circles for the play
button, cart button, teacher ring and list bullets. **Nothing is a pill.**

**Shadows.** Genius Course is effectively a shadowless design. There is exactly one shadow
in the measured CSS — `0 5px 10px 0 rgba(83,82,82,.1)` on the nav dropdown. Cards have no
shadow and no border; separation comes from the alternating section grounds and from
generous whitespace. Do not add elevation.

**Borders.** 2px teal on the primary button — and note the button carries both that border
and a gradient fill, so the border reads as a slightly darker edge. 1px `#cccccc` for
dividers, 4px transparent for gradient-ringed icons, and a 3px teal bar marking an open
FAQ answer. Meta separators are 1px × 15px pseudo-element rules; the sponsor strip divides
its logos with 1px × 80px rules.

**Backgrounds.** White alternating with `#f7f7f7`, interrupted by full-bleed bands: the hero
(a flat blue illustration, `sd-1.jpg`), the search-and-counters band, the FAQ, the contact
section and the footer (all photographic).
There are no patterns, no textures and no grain.

**Type over imagery.** The hero slides are flat blue illustrations — rockets above clouds on
a `#0d6fb8` ground — not photographs, so white type sits on them directly with no scrim, and
`HeroSlide` reproduces that (`overlay` defaults to off, with a `background` prop painting the
illustration's blue). The FAQ and counter bands *are* photographs, and there the source still
uses no scrim; `Section` therefore offers an optional `overlay` for when you substitute a
busier image. **That overlay is this system's addition, not the source's.**

**Motion.** `0.3s ease-in-out` is the house transition, applied to nearly every interactive
element. Gradient fills animate on a slower `background 1s ease-out` because they are
sliding a 200%-wide background rather than changing colour. There are no bounces, springs
or staggered entrances. The source animates counters from zero and runs Owl carousels on
autoplay.

**Hover states** — inferred from the static CSS, as noted above, and consistent across the
evidence: gradient-filled elements slide their gradient from left to right. Nav links, FAQ
tabs and sub-menu items fade a gradient layer in behind the label (their overlay sits at
`opacity: 0` at rest). Card titles turn teal. Course images scale slightly. A best-course
thumbnail takes a 65% black scrim and reveals its stars and COURSE DETAIL link, both of
which rest at `opacity: 0`. The add-to-cart circle swaps white for the gradient.

**Press states.** None exist in the source — no `:active` rule was found. Use the hover state.

**Focus states.** Also absent. `Input` here adds a 2px teal outline for keyboard
accessibility; **that is this system's addition.**

**Fixed elements.** The header is transparent and overlays the hero rather than being fixed;
the source adds a sticky class on scroll. A back-to-top control sits bottom-right. No
floating action button.

**Imagery.** Bright, ordinary, unfiltered stock — classrooms, laptops, people at desks.
Teacher portraits and product packshots are transparent PNGs, so they sit directly on the
card ground with no frame; portraits are then cut to circles by the gradient ring. No
duotones, no colour grading, no monochrome.

## Iconography

**Two real icon fonts, both loaded from the source host — neither is a substitution.**

**Font Awesome 5 Free** carries all UI iconography. The caret is near-ubiquitous:
`fas fa-caret-right` appears inside almost every button, which is why `Button` renders it
by default. Also in use: `fa-arrow-right` (COURSE DETAIL), `fa-bolt` (both trend badges),
`fa-star` (ratings), `fa-user` and `fa-comment-dots` (metrics), `fa-cart-plus`, `fa-play`,
`fa-search`, `fa-shopping-bag`, `fa-map-marker-alt`, `fa-phone`, `fa-envelope`, `fa-times`,
`fa-chevron-left`/`right` (carousel arrows), `fa-cog` (the demo colour switcher), and `fab`
brand marks for Facebook, Twitter, Google Plus, Apple, Android and Windows.

**Flaticon**, a bespoke icon font, carries the subject-category glyphs — and these are the
ones that wear the gradient. Twelve classes appear: `flaticon-technology`,
`flaticon-technology-1`, `flaticon-technology-2`, `flaticon-app-store`,
`flaticon-artist-tools`, `flaticon-business`, `flaticon-dna`, `flaticon-cogwheel`,
`flaticon-favorites-button`, `flaticon-group`, `flaticon-book`, `flaticon-graduation-hat`.

House rules:

- Solid `fas` for UI, `fab` for brands. No regular or light weights appear.
- UI glyphs are single-colour and inherit their context: white in the header and on
  gradient fills, ink in body contexts, amber for stars, and the two oranges for trend
  markers only.
- **Category glyphs are always gradient-filled** at 60px via `background-clip: text`. Never
  render them flat.
- Sizes: 60px category glyph, 40px counter glyph, 22px contact and header glyph, 16px star,
  14px inline button caret, 11–12px badge glyph.
- Every icon labels something; there is no purely decorative iconography — with the single
  exception of the 40px `fa-quote-right` behind a testimonial.
- Do not hand-draw SVG icons for this brand; both fonts are available.

## Index

| Path | What it is |
|---|---|
| `styles.css` | The single entry point consumers link. `@import`s only. |
| `tokens/colors.css` | The two brand hues, ink, accents, surfaces, semantic aliases. |
| `tokens/typography.css` | Roboto, the 100–700 weight range, px sizes, absolute line-heights. |
| `tokens/spacing.css` | Utility steps, section rhythm, container, component padding, control sizes. |
| `tokens/effects.css` | Radii, **the gradient and its three variants**, the one shadow, borders, motion. |
| `tokens/fonts.css` | Roboto from Google Fonts. |
| `tokens/base.css` | Element defaults. |
| `guidelines/*.html` | 19 specimen cards rendered in the Design System tab. |
| `assets/README.md` | Asset and icon inventory, and why nothing is stored locally. |
| `ui_kits/website/` | Click-through recreation of the site, 8 screens plus the login popup. |
| `templates/course-landing/` | Course landing page template (Design Component). |
| `thumbnail.html` | The project tile. |
| `SKILL.md` | Agent Skills front matter for use outside this project. |

### Components

**`components/core/`** — `Button`, `SubmitButton`, `SectionTitle`, `HeroTitle`, `Input`,
`Rating`, `Badge`, `MetaLine`, `BulletList`

**`components/cards/`** — `CourseCard`, `BestCourseCard`, `NewsCard`, `EventCard`,
`ProductCard`, `TeacherCard`, `TestimonialSlide`, `CategoryTile`

**`components/layout/`** — `SiteHeader`, `HeroSlide`, `Section` (plus `Grid`), `Tabs`,
`Accordion`, `CounterStrip`, `SearchBar`, `ContactAddress`, `SiteFooter`

Each has a sibling `.d.ts` props contract and a `.prompt.md` usage note.

#### Intentional additions

Five components have no single class in the source but were extracted because the markup
shape repeats:

- **`Section` / `Grid`** — bands are raw Bootstrap markup on every page. Naming them keeps
  the 125px rhythm, the 1170px container and the 30px gutter from drifting.
- **`HeroSlide`** — the slider frame, extracted so the header/headline overlay relationship
  is reusable.
- **`MetaLine`** — the category/author line with its pseudo-element separators appears on
  three different card types under three different class names.
- **`BulletList`** — `.about-list` and the app section's list are the same thing.
- **`Badge`** — four visually distinct markers (`.trend-badge`, `.trend-badge-2`,
  `.course-price`, `.course-viewer li`) grouped under one component with a `tone` prop,
  because they are all "small marker" and share the type scale.

#### Deviations from the source, both deliberate

1. **`overlay` scrim** on `Section` (and available on `HeroSlide`) — the source has none, and
   it is off by default. Turn it on only when substituting a busy photograph.
2. **Focus outline** on `Input` — the source defines no focus style.

The focus ring defaults to on, because a design system that ships an inaccessible field is
worse than one that deviates. The scrim defaults to off, so the shipped look matches the source.

#### Not built

The source defines detail views — `course-details.html`, `teacher-details.html`,
`blog-single.html` — plus `check-out.html` and the three other home variations. Their
markup was not part of the supplied page source, so no component or screen was authored
for them rather than guessing at their structure. The colour switcher and its eight
alternate palettes are also out of scope. Supply those pages and they become the next batch.

### UI kits

| Kit | Screens |
|---|---|
| `ui_kits/website/` | Home, Course index, Teachers, Blog, Shop, About, FAQ, Contact, Login popup |

No slide template was provided, so no sample slides were created.

### A note on the bundle namespace

Consuming code reads components from `window.RaqueDesignSystem_94a18b`. That name comes
from an earlier project title and is now misleading, but it is stable and every card, kit
and template here uses it. Renaming the project would change it and require a
find-and-replace across `components/*/*.card.html`, `ui_kits/website/*` and
`templates/course-landing/*`.
