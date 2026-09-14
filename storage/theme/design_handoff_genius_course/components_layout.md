# Component reference — Layout & chrome

Source, props contract and usage notes for the 9 components in `components/layout/`.
These are **design references**, not code to ship — read them for exact values and structure,
then rebuild in the target codebase. See the handoff README for the tokens they consume.

**Contents:** [SiteHeader](#siteheader) · [HeroSlide](#heroslide) · [Section](#section) · [Tabs](#tabs) · [Accordion](#accordion) · [CounterStrip](#counterstrip) · [SearchBar](#searchbar) · [ContactAddress](#contactaddress) · [SiteFooter](#sitefooter)


---

## SiteHeader

Use `SiteHeader` as the first element inside a `HeroSlide`, not above it — the source overlays the two.

```jsx
<HeroSlide image="/assets/img/banner/s-4.jpg">
  <SiteHeader logo="/assets/img/logo/logo.png" active="Home" items={nav} onLogin={open} />
  …
</HeroSlide>
```

If you need a header on a white page, give its wrapper a dark ground — the component has no light variant, because the source has none.

### Props contract

```ts
/**
 * The site header (`.main-menu`). It is transparent and overlays the hero — the nav
 * links are white, so it only works on a dark or photographic ground.
 *
 * Nav links are 15px/500 uppercase and carry a gradient pill that fades in behind the label
 * **on hover only** — in the source the current page is not specially marked, so `active`
 * is accepted but intentionally paints nothing. Cart and search are 42px circles outlined
 * in teal. The 300px dropdown is white with a 4px radius and the system's single shadow.
 */
export interface NavItem { label: string; href?: string; children?: NavItem[] }
export interface SiteHeaderProps {
  logo?: string;
  /** Wordmark fallback when no logo is supplied. @default "Genius" */
  brand?: string;
  items?: NavItem[];
  /** Label of the current item. Accepted for semantics; the source marks no active state,
   *  so this paints nothing. */
  active?: string;
  onSelect?: (item: NavItem) => void;
  /** The source's language picker. Pass [] to hide. */
  languages?: string[];
  onLogin?: () => void;
  style?: React.CSSProperties;
}
export function SiteHeader(props: SiteHeaderProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

function NavLink({ item, active, onSelect }) {
  const [open, setOpen] = React.useState(false);
  const on = open;
  return (
    <li style={{ display: 'inline-block', position: 'relative' }}
      onMouseEnter={() => setOpen(true)} onMouseLeave={() => setOpen(false)}>
      <a href={item.href || '#'}
        onClick={(e) => { if (onSelect) { e.preventDefault(); onSelect(item); } }}
        style={{
          position: 'relative',
          display: 'inline-block',
          padding: 'var(--pad-nav-link)',
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-nav)', fontWeight: 'var(--fw-medium)',
          lineHeight: '21px',
          color: 'var(--genius-white)',
          textTransform: 'uppercase',
          textDecoration: 'none',
          borderRadius: 'var(--radius)',
          zIndex: 1
        }}>
        <span style={{
          position: 'absolute', inset: 0,
          borderRadius: 'var(--radius)',
          backgroundImage: 'var(--gradient)',
          backgroundSize: 'var(--gradient-size)',
          opacity: on ? 1 : 0,
          transition: 'var(--transition)',
          zIndex: -1
        }} />
        {item.label}
      </a>

      {item.children && item.children.length ? (
        <ul style={{
          position: 'absolute',
          top: '30px', left: '-115px',
          width: 'var(--w-submenu)',
          padding: 'var(--pad-submenu)',
          background: 'var(--genius-white)',
          borderRadius: 'var(--radius)',
          boxShadow: 'var(--shadow-menu)',
          opacity: open ? 1 : 0,
          visibility: open ? 'visible' : 'hidden',
          transition: 'var(--transition)',
          zIndex: 20
        }}>
          {item.children.map((c, i) => <SubLink key={i} item={c} onSelect={onSelect} />)}
        </ul>
      ) : null}
    </li>
  );
}

function SubLink({ item, onSelect }) {
  const [hover, setHover] = React.useState(false);
  return (
    <li>
      <a href={item.href || '#'}
        onClick={(e) => { if (onSelect) { e.preventDefault(); onSelect(item); } }}
        onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
        style={{
          position: 'relative',
          display: 'block',
          padding: '6px 10px',
          marginBottom: '4px',
          borderRadius: 'var(--radius)',
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-nav)', fontWeight: 'var(--fw-medium)',
          lineHeight: '21px',
          color: hover ? 'var(--genius-white)' : 'var(--text-heading)',
          textTransform: 'capitalize',
          textDecoration: 'none',
          transition: 'var(--transition)',
          zIndex: 1
        }}>
        <span style={{
          position: 'absolute', inset: 0,
          borderRadius: 'var(--radius)',
          backgroundImage: 'var(--gradient)',
          backgroundSize: 'var(--gradient-size)',
          opacity: hover ? 1 : 0,
          transition: 'var(--transition)',
          zIndex: -1
        }} />
        {item.label}
      </a>
    </li>
  );
}

function IconCircle({ icon, label, onClick }) {
  const [hover, setHover] = React.useState(false);
  return (
    <button onClick={onClick} aria-label={label}
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{
        width: '42px', height: '42px',
        display: 'inline-flex', alignItems: 'center', justifyContent: 'center',
        borderRadius: 'var(--radius-circle)',
        border: 'var(--border-width-button) solid var(--color-primary)',
        background: hover ? 'var(--color-primary)' : 'transparent',
        color: 'var(--genius-white)',
        fontSize: 'var(--fs-base)',
        cursor: 'pointer',
        transition: 'var(--transition)'
      }}><i className={icon} /></button>
  );
}

export function SiteHeader({
  logo, brand = 'Genius', items = [], active, onSelect,
  languages = ['ENG', 'BAN', 'ARB', 'FRN'], onLogin, style
}) {
  return (
    <header style={{ position: 'relative', width: '100%', zIndex: 30, ...style }}>
      <div style={{ maxWidth: 'var(--container)', margin: '0 auto', padding: '25px 15px' }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: 'var(--space-30)' }}>
          <a href="#" onClick={(e) => { if (onSelect) { e.preventDefault(); onSelect(items[0] || {}); } }}
            style={{ flexShrink: 0, display: 'inline-block' }}>
            {logo
              ? <img src={logo} alt={brand} style={{ display: 'block', maxHeight: '40px', width: 'auto' }} />
              : <span style={{
                  fontFamily: 'var(--font-sans)', fontSize: '22px', fontWeight: 'var(--fw-bold)',
                  color: 'var(--genius-white)', textTransform: 'uppercase'
                }}>{brand}</span>}
          </a>

          {languages.length ? (
            <span style={{ position: 'relative', flexShrink: 0 }}>
              <select aria-label="Language" style={{
                appearance: 'none',
                background: 'transparent',
                border: 0,
                paddingRight: '18px',
                fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-nav)', fontWeight: 'var(--fw-medium)',
                textTransform: 'uppercase',
                color: 'var(--color-primary)', cursor: 'pointer'
              }}>
                {languages.map((l) => <option key={l} style={{ color: '#333' }}>{l}</option>)}
              </select>
              <i className="fas fa-chevron-down" style={{
                position: 'absolute', right: 0, top: '5px', fontSize: '10px', color: 'var(--color-primary)'
              }} />
            </span>
          ) : null}

          <nav style={{ marginLeft: 'auto', minWidth: 0 }}>
            <ul style={{ display: 'flex', alignItems: 'center', flexWrap: 'wrap' }}>
              {items.map((it, i) => <NavLink key={i} item={it} active={active} onSelect={onSelect} />)}
            </ul>
          </nav>

          <ul style={{ display: 'flex', alignItems: 'center', gap: 'var(--space-10)', flexShrink: 0 }}>
            <li><IconCircle icon="fas fa-shopping-bag" label="Cart" /></li>
            <li><IconCircle icon="fas fa-search" label="Search" /></li>
          </ul>

          <a href="#" onClick={(e) => { if (onLogin) { e.preventDefault(); onLogin(); } }}
            style={{
              flexShrink: 0,
              fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-nav)', fontWeight: 'var(--fw-bold)',
              lineHeight: '21px', color: 'var(--genius-white)', textTransform: 'uppercase',
              textDecoration: 'none'
            }}>log in</a>
        </div>
      </div>
    </header>
  );
}
```


---

## HeroSlide

```jsx
<HeroSlide image="/assets/img/banner/s-4.jpg" minHeight={780}>
  <SiteHeader … />
  <div style={{ maxWidth: 'var(--container)', margin: '0 auto', padding: '180px 15px' }}>
    <HeroTitle eyebrow="EDUCATION & TRAINING ORGANIZATION" emphasis="for Education">Inventive Solution </HeroTitle>
    <Button href="/course" style={{ marginTop: '30px' }}>Our Courses</Button>
  </div>
</HeroSlide>
```

### Props contract

```ts
/**
 * A full-bleed photographic slide, the frame the header and `HeroTitle` sit inside.
 *
 * The source's slides are flat blue illustrations, not photographs, so there is no scrim —
 * `overlay` is off by default and `background` paints the illustration's own blue behind the
 * image. Turn `overlay` on only if you swap in a busy photograph, and note that doing so is
 * a deviation from the source.
 */
export interface HeroSlideProps {
  image?: string;
  /** @default 720 */
  minHeight?: number;
  /** A 45% black scrim. Off by default — the source has none. @default false */
  overlay?: boolean;
  /** Ground colour behind the image, matching the illustration's blue. @default "#0d6fb8" */
  background?: string;
  children?: React.ReactNode;
  style?: React.CSSProperties;
}
export function HeroSlide(props: HeroSlideProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function HeroSlide({ image, minHeight = 720, overlay = false, background = '#0d6fb8', children, style }) {
  return (
    <section style={{
      position: 'relative',
      minHeight: minHeight + 'px',
      background: background,
      backgroundImage: image ? 'url(' + image + ')' : 'none',
      backgroundSize: 'cover',
      backgroundPosition: 'center',
      backgroundRepeat: 'no-repeat',
      overflow: 'hidden',
      ...style
    }}>
      {overlay ? (
        <span style={{ position: 'absolute', inset: 0, background: 'rgba(0,0,0,.45)' }} />
      ) : null}
      <div style={{ position: 'relative', zIndex: 2 }}>{children}</div>
    </section>
  );
}
```


---

## Section

```jsx
<Section tone="alt">
  <SectionTitle eyebrow="GENIUS STAFFS" emphasis="Teachers.">Genius </SectionTitle>
  <Grid cols={4}>{teachers.map(t => <TeacherCard key={t.name} {...t} />)}</Grid>
</Section>

<Section image="/assets/img/banner/fq-1.jpg" pad="faq" overlay>…</Section>
```

Alternate `white` and `alt` down the page; never put two `alt` bands next to each other.

### Props contract

```ts
/**
 * A page band. Genius alternates white and #f7f7f7 grounds and pads generously —
 * 125px is the standard, with four documented exceptions the `pad` prop names.
 * Content is capped at the 1170px container.
 *
 * Also exports `Grid`, a wrapping auto-fit grid on the source's 30px gutter.
 */
export interface SectionProps {
  /** @default "white" */
  tone?: 'white' | 'alt' | 'none';
  /** Background photograph URL. */
  image?: string;
  /** standard 125 · teacher 105 · faq 110 · product 100 · sponsor 60 · none. @default "standard" */
  pad?: 'standard' | 'teacher' | 'faq' | 'product' | 'sponsor' | 'none';
  /** Dark scrim for photographic grounds — this system's addition, not the source's. @default false */
  overlay?: boolean;
  children?: React.ReactNode;
  contentStyle?: React.CSSProperties;
  style?: React.CSSProperties;
}
export function Section(props: SectionProps): JSX.Element;

export interface GridProps {
  /** Nominal column count at the 1170px container. The track minimum is derived from the
   *  resulting design width, so narrower viewports drop to fewer columns rather than
   *  fitting more, thinner ones. @default 3 */
  cols?: number;
  /** @default 30 */
  gap?: number;
  children?: React.ReactNode;
  style?: React.CSSProperties;
}
export function Grid(props: GridProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function Section({
  tone = 'white', image, pad = 'standard', overlay = false,
  children, contentStyle, style
}) {
  const pads = {
    standard: 'var(--section-pad) 0',
    teacher: 'var(--section-pad-teacher) 0',
    faq: 'var(--section-pad-faq) 0',
    product: 'var(--section-pad-product) 0',
    sponsor: 'var(--section-pad-sponsor) 0',
    none: 0
  };
  const tones = {
    white: 'var(--surface-page)',
    alt: 'var(--surface-alt)',
    none: 'transparent'
  };

  return (
    <section style={{
      position: 'relative',
      padding: pads[pad],
      background: tones[tone],
      backgroundImage: image ? 'url(' + image + ')' : undefined,
      backgroundSize: image ? 'cover' : undefined,
      backgroundPosition: image ? 'center' : undefined,
      backgroundRepeat: image ? 'no-repeat' : undefined,
      overflow: 'hidden',
      ...style
    }}>
      {overlay ? <span style={{ position: 'absolute', inset: 0, background: 'rgba(0,0,0,.55)' }} /> : null}
      <div style={{
        position: 'relative', zIndex: 2,
        maxWidth: 'var(--container)', margin: '0 auto', padding: '0 15px',
        ...contentStyle
      }}>{children}</div>
    </section>
  );
}

export function Grid({ cols = 3, gap = 30, children, style }) {
  // Derive the track minimum from the real design width at the 1170px container, so a
  // narrow viewport drops to fewer columns instead of squeezing in more, thinner ones.
  const design = (1170 - gap * (cols - 1)) / cols;
  const min = Math.round(design * 0.8);
  return (
    <div style={{
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(min(' + min + 'px,100%),1fr))',
      gap: gap + 'px',
      ...style
    }}>{children}</div>
  );
}
```


---

## Tabs

```jsx
<Tabs items={['GENERAL','COURSES','TEACHERS','EVENTS','OTHERS']} active={tab} onChange={setTab} />
```

Labels are uppercase in the source; the component does not transform them for you beyond CSS.

### Props contract

```ts
/**
 * The FAQ tab strip (`.tab-button`): uppercase pills on a solid #006dad ground that
 * swap to the gradient when active or hovered. 4px radius, like everything else.
 */
export interface TabsProps {
  /** Labels, e.g. ["GENERAL","COURSES","TEACHERS","EVENTS","OTHERS"]. */
  items?: string[];
  active?: string;
  onChange?: (label: string) => void;
  /** @default "center" */
  align?: 'center' | 'left';
  style?: React.CSSProperties;
}
export function Tabs(props: TabsProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function Tabs({ items = [], active, onChange, align = 'center', style }) {
  return (
    <div style={{ textAlign: align, marginBottom: 'var(--space-45)', ...style }}>
      <ul style={{ display: 'inline-flex', gap: 'var(--space-10)', flexWrap: 'wrap', justifyContent: 'center' }}>
        {items.map((it) => <Tab key={it} label={it} on={it === active} onClick={() => onChange && onChange(it)} />)}
      </ul>
    </div>
  );
}

function Tab({ label, on, onClick }) {
  const [hover, setHover] = React.useState(false);
  const lit = on || hover;
  return (
    <li>
      <button onClick={onClick}
        onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
        style={{
          position: 'relative',
          padding: 'var(--pad-chip)',
          border: 0,
          borderRadius: 'var(--radius)',
          background: 'var(--genius-tab)',
          color: 'var(--genius-white)',
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-base)', fontWeight: 'var(--fw-medium)',
          textTransform: 'uppercase',
          cursor: 'pointer',
          zIndex: 1,
          overflow: 'hidden'
        }}>
        <span style={{
          position: 'absolute', inset: 0,
          borderRadius: 'var(--radius)',
          backgroundImage: 'var(--gradient)',
          backgroundSize: 'var(--gradient-size)',
          opacity: lit ? 1 : 0,
          transition: 'var(--transition)',
          zIndex: -1
        }} />
        {label}
      </button>
    </li>
  );
}
```


---

## Accordion

```jsx
<Accordion items={[
  { question: 'How to Register or Make An Account in Genius?', answer: 'Lorem ipsum…' },
  { question: 'What is Genius Courses?', answer: 'Lorem ipsum…' }
]} />
```

Resist adding an icon to the question — the bare 26px line is the design.

### Props contract

```ts
/**
 * The FAQ accordion (`.panel`). Questions are an unusually large 26px at regular weight
 * with no chevron, plus/minus or divider — the open answer is marked only by a 3px teal
 * bar down its left edge. On the source's photographic FAQ ground the answer text is
 * #67a0c9; use `tone="dark"` on a white page.
 */
export interface AccordionItem { question: React.ReactNode; answer: React.ReactNode }
export interface AccordionProps {
  items?: AccordionItem[];
  /** Index of the open item; -1 for none. @default 0 */
  openIndex?: number;
  /** Provide to control the component; omit to let it manage its own state. */
  onToggle?: (index: number) => void;
  /** "light" = white questions for the photographic ground; "dark" = ink on white. @default "light" */
  tone?: 'light' | 'dark';
  style?: React.CSSProperties;
}
export function Accordion(props: AccordionProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function Accordion({ items = [], openIndex = 0, onToggle, tone = 'light', style }) {
  const [internal, setInternal] = React.useState(openIndex);
  const current = onToggle ? openIndex : internal;
  const set = (i) => (onToggle ? onToggle(i === current ? -1 : i) : setInternal(i === current ? -1 : i));
  const onDark = tone === 'light';

  return (
    <div style={style}>
      {items.map((it, i) => {
        const open = i === current;
        return (
          <div key={i} style={{ marginBottom: 'var(--space-45)' }}>
            <h3 style={{
              position: 'relative',
              fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-accordion)', fontWeight: 'var(--fw-regular)',
              lineHeight: 'var(--lh-accordion)', margin: 0
            }}>
              <button onClick={() => set(i)} aria-expanded={open}
                style={{
                  display: 'block', width: '100%',
                  padding: 0, border: 0, background: 'transparent',
                  textAlign: 'left', cursor: 'pointer',
                  fontFamily: 'inherit', fontSize: 'inherit', fontWeight: 'inherit', lineHeight: 'inherit',
                  color: onDark ? 'var(--genius-white)' : 'var(--text-heading)'
                }}>{it.question}</button>
            </h3>
            {open ? (
              <div style={{
                position: 'relative',
                marginTop: 'var(--space-15)',
                paddingLeft: 'var(--space-15)',
                fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-base)', lineHeight: 'var(--lh-base)',
                color: onDark ? 'var(--genius-faq-body)' : 'var(--text-body)'
              }}>
                <span style={{
                  position: 'absolute', left: 0, top: 0, bottom: 0,
                  width: 'var(--bar-faq)', background: 'var(--color-primary)'
                }} />
                {it.answer}
              </div>
            ) : null}
          </div>
        );
      })}
    </div>
  );
}
```


---

## CounterStrip

```jsx
<CounterStrip items={[
  { icon: 'flaticon-graduation-hat', value: '5', suffix: ' M+', label: 'Students Enrolled' },
  { icon: 'flaticon-book', value: '122', suffix: '.500+', label: 'Online Available Courses' },
  { icon: 'flaticon-favorites-button', value: '15', suffix: '.000+', label: 'Premium Quality Products' },
  { icon: 'flaticon-group', value: '7', suffix: '.500+', label: 'Teachers Registered' }
]} />
```

Split the figure at the point where the source does — the digits go in `value`, everything else in `suffix`. Only place it on a dark ground; there is no ink variant.

### Props contract

```ts
/**
 * The statistics row (`.counter-icon-number`). Three details matter and are easy to miss:
 * the glyph is **gradient-clipped** (the source's `.text-gradiant`), and the figure is split
 * into a 30px/700 `value` and a 16px/400 `suffix` — the source writes
 * `<span class="counter-count">5 </span><span>M+</span>`, so "5" is large and bold while
 * "M+" is body size. White only; it always sits on a photographic band.
 *
 * The source animates the figures up from zero on scroll; render the final value in mocks.
 */
export interface CounterItem {
  /** Flaticon class. Rendered gradient-clipped. */
  icon?: string;
  /** The large bold figure, e.g. "5" or "122". */
  value: React.ReactNode;
  /** The small regular remainder, e.g. " M+" or ".500+". */
  suffix?: React.ReactNode;
  label: React.ReactNode;
}
export interface CounterStripProps {
  items?: CounterItem[];
  style?: React.CSSProperties;
}
export function CounterStrip(props: CounterStripProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function CounterStrip({ items = [], style }) {
  return (
    <div style={{
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(200px,1fr))',
      gap: 'var(--gutter)',
      ...style
    }}>
      {items.map((it, i) => (
        <div key={i} style={{ display: 'flex', alignItems: 'flex-start', gap: 'var(--space-15)' }}>
          {it.icon ? (
            <span style={{
              flexShrink: 0, width: '60px', lineHeight: 'var(--lh-circle)',
              fontSize: '40px', textAlign: 'center'
            }}>
              <i className={it.icon} style={{
                fontStyle: 'normal',
                backgroundImage: 'var(--gradient-text)',
                WebkitBackgroundClip: 'text',
                backgroundClip: 'text',
                WebkitTextFillColor: 'transparent',
                color: 'var(--color-primary)'
              }} />
            </span>
          ) : null}
          <div>
            <div style={{ lineHeight: '27px' }}>
              <span style={{
                fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-counter)', fontWeight: 'var(--fw-bold)',
                color: 'var(--genius-white)'
              }}>{it.value}</span>
              {it.suffix ? (
                <span style={{
                  fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-base)', fontWeight: 'var(--fw-regular)',
                  color: 'var(--genius-white)'
                }}>{it.suffix}</span>
              ) : null}
            </div>
            <p style={{
              margin: 0, marginTop: 'var(--space-10)',
              fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-base)', lineHeight: 'var(--lh-base)',
              color: 'var(--genius-white)'
            }}>{it.label}</p>
          </div>
        </div>
      ))}
    </div>
  );
}
```


---

## SearchBar

```jsx
<SearchBar value={q} onChange={e => setQ(e.target.value)} onSubmit={run} />
```

Appears twice in the source — inside the hero and again as its own band.

### Props contract

```ts
/**
 * The course search bar (`.search-course`): a 700px-wide 60px #f9f9f9 field with a
 * 5px radius and the gradient submit button butted against its right edge.
 */
export interface SearchBarProps {
  /** @default "Type what do you want to learn today?" */
  placeholder?: string;
  /** @default "Search Course" */
  label?: string;
  value?: string;
  onChange?: (e: React.ChangeEvent) => void;
  onSubmit?: () => void;
  style?: React.CSSProperties;
}
export function SearchBar(props: SearchBarProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';
import { SubmitButton } from '../core/SubmitButton.jsx';
import { Input } from '../core/Input.jsx';

export function SearchBar({
  placeholder = 'Type what do you want to learn today?',
  label = 'Search Course', value, onChange, onSubmit, style
}) {
  return (
    <form onSubmit={(e) => { e.preventDefault(); onSubmit && onSubmit(); }}
      style={{
        position: 'relative',
        maxWidth: 'var(--search-width)',
        ...style
      }}>
      <Input size="lg" ground="search" placeholder={placeholder} value={value} onChange={onChange}
        style={{ marginBottom: 0, paddingRight: '190px' }} />
      <div style={{ position: 'absolute', right: 0, top: 0, width: '180px' }}>
        <SubmitButton>{label}</SubmitButton>
      </div>
    </form>
  );
}
```


---

## ContactAddress

```jsx
<ContactAddress items={[
  { icon: 'fas fa-map-marker-alt', lines: ['Primary: Last Vegas, 120 Graphic Street, US', 'Second: Califorinia, 88 Design Street, US'] },
  { icon: 'fas fa-phone', lines: ['Primary: (100) 3434 55666', 'Second: (20) 3434 9999'] }
]} />
```

### Props contract

```ts
/**
 * The contact detail list (`.contact-address`): a 60px gradient-ringed round icon beside
 * two lines of detail. The source labels both lines "Primary:" and "Second:" rather than
 * naming the channel.
 */
export interface AddressBlock {
  /** Font Awesome class, e.g. "fas fa-map-marker-alt". */
  icon: string;
  lines: React.ReactNode[];
}
export interface ContactAddressProps {
  items?: AddressBlock[];
  style?: React.CSSProperties;
}
export function ContactAddress(props: ContactAddressProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function ContactAddress({ items = [], style }) {
  return (
    <div style={{ ...style }}>
      {items.map((it, i) => (
        <div key={i} style={{ display: 'flex', gap: 'var(--space-20)', marginBottom: 'var(--space-30)' }}>
          <span style={{
            position: 'relative',
            flexShrink: 0,
            width: 'var(--h-addr-icon)', height: 'var(--h-addr-icon)',
            lineHeight: 'var(--h-addr-icon)',
            borderRadius: 'var(--radius-addr)',
            border: 'var(--border-width-addr) solid transparent',
            backgroundImage: 'var(--gradient)',
            backgroundOrigin: 'border-box',
            textAlign: 'center',
            color: 'var(--genius-white)',
            fontSize: '22px'
          }}><i className={it.icon} /></span>
          <ul style={{ paddingTop: '4px' }}>
            {it.lines.map((l, j) => (
              <li key={j} style={{
                fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-base)', lineHeight: '28px',
                color: 'var(--text-body)'
              }}>{l}</li>
            ))}
          </ul>
        </div>
      ))}
    </div>
  );
}
```


---

## SiteFooter

```jsx
<SiteFooter
  logo="/assets/img/logo/logo.png"
  blurb="We take our mission of increasing global access to quality education seriously."
  socials={[{ icon: 'fab fa-facebook-f' }, { icon: 'fab fa-twitter' }, { icon: 'fab fa-google-plus-g' }]}
  legal={[{ label: 'License' }, { label: 'Privacy & Policy' }, { label: 'Term Of Service' }]}
  copyright="© 2018 - Designed & Developed by Jthemes Studio. All rights reserved"
/>
```

Do not add link columns — the absence of them is the design.

### Props contract

```ts
/**
 * The footer (`.footer_2`). Unusually for an education template it has no link columns:
 * a centred logo, one sentence of mission copy, a 735px subscribe form, a row of social
 * icons, then the copyright and legal links. All type is white over a darkened
 * photographic ground.
 */
export interface FooterLink { label: string; href?: string }
export interface SiteFooterProps {
  logo?: string;
  /** @default "Genius" */
  brand?: string;
  /** The single mission sentence. */
  blurb?: React.ReactNode;
  socials?: { icon: string; href?: string; label?: string }[];
  /** License / Privacy / Terms. */
  legal?: FooterLink[];
  copyright?: React.ReactNode;
  /** Background photograph. */
  image?: string;
  onSubscribe?: () => void;
  style?: React.CSSProperties;
}
export function SiteFooter(props: SiteFooterProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';
import { SubmitButton } from '../core/SubmitButton.jsx';
import { Input } from '../core/Input.jsx';

export function SiteFooter({
  logo, brand = 'Genius', blurb, socials = [], legal = [], copyright,
  image, onSubscribe, style
}) {
  return (
    <footer style={{
      position: 'relative',
      backgroundColor: '#1b1b1b',
      backgroundImage: image ? 'url(' + image + ')' : undefined,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
      ...style
    }}>
      <span style={{ position: 'absolute', inset: 0, background: 'rgba(0,0,0,.7)' }} />
      <div style={{
        position: 'relative', zIndex: 2,
        maxWidth: 'var(--container)', margin: '0 auto', padding: 'var(--space-60) 15px var(--space-30)'
      }}>
        <div style={{ textAlign: 'center' }}>
          {logo
            ? <img src={logo} alt={brand} style={{ display: 'inline-block', maxHeight: '40px', width: 'auto' }} />
            : <span style={{
                fontFamily: 'var(--font-sans)', fontSize: '22px', fontWeight: 'var(--fw-bold)',
                color: 'var(--genius-white)', textTransform: 'uppercase'
              }}>{brand}</span>}
        </div>

        {blurb ? (
          <p style={{
            maxWidth: 'var(--subscribe-width)', margin: 'var(--space-20) auto 0',
            textAlign: 'center',
            fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-base)', lineHeight: 'var(--lh-base)',
            color: 'var(--genius-white)'
          }}>{blurb}</p>
        ) : null}

        <form onSubmit={(e) => { e.preventDefault(); onSubscribe && onSubscribe(); }}
          style={{
            position: 'relative',
            maxWidth: 'var(--subscribe-width)',
            margin: 'var(--space-35) auto var(--space-60)'
          }}>
          <Input size="lg" ground="search" type="email" placeholder="Email Address."
            style={{ marginBottom: 0, paddingRight: '200px' }} />
          <div style={{ position: 'absolute', right: 0, top: 0, width: '190px' }}>
            <SubmitButton>Subscribe now</SubmitButton>
          </div>
        </form>

        {socials.length ? (
          <ul style={{ display: 'flex', justifyContent: 'center', gap: 'var(--space-20)', marginBottom: 'var(--space-30)' }}>
            {socials.map((s, i) => <Social key={i} s={s} />)}
          </ul>
        ) : null}

        <div style={{
          display: 'flex', alignItems: 'center', justifyContent: 'space-between',
          gap: 'var(--space-20)', flexWrap: 'wrap',
          borderTop: 'var(--border-width) solid rgba(255,255,255,.15)',
          paddingTop: 'var(--space-25)'
        }}>
          <p style={{
            margin: 0,
            fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-base)', lineHeight: 'var(--lh-base)',
            color: 'var(--genius-white)'
          }}>{copyright}</p>
          {legal.length ? (
            <ul style={{ display: 'flex', gap: 'var(--space-20)', flexWrap: 'wrap' }}>
              {legal.map((l, i) => <LegalLink key={i} l={l} />)}
            </ul>
          ) : null}
        </div>
      </div>
    </footer>
  );
}

function Social({ s }) {
  const [hover, setHover] = React.useState(false);
  return (
    <li>
      <a href={s.href || '#'} aria-label={s.label}
        onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
        style={{
          display: 'inline-block',
          lineHeight: 'var(--lh-chip)',
          fontSize: 'var(--fs-base)',
          color: hover ? 'var(--color-primary)' : 'var(--genius-white)',
          transition: 'var(--transition)'
        }}><i className={s.icon} /></a>
    </li>
  );
}

function LegalLink({ l }) {
  const [hover, setHover] = React.useState(false);
  return (
    <li>
      <a href={l.href || '#'}
        onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
        style={{
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-base)',
          color: hover ? 'var(--color-primary)' : 'var(--genius-white)',
          textDecoration: 'none', transition: 'var(--transition)'
        }}>{l.label}</a>
    </li>
  );
}
```
