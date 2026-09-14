# Component reference — Cards

Source, props contract and usage notes for the 8 components in `components/cards/`.
These are **design references**, not code to ship — read them for exact values and structure,
then rebuild in the target codebase. See the handoff README for the tokens they consume.

**Contents:** [CourseCard](#coursecard) · [BestCourseCard](#bestcoursecard) · [NewsCard](#newscard) · [EventCard](#eventcard) · [ProductCard](#productcard) · [TeacherCard](#teachercard) · [TestimonialSlide](#testimonialslide) · [CategoryTile](#categorytile)


---

## CourseCard

Use `CourseCard` in the popular-courses carousel and any wide course grid.

```jsx
<CourseCard
  image="/assets/img/course/c-1.jpg"
  price="$99.00"
  category="Web Design"
  author="John Luis Fernandes"
  title="Fully Responsive Web Design & Development."
  trending
  metrics={[
    { icon: 'fas fa-user', label: '1.220' },
    { icon: 'fas fa-comment-dots', label: '1.015' },
    { label: '125k Unrolled' }
  ]}
/>
```

Do not put it on a white panel — the card is deliberately surface-less. The source's "Unrolled" (for Enrolled) is its own typo.

### Props contract

```ts
/**
 * The primary course card (`.course-item-pic-text`), used in the "Popular Courses" carousel.
 * It has no card surface at all — no background, no border, no shadow. Structure is carried
 * by a 4px-radius image with a gradient price tag, then the meta line, stars, a 22px title
 * underlined by a 50×3px gradient rule, and a row of grey metric chips.
 *
 * The "COURSE DETAIL" link is hidden until hover, as in the source.
 */
export interface CourseMetric { icon?: string; label: React.ReactNode }
export interface CourseCardProps {
  image: string;
  /** Display string, e.g. "$99.00". */
  price?: string;
  category: string;
  author: string;
  title: string;
  href?: string;
  /** @default 5 */
  rating?: number;
  /** Appends the inline TRENDING badge to the title. @default false */
  trending?: boolean;
  /** The footer chips — students, comments, enrolled. */
  metrics?: CourseMetric[];
  /** Forwarded to the card root; sets a pointer cursor when present. */
  onClick?: (e: React.MouseEvent) => void;
  style?: React.CSSProperties;
}
export function CourseCard(props: CourseCardProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';
import { Badge } from '../core/Badge.jsx';
import { Rating } from '../core/Rating.jsx';
import { MetaLine } from '../core/MetaLine.jsx';

export function CourseCard({
  image, price, category, author, title, href = '#',
  rating = 5, trending = false, metrics = [], onClick, style, ...rest
}) {
  const [hover, setHover] = React.useState(false);
  return (
    <div {...rest} onClick={onClick}
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{ cursor: onClick ? 'pointer' : undefined, ...style }}>
      <div style={{
        position: 'relative',
        marginBottom: 'var(--space-25)',
        borderRadius: 'var(--radius)',
        overflow: 'hidden'
      }}>
        <img src={image} alt="" style={{
          display: 'block', width: '100%',
          transform: hover ? 'scale(1.06)' : 'none',
          transition: 'var(--transition)'
        }} />
        {price ? <Badge tone="price" icon={null}>{price}</Badge> : null}
        <div style={{
          position: 'absolute', top: '25px', right: '5px',
          opacity: hover ? 1 : 0,
          transition: 'var(--transition)'
        }}>
          <a href={href} style={{
            fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-xs)', fontWeight: 'var(--fw-bold)',
            color: 'var(--genius-white)', textTransform: 'uppercase', textDecoration: 'none'
          }}>COURSE DETAIL <i className="fas fa-arrow-right" /></a>
        </div>
      </div>

      <div>
        <MetaLine items={[
          { label: category, accent: true },
          { label: author }
        ]} />
        <div style={{ marginTop: '2px' }}><Rating value={rating} /></div>

        <div style={{ position: 'relative', marginTop: 'var(--space-10)', paddingBottom: 'var(--space-30)' }}>
          <h3 style={{
            fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-card-title)', fontWeight: 'var(--fw-medium)',
            lineHeight: 'var(--lh-card-title)', margin: 0,
            color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
            transition: 'var(--transition)'
          }}>
            <a href={href} style={{ color: 'inherit' }}>{title}</a>
            {trending ? <> <Badge>TRENDING</Badge></> : null}
          </h3>
          <span style={{
            position: 'absolute', bottom: 'var(--space-25)', left: 0,
            width: 'var(--rule-card)', height: '3px',
            backgroundImage: 'var(--gradient)'
          }} />
        </div>

        {metrics.length ? (
          <ul style={{ display: 'flex', gap: '5px', flexWrap: 'wrap' }}>
            {metrics.map((m, i) => (
              <li key={i}>
                <Badge tone="chip">
                  {m.icon ? <i className={m.icon} style={{ marginRight: '5px' }} /> : null}{m.label}
                </Badge>
              </li>
            ))}
          </ul>
        ) : null}
      </div>
    </div>
  );
}
```


---

## BestCourseCard

Use `BestCourseCard` for four-up and wider course grids.

```jsx
<BestCourseCard
  image="/assets/img/course/bc-1.jpg"
  price="$99.00" trending
  title="Fully Responsive Web Design & Development."
  category="Web Design" students="250 Students"
/>
```

Its meta line is regular weight, not bold — that is the one difference from `CourseCard`.

### Props contract

```ts
/**
 * The compact grid card (`.best-course-pic-text`) from "Browse Our Best Course.".
 * Unlike `CourseCard` this one does have a white 4px-radius text panel. On hover the
 * thumbnail takes a 65%-black scrim and the stars plus the COURSE DETAIL link fade in
 * over it. A 45°-rotated orange ribbon marks a trending item.
 */
export interface BestCourseCardProps {
  image: string;
  price?: string;
  title: string;
  category: string;
  /** e.g. "250 Students". */
  students: string;
  href?: string;
  /** @default 5 */
  rating?: number;
  /** Shows the corner ribbon. @default false */
  trending?: boolean;
  /** Forwarded to the card root; sets a pointer cursor when present. */
  onClick?: (e: React.MouseEvent) => void;
  style?: React.CSSProperties;
}
export function BestCourseCard(props: BestCourseCardProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';
import { Badge } from '../core/Badge.jsx';
import { Rating } from '../core/Rating.jsx';
import { MetaLine } from '../core/MetaLine.jsx';

export function BestCourseCard({
  image, price, title, category, students, href = '#',
  rating = 5, trending = false, onClick, style, ...rest
}) {
  const [hover, setHover] = React.useState(false);
  return (
    <div {...rest} onClick={onClick}
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{ position: 'relative', paddingTop: 'var(--space-30)', borderRadius: 'var(--radius)', cursor: onClick ? 'pointer' : undefined, ...style }}>
      <div style={{ position: 'relative', borderRadius: 'var(--radius)', overflow: 'hidden' }}>
        <img src={image} alt="" style={{ display: 'block', width: '100%' }} />
        {trending ? <Badge tone="ribbon">Trending</Badge> : null}
        {price ? <Badge tone="price" icon={null}>{price}</Badge> : null}

        <div style={{
          position: 'absolute', inset: 0,
          background: 'var(--genius-scrim)',
          borderRadius: 'var(--radius)',
          opacity: hover ? 1 : 0,
          transition: 'var(--transition)'
        }} />

        <div style={{
          position: 'absolute', left: 0, right: 0, bottom: '55px',
          textAlign: 'center', zIndex: 2,
          opacity: hover ? 1 : 0, transition: 'var(--transition)'
        }}><Rating value={rating} /></div>

        <div style={{
          position: 'absolute', left: 0, right: 0, bottom: '25px',
          textAlign: 'center', zIndex: 2,
          opacity: hover ? 1 : 0, transition: 'var(--transition)'
        }}>
          <a href={href} style={{
            fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-xs)', fontWeight: 'var(--fw-bold)',
            color: 'var(--genius-white)', textTransform: 'uppercase', textDecoration: 'none'
          }}>COURSE DETAIL <i className="fas fa-arrow-right" /></a>
        </div>
      </div>

      <div style={{
        background: 'var(--surface-card)',
        borderRadius: 'var(--radius)',
        padding: 'var(--pad-card-text)',
        transition: 'var(--transition)'
      }}>
        <h3 style={{
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-card-title)', fontWeight: 'var(--fw-medium)',
          lineHeight: 'var(--lh-card-title)', margin: 0, marginBottom: 'var(--space-20)',
          color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
          transition: 'var(--transition)'
        }}><a href={href} style={{ color: 'inherit' }}>{title}</a></h3>
        <MetaLine bold={false} items={[
          { label: category, accent: true },
          { label: students }
        ]} />
      </div>
    </div>
  );
}
```


---

## NewsCard

Use `NewsCard` in the three-column "Latest" band and on the blog index.

```jsx
<NewsCard
  image="/assets/img/blog/lb-1.jpg"
  date="26 April 2018"
  title="Affiliate Marketing A Beginner’s Guide."
  metrics={[{ icon: 'fas fa-user', label: '1.220' }, { icon: 'fas fa-comment-dots', label: '1.015' }]}
/>
```

### Props contract

```ts
/**
 * A "Latest News." item (`.latest-news-area`): a 120×120 thumbnail floated left of a
 * grey date line, an 18px/700 title and optional view/comment counts, with a 1px #ccc
 * rule beneath. Capped at 335px — it is a narrow-column component.
 */
export interface NewsMetric { icon?: string; label: React.ReactNode }
export interface NewsCardProps {
  image?: string;
  /** e.g. "26 April 2018". */
  date?: string;
  title: string;
  href?: string;
  metrics?: NewsMetric[];
  /** Drops the bottom rule on the last item. @default false */
  last?: boolean;
  /** Forwarded to the card root; sets a pointer cursor when present. */
  onClick?: (e: React.MouseEvent) => void;
  style?: React.CSSProperties;
}
export function NewsCard(props: NewsCardProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function NewsCard({ image, date, title, href = '#', metrics = [], last = false, onClick, style, ...rest }) {
  const [hover, setHover] = React.useState(false);
  return (
    <div {...rest} onClick={onClick}
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{
        cursor: onClick ? 'pointer' : undefined,
        display: 'inline-block', width: '100%',
        maxWidth: '335px',
        paddingBottom: 'var(--space-30)',
        marginBottom: 'var(--space-30)',
        borderBottom: last ? 0 : 'var(--border-width) solid var(--border-default)',
        ...style
      }}>
      {image ? (
        <div style={{
          float: 'left', width: 'var(--w-news-thumb)', height: 'var(--w-news-thumb)',
          marginRight: 'var(--space-20)', overflow: 'hidden', position: 'relative'
        }}>
          <a href={href}>
            <img src={image} alt="" style={{
              width: '100%', height: '100%', objectFit: 'cover', display: 'block',
              transform: hover ? 'scale(1.08)' : 'none', transition: 'var(--transition)'
            }} />
          </a>
        </div>
      ) : null}

      <div style={{ overflow: 'hidden' }}>
        {date ? (
          <div style={{
            fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-meta)', lineHeight: '19.6px',
            color: 'var(--text-muted)', marginBottom: 'var(--space-10)'
          }}>{date}</div>
        ) : null}
        <h3 style={{
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-title-sm)', fontWeight: 'var(--fw-bold)',
          lineHeight: '21.6px', margin: 0, marginBottom: 'var(--space-10)',
          color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
          transition: 'var(--transition)'
        }}><a href={href} style={{ color: 'inherit' }}>{title}</a></h3>

        {metrics.length ? (
          <ul style={{ display: 'flex', gap: 'var(--space-15)' }}>
            {metrics.map((m, i) => (
              <li key={i} style={{
                fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-meta)', color: 'var(--text-muted)'
              }}>
                {m.icon ? <i className={m.icon} style={{ marginRight: '5px' }} /> : null}{m.label}
              </li>
            ))}
          </ul>
        ) : null}
      </div>
    </div>
  );
}
```


---

## EventCard

```jsx
<EventCard day="22" month="April 2018"
  title="Fully Responsive Web Design & Development."
  category="Web Design" author="Koke" />
```

The date tile needs the gradient layer behind it — keep the component's own `z-index: -1` span rather than painting the tile itself.

### Props contract

```ts
/**
 * An "Upcoming Events." row (`.latest-event-item`). Its date tile is the system's most
 * distinctive small detail: a 95×84 white block with a 10px radius sitting on top of a
 * 69° gradient layer, so the gradient reads as a coloured edge around white — the source
 * calls that layer `.gradient-bdr`.
 */
export interface EventCardProps {
  /** Day numeral, e.g. "22". */
  day: React.ReactNode;
  /** Month and year, e.g. "April 2018". */
  month: React.ReactNode;
  title: string;
  category: string;
  author: string;
  href?: string;
  /** Forwarded to the card root; sets a pointer cursor when present. */
  onClick?: (e: React.MouseEvent) => void;
  style?: React.CSSProperties;
}
export function EventCard(props: EventCardProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';
import { MetaLine } from '../core/MetaLine.jsx';

export function EventCard({ day, month, title, category, author, href = '#', onClick, style, ...rest }) {
  const [hover, setHover] = React.useState(false);
  return (
    <div {...rest} onClick={onClick}
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{ cursor: onClick ? 'pointer' : undefined, display: 'inline-block', width: '100%', maxWidth: '340px', marginBottom: 'var(--space-30)', ...style }}>
      <div style={{
        position: 'relative',
        float: 'left',
        width: 'var(--w-event-date)',
        height: 'var(--h-event-date)',
        marginRight: 'var(--space-20)',
        borderRadius: 'var(--radius-lg)',
        background: 'var(--genius-white)',
        textAlign: 'center'
      }}>
        <span style={{
          position: 'absolute', inset: 0, zIndex: -1,
          borderRadius: 'var(--radius-lg)',
          backgroundImage: 'var(--gradient-border)'
        }} />
        <div style={{
          paddingTop: 'var(--space-8)',
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-event-date)', fontWeight: 'var(--fw-bold)',
          lineHeight: '50px', color: 'var(--text-heading)'
        }}>{day}</div>
        <div style={{
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-sm)', fontWeight: 'var(--fw-medium)',
          lineHeight: '18.2px', color: 'var(--text-muted)'
        }}>{month}</div>
      </div>

      <div style={{ overflow: 'hidden' }}>
        <h3 style={{
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-title-sm)', fontWeight: 'var(--fw-bold)',
          lineHeight: '21.6px', margin: 0, marginBottom: 'var(--space-10)',
          color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
          transition: 'var(--transition)'
        }}><a href={href} style={{ color: 'inherit' }}>{title}</a></h3>
        <MetaLine items={[{ label: category, accent: true }, { label: author }]} />
      </div>
    </div>
  );
}
```


---

## ProductCard

```jsx
<ProductCard image="/assets/img/product/bp-1.png" title="Mobile Apps Books." price="Start from $55.25" />
```

Packshots are transparent PNGs on the tinted ground — do not put them in a white box.

### Props contract

```ts
/**
 * A shop item (`.product-img-text`): a #f1f1f3 panel with a centred packshot, an 18px
 * title, a 12px bold "Start from $…" line, and a 40px circular add-to-cart button that
 * fills with the gradient on hover. The only card in the system with a tinted ground.
 */
export interface ProductCardProps {
  image: string;
  title: string;
  /** Full display string, e.g. "Start from $55.25". */
  price: string;
  href?: string;
  /** Forwarded to the card root; sets a pointer cursor when present. */
  onClick?: (e: React.MouseEvent) => void;
  style?: React.CSSProperties;
}
export function ProductCard(props: ProductCardProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function ProductCard({ image, title, price, href = '#', onClick, style, ...rest }) {
  const [hover, setHover] = React.useState(false);
  const [cartHover, setCartHover] = React.useState(false);
  return (
    <div {...rest} onClick={onClick}
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{
        cursor: onClick ? 'pointer' : undefined,
        display: 'inline-block', width: '100%',
        margin: '5px 0',
        padding: 'var(--pad-product)',
        borderRadius: 'var(--radius)',
        background: 'var(--surface-product)',
        transition: 'var(--transition)',
        ...style
      }}>
      <div style={{ textAlign: 'center', marginBottom: 'var(--space-20)' }}>
        <a href={href}>
          <img src={image} alt="" style={{
            display: 'inline-block',
            transform: hover ? 'scale(1.05)' : 'none',
            transition: 'var(--transition)'
          }} />
        </a>
      </div>

      <div style={{ position: 'relative', overflow: 'hidden' }}>
        <div style={{ float: 'left' }}>
          <h3 style={{
            fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-title-sm)', fontWeight: 'var(--fw-medium)',
            lineHeight: 'var(--lh-card-title)', margin: 0,
            color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
            transition: 'var(--transition)'
          }}><a href={href} style={{ color: 'inherit' }}>{title}</a></h3>
          <div style={{
            marginTop: '5px',
            fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-xs)', fontWeight: 'var(--fw-bold)',
            lineHeight: '16.8px', color: 'var(--text-body)'
          }}>{price}</div>
        </div>

        <button aria-label={'Add ' + title + ' to cart'}
          onMouseEnter={() => setCartHover(true)} onMouseLeave={() => setCartHover(false)}
          style={{
            position: 'relative',
            float: 'right',
            width: 'var(--h-circle)', height: 'var(--h-circle)',
            marginTop: 'var(--space-10)',
            border: 0,
            borderRadius: 'var(--radius-circle)',
            background: cartHover ? 'transparent' : 'var(--genius-white)',
            backgroundImage: cartHover ? 'var(--gradient)' : 'none',
            color: cartHover ? 'var(--genius-white)' : '#bbbbbb',
            lineHeight: 'var(--lh-circle)',
            textAlign: 'center',
            cursor: 'pointer',
            overflow: 'hidden',
            transition: 'var(--transition)'
          }}>
          <i className="fas fa-cart-plus" />
        </button>
      </div>
    </div>
  );
}
```


---

## TeacherCard

```jsx
<TeacherCard
  image="/assets/img/teacher/tb-1.png"
  name="Daniel Alvares" designation="Mobile Apps"
  socials={[
    { icon: 'fab fa-facebook-f', label: 'Facebook' },
    { icon: 'fab fa-twitter', label: 'Twitter' },
    { icon: 'fab fa-google-plus-g', label: 'Google Plus' }
  ]}
/>
```

Three socials is what the source shows on every card.

### Props contract

```ts
/**
 * A staff card (`.teacher-img-text`). The portrait sits inside a full-circle gradient
 * ring that extends 5px beyond it on every side, and the social icons fade in centred
 * over the photo on hover. Name is 18px/700 ink; the designation is 13px teal.
 */
export interface TeacherSocial { icon: string; href?: string; label?: string }
export interface TeacherCardProps {
  /** Portrait — the source uses transparent PNGs cut to a circle. */
  image: string;
  name: string;
  /** e.g. "Mobile Apps". */
  designation: string;
  socials?: TeacherSocial[];
  /** Forwarded to the card root; sets a pointer cursor when present. */
  onClick?: (e: React.MouseEvent) => void;
  style?: React.CSSProperties;
}
export function TeacherCard(props: TeacherCardProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function TeacherCard({ image, name, designation, socials = [], onClick, style, ...rest }) {
  const [hover, setHover] = React.useState(false);
  return (
    <div {...rest} onClick={onClick}
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{
        cursor: onClick ? 'pointer' : undefined,
        position: 'relative',
        background: 'var(--surface-card)',
        borderRadius: 'var(--radius)',
        padding: 'var(--pad-teacher)',
        textAlign: 'center',
        ...style
      }}>
      <div style={{ position: 'relative', textAlign: 'center', zIndex: 1 }}>
        <span style={{
          position: 'absolute', top: '-5px', left: '-5px', right: '-5px',
          margin: '0 auto',
          width: 'calc(100% + 10px)',
          paddingBottom: 'calc(100% + 10px)',
          borderRadius: 'var(--radius-circle)',
          backgroundImage: 'var(--gradient)',
          zIndex: -1
        }} />
        <img src={image} alt="" style={{
          display: 'block', width: '100%',
          borderRadius: 'var(--radius-circle)'
        }} />

        <div style={{
          position: 'absolute', left: 0, right: 0,
          top: '50%', transform: 'translateY(-50%)',
          height: 'var(--h-chip)',
          textAlign: 'center',
          opacity: hover ? 1 : 0,
          transition: 'var(--transition)'
        }}>
          <ul style={{ display: 'inline-flex', gap: 'var(--space-15)' }}>
            {socials.map((s, i) => (
              <li key={i}>
                <a href={s.href || '#'} aria-label={s.label}
                  style={{ color: 'var(--genius-white)', lineHeight: 'var(--lh-chip)', fontSize: 'var(--fs-base)' }}>
                  <i className={s.icon} />
                </a>
              </li>
            ))}
          </ul>
        </div>
      </div>

      <div style={{ marginTop: 'var(--space-15)', textAlign: 'center' }}>
        <h3 style={{
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-title-sm)', fontWeight: 'var(--fw-bold)',
          lineHeight: '25.2px', margin: 0, color: 'var(--text-heading)'
        }}>{name}</h3>
        <span style={{
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-sm)', lineHeight: '18.2px',
          color: 'var(--color-primary)'
        }}>{designation}</span>
      </div>
    </div>
  );
}
```


---

## TestimonialSlide

```jsx
<TestimonialSlide
  quote="“This was our first time lorem ipsum and we "
  emphasis="were very pleased with the whole experience"
  tail=". Your price was lower than other companies.”"
  name="Robertho Garcia" designation="Graphic Designer"
/>
```

Keep the curly quotation marks in the copy — the source does.

### Props contract

```ts
/**
 * A student quote (`.student-qoute`): 25px/300 italic ink centred on the page ground —
 * no card, no avatar — with a bolded phrase inside the sentence, a name/designation
 * line separated by a 1px rule, and a 40px navy quote glyph in the lower right.
 *
 * The bolded phrase is not decoration: every testimonial in the source emphasises its
 * middle clause, so the component takes the quote in three parts.
 */
export interface TestimonialSlideProps {
  /** Text before the emphasis. */
  quote?: React.ReactNode;
  /** The bolded clause. */
  emphasis?: React.ReactNode;
  /** Text after the emphasis. */
  tail?: React.ReactNode;
  name: string;
  designation: string;
  style?: React.CSSProperties;
}
export function TestimonialSlide(props: TestimonialSlideProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function TestimonialSlide({ quote, emphasis, tail, name, designation, style }) {
  return (
    <div style={{
      position: 'relative',
      maxWidth: 'var(--measure-testimonial)',
      margin: '0 auto',
      borderRadius: 'var(--radius-md)',
      textAlign: 'center',
      ...style
    }}>
      <p style={{
        fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-quote)', fontWeight: 'var(--fw-light)',
        fontStyle: 'italic', lineHeight: 'var(--lh-quote)', color: 'var(--text-heading)',
        margin: 0, marginBottom: 'var(--space-30)'
      }}>
        {quote}
        {emphasis ? <strong style={{ fontWeight: 'var(--fw-bold)' }}>{emphasis}</strong> : null}
        {tail}
      </p>

      <div style={{ textAlign: 'center' }}>
        <span style={{
          position: 'relative',
          display: 'inline-block',
          marginRight: '28px',
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-sm)', fontWeight: 'var(--fw-bold)',
          lineHeight: '18.2px', color: 'var(--text-heading)'
        }}>
          {name}
          <span style={{
            position: 'absolute', right: '-14px', top: '4px',
            width: '1px', height: '10px', background: 'var(--text-muted)'
          }} />
        </span>
        <span style={{
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-sm)', fontWeight: 'var(--fw-light)',
          lineHeight: '18.2px', color: 'var(--text-muted)'
        }}>{designation}</span>
      </div>

      <i className="fas fa-quote-right" style={{
        position: 'absolute', right: '35px', bottom: '-30px',
        fontSize: '40px', color: 'var(--genius-quote)', opacity: .5
      }} />
    </div>
  );
}
```


---

## CategoryTile

```jsx
<CategoryTile icon="flaticon-technology" title="Responsive Website" />
<CategoryTile icon="flaticon-app-store" title="IOS Applications" />
```

Needs the template's Flaticon stylesheet loaded. See the readme's ICONOGRAPHY section for the glyph list.

### Props contract

```ts
/**
 * A subject tile (`.category-item`): a 60px Flaticon glyph with the brand gradient
 * clipped to the glyph shape via `background-clip: text`, over an 18px/500 label.
 * This gradient-filled glyph is the only place in the system where the gradient
 * becomes type.
 */
export interface CategoryTileProps {
  /** Flaticon class, e.g. "flaticon-technology". Font Awesome also works. */
  icon: string;
  title: string;
  href?: string;
  /** Forwarded to the card root; sets a pointer cursor when present. */
  onClick?: (e: React.MouseEvent) => void;
  style?: React.CSSProperties;
}
export function CategoryTile(props: CategoryTileProps): JSX.Element;
```

### Reference implementation

```jsx
import React from 'react';

export function CategoryTile({ icon, title, href = '#', onClick, style, ...rest }) {
  const [hover, setHover] = React.useState(false);
  return (
    <a {...rest} href={href} onClick={onClick}
      onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}
      style={{
        display: 'block', textAlign: 'center', textDecoration: 'none',
        padding: 'var(--space-20) var(--space-10)',
        transition: 'var(--transition)',
        ...style
      }}>
      <div style={{ position: 'relative', textAlign: 'center', zIndex: 1, height: '84px' }}>
        <i className={icon} style={{
          fontSize: '60px',
          lineHeight: '84px',
          fontStyle: 'normal',
          backgroundImage: 'var(--gradient-text)',
          WebkitBackgroundClip: 'text',
          backgroundClip: 'text',
          WebkitTextFillColor: 'transparent',
          color: 'var(--color-primary)'
        }} />
      </div>
      <div style={{ marginTop: 'var(--space-10)', textAlign: 'center' }}>
        <h4 style={{
          fontFamily: 'var(--font-sans)', fontSize: 'var(--fs-title-sm)', fontWeight: 'var(--fw-medium)',
          lineHeight: '21.6px', margin: 0,
          color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
          transition: 'var(--transition)'
        }}>{title}</h4>
      </div>
    </a>
  );
}
```
