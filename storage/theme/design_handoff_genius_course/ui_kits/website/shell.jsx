const NS = window.RaqueDesignSystem_94a18b;
const { SiteHeader, SiteFooter, HeroSlide, Section, Em, Modal } = NS;

function Shell({ screen, go, onLogin, children }) {
  const D = window.GeniusData;
  const active = {
    home: 'Home', about: 'About Us', shop: 'shop', contact: 'Contact Us',
    course: 'Pages', teacher: 'Pages', blog: 'Pages', faq: 'Pages'
  }[screen];

  return (
    <div>
      {children}
      <SiteFooter
        logo={D.img + '/logo/logo.png'}
        brand="Genius"
        image={D.img + '/banner/bt.png'}
        blurb={D.footer.blurb}
        socials={D.socials}
        legal={D.footer.legal}
        copyright={D.footer.copyright}
      />
    </div>
  );
}

/* The header always overlays a coloured ground, so every screen opens with one of these two.
   Place bold runs with <Em>, as the source does. */
function PageTop({ children, eyebrow, screen, go, onLogin, image, minHeight = 430 }) {
  const D = window.GeniusData;
  const { SiteHeader, HeroSlide, HeroTitle, Em } = NS;
  return (
    <HeroSlide image={image || (D.img + '/banner/hb-2.jpg')} minHeight={minHeight}>
      <SiteHeader logo={D.img + '/logo/logo.png'} brand="Genius"
        items={D.nav} active={{
          home: 'Home', about: 'About Us', shop: 'shop', contact: 'Contact Us',
          course: 'Pages', teacher: 'Pages', blog: 'Pages', faq: 'Pages'
        }[screen]}
        onSelect={(it) => go(it.screen || 'home')} onLogin={onLogin} />
      <div style={{ maxWidth: 'var(--container)', margin: '0 auto', padding: '90px 15px 100px' }}>
        <HeroTitle size="compact" eyebrow={eyebrow}>{children}</HeroTitle>
      </div>
    </HeroSlide>
  );
}

function SponsorStrip() {
  const D = window.GeniusData;
  const { Section } = NS;
  return (
    <Section pad="sponsor">
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: '10px', flexWrap: 'wrap' }}>
        {D.sponsors.map((s, i) => (
          <div key={i} style={{
            position: 'relative', textAlign: 'center', padding: '0 10px',
            borderRight: i < D.sponsors.length - 1 ? '1px solid var(--border-default)' : 0
          }}>
            <img src={s} alt="" style={{ maxWidth: '150px', display: 'block' }} />
          </div>
        ))}
      </div>
    </Section>
  );
}

Object.assign(window, { Shell, PageTop, SponsorStrip });
