const NS = window.RaqueDesignSystem_94a18b;
const {
  SiteHeader, HeroSlide, HeroTitle, Section, Grid, SectionTitle, Em, Button, SubmitButton, Input,
  SearchBar, CourseCard, BestCourseCard, NewsCard, EventCard, ProductCard, TeacherCard,
  CategoryTile, TestimonialSlide, CounterStrip, Tabs, Accordion, ContactAddress, BulletList
} = NS;

function HomeScreen({ go, onLogin, state, actions }) {
  const D = window.GeniusData;
  const [faqTab, setFaqTab] = React.useState(D.faq.tabs[0]);
  const [testi, setTesti] = React.useState(0);
  const [openFaq, setOpenFaq] = React.useState(0);

  return (
    <div>
      {/* ---- hero with overlaid header ---- */}
      <HeroSlide image={D.img + '/banner/sd-1.jpg'} minHeight={760} background="#0d6fb8">
        <SiteHeader logo={D.img + '/logo/logo.png'} brand="Genius"
          items={D.nav} active="Home"
          onSelect={(it) => go(it.screen || 'home')} onLogin={onLogin} />
        <div style={{ maxWidth: 'var(--container)', margin: '0 auto', padding: '130px 15px 150px' }}>
          <HeroTitle eyebrow="EDUCATION & TRAINING ORGANIZATION" indent>
            <Em>Inventive</Em> Solution<br /> for <Em>Education</Em>
          </HeroTitle>
          <div style={{ marginTop: 'var(--space-35)' }}>
            <Button variant="outline" onClick={(e) => { e.preventDefault(); go('course'); }} href="#">Our Courses</Button>
          </div>
        </div>
      </HeroSlide>

      <SponsorStrip />

      {/* ---- popular courses ---- */}
      <Section pad="product">
        <SectionTitle eyebrow="LEARN NEW SKILLS"><Em>Popular</Em> Courses.</SectionTitle>
        <Grid cols={3}>
          {D.courses.map((c, i) => (
            <CourseCard key={i} {...c} href="#"
              onClick={() => go('course')} />
          ))}
        </Grid>
      </Section>

      {/* ---- about + registration form ---- */}
      <Section tone="alt">
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit,minmax(320px,1fr))', gap: 'var(--space-60)', alignItems: 'center' }}>
          <div>
            <SectionTitle eyebrow="SORT ABOUT US">We are <Em>Genius Course</Em> work since 1980.</SectionTitle>
            <p style={{ fontSize: 'var(--fs-card-title)', fontWeight: 'var(--fw-medium)', lineHeight: 'var(--lh-body-lg)', color: 'var(--text-heading)', marginBottom: 'var(--space-20)' }}>
              {D.about.lede}
            </p>
            <p style={{ marginBottom: 'var(--space-30)' }}>{D.about.body}</p>
            <BulletList items={D.about.list} style={{ marginBottom: 'var(--space-35)' }} />
            <div style={{ display: 'flex', gap: 'var(--space-15)', flexWrap: 'wrap' }}>
              <Button onClick={(e) => { e.preventDefault(); go('about'); }} href="#" style={{ marginTop: 0 }}>About Us</Button>
              <Button variant="outline" onClick={(e) => { e.preventDefault(); go('contact'); }} href="#" style={{ marginTop: 0 }}>contact us</Button>
            </div>
          </div>

          <div style={{
            padding: 'var(--space-35)',
            borderRadius: 'var(--radius)',
            background: 'var(--surface-page)'
          }}>
            <div style={{ textAlign: 'center', marginBottom: 'var(--space-25)' }}>
              <h3 style={{ fontSize: 'var(--fs-h4)', fontWeight: 'var(--fw-medium)', marginBottom: '6px' }}>Get a Free Registration.</h3>
              <p style={{ margin: 0, fontSize: 'var(--fs-meta)' }}>More Than 122K Online Available Courses</p>
            </div>
            <form onSubmit={(e) => { e.preventDefault(); actions.register(); }}>
              <Input placeholder="Your Name*" required />
              <Input type="email" placeholder="Your@email.com*" required />
              <Input as="select" defaultValue="">
                <option value="" disabled>Select Course.</option>
                <option>Web Design</option>
                <option>Web Development</option>
                <option>Php Core</option>
              </Input>
              {state.registered ? (
                <p style={{ margin: '0 0 10px', fontSize: 'var(--fs-meta)', fontWeight: 'var(--fw-bold)', color: 'var(--color-primary)' }}>
                  <i className="fas fa-check" style={{ marginRight: '6px' }} />Request received.
                </p>
              ) : null}
              <SubmitButton>SUBMIT REQUEST</SubmitButton>
            </form>
          </div>
        </div>
      </Section>

      {/* ---- search + counters over a photo ---- */}
      <Section image={D.img + '/banner/hb-2.jpg'} pad="product" overlay>
        <SectionTitle align="center" tone="light" eyebrow="LEARN NEW SKILLS"><Em>Search</Em> Genius Courses.</SectionTitle>
        <div style={{ display: 'flex', justifyContent: 'center', marginBottom: 'var(--space-60)' }}>
          <SearchBar value={state.query} onChange={(e) => actions.setQuery(e.target.value)}
            onSubmit={() => go('course')} style={{ width: '100%' }} />
        </div>
        <CounterStrip items={D.counters} />

        {/* the app block lives inside this same band in the source, not in its own section */}
        <div style={{
          display: 'grid', gridTemplateColumns: 'repeat(auto-fit,minmax(300px,1fr))',
          gap: 'var(--space-60)', alignItems: 'center', marginTop: 'var(--space-65)'
        }}>
          <img src={D.app.image} alt="" style={{ display: 'block', width: '100%' }} />
          <div>
            <SectionTitle tone="light"><Em>Download</Em> Genius Application on <Em>PlayStore.</Em></SectionTitle>
            <p style={{ marginBottom: 'var(--space-25)', color: 'var(--genius-white)' }}>
              Introduction Genius Mobile Application on Play Store lorem ipsum dolor sit amet consectuerer adipiscing.
            </p>
            <BulletList items={D.app.list} style={{ marginBottom: 'var(--space-30)' }} tone="light" />
            <div style={{ display: 'flex', gap: 'var(--space-20)', alignItems: 'center', flexWrap: 'wrap' }}>
              <Button icon={null} href="#" style={{ marginTop: 0 }}>GET THE APP NOW</Button>
              <ul style={{ display: 'flex', gap: 'var(--space-15)', fontSize: '22px', color: 'var(--genius-white)' }}>
                <li><a href="#" aria-label="App Store"><i className="fab fa-apple" /></a></li>
                <li><a href="#" aria-label="Play Store"><i className="fab fa-android" /></a></li>
                <li><a href="#" aria-label="Windows"><i className="fab fa-windows" /></a></li>
              </ul>
            </div>
          </div>
        </div>
      </Section>

      {/* ---- latest: news / events / video ---- */}
      <Section tone="alt" pad="product">
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit,minmax(280px,1fr))', gap: 'var(--gutter)' }}>
          <div>
            <SectionTitle>Latest <Em>News.</Em></SectionTitle>
            {D.news.map((n, i) => (
              <NewsCard key={i} {...n} last={i === D.news.length - 1}
                onClick={() => go('blog')} />
            ))}
            <a href="#" onClick={(e) => { e.preventDefault(); go('blog'); }}
              style={{ fontWeight: 'var(--fw-bold)', color: 'var(--text-heading)' }}>View All News</a>
          </div>

          <div>
            <SectionTitle>Upcoming <Em>Events.</Em></SectionTitle>
            {D.events.map((ev, i) => <EventCard key={i} {...ev} />)}
            <a href="#" onClick={(e) => e.preventDefault()}
              style={{ fontWeight: 'var(--fw-bold)', color: 'var(--text-heading)' }}>Check Calendar</a>
          </div>

          <div>
            <SectionTitle>Latest <Em>Video.</Em></SectionTitle>
            <div style={{ position: 'relative', marginBottom: 'var(--space-20)' }}>
              <img src={D.img + '/banner/v-1.jpg'} alt="" style={{ display: 'block', width: '100%', borderRadius: 'var(--radius)' }} />
              <a href="https://www.youtube.com/watch?v=-g4TnixUdSc" target="_blank" rel="noreferrer"
                aria-label="Play video"
                style={{
                  position: 'absolute', top: '50%', left: '50%', transform: 'translate(-50%,-50%)',
                  width: 'var(--h-circle)', height: 'var(--h-circle)', lineHeight: 'var(--lh-circle)',
                  borderRadius: 'var(--radius-circle)', textAlign: 'center',
                  backgroundImage: 'var(--gradient)', backgroundSize: 'var(--gradient-size)',
                  color: 'var(--genius-white)'
                }}><i className="fas fa-play" /></a>
            </div>
            <h3 style={{ fontSize: 'var(--fs-title-sm)', fontWeight: 'var(--fw-bold)', lineHeight: '21.6px', marginBottom: 'var(--space-10)' }}>
              <a href="#" onClick={(e) => e.preventDefault()}>Learning IOS Apps in Amsterdam.</a>
            </h3>
            <p style={{ marginBottom: 'var(--space-15)' }}>Lorem ipsum dolor sit amet, consectetuer delacosta adipiscing elit, sed diam nonummy.</p>
            <a href="#" onClick={(e) => e.preventDefault()}
              style={{ fontWeight: 'var(--fw-bold)', color: 'var(--text-heading)' }}>View All Videos</a>
          </div>
        </div>
      </Section>

      {/* ---- products ---- */}
      <Section pad="product">
        <SectionTitle>Genius <Em>Best Products.</Em></SectionTitle>
        <Grid cols={4}>
          {D.products.map((p, i) => (
            <ProductCard key={i} {...p} href="#"
              onClick={() => go('shop')} />
          ))}
        </Grid>
      </Section>

      {/* ---- best courses ---- */}
      <Section tone="alt" pad="product">
        <SectionTitle align="center" eyebrow="SEARCH OUR COURSES">Browse Our<Em> Best Course.</Em></SectionTitle>
        <Grid cols={4}>
          {D.bestCourses.slice(0, 8).map((c, i) => (
            <BestCourseCard key={i} {...c} href="#" onClick={() => go('course')} />
          ))}
        </Grid>
      </Section>

      {/* ---- FAQ over a photo ---- */}
      <Section image={D.img + '/banner/fq-1.jpg'} pad="faq" overlay>
        <SectionTitle align="center" tone="light" eyebrow="GENIUS COURSE FAQ">Frequently<Em> Ask &amp; Questions</Em></SectionTitle>
        <Tabs items={D.faq.tabs} active={faqTab} onChange={setFaqTab} />
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit,minmax(280px,1fr))', gap: 'var(--space-45)' }}>
          {[0, 1].map((col) => (
            <Accordion key={col + faqTab}
              items={D.faq.questions.slice(col * 2, col * 2 + 2).map((q) => ({ question: q, answer: D.faq.answer }))}
              openIndex={col === 0 ? openFaq : -1}
              onToggle={col === 0 ? setOpenFaq : undefined}
            />
          ))}
        </div>
        <div style={{ display: 'flex', gap: 'var(--space-15)', justifyContent: 'center', flexWrap: 'wrap' }}>
          <Button variant="onDark" onClick={(e) => { e.preventDefault(); go('faq'); }} href="#">Make Question</Button>
          <Button variant="onDark" onClick={(e) => { e.preventDefault(); go('contact'); }} href="#">contact us</Button>
        </div>
      </Section>

      {/* ---- categories ---- */}
      <Section pad="product">
        <SectionTitle eyebrow="GENIUS CATEGORIES">Browse <Em>By Category.</Em></SectionTitle>
        <Grid cols={4}>
          {D.categories.map((c, i) => (
            <CategoryTile key={i} {...c} href="#"
              onClick={(e) => { e.preventDefault(); go('course'); }} />
          ))}
        </Grid>
      </Section>

      {/* ---- testimonials ---- */}
      <Section tone="alt" pad="product">
        <SectionTitle align="center" eyebrow="WHAT THEY SAY ABOUT US">Students <Em>Testimonial.</Em></SectionTitle>
        <TestimonialSlide
          quote="“This was our first time lorem ipsum and we "
          emphasis="were very pleased with the whole experience"
          tail=". Your price was lower than other companies. Our experience so we’ll be back in the future lorem ipsum diamet.”"
          name={D.testimonials[testi].name}
          designation={D.testimonials[testi].designation}
        />
        <div style={{ display: 'flex', justifyContent: 'center', gap: '8px', marginTop: 'var(--space-45)' }}>
          {D.testimonials.map((_, i) => (
            <button key={i} onClick={() => setTesti(i)} aria-label={'Testimonial ' + (i + 1)}
              style={{
                width: '10px', height: '10px', padding: 0, border: 0,
                borderRadius: 'var(--radius-circle)', cursor: 'pointer',
                background: i === testi ? 'var(--color-primary)' : 'var(--border-default)',
                transition: 'var(--transition)'
              }} />
          ))}
        </div>
      </Section>

      {/* ---- teachers ---- */}
      <Section pad="teacher">
        <SectionTitle eyebrow="GENIUS STAFFS">Genius <Em>Teachers.</Em></SectionTitle>
        <Grid cols={4}>
          {D.teachers.map((t, i) => <TeacherCard key={i} {...t} socials={D.socials} />)}
        </Grid>
        <div style={{ marginTop: 'var(--space-45)' }}>
          <Button onClick={(e) => { e.preventDefault(); go('teacher'); }} href="#">All teacher</Button>
        </div>
      </Section>

      {/* ---- contact ---- */}
      <Section tone="alt" pad="product">
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit,minmax(300px,1fr))', gap: 'var(--space-60)' }}>
          <div>
            <SectionTitle eyebrow="CONTACT US"><Em>Get in Touch</Em></SectionTitle>
            <p style={{ marginBottom: 'var(--space-35)' }}>
              Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet ipsum dolor sit amet.
            </p>
            <ContactAddress items={D.contact} />
          </div>
          <div>
            <h3 style={{ fontSize: 'var(--fs-h4)', fontWeight: 'var(--fw-medium)', marginBottom: 'var(--space-20)' }}>Send Us a message</h3>
            <form onSubmit={(e) => { e.preventDefault(); actions.sendMessage(); }}>
              <Input placeholder="Name." required />
              <Input type="email" placeholder="Email." required />
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

Object.assign(window, { HomeScreen });
