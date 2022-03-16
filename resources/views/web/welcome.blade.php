@extends('web.layouts.app')

@section('content')
  <section class="main md:flex mx-5 sm:mx-10 xl:mx-24 xl:px-1 mt-10">
    <div
      class="left md:basis-2/4 flex flex-col justify-center items-center bg-bluecoral rounded-r-lg md:rounded-r-none rounded-l-lg pt-14 lg:pt-44 pb-72 md:pb-16 lg:pb-44 px-7 xl:px-24 text-white">
      <div class="left__container p-10 rounded-lg">
        <span class="left__title font-bold">IATI Publishing Tool</span>
        <p class="pt-6 pb-8">Welcome to IATI Publisher. Use this tool to start your IATI publishing journey.
          Enter
          your login
          information if you're already a user or create a new account if you're new here.</p>
        <span>Haven't registered yet? <a class="text-Turquoise" href="join_now.blade.php">Join Now</a></span>
      </div>
    </div>
    <div id="right"
      class="right basis-2/4 m-auto -mt-64 md:my-0 bg-white rounded-l-lg md:rounded-l-none rounded-r-lg py-10 px-7 lg:px-14 lg:py-28 xl:px-24">
      <div class="right__container flex flex-col">
        <h2 class="text-N-N50 font-bold mb-2">Sign In.</h2>
        <span class="text-N-N40">Welcome back! Please enter your details.</span>
        <div class="username mt-6 mb-4 flex flex-col text-bluecoral font-bold text-sm relative">
          <label class="mb-2" for="Username">Username</label>
          <input class="py-5 box-border outline-none rounded-lg placeholder:text-N-N40 text-base" type="text"
            placeholder="Enter a registered username.">
          <svg class="absolute top-12 left-6" width="20" height="22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="m13.504 11.448-.455.358.538.214a9.667 9.667 0 0 1 6.042 7.916.667.667 0 0 1-.57.73h-.091a.667.667 0 0 1-.667-.593 8.333 8.333 0 0 0-16.562 0A.673.673 0 0 1 .4 19.926a9.667 9.667 0 0 1 6.013-7.907l.536-.214-.454-.357a5.667 5.667 0 1 1 7.008 0Zm-5.911-.845a4.334 4.334 0 1 0 4.815-7.207 4.334 4.334 0 0 0-4.815 7.207Z"
              fill="#155366" stroke="#155366" stroke-width=".667" />
          </svg>
        </div>
        <div class="password mb-4 flex flex-col text-bluecoral font-bold text-sm relative">
          <label class="mb-2" for="Password">Password</label>
          <input class="py-5 box-border outline-none rounded-lg placeholder:text-N-N40 text-base" type="password"
            placeholder="Enter a correct password.">
          <svg class="absolute top-12 left-6 mt-1" width="16" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M12.667 7v.333H13A2.667 2.667 0 0 1 15.667 10v7A2.667 2.667 0 0 1 13 19.667H3A2.667 2.667 0 0 1 .333 17v-7A2.667 2.667 0 0 1 3 7.333h.333V5a4.667 4.667 0 0 1 9.334 0v2ZM11 7.333h.333V5a3.333 3.333 0 0 0-6.666 0v2.333H11Zm2.943 10.61c.25-.25.39-.59.39-.943v-7A1.333 1.333 0 0 0 13 8.667H3A1.333 1.333 0 0 0 1.667 10v7A1.333 1.333 0 0 0 3 18.333h10c.354 0 .693-.14.943-.39Z"
              fill="#155366" stroke="#155366" stroke-width=".667" />
          </svg>
        </div>
        <span class="text-N-N40 mb-6 text-sm">Forgot your password? <span><a class="text-bluecoral font-bold"
              href="#">Reset.</a></span></span>
        <button
          class="btn flex justify-center bg-Turquoise border-none text-N-N50 font-bold outline-none rounded-lg relative">SIGN
          IN
          <svg class="absolute right-7" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 12h18M16 7l5 5-5 5" stroke="#2A2F30" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </button>
      </div>
    </div>
  </section>
@endsection
