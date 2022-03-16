@extends('web.layouts.app')

@section('content')
  <section class="main flex justify-between mx-24 px-1 mt-10">
    <div class="left basis-2/4 bg-bluecoral rounded-l-lg py-44 px-24 text-white">
      <div class="left__container p-10 rounded-lg">
        <span class="left__title font-bold">IATI Publishing Tool</span>
        <p class="pt-6 pb-8">Welcome to IATI Publisher. Use this tool to start your IATI publishing journey.
          Enter
          your login
          information if you're already a user or create a new account if you're new here.</p>
        <span>Haven't registered yet? <a class="text-Turquoise" href="#">Sign In</a></span>
      </div>
    </div>
    <div class="right basis-2/4 bg-white rounded-r-lg py-24 px-24">
      <div class="right__container flex flex-col">
        <h2 class="text-Neutrals-N50 font-bold mb-2">Join Now.</h2>
        <span class="text-Neutrals-N40 mb-8">To being this journey, tell us your perference and we'll guide you
          through this process.</span>
        <div class="right__content flex items-center bg-white mb-6 py-6 px-5 rounded-lg">
          <img src="/images/default 1.svg" alt="default 1">
          <div class="ml-4">
            <span class="text-sm text-bluecoral font-bold">I am new to IATI</span>
            <p class="text-xs text-Neutrals-N40 leading-5">Use this option if your organisation has not
              registered an account with IATI on the IATI Registry</p>
          </div>
        </div>
        <div class="right__content flex items-center bg-white mb-4 py-6 px-5 rounded-lg">
          <img src="/images/default 2.svg" alt="default 2">
          <div class="ml-4">
            <span class="text-sm text-bluecoral font-bold">My organisation has registered with IATI</span>
            <p class="text-xs text-Neutrals-N40 leading-5">Use this option if your organization is listed as an
              IATI publisher of the IATI Registry</p>
          </div>
        </div>
        <span class="text-sm text-Neutrals-N40">Not sure which one to select? <a class="text-bluecoral font-bold"
            href="#">Contact Support.</a></span>
      </div>
    </div>
  </section>
@endsection
