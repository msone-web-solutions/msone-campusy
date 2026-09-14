const NS = window.RaqueDesignSystem_94a18b;
const {
  Section, Grid, SectionTitle, Em, Button, SubmitButton, Input, SearchBar,
  CourseCard, BestCourseCard, NewsCard, TeacherCard, ProductCard, CategoryTile,
  Tabs, Accordion, ContactAddress, BulletList, CounterStrip, Badge
} = NS;

/* ---------------- Course index ---------------- */
function CourseScreen({ go, onLogin, state, actions }) {
  const D = window.GeniusData;
  const [cat, setCat] = React.useState('ALL');
  const cats = ['ALL'].concat(Array.from(new Set(D.courses.map((c) => c.category.toUpperCase()))));
  const q = (state.query || '').toLowerCase();

  const wide = D.courses.filter((c) =>
    (cat === 'ALL' || c.category.toUpperCase() === cat) && c.title.toLowerCase().indexOf(q) > -1);
  const grid = D.bestCourses.filter((c) => c.title.toLowerCase().indexOf(q) > -1);

  return (
    <div>
      <PageTop screen="course" go={go} onLogin={onLogin}
        eyebrow="SEARCH OUR COURSES">Browse Our<Em> Best Course.</Em></PageTop>

      <Section pad="product">
        <div style={{ display: 'flex', justifyContent: 'center', marginBottom: 'var(--space-45)' }}>
          <SearchBar value={state.query} onChange={(e) => actions.setQuery(e.target.value)}
            style={{ width: '100%' }} />
        </div>

        <Tabs items={cats} active={cat} onChange={setCat} />

        <p style={{ textAlign: 'center', marginBottom: 'var(--space-45)', fontSize: 'var(--fs-meta)', color: 'var(--text-muted)' }}>
          {wide.length + grid.length} courses
        </p>

        {wide.length ? (
          <Grid cols={3} style={{ marginBottom: 'var(--space-65)' }}>
            {wide.map((c, i) => <CourseCard key={i} {...c} href="#" />)}
          </Grid>
        ) : null}

        {grid.length ? (
          <Grid cols={4}>
            {grid.map((c, i) => <BestCourseCard key={i} {...c} href="#" />)}
          </Grid>
        ) : null}

        {!wide.length && !grid.length ? (
          <p style={{ textAlign: 'center', padding: 'var(--space-45) 0' }}>No courses match that search.</p>
        ) : null}
      </Section>
    </div>
  );
}

/* ---------------- Teacher index ---------------- */
function TeacherScreen({ go, onLogin }) {
  const D = window.GeniusData;
  const roster = D.teachers.concat(D.teachers.map(function (t, i) {
    return { image: t.image, name: ['Johanas Doe', 'Juliana Hernandes', 'Berliana Luis', 'Daniel Alvares'][i], designation: ['Graphic', 'Web Design', 'IOS App', 'Mobile Apps'][i] };
  }));
  return (
    <div>
      <PageTop screen="teacher" go={go} onLogin={onLogin}
        eyebrow="GENIUS STAFFS">Genius <Em>Teachers.</Em></PageTop>
      <Section pad="teacher">
        <Grid cols={4}>
          {roster.map((t, i) => <TeacherCard key={i} {...t} socials={D.socials} />)}
        </Grid>
      </Section>
      <Section image={D.img + '/banner/hb-2.jpg'} pad="product" overlay>
        <CounterStrip items={D.counters} />
      </Section>
    </div>
  );
}

/* ---------------- Blog index ---------------- */
function BlogScreen({ go, onLogin }) {
  const D = window.GeniusData;
  const posts = D.news.concat(D.news).concat(D.news);
  return (
    <div>
      <PageTop screen="blog" go={go} onLogin={onLogin}
        eyebrow="GENIUS JOURNAL">Latest <Em>News.</Em></PageTop>
      <Section pad="product">
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit,minmax(300px,1fr))', gap: 'var(--gutter)' }}>
          {posts.map((n, i) => <NewsCard key={i} {...n} last />)}
        </div>
      </Section>
    </div>
  );
}

/* ---------------- Shop ---------------- */
function ShopScreen({ go, onLogin, state, actions }) {
  const D = window.GeniusData;
  const items = D.products.concat(D.products);
  return (
    <div>
      <PageTop screen="shop" go={go} onLogin={onLogin}
        eyebrow="GENIUS STORE">Genius <Em>Best Products.</Em></PageTop>
      <Section pad="product">
        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: '15px', flexWrap: 'wrap', marginBottom: 'var(--space-45)' }}>
          <p style={{ margin: 0, fontSize: 'var(--fs-meta)', color: 'var(--text-muted)' }}>{items.length} products</p>
          <p style={{ margin: 0, fontSize: 'var(--fs-meta)', fontWeight: 'var(--fw-bold)' }}>
            <i className="fas fa-shopping-bag" style={{ marginRight: '7px', color: 'var(--color-primary)' }} />
            {state.cart} in cart
          </p>
        </div>
        <Grid cols={4}>
          {items.map((p, i) => (
            <ProductCard key={i} {...p} href="#" onClick={actions.addToCart} />
          ))}
        </Grid>
      </Section>
    </div>
  );
}

/* ---------------- About ---------------- */
function AboutScreen({ go, onLogin }) {
  const D = window.GeniusData;
  return (
    <div>
      <PageTop screen="about" go={go} onLogin={onLogin}
        eyebrow="SORT ABOUT US">We are Genius <Em>Course.</Em></PageTop>

      <Section pad="product">
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit,minmax(320px,1fr))', gap: 'var(--space-60)', alignItems: 'center' }}>
          <img src={D.about.image} alt="" style={{ display: 'block', width: '100%', borderRadius: 'var(--radius)' }} />
          <div>
            <SectionTitle eyebrow="SORT ABOUT US">We are <Em>Genius Course</Em> work since 1980.</SectionTitle>
            <p style={{ fontSize: 'var(--fs-card-title)', fontWeight: 'var(--fw-medium)', lineHeight: 'var(--lh-body-lg)', color: 'var(--text-heading)', marginBottom: 'var(--space-20)' }}>
              {D.about.lede}
            </p>
            <p style={{ marginBottom: 'var(--space-30)' }}>{D.about.body}</p>
            <BulletList items={D.about.list} style={{ marginBottom: 'var(--space-35)' }} />
            <Button onClick={(e) => { e.preventDefault(); go('contact'); }} href="#" style={{ marginTop: 0 }}>contact us</Button>
          </div>
        </div>
      </Section>

      <Section tone="alt" pad="product">
        <SectionTitle eyebrow="GENIUS CATEGORIES">Browse <Em>By Category.</Em></SectionTitle>
        <Grid cols={4}>
          {D.categories.map((c, i) => <CategoryTile key={i} {...c} href="#" />)}
        </Grid>
      </Section>

      <SponsorStrip />
    </div>
  );
}

/* ---------------- FAQ ---------------- */
function FaqScreen({ go, onLogin, state, actions }) {
  const D = window.GeniusData;
  const [tab, setTab] = React.useState(D.faq.tabs[0]);
  const [open, setOpen] = React.useState(0);
  return (
    <div>
      <PageTop screen="faq" go={go} onLogin={onLogin}
        eyebrow="GENIUS COURSE FAQ">Frequently<Em> Ask &amp; Questions</Em></PageTop>

      <Section pad="faq">
        <Tabs items={D.faq.tabs} active={tab} onChange={(t) => { setTab(t); setOpen(0); }} />
        <div style={{ maxWidth: '760px', margin: '0 auto' }}>
          <Accordion key={tab} tone="dark"
            items={D.faq.questions.map((q) => ({ question: q, answer: D.faq.answer }))}
            openIndex={open} onToggle={setOpen} />
        </div>
      </Section>

      <Section tone="alt" pad="product">
        <div style={{ maxWidth: '560px', margin: '0 auto' }}>
          <SectionTitle align="center">Make a <Em>Question</Em></SectionTitle>
          <form onSubmit={(e) => { e.preventDefault(); actions.sendMessage(); }}>
            <Input placeholder="Name." required />
            <Input type="email" placeholder="Email." required />
            <Input as="textarea" placeholder="Your question." rows={4} />
            {state.messageSent ? (
              <p style={{ margin: '0 0 10px', fontSize: 'var(--fs-meta)', fontWeight: 'var(--fw-bold)', color: 'var(--color-primary)' }}>
                <i className="fas fa-check" style={{ marginRight: '6px' }} />Question sent.
              </p>
            ) : null}
            <SubmitButton icon="fas fa-caret-right">SEND MESSAGE NOW</SubmitButton>
          </form>
        </div>
      </Section>
    </div>
  );
}

/* ---------------- Contact ---------------- */
function ContactScreen({ go, onLogin, state, actions }) {
  const D = window.GeniusData;
  return (
    <div>
      <PageTop screen="contact" go={go} onLogin={onLogin}
        eyebrow="CONTACT US"><Em>Get in Touch</Em></PageTop>
      <Section pad="product">
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit,minmax(300px,1fr))', gap: 'var(--space-60)' }}>
          <div>
            <SectionTitle eyebrow="CONTACT US"><Em>Get in Touch</Em></SectionTitle>
            <p style={{ marginBottom: 'var(--space-35)' }}>
              Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet ipsum dolor sit amet, consectetuer adipiscing elit.
            </p>
            <ContactAddress items={D.contact} />
          </div>
          <div>
            <h3 style={{ fontSize: 'var(--fs-h4)', fontWeight: 'var(--fw-medium)', marginBottom: 'var(--space-20)' }}>Send Us a message</h3>
            <form onSubmit={(e) => { e.preventDefault(); actions.sendMessage(); }}>
              <Input placeholder="Name." required />
              <Input type="email" placeholder="Email." required />
              <Input placeholder="Subject." />
              <Input as="textarea" placeholder="Message." rows={4} />
              {state.messageSent ? (
                <p style={{ margin: '0 0 10px', fontSize: 'var(--fs-meta)', fontWeight: 'var(--fw-bold)', color: 'var(--color-primary)' }}>
                  <i className="fas fa-check" style={{ marginRight: '6px' }} />Message sent.
                </p>
              ) : null}
              <SubmitButton icon="fas fa-caret-right">SEND MESSAGE NOW</SubmitButton>
            </form>
          </div>
        </div>
      </Section>
    </div>
  );
}

Object.assign(window, { CourseScreen, TeacherScreen, BlogScreen, ShopScreen, AboutScreen, FaqScreen, ContactScreen });
