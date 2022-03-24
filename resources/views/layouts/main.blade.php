@extends('welcome')

@section('content')

<main class="main">
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
</main>

@endsection
