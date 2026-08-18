<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NCIP — Create Account</title>
  <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">
  <link rel="icon" href="{{ asset('images/favicon.png') }}"  type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
  :root {
    --green-deep:  #1E4D2B;
    --green-mid:   #2E7D46;
    --green-light: #4CAF6E;
    --gold:        #C9A84C;
    --gold-light:  #E8C97A;
    --cream:       #F9F6EF;
    --text-dark:   #1A2E1F;
    --text-muted:  #6B7C70;
    --border:      #D8E6DC;
    --white:       #FFFFFF;
    --error-bg:    #FFF0F0;
    --error-text:  #C0392B;

    --fs-xxs: clamp(9px,  1.1vw, 11px);
    --fs-xs:  clamp(10px, 1.3vw, 12px);
    --fs-sm:  clamp(11px, 1.5vw, 13.5px);
    --fs-md:  clamp(13px, 1.7vw, 15px);
    --fs-lg:  clamp(15px, 2vw,   18px);
    --fs-xxl: clamp(20px, 3.5vw, 30px);

    --radius-sm: clamp(6px,  1vw,   10px);
    --radius-lg: clamp(12px, 1.8vw, 20px);

    --input-pad-y: clamp(10px, 1.4vw, 14px);
    --input-pad-x: clamp(12px, 1.5vw, 16px);
  }

  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
  html { -webkit-text-size-adjust: 100%; }

  body {
    min-height: 100vh;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    background-color: #FFFFFF;
    background-image:
      radial-gradient(ellipse at 20% 80%, rgba(46,125,70,.10) 0%, transparent 55%),
      radial-gradient(ellipse at 80% 10%, rgba(201,168,76,.08) 0%, transparent 50%);
    font-family: 'DM Sans', sans-serif;
    padding: clamp(12px, 3vw, 32px) clamp(10px, 2.5vw, 20px);
  }

  /* ─── CARD ─── */
  .register-card {
    display: flex;
    align-items: stretch;   
    width: 100%;
    max-width: 980px;
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow:
      0 4px 6px rgba(0,0,0,.04),
      0 20px 60px rgba(30,77,43,.14),
      0 0 0 1px rgba(30,77,43,.06);
    animation: cardIn .65s cubic-bezier(.22,1,.36,1) both;
  }

  @keyframes cardIn {
    from { opacity:0; transform:translateY(28px) scale(.98); }
    to   { opacity:1; transform:translateY(0) scale(1); }
  }

  /* ─── LEFT PANEL ───
     Desktop: no min-height — flex stretch makes it match the right panel.
     The absolutely-positioned image then fills that full height.
     Mobile: min-height added in media query so the banner has visible height.
  ─── */
  .left-panel {
    flex: 0 0 clamp(220px, 30vw, 340px);
    position: relative;
    overflow: hidden;
    /* intentionally no min-height here; flex stretch handles desktop height */
  }

  .left-panel img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;           
    object-fit: cover;
    transform: scale(1.06);
    transition: transform 8s ease;
    filter: brightness(.6) saturate(1.1);
  }

  .left-panel:hover img { transform: scale(1.12); }

  .left-panel::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(160deg, rgba(30,77,43,.55) 0%, rgba(15,35,20,.75) 100%);
    z-index: 1;
  }

  .left-content {
    position: absolute; inset: 0;
    z-index: 2;
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: clamp(20px, 3vw, 36px) clamp(18px, 2.5vw, 32px);
  }

  .left-badge {
    display: inline-flex; align-items: center; gap: clamp(5px,.8vw,8px);
    background: rgba(201,168,76,.18);
    border: 1px solid rgba(201,168,76,.45);
    color: var(--gold-light);
    font-size: var(--fs-xxs); font-weight: 600; letter-spacing: 1.4px;
    text-transform: uppercase;
    padding: clamp(4px,.6vw,6px) clamp(10px,1.3vw,14px);
    border-radius: 100px;
    margin-bottom: clamp(12px,1.8vw,18px);
    width: fit-content;
  }
  .left-badge i { font-size: var(--fs-xxs); }

  .left-title {
    font-family: 'Playfair Display', serif;
    color: var(--white);
    font-size: var(--fs-xxl);
    line-height: 1.25; letter-spacing: .3px;
    margin-bottom: clamp(8px,1.2vw,12px);
  }
  .left-title span { color: var(--gold-light); }

  .left-divider {
    width: 40px; height: 2px;
    background: linear-gradient(to right, var(--gold), transparent);
    margin: clamp(10px,1.5vw,16px) 0;
    border-radius: 2px;
  }

  .left-sub {
    color: rgba(255,255,255,.65);
    font-size: var(--fs-sm); font-weight: 300; line-height: 1.55;
    max-width: 260px;
  }

  /* ─── RIGHT PANEL ───
     NO overflow-y / max-height — the card grows with the form,
     so the left image always matches the full height.
  ─── */
  .right-panel {
    flex: 1;
    padding: clamp(24px, 3.5vw, 44px) clamp(18px, 4vw, 50px);
    display: flex; flex-direction: column; align-items: center;
  }

  .logo-wrap {
    position: relative;
    margin-bottom: clamp(10px,1.5vw,16px);
  }
  .logo-wrap::before {
    content: '';
    position: absolute; inset: -10px; border-radius: 50%;
    background: radial-gradient(circle, rgba(46,125,70,.08) 0%, transparent 70%);
  }
  .logo {
    width: clamp(48px, 7vw, 66px); height: auto;
    display: block; position: relative; z-index: 1;
    filter: drop-shadow(0 4px 12px rgba(30,77,43,.20));
    animation: logoIn .7s .2s cubic-bezier(.22,1,.36,1) both;
  }
  @keyframes logoIn {
    from { opacity:0; transform:scale(.8) translateY(-8px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
  }

  .brand-name {
    text-align: center;
    margin-bottom: clamp(16px,2.5vw,24px);
    animation: fadeUp .5s .35s ease both;
  }
  .brand-name h2 {
    color: var(--text-dark);
    font-family: 'DM Sans', sans-serif;
    font-size: var(--fs-xs); font-weight: 600;
    letter-spacing: 1.2px; text-transform: uppercase; line-height: 1.5;
  }
  .brand-name p {
    color: var(--text-muted);
    font-size: var(--fs-xs); font-weight: 300;
    margin-top: clamp(2px,.4vw,4px); letter-spacing: .4px;
  }

  @keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
  }

  .register-form {
    width: 100%; max-width: 520px;
    animation: fadeUp .5s .45s ease both;
  }

  .form-section {
    font-size: var(--fs-xxs); font-weight: 700;
    letter-spacing: 1.3px; text-transform: uppercase;
    color: var(--text-muted);
    margin: clamp(14px,2vw,22px) 0 clamp(10px,1.4vw,16px);
    display: flex; align-items: center; gap: 10px;
  }
  .form-section::before,
  .form-section::after { content: ''; flex: 1; height: 1px; background: var(--border); }
  .form-section:first-child { margin-top: 0; }

  .form-row        { display: grid; grid-template-columns: 1fr 1fr;     gap: clamp(10px,1.5vw,16px); }
  .form-row.triple { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: clamp(10px,1.5vw,16px); }

  .form-label {
    display: block;
    font-size: var(--fs-xxs); font-weight: 600;
    letter-spacing: 1px; text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: clamp(5px,.7vw,8px);
  }

  .input-group {
    position: relative;
    margin-bottom: clamp(12px,1.8vw,18px);
  }

  .input-group input,
  .input-group select {
    width: 100%;
    padding: var(--input-pad-y) var(--input-pad-x);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: var(--fs-md);
    font-family: 'DM Sans', sans-serif; font-weight: 400;
    color: var(--text-dark);
    background: var(--cream);
    transition: border-color .22s, box-shadow .22s, background .22s;
    outline: none;
    appearance: none; -webkit-appearance: none;
    touch-action: manipulation;
  }

  .input-group.has-icon input { padding-right: clamp(36px,5vw,46px); }
  .input-group input::placeholder { color: #B0BDB4; font-weight: 300; }

  .input-group input:focus,
  .input-group select:focus {
    border-color: var(--green-mid);
    background: var(--white);
    box-shadow: 0 0 0 4px rgba(46,125,70,.10);
  }

  .input-group input.is-invalid,
  .input-group select.is-invalid {
    border-color: var(--error-text);
    box-shadow: 0 0 0 3px rgba(192,57,43,.10);
  }

  .input-group select:disabled { background: #f2f2f2; color: #aaa; cursor: not-allowed; }

  .input-group .icon {
    position: absolute;
    right: clamp(10px,1.5vw,15px);
    top: 50%; transform: translateY(-50%);
    color: #B0BDB4;
    font-size: var(--fs-sm);
    cursor: pointer;
    transition: color .2s;
    line-height: 1;
  }
  .input-group input:focus ~ .icon,
  .input-group:hover .icon { color: var(--green-mid); }

  .field-error {
    display: none;
    font-size: var(--fs-xs); color: var(--error-text);
    margin-top: -8px; margin-bottom: 10px;
    padding: clamp(5px,.8vw,8px) clamp(8px,1.2vw,12px);
    background: var(--error-bg);
    border-radius: var(--radius-sm);
    border-left: 3px solid var(--error-text);
  }

  .file-note       { font-size: var(--fs-xs); color: var(--text-muted); margin-top: 5px; display: block; }
  .file-note.ok    { color: #059669; }
  .file-note.err   { color: var(--error-text); }

  .alert-box {
    width: 100%;
    background: var(--error-bg);
    border: 1px solid rgba(192,57,43,.20);
    border-left: 3px solid var(--error-text);
    border-radius: var(--radius-sm);
    padding: clamp(8px,1.2vw,12px) clamp(10px,1.5vw,16px);
    margin-bottom: clamp(12px,1.8vw,18px);
    animation: shake .4s ease;
  }
  .alert-box p, .alert-box li { color: var(--error-text); font-size: var(--fs-sm); }
  .alert-box ul { padding-left: 18px; }

  .alert-box-success {
    width: 100%;
    background: #F0FFF4;
    border: 1px solid rgba(5,150,105,.20);
    border-left: 3px solid #059669;
    border-radius: var(--radius-sm);
    padding: clamp(8px,1.2vw,12px) clamp(10px,1.5vw,16px);
    margin-bottom: clamp(12px,1.8vw,18px);
    font-size: var(--fs-sm); color: #065f46;
  }

  @keyframes shake {
    0%,100% { transform: translateX(0); }
    20%     { transform: translateX(-5px); }
    40%     { transform: translateX(5px); }
    60%     { transform: translateX(-3px); }
    80%     { transform: translateX(3px); }
  }

  .btn-register {
    width: 100%;
    padding: clamp(12px,1.7vw,15px);
    background: linear-gradient(135deg, var(--green-mid) 0%, var(--green-deep) 100%);
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-size: var(--fs-md); font-weight: 600;
    font-family: 'DM Sans', sans-serif; letter-spacing: .5px;
    cursor: pointer; position: relative; overflow: hidden;
    transition: transform .15s, box-shadow .2s;
    box-shadow: 0 4px 18px rgba(30,77,43,.30);
    margin-top: clamp(4px,.8vw,8px);
  }
  .btn-register::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.12) 0%, transparent 60%);
  }
  .btn-register:hover  { transform: translateY(-1px); box-shadow: 0 7px 24px rgba(30,77,43,.38); }
  .btn-register:active { transform: translateY(0);    box-shadow: 0 3px 10px rgba(30,77,43,.25); }
  .btn-register span {
    position: relative; z-index: 1;
    display: flex; align-items: center; justify-content: center;
    gap: clamp(5px,.8vw,8px);
  }

  .divider {
    display: flex; align-items: center; gap: 12px;
    margin: clamp(14px,2vw,22px) 0 clamp(10px,1.6vw,18px);
  }
  .divider::before,
  .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
  .divider span   { font-size: var(--fs-xs); color: #B0BDB4; white-space: nowrap; }

  .signin-text { text-align: center; font-size: var(--fs-sm); color: var(--text-muted); }
  .signin-text a {
    color: var(--green-deep); font-weight: 600;
    text-decoration: none; transition: color .2s;
  }
  .signin-text a:hover { color: var(--green-mid); text-decoration: underline; }

  input[type="password"]::-ms-reveal,
  input[type="password"]::-ms-clear { display: none; width: 0; height: 0; }

  /* ─── APPROVAL MODAL ─── */
  .modal-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.5); backdrop-filter: blur(3px);
    z-index: 1000; align-items: center; justify-content: center;
    padding: 20px;
  }
  .modal-backdrop.show { display: flex; }

  .modal-box {
    background: var(--white); border-radius: var(--radius-lg);
    padding: clamp(22px,4vw,38px) clamp(20px,3.5vw,34px);
    max-width: 420px; width: 100%;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0,0,0,.22);
    animation: fadeUp .35s cubic-bezier(.22,1,.36,1) both;
  }
  .modal-icon {
    width: clamp(44px,6vw,60px); height: clamp(44px,6vw,60px);
    border-radius: 50%; background: var(--cream);
    display: grid; place-items: center;
    margin: 0 auto clamp(12px,1.8vw,18px);
    font-size: clamp(18px,2.5vw,24px); color: var(--green-mid);
    border: 2px solid var(--border);
  }
  .modal-box h3 { color: var(--text-dark); font-size: var(--fs-lg); font-weight: 600; margin-bottom: clamp(8px,1.2vw,12px); }
  .modal-box p  { color: var(--text-muted); font-size: var(--fs-sm); line-height: 1.6; margin-bottom: 8px; }

  .btn-ok {
    margin-top: clamp(14px,2vw,22px);
    padding: clamp(10px,1.4vw,13px) clamp(22px,3vw,34px);
    background: linear-gradient(135deg, var(--green-mid), var(--green-deep));
    color: #fff; border: none; border-radius: var(--radius-sm);
    font-size: var(--fs-sm); font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer; transition: transform .15s, box-shadow .2s;
    box-shadow: 0 4px 14px rgba(30,77,43,.28);
  }
  .btn-ok:hover { transform: translateY(-1px); box-shadow: 0 7px 20px rgba(30,77,43,.35); }

  /* ═══════════════════════════════════
     RESPONSIVE
  ═══════════════════════════════════ */

  @media (max-width: 900px) {
    .left-panel { flex: 0 0 clamp(180px, 28vw, 280px); }
    .form-row.triple { grid-template-columns: 1fr 1fr; }
    .form-row.triple > div:last-child { grid-column: 1 / -1; }
  }

  /* Stacked layout — left panel needs explicit height as a banner */
  @media (max-width: 720px) {
    .register-card  { flex-direction: column; }
    .left-panel     { flex: none; width: 100%; min-height: clamp(160px, 30vw, 220px); }
    .left-content   { justify-content: flex-end; }
    .left-title     { font-size: clamp(18px, 4.5vw, 26px); }
    .left-sub       { display: none; }
    .right-panel    { padding: clamp(20px, 5vw, 36px) clamp(16px, 5vw, 40px); }
    .form-row.triple { grid-template-columns: 1fr 1fr; }
    .form-row.triple > div:last-child { grid-column: 1 / -1; }
  }

  @media (max-width: 540px) {
    body            { padding: 10px; }
    .register-card  { border-radius: clamp(10px,3vw,16px); }
    .left-panel     { min-height: clamp(130px, 28vw, 180px); }
    .left-badge     { font-size: 9px; }
    .right-panel    { padding: clamp(16px,5vw,28px) clamp(14px,5vw,28px); }
    .form-row,
    .form-row.triple { grid-template-columns: 1fr; }
    .form-row.triple > div:last-child { grid-column: auto; }
  }

  @media (max-width: 380px) {
    body            { padding: 8px; }
    .left-panel     { min-height: 120px; }
    .right-panel    { padding: 14px 12px; }
    .logo           { width: 44px; }
    .brand-name h2  { letter-spacing: .8px; }
  }

  @media (max-width: 340px) {
    .left-panel     { min-height: 100px; }
    .right-panel    { padding: 12px 10px; }
  }

  @media (hover: none) and (pointer: coarse) {
    .input-group input,
    .input-group select { font-size: max(var(--fs-md), 16px); }
  }

  @media (min-width: 1400px) {
    .register-card  { max-width: 1100px; }
    .left-panel     { flex: 0 0 380px; }
  }
  </style>
</head>
<body>

  <div class="modal-backdrop" id="approvalModal">
    <div class="modal-box">
      <div class="modal-icon"><i class="fas fa-check-circle"></i></div>
      <h3>Ready to Create Your Account</h3>
      <p>Please review your information before submitting. Once created, you'll be able to log in right away.</p>
      <button class="btn-ok" id="modalOkBtn">Confirm &amp; Create Account</button>
    </div>
  </div>

  <div class="register-card">

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

    <div class="right-panel">

      <div class="logo-wrap">
        <img src="{{ asset('images/ncip logo.png') }}" alt="NCIP Logo" class="logo">
      </div>

      <div class="brand-name">
        <h2>National Commission on<br>Indigenous Peoples</h2>
        <p>Create your account to get started</p>
      </div>

      @if(session('success'))
        <div class="alert-box-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert-box"><p>{{ session('error') }}</p></div>
      @endif
      @if ($errors->any())
        <div class="alert-box">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}"
            class="register-form" id="registerForm"
            enctype="multipart/form-data" novalidate>
        @csrf

        <div class="form-section">Personal Information</div>

        <div class="form-row">
          <div>
            <label class="form-label" for="first_name">First Name</label>
            <div class="input-group">
              <input type="text" id="first_name" name="first_name"
                     placeholder="First name" value="{{ old('first_name') }}" required>
            </div>
          </div>
          <div>
            <label class="form-label" for="last_name">Last Name</label>
            <div class="input-group">
              <input type="text" id="last_name" name="last_name"
                     placeholder="Last name" value="{{ old('last_name') }}" required>
            </div>
          </div>
        </div>

        <label class="form-label" for="email">Email Address</label>
        <div class="input-group has-icon">
          <input type="email" id="email" name="email"
                 placeholder="you@gmail.com" value="{{ old('email') }}"
                 pattern="[a-zA-Z0-9._%+\-]+@gmail\.com$" required>
          <span class="icon"><i class="fas fa-envelope"></i></span>
        </div>
        <div class="field-error" id="emailError"></div>

        <div class="form-section">Location</div>

        <div class="form-row triple">
          <div>
            <label class="form-label" for="province_code">Province</label>
            <div class="input-group">
              <select id="province_code" name="province_code" required>
                <option disabled selected>Loading…</option>
              </select>
              <input type="hidden" name="province_name" id="province_name" value="{{ old('province_name') }}">
            </div>
          </div>
          <div>
            <label class="form-label" for="municipality_code">Municipality</label>
            <div class="input-group">
              <select id="municipality_code" name="municipality_code" required disabled>
                <option disabled selected>Select Province first</option>
              </select>
              <input type="hidden" name="municipality_name" id="municipality_name" value="{{ old('municipality_name') }}">
            </div>
          </div>
          <div>
            <label class="form-label" for="barangay_code">Barangay</label>
            <div class="input-group">
              <select id="barangay_code" name="barangay_code" required disabled>
                <option disabled selected>Select Municipality first</option>
              </select>
              <input type="hidden" name="barangay_name" id="barangay_name" value="{{ old('barangay_name') }}">
            </div>
          </div>
        </div>

        <div class="form-section">Indigenous Group &amp; Contact</div>

        <div class="form-row">
          <div>
            <label class="form-label" for="tribe">Indigenous Group / Tribe</label>
            <div class="input-group">
                @php
                    $tribes = \App\Models\Tribe::active()->orderBy('name')->pluck('name')->toArray();
                @endphp
                <select id="tribe" name="tribe" required>
                    <option disabled {{ old('tribe') ? '' : 'selected' }}>Select your IP group</option>
                    @foreach($tribes as $tribe)
                        <option value="{{ $tribe }}" {{ old('tribe') == $tribe ? 'selected' : '' }}>
                            {{ $tribe }}
                        </option>
                    @endforeach
                    <option value="Other" {{ old('tribe') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
          </div>
          <div>
            <label class="form-label" for="contact">Phone Number</label>
            <div class="input-group">
              <input type="tel" id="contact" name="contact"
                     placeholder="09XXXXXXXXX" value="{{ old('contact') }}"
                     maxlength="11" required>
            </div>
            <div class="field-error" id="phoneError"></div>
          </div>
        </div>

        <label class="form-label" for="leader">Elder / Chieftain / Leader</label>
        <div class="input-group">
          <input type="text" id="leader" name="leader"
                 placeholder="Name of your community leader"
                 value="{{ old('leader') }}" required>
        </div>

        <div class="form-section">Security</div>

        <div class="form-row">
          <div>
            <label class="form-label" for="password">Password</label>
            <div class="input-group has-icon">
              <input type="password" id="password" name="password"
                     placeholder="Create a password" required>
              <span class="icon" onclick="togglePwd('password','eyePass')" title="Show / hide">
                <i id="eyePass" class="fas fa-eye"></i>
              </span>
            </div>
          </div>
          <div>
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <div class="input-group has-icon">
              <input type="password" id="password_confirmation" name="password_confirmation"
                     placeholder="Confirm password" required>
              <span class="icon" onclick="togglePwd('password_confirmation','eyeConf')" title="Show / hide">
                <i id="eyeConf" class="fas fa-eye"></i>
              </span>
            </div>
          </div>
        </div>

        <div class="form-section">Documents</div>

        <!-- To be remove -->
        <label class="form-label" for="birth_certificate">Birth Certificate</label>
        <div class="input-group">
          <input type="file" id="birth_certificate" name="birth_certificate"
                 accept=".jpg,.jpeg,.png,.pdf" required>
        </div>
        <span class="file-note" id="fileNote">Accepted: JPG, PNG, PDF — max 5 MB</span>

        <button type="submit" class="btn-register">
          <span><i class="fas fa-user-plus"></i> Create Account</span>
        </button>

        <div class="divider"><span>Already registered?</span></div>

        <p class="signin-text">
          Have an account? <a href="{{ route('login') }}">Sign in here</a>
        </p>

      </form>
    </div>
  </div>

  <script>
  function togglePwd(fieldId, iconId) {
    const inp  = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    const isHid = inp.type === 'password';
    inp.type       = isHid ? 'text'            : 'password';
    icon.className = isHid ? 'fas fa-eye-slash' : 'fas fa-eye';
  }

  document.addEventListener('DOMContentLoaded', async () => {

    const provSel  = document.getElementById('province_code');
    const munSel   = document.getElementById('municipality_code');
    const brgySel  = document.getElementById('barangay_code');

    const setLoad = (sel, msg) => { sel.innerHTML = `<option disabled selected>${msg}</option>`; sel.disabled = true; };
    const reset   = (sel, msg) => { sel.innerHTML = `<option disabled selected>${msg}</option>`; sel.disabled = false; };

    try {
      const [pRes, mRes, bRes] = await Promise.all([
        fetch('{{ asset("data/provinces.json") }}'),
        fetch('{{ asset("data/mun.json") }}'),
        fetch('{{ asset("data/brgy.json") }}'),
      ]);
      const provinces      = (await pRes.json()).RECORDS;
      const municipalities = (await mRes.json()).RECORDS;
      const barangays      = (await bRes.json()).RECORDS;

      provinces.sort((a,b) => a.provDesc.localeCompare(b.provDesc));
      reset(provSel, 'Select Province');
      provinces.forEach(p => {
        const o = document.createElement('option');
        o.value = p.provCode; o.textContent = p.provDesc;
        provSel.appendChild(o);
      });

      provSel.addEventListener('change', function () {
        document.getElementById('province_name').value = this.options[this.selectedIndex].text;
        setLoad(munSel, 'Loading municipalities…');
        setLoad(brgySel, 'Select Municipality first');
        setTimeout(() => {
          const list = municipalities.filter(m => m.provCode === this.value)
            .sort((a,b) => a.citymunDesc.localeCompare(b.citymunDesc));
          reset(munSel, 'Select Municipality');
          list.forEach(m => {
            const o = document.createElement('option');
            o.value = m.citymunCode; o.textContent = m.citymunDesc;
            munSel.appendChild(o);
          });
        }, 250);
      });

      munSel.addEventListener('change', function () {
        document.getElementById('municipality_name').value = this.options[this.selectedIndex].text;
        setLoad(brgySel, 'Loading barangays…');
        setTimeout(() => {
          const list = barangays.filter(b => b.citymunCode === this.value)
            .sort((a,b) => a.brgyDesc.localeCompare(b.brgyDesc));
          reset(brgySel, 'Select Barangay');
          list.forEach(b => {
            const o = document.createElement('option');
            o.value = b.brgyCode; o.textContent = b.brgyDesc;
            brgySel.appendChild(o);
          });
        }, 250);
      });

      brgySel.addEventListener('change', function () {
        document.getElementById('barangay_name').value = this.options[this.selectedIndex].text;
      });

    } catch (err) {
      provSel.innerHTML = '<option disabled selected>Error loading — please refresh</option>';
    }

    const fileInput = document.getElementById('birth_certificate');
    const fileNote  = document.getElementById('fileNote');
    fileInput.addEventListener('change', function () {
      const f = this.files[0];
      if (!f) { fileNote.textContent = 'Accepted: JPG, PNG, PDF — max 5 MB'; fileNote.className = 'file-note'; return; }
      const mb = (f.size / 1024 / 1024).toFixed(2);
      if (parseFloat(mb) > 5) { fileNote.textContent = `File too large (${mb} MB). Max is 5 MB.`; fileNote.className = 'file-note err'; this.value = ''; }
      else                    { fileNote.textContent = `✓ ${f.name} (${mb} MB)`;                  fileNote.className = 'file-note ok'; }
    });

    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    emailInput.addEventListener('input', function () {
      const ok = /^[a-zA-Z0-9._%+\-]+@gmail\.com$/i.test(this.value);
      if (this.value && !ok) { emailError.textContent = 'Please use a Gmail address (@gmail.com)'; emailError.style.display = 'block'; this.classList.add('is-invalid'); }
      else                   { emailError.style.display = 'none'; this.classList.remove('is-invalid'); }
    });

    const contactInput = document.getElementById('contact');
    const phoneError   = document.getElementById('phoneError');
    contactInput.addEventListener('input', function () {
      let v = this.value.replace(/\D/g, '');
      if (v.length > 0 && !v.startsWith('09')) v = v.startsWith('0') ? '09' + v.slice(1) : '09' + v;
      this.value = v.slice(0, 11);
      if (v.length > 0 && v.length < 11) { phoneError.textContent = `${v.length}/11 digits`; phoneError.style.display = 'block'; this.classList.add('is-invalid'); }
      else                               { phoneError.style.display = 'none'; this.classList.remove('is-invalid'); }
    });

    const form  = document.getElementById('registerForm');
    const modal = document.getElementById('approvalModal');
    const okBtn = document.getElementById('modalOkBtn');

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const email = emailInput.value, contact = contactInput.value;
      const pwd  = document.getElementById('password').value;
      const pwdC = document.getElementById('password_confirmation').value;
      let valid  = true;

      if (!/^[a-zA-Z0-9._%+\-]+@gmail\.com$/i.test(email)) {
        emailError.textContent = 'Please use a Gmail address (@gmail.com)';
        emailError.style.display = 'block'; emailInput.classList.add('is-invalid'); emailInput.focus(); valid = false;
      }
      if (contact.length !== 11 || !contact.startsWith('09')) {
        phoneError.textContent = 'Enter a valid 11-digit number starting with 09';
        phoneError.style.display = 'block'; contactInput.classList.add('is-invalid'); if (valid) contactInput.focus(); valid = false;
      }
      if (pwd.length < 8)    { alert('Password must be at least 8 characters.'); valid = false; }
      else if (pwd !== pwdC) { alert('Passwords do not match.');                  valid = false; }

      if (!valid) return;
      modal.classList.add('show');
      document.body.style.overflow = 'hidden';
    });

    okBtn.addEventListener('click', () => {
      modal.classList.remove('show'); document.body.style.overflow = ''; form.submit();
    });
    modal.addEventListener('click', function (e) {
      if (e.target === this) { this.classList.remove('show'); document.body.style.overflow = ''; }
    });
  });
  </script>
  @include('partials.website-chatbot')
</body>
</html>