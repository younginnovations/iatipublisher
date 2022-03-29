<template>
  <div class="wrapper relative h-56 bg-bluecoral sm:h-72">
    <div class="mx-3 sm:mx-10 xl:mx-24 xl:px-1">
      <header class="relative z-10 grid">
        <nav
          class="relative z-10 mt-6 flex items-center justify-between rounded-md bg-white px-5 pt-5 text-xs sm:mt-12 sm:px-10"
        >
          <a class="pb-5" href="#">
            <img
              class="w-52 sm:w-auto"
              src="/images/logo.svg"
              alt="iati logo"
            />
          </a>
          <div>
            <ul
              id="nav-list"
              class="nav__list flex pt-10 leading-5 xl:space-x-3"
            >
              <li class="nav__links active"><a href="#about">ABOUT</a></li>
              <li class="nav__links active">
                <a href="#step-by-step-publishing-guide"
                  >STEP-BY-STEP PUBLISHING GUIDE</a
                >
              </li>
              <li class="nav__links active dropdown relative">
                <a href="#iati-standard">IATI STANDARD</a>
                <div
                  class="dropdown__content invisible absolute right-0 top-7 hidden h-56 bg-white py-7 px-8 opacity-0 duration-300 xl:block"
                >
                  <strong class="text-sm font-bold text-n-50"
                    >IATI Standard</strong
                  >
                  <p class="py-4 text-sm text-n-50">
                    The IATI Standard is a set of rules and guidance on how to
                    publish useful development and humanitarian data. Find out
                    the full range of data included in the IATI Standard and
                    more about its technical format.
                  </p>
                  <a
                    class="read__more rounded-sm bg-bluecoral px-5 pt-2 text-xs hover:bg-n-50"
                    href="#"
                    >Read more</a
                  >
                </div>
              </li>
              <li class="nav__links active"><a href="#support">SUPPORT</a></li>
              <li class="absolute bottom-4 left-0 right-0 xl:hidden">
                <div class="flex items-center justify-center">
                  <span class="mr-2 pt-5 pb-5 uppercase text-white xl:pt-0"
                    >Language:</span
                  >
                  <ul class="languages flex items-center justify-center">
                    <li class="nav__links">
                      <a class="nav__active links__active" href="#">EN</a>
                    </li>
                    <li class="nav__links"><a href="#">FR</a></li>
                    <li class="nav__links"><a href="#">ES</a></li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
          <div class="languages hidden pt-11 xl:block">
            <div class="flex">
              <span class="mr-2 pt-5 pb-5 uppercase xl:pt-0">Language:</span>
              <ul class="flex items-center justify-center">
                <li class="nav__links">
                  <a class="nav__active links__active" href="#">EN</a>
                </li>
                <li class="nav__links"><a href="#">FR</a></li>
                <li class="nav__links"><a href="#">ES</a></li>
              </ul>
            </div>
          </div>
          <div
            id="hamburger"
            class="hamburger relative mb-4 flex h-11 w-11 cursor-pointer items-center justify-center overflow-hidden rounded xl:hidden"
          >
            <span
              class="absolute h-1 w-10 rounded-lg bg-bluecoral duration-300"
            ></span>
            <span
              class="absolute h-1 w-10 rounded-lg bg-bluecoral duration-300"
            ></span>
            <span
              class="absolute h-1 w-10 rounded-lg bg-bluecoral duration-300"
            ></span>
          </div>
        </nav>
        <div
          class="header__title mt-6 border-l-4 border-l-turquoise py-2 px-4 sm:py-5 sm:px-6"
        >
          <h1 class="text-4xl font-bold text-white sm:text-heading-2">
            IATI Publisher
          </h1>
        </div>
      </header>
    </div>
  </div>
</template>
