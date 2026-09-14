# Component reference — Core primitives

Source, props contract and usage notes for the 9 components in `components/core/`.
These are **design references**, not code to ship — read them for exact values and structure,
then rebuild in the target codebase. See the handoff README for the tokens they consume.

**Contents:** [Button](#button) · [SubmitButton](#submitbutton) · [SectionTitle](#sectiontitle) · [HeroTitle](#herotitle) · [Input](#input) · [Rating](#rating) · [Badge](#badge) · [MetaLine](#metaline) · [BulletList](#bulletlist)


---

## Button

Use `Button` for every standalone call to action. The source pairs two of them side by side ("About Us" + "contact us", "Make Question" + "contact us").

```jsx
<Button href="/about">About Us</Button>
<Button href="/contact">contact us</Button>
<Button icon={null} href="/app">GET THE APP NOW</Button>
<Button variant="outline" href="/course">Our Courses</Button>   {/* on a hero */}
```

Labels keep the source's own inconsistent casing where you are reproducing a page; write new ones in Title Case. Hover slides the gradient — never darken or invert it.

### Props contract

```ts
/**
 * Genius Course's call-to-action (`.genius-btn`): a 56px box with a 2px teal border,
 * 4px radius, uppercase bold label and the house gradient inside. Hover slides the
 * gradient from left to right rather than changing colour — the gradient is authored
 * at 200% width with a repeated start stop specifically to allow that.
 *
 * A caret icon is part of the component, not an option: nearly every button in the
 * source carries `fas fa-caret-right`. Pass `icon={null}` for the few that do not.
 */
export interface ButtonProps {
  /** @default "a" */
  as?: 'a' | 'button';
  /** gradient = the filled button used almost everywhere (`.genius-btn.gradient-bg`);
   *  outline = the source's bare `.genius-btn` — teal border, no fill, white label, as on the
   *  hero's "Our Courses"; outlineInk = the same shape with an ink label for light grounds;
   *  onDark = white border and label. @default "gradient" */
  variant?: 'gradient' | 'outline' | 'outlineInk' | 'onDark';
  /** Font Awesome class, or null for no icon. @default "fas fa-caret-right" */
  icon?: string | null;
  children?: React.ReactNode;
  style?: React.CSSProperties;
  href?: string;
  onClick?: (e: React.MouseEvent) => void;
}
export function Button(props: ButtonProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function Button({
  as = 'a', variant = 'gradient', icon = 'fas fa-caret-right',
  children, style, ...rest
}) {
  const [hover, setHover] = React.useState(false);

  const shell = {
    display: 'inline-block',
    position: 'relative',
    height: 'var(--h-button)',
    lineHeight: 'var(--lh-button)',
    padding: 'var(--pad-button)',
    borderRadius: 'var(--radius)',
    border: 'var(--border-width-button) solid var(--border-button)',
    fontFamily: 'var(--font-sans)',
    fontSize: 'var(--fs-base)',
    fontWeight: 'var(--fw-bold)',
    textTransform: 'uppercase',
    textAlign: 'center',
    textDecoration: 'none',
    whiteSpace: 'nowrap',
    cursor: 'pointer',
    overflow: 'hidden',
    transition: 'var(--transition)'
  };

  const skins = {
    gradient: {
      color: 'var(--genius-white)',
      backgroundImage: 'var(--gradient)',
      backgroundSize: 'var(--gradient-size)',
      backgroundPosition: hover ? 'right center' : 'left center',
      opacity: 'var(--gradient-opacity)'
    },
    /* The source's bare .genius-btn — 2px teal border, no fill, white label.
       This is what the hero's "Our Courses" button is. */
    outline: {
      color: 'var(--genius-white)',
      backgroundImage: hover ? 'var(--gradient)' : 'none',
      backgroundColor: 'transparent',
      backgroundSize: 'var(--gradient-size)',
      backgroundPosition: hover ? 'right center' : 'left center',
      opacity: hover ? 'var(--gradient-opacity)' : 1
    },
    /* Same shape on a light ground, where a white label would vanish. */
    outlineInk: {
      color: hover ? 'var(--genius-white)' : 'var(--text-heading)',
      backgroundImage: hover ? 'var(--gradient)' : 'none',
      backgroundColor: 'transparent',
      backgroundSize: 'var(--gradient-size)',
      backgroundPosition: hover ? 'right center' : 'left center'
    },
    onDark: {
      color: hover ? 'var(--text-heading)' : 'var(--genius-white)',
      backgroundColor: hover ? 'var(--genius-white)' : 'transparent',
      borderColor: 'var(--genius-white)'
    }
  };

  const Tag = as;
  return React.createElement(
    Tag,
    {
      ...rest,
      onMouseEnter: () => setHover(true),
      onMouseLeave: () => setHover(false),
      style: { ...shell, ...skins[variant], ...style }
    },
    children,
    icon ? React.createElement('i', { className: icon, style: { marginLeft: '7px', fontSize: 'var(--fs-base)' } }) : null
  );
}
```


---

## SubmitButton

Use `SubmitButton` as the last element of any form.

```jsx
<SubmitButton>Search Course</SubmitButton>
<SubmitButton icon="fas fa-caret-right">SEND MESSAGE NOW</SubmitButton>
<SubmitButton>Subscribe now</SubmitButton>
```

Never give it a border — that is what separates it from `Button`.

### Props contract

```ts
/**
 * The form submit button (`.nws-button button`): 60px tall, borderless, gradient-filled,
 * 18px bold uppercase. Distinct from `Button` — it has no border and stretches to the
 * width of its form.
 */
export interface SubmitButtonProps {
  children?: React.ReactNode;
  /** Font Awesome class appended after the label, e.g. "fas fa-caret-right". */
  icon?: string;
  /** Fill the form width, as in every source form. @default true */
  block?: boolean;
  type?: 'submit' | 'button';
  style?: React.CSSProperties;
  onClick?: (e: React.MouseEvent) => void;
}
export function SubmitButton(props: SubmitButtonProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function SubmitButton({ children, icon, block = true, style, ...rest }) {
  const [hover, setHover] = React.useState(false);
  return (
    <button {...rest} type={rest.type || 'submit'}
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{
        display: block ? 'block' : 'inline-block',
        width: block ? '100%' : 'auto',
        height: 'var(--h-control)',
        padding: '1px 4px',
        border: 0,
        borderRadius: 'var(--radius)',
        fontFamily: 'var(--font-sans)',
        fontSize: 'var(--fs-submit)',
        fontWeight: 'var(--fw-bold)',
        lineHeight: '25.2px',
        color: 'var(--genius-white)',
        textTransform: 'uppercase',
        textAlign: 'center',
        cursor: 'pointer',
        backgroundImage: 'var(--gradient)',
        backgroundSize: 'var(--gradient-size)',
        backgroundPosition: hover ? 'right center' : 'left center',
        transition: 'var(--transition-gradient)',
        ...style
      }}>
      {children}
      {icon ? <i className={icon} style={{ marginLeft: '7px' }} /> : null}
    </button>
  );
}
```


---

## SectionTitle

Use `SectionTitle` to open a section, and place the bold run with `Em` wherever the copy needs it — the source puts it at the start, middle, end or twice. The trailing full stop is part of the style.

```jsx
<SectionTitle eyebrow="LEARN NEW SKILLS"><Em>Popular</Em> Courses.</SectionTitle>
<SectionTitle align="center" eyebrow="SEARCH OUR COURSES">Browse Our<Em> Best Course.</Em></SectionTitle>
<SectionTitle eyebrow="SORT ABOUT US">We are <Em>Genius Course</Em> work since 1980.</SectionTitle>
<SectionTitle align="center" tone="light" eyebrow="GENIUS COURSE FAQ">Frequently<Em> Ask &amp; Questions</Em></SectionTitle>
```

Mind the spaces: the source often puts them *inside* the span (`<span> Best Course.</span>`), which is why you should copy the copy exactly rather than trimming.

### Props contract

```ts
/**
 * The heading that opens every band (`.section-title`): an uppercase 7px-tracked eyebrow
 * flanked by two 70px teal full stops, then a 38px/300 headline over a 50×2px teal rule.
 *
 * The headline's defining move is a bold run inside the light line. In the source that run
 * is a bare `<span>` and it sits at the **start** ("**Popular** Courses."), the **middle**
 * ("We are **Genius Course** work since 1980."), the **end** ("Browse Our** Best Course.**"),
 * or **twice** ("**Inventive** Solution for **Education**"). So there is no fixed light/bold
 * split — place it yourself with the exported `Em` component.
 */
export interface EmProps {
  children?: React.ReactNode;
  style?: React.CSSProperties;
}
/** The bold run inside a heading. */
export function Em(props: EmProps): JSX.Element;

export interface SectionTitleProps {
  /** Uppercase kicker, e.g. "LEARN NEW SKILLS". Rendered with the flanking teal dots. */
  eyebrow?: string;
  /** The headline. Wrap bold runs in `<Em>`. */
  children?: React.ReactNode;
  /** @default "left" */
  align?: 'left' | 'center';
  /** "light" for photographic or coloured grounds. @default "ink" */
  tone?: 'ink' | 'light';
  /** The 50×2px underline. @default true */
  rule?: boolean;
  style?: React.CSSProperties;
}
export function SectionTitle(props: SectionTitleProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

/** The bold run inside a heading. In the source this is a plain <span> inside the h2,
 *  and it appears at the start, middle, end, or twice — so it must be placed by the author. */
export function Em({ children, style }) {
  return <span style={{ fontWeight: 'var(--fw-bold)', ...style }}>{children}</span>;
}

export function SectionTitle({ eyebrow, children, align = 'left', tone = 'ink', rule = true, style }) {
  const onDark = tone === 'light';
  return (
    <div style={{ textAlign: align, marginBottom: 'var(--space-65)', ...style }}>
      {eyebrow ? (
        <span style={{
          position: 'relative',
          display: 'inline-block',
          fontFamily: 'var(--font-sans)',
          fontSize: 'var(--fs-base)',
          fontWeight: 'var(--fw-regular)',
          lineHeight: 'var(--lh-base)',
          letterSpacing: 'var(--tracking-eyebrow)',
          textTransform: 'uppercase',
          color: onDark ? 'rgba(255,255,255,.75)' : 'var(--text-eyebrow)',
          marginBottom: 'var(--space-10)',
          padding: '0 45px'
        }}>
          <Dot side="left" />
          {eyebrow}
          <Dot side="right" />
        </span>
      ) : null}

      <h2 style={{
        position: 'relative',
        display: 'inline-block',
        fontFamily: 'var(--font-sans)',
        fontSize: 'var(--fs-section)',
        fontWeight: 'var(--fw-light)',
        lineHeight: 'var(--lh-section)',
        color: onDark ? 'var(--genius-white)' : 'var(--text-heading)',
        margin: 0,
        paddingBottom: rule ? '20px' : 0
      }}>
        {children}
        {rule ? (
          <span style={{
            position: 'absolute',
            bottom: 0,
            left: align === 'center' ? '50%' : 0,
            transform: align === 'center' ? 'translateX(-50%)' : 'none',
            width: 'var(--rule-section)',
            height: '2px',
            background: onDark ? 'var(--genius-white)' : 'var(--color-primary)'
          }} />
        ) : null}
      </h2>
    </div>
  );
}

function Dot({ side }) {
  return (
    <span aria-hidden="true" style={{
      position: 'absolute',
      [side]: 0,
      top: '-10px',
      fontSize: 'var(--fs-quote-mark)',
      lineHeight: 1,
      color: 'var(--color-primary)'
    }}>..</span>
  );
}
```


---

## HeroTitle

Use `HeroTitle` only inside a `HeroSlide`.

```jsx
<HeroTitle eyebrow="EDUCATION & TRAINING ORGANIZATION" indent>
  <Em>Inventive</Em> Solution<br /> for <Em>Education</Em>
</HeroTitle>
```

Note the explicit `<br />` — the source breaks this headline manually rather than letting it wrap.

### Props contract

```ts
/**
 * The slider headline: 90px at weight **100** — a hairline at display size — with bold runs
 * placed inside it via `Em`, exactly as `SectionTitle` works. The source's first slide reads
 * `<span>Inventive</span> Solution <br> for <span>Education</span>`, so the bold run opens
 * *and* closes the line.
 *
 * Assumes white type; it only belongs on a `HeroSlide`.
 */
export interface HeroTitleProps {
  /** Uppercase kicker, rendered with the flanking teal dots. */
  eyebrow?: string;
  /** The headline. Wrap bold runs in `Em` (imported from SectionTitle). */
  children?: React.ReactNode;
  /** display = 90px (slider); compact = 70px (`.secoud-title`). @default "display" */
  size?: 'display' | 'compact';
  /** @default "left" */
  align?: 'left' | 'center';
  /** The source's `.ml42` offset on left-aligned eyebrows. @default false */
  indent?: boolean;
  style?: React.CSSProperties;
}
export function HeroTitle(props: HeroTitleProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';
import { Em } from './SectionTitle.jsx';

export function HeroTitle({ eyebrow, children, size = 'display', align = 'left', indent = false, style }) {
  return (
    <div style={{ textAlign: align, ...style }}>
      {eyebrow ? (
        <span style={{
          position: 'relative',
          display: 'inline-block',
          marginLeft: indent ? '42px' : 0,
          fontFamily: 'var(--font-sans)',
          fontSize: 'var(--fs-base)',
          fontWeight: 'var(--fw-regular)',
          lineHeight: 'var(--lh-base)',
          letterSpacing: 'var(--tracking-eyebrow)',
          textTransform: 'uppercase',
          color: 'var(--text-eyebrow)',
          marginBottom: 'var(--space-20)',
          padding: '0 45px'
        }}>
          <span aria-hidden="true" style={{
            position: 'absolute', left: 0, top: '-10px',
            fontSize: 'var(--fs-quote-mark)', lineHeight: 1, color: 'var(--color-primary)'
          }}>..</span>
          {eyebrow}
          <span aria-hidden="true" style={{
            position: 'absolute', right: 0, top: '-10px',
            fontSize: 'var(--fs-quote-mark)', lineHeight: 1, color: 'var(--color-primary)'
          }}>..</span>
        </span>
      ) : null}

      <h2 style={{
        fontFamily: 'var(--font-sans)',
        fontSize: size === 'display' ? 'var(--fs-display)' : 'var(--fs-display-sm)',
        fontWeight: 'var(--fw-thin)',
        lineHeight: size === 'display' ? 'var(--lh-display)' : 'var(--lh-display-sm)',
        color: 'var(--genius-white)',
        margin: 0
      }}>{children}</h2>
    </div>
  );
}
```


---

## Input

Use `Input` for all entry. Genius shows no labels — the placeholder carries the field name, and a trailing asterisk marks a required field.

```jsx
<Input type="email" placeholder="Your@email.com*" />
<Input size="lg" ground="search" placeholder="Type what do you want to learn today?" />
<Input as="textarea" placeholder="Message." ground="veil" />
```

### Props contract

```ts
/**
 * Genius Course's form field. Borderless and filled — the ground colour does the work,
 * not an outline. 50px on standard forms, 60px for the big search bars.
 *
 * The source defines no focus style at all; the teal outline here is this system's
 * own addition for accessibility, and is marked as such in the readme.
 */
export interface InputProps {
  /** @default "input" */
  as?: 'input' | 'textarea' | 'select';
  /** lg = the 60px search field with a 5px radius. @default "md" */
  size?: 'md' | 'lg';
  /** field #eee (forms) · search #f9f9f9 (search bars) · veil 78% white (over photos) · white. @default "field" */
  ground?: 'field' | 'search' | 'veil' | 'white';
  /** Textarea only. @default 4 */
  rows?: number;
  type?: string;
  placeholder?: string;
  value?: string;
  onChange?: (e: React.ChangeEvent) => void;
  children?: React.ReactNode;
  style?: React.CSSProperties;
}
export function Input(props: InputProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function Input({ as = 'input', size = 'md', ground = 'field', rows = 4, style, ...rest }) {
  const [focus, setFocus] = React.useState(false);
  const Tag = as === 'textarea' ? 'textarea' : as === 'select' ? 'select' : 'input';
  const isArea = Tag === 'textarea';

  const grounds = {
    field: 'var(--surface-field)',
    search: 'var(--genius-field-search)',
    veil: 'var(--genius-veil)',
    white: 'var(--genius-white)'
  };

  return React.createElement(Tag, {
    ...rest,
    rows: isArea ? rows : undefined,
    onFocus: () => setFocus(true),
    onBlur: () => setFocus(false),
    style: {
      display: 'block',
      width: '100%',
      height: isArea ? 'var(--h-textarea)' : (size === 'lg' ? 'var(--h-control)' : 'var(--h-field)'),
      padding: isArea ? '15px' : (size === 'lg' ? '0 20px' : 'var(--pad-field)'),
      border: 0,
      outline: focus ? '2px solid var(--color-primary)' : 'none',
      outlineOffset: '-2px',
      borderRadius: size === 'lg' ? 'var(--radius-md)' : 'var(--radius)',
      background: grounds[ground],
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-base)',
      color: '#000',
      resize: isArea ? 'none' : undefined,
      appearance: Tag === 'select' ? 'none' : undefined,
      marginBottom: 'var(--space-10)',
      ...style
    }
  });
}
```


---

## Rating

Use `Rating` on course cards.

```jsx
<Rating />
<Rating value={4} />
```

Amber only — never teal, never grey.

### Props contract

```ts
/**
 * Five amber (#ffc926) Font Awesome stars (`.course-rate`). The source always renders
 * five solid stars regardless of the real score.
 */
export interface RatingProps {
  /** @default 5 */
  value?: number;
  /** @default 5 */
  max?: number;
  /** Glyph size in px. @default 16 */
  size?: number;
  style?: React.CSSProperties;
}
export function Rating(props: RatingProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function Rating({ value = 5, max = 5, size = 16, style }) {
  return (
    <div style={{ display: 'inline-block', lineHeight: 1, ...style }}>
      <ul style={{ display: 'inline-flex', gap: '1px' }}>
        {Array.from({ length: max }).map((_, i) => (
          <li key={i} style={{ display: 'inline-block', color: 'var(--color-rating)' }}>
            <i className={i < Math.round(value) ? 'fas fa-star' : 'far fa-star'}
              style={{ fontSize: size + 'px', color: 'var(--color-rating)' }} />
          </li>
        ))}
      </ul>
    </div>
  );
}
```


---

## Badge

```jsx
<h3>Fully Responsive Web Design. <Badge>TRENDING</Badge></h3>
<Badge tone="price" icon={null}>$99.00</Badge>
<Badge tone="ribbon">Trending</Badge>
<Badge tone="chip"><i className="fas fa-user" /> 1.220</Badge>
```

`price` and `ribbon` are absolutely positioned — put them inside a `position: relative` image wrapper.

### Props contract

```ts
/**
 * The four small markers in the system, each structurally different:
 *
 * - `trend` — inline "⚡ TRENDING" chip in #ff5c26, sitting 6px above the baseline
 *   of a card title (`.trend-badge`).
 * - `ribbon` — the 45°-rotated #ff5a00 corner banner on a best-course thumbnail
 *   (`.trend-badge-2`). Absolutely positioned; its parent needs `overflow: hidden`.
 * - `price` — the gradient price tag pinned 20px from a course image's top-left corner
 *   (`.course-price`).
 * - `chip` — a grey #f7f7f7 metric pill from a course card's footer (`.course-viewer li`).
 */
export interface BadgeProps {
  children?: React.ReactNode;
  /** @default "trend" */
  tone?: 'trend' | 'ribbon' | 'price' | 'chip';
  /** Font Awesome class; null to omit. Defaults to the bolt used by both trend markers. */
  icon?: string | null;
  style?: React.CSSProperties;
}
export function Badge(props: BadgeProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function Badge({ children, tone = 'trend', icon = 'fas fa-bolt', style }) {
  if (tone === 'ribbon') {
    return (
      <div style={{
        position: 'absolute', top: '-18px', left: '-50px',
        padding: '30px 35px 5px',
        background: 'var(--genius-trend-alt)',
        color: 'var(--genius-white)',
        fontFamily: 'var(--font-sans)',
        fontSize: 'var(--fs-xs)',
        fontWeight: 'var(--fw-bold)',
        lineHeight: '16.8px',
        textTransform: 'uppercase',
        textAlign: 'center',
        transform: 'rotate(-45deg)',
        zIndex: 2,
        ...style
      }}>
        {icon ? <i className={icon} style={{ marginRight: '4px' }} /> : null}
        <span>{children}</span>
      </div>
    );
  }

  if (tone === 'price') {
    return (
      <div style={{
        position: 'absolute', top: '20px', left: '20px',
        padding: '5px 15px',
        borderRadius: 'var(--radius)',
        backgroundImage: 'var(--gradient)',
        backgroundSize: 'var(--gradient-size)',
        color: 'var(--genius-white)',
        fontFamily: 'var(--font-sans)',
        fontSize: 'var(--fs-base)',
        fontWeight: 'var(--fw-bold)',
        textAlign: 'center',
        zIndex: 2,
        ...style
      }}><span>{children}</span></div>
    );
  }

  if (tone === 'chip') {
    return (
      <span style={{
        display: 'inline-block',
        padding: 'var(--pad-chip)',
        borderRadius: 'var(--radius-chip)',
        background: 'var(--surface-chip)',
        color: 'var(--text-muted)',
        fontFamily: 'var(--font-sans)',
        fontSize: 'var(--fs-meta)',
        lineHeight: '19.6px',
        ...style
      }}>{children}</span>
    );
  }

  return (
    <span style={{
      display: 'inline-block',
      position: 'relative',
      top: '-6px',
      padding: '5px',
      borderRadius: 'var(--radius-chip)',
      background: 'var(--color-trend)',
      color: 'var(--genius-white)',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-xxs)',
      fontWeight: 'var(--fw-bold)',
      textTransform: 'uppercase',
      whiteSpace: 'nowrap',
      ...style
    }}>
      {icon ? <i className={icon} style={{ marginRight: '3px', fontSize: 'var(--fs-xxs)' }} /> : null}
      {children}
    </span>
  );
}
```


---

## MetaLine

```jsx
<MetaLine items={[
  { label: 'Web Design', accent: true },
  { label: 'John Luis Fernandes' }
]} />
```

Mark only the first item `accent`. Two or three items is the whole range the source uses.

### Props contract

```ts
/**
 * The category / author line on a course card (`.course-meta`). Items are separated by
 * a 1px 15px-tall grey rule drawn as a pseudo-element, not a pipe character, and the
 * first item is teal while the rest are ink.
 */
export interface MetaItem {
  label: React.ReactNode;
  href?: string;
  /** Paint this item teal — the source does this for the category only. */
  accent?: boolean;
}
export interface MetaLineProps {
  items?: MetaItem[];
  /** The source uses 700 on course cards and 400 on the best-course card. @default true */
  bold?: boolean;
  style?: React.CSSProperties;
}
export function MetaLine(props: MetaLineProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function MetaLine({ items = [], bold = true, style }) {
  return (
    <div style={{ display: 'inline-block', width: '100%', ...style }}>
      {items.map((it, i) => (
        <span key={i} style={{
          position: 'relative',
          float: 'left',
          marginRight: i < items.length - 1 ? '28px' : 0,
          fontFamily: 'var(--font-sans)',
          fontSize: 'var(--fs-meta)',
          fontWeight: bold ? 'var(--fw-bold)' : 'var(--fw-regular)',
          lineHeight: '19.6px',
          color: it.accent ? 'var(--text-category)' : 'var(--text-heading)'
        }}>
          <a href={it.href || '#'} style={{ color: 'inherit' }}>{it.label}</a>
          {i < items.length - 1 ? (
            <span style={{
              position: 'absolute', right: '-14px', top: '2px',
              width: '1px', height: '15px', background: 'var(--text-muted)'
            }} />
          ) : null}
        </span>
      ))}
    </div>
  );
}
```


---

## BulletList

```jsx
<BulletList items={[
  'Professional And Experienced Since 1980',
  'Our Mission Increasing Global Access To Quality Aducation',
  '100K Online Available Courses'
]} />
```

The source's "Aducation" typo is real — fix it in new copy.

### Props contract

```ts
/**
 * The claim list used in the About and App sections (`.about-list`): 15px solid teal
 * discs beside 16px/500 ink text. The bullet is a filled circle, not a tick.
 */
export interface BulletListProps {
  items?: React.ReactNode[];
  /** "light" for the app band, which sits on a photographic ground. @default "ink" */
  tone?: 'ink' | 'light';
  style?: React.CSSProperties;
}
export function BulletList(props: BulletListProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function BulletList({ items = [], tone = 'ink', style }) {
  return (
    <ul style={{ marginBottom: 'var(--space-65)', ...style }}>
      {items.map((it, i) => (
        <li key={i} style={{
          position: 'relative',
          paddingLeft: '25px',
          marginBottom: 'var(--space-8)',
          fontFamily: 'var(--font-sans)',
          fontSize: 'var(--fs-base)',
          fontWeight: 'var(--fw-medium)',
          lineHeight: 'var(--lh-base)',
          color: tone === 'light' ? 'var(--genius-white)' : 'var(--text-heading)'
        }}>
          <span style={{
            position: 'absolute', left: 0, top: '2px',
            width: '15px', height: '15px',
            borderRadius: 'var(--radius-circle)',
            background: 'var(--color-primary)'
          }} />
          {it}
        </li>
      ))}
    </ul>
  );
}
```
