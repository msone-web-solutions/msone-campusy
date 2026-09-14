/* @ds-bundle: {"format":4,"namespace":"RaqueDesignSystem_94a18b","components":[{"name":"BestCourseCard","sourcePath":"components/cards/BestCourseCard.jsx"},{"name":"CategoryTile","sourcePath":"components/cards/CategoryTile.jsx"},{"name":"CourseCard","sourcePath":"components/cards/CourseCard.jsx"},{"name":"EventCard","sourcePath":"components/cards/EventCard.jsx"},{"name":"NewsCard","sourcePath":"components/cards/NewsCard.jsx"},{"name":"ProductCard","sourcePath":"components/cards/ProductCard.jsx"},{"name":"TeacherCard","sourcePath":"components/cards/TeacherCard.jsx"},{"name":"TestimonialSlide","sourcePath":"components/cards/TestimonialSlide.jsx"},{"name":"Badge","sourcePath":"components/core/Badge.jsx"},{"name":"BulletList","sourcePath":"components/core/BulletList.jsx"},{"name":"Button","sourcePath":"components/core/Button.jsx"},{"name":"HeroTitle","sourcePath":"components/core/HeroTitle.jsx"},{"name":"Input","sourcePath":"components/core/Input.jsx"},{"name":"MetaLine","sourcePath":"components/core/MetaLine.jsx"},{"name":"Rating","sourcePath":"components/core/Rating.jsx"},{"name":"Em","sourcePath":"components/core/SectionTitle.jsx"},{"name":"SectionTitle","sourcePath":"components/core/SectionTitle.jsx"},{"name":"SubmitButton","sourcePath":"components/core/SubmitButton.jsx"},{"name":"Accordion","sourcePath":"components/layout/Accordion.jsx"},{"name":"ContactAddress","sourcePath":"components/layout/ContactAddress.jsx"},{"name":"CounterStrip","sourcePath":"components/layout/CounterStrip.jsx"},{"name":"HeroSlide","sourcePath":"components/layout/HeroSlide.jsx"},{"name":"SearchBar","sourcePath":"components/layout/SearchBar.jsx"},{"name":"Section","sourcePath":"components/layout/Section.jsx"},{"name":"Grid","sourcePath":"components/layout/Section.jsx"},{"name":"SiteFooter","sourcePath":"components/layout/SiteFooter.jsx"},{"name":"SiteHeader","sourcePath":"components/layout/SiteHeader.jsx"},{"name":"Tabs","sourcePath":"components/layout/Tabs.jsx"}],"sourceHashes":{"components/cards/BestCourseCard.jsx":"a168899710f4","components/cards/CategoryTile.jsx":"7c3a4c2338cb","components/cards/CourseCard.jsx":"8f23eaee77b4","components/cards/EventCard.jsx":"1d00e6f9662f","components/cards/NewsCard.jsx":"67931676eb41","components/cards/ProductCard.jsx":"77eda69cdb93","components/cards/TeacherCard.jsx":"27497b88cb42","components/cards/TestimonialSlide.jsx":"be2884ba76d7","components/core/Badge.jsx":"6e5ee76f5660","components/core/BulletList.jsx":"006f32769a7f","components/core/Button.jsx":"f370e91262b6","components/core/HeroTitle.jsx":"590a0fcd1b2b","components/core/Input.jsx":"d59c0893a059","components/core/MetaLine.jsx":"d054d85a688f","components/core/Rating.jsx":"c1d100f93b9b","components/core/SectionTitle.jsx":"2f3f871d2114","components/core/SubmitButton.jsx":"491b1ae23f06","components/layout/Accordion.jsx":"61123110906d","components/layout/ContactAddress.jsx":"8ab704cd3ad5","components/layout/CounterStrip.jsx":"ee6d1e96c643","components/layout/HeroSlide.jsx":"92e1d4d99a60","components/layout/SearchBar.jsx":"fd792af69f58","components/layout/Section.jsx":"93daec51c704","components/layout/SiteFooter.jsx":"4c06db26c365","components/layout/SiteHeader.jsx":"98849543a8cc","components/layout/Tabs.jsx":"353807f6e98a","ui_kits/website/data.js":"11e877d79299","ui_kits/website/home.jsx":"e97b38b3795f","ui_kits/website/login.jsx":"720e7181f61d","ui_kits/website/pages.jsx":"583ef1bebb9d","ui_kits/website/shell.jsx":"2600483c7df0"},"inlinedExternals":[],"unexposedExports":[]} */

(() => {

const __ds_ns = (window.RaqueDesignSystem_94a18b = window.RaqueDesignSystem_94a18b || {});

const __ds_scope = {};

(__ds_ns.__errors = __ds_ns.__errors || []);

// components/cards/CategoryTile.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
function CategoryTile({
  icon,
  title,
  href = '#',
  onClick,
  style,
  ...rest
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("a", _extends({}, rest, {
    href: href,
    onClick: onClick,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      display: 'block',
      textAlign: 'center',
      textDecoration: 'none',
      padding: 'var(--space-20) var(--space-10)',
      transition: 'var(--transition)',
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      textAlign: 'center',
      zIndex: 1,
      height: '84px'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: icon,
    style: {
      fontSize: '60px',
      lineHeight: '84px',
      fontStyle: 'normal',
      backgroundImage: 'var(--gradient-text)',
      WebkitBackgroundClip: 'text',
      backgroundClip: 'text',
      WebkitTextFillColor: 'transparent',
      color: 'var(--color-primary)'
    }
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 'var(--space-10)',
      textAlign: 'center'
    }
  }, /*#__PURE__*/React.createElement("h4", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-title-sm)',
      fontWeight: 'var(--fw-medium)',
      lineHeight: '21.6px',
      margin: 0,
      color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
      transition: 'var(--transition)'
    }
  }, title)));
}
Object.assign(__ds_scope, { CategoryTile });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/cards/CategoryTile.jsx", error: String((e && e.message) || e) }); }

// components/cards/NewsCard.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
function NewsCard({
  image,
  date,
  title,
  href = '#',
  metrics = [],
  last = false,
  onClick,
  style,
  ...rest
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    onClick: onClick,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      cursor: onClick ? 'pointer' : undefined,
      display: 'inline-block',
      width: '100%',
      maxWidth: '335px',
      paddingBottom: 'var(--space-30)',
      marginBottom: 'var(--space-30)',
      borderBottom: last ? 0 : 'var(--border-width) solid var(--border-default)',
      ...style
    }
  }), image ? /*#__PURE__*/React.createElement("div", {
    style: {
      float: 'left',
      width: 'var(--w-news-thumb)',
      height: 'var(--w-news-thumb)',
      marginRight: 'var(--space-20)',
      overflow: 'hidden',
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: href
  }, /*#__PURE__*/React.createElement("img", {
    src: image,
    alt: "",
    style: {
      width: '100%',
      height: '100%',
      objectFit: 'cover',
      display: 'block',
      transform: hover ? 'scale(1.08)' : 'none',
      transition: 'var(--transition)'
    }
  }))) : null, /*#__PURE__*/React.createElement("div", {
    style: {
      overflow: 'hidden'
    }
  }, date ? /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-meta)',
      lineHeight: '19.6px',
      color: 'var(--text-muted)',
      marginBottom: 'var(--space-10)'
    }
  }, date) : null, /*#__PURE__*/React.createElement("h3", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-title-sm)',
      fontWeight: 'var(--fw-bold)',
      lineHeight: '21.6px',
      margin: 0,
      marginBottom: 'var(--space-10)',
      color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: href,
    style: {
      color: 'inherit'
    }
  }, title)), metrics.length ? /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'flex',
      gap: 'var(--space-15)'
    }
  }, metrics.map((m, i) => /*#__PURE__*/React.createElement("li", {
    key: i,
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-meta)',
      color: 'var(--text-muted)'
    }
  }, m.icon ? /*#__PURE__*/React.createElement("i", {
    className: m.icon,
    style: {
      marginRight: '5px'
    }
  }) : null, m.label))) : null));
}
Object.assign(__ds_scope, { NewsCard });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/cards/NewsCard.jsx", error: String((e && e.message) || e) }); }

// components/cards/ProductCard.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
function ProductCard({
  image,
  title,
  price,
  href = '#',
  onClick,
  style,
  ...rest
}) {
  const [hover, setHover] = React.useState(false);
  const [cartHover, setCartHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    onClick: onClick,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      cursor: onClick ? 'pointer' : undefined,
      display: 'inline-block',
      width: '100%',
      margin: '5px 0',
      padding: 'var(--pad-product)',
      borderRadius: 'var(--radius)',
      background: 'var(--surface-product)',
      transition: 'var(--transition)',
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: 'center',
      marginBottom: 'var(--space-20)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: href
  }, /*#__PURE__*/React.createElement("img", {
    src: image,
    alt: "",
    style: {
      display: 'inline-block',
      transform: hover ? 'scale(1.05)' : 'none',
      transition: 'var(--transition)'
    }
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      float: 'left'
    }
  }, /*#__PURE__*/React.createElement("h3", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-title-sm)',
      fontWeight: 'var(--fw-medium)',
      lineHeight: 'var(--lh-card-title)',
      margin: 0,
      color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: href,
    style: {
      color: 'inherit'
    }
  }, title)), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: '5px',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-xs)',
      fontWeight: 'var(--fw-bold)',
      lineHeight: '16.8px',
      color: 'var(--text-body)'
    }
  }, price)), /*#__PURE__*/React.createElement("button", {
    "aria-label": 'Add ' + title + ' to cart',
    onMouseEnter: () => setCartHover(true),
    onMouseLeave: () => setCartHover(false),
    style: {
      position: 'relative',
      float: 'right',
      width: 'var(--h-circle)',
      height: 'var(--h-circle)',
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
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: "fas fa-cart-plus"
  }))));
}
Object.assign(__ds_scope, { ProductCard });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/cards/ProductCard.jsx", error: String((e && e.message) || e) }); }

// components/cards/TeacherCard.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
function TeacherCard({
  image,
  name,
  designation,
  socials = [],
  onClick,
  style,
  ...rest
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    onClick: onClick,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      cursor: onClick ? 'pointer' : undefined,
      position: 'relative',
      background: 'var(--surface-card)',
      borderRadius: 'var(--radius)',
      padding: 'var(--pad-teacher)',
      textAlign: 'center',
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      textAlign: 'center',
      zIndex: 1
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      top: '-5px',
      left: '-5px',
      right: '-5px',
      margin: '0 auto',
      width: 'calc(100% + 10px)',
      paddingBottom: 'calc(100% + 10px)',
      borderRadius: 'var(--radius-circle)',
      backgroundImage: 'var(--gradient)',
      zIndex: -1
    }
  }), /*#__PURE__*/React.createElement("img", {
    src: image,
    alt: "",
    style: {
      display: 'block',
      width: '100%',
      borderRadius: 'var(--radius-circle)'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      left: 0,
      right: 0,
      top: '50%',
      transform: 'translateY(-50%)',
      height: 'var(--h-chip)',
      textAlign: 'center',
      opacity: hover ? 1 : 0,
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'inline-flex',
      gap: 'var(--space-15)'
    }
  }, socials.map((s, i) => /*#__PURE__*/React.createElement("li", {
    key: i
  }, /*#__PURE__*/React.createElement("a", {
    href: s.href || '#',
    "aria-label": s.label,
    style: {
      color: 'var(--genius-white)',
      lineHeight: 'var(--lh-chip)',
      fontSize: 'var(--fs-base)'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: s.icon
  }))))))), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 'var(--space-15)',
      textAlign: 'center'
    }
  }, /*#__PURE__*/React.createElement("h3", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-title-sm)',
      fontWeight: 'var(--fw-bold)',
      lineHeight: '25.2px',
      margin: 0,
      color: 'var(--text-heading)'
    }
  }, name), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-sm)',
      lineHeight: '18.2px',
      color: 'var(--color-primary)'
    }
  }, designation)));
}
Object.assign(__ds_scope, { TeacherCard });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/cards/TeacherCard.jsx", error: String((e && e.message) || e) }); }

// components/cards/TestimonialSlide.jsx
try { (() => {
function TestimonialSlide({
  quote,
  emphasis,
  tail,
  name,
  designation,
  style
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      maxWidth: 'var(--measure-testimonial)',
      margin: '0 auto',
      borderRadius: 'var(--radius-md)',
      textAlign: 'center',
      ...style
    }
  }, /*#__PURE__*/React.createElement("p", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-quote)',
      fontWeight: 'var(--fw-light)',
      fontStyle: 'italic',
      lineHeight: 'var(--lh-quote)',
      color: 'var(--text-heading)',
      margin: 0,
      marginBottom: 'var(--space-30)'
    }
  }, quote, emphasis ? /*#__PURE__*/React.createElement("strong", {
    style: {
      fontWeight: 'var(--fw-bold)'
    }
  }, emphasis) : null, tail), /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: 'center'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'relative',
      display: 'inline-block',
      marginRight: '28px',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-sm)',
      fontWeight: 'var(--fw-bold)',
      lineHeight: '18.2px',
      color: 'var(--text-heading)'
    }
  }, name, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      right: '-14px',
      top: '4px',
      width: '1px',
      height: '10px',
      background: 'var(--text-muted)'
    }
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-sm)',
      fontWeight: 'var(--fw-light)',
      lineHeight: '18.2px',
      color: 'var(--text-muted)'
    }
  }, designation)), /*#__PURE__*/React.createElement("i", {
    className: "fas fa-quote-right",
    style: {
      position: 'absolute',
      right: '35px',
      bottom: '-30px',
      fontSize: '40px',
      color: 'var(--genius-quote)',
      opacity: .5
    }
  }));
}
Object.assign(__ds_scope, { TestimonialSlide });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/cards/TestimonialSlide.jsx", error: String((e && e.message) || e) }); }

// components/core/Badge.jsx
try { (() => {
function Badge({
  children,
  tone = 'trend',
  icon = 'fas fa-bolt',
  style
}) {
  if (tone === 'ribbon') {
    return /*#__PURE__*/React.createElement("div", {
      style: {
        position: 'absolute',
        top: '-18px',
        left: '-50px',
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
      }
    }, icon ? /*#__PURE__*/React.createElement("i", {
      className: icon,
      style: {
        marginRight: '4px'
      }
    }) : null, /*#__PURE__*/React.createElement("span", null, children));
  }
  if (tone === 'price') {
    return /*#__PURE__*/React.createElement("div", {
      style: {
        position: 'absolute',
        top: '20px',
        left: '20px',
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
      }
    }, /*#__PURE__*/React.createElement("span", null, children));
  }
  if (tone === 'chip') {
    return /*#__PURE__*/React.createElement("span", {
      style: {
        display: 'inline-block',
        padding: 'var(--pad-chip)',
        borderRadius: 'var(--radius-chip)',
        background: 'var(--surface-chip)',
        color: 'var(--text-muted)',
        fontFamily: 'var(--font-sans)',
        fontSize: 'var(--fs-meta)',
        lineHeight: '19.6px',
        ...style
      }
    }, children);
  }
  return /*#__PURE__*/React.createElement("span", {
    style: {
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
    }
  }, icon ? /*#__PURE__*/React.createElement("i", {
    className: icon,
    style: {
      marginRight: '3px',
      fontSize: 'var(--fs-xxs)'
    }
  }) : null, children);
}
Object.assign(__ds_scope, { Badge });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Badge.jsx", error: String((e && e.message) || e) }); }

// components/core/BulletList.jsx
try { (() => {
function BulletList({
  items = [],
  tone = 'ink',
  style
}) {
  return /*#__PURE__*/React.createElement("ul", {
    style: {
      marginBottom: 'var(--space-65)',
      ...style
    }
  }, items.map((it, i) => /*#__PURE__*/React.createElement("li", {
    key: i,
    style: {
      position: 'relative',
      paddingLeft: '25px',
      marginBottom: 'var(--space-8)',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-base)',
      fontWeight: 'var(--fw-medium)',
      lineHeight: 'var(--lh-base)',
      color: tone === 'light' ? 'var(--genius-white)' : 'var(--text-heading)'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      left: 0,
      top: '2px',
      width: '15px',
      height: '15px',
      borderRadius: 'var(--radius-circle)',
      background: 'var(--color-primary)'
    }
  }), it)));
}
Object.assign(__ds_scope, { BulletList });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/BulletList.jsx", error: String((e && e.message) || e) }); }

// components/core/Button.jsx
try { (() => {
function Button({
  as = 'a',
  variant = 'gradient',
  icon = 'fas fa-caret-right',
  children,
  style,
  ...rest
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
  return React.createElement(Tag, {
    ...rest,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      ...shell,
      ...skins[variant],
      ...style
    }
  }, children, icon ? React.createElement('i', {
    className: icon,
    style: {
      marginLeft: '7px',
      fontSize: 'var(--fs-base)'
    }
  }) : null);
}
Object.assign(__ds_scope, { Button });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Button.jsx", error: String((e && e.message) || e) }); }

// components/core/Input.jsx
try { (() => {
function Input({
  as = 'input',
  size = 'md',
  ground = 'field',
  rows = 4,
  style,
  ...rest
}) {
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
      height: isArea ? 'var(--h-textarea)' : size === 'lg' ? 'var(--h-control)' : 'var(--h-field)',
      padding: isArea ? '15px' : size === 'lg' ? '0 20px' : 'var(--pad-field)',
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
Object.assign(__ds_scope, { Input });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Input.jsx", error: String((e && e.message) || e) }); }

// components/core/MetaLine.jsx
try { (() => {
function MetaLine({
  items = [],
  bold = true,
  style
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'inline-block',
      width: '100%',
      ...style
    }
  }, items.map((it, i) => /*#__PURE__*/React.createElement("span", {
    key: i,
    style: {
      position: 'relative',
      float: 'left',
      marginRight: i < items.length - 1 ? '28px' : 0,
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-meta)',
      fontWeight: bold ? 'var(--fw-bold)' : 'var(--fw-regular)',
      lineHeight: '19.6px',
      color: it.accent ? 'var(--text-category)' : 'var(--text-heading)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: it.href || '#',
    style: {
      color: 'inherit'
    }
  }, it.label), i < items.length - 1 ? /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      right: '-14px',
      top: '2px',
      width: '1px',
      height: '15px',
      background: 'var(--text-muted)'
    }
  }) : null)));
}
Object.assign(__ds_scope, { MetaLine });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/MetaLine.jsx", error: String((e && e.message) || e) }); }

// components/cards/EventCard.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
function EventCard({
  day,
  month,
  title,
  category,
  author,
  href = '#',
  onClick,
  style,
  ...rest
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    onClick: onClick,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      cursor: onClick ? 'pointer' : undefined,
      display: 'inline-block',
      width: '100%',
      maxWidth: '340px',
      marginBottom: 'var(--space-30)',
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      float: 'left',
      width: 'var(--w-event-date)',
      height: 'var(--h-event-date)',
      marginRight: 'var(--space-20)',
      borderRadius: 'var(--radius-lg)',
      background: 'var(--genius-white)',
      textAlign: 'center'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      inset: 0,
      zIndex: -1,
      borderRadius: 'var(--radius-lg)',
      backgroundImage: 'var(--gradient-border)'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      paddingTop: 'var(--space-8)',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-event-date)',
      fontWeight: 'var(--fw-bold)',
      lineHeight: '50px',
      color: 'var(--text-heading)'
    }
  }, day), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-sm)',
      fontWeight: 'var(--fw-medium)',
      lineHeight: '18.2px',
      color: 'var(--text-muted)'
    }
  }, month)), /*#__PURE__*/React.createElement("div", {
    style: {
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("h3", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-title-sm)',
      fontWeight: 'var(--fw-bold)',
      lineHeight: '21.6px',
      margin: 0,
      marginBottom: 'var(--space-10)',
      color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: href,
    style: {
      color: 'inherit'
    }
  }, title)), /*#__PURE__*/React.createElement(__ds_scope.MetaLine, {
    items: [{
      label: category,
      accent: true
    }, {
      label: author
    }]
  })));
}
Object.assign(__ds_scope, { EventCard });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/cards/EventCard.jsx", error: String((e && e.message) || e) }); }

// components/core/Rating.jsx
try { (() => {
function Rating({
  value = 5,
  max = 5,
  size = 16,
  style
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'inline-block',
      lineHeight: 1,
      ...style
    }
  }, /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'inline-flex',
      gap: '1px'
    }
  }, Array.from({
    length: max
  }).map((_, i) => /*#__PURE__*/React.createElement("li", {
    key: i,
    style: {
      display: 'inline-block',
      color: 'var(--color-rating)'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: i < Math.round(value) ? 'fas fa-star' : 'far fa-star',
    style: {
      fontSize: size + 'px',
      color: 'var(--color-rating)'
    }
  })))));
}
Object.assign(__ds_scope, { Rating });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/Rating.jsx", error: String((e && e.message) || e) }); }

// components/cards/BestCourseCard.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
function BestCourseCard({
  image,
  price,
  title,
  category,
  students,
  href = '#',
  rating = 5,
  trending = false,
  onClick,
  style,
  ...rest
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    onClick: onClick,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      position: 'relative',
      paddingTop: 'var(--space-30)',
      borderRadius: 'var(--radius)',
      cursor: onClick ? 'pointer' : undefined,
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      borderRadius: 'var(--radius)',
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("img", {
    src: image,
    alt: "",
    style: {
      display: 'block',
      width: '100%'
    }
  }), trending ? /*#__PURE__*/React.createElement(__ds_scope.Badge, {
    tone: "ribbon"
  }, "Trending") : null, price ? /*#__PURE__*/React.createElement(__ds_scope.Badge, {
    tone: "price",
    icon: null
  }, price) : null, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      inset: 0,
      background: 'var(--genius-scrim)',
      borderRadius: 'var(--radius)',
      opacity: hover ? 1 : 0,
      transition: 'var(--transition)'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      left: 0,
      right: 0,
      bottom: '55px',
      textAlign: 'center',
      zIndex: 2,
      opacity: hover ? 1 : 0,
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Rating, {
    value: rating
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      left: 0,
      right: 0,
      bottom: '25px',
      textAlign: 'center',
      zIndex: 2,
      opacity: hover ? 1 : 0,
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: href,
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-xs)',
      fontWeight: 'var(--fw-bold)',
      color: 'var(--genius-white)',
      textTransform: 'uppercase',
      textDecoration: 'none'
    }
  }, "COURSE DETAIL ", /*#__PURE__*/React.createElement("i", {
    className: "fas fa-arrow-right"
  })))), /*#__PURE__*/React.createElement("div", {
    style: {
      background: 'var(--surface-card)',
      borderRadius: 'var(--radius)',
      padding: 'var(--pad-card-text)',
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("h3", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-card-title)',
      fontWeight: 'var(--fw-medium)',
      lineHeight: 'var(--lh-card-title)',
      margin: 0,
      marginBottom: 'var(--space-20)',
      color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: href,
    style: {
      color: 'inherit'
    }
  }, title)), /*#__PURE__*/React.createElement(__ds_scope.MetaLine, {
    bold: false,
    items: [{
      label: category,
      accent: true
    }, {
      label: students
    }]
  })));
}
Object.assign(__ds_scope, { BestCourseCard });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/cards/BestCourseCard.jsx", error: String((e && e.message) || e) }); }

// components/cards/CourseCard.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
function CourseCard({
  image,
  price,
  category,
  author,
  title,
  href = '#',
  rating = 5,
  trending = false,
  metrics = [],
  onClick,
  style,
  ...rest
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", _extends({}, rest, {
    onClick: onClick,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      cursor: onClick ? 'pointer' : undefined,
      ...style
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      marginBottom: 'var(--space-25)',
      borderRadius: 'var(--radius)',
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("img", {
    src: image,
    alt: "",
    style: {
      display: 'block',
      width: '100%',
      transform: hover ? 'scale(1.06)' : 'none',
      transition: 'var(--transition)'
    }
  }), price ? /*#__PURE__*/React.createElement(__ds_scope.Badge, {
    tone: "price",
    icon: null
  }, price) : null, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      top: '25px',
      right: '5px',
      opacity: hover ? 1 : 0,
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: href,
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-xs)',
      fontWeight: 'var(--fw-bold)',
      color: 'var(--genius-white)',
      textTransform: 'uppercase',
      textDecoration: 'none'
    }
  }, "COURSE DETAIL ", /*#__PURE__*/React.createElement("i", {
    className: "fas fa-arrow-right"
  })))), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(__ds_scope.MetaLine, {
    items: [{
      label: category,
      accent: true
    }, {
      label: author
    }]
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: '2px'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Rating, {
    value: rating
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      marginTop: 'var(--space-10)',
      paddingBottom: 'var(--space-30)'
    }
  }, /*#__PURE__*/React.createElement("h3", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-card-title)',
      fontWeight: 'var(--fw-medium)',
      lineHeight: 'var(--lh-card-title)',
      margin: 0,
      color: hover ? 'var(--color-primary)' : 'var(--text-heading)',
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: href,
    style: {
      color: 'inherit'
    }
  }, title), trending ? /*#__PURE__*/React.createElement(React.Fragment, null, " ", /*#__PURE__*/React.createElement(__ds_scope.Badge, null, "TRENDING")) : null), /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      bottom: 'var(--space-25)',
      left: 0,
      width: 'var(--rule-card)',
      height: '3px',
      backgroundImage: 'var(--gradient)'
    }
  })), metrics.length ? /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'flex',
      gap: '5px',
      flexWrap: 'wrap'
    }
  }, metrics.map((m, i) => /*#__PURE__*/React.createElement("li", {
    key: i
  }, /*#__PURE__*/React.createElement(__ds_scope.Badge, {
    tone: "chip"
  }, m.icon ? /*#__PURE__*/React.createElement("i", {
    className: m.icon,
    style: {
      marginRight: '5px'
    }
  }) : null, m.label)))) : null));
}
Object.assign(__ds_scope, { CourseCard });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/cards/CourseCard.jsx", error: String((e && e.message) || e) }); }

// components/core/SectionTitle.jsx
try { (() => {
/** The bold run inside a heading. In the source this is a plain <span> inside the h2,
 *  and it appears at the start, middle, end, or twice — so it must be placed by the author. */
function Em({
  children,
  style
}) {
  return /*#__PURE__*/React.createElement("span", {
    style: {
      fontWeight: 'var(--fw-bold)',
      ...style
    }
  }, children);
}
function SectionTitle({
  eyebrow,
  children,
  align = 'left',
  tone = 'ink',
  rule = true,
  style
}) {
  const onDark = tone === 'light';
  return /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: align,
      marginBottom: 'var(--space-65)',
      ...style
    }
  }, eyebrow ? /*#__PURE__*/React.createElement("span", {
    style: {
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
    }
  }, /*#__PURE__*/React.createElement(Dot, {
    side: "left"
  }), eyebrow, /*#__PURE__*/React.createElement(Dot, {
    side: "right"
  })) : null, /*#__PURE__*/React.createElement("h2", {
    style: {
      position: 'relative',
      display: 'inline-block',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-section)',
      fontWeight: 'var(--fw-light)',
      lineHeight: 'var(--lh-section)',
      color: onDark ? 'var(--genius-white)' : 'var(--text-heading)',
      margin: 0,
      paddingBottom: rule ? '20px' : 0
    }
  }, children, rule ? /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      bottom: 0,
      left: align === 'center' ? '50%' : 0,
      transform: align === 'center' ? 'translateX(-50%)' : 'none',
      width: 'var(--rule-section)',
      height: '2px',
      background: onDark ? 'var(--genius-white)' : 'var(--color-primary)'
    }
  }) : null));
}
function Dot({
  side
}) {
  return /*#__PURE__*/React.createElement("span", {
    "aria-hidden": "true",
    style: {
      position: 'absolute',
      [side]: 0,
      top: '-10px',
      fontSize: 'var(--fs-quote-mark)',
      lineHeight: 1,
      color: 'var(--color-primary)'
    }
  }, "..");
}
Object.assign(__ds_scope, { Em, SectionTitle });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/SectionTitle.jsx", error: String((e && e.message) || e) }); }

// components/core/HeroTitle.jsx
try { (() => {
function HeroTitle({
  eyebrow,
  children,
  size = 'display',
  align = 'left',
  indent = false,
  style
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: align,
      ...style
    }
  }, eyebrow ? /*#__PURE__*/React.createElement("span", {
    style: {
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
    }
  }, /*#__PURE__*/React.createElement("span", {
    "aria-hidden": "true",
    style: {
      position: 'absolute',
      left: 0,
      top: '-10px',
      fontSize: 'var(--fs-quote-mark)',
      lineHeight: 1,
      color: 'var(--color-primary)'
    }
  }, ".."), eyebrow, /*#__PURE__*/React.createElement("span", {
    "aria-hidden": "true",
    style: {
      position: 'absolute',
      right: 0,
      top: '-10px',
      fontSize: 'var(--fs-quote-mark)',
      lineHeight: 1,
      color: 'var(--color-primary)'
    }
  }, "..")) : null, /*#__PURE__*/React.createElement("h2", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: size === 'display' ? 'var(--fs-display)' : 'var(--fs-display-sm)',
      fontWeight: 'var(--fw-thin)',
      lineHeight: size === 'display' ? 'var(--lh-display)' : 'var(--lh-display-sm)',
      color: 'var(--genius-white)',
      margin: 0
    }
  }, children));
}
Object.assign(__ds_scope, { HeroTitle });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/HeroTitle.jsx", error: String((e && e.message) || e) }); }

// components/core/SubmitButton.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
function SubmitButton({
  children,
  icon,
  block = true,
  style,
  ...rest
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("button", _extends({}, rest, {
    type: rest.type || 'submit',
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
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
    }
  }), children, icon ? /*#__PURE__*/React.createElement("i", {
    className: icon,
    style: {
      marginLeft: '7px'
    }
  }) : null);
}
Object.assign(__ds_scope, { SubmitButton });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/core/SubmitButton.jsx", error: String((e && e.message) || e) }); }

// components/layout/Accordion.jsx
try { (() => {
function Accordion({
  items = [],
  openIndex = 0,
  onToggle,
  tone = 'light',
  style
}) {
  const [internal, setInternal] = React.useState(openIndex);
  const current = onToggle ? openIndex : internal;
  const set = i => onToggle ? onToggle(i === current ? -1 : i) : setInternal(i === current ? -1 : i);
  const onDark = tone === 'light';
  return /*#__PURE__*/React.createElement("div", {
    style: style
  }, items.map((it, i) => {
    const open = i === current;
    return /*#__PURE__*/React.createElement("div", {
      key: i,
      style: {
        marginBottom: 'var(--space-45)'
      }
    }, /*#__PURE__*/React.createElement("h3", {
      style: {
        position: 'relative',
        fontFamily: 'var(--font-sans)',
        fontSize: 'var(--fs-accordion)',
        fontWeight: 'var(--fw-regular)',
        lineHeight: 'var(--lh-accordion)',
        margin: 0
      }
    }, /*#__PURE__*/React.createElement("button", {
      onClick: () => set(i),
      "aria-expanded": open,
      style: {
        display: 'block',
        width: '100%',
        padding: 0,
        border: 0,
        background: 'transparent',
        textAlign: 'left',
        cursor: 'pointer',
        fontFamily: 'inherit',
        fontSize: 'inherit',
        fontWeight: 'inherit',
        lineHeight: 'inherit',
        color: onDark ? 'var(--genius-white)' : 'var(--text-heading)'
      }
    }, it.question)), open ? /*#__PURE__*/React.createElement("div", {
      style: {
        position: 'relative',
        marginTop: 'var(--space-15)',
        paddingLeft: 'var(--space-15)',
        fontFamily: 'var(--font-sans)',
        fontSize: 'var(--fs-base)',
        lineHeight: 'var(--lh-base)',
        color: onDark ? 'var(--genius-faq-body)' : 'var(--text-body)'
      }
    }, /*#__PURE__*/React.createElement("span", {
      style: {
        position: 'absolute',
        left: 0,
        top: 0,
        bottom: 0,
        width: 'var(--bar-faq)',
        background: 'var(--color-primary)'
      }
    }), it.answer) : null);
  }));
}
Object.assign(__ds_scope, { Accordion });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/layout/Accordion.jsx", error: String((e && e.message) || e) }); }

// components/layout/ContactAddress.jsx
try { (() => {
function ContactAddress({
  items = [],
  style
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      ...style
    }
  }, items.map((it, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      gap: 'var(--space-20)',
      marginBottom: 'var(--space-30)'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'relative',
      flexShrink: 0,
      width: 'var(--h-addr-icon)',
      height: 'var(--h-addr-icon)',
      lineHeight: 'var(--h-addr-icon)',
      borderRadius: 'var(--radius-addr)',
      border: 'var(--border-width-addr) solid transparent',
      backgroundImage: 'var(--gradient)',
      backgroundOrigin: 'border-box',
      textAlign: 'center',
      color: 'var(--genius-white)',
      fontSize: '22px'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: it.icon
  })), /*#__PURE__*/React.createElement("ul", {
    style: {
      paddingTop: '4px'
    }
  }, it.lines.map((l, j) => /*#__PURE__*/React.createElement("li", {
    key: j,
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-base)',
      lineHeight: '28px',
      color: 'var(--text-body)'
    }
  }, l))))));
}
Object.assign(__ds_scope, { ContactAddress });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/layout/ContactAddress.jsx", error: String((e && e.message) || e) }); }

// components/layout/CounterStrip.jsx
try { (() => {
function CounterStrip({
  items = [],
  style
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(200px,1fr))',
      gap: 'var(--gutter)',
      ...style
    }
  }, items.map((it, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'flex-start',
      gap: 'var(--space-15)'
    }
  }, it.icon ? /*#__PURE__*/React.createElement("span", {
    style: {
      flexShrink: 0,
      width: '60px',
      lineHeight: 'var(--lh-circle)',
      fontSize: '40px',
      textAlign: 'center'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: it.icon,
    style: {
      fontStyle: 'normal',
      backgroundImage: 'var(--gradient-text)',
      WebkitBackgroundClip: 'text',
      backgroundClip: 'text',
      WebkitTextFillColor: 'transparent',
      color: 'var(--color-primary)'
    }
  })) : null, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      lineHeight: '27px'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-counter)',
      fontWeight: 'var(--fw-bold)',
      color: 'var(--genius-white)'
    }
  }, it.value), it.suffix ? /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-base)',
      fontWeight: 'var(--fw-regular)',
      color: 'var(--genius-white)'
    }
  }, it.suffix) : null), /*#__PURE__*/React.createElement("p", {
    style: {
      margin: 0,
      marginTop: 'var(--space-10)',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-base)',
      lineHeight: 'var(--lh-base)',
      color: 'var(--genius-white)'
    }
  }, it.label)))));
}
Object.assign(__ds_scope, { CounterStrip });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/layout/CounterStrip.jsx", error: String((e && e.message) || e) }); }

// components/layout/HeroSlide.jsx
try { (() => {
function HeroSlide({
  image,
  minHeight = 720,
  overlay = false,
  background = '#0d6fb8',
  children,
  style
}) {
  return /*#__PURE__*/React.createElement("section", {
    style: {
      position: 'relative',
      minHeight: minHeight + 'px',
      background: background,
      backgroundImage: image ? 'url(' + image + ')' : 'none',
      backgroundSize: 'cover',
      backgroundPosition: 'center',
      backgroundRepeat: 'no-repeat',
      overflow: 'hidden',
      ...style
    }
  }, overlay ? /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      inset: 0,
      background: 'rgba(0,0,0,.45)'
    }
  }) : null, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      zIndex: 2
    }
  }, children));
}
Object.assign(__ds_scope, { HeroSlide });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/layout/HeroSlide.jsx", error: String((e && e.message) || e) }); }

// components/layout/SearchBar.jsx
try { (() => {
function SearchBar({
  placeholder = 'Type what do you want to learn today?',
  label = 'Search Course',
  value,
  onChange,
  onSubmit,
  style
}) {
  return /*#__PURE__*/React.createElement("form", {
    onSubmit: e => {
      e.preventDefault();
      onSubmit && onSubmit();
    },
    style: {
      position: 'relative',
      maxWidth: 'var(--search-width)',
      ...style
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Input, {
    size: "lg",
    ground: "search",
    placeholder: placeholder,
    value: value,
    onChange: onChange,
    style: {
      marginBottom: 0,
      paddingRight: '190px'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      right: 0,
      top: 0,
      width: '180px'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.SubmitButton, null, label)));
}
Object.assign(__ds_scope, { SearchBar });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/layout/SearchBar.jsx", error: String((e && e.message) || e) }); }

// components/layout/Section.jsx
try { (() => {
function Section({
  tone = 'white',
  image,
  pad = 'standard',
  overlay = false,
  children,
  contentStyle,
  style
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
  return /*#__PURE__*/React.createElement("section", {
    style: {
      position: 'relative',
      padding: pads[pad],
      background: tones[tone],
      backgroundImage: image ? 'url(' + image + ')' : undefined,
      backgroundSize: image ? 'cover' : undefined,
      backgroundPosition: image ? 'center' : undefined,
      backgroundRepeat: image ? 'no-repeat' : undefined,
      overflow: 'hidden',
      ...style
    }
  }, overlay ? /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      inset: 0,
      background: 'rgba(0,0,0,.55)'
    }
  }) : null, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      zIndex: 2,
      maxWidth: 'var(--container)',
      margin: '0 auto',
      padding: '0 15px',
      ...contentStyle
    }
  }, children));
}
function Grid({
  cols = 3,
  gap = 30,
  children,
  style
}) {
  // Derive the track minimum from the real design width at the 1170px container, so a
  // narrow viewport drops to fewer columns instead of squeezing in more, thinner ones.
  const design = (1170 - gap * (cols - 1)) / cols;
  const min = Math.round(design * 0.8);
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(min(' + min + 'px,100%),1fr))',
      gap: gap + 'px',
      ...style
    }
  }, children);
}
Object.assign(__ds_scope, { Section, Grid });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/layout/Section.jsx", error: String((e && e.message) || e) }); }

// components/layout/SiteFooter.jsx
try { (() => {
function SiteFooter({
  logo,
  brand = 'Genius',
  blurb,
  socials = [],
  legal = [],
  copyright,
  image,
  onSubscribe,
  style
}) {
  return /*#__PURE__*/React.createElement("footer", {
    style: {
      position: 'relative',
      backgroundColor: '#1b1b1b',
      backgroundImage: image ? 'url(' + image + ')' : undefined,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
      ...style
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      inset: 0,
      background: 'rgba(0,0,0,.7)'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      zIndex: 2,
      maxWidth: 'var(--container)',
      margin: '0 auto',
      padding: 'var(--space-60) 15px var(--space-30)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: 'center'
    }
  }, logo ? /*#__PURE__*/React.createElement("img", {
    src: logo,
    alt: brand,
    style: {
      display: 'inline-block',
      maxHeight: '40px',
      width: 'auto'
    }
  }) : /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: '22px',
      fontWeight: 'var(--fw-bold)',
      color: 'var(--genius-white)',
      textTransform: 'uppercase'
    }
  }, brand)), blurb ? /*#__PURE__*/React.createElement("p", {
    style: {
      maxWidth: 'var(--subscribe-width)',
      margin: 'var(--space-20) auto 0',
      textAlign: 'center',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-base)',
      lineHeight: 'var(--lh-base)',
      color: 'var(--genius-white)'
    }
  }, blurb) : null, /*#__PURE__*/React.createElement("form", {
    onSubmit: e => {
      e.preventDefault();
      onSubscribe && onSubscribe();
    },
    style: {
      position: 'relative',
      maxWidth: 'var(--subscribe-width)',
      margin: 'var(--space-35) auto var(--space-60)'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.Input, {
    size: "lg",
    ground: "search",
    type: "email",
    placeholder: "Email Address.",
    style: {
      marginBottom: 0,
      paddingRight: '200px'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      right: 0,
      top: 0,
      width: '190px'
    }
  }, /*#__PURE__*/React.createElement(__ds_scope.SubmitButton, null, "Subscribe now"))), socials.length ? /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'flex',
      justifyContent: 'center',
      gap: 'var(--space-20)',
      marginBottom: 'var(--space-30)'
    }
  }, socials.map((s, i) => /*#__PURE__*/React.createElement(Social, {
    key: i,
    s: s
  }))) : null, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: 'var(--space-20)',
      flexWrap: 'wrap',
      borderTop: 'var(--border-width) solid rgba(255,255,255,.15)',
      paddingTop: 'var(--space-25)'
    }
  }, /*#__PURE__*/React.createElement("p", {
    style: {
      margin: 0,
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-base)',
      lineHeight: 'var(--lh-base)',
      color: 'var(--genius-white)'
    }
  }, copyright), legal.length ? /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'flex',
      gap: 'var(--space-20)',
      flexWrap: 'wrap'
    }
  }, legal.map((l, i) => /*#__PURE__*/React.createElement(LegalLink, {
    key: i,
    l: l
  }))) : null)));
}
function Social({
  s
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement("a", {
    href: s.href || '#',
    "aria-label": s.label,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      display: 'inline-block',
      lineHeight: 'var(--lh-chip)',
      fontSize: 'var(--fs-base)',
      color: hover ? 'var(--color-primary)' : 'var(--genius-white)',
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: s.icon
  })));
}
function LegalLink({
  l
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement("a", {
    href: l.href || '#',
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-base)',
      color: hover ? 'var(--color-primary)' : 'var(--genius-white)',
      textDecoration: 'none',
      transition: 'var(--transition)'
    }
  }, l.label));
}
Object.assign(__ds_scope, { SiteFooter });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/layout/SiteFooter.jsx", error: String((e && e.message) || e) }); }

// components/layout/SiteHeader.jsx
try { (() => {
function NavLink({
  item,
  active,
  onSelect
}) {
  const [open, setOpen] = React.useState(false);
  const on = open;
  return /*#__PURE__*/React.createElement("li", {
    style: {
      display: 'inline-block',
      position: 'relative'
    },
    onMouseEnter: () => setOpen(true),
    onMouseLeave: () => setOpen(false)
  }, /*#__PURE__*/React.createElement("a", {
    href: item.href || '#',
    onClick: e => {
      if (onSelect) {
        e.preventDefault();
        onSelect(item);
      }
    },
    style: {
      position: 'relative',
      display: 'inline-block',
      padding: 'var(--pad-nav-link)',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-nav)',
      fontWeight: 'var(--fw-medium)',
      lineHeight: '21px',
      color: 'var(--genius-white)',
      textTransform: 'uppercase',
      textDecoration: 'none',
      borderRadius: 'var(--radius)',
      zIndex: 1
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      inset: 0,
      borderRadius: 'var(--radius)',
      backgroundImage: 'var(--gradient)',
      backgroundSize: 'var(--gradient-size)',
      opacity: on ? 1 : 0,
      transition: 'var(--transition)',
      zIndex: -1
    }
  }), item.label), item.children && item.children.length ? /*#__PURE__*/React.createElement("ul", {
    style: {
      position: 'absolute',
      top: '30px',
      left: '-115px',
      width: 'var(--w-submenu)',
      padding: 'var(--pad-submenu)',
      background: 'var(--genius-white)',
      borderRadius: 'var(--radius)',
      boxShadow: 'var(--shadow-menu)',
      opacity: open ? 1 : 0,
      visibility: open ? 'visible' : 'hidden',
      transition: 'var(--transition)',
      zIndex: 20
    }
  }, item.children.map((c, i) => /*#__PURE__*/React.createElement(SubLink, {
    key: i,
    item: c,
    onSelect: onSelect
  }))) : null);
}
function SubLink({
  item,
  onSelect
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement("a", {
    href: item.href || '#',
    onClick: e => {
      if (onSelect) {
        e.preventDefault();
        onSelect(item);
      }
    },
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      position: 'relative',
      display: 'block',
      padding: '6px 10px',
      marginBottom: '4px',
      borderRadius: 'var(--radius)',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-nav)',
      fontWeight: 'var(--fw-medium)',
      lineHeight: '21px',
      color: hover ? 'var(--genius-white)' : 'var(--text-heading)',
      textTransform: 'capitalize',
      textDecoration: 'none',
      transition: 'var(--transition)',
      zIndex: 1
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      inset: 0,
      borderRadius: 'var(--radius)',
      backgroundImage: 'var(--gradient)',
      backgroundSize: 'var(--gradient-size)',
      opacity: hover ? 1 : 0,
      transition: 'var(--transition)',
      zIndex: -1
    }
  }), item.label));
}
function IconCircle({
  icon,
  label,
  onClick
}) {
  const [hover, setHover] = React.useState(false);
  return /*#__PURE__*/React.createElement("button", {
    onClick: onClick,
    "aria-label": label,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      width: '42px',
      height: '42px',
      display: 'inline-flex',
      alignItems: 'center',
      justifyContent: 'center',
      borderRadius: 'var(--radius-circle)',
      border: 'var(--border-width-button) solid var(--color-primary)',
      background: hover ? 'var(--color-primary)' : 'transparent',
      color: 'var(--genius-white)',
      fontSize: 'var(--fs-base)',
      cursor: 'pointer',
      transition: 'var(--transition)'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: icon
  }));
}
function SiteHeader({
  logo,
  brand = 'Genius',
  items = [],
  active,
  onSelect,
  languages = ['ENG', 'BAN', 'ARB', 'FRN'],
  onLogin,
  style
}) {
  return /*#__PURE__*/React.createElement("header", {
    style: {
      position: 'relative',
      width: '100%',
      zIndex: 30,
      ...style
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container)',
      margin: '0 auto',
      padding: '25px 15px'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 'var(--space-30)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: "#",
    onClick: e => {
      if (onSelect) {
        e.preventDefault();
        onSelect(items[0] || {});
      }
    },
    style: {
      flexShrink: 0,
      display: 'inline-block'
    }
  }, logo ? /*#__PURE__*/React.createElement("img", {
    src: logo,
    alt: brand,
    style: {
      display: 'block',
      maxHeight: '40px',
      width: 'auto'
    }
  }) : /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: '22px',
      fontWeight: 'var(--fw-bold)',
      color: 'var(--genius-white)',
      textTransform: 'uppercase'
    }
  }, brand)), languages.length ? /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'relative',
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement("select", {
    "aria-label": "Language",
    style: {
      appearance: 'none',
      background: 'transparent',
      border: 0,
      paddingRight: '18px',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-nav)',
      fontWeight: 'var(--fw-medium)',
      textTransform: 'uppercase',
      color: 'var(--color-primary)',
      cursor: 'pointer'
    }
  }, languages.map(l => /*#__PURE__*/React.createElement("option", {
    key: l,
    style: {
      color: '#333'
    }
  }, l))), /*#__PURE__*/React.createElement("i", {
    className: "fas fa-chevron-down",
    style: {
      position: 'absolute',
      right: 0,
      top: '5px',
      fontSize: '10px',
      color: 'var(--color-primary)'
    }
  })) : null, /*#__PURE__*/React.createElement("nav", {
    style: {
      marginLeft: 'auto',
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'flex',
      alignItems: 'center',
      flexWrap: 'wrap'
    }
  }, items.map((it, i) => /*#__PURE__*/React.createElement(NavLink, {
    key: i,
    item: it,
    active: active,
    onSelect: onSelect
  })))), /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 'var(--space-10)',
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement(IconCircle, {
    icon: "fas fa-shopping-bag",
    label: "Cart"
  })), /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement(IconCircle, {
    icon: "fas fa-search",
    label: "Search"
  }))), /*#__PURE__*/React.createElement("a", {
    href: "#",
    onClick: e => {
      if (onLogin) {
        e.preventDefault();
        onLogin();
      }
    },
    style: {
      flexShrink: 0,
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-nav)',
      fontWeight: 'var(--fw-bold)',
      lineHeight: '21px',
      color: 'var(--genius-white)',
      textTransform: 'uppercase',
      textDecoration: 'none'
    }
  }, "log in"))));
}
Object.assign(__ds_scope, { SiteHeader });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/layout/SiteHeader.jsx", error: String((e && e.message) || e) }); }

// components/layout/Tabs.jsx
try { (() => {
function Tabs({
  items = [],
  active,
  onChange,
  align = 'center',
  style
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: align,
      marginBottom: 'var(--space-45)',
      ...style
    }
  }, /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'inline-flex',
      gap: 'var(--space-10)',
      flexWrap: 'wrap',
      justifyContent: 'center'
    }
  }, items.map(it => /*#__PURE__*/React.createElement(Tab, {
    key: it,
    label: it,
    on: it === active,
    onClick: () => onChange && onChange(it)
  }))));
}
function Tab({
  label,
  on,
  onClick
}) {
  const [hover, setHover] = React.useState(false);
  const lit = on || hover;
  return /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement("button", {
    onClick: onClick,
    onMouseEnter: () => setHover(true),
    onMouseLeave: () => setHover(false),
    style: {
      position: 'relative',
      padding: 'var(--pad-chip)',
      border: 0,
      borderRadius: 'var(--radius)',
      background: 'var(--genius-tab)',
      color: 'var(--genius-white)',
      fontFamily: 'var(--font-sans)',
      fontSize: 'var(--fs-base)',
      fontWeight: 'var(--fw-medium)',
      textTransform: 'uppercase',
      cursor: 'pointer',
      zIndex: 1,
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      inset: 0,
      borderRadius: 'var(--radius)',
      backgroundImage: 'var(--gradient)',
      backgroundSize: 'var(--gradient-size)',
      opacity: lit ? 1 : 0,
      transition: 'var(--transition)',
      zIndex: -1
    }
  }), label));
}
Object.assign(__ds_scope, { Tabs });
})(); } catch (e) { __ds_ns.__errors.push({ path: "components/layout/Tabs.jsx", error: String((e && e.message) || e) }); }

// ui_kits/website/data.js
try { (() => {
window.GeniusData = {
  img: 'https://jthemes.net/themes/html/genius-course/assets/img',
  nav: [{
    label: 'Home',
    screen: 'home',
    children: [{
      label: 'Home 1',
      screen: 'home'
    }, {
      label: 'Home 2',
      screen: 'home'
    }, {
      label: 'Home 3',
      screen: 'home'
    }, {
      label: 'Home 4',
      screen: 'home'
    }]
  }, {
    label: 'About Us',
    screen: 'about'
  }, {
    label: 'shop',
    screen: 'shop'
  }, {
    label: 'Contact Us',
    screen: 'contact'
  }, {
    label: 'Pages',
    screen: 'course',
    children: [{
      label: 'Teacher',
      screen: 'teacher'
    }, {
      label: 'Course',
      screen: 'course'
    }, {
      label: 'Course Details',
      screen: 'course'
    }, {
      label: 'Blog',
      screen: 'blog'
    }, {
      label: 'FAQ',
      screen: 'faq'
    }]
  }],
  socials: [{
    icon: 'fab fa-facebook-f',
    label: 'Facebook'
  }, {
    icon: 'fab fa-twitter',
    label: 'Twitter'
  }, {
    icon: 'fab fa-google-plus-g',
    label: 'Google Plus'
  }],
  courses: [{
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/course/c-1.jpg',
    price: '$99.00',
    category: 'Web Design',
    author: 'John Luis Fernandes',
    title: 'Fully Responsive Web Design & Development.',
    trending: true,
    metrics: [{
      icon: 'fas fa-user',
      label: '1.220'
    }, {
      icon: 'fas fa-comment-dots',
      label: '1.015'
    }, {
      label: '125k Unrolled'
    }]
  }, {
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/course/c-2.jpg',
    price: '$99.00',
    category: 'Mobile Apps',
    author: 'Fernando Torres',
    title: 'Introduction to Mobile Application Development.',
    metrics: [{
      icon: 'fas fa-user',
      label: '1.220'
    }, {
      icon: 'fas fa-comment-dots',
      label: '1.015'
    }, {
      label: '125k Unrolled'
    }]
  }, {
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/course/c-3.jpg',
    price: '$99.00',
    category: 'Motion Graphic',
    author: 'enny Garcias',
    title: 'Learning IOS Apps Programming & Development.',
    metrics: [{
      icon: 'fas fa-user',
      label: '1.220'
    }, {
      icon: 'fas fa-comment-dots',
      label: '1.015'
    }, {
      label: '125k Unrolled'
    }]
  }],
  bestCourses: ['bc-1', 'bc-2', 'bc-3', 'bc-4', 'bc-5', 'bc-6', 'bc-7', 'bc-8'].map(function (n, i) {
    return {
      image: 'https://jthemes.net/themes/html/genius-course/assets/img/course/' + n + '.jpg',
      price: '$99.00',
      title: 'Fully Responsive Web Design & Development.',
      category: 'Web Design',
      students: '250 Students',
      trending: i === 0 || i === 5
    };
  }),
  news: [{
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/blog/lb-1.jpg',
    date: '26 April 2018',
    title: 'Affiliate Marketing A Beginner’s Guide.',
    metrics: [{
      icon: 'fas fa-user',
      label: '1.220'
    }, {
      icon: 'fas fa-comment-dots',
      label: '1.015'
    }]
  }, {
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/blog/lb-2.jpg',
    date: '26 April 2018',
    title: 'No.1 The Best Online Course 2018.',
    metrics: [{
      icon: 'fas fa-user',
      label: '1.220'
    }, {
      icon: 'fas fa-comment-dots',
      label: '1.015'
    }]
  }],
  events: [{
    day: '22',
    month: 'April 2018',
    title: 'Fully Responsive Web Design & Development.',
    category: 'Web Design',
    author: 'Koke'
  }, {
    day: '07',
    month: 'August 2018',
    title: 'Introduction to Mobile Application Development.',
    category: 'Web Design',
    author: 'Koke'
  }, {
    day: '30',
    month: 'Sept 2018',
    title: 'IOS Apps Programming & Development.',
    category: 'Web Design',
    author: 'Koke'
  }],
  products: ['bp-1', 'bp-2', 'bp-3', 'bp-4'].map(function (n) {
    return {
      image: 'https://jthemes.net/themes/html/genius-course/assets/img/product/' + n + '.png',
      title: 'Mobile Apps Books.',
      price: 'Start from $55.25'
    };
  }),
  teachers: [{
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/teacher/tb-1.png',
    name: 'Daniel Alvares',
    designation: 'Mobile Apps'
  }, {
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/teacher/tb-2.png',
    name: 'Berliana Luis',
    designation: 'IOS App'
  }, {
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/teacher/tb-3.png',
    name: 'Juliana Hernandes',
    designation: 'Web Design'
  }, {
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/teacher/tb-4.png',
    name: 'Johansen Doe',
    designation: 'Graphic'
  }],
  categories: [{
    icon: 'flaticon-technology',
    title: 'Responsive Website'
  }, {
    icon: 'flaticon-app-store',
    title: 'IOS Applications'
  }, {
    icon: 'flaticon-artist-tools',
    title: 'Graphic Design'
  }, {
    icon: 'flaticon-business',
    title: 'Marketing'
  }, {
    icon: 'flaticon-dna',
    title: 'Science'
  }, {
    icon: 'flaticon-cogwheel',
    title: 'Enginering'
  }, {
    icon: 'flaticon-favorites-button',
    title: 'Photography'
  }, {
    icon: 'flaticon-technology-1',
    title: 'Mobile Application'
  }],
  testimonials: [{
    name: 'Robertho Garcia',
    designation: 'Graphic Designer'
  }, {
    name: 'Juliana Hernandes',
    designation: 'Web Designer'
  }, {
    name: 'Daniel Alvares',
    designation: 'Mobile Developer'
  }],
  counters: [{
    icon: 'flaticon-graduation-hat',
    value: '5',
    suffix: ' M+',
    label: 'Students Enrolled'
  }, {
    icon: 'flaticon-book',
    value: '122',
    suffix: '.500+',
    label: 'Online Available Courses'
  }, {
    icon: 'flaticon-favorites-button',
    value: '15',
    suffix: '.000+',
    label: 'Premium Quality Products'
  }, {
    icon: 'flaticon-group',
    value: '7',
    suffix: '.500+',
    label: 'Teachers Registered'
  }],
  faq: {
    tabs: ['GENERAL', 'COURSES', 'TEACHERS', 'EVENTS', 'OTHERS'],
    answer: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam volutpat. Ut wisi enim ad minim veniam consectetuer adipiscing elit, sed diam nonummy.',
    questions: ['How to Register or Make An Account in Genius?', 'What is Genius Courses?', 'What Lorem Ipsum Dolor Sit Amet Consectuerer?', 'Adipiscing Diamet Nonnumy Nibh Euismod?']
  },
  contact: [{
    icon: 'fas fa-map-marker-alt',
    lines: ['Primary: Last Vegas, 120 Graphic Street, US', 'Second: Califorinia, 88 Design Street, US']
  }, {
    icon: 'fas fa-phone',
    lines: ['Primary: (100) 3434 55666', 'Second: (20) 3434 9999']
  }, {
    icon: 'fas fa-envelope',
    lines: ['Primary: info@geniuscourse.com', 'Second: mail@genius.info']
  }],
  about: {
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/about/abt.jpg',
    lede: 'We take our mission of increasing global access to quality education seriously. We connect learners to the best universities and institutions from around the world.',
    body: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam volutpat. Ut wisi enim ad minim veniam. magna aliquam volutpat. Ut wisi enim ad minim veniam.',
    list: ['Professional And Experienced Since 1980', 'We Connect Learners To The Best Universities From Around The World', 'Our Mission Increasing Global Access To Quality Aducation', '100K Online Available Courses']
  },
  app: {
    image: 'https://jthemes.net/themes/html/genius-course/assets/img/about/ab-2.png',
    list: ['Professional And Experienced Since 1980', 'Our Mission Increasing Global Access To Quality Aducation', '100K Online Available Courses']
  },
  sponsors: ['s-1', 's-2', 's-3', 's-4', 's-5', 's-6'].map(function (n) {
    return 'https://jthemes.net/themes/html/genius-course/assets/img/sponsor/' + n + '.jpg';
  }),
  footer: {
    blurb: 'We take our mission of increasing global access to quality education seriously.',
    legal: [{
      label: 'License'
    }, {
      label: 'Privacy & Policy'
    }, {
      label: 'Term Of Service'
    }],
    copyright: '© 2018 - Designed & Developed by Jthemes Studio. All rights reserved'
  }
};
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/website/data.js", error: String((e && e.message) || e) }); }

// ui_kits/website/home.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
const NS = window.RaqueDesignSystem_94a18b;
const {
  SiteHeader,
  HeroSlide,
  HeroTitle,
  Section,
  Grid,
  SectionTitle,
  Em,
  Button,
  SubmitButton,
  Input,
  SearchBar,
  CourseCard,
  BestCourseCard,
  NewsCard,
  EventCard,
  ProductCard,
  TeacherCard,
  CategoryTile,
  TestimonialSlide,
  CounterStrip,
  Tabs,
  Accordion,
  ContactAddress,
  BulletList
} = NS;
function HomeScreen({
  go,
  onLogin,
  state,
  actions
}) {
  const D = window.GeniusData;
  const [faqTab, setFaqTab] = React.useState(D.faq.tabs[0]);
  const [testi, setTesti] = React.useState(0);
  const [openFaq, setOpenFaq] = React.useState(0);
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(HeroSlide, {
    image: D.img + '/banner/sd-1.jpg',
    minHeight: 760,
    background: "#0d6fb8"
  }, /*#__PURE__*/React.createElement(SiteHeader, {
    logo: D.img + '/logo/logo.png',
    brand: "Genius",
    items: D.nav,
    active: "Home",
    onSelect: it => go(it.screen || 'home'),
    onLogin: onLogin
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container)',
      margin: '0 auto',
      padding: '130px 15px 150px'
    }
  }, /*#__PURE__*/React.createElement(HeroTitle, {
    eyebrow: "EDUCATION & TRAINING ORGANIZATION",
    indent: true
  }, /*#__PURE__*/React.createElement(Em, null, "Inventive"), " Solution", /*#__PURE__*/React.createElement("br", null), " for ", /*#__PURE__*/React.createElement(Em, null, "Education")), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 'var(--space-35)'
    }
  }, /*#__PURE__*/React.createElement(Button, {
    variant: "outline",
    onClick: e => {
      e.preventDefault();
      go('course');
    },
    href: "#"
  }, "Our Courses")))), /*#__PURE__*/React.createElement(SponsorStrip, null), /*#__PURE__*/React.createElement(Section, {
    pad: "product"
  }, /*#__PURE__*/React.createElement(SectionTitle, {
    eyebrow: "LEARN NEW SKILLS"
  }, /*#__PURE__*/React.createElement(Em, null, "Popular"), " Courses."), /*#__PURE__*/React.createElement(Grid, {
    cols: 3
  }, D.courses.map((c, i) => /*#__PURE__*/React.createElement(CourseCard, _extends({
    key: i
  }, c, {
    href: "#",
    onClick: () => go('course')
  }))))), /*#__PURE__*/React.createElement(Section, {
    tone: "alt"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(320px,1fr))',
      gap: 'var(--space-60)',
      alignItems: 'center'
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(SectionTitle, {
    eyebrow: "SORT ABOUT US"
  }, "We are ", /*#__PURE__*/React.createElement(Em, null, "Genius Course"), " work since 1980."), /*#__PURE__*/React.createElement("p", {
    style: {
      fontSize: 'var(--fs-card-title)',
      fontWeight: 'var(--fw-medium)',
      lineHeight: 'var(--lh-body-lg)',
      color: 'var(--text-heading)',
      marginBottom: 'var(--space-20)'
    }
  }, D.about.lede), /*#__PURE__*/React.createElement("p", {
    style: {
      marginBottom: 'var(--space-30)'
    }
  }, D.about.body), /*#__PURE__*/React.createElement(BulletList, {
    items: D.about.list,
    style: {
      marginBottom: 'var(--space-35)'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 'var(--space-15)',
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement(Button, {
    onClick: e => {
      e.preventDefault();
      go('about');
    },
    href: "#",
    style: {
      marginTop: 0
    }
  }, "About Us"), /*#__PURE__*/React.createElement(Button, {
    variant: "outline",
    onClick: e => {
      e.preventDefault();
      go('contact');
    },
    href: "#",
    style: {
      marginTop: 0
    }
  }, "contact us"))), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: 'var(--space-35)',
      borderRadius: 'var(--radius)',
      background: 'var(--surface-page)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: 'center',
      marginBottom: 'var(--space-25)'
    }
  }, /*#__PURE__*/React.createElement("h3", {
    style: {
      fontSize: 'var(--fs-h4)',
      fontWeight: 'var(--fw-medium)',
      marginBottom: '6px'
    }
  }, "Get a Free Registration."), /*#__PURE__*/React.createElement("p", {
    style: {
      margin: 0,
      fontSize: 'var(--fs-meta)'
    }
  }, "More Than 122K Online Available Courses")), /*#__PURE__*/React.createElement("form", {
    onSubmit: e => {
      e.preventDefault();
      actions.register();
    }
  }, /*#__PURE__*/React.createElement(Input, {
    placeholder: "Your Name*",
    required: true
  }), /*#__PURE__*/React.createElement(Input, {
    type: "email",
    placeholder: "Your@email.com*",
    required: true
  }), /*#__PURE__*/React.createElement(Input, {
    as: "select",
    defaultValue: ""
  }, /*#__PURE__*/React.createElement("option", {
    value: "",
    disabled: true
  }, "Select Course."), /*#__PURE__*/React.createElement("option", null, "Web Design"), /*#__PURE__*/React.createElement("option", null, "Web Development"), /*#__PURE__*/React.createElement("option", null, "Php Core")), state.registered ? /*#__PURE__*/React.createElement("p", {
    style: {
      margin: '0 0 10px',
      fontSize: 'var(--fs-meta)',
      fontWeight: 'var(--fw-bold)',
      color: 'var(--color-primary)'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: "fas fa-check",
    style: {
      marginRight: '6px'
    }
  }), "Request received.") : null, /*#__PURE__*/React.createElement(SubmitButton, null, "SUBMIT REQUEST"))))), /*#__PURE__*/React.createElement(Section, {
    image: D.img + '/banner/hb-2.jpg',
    pad: "product",
    overlay: true
  }, /*#__PURE__*/React.createElement(SectionTitle, {
    align: "center",
    tone: "light",
    eyebrow: "LEARN NEW SKILLS"
  }, /*#__PURE__*/React.createElement(Em, null, "Search"), " Genius Courses."), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'center',
      marginBottom: 'var(--space-60)'
    }
  }, /*#__PURE__*/React.createElement(SearchBar, {
    value: state.query,
    onChange: e => actions.setQuery(e.target.value),
    onSubmit: () => go('course'),
    style: {
      width: '100%'
    }
  })), /*#__PURE__*/React.createElement(CounterStrip, {
    items: D.counters
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(300px,1fr))',
      gap: 'var(--space-60)',
      alignItems: 'center',
      marginTop: 'var(--space-65)'
    }
  }, /*#__PURE__*/React.createElement("img", {
    src: D.app.image,
    alt: "",
    style: {
      display: 'block',
      width: '100%'
    }
  }), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(SectionTitle, {
    tone: "light"
  }, /*#__PURE__*/React.createElement(Em, null, "Download"), " Genius Application on ", /*#__PURE__*/React.createElement(Em, null, "PlayStore.")), /*#__PURE__*/React.createElement("p", {
    style: {
      marginBottom: 'var(--space-25)',
      color: 'var(--genius-white)'
    }
  }, "Introduction Genius Mobile Application on Play Store lorem ipsum dolor sit amet consectuerer adipiscing."), /*#__PURE__*/React.createElement(BulletList, {
    items: D.app.list,
    style: {
      marginBottom: 'var(--space-30)'
    },
    tone: "light"
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 'var(--space-20)',
      alignItems: 'center',
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement(Button, {
    icon: null,
    href: "#",
    style: {
      marginTop: 0
    }
  }, "GET THE APP NOW"), /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'flex',
      gap: 'var(--space-15)',
      fontSize: '22px',
      color: 'var(--genius-white)'
    }
  }, /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement("a", {
    href: "#",
    "aria-label": "App Store"
  }, /*#__PURE__*/React.createElement("i", {
    className: "fab fa-apple"
  }))), /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement("a", {
    href: "#",
    "aria-label": "Play Store"
  }, /*#__PURE__*/React.createElement("i", {
    className: "fab fa-android"
  }))), /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement("a", {
    href: "#",
    "aria-label": "Windows"
  }, /*#__PURE__*/React.createElement("i", {
    className: "fab fa-windows"
  })))))))), /*#__PURE__*/React.createElement(Section, {
    tone: "alt",
    pad: "product"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(280px,1fr))',
      gap: 'var(--gutter)'
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(SectionTitle, null, "Latest ", /*#__PURE__*/React.createElement(Em, null, "News.")), D.news.map((n, i) => /*#__PURE__*/React.createElement(NewsCard, _extends({
    key: i
  }, n, {
    last: i === D.news.length - 1,
    onClick: () => go('blog')
  }))), /*#__PURE__*/React.createElement("a", {
    href: "#",
    onClick: e => {
      e.preventDefault();
      go('blog');
    },
    style: {
      fontWeight: 'var(--fw-bold)',
      color: 'var(--text-heading)'
    }
  }, "View All News")), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(SectionTitle, null, "Upcoming ", /*#__PURE__*/React.createElement(Em, null, "Events.")), D.events.map((ev, i) => /*#__PURE__*/React.createElement(EventCard, _extends({
    key: i
  }, ev))), /*#__PURE__*/React.createElement("a", {
    href: "#",
    onClick: e => e.preventDefault(),
    style: {
      fontWeight: 'var(--fw-bold)',
      color: 'var(--text-heading)'
    }
  }, "Check Calendar")), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(SectionTitle, null, "Latest ", /*#__PURE__*/React.createElement(Em, null, "Video.")), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      marginBottom: 'var(--space-20)'
    }
  }, /*#__PURE__*/React.createElement("img", {
    src: D.img + '/banner/v-1.jpg',
    alt: "",
    style: {
      display: 'block',
      width: '100%',
      borderRadius: 'var(--radius)'
    }
  }), /*#__PURE__*/React.createElement("a", {
    href: "https://www.youtube.com/watch?v=-g4TnixUdSc",
    target: "_blank",
    rel: "noreferrer",
    "aria-label": "Play video",
    style: {
      position: 'absolute',
      top: '50%',
      left: '50%',
      transform: 'translate(-50%,-50%)',
      width: 'var(--h-circle)',
      height: 'var(--h-circle)',
      lineHeight: 'var(--lh-circle)',
      borderRadius: 'var(--radius-circle)',
      textAlign: 'center',
      backgroundImage: 'var(--gradient)',
      backgroundSize: 'var(--gradient-size)',
      color: 'var(--genius-white)'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: "fas fa-play"
  }))), /*#__PURE__*/React.createElement("h3", {
    style: {
      fontSize: 'var(--fs-title-sm)',
      fontWeight: 'var(--fw-bold)',
      lineHeight: '21.6px',
      marginBottom: 'var(--space-10)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: "#",
    onClick: e => e.preventDefault()
  }, "Learning IOS Apps in Amsterdam.")), /*#__PURE__*/React.createElement("p", {
    style: {
      marginBottom: 'var(--space-15)'
    }
  }, "Lorem ipsum dolor sit amet, consectetuer delacosta adipiscing elit, sed diam nonummy."), /*#__PURE__*/React.createElement("a", {
    href: "#",
    onClick: e => e.preventDefault(),
    style: {
      fontWeight: 'var(--fw-bold)',
      color: 'var(--text-heading)'
    }
  }, "View All Videos")))), /*#__PURE__*/React.createElement(Section, {
    pad: "product"
  }, /*#__PURE__*/React.createElement(SectionTitle, null, "Genius ", /*#__PURE__*/React.createElement(Em, null, "Best Products.")), /*#__PURE__*/React.createElement(Grid, {
    cols: 4
  }, D.products.map((p, i) => /*#__PURE__*/React.createElement(ProductCard, _extends({
    key: i
  }, p, {
    href: "#",
    onClick: () => go('shop')
  }))))), /*#__PURE__*/React.createElement(Section, {
    tone: "alt",
    pad: "product"
  }, /*#__PURE__*/React.createElement(SectionTitle, {
    align: "center",
    eyebrow: "SEARCH OUR COURSES"
  }, "Browse Our", /*#__PURE__*/React.createElement(Em, null, " Best Course.")), /*#__PURE__*/React.createElement(Grid, {
    cols: 4
  }, D.bestCourses.slice(0, 8).map((c, i) => /*#__PURE__*/React.createElement(BestCourseCard, _extends({
    key: i
  }, c, {
    href: "#",
    onClick: () => go('course')
  }))))), /*#__PURE__*/React.createElement(Section, {
    image: D.img + '/banner/fq-1.jpg',
    pad: "faq",
    overlay: true
  }, /*#__PURE__*/React.createElement(SectionTitle, {
    align: "center",
    tone: "light",
    eyebrow: "GENIUS COURSE FAQ"
  }, "Frequently", /*#__PURE__*/React.createElement(Em, null, " Ask & Questions")), /*#__PURE__*/React.createElement(Tabs, {
    items: D.faq.tabs,
    active: faqTab,
    onChange: setFaqTab
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(280px,1fr))',
      gap: 'var(--space-45)'
    }
  }, [0, 1].map(col => /*#__PURE__*/React.createElement(Accordion, {
    key: col + faqTab,
    items: D.faq.questions.slice(col * 2, col * 2 + 2).map(q => ({
      question: q,
      answer: D.faq.answer
    })),
    openIndex: col === 0 ? openFaq : -1,
    onToggle: col === 0 ? setOpenFaq : undefined
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 'var(--space-15)',
      justifyContent: 'center',
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement(Button, {
    variant: "onDark",
    onClick: e => {
      e.preventDefault();
      go('faq');
    },
    href: "#"
  }, "Make Question"), /*#__PURE__*/React.createElement(Button, {
    variant: "onDark",
    onClick: e => {
      e.preventDefault();
      go('contact');
    },
    href: "#"
  }, "contact us"))), /*#__PURE__*/React.createElement(Section, {
    pad: "product"
  }, /*#__PURE__*/React.createElement(SectionTitle, {
    eyebrow: "GENIUS CATEGORIES"
  }, "Browse ", /*#__PURE__*/React.createElement(Em, null, "By Category.")), /*#__PURE__*/React.createElement(Grid, {
    cols: 4
  }, D.categories.map((c, i) => /*#__PURE__*/React.createElement(CategoryTile, _extends({
    key: i
  }, c, {
    href: "#",
    onClick: e => {
      e.preventDefault();
      go('course');
    }
  }))))), /*#__PURE__*/React.createElement(Section, {
    tone: "alt",
    pad: "product"
  }, /*#__PURE__*/React.createElement(SectionTitle, {
    align: "center",
    eyebrow: "WHAT THEY SAY ABOUT US"
  }, "Students ", /*#__PURE__*/React.createElement(Em, null, "Testimonial.")), /*#__PURE__*/React.createElement(TestimonialSlide, {
    quote: "\u201CThis was our first time lorem ipsum and we ",
    emphasis: "were very pleased with the whole experience",
    tail: ". Your price was lower than other companies. Our experience so we\u2019ll be back in the future lorem ipsum diamet.\u201D",
    name: D.testimonials[testi].name,
    designation: D.testimonials[testi].designation
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'center',
      gap: '8px',
      marginTop: 'var(--space-45)'
    }
  }, D.testimonials.map((_, i) => /*#__PURE__*/React.createElement("button", {
    key: i,
    onClick: () => setTesti(i),
    "aria-label": 'Testimonial ' + (i + 1),
    style: {
      width: '10px',
      height: '10px',
      padding: 0,
      border: 0,
      borderRadius: 'var(--radius-circle)',
      cursor: 'pointer',
      background: i === testi ? 'var(--color-primary)' : 'var(--border-default)',
      transition: 'var(--transition)'
    }
  })))), /*#__PURE__*/React.createElement(Section, {
    pad: "teacher"
  }, /*#__PURE__*/React.createElement(SectionTitle, {
    eyebrow: "GENIUS STAFFS"
  }, "Genius ", /*#__PURE__*/React.createElement(Em, null, "Teachers.")), /*#__PURE__*/React.createElement(Grid, {
    cols: 4
  }, D.teachers.map((t, i) => /*#__PURE__*/React.createElement(TeacherCard, _extends({
    key: i
  }, t, {
    socials: D.socials
  })))), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 'var(--space-45)'
    }
  }, /*#__PURE__*/React.createElement(Button, {
    onClick: e => {
      e.preventDefault();
      go('teacher');
    },
    href: "#"
  }, "All teacher"))), /*#__PURE__*/React.createElement(Section, {
    tone: "alt",
    pad: "product"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(300px,1fr))',
      gap: 'var(--space-60)'
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(SectionTitle, {
    eyebrow: "CONTACT US"
  }, /*#__PURE__*/React.createElement(Em, null, "Get in Touch")), /*#__PURE__*/React.createElement("p", {
    style: {
      marginBottom: 'var(--space-35)'
    }
  }, "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet ipsum dolor sit amet."), /*#__PURE__*/React.createElement(ContactAddress, {
    items: D.contact
  })), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("h3", {
    style: {
      fontSize: 'var(--fs-h4)',
      fontWeight: 'var(--fw-medium)',
      marginBottom: 'var(--space-20)'
    }
  }, "Send Us a message"), /*#__PURE__*/React.createElement("form", {
    onSubmit: e => {
      e.preventDefault();
      actions.sendMessage();
    }
  }, /*#__PURE__*/React.createElement(Input, {
    placeholder: "Name.",
    required: true
  }), /*#__PURE__*/React.createElement(Input, {
    type: "email",
    placeholder: "Email.",
    required: true
  }), /*#__PURE__*/React.createElement(Input, {
    as: "textarea",
    placeholder: "Message.",
    rows: 4
  }), state.messageSent ? /*#__PURE__*/React.createElement("p", {
    style: {
      margin: '0 0 10px',
      fontSize: 'var(--fs-meta)',
      fontWeight: 'var(--fw-bold)',
      color: 'var(--color-primary)'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: "fas fa-check",
    style: {
      marginRight: '6px'
    }
  }), "Message sent.") : null, /*#__PURE__*/React.createElement(SubmitButton, {
    icon: "fas fa-caret-right"
  }, "SEND MESSAGE NOW"))))));
}
Object.assign(window, {
  HomeScreen
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/website/home.jsx", error: String((e && e.message) || e) }); }

// ui_kits/website/login.jsx
try { (() => {
const NS = window.RaqueDesignSystem_94a18b;
const {
  Input,
  SubmitButton
} = NS;
function LoginModal({
  open,
  onClose,
  onAuth
}) {
  const D = window.GeniusData;
  const [email, setEmail] = React.useState('');
  const [pass, setPass] = React.useState('');
  const [err, setErr] = React.useState('');
  if (!open) return null;
  function submit(e) {
    e.preventDefault();
    if (!email || !pass) {
      setErr('Both fields are required.');
      return;
    }
    setErr('');
    onAuth(email);
    onClose();
  }
  return /*#__PURE__*/React.createElement("div", {
    onClick: onClose,
    style: {
      position: 'fixed',
      inset: 0,
      zIndex: 999,
      background: 'rgba(0,0,0,.7)',
      overflowY: 'auto'
    }
  }, /*#__PURE__*/React.createElement("div", {
    onClick: e => e.stopPropagation(),
    style: {
      maxWidth: '480px',
      margin: '60px auto',
      background: 'var(--genius-white)',
      borderRadius: 'var(--radius)',
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      padding: 'var(--space-35) var(--space-30)',
      textAlign: 'center'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      inset: 0,
      backgroundImage: 'var(--gradient)',
      backgroundSize: 'var(--gradient-size)',
      opacity: 'var(--gradient-opacity)'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      zIndex: 2
    }
  }, /*#__PURE__*/React.createElement("img", {
    src: D.img + '/logo/p-logo.jpg',
    alt: "",
    style: {
      maxHeight: '54px',
      marginBottom: 'var(--space-15)'
    }
  }), /*#__PURE__*/React.createElement("h2", {
    style: {
      fontSize: '28px',
      fontWeight: 'var(--fw-thin)',
      lineHeight: 1.2,
      color: 'var(--genius-white)',
      marginBottom: '6px'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontWeight: 'var(--fw-bold)'
    }
  }, "Login"), " Your Account."), /*#__PURE__*/React.createElement("p", {
    style: {
      margin: 0,
      fontSize: 'var(--fs-meta)',
      color: 'var(--genius-white)'
    }
  }, "Login to our website, or ", /*#__PURE__*/React.createElement("span", {
    style: {
      fontWeight: 'var(--fw-bold)'
    }
  }, "REGISTER"))), /*#__PURE__*/React.createElement("button", {
    onClick: onClose,
    "aria-label": "Close",
    style: {
      position: 'absolute',
      top: '12px',
      right: '12px',
      zIndex: 3,
      width: '32px',
      height: '32px',
      border: 0,
      borderRadius: 'var(--radius)',
      background: 'rgba(255,255,255,.2)',
      color: 'var(--genius-white)',
      cursor: 'pointer',
      fontSize: '16px'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: "fas fa-times"
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: 'var(--space-30)'
    }
  }, /*#__PURE__*/React.createElement("a", {
    href: "#",
    onClick: e => e.preventDefault(),
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 'var(--space-15)',
      marginBottom: 'var(--space-20)',
      padding: '0 var(--space-15)',
      height: 'var(--h-field)',
      borderRadius: 'var(--radius)',
      background: '#3b5998',
      color: 'var(--genius-white)',
      fontSize: 'var(--fs-meta)',
      fontWeight: 'var(--fw-bold)',
      textDecoration: 'none'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: "fab fa-facebook-f"
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      textAlign: 'center'
    }
  }, "Login with Facebook")), /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: 'center',
      marginBottom: 'var(--space-20)',
      fontSize: 'var(--fs-meta)',
      fontWeight: 'var(--fw-bold)',
      color: 'var(--text-muted)'
    }
  }, "OR SIGN IN"), /*#__PURE__*/React.createElement("form", {
    onSubmit: submit
  }, /*#__PURE__*/React.createElement(Input, {
    type: "email",
    placeholder: "Your@email.com*",
    value: email,
    onChange: e => setEmail(e.target.value)
  }), /*#__PURE__*/React.createElement(Input, {
    type: "password",
    placeholder: "Your password*",
    value: pass,
    onChange: e => setPass(e.target.value)
  }), err ? /*#__PURE__*/React.createElement("p", {
    style: {
      margin: '0 0 10px',
      fontSize: 'var(--fs-meta)',
      color: 'var(--color-trend)'
    }
  }, err) : null, /*#__PURE__*/React.createElement(SubmitButton, null, "LOg in Now")), /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: 'center',
      marginTop: 'var(--space-20)'
    }
  }, /*#__PURE__*/React.createElement("p", {
    style: {
      margin: 0,
      fontSize: 'var(--fs-xs)',
      color: 'var(--text-muted)'
    }
  }, "* Denotes mandatory field."), /*#__PURE__*/React.createElement("p", {
    style: {
      margin: 0,
      fontSize: 'var(--fs-xs)',
      color: 'var(--text-muted)'
    }
  }, "** At least one telephone number is required.")))));
}
Object.assign(window, {
  LoginModal
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/website/login.jsx", error: String((e && e.message) || e) }); }

// ui_kits/website/pages.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
const NS = window.RaqueDesignSystem_94a18b;
const {
  Section,
  Grid,
  SectionTitle,
  Em,
  Button,
  SubmitButton,
  Input,
  SearchBar,
  CourseCard,
  BestCourseCard,
  NewsCard,
  TeacherCard,
  ProductCard,
  CategoryTile,
  Tabs,
  Accordion,
  ContactAddress,
  BulletList,
  CounterStrip,
  Badge
} = NS;

/* ---------------- Course index ---------------- */
function CourseScreen({
  go,
  onLogin,
  state,
  actions
}) {
  const D = window.GeniusData;
  const [cat, setCat] = React.useState('ALL');
  const cats = ['ALL'].concat(Array.from(new Set(D.courses.map(c => c.category.toUpperCase()))));
  const q = (state.query || '').toLowerCase();
  const wide = D.courses.filter(c => (cat === 'ALL' || c.category.toUpperCase() === cat) && c.title.toLowerCase().indexOf(q) > -1);
  const grid = D.bestCourses.filter(c => c.title.toLowerCase().indexOf(q) > -1);
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(PageTop, {
    screen: "course",
    go: go,
    onLogin: onLogin,
    eyebrow: "SEARCH OUR COURSES"
  }, "Browse Our", /*#__PURE__*/React.createElement(Em, null, " Best Course.")), /*#__PURE__*/React.createElement(Section, {
    pad: "product"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'center',
      marginBottom: 'var(--space-45)'
    }
  }, /*#__PURE__*/React.createElement(SearchBar, {
    value: state.query,
    onChange: e => actions.setQuery(e.target.value),
    style: {
      width: '100%'
    }
  })), /*#__PURE__*/React.createElement(Tabs, {
    items: cats,
    active: cat,
    onChange: setCat
  }), /*#__PURE__*/React.createElement("p", {
    style: {
      textAlign: 'center',
      marginBottom: 'var(--space-45)',
      fontSize: 'var(--fs-meta)',
      color: 'var(--text-muted)'
    }
  }, wide.length + grid.length, " courses"), wide.length ? /*#__PURE__*/React.createElement(Grid, {
    cols: 3,
    style: {
      marginBottom: 'var(--space-65)'
    }
  }, wide.map((c, i) => /*#__PURE__*/React.createElement(CourseCard, _extends({
    key: i
  }, c, {
    href: "#"
  })))) : null, grid.length ? /*#__PURE__*/React.createElement(Grid, {
    cols: 4
  }, grid.map((c, i) => /*#__PURE__*/React.createElement(BestCourseCard, _extends({
    key: i
  }, c, {
    href: "#"
  })))) : null, !wide.length && !grid.length ? /*#__PURE__*/React.createElement("p", {
    style: {
      textAlign: 'center',
      padding: 'var(--space-45) 0'
    }
  }, "No courses match that search.") : null));
}

/* ---------------- Teacher index ---------------- */
function TeacherScreen({
  go,
  onLogin
}) {
  const D = window.GeniusData;
  const roster = D.teachers.concat(D.teachers.map(function (t, i) {
    return {
      image: t.image,
      name: ['Johanas Doe', 'Juliana Hernandes', 'Berliana Luis', 'Daniel Alvares'][i],
      designation: ['Graphic', 'Web Design', 'IOS App', 'Mobile Apps'][i]
    };
  }));
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(PageTop, {
    screen: "teacher",
    go: go,
    onLogin: onLogin,
    eyebrow: "GENIUS STAFFS"
  }, "Genius ", /*#__PURE__*/React.createElement(Em, null, "Teachers.")), /*#__PURE__*/React.createElement(Section, {
    pad: "teacher"
  }, /*#__PURE__*/React.createElement(Grid, {
    cols: 4
  }, roster.map((t, i) => /*#__PURE__*/React.createElement(TeacherCard, _extends({
    key: i
  }, t, {
    socials: D.socials
  }))))), /*#__PURE__*/React.createElement(Section, {
    image: D.img + '/banner/hb-2.jpg',
    pad: "product",
    overlay: true
  }, /*#__PURE__*/React.createElement(CounterStrip, {
    items: D.counters
  })));
}

/* ---------------- Blog index ---------------- */
function BlogScreen({
  go,
  onLogin
}) {
  const D = window.GeniusData;
  const posts = D.news.concat(D.news).concat(D.news);
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(PageTop, {
    screen: "blog",
    go: go,
    onLogin: onLogin,
    eyebrow: "GENIUS JOURNAL"
  }, "Latest ", /*#__PURE__*/React.createElement(Em, null, "News.")), /*#__PURE__*/React.createElement(Section, {
    pad: "product"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(300px,1fr))',
      gap: 'var(--gutter)'
    }
  }, posts.map((n, i) => /*#__PURE__*/React.createElement(NewsCard, _extends({
    key: i
  }, n, {
    last: true
  }))))));
}

/* ---------------- Shop ---------------- */
function ShopScreen({
  go,
  onLogin,
  state,
  actions
}) {
  const D = window.GeniusData;
  const items = D.products.concat(D.products);
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(PageTop, {
    screen: "shop",
    go: go,
    onLogin: onLogin,
    eyebrow: "GENIUS STORE"
  }, "Genius ", /*#__PURE__*/React.createElement(Em, null, "Best Products.")), /*#__PURE__*/React.createElement(Section, {
    pad: "product"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: '15px',
      flexWrap: 'wrap',
      marginBottom: 'var(--space-45)'
    }
  }, /*#__PURE__*/React.createElement("p", {
    style: {
      margin: 0,
      fontSize: 'var(--fs-meta)',
      color: 'var(--text-muted)'
    }
  }, items.length, " products"), /*#__PURE__*/React.createElement("p", {
    style: {
      margin: 0,
      fontSize: 'var(--fs-meta)',
      fontWeight: 'var(--fw-bold)'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: "fas fa-shopping-bag",
    style: {
      marginRight: '7px',
      color: 'var(--color-primary)'
    }
  }), state.cart, " in cart")), /*#__PURE__*/React.createElement(Grid, {
    cols: 4
  }, items.map((p, i) => /*#__PURE__*/React.createElement(ProductCard, _extends({
    key: i
  }, p, {
    href: "#",
    onClick: actions.addToCart
  }))))));
}

/* ---------------- About ---------------- */
function AboutScreen({
  go,
  onLogin
}) {
  const D = window.GeniusData;
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(PageTop, {
    screen: "about",
    go: go,
    onLogin: onLogin,
    eyebrow: "SORT ABOUT US"
  }, "We are Genius ", /*#__PURE__*/React.createElement(Em, null, "Course.")), /*#__PURE__*/React.createElement(Section, {
    pad: "product"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(320px,1fr))',
      gap: 'var(--space-60)',
      alignItems: 'center'
    }
  }, /*#__PURE__*/React.createElement("img", {
    src: D.about.image,
    alt: "",
    style: {
      display: 'block',
      width: '100%',
      borderRadius: 'var(--radius)'
    }
  }), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(SectionTitle, {
    eyebrow: "SORT ABOUT US"
  }, "We are ", /*#__PURE__*/React.createElement(Em, null, "Genius Course"), " work since 1980."), /*#__PURE__*/React.createElement("p", {
    style: {
      fontSize: 'var(--fs-card-title)',
      fontWeight: 'var(--fw-medium)',
      lineHeight: 'var(--lh-body-lg)',
      color: 'var(--text-heading)',
      marginBottom: 'var(--space-20)'
    }
  }, D.about.lede), /*#__PURE__*/React.createElement("p", {
    style: {
      marginBottom: 'var(--space-30)'
    }
  }, D.about.body), /*#__PURE__*/React.createElement(BulletList, {
    items: D.about.list,
    style: {
      marginBottom: 'var(--space-35)'
    }
  }), /*#__PURE__*/React.createElement(Button, {
    onClick: e => {
      e.preventDefault();
      go('contact');
    },
    href: "#",
    style: {
      marginTop: 0
    }
  }, "contact us")))), /*#__PURE__*/React.createElement(Section, {
    tone: "alt",
    pad: "product"
  }, /*#__PURE__*/React.createElement(SectionTitle, {
    eyebrow: "GENIUS CATEGORIES"
  }, "Browse ", /*#__PURE__*/React.createElement(Em, null, "By Category.")), /*#__PURE__*/React.createElement(Grid, {
    cols: 4
  }, D.categories.map((c, i) => /*#__PURE__*/React.createElement(CategoryTile, _extends({
    key: i
  }, c, {
    href: "#"
  }))))), /*#__PURE__*/React.createElement(SponsorStrip, null));
}

/* ---------------- FAQ ---------------- */
function FaqScreen({
  go,
  onLogin,
  state,
  actions
}) {
  const D = window.GeniusData;
  const [tab, setTab] = React.useState(D.faq.tabs[0]);
  const [open, setOpen] = React.useState(0);
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(PageTop, {
    screen: "faq",
    go: go,
    onLogin: onLogin,
    eyebrow: "GENIUS COURSE FAQ"
  }, "Frequently", /*#__PURE__*/React.createElement(Em, null, " Ask & Questions")), /*#__PURE__*/React.createElement(Section, {
    pad: "faq"
  }, /*#__PURE__*/React.createElement(Tabs, {
    items: D.faq.tabs,
    active: tab,
    onChange: t => {
      setTab(t);
      setOpen(0);
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: '760px',
      margin: '0 auto'
    }
  }, /*#__PURE__*/React.createElement(Accordion, {
    key: tab,
    tone: "dark",
    items: D.faq.questions.map(q => ({
      question: q,
      answer: D.faq.answer
    })),
    openIndex: open,
    onToggle: setOpen
  }))), /*#__PURE__*/React.createElement(Section, {
    tone: "alt",
    pad: "product"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: '560px',
      margin: '0 auto'
    }
  }, /*#__PURE__*/React.createElement(SectionTitle, {
    align: "center"
  }, "Make a ", /*#__PURE__*/React.createElement(Em, null, "Question")), /*#__PURE__*/React.createElement("form", {
    onSubmit: e => {
      e.preventDefault();
      actions.sendMessage();
    }
  }, /*#__PURE__*/React.createElement(Input, {
    placeholder: "Name.",
    required: true
  }), /*#__PURE__*/React.createElement(Input, {
    type: "email",
    placeholder: "Email.",
    required: true
  }), /*#__PURE__*/React.createElement(Input, {
    as: "textarea",
    placeholder: "Your question.",
    rows: 4
  }), state.messageSent ? /*#__PURE__*/React.createElement("p", {
    style: {
      margin: '0 0 10px',
      fontSize: 'var(--fs-meta)',
      fontWeight: 'var(--fw-bold)',
      color: 'var(--color-primary)'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: "fas fa-check",
    style: {
      marginRight: '6px'
    }
  }), "Question sent.") : null, /*#__PURE__*/React.createElement(SubmitButton, {
    icon: "fas fa-caret-right"
  }, "SEND MESSAGE NOW")))));
}

/* ---------------- Contact ---------------- */
function ContactScreen({
  go,
  onLogin,
  state,
  actions
}) {
  const D = window.GeniusData;
  return /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(PageTop, {
    screen: "contact",
    go: go,
    onLogin: onLogin,
    eyebrow: "CONTACT US"
  }, /*#__PURE__*/React.createElement(Em, null, "Get in Touch")), /*#__PURE__*/React.createElement(Section, {
    pad: "product"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit,minmax(300px,1fr))',
      gap: 'var(--space-60)'
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement(SectionTitle, {
    eyebrow: "CONTACT US"
  }, /*#__PURE__*/React.createElement(Em, null, "Get in Touch")), /*#__PURE__*/React.createElement("p", {
    style: {
      marginBottom: 'var(--space-35)'
    }
  }, "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet ipsum dolor sit amet, consectetuer adipiscing elit."), /*#__PURE__*/React.createElement(ContactAddress, {
    items: D.contact
  })), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("h3", {
    style: {
      fontSize: 'var(--fs-h4)',
      fontWeight: 'var(--fw-medium)',
      marginBottom: 'var(--space-20)'
    }
  }, "Send Us a message"), /*#__PURE__*/React.createElement("form", {
    onSubmit: e => {
      e.preventDefault();
      actions.sendMessage();
    }
  }, /*#__PURE__*/React.createElement(Input, {
    placeholder: "Name.",
    required: true
  }), /*#__PURE__*/React.createElement(Input, {
    type: "email",
    placeholder: "Email.",
    required: true
  }), /*#__PURE__*/React.createElement(Input, {
    placeholder: "Subject."
  }), /*#__PURE__*/React.createElement(Input, {
    as: "textarea",
    placeholder: "Message.",
    rows: 4
  }), state.messageSent ? /*#__PURE__*/React.createElement("p", {
    style: {
      margin: '0 0 10px',
      fontSize: 'var(--fs-meta)',
      fontWeight: 'var(--fw-bold)',
      color: 'var(--color-primary)'
    }
  }, /*#__PURE__*/React.createElement("i", {
    className: "fas fa-check",
    style: {
      marginRight: '6px'
    }
  }), "Message sent.") : null, /*#__PURE__*/React.createElement(SubmitButton, {
    icon: "fas fa-caret-right"
  }, "SEND MESSAGE NOW"))))));
}
Object.assign(window, {
  CourseScreen,
  TeacherScreen,
  BlogScreen,
  ShopScreen,
  AboutScreen,
  FaqScreen,
  ContactScreen
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/website/pages.jsx", error: String((e && e.message) || e) }); }

// ui_kits/website/shell.jsx
try { (() => {
const NS = window.RaqueDesignSystem_94a18b;
const {
  SiteHeader,
  SiteFooter,
  HeroSlide,
  Section,
  Em,
  Modal
} = NS;
function Shell({
  screen,
  go,
  onLogin,
  children
}) {
  const D = window.GeniusData;
  const active = {
    home: 'Home',
    about: 'About Us',
    shop: 'shop',
    contact: 'Contact Us',
    course: 'Pages',
    teacher: 'Pages',
    blog: 'Pages',
    faq: 'Pages'
  }[screen];
  return /*#__PURE__*/React.createElement("div", null, children, /*#__PURE__*/React.createElement(SiteFooter, {
    logo: D.img + '/logo/logo.png',
    brand: "Genius",
    image: D.img + '/banner/bt.png',
    blurb: D.footer.blurb,
    socials: D.socials,
    legal: D.footer.legal,
    copyright: D.footer.copyright
  }));
}

/* The header always overlays a coloured ground, so every screen opens with one of these two.
   Place bold runs with <Em>, as the source does. */
function PageTop({
  children,
  eyebrow,
  screen,
  go,
  onLogin,
  image,
  minHeight = 430
}) {
  const D = window.GeniusData;
  const {
    SiteHeader,
    HeroSlide,
    HeroTitle,
    Em
  } = NS;
  return /*#__PURE__*/React.createElement(HeroSlide, {
    image: image || D.img + '/banner/hb-2.jpg',
    minHeight: minHeight
  }, /*#__PURE__*/React.createElement(SiteHeader, {
    logo: D.img + '/logo/logo.png',
    brand: "Genius",
    items: D.nav,
    active: {
      home: 'Home',
      about: 'About Us',
      shop: 'shop',
      contact: 'Contact Us',
      course: 'Pages',
      teacher: 'Pages',
      blog: 'Pages',
      faq: 'Pages'
    }[screen],
    onSelect: it => go(it.screen || 'home'),
    onLogin: onLogin
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 'var(--container)',
      margin: '0 auto',
      padding: '90px 15px 100px'
    }
  }, /*#__PURE__*/React.createElement(HeroTitle, {
    size: "compact",
    eyebrow: eyebrow
  }, children)));
}
function SponsorStrip() {
  const D = window.GeniusData;
  const {
    Section
  } = NS;
  return /*#__PURE__*/React.createElement(Section, {
    pad: "sponsor"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: '10px',
      flexWrap: 'wrap'
    }
  }, D.sponsors.map((s, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      position: 'relative',
      textAlign: 'center',
      padding: '0 10px',
      borderRight: i < D.sponsors.length - 1 ? '1px solid var(--border-default)' : 0
    }
  }, /*#__PURE__*/React.createElement("img", {
    src: s,
    alt: "",
    style: {
      maxWidth: '150px',
      display: 'block'
    }
  })))));
}
Object.assign(window, {
  Shell,
  PageTop,
  SponsorStrip
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/website/shell.jsx", error: String((e && e.message) || e) }); }

__ds_ns.BestCourseCard = __ds_scope.BestCourseCard;

__ds_ns.CategoryTile = __ds_scope.CategoryTile;

__ds_ns.CourseCard = __ds_scope.CourseCard;

__ds_ns.EventCard = __ds_scope.EventCard;

__ds_ns.NewsCard = __ds_scope.NewsCard;

__ds_ns.ProductCard = __ds_scope.ProductCard;

__ds_ns.TeacherCard = __ds_scope.TeacherCard;

__ds_ns.TestimonialSlide = __ds_scope.TestimonialSlide;

__ds_ns.Badge = __ds_scope.Badge;

__ds_ns.BulletList = __ds_scope.BulletList;

__ds_ns.Button = __ds_scope.Button;

__ds_ns.HeroTitle = __ds_scope.HeroTitle;

__ds_ns.Input = __ds_scope.Input;

__ds_ns.MetaLine = __ds_scope.MetaLine;

__ds_ns.Rating = __ds_scope.Rating;

__ds_ns.Em = __ds_scope.Em;

__ds_ns.SectionTitle = __ds_scope.SectionTitle;

__ds_ns.SubmitButton = __ds_scope.SubmitButton;

__ds_ns.Accordion = __ds_scope.Accordion;

__ds_ns.ContactAddress = __ds_scope.ContactAddress;

__ds_ns.CounterStrip = __ds_scope.CounterStrip;

__ds_ns.HeroSlide = __ds_scope.HeroSlide;

__ds_ns.SearchBar = __ds_scope.SearchBar;

__ds_ns.Section = __ds_scope.Section;

__ds_ns.Grid = __ds_scope.Grid;

__ds_ns.SiteFooter = __ds_scope.SiteFooter;

__ds_ns.SiteHeader = __ds_scope.SiteHeader;

__ds_ns.Tabs = __ds_scope.Tabs;

})();
