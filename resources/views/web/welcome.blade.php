@extends('web.layouts.app')

@section('content')
  <section class="main sm:mx-10 xl:mx-24 xl:px-1 mt-7 sm:mt-10">
    <div class="main__container md:flex">
      <div
        class="left md:basis-2/4 flex flex-col justify-center items-center bg-bluecoral sm:rounded-r-lg md:rounded-r-none sm:rounded-l-lg pt-5 sm:pt-10 lg:pt-44 pb-72 md:pb-16 lg:pb-44 px-3 sm:px-5 xl:px-24 text-white">
        <div class="left__container p-5 sm:p-10 rounded-lg">
          <span class="left__title font-bold">IATI Publishing Tool</span>
          <p class="pt-2 sm:pt-6 sm:pb-8">Welcome to IATI Publisher. Use this tool to start your IATI publishing
            journey.
            Enter
            your login
            information if you're already a user or create a new account if you're new here.</p>
          <span class="hidden sm:block">Haven't registered yet? <a class="text-turquoise" href="join_now.blade.php">Join
              Now</a></span>
        </div>
      </div>
      <div id="right"
        class="right basis-2/4 m-auto md:my-0 bg-white rounded-l-lg md:rounded-l-none rounded-r-lg py-5 px-5 sm:py-10 sm:px-10 lg:px-14 lg:py-28 xl:px-24">
        <form method="GET" action="" class="form">
          <div class="right__container flex flex-col">
            <h2 class="hidden sm:block text-n-50 font-bold mb-2 text-4xl sm:text-heading-3">Sign In.</h2>
            <span class="text-n-40">Welcome back! Please enter your details.</span>
            <div class="mt-6 mb-4 flex flex-col text-bluecoral font-bold text-sm relative">
              <label class="mb-2" for="Username">Username</label>
              <input class="username input" type="text" placeholder="Enter a registered username" name="username">
              <svg class="absolute top-11 sm:top-12 left-5 sm:left-6" width="20" height="22" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="m13.504 11.448-.455.358.538.214a9.667 9.667 0 0 1 6.042 7.916.667.667 0 0 1-.57.73h-.091a.667.667 0 0 1-.667-.593 8.333 8.333 0 0 0-16.562 0A.673.673 0 0 1 .4 19.926a9.667 9.667 0 0 1 6.013-7.907l.536-.214-.454-.357a5.667 5.667 0 1 1 7.008 0Zm-5.911-.845a4.334 4.334 0 1 0 4.815-7.207 4.334 4.334 0 0 0-4.815 7.207Z"
                  fill="#155366" stroke="#155366" stroke-width=".667" />
              </svg>
              @error('username')
                <span class="error" role="alert">
                  {{ $message }}
                </span>
              @enderror
            </div>
            <div class="mb-4 flex flex-col text-bluecoral font-bold text-sm relative">
              <label class="mb-2" for="Password">Password</label>
              <input class="password input" type="password" placeholder="Enter a correct password" name="password">
              <svg class="absolute top-11 sm:top-12 left-5 sm:left-6 mt-1" width="16" height="20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M12.667 7v.333H13A2.667 2.667 0 0 1 15.667 10v7A2.667 2.667 0 0 1 13 19.667H3A2.667 2.667 0 0 1 .333 17v-7A2.667 2.667 0 0 1 3 7.333h.333V5a4.667 4.667 0 0 1 9.334 0v2ZM11 7.333h.333V5a3.333 3.333 0 0 0-6.666 0v2.333H11Zm2.943 10.61c.25-.25.39-.59.39-.943v-7A1.333 1.333 0 0 0 13 8.667H3A1.333 1.333 0 0 0 1.667 10v7A1.333 1.333 0 0 0 3 18.333h10c.354 0 .693-.14.943-.39Z"
                  fill="#155366" stroke="#155366" stroke-width=".667" />
              </svg>
              @error('password')
                <span class="error" role="alert">
                  {{ $message }}
                </span>
              @enderror
            </div>
            <p class="text-n-40 mb-6 text-sm">Forgot your password? <span><a
                  class="hover:border-b-2 hover:border-b-turquoise text-bluecoral font-bold" href="#">Reset.</a></span>
            </p>
            <button type="submit" id="btn"
              class="btn group flex justify-center bg-turquoise border-none duration-200 text-n-50 hover:bg-bluecoral hover:text-white font-bold outline-none rounded-lg relative">SIGN
              IN
              <svg class="absolute right-7 group-hover:translate-x-1 hover:fill-white duration-200" width="24" height="24"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 12h18M16 7l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </button>
          </div>

        </form>
      </div>
    </div>
  </section>
@endsection
