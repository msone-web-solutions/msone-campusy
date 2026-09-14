# Assets

**No binaries are stored in this project.** `jthemes.net` serves the Genius Course demo without
cross-origin access headers, so the logo and imagery could not be downloaded programmatically.
Nothing here has been redrawn, traced or approximated.

Every asset is referenced from its original URL. The base is:

    https://jthemes.net/themes/html/genius-course/assets/img/

## Logo

| File | Use |
|---|---|
| `logo/logo.png` | the only lockup. It is a light mark, so it appears solely on dark or gradient grounds — the header overlays the hero, and the footer is a darkened photograph. |
| `logo/p-logo.jpg` | a square variant used once, in the login popup header. |

There is no dark-on-light lockup in the source. `SiteHeader` and `SiteFooter` fall back to the
word "Genius" set in Roboto bold when no `logo` prop is passed.

## Imagery

- Hero slides, in the order the carousel shows them:
  1. `banner/sd-1.jpg` — the rocket illustration on a flat `#0d6fb8` ground. **This is the
     first slide**, the one the page opens on, and the one to use for a single-slide hero.
  2. `banner/s-4.jpg` (`.slider-bg-2`, also reused by `.slider-bg-4`)
  3. `banner/s-3.jpg` (`.slider-bg-3`) — carries the countdown slide
- Section grounds: `banner/hb-2.jpg` (search + counters), `banner/fq-1.jpg` (FAQ), `banner/cf-1.png` (contact), `banner/bt.png` (footer)
- Courses: `course/c-1..3.jpg` (wide cards), `course/bc-1..8.jpg` (grid cards)
- Teachers: `teacher/tb-1..4.png` — transparent PNGs, cut to circles by the component
- Products: `product/bp-1..4.png` — transparent packshots
- Blog: `blog/lb-1..2.jpg`
- About: `about/abt.jpg`, `about/ab-2.png`
- Video poster: `banner/v-1.jpg`
- Sponsors: `sponsor/s-1..6.jpg`

The vendor ships these as licensed demo stock; they are not redistributable with the template.

## Icons — two sets, both real

1. **Font Awesome 5 Free** for all UI glyphs: `fas fa-caret-right` (in nearly every button),
   `fa-arrow-right`, `fa-bolt` (trend badges), `fa-star` (ratings), `fa-user`,
   `fa-comment-dots`, `fa-cart-plus`, `fa-play`, `fa-search`, `fa-shopping-bag`,
   `fa-map-marker-alt`, `fa-phone`, `fa-envelope`, `fa-times`, `fa-chevron-left/right`,
   plus `fab` brand marks for Facebook, Twitter, Google Plus, Apple, Android and Windows.

2. **Flaticon**, a bespoke icon font, for the subject-category glyphs — and these are the ones
   that carry the brand gradient clipped to the glyph shape. The classes present in the source:
   `flaticon-technology`, `flaticon-technology-1`, `flaticon-technology-2`,
   `flaticon-app-store`, `flaticon-artist-tools`, `flaticon-business`, `flaticon-dna`,
   `flaticon-cogwheel`, `flaticon-favorites-button`, `flaticon-group`, `flaticon-book`,
   `flaticon-graduation-hat`.

Both stylesheets are linked from the source host, so **neither is a substitution** — the cards
and kit load the template's own icon fonts. If you self-host later, copy
`assets/css/fontawesome-all.css`, `assets/css/flaticon.css` and their font binaries.

## To make this self-contained

Drop the template's `assets/` folder into this directory, then change the `img` value at the top
of `ui_kits/website/data.js`, the `IMG`/`CSS` constants in the `guidelines/*.html` cards and the
component `*.card.html` files, and the path in `thumbnail.html`.
