<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IATI Publisher') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="wrapper">
  <div class="container">
    <header class="header">
      <nav class="nav">
        <a class="nav__logo" href="#"><img src="/img/logo.svg" alt="logo"></a>
        <ul class="nav__list">
          <li><a class="nav__links" href="#">ABOUT</a></li>
          <li><a class="nav__links" href="#">STEP-BY-STEP PUBLISHING GUIDE</a></li>
          <div class="dropdown">
            <li><a class="nav__links" href="#">IATI STANDARD</a></li>
            <div class="dropdown__content">
              <strong>IATI Standard</strong>
              <p>The IATI Standard is a set of rules and guidance on how to publish useful development and humanitarian data. Find out the full range of data included in the IATI Standard and more about its technical format.</p>
              <button class="btn">Read more</button>
            </div>
          </div>
          <li><a class="nav__links" href="#">SUPPORT</a></li>
        </ul>
        <div class="languages">
          <ul>
            LANGUAGE: <li><a class="nav__links" href="en.html">EN</a></li>
            <li><a class="nav__links" href="fr.html">FR</a></li>
            <li><a class="nav__links" href="#">ES</a></li>
          </ul>
        </div>
      </nav>
      <div class="header__title">
        <h1>IATI Publisher</h1>
      </div>
    </header>

    <section class="main">
      <div class="left">
        <div class="left__container">
          <div class="left__content">
            <span class="left__title">IATI Publishing Tool</span>
            <p>Welcome to IATI Publisher. Use this tool to start your IATI publishing journey. Enter
              your login
              information if you're already a user or create a new account if you're new here.</p>
            <span class="blue">Haven't registered yet? <a href="#">Join Now</a></span>
          </div>
        </div>
      </div>
      <div class="right">
        <div class="right__container">
          <div class="right__content">
            <h2>Sign In.</h2>
            <span class="gray">Welcome back! Please enter your details.</span>
            <div class="username">
              <label for="Username">Username</label>
              <input type="text" placeholder="Enter a registered username.">
              <i class="uil uil-user"></i>
            </div>
            <div class="password">
              <label for="Password">Password</label>
              <input type="text" placeholder="Enter a correct password.">
              <i class="uil uil-lock"></i>
            </div>
            <span class="reset">Forgot your password? <span><a href="#">Reset.</a></span></span>
            <button class="btn">SIGN IN <img src="/img/right-arrow.png" alt=""></button>
          </div>
        </div>
      </div>
    </section>

  </div>
  <footer class="footer">
    <div class="footer__container">
      <div class="footer__content">
        <div class="footer__logo">
          <a href="#"><img src="/img/logo-white.svg" alt="logo"></a>
        </div>
        <div class="footer__nav">
          <h4>IATI Publisher</h4>
          <a href="#">Home</a>
          <a href="#">About</a>
          <a href="#">Sign In</a>
          <a href="#">Join Now</a>
        </div>
        <div class="footer__standard">
          <h4>IATI Standard</h4>
          <a href="#">About IATI Standard</a>
          <a href="#">Step-by-step publishing guide</a>
          <a href="#">Using Data</a>
          <a href="#">Support</a>
        </div>
        <div class="footer__contact">
          <p>Part of the IATI Unified Platform <br>
            code licensed under the GNU AGPL. <br>
            Documnetation licensed under CC BY 3.0</p>
          <div class="contact">
            <i class="ri-customer-service-line"></i>
            <span>FOR QUERIES, CONTACT SUPPORT</span>
          </div>
          <span>support@iatistandard.org</span>
        </div>
      </div>
    </div>
  </footer>
  <div class="copyright">
    <span><i class="uil uil-copyright"></i> Copyright IATI 2022. All rights reserved.</span>
    <div class="footer__social">
      <a href="#"><i class="ri-twitter-fill"></i></a>
      <a href="#"><i class="ri-youtube-fill"></i></a>
    </div>
  </div>
</div>
</body>
</html>
