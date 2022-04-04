<footer class="bg-bluecoral mt-7 sm:mt-10 md:mt-20 text-n-20 text-sm leading-6">
  <div class="border-b border-white border-opacity-20">
    <div class="mx-3 sm:mx-10 xl:mx-24 xl:px-1 py-10">
      <div
        class="footer__container grid grid-flow-row md:grid-cols-2 lg:grid-cols-4 lg:justify-items-center gap-8 sm:gap-y-10">
        <div>
          <a href="#">
            <img class="w-60 sm:w-auto" src='/images/logo-white.svg' alt='iati logo' />
          </a>
        </div>
        <div class="footer__links">
          <span class="text-n-10 font-bold">IATI Publisher</span>
          <ul class="flex flex-col mt-2">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Sign In</a></li>
            <li><a href="#">Join Now</a></li>
          </ul>
        </div>
        <div class="footer__links">
          <span class="text-n-10 font-bold">IATI Standard</span>
          <ul class="flex flex-col mt-2">
            <li><a href="#">About IATI Standard</a></li>
            <li><a href="#">Step-by-step publishing guide</a></li>
            <li><a href="#">Using Data</a></li>
            <li><a href="#">Support</a></li>
          </ul>
        </div>
        <div class="footer__links lg:justify-self-end">
          <div class="leading-5 text-xs">
            <p>Part of the IATI Unified Platform</p>
            <p>Code licensed under the GNU AGPL.</p>
            <p>Documnetation licensed under CC BY 3.0</p>
          </div>
          <div class="text-n-10 flex items-center space-x-2 my-5">
            <div class="text-2xl">
              {!! file_get_contents(public_path('/images/headphone.svg')) !!}
            </div>
            <span class="text-sm font-bold uppercase">For queries, contact support</span>
          </div>
          <ul>
            <li><a class="text-sm text-n-10" href="mailto:support@iatistandard.org">support@iatistandard.org</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="mx-5 sm:mx-10 xl:mx-24 xl:px-1 py-7">
    <div class="footer__container grid sm:grid-cols-2 gap-3">
      <span class="flex items-center">
        <div class="mt-1 mr-1 text-xl">
          {!! file_get_contents(public_path('/images/copyright.svg')) !!}
        </div>
        Copyright IATI 2022. All rights reserved.
      </span>
      <div class="flex sm:justify-end">
        <a href="#">
          <div class="mt-1 mr-1 text-4xl">
            {!! file_get_contents(public_path('/images/youtube.svg')) !!}
          </div>
        </a>
        <a class="ml-4" href="#">
          <div class="mt-1 mr-1 text-4xl">
            {!! file_get_contents(public_path('/images/twitter.svg')) !!}
          </div>
        </a>
      </div>
    </div>
  </div>
</footer>
