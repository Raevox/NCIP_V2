<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password - NCIP</title>
  <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet"/>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      background: #ffffff;
    }

    .login-card {
      display: flex;
      width: 100%;
      max-width: 900px;
      background: white;
      border-radius: 5px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    /* LEFT PANEL */
    .left-panel {
      flex: 1;
      position: relative;
      overflow: hidden;
      min-height: 400px;
    }

    .left-panel img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: blur(4px);
      transform: scale(1.05);
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
    }

    .overlay-text {
      position: absolute;
      top: 20px; 
      left: 50%;
      transform: translateX(-50%);
      z-index: 2;
      color: #fff;
      font-size: clamp(14px, 2vw, 18px); 
      font-weight: 600;
      text-align: center;
      line-height: 1.3;
      letter-spacing: 1px;
      text-transform: uppercase;
      text-shadow: 0 2px 5px rgba(0,0,0,0.7), 
                  0 0 10px rgba(0,0,0,0.5);
      padding: 6px 14px;
      border-radius: 6px;
      background: rgba(27, 59, 24, 0.3); 
    }

    /* RIGHT PANEL */
    .right-panel {
      flex: 1;
      padding: 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .logo {
      width: 80px;
      height: auto;
      margin-bottom: 20px;
    }

    .right-panel h2 {
      text-align: center;
      color: #333;
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 10px;
      line-height: 1.4;
    }

    .subtitle {
      text-align: center;
      color: #666;
      font-size: 14px;
      margin-bottom: 25px;
      line-height: 1.4;
    }

    .login-form {
      width: 100%;
      max-width: 350px;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group input {
      width: 100%;
      padding: 14px 45px 14px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 15px;
      font-family: 'Inter', sans-serif;
    }

    .input-group input:focus {
      outline: none;
      border-color: #3E7B27;
    }

    .input-group .icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
    }

    .success {
      background: #d4edda;
      color: #155724;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 14px;
      border: 1px solid #c3e6cb;
    }

    .error {
      background: #fee;
      color: #c33;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 14px;
    }

    button[type="submit"] {
      width: 100%;
      padding: 14px;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #3E7B27, #2c5530);
      margin-top: 10px;
    }

    button[type="submit"]:hover {
      background: linear-gradient(135deg, #2c5530, #1a3d1f);
    }

    .signup-text {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #333;
    }

    .signup-text a {
      text-decoration: none;
      font-weight: 600;
      color: #222;
    }

    .signup-text a:hover {
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .login-card { 
        flex-direction: column; 
      }
      .left-panel { 
        min-height: 250px; 
      }
      .overlay-text { 
        font-size: clamp(18px, 4vw, 26px); 
      }
    }

    @media (max-width: 480px) {
      .left-panel { 
        min-height: 200px; 
      }
      .overlay-text { 
        font-size: clamp(16px, 5vw, 22px); 
        padding: 4px 10px;
        top: 10px;
      }
      .right-panel { 
        padding: 20px; 
      }
      .logo { 
        width: 60px; 
      }
      .right-panel h2 {
        font-size: 16px;
      }
      .subtitle {
        font-size: 13px;
      }
    }
  </style>
</head>
<body>
  <div class="login-card">
    <!-- LEFT PANEL -->
    <div class="left-panel">
      <img src="{{ asset('images/Banner_04-scaled.jpg') }}" alt="Background">
      <div class="overlay-text">NCIP Nueva Ecija Provincial Office</div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
      <img src="{{ asset('images/ncip logo.png') }}" alt="NCIP Logo" class="logo">
      <h2>FORGOT PASSWORD</h2>
      <p class="subtitle">Enter your email and we'll send you a reset link.</p>

      <!-- SUCCESS MESSAGE -->
      @if (session('status'))
        <div class="success">
          {{ session('status') }}
        </div>
      @endif

      <!-- FORM -->
      <form method="POST" action="{{ route('password.email') }}" class="login-form">
        @csrf

        <!-- EMAIL INPUT -->
        <div class="input-group">
          <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus />
          <span class="icon"><i class="fas fa-envelope"></i></span>
        </div>

        <!-- ERROR MESSAGES -->
        @if ($errors->any())
          <div class="error">
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <!-- SUBMIT BUTTON -->
        <button type="submit">Send Reset Link</button>

        <!-- BACK TO LOGIN LINK -->
        <p class="signup-text">
          Remembered your password? 
          <a href="{{ route('login') }}">Login here</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>
