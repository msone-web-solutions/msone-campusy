const NS = window.RaqueDesignSystem_94a18b;
const { Input, SubmitButton } = NS;

function LoginModal({ open, onClose, onAuth }) {
  const D = window.GeniusData;
  const [email, setEmail] = React.useState('');
  const [pass, setPass] = React.useState('');
  const [err, setErr] = React.useState('');

  if (!open) return null;

  function submit(e) {
    e.preventDefault();
    if (!email || !pass) { setErr('Both fields are required.'); return; }
    setErr('');
    onAuth(email);
    onClose();
  }

  return (
    <div onClick={onClose} style={{
      position: 'fixed', inset: 0, zIndex: 999,
      background: 'rgba(0,0,0,.7)', overflowY: 'auto'
    }}>
      <div onClick={(e) => e.stopPropagation()} style={{
        maxWidth: '480px', margin: '60px auto',
        background: 'var(--genius-white)',
        borderRadius: 'var(--radius)',
        overflow: 'hidden'
      }}>
        <div style={{
          position: 'relative',
          padding: 'var(--space-35) var(--space-30)',
          textAlign: 'center'
        }}>
          <span style={{
            position: 'absolute', inset: 0,
            backgroundImage: 'var(--gradient)', backgroundSize: 'var(--gradient-size)',
            opacity: 'var(--gradient-opacity)'
          }} />
          <div style={{ position: 'relative', zIndex: 2 }}>
            <img src={D.img + '/logo/p-logo.jpg'} alt="" style={{ maxHeight: '54px', marginBottom: 'var(--space-15)' }} />
            <h2 style={{
              fontSize: '28px', fontWeight: 'var(--fw-thin)', lineHeight: 1.2,
              color: 'var(--genius-white)', marginBottom: '6px'
            }}>
              <span style={{ fontWeight: 'var(--fw-bold)' }}>Login</span> Your Account.
            </h2>
            <p style={{ margin: 0, fontSize: 'var(--fs-meta)', color: 'var(--genius-white)' }}>
              Login to our website, or <span style={{ fontWeight: 'var(--fw-bold)' }}>REGISTER</span>
            </p>
          </div>
          <button onClick={onClose} aria-label="Close"
            style={{
              position: 'absolute', top: '12px', right: '12px', zIndex: 3,
              width: '32px', height: '32px', border: 0, borderRadius: 'var(--radius)',
              background: 'rgba(255,255,255,.2)', color: 'var(--genius-white)',
              cursor: 'pointer', fontSize: '16px'
            }}><i className="fas fa-times" /></button>
        </div>

        <div style={{ padding: 'var(--space-30)' }}>
          <a href="#" onClick={(e) => e.preventDefault()}
            style={{
              display: 'flex', alignItems: 'center', gap: 'var(--space-15)',
              marginBottom: 'var(--space-20)',
              padding: '0 var(--space-15)',
              height: 'var(--h-field)',
              borderRadius: 'var(--radius)',
              background: '#3b5998', color: 'var(--genius-white)',
              fontSize: 'var(--fs-meta)', fontWeight: 'var(--fw-bold)',
              textDecoration: 'none'
            }}>
            <i className="fab fa-facebook-f" />
            <span style={{ flex: 1, textAlign: 'center' }}>Login with Facebook</span>
          </a>

          <div style={{
            textAlign: 'center', marginBottom: 'var(--space-20)',
            fontSize: 'var(--fs-meta)', fontWeight: 'var(--fw-bold)', color: 'var(--text-muted)'
          }}>OR SIGN IN</div>

          <form onSubmit={submit}>
            <Input type="email" placeholder="Your@email.com*" value={email}
              onChange={(e) => setEmail(e.target.value)} />
            <Input type="password" placeholder="Your password*" value={pass}
              onChange={(e) => setPass(e.target.value)} />
            {err ? (
              <p style={{ margin: '0 0 10px', fontSize: 'var(--fs-meta)', color: 'var(--color-trend)' }}>{err}</p>
            ) : null}
            <SubmitButton>LOg in Now</SubmitButton>
          </form>

          <div style={{ textAlign: 'center', marginTop: 'var(--space-20)' }}>
            <p style={{ margin: 0, fontSize: 'var(--fs-xs)', color: 'var(--text-muted)' }}>* Denotes mandatory field.</p>
            <p style={{ margin: 0, fontSize: 'var(--fs-xs)', color: 'var(--text-muted)' }}>** At least one telephone number is required.</p>
          </div>
        </div>
      </div>
    </div>
  );
}

Object.assign(window, { LoginModal });
