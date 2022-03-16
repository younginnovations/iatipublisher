@extends('web.layouts.app')

@section('content')
  <section class="main md:flex mx-5 sm:mx-10 xl:mx-24 xl:px-1 mt-10">
    <div
      class="left md:basis-2/4 flex flex-col justify-center items-center bg-bluecoral rounded-r-lg lg:rounded-r-none rounded-l-lg pt-14 lg:pt-44 pb-72 md:pb-16 lg:pb-44 px-7 xl:px-24 text-white">
      <div class="left__container p-10 rounded-lg">
        <span class="left__title font-bold">IATI Publishing Tool</span>
        <p class="pt-6 pb-8">Welcome to IATI Publisher. Use this tool to start your IATI publishing journey.
          Enter
          your login
          information if you're already a user or create a new account if you're new here.</p>
        <span>Haven't registered yet? <a class="text-Turquoise" href="joinNow.blade.php">Join Now</a></span>
      </div>
    </div>
    <div
      class="right w-10/12 basis-2/4 m-auto -mt-64 md:my-0 bg-white rounded-l-lg lg:rounded-l-none rounded-r-lg py-10 px-7 lg:px-14 lg:py-28 xl:px-24">
      <div class="right__container flex flex-col">
        <h2 class="text-Neutrals-N50 font-bold mb-2">Sign In.</h2>
        <span class="text-Neutrals-N40">Welcome back! Please enter your details.</span>
        <div class="username mt-6 mb-4 flex flex-col text-bluecoral font-bold text-sm relative">
          <label class="mb-2" for="Username">Username</label>
          <input class="py-5 box-border outline-none rounded-lg placeholder:text-Neutrals-N40 text-base" type="text"
            placeholder="Enter a registered username.">
          <img class="absolute top-12 left-6" width="20px" height="22px" src="/images/user.svg" alt="user">
        </div>
        <div class="password mb-4 flex flex-col text-bluecoral font-bold text-sm relative">
          <label class="mb-2" for="Password">Password</label>
          <input class="py-5 box-border outline-none rounded-lg placeholder:text-Neutrals-N40 text-base" type="password"
            placeholder="Enter a correct password.">
          <img class="absolute top-12 left-6" width="16px" height="20px" src="/images/pw.svg" alt="pw_lock">
        </div>
        <span class="text-Neutrals-N40 mb-6 text-sm">Forgot your password? <span><a class="text-bluecoral font-bold"
              href="#">Reset.</a></span></span>
        <button
          class="btn flex justify-center bg-Turquoise border-none text-Neutrals-N50 font-bold outline-none rounded-lg relative">SIGN
          IN
          <img class="absolute right-7" src="/images/Arrow_Left_LG.svg" alt="arrow">
        </button>
      </div>
    </div>
  </section>
@endsection
