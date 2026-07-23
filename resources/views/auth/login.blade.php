<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NCIP Login</title>
  <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    :root {
      --green-deep:   #1E4D2B;
      --green-mid:    #2E7D46;
      --green-light:  #4CAF6E;
      --gold:         #C9A84C;
      --gold-light:   #E8C97A;
      --cream:        #F9F6EF;
      --text-dark:    #1A2E1F;
      --text-muted:   #6B7C70;
      --border:       #D8E6DC;
      --white:        #FFFFFF;
      --error-bg:     #FFF0F0;
      --error-text:   #C0392B;
    }

    *, *::before, *::after {
      margin: 0; padding: 0;
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #FFFFFF;
      background-image:
        radial-gradient(ellipse at 20% 80%, rgba(46,125,70,0.10) 0%, transparent 55%),
        radial-gradient(ellipse at 80% 10%, rgba(201,168,76,0.08) 0%, transparent 50%);
      font-family: 'DM Sans', sans-serif;
      padding: 20px;
    }

    /* ── CARD ── */
    .login-card {
      display: flex;
      width: 100%;
      max-width: 920px;
      background: var(--white);
      border-radius: 20px;
      overflow: hidden;
      box-shadow:
        0 4px 6px rgba(0,0,0,0.04),
        0 20px 60px rgba(30,77,43,0.14),
        0 0 0 1px rgba(30,77,43,0.06);
      animation: cardIn 0.65s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes cardIn {
      from { opacity: 0; transform: translateY(28px) scale(0.98); }
      to   { opacity: 1; transform: translateY(0)   scale(1); }
    }

    /* ── LEFT PANEL ── */
    .left-panel {
      flex: 1.1;
      position: relative;
      overflow: hidden;
      min-height: 480px;
    }

    .left-panel img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      position: absolute;
      inset: 0;
      transform: scale(1.06);
      transition: transform 8s ease;
      filter: brightness(0.6) saturate(1.1);
    }

    .left-panel:hover img {
      transform: scale(1.12);
    }

    /* dark gradient overlay */
    .left-panel::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(
        160deg,
        rgba(30,77,43,0.55) 0%,
        rgba(15,35,20,0.75) 100%
      );
      z-index: 1;
    }

    .left-content {
      position: absolute;
      inset: 0;
      z-index: 2;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 36px 32px;
    }

    .left-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(201,168,76,0.18);
      border: 1px solid rgba(201,168,76,0.45);
      color: var(--gold-light);
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 1.6px;
      text-transform: uppercase;
      padding: 6px 14px;
      border-radius: 100px;
      margin-bottom: 18px;
      width: fit-content;
    }

    .left-badge i { font-size: 10px; }

    .left-title {
      font-family: 'Playfair Display', serif;
      color: var(--white);
      font-size: clamp(22px, 3vw, 30px);
      line-height: 1.25;
      letter-spacing: 0.3px;
      margin-bottom: 12px;
    }

    .left-title span {
      color: var(--gold-light);
    }

    .left-sub {
      color: rgba(255,255,255,0.65);
      font-size: 13px;
      font-weight: 300;
      line-height: 1.55;
      max-width: 280px;
    }

    .left-divider {
      width: 40px;
      height: 2px;
      background: linear-gradient(to right, var(--gold), transparent);
      margin: 16px 0;
      border-radius: 2px;
    }

    /* ── RIGHT PANEL ── */
    .right-panel {
      flex: 1;
      padding: 48px 44px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: var(--white);
    }

    .logo-wrap {
      position: relative;
      margin-bottom: 22px;
    }

    .logo-wrap::before {
      content: '';
      position: absolute;
      inset: -10px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(46,125,70,0.08) 0%, transparent 70%);
    }

    .logo {
      width: 100px;
      height: auto;
      display: block;
      position: relative;
      z-index: 1;
      filter: drop-shadow(0 4px 12px rgba(30,77,43,0.20));
      animation: logoIn 0.7s 0.2s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes logoIn {
      from { opacity: 0; transform: scale(0.8) translateY(-8px); }
      to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .brand-name {
      text-align: center;
      margin-bottom: 30px;
      animation: fadeUp 0.5s 0.35s ease both;
    }

    .brand-name h2 {
      color: var(--text-dark);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 600;
      letter-spacing: 1.4px;
      text-transform: uppercase;
      line-height: 1.5;
    }

    .brand-name p {
      color: var(--text-muted);
      font-size: 12px;
      font-weight: 300;
      margin-top: 4px;
      letter-spacing: 0.5px;
    }

    /* ── FORM ── */
    .login-form {
      width: 100%;
      max-width: 320px;
      animation: fadeUp 0.5s 0.45s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(14px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .form-label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 7px;
    }

    .input-group {
      position: relative;
      margin-bottom: 18px;
    }

    .input-group input {
      width: 100%;
      padding: 13px 44px 13px 16px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-size: 14.5px;
      font-family: 'DM Sans', sans-serif;
      font-weight: 400;
      color: var(--text-dark);
      background: var(--cream);
      transition: border-color 0.22s, box-shadow 0.22s, background 0.22s;
      outline: none;
    }

    .input-group input::placeholder {
      color: #B0BDB4;
      font-weight: 300;
    }

    .input-group input:focus {
      border-color: var(--green-mid);
      background: var(--white);
      box-shadow: 0 0 0 4px rgba(46,125,70,0.10);
    }

    .input-group {
  position: relative;
  margin-bottom: 18px;
}

    .input-group input {
      width: 100%;
      padding: 13px 44px 13px 16px;
    }

    .input-group .icon {
      position: absolute;
      right: 14px;
      bottom: 13px; 
      color: #B0BDB4;
      cursor: pointer;
      font-size: 14px;
    }

    .input-group input:focus ~ .icon,
    .input-group:hover .icon {
      color: var(--green-mid);
    }

    /* ── ERROR ── */
    .error-box {
      background: var(--error-bg);
      border: 1px solid rgba(192,57,43,0.2);
      border-left: 3px solid var(--error-text);
      border-radius: 8px;
      padding: 11px 14px;
      margin-bottom: 16px;
      animation: shake 0.4s ease;
    }

    @keyframes shake {
      0%,100%{ transform: translateX(0); }
      20%    { transform: translateX(-5px); }
      40%    { transform: translateX(5px); }
      60%    { transform: translateX(-3px); }
      80%    { transform: translateX(3px); }
    }

    .error-box p {
      color: var(--error-text);
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 7px;
    }

    .error-box p::before {
      content: '\f06a';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      font-size: 13px;
      flex-shrink: 0;
    }

    /* ── EXTRAS ── */
    .form-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 22px;
    }

    .remember-me label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: var(--text-muted);
      cursor: pointer;
      user-select: none;
    }

    .remember-me input[type="checkbox"] {
      appearance: none;
      width: 16px;
      height: 16px;
      border: 1.5px solid var(--border);
      border-radius: 4px;
      background: var(--cream);
      cursor: pointer;
      position: relative;
      transition: border-color 0.2s, background 0.2s;
      flex-shrink: 0;
    }

    .remember-me input[type="checkbox"]:checked {
      background: var(--green-mid);
      border-color: var(--green-mid);
    }

    .remember-me input[type="checkbox"]:checked::after {
      content: '\f00c';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      font-size: 9px;
      color: white;
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
    }

    .forgot {
      font-size: 13px;
      color: var(--green-mid);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }

    .forgot:hover { color: var(--green-deep); text-decoration: underline; }

    /* ── BUTTON ── */
    .btn-login {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, var(--green-mid) 0%, var(--green-deep) 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      letter-spacing: 0.5px;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 4px 18px rgba(30,77,43,0.30);
    }

    .btn-login::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 60%);
    }

    .btn-login:hover {
      transform: translateY(-1px);
      box-shadow: 0 7px 24px rgba(30,77,43,0.38);
    }

    .btn-login:active {
      transform: translateY(0);
      box-shadow: 0 3px 10px rgba(30,77,43,0.25);
    }

    .btn-login span {
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    /* ── DIVIDER ── */
    .divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 20px 0 16px;
    }

    .divider::before, .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }

    .divider span {
      font-size: 12px;
      color: #B0BDB4;
      white-space: nowrap;
    }

    /* ── SIGNUP ── */
    .signup-text {
      text-align: center;
      font-size: 13.5px;
      color: var(--text-muted);
    }

    .signup-text a {
      color: var(--green-deep);
      font-weight: 600;
      text-decoration: none;
      transition: color 0.2s;
    }

    .signup-text a:hover { color: var(--green-mid); text-decoration: underline; }

    /* hide browser password eye */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear { display: none; width: 0; height: 0; }

    /* ── RESPONSIVE ── */
    @media (max-width: 720px) {
      .login-card { flex-direction: column; border-radius: 16px; }
      .left-panel  { min-height: 220px; }
      .left-content { padding: 24px; justify-content: flex-end; }
      .left-title  { font-size: 20px; }
      .right-panel { padding: 36px 28px; }
    }

    @media (max-width: 460px) {
      body { padding: 12px; }
      .left-panel  { min-height: 180px; }
      .right-panel { padding: 28px 20px; }
      .logo { width: 58px; }
    }
  </style>
</head>
<body>

  <div class="login-card">

    <!-- ═══ LEFT PANEL ═══ -->
    <div class="left-panel">
      <img src="{{ asset('images/Banner_04-scaled.jpg') }}" alt="NCIP Background">
      <div class="left-content">
        <div class="left-badge">
          <i class="fas fa-landmark"></i>
          Government of the Philippines
        </div>
        <h1 class="left-title">
          NCIP<br>
          <span>Nueva Ecija</span><br>
          Provincial Office
        </h1>
        <div class="left-divider"></div>
        <p class="left-sub">Serving and protecting the rights of Indigenous Peoples in Nueva Ecija.</p>
      </div>
    </div>

    <!-- ═══ RIGHT PANEL ═══ -->
    <div class="right-panel">

      <div class="logo-wrap">
        <img src="{{ asset('images/mainLogo.png') }}" alt="NCIP Logo" class="logo">
      </div>

      <div class="brand-name">
        <h2>National Commission on<br>Indigenous Peoples</h2>
        {{-- <p>Sign in to your account to continue</p> --}}
      </div>

      <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        <!-- Email -->
        <div class="input-group">
          <label class="form-label" for="email">Email Address</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="you@example.com"
            value="{{ old('email') }}"
            required
            autofocus
          />
          <span class="icon"><i class="fas fa-envelope"></i></span>
        </div>

        <!-- Password -->
        <div class="input-group">
          <label class="form-label" for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter password"
            required
          />
          <span class="icon" onclick="togglePassword()" title="Show / hide password">
            <i id="eye-icon" class="fas fa-eye"></i>
          </span>
        </div>

        <!-- Errors -->
        @if ($errors->any())
          <div class="error-box">
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <!-- Remember + Forgot -->
        <div class="form-footer">
          <div class="remember-me">
            <label>
              <input type="checkbox" name="remember">
              Remember me
            </label>
          </div>
          <a href="{{ route('password.request') }}" class="forgot">Forgot password?</a>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-login">
          <span>
            {{-- <i class="fas fa-arrow-right-to-bracket"></i> --}}
            Sign In
          </span>
        </button>

        <div class="divider"><span>New here?</span></div>

        <p class="signup-text">
          Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </p>

      </form>
    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const icon  = document.getElementById('eye-icon');
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      icon.classList.toggle('fa-eye',       !isHidden);
      icon.classList.toggle('fa-eye-slash',  isHidden);
    }
  </script>
</body>
</html>