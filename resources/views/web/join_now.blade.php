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
        <span>Already a member? <a class="text-Turquoise" href="#">Sign In</a></span>
      </div>
    </div>
    <div
      class="right basis-2/4 m-auto -mt-64 md:my-0 bg-white rounded-l-lg lg:rounded-l-none rounded-r-lg py-10 px-7 lg:px-14 lg:py-28 xl:px-24">
      <div class="right__container flex flex-col">
        <h2 class="text-N-N50 font-bold mb-2">Join Now.</h2>
        <span class="text-N-N40 mb-8">To being this journey, tell us your perference and we'll guide you
          through this process.</span>
        <a href="#" class="right__content flex items-center bg-white mb-6 py-6 px-5 rounded-lg">
          <div>
            <svg width="52" height="52" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="26" cy="26" r="25.25" stroke="currentColor" stroke-width="1.5" />
              <path
                d="M37.4 37.82c-.051-.609-.05-5.383-.036-8.318a.6.6 0 0 0-.598-.604h-.003a.6.6 0 0 0-.6.598c0 .022-.01 2.12-.01 4.204.002 2.112.004 3.224.029 3.834l-9.849 2.963a.597.597 0 0 0 .054-.248v-7.897a.6.6 0 1 0-1.202 0v7.897c0 .055.009.108.022.159l-9.56-2.908-.008-7.9a.6.6 0 0 0-.6-.601h-.001a.6.6 0 0 0-.6.6l.007 8.347a.6.6 0 0 0 .425.574l10.868 3.304a.592.592 0 0 0 .348 0l10.903-3.28a.6.6 0 0 0 .41-.724Zm-.472-.44Z"
                fill="currentColor" stroke="#18ACB2" stroke-width=".3" />
              <path
                d="m40.04 23.746-3.365-1.902-.013-.006a12.004 12.004 0 0 0-2.331-3.259.6.6 0 1 0-.847.852 10.778 10.778 0 0 1 2.624 4.217l-1.582.433c-1.258-3.633-4.733-6.132-8.613-6.132-1.608 0-3.189.425-4.572 1.228a.601.601 0 0 0 .603 1.039 7.908 7.908 0 0 1 3.969-1.066 7.95 7.95 0 0 1 7.45 5.25l-1.583.433a6.312 6.312 0 0 0-5.867-4.047 6.295 6.295 0 0 0-5.879 4.075l-1.586-.425a7.94 7.94 0 0 1 1.871-2.97.6.6 0 1 0-.85-.849 9.148 9.148 0 0 0-2.184 3.506l-1.583-.425c.102-.31.218-.613.346-.909.1-.102.161-.236.172-.376a10.776 10.776 0 0 1 9.693-6.1c1.89 0 3.749.497 5.375 1.439a.601.601 0 0 0 .602-1.04 11.949 11.949 0 0 0-5.977-1.6 11.98 11.98 0 0 0-10.814 6.86l-3.139 1.774a.6.6 0 0 0 .358 1.12l1.32-.136-1.473 1.87a.599.599 0 0 0 .301.947l11.361 3.378a.601.601 0 0 0 .691-.274l1.409-2.418 1.31 2.177a.6.6 0 0 0 .673.27l11.447-3.129a.602.602 0 0 0 .313-.951l-1.487-1.889 1.499.156a.6.6 0 0 0 .358-1.12Zm-14.127-1.758a5.104 5.104 0 0 1 4.702 3.165l-4.703 1.288-4.71-1.265a5.09 5.09 0 0 1 4.711-3.188Zm-2.196 7.652-10.061-2.992 1.46-1.855L25 27.439l-1.282 2.201Zm4.315-.24-1.184-1.964 9.87-2.643 1.448 1.838-10.134 2.77ZM21.585 13.43a.601.601 0 0 0 1.155-.33l-.8-2.803a.601.601 0 0 0-1.156.33l.801 2.804ZM29.34 13.909a.601.601 0 0 0 .742-.412l.8-2.804a.6.6 0 1 0-1.155-.33l-.8 2.804a.6.6 0 0 0 .412.742ZM35.91 17.586a.601.601 0 0 0 .42-.17l2.053-2.003a.6.6 0 1 0-.839-.86l-2.052 2.002a.6.6 0 0 0 .419 1.03ZM15.37 17.365a.602.602 0 0 0 .84-.86l-2.003-1.952a.6.6 0 1 0-.838.86l2.001 1.952Z"
                fill="currentColor" stroke="#18ACB2" stroke-width=".3" />
            </svg>
          </div>
          <div class="mx-4 xl:px-1">
            <span class="text-sm text-bluecoral font-bold">I am new to IATI</span>
            <p class="text-xs text-N-N40 leading-5">Use this option if your organisation has not
              registered an account with IATI on the IATI Registry</p>
          </div>
          <div>
            <svg class="right__arrow" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 12h18M16 7l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </div>
        </a>
        <a href="#" class="right__content flex items-center bg-white mb-4 py-6 px-5 rounded-lg">
          <div>
            <svg width="52" height="52" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="26" cy="26" r="25.25" stroke="currentColor" stroke-width="1.5" />
              <path
                d="M20.871 17.208A10.167 10.167 0 0 1 26 15.823a10.11 10.11 0 0 1 7.196 2.98.566.566 0 0 0 .804 0A.57.57 0 0 0 34 18a11.24 11.24 0 0 0-8-3.313c-2.008 0-3.98.532-5.703 1.54a.568.568 0 1 0 .574.982Z"
                fill="currentColor" stroke="#18ACB2" stroke-width=".3" />
              <path
                d="M26 12c-3.78 0-7.321 1.482-9.974 4.175a.57.57 0 0 0 .81.798A12.77 12.77 0 0 1 26 13.137c7.092 0 12.863 5.77 12.863 12.863 0 2.184-.548 4.244-1.513 6.047L35.58 29.34a4.381 4.381 0 0 0 1.734-3.49 4.392 4.392 0 0 0-4.388-4.388 4.34 4.34 0 0 0-2.389.707 5.93 5.93 0 0 0-9.123.06 4.377 4.377 0 0 0-2.479-.767 4.392 4.392 0 0 0-4.387 4.387c0 1.415.674 2.674 1.716 3.477l-1.635 2.681a12.86 12.86 0 0 1 .204-12.393.569.569 0 1 0-.987-.565A14 14 0 0 0 12 26c0 5.095 2.736 9.564 6.817 12.013a.566.566 0 0 0 .325.189A13.911 13.911 0 0 0 26 40c7.719 0 14-6.28 14-14S33.719 12 26 12Zm6.925 10.599a3.253 3.253 0 0 1 3.25 3.25 3.253 3.253 0 0 1-3.25 3.25c-.576 0-1.127-.15-1.618-.434A5.906 5.906 0 0 0 31.94 26a5.903 5.903 0 0 0-.757-2.896 3.217 3.217 0 0 1 1.74-.505ZM26 21.196A4.81 4.81 0 0 1 30.803 26 4.81 4.81 0 0 1 26 30.804 4.81 4.81 0 0 1 21.195 26 4.81 4.81 0 0 1 26 21.196Zm-10.316 4.653a3.253 3.253 0 0 1 5.092-2.678A5.905 5.905 0 0 0 20.058 26c0 .933.217 1.816.601 2.603a3.253 3.253 0 0 1-4.976-2.754Zm3.381 10.981a12.962 12.962 0 0 1-3.779-3.719l1.959-3.213c.52.218 1.09.339 1.689.339.832 0 1.627-.23 2.321-.665a6 6 0 0 0 1.3 1.265l-3.49 5.993ZM26 38.864c-2.146 0-4.17-.53-5.951-1.463l3.49-5.995c.75.343 1.583.535 2.46.535.861 0 1.68-.185 2.418-.516l3.495 5.997A12.784 12.784 0 0 1 26 38.864Zm6.897-2.01-3.49-5.99c.49-.345.926-.762 1.292-1.235a4.349 4.349 0 0 0 2.226.607c.59 0 1.152-.118 1.666-.33l2.11 3.224a12.973 12.973 0 0 1-3.804 3.723Z"
                fill="currentColor" stroke="#18ACB2" stroke-width=".3" />
              <path
                d="M26 29.803a3.823 3.823 0 0 0 3.048-1.528.569.569 0 0 0-.91-.68 2.668 2.668 0 0 1-4.337-.086.569.569 0 0 0-.938.643A3.804 3.804 0 0 0 26 29.803Z"
                fill="currentColor" stroke="#18ACB2" stroke-width=".3" />
            </svg>
          </div>
          <div class="mx-4 xl:px-1">
            <span class="text-sm text-bluecoral font-bold">My organisation has registered with IATI</span>
            <p class="text-xs text-N-N40 leading-5">Use this option if your organization is listed as an
              IATI publisher of the IATI Registry</p>
          </div>
          <div>
            <svg class="right__arrow" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 12h18M16 7l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </div>
        </a>
        <span class="text-sm text-N-N40">Not sure which one to select? <a
            class="hover:border-b-2 hover:border-b-Turquoise text-bluecoral font-bold" href="#">Contact
            Support.</a></span>
      </div>
    </div>
  </section>
@endsection
