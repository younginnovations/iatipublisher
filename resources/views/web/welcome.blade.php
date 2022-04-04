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
              <input class="username input sm:h-16" type="text" placeholder="Enter a registered username" name="username">
              <div class="text-xl absolute top-11 sm:top-12 left-5 sm:left-6">
                {!! file_get_contents(public_path('/images/user.svg')) !!}
              </div>
              @error('username')
                <span class="error" role="alert">
                  {{ $message }}
                </span>
              @enderror
            </div>
            <div class="mb-4 flex flex-col text-bluecoral font-bold text-sm relative">
              <label class="mb-2" for="Password">Password</label>
              <input class="password input sm:h-16" type="password" placeholder="Enter a correct password"
                name="password">
              <div class="text-xl absolute top-11 sm:top-12 left-5 sm:left-6">
                {!! file_get_contents(public_path('/images/pw-lock.svg')) !!}
              </div>
              @error('password')
                <span class="error" role="alert">
                  {{ $message }}
                </span>
              @enderror
            </div>
            <p class="text-n-40 mb-6 text-sm">Forgot your password? <span><a
                  class="border-b-2 border-b-transparent hover:border-b-2 hover:border-b-turquoise text-bluecoral font-bold" href="#">Reset.</a></span>
            </p>
            <button type="submit" id="btn"
              class="btn group text-sm flex justify-center bg-turquoise border-none duration-200 text-n-50 hover:bg-bluecoral hover:text-white font-bold outline-none rounded-lg relative">SIGN
              IN
              <div class="text-xl absolute right-7 group-hover:translate-x-1 hover:fill-white duration-200">
                {!! file_get_contents(public_path('/images/arrow-right.svg')) !!}
              </div>
            </button>
          </div>

        </form>
      </div>
    </div>
  </section>
@endsection
