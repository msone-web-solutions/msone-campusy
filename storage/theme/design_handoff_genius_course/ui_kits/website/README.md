# Genius Course website UI kit

A click-through recreation of the Genius Course marketing site, built from this design
system's components. Open `index.html`.

## Screens

| Screen | File | Source page |
|---|---|---|
| Home | `home.jsx` | `index-2.html` (the page given as the brief) |
| Course index | `pages.jsx` → `CourseScreen` | `course.html` |
| Teachers | `pages.jsx` → `TeacherScreen` | `teacher.html` |
| Blog | `pages.jsx` → `BlogScreen` | `blog.html` |
| Shop | `pages.jsx` → `ShopScreen` | `shop.html` |
| About | `pages.jsx` → `AboutScreen` | `about.html` |
| FAQ | `pages.jsx` → `FaqScreen` | `faq.html` |
| Contact | `pages.jsx` → `ContactScreen` | `contact.html` |
| Login | `login.jsx` | the `#myModal` popup in `index-2.html` |

`shell.jsx` holds the footer wrapper, the `PageTop` header-over-hero used by every
interior page, and the sponsor strip. `data.js` holds all copy and image URLs, taken
verbatim from the source page.

Screen files use lowercase names on purpose: the design-system compiler treats any
PascalCase `.jsx` as a reusable component and would otherwise bundle these screens.

## What is interactive

- The nav and its two dropdowns switch screens; the active item carries the gradient pill.
- "log in" opens the real gradient-headed modal, which validates both fields.
- The hero search carries its query into the course index, which filters on it.
- The course index has working category tabs and a live result count.
- The FAQ tabs reset and drive a working accordion, on both the home band and the FAQ page.
- The testimonial dots switch quotes.
- The home registration form and all message forms confirm on submit.
- Shop product clicks increment a cart count shown above the grid.
- Home-page cards navigate: course cards to the course index, news to the blog, products to
  the shop, category tiles to the course index.

## Section order, verified against the source

`index-2.html` runs: slider → sponsor → popular-course → about-us → **search-course**
→ latest-area → best-product → best-course → faq → course-category → testimonial → teacher
→ contact → footer. `home.jsx` reproduces that order exactly.

One nesting detail worth keeping: the app-download block is **inside** `#search-course`,
sharing its photographic ground with the search bar and the counters. It is not its own
section, so its heading and body copy are white.

## Fidelity notes

**Heading splits are copied, not chosen.** In the source the bold run is a bare `<span>`
inside the `h2` and it lands wherever the copy needs it — "**Popular** Courses.",
"We are **Genius Course** work since 1980.", "Browse Our** Best Course.**",
"**Inventive** Solution for **Education**". Each heading here reproduces its source split
exactly, including whether the space sits inside or outside the span.

**Faithful.** Every value came from the source's own `style.css`, measured by injecting the
real markup (from the page source the user supplied) into a probe page loading the live
stylesheet, then reading computed styles. Colours, gradients, radii, paddings, font sizes
and the absolute line-heights are the authored values.

**Abbreviated.** The source's Owl carousels are rendered as static grids; the countdown
timer, odometer counters and lightbox are shown in their resting state. Index pages repeat
the home page's items rather than inventing new catalogue content.

**Additions, flagged.** Two things here are not in the source: a dark scrim on photographic
sections (the source relies on its own dark photography, which does not survive image
substitution), and a focus ring on form fields (the source defines no focus style at all).
Both are called out in the root readme.

**Not recreated.** `course-details.html`, `teacher-details.html`, `blog-single.html` and
`check-out.html` are detail views whose markup was not part of the page supplied, so no
screen was authored for them.
