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
          <span class="hidden sm:block">Already a member? <a class="text-turquoise" href="#">Sign In</a></span>
        </div>
      </div>
      <div
        class="right basis-2/4 m-auto md:my-0 bg-white rounded-l-lg md:rounded-l-none rounded-r-lg py-5 sm:py-10 lg:py-28 px-5 sm:px-7 xl:px-20">
        <div class="right__container flex flex-col">
          <h2 class="hidden sm:block text-n-50 font-bold mb-2 text-4xl sm:text-heading-3">Join Now.</h2>
          <span class="text-n-40 mb-8">To being this journey, tell us your perference and we'll guide you
            through this process.</span>
          <a href="#" class="right__content flex items-center bg-white mb-6 p-5 rounded-lg">
            <div class="right__icon text-6xl">
              {!! file_get_contents(public_path('/images/default-1.svg')) !!}
            </div>
            <div class="details mx-4 xl:px-1">
              <span class="text-sm text-bluecoral font-bold">I am new to IATI</span>
              <p class="text-xs text-n-40 leading-5">Use this option if your organisation has not
                registered an account with IATI on the IATI Registry</p>
            </div>
            <div>
              <div class="right__arrow text-xl">
                {!! file_get_contents(public_path('/images/arrow-right.svg')) !!}
              </div>
            </div>
          </a>
          <a href="#" class="right__content flex items-center bg-white mb-4 p-5 rounded-lg">
            <div>
              <div class="right__icon text-6xl">
                {!! file_get_contents(public_path('/images/default-2.svg')) !!}
              </div>
            </div>
            <div class="details mx-4 xl:px-1">
              <span class="text-sm text-bluecoral font-bold">My organisation has registered with IATI</span>
              <p class="text-xs text-n-40 leading-5">Use this option if your organization is listed as an
                IATI publisher of the IATI Registry</p>
            </div>
            <div>
              <div class="right__arrow text-xl">
                {!! file_get_contents(public_path('/images/arrow-right.svg')) !!}
              </div>
            </div>
          </a>
          <span class="text-sm text-n-40">Not sure which one to select? <a
              class="border-b-2 border-b-transparent hover:border-b-2 hover:border-b-turquoise text-bluecoral font-bold"
              href="#">Contact
              Support.</a></span>
        </div>
      </div>
    </div>
  </section>
@endsection
