<template>
  <section class="section mb-7 sm:mx-10 sm:mb-10 md:mb-14 xl:mx-24 xl:px-1">
    <div class="section__container">
      <div class="section__title mt-7 text-center sm:mt-14">
        <h2>Create IATI Publisher Account</h2>
        <p>
          Register your organisation to start your IATI publishing journey by
          creating an account in IATI publisher.
        </p>
      </div>
      <EmailVerification v-if="true"></EmailVerification>
      <div v-else class="section__wrapper flex">
        <form method="POST" action="" class="form">
          <div class="form__container">
            <span class="text-2xl font-bold text-n-50"
              >Publisher Information</span
            >
            <div
              class="feedback mt-6 border-l-2 border-crimson-50 bg-crimson-10 p-4 text-sm text-n-50"
            >
              <p class="mb-2 flex font-bold">
                <svg
                  class="mr-2"
                  width="23"
                  height="21"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M11.887 15a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm10.67 1.47-8.05-14a3 3 0 0 0-5.24 0l-8 14A3 3 0 0 0 3.827 21h16.12a3 3 0 0 0 2.61-4.53Zm-1.73 2a1 1 0 0 1-.88.51H3.827a1 1 0 0 1-.88-.51 1 1 0 0 1 0-1l8-14a1 1 0 0 1 1.78 0l8.05 14a1 1 0 0 1 .05 1.02v-.02ZM11.887 7a1 1 0 0 0-1 1v4a1 1 0 0 0 2 0V8a1 1 0 0 0-1-1Z"
                    fill="#D1001E"
                  />
                </svg>
                Sorry, the information you provided doesn’t match your IATI
                Registry information.
              </p>
              <p class="ml-8 leading-5 xl:mr-1">
                Please note that if you’re an account holder in IATI Registry,
                make sure your
                <span class="font-bold"
                  >Publisher Name,Publisher ID and IATI Organisation ID</span
                >
                match your IATI Registry Information. Contact
                <span
                  ><a
                    class="text-n-40 hover:text-n-50"
                    href="mailto:support@iatistandard.org"
                    >support@iatistandard.org</a
                  ></span
                >
                for more details.
              </p>
            </div>
            <div class="form__content">
              <div class="col-span-2 mb-4">
                <div class="flex items-center justify-between">
                  <label class="label" for=""
                    >Publisher Name
                    <span class="text-crimson-40"> *</span>
                  </label>
                  <svg
                    width="15"
                    height="15"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M7.385 5.167c-.18 0-.359.043-.518.128-.16.085-.295.209-.39.362l-.004.006-.003.007a.346.346 0 0 1-.093.105.438.438 0 0 1-.455.033.37.37 0 0 1-.113-.093.314.314 0 0 1-.06-.117.287.287 0 0 1-.005-.124l-.329-.058.329.058a.305.305 0 0 1 .05-.119l.003-.006.004-.006a1.75 1.75 0 0 1 .663-.615 1.92 1.92 0 0 1 2.092.176c.324.256.537.606.607.985.07.378-.005.77-.215 1.105-.211.337-.546.6-.952.737l-.227.076v.36a.31.31 0 0 1-.103.227.414.414 0 0 1-.281.106c-.11 0-.21-.04-.281-.106A.31.31 0 0 1 7 8.167V7.5a.31.31 0 0 1 .104-.227.414.414 0 0 1 .28-.106c.272 0 .536-.1.735-.285a.977.977 0 0 0 .317-.715.977.977 0 0 0-.317-.716 1.08 1.08 0 0 0-.734-.284Zm0 0V5.5v-.333Zm-.368 4.906.011-.021.009-.023a.16.16 0 0 1 .02-.037.738.738 0 0 1 .051-.06.392.392 0 0 1 .12-.074.433.433 0 0 1 .313 0l.12-.31-.12.31a.39.39 0 0 1 .126.079c.034.032.06.07.077.108.017.039.026.08.025.12v.015a.29.29 0 0 1-.02.118v.001a.264.264 0 0 1-.067.097l.227.244-.227-.244a.321.321 0 0 1-.116.068l-.01.003-.01.005a.386.386 0 0 1-.293 0l-.01-.005-.01-.003a.321.321 0 0 1-.117-.068l-.227.244.227-.244a.264.264 0 0 1-.067-.097l-.006-.015-.007-.015a.193.193 0 0 1-.022-.093v-.036a.508.508 0 0 1-.002-.057.084.084 0 0 1 .005-.01ZM3.572 2.24a7.245 7.245 0 0 1 3.813-1.073c.902 0 1.795.165 2.627.485.833.32 1.588.789 2.223 1.378a6.324 6.324 0 0 1 1.478 2.055c.342.766.518 1.587.518 2.415a6 6 0 0 1-1.147 3.51 6.759 6.759 0 0 1-3.072 2.338 7.36 7.36 0 0 1-3.967.363 7.032 7.032 0 0 1-3.51-1.741A6.2 6.2 0 0 1 .669 8.73a5.892 5.892 0 0 1 .387-3.645A6.467 6.467 0 0 1 3.572 2.24Zm.446 9.978c.998.62 2.17.949 3.367.949 1.604 0 3.147-.592 4.288-1.652 1.142-1.06 1.789-2.504 1.789-4.015a5.4 5.4 0 0 0-1.031-3.158 6.007 6.007 0 0 0-2.729-2.08 6.488 6.488 0 0 0-3.498-.32 6.226 6.226 0 0 0-3.107 1.543A5.56 5.56 0 0 0 1.426 6.39a5.314 5.314 0 0 0 .348 3.287 5.773 5.773 0 0 0 2.244 2.54Z"
                      fill="#68797E"
                      stroke="#68797E"
                      stroke-width=".667"
                    />
                  </svg>
                </div>
                <input
                  class="form__input"
                  type="text"
                  placeholder="Enter the name of your organisation"
                />
              </div>

              <div class="mb-4">
                <div class="flex items-center justify-between">
                  <label class="label" for=""
                    >Publisher ID
                    <span class="text-crimson-40"> *</span>
                  </label>
                  <svg
                    width="15"
                    height="15"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M7.385 5.167c-.18 0-.359.043-.518.128-.16.085-.295.209-.39.362l-.004.006-.003.007a.346.346 0 0 1-.093.105.438.438 0 0 1-.455.033.37.37 0 0 1-.113-.093.314.314 0 0 1-.06-.117.287.287 0 0 1-.005-.124l-.329-.058.329.058a.305.305 0 0 1 .05-.119l.003-.006.004-.006a1.75 1.75 0 0 1 .663-.615 1.92 1.92 0 0 1 2.092.176c.324.256.537.606.607.985.07.378-.005.77-.215 1.105-.211.337-.546.6-.952.737l-.227.076v.36a.31.31 0 0 1-.103.227.414.414 0 0 1-.281.106c-.11 0-.21-.04-.281-.106A.31.31 0 0 1 7 8.167V7.5a.31.31 0 0 1 .104-.227.414.414 0 0 1 .28-.106c.272 0 .536-.1.735-.285a.977.977 0 0 0 .317-.715.977.977 0 0 0-.317-.716 1.08 1.08 0 0 0-.734-.284Zm0 0V5.5v-.333Zm-.368 4.906.011-.021.009-.023a.16.16 0 0 1 .02-.037.738.738 0 0 1 .051-.06.392.392 0 0 1 .12-.074.433.433 0 0 1 .313 0l.12-.31-.12.31a.39.39 0 0 1 .126.079c.034.032.06.07.077.108.017.039.026.08.025.12v.015a.29.29 0 0 1-.02.118v.001a.264.264 0 0 1-.067.097l.227.244-.227-.244a.321.321 0 0 1-.116.068l-.01.003-.01.005a.386.386 0 0 1-.293 0l-.01-.005-.01-.003a.321.321 0 0 1-.117-.068l-.227.244.227-.244a.264.264 0 0 1-.067-.097l-.006-.015-.007-.015a.193.193 0 0 1-.022-.093v-.036a.508.508 0 0 1-.002-.057.084.084 0 0 1 .005-.01ZM3.572 2.24a7.245 7.245 0 0 1 3.813-1.073c.902 0 1.795.165 2.627.485.833.32 1.588.789 2.223 1.378a6.324 6.324 0 0 1 1.478 2.055c.342.766.518 1.587.518 2.415a6 6 0 0 1-1.147 3.51 6.759 6.759 0 0 1-3.072 2.338 7.36 7.36 0 0 1-3.967.363 7.032 7.032 0 0 1-3.51-1.741A6.2 6.2 0 0 1 .669 8.73a5.892 5.892 0 0 1 .387-3.645A6.467 6.467 0 0 1 3.572 2.24Zm.446 9.978c.998.62 2.17.949 3.367.949 1.604 0 3.147-.592 4.288-1.652 1.142-1.06 1.789-2.504 1.789-4.015a5.4 5.4 0 0 0-1.031-3.158 6.007 6.007 0 0 0-2.729-2.08 6.488 6.488 0 0 0-3.498-.32 6.226 6.226 0 0 0-3.107 1.543A5.56 5.56 0 0 0 1.426 6.39a5.314 5.314 0 0 0 .348 3.287 5.773 5.773 0 0 0 2.244 2.54Z"
                      fill="#68797E"
                      stroke="#68797E"
                      stroke-width=".667"
                    />
                  </svg>
                </div>
                <input
                  class="form__input"
                  type="text"
                  placeholder="For example, ‘dfid’ or ‘wordlbank’"
                />
                <span class="text-tiny font-normal text-n-40"
                  >You can use a short unique acronym of your organisation's
                  name.
                </span>
              </div>

              <div class="mb-4">
                <div class="flex items-center justify-between">
                  <label class="label" for=""
                    >Country
                    <span class="text-crimson-40"> *</span>
                  </label>
                  <svg
                    width="15"
                    height="15"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M7.385 5.167c-.18 0-.359.043-.518.128-.16.085-.295.209-.39.362l-.004.006-.003.007a.346.346 0 0 1-.093.105.438.438 0 0 1-.455.033.37.37 0 0 1-.113-.093.314.314 0 0 1-.06-.117.287.287 0 0 1-.005-.124l-.329-.058.329.058a.305.305 0 0 1 .05-.119l.003-.006.004-.006a1.75 1.75 0 0 1 .663-.615 1.92 1.92 0 0 1 2.092.176c.324.256.537.606.607.985.07.378-.005.77-.215 1.105-.211.337-.546.6-.952.737l-.227.076v.36a.31.31 0 0 1-.103.227.414.414 0 0 1-.281.106c-.11 0-.21-.04-.281-.106A.31.31 0 0 1 7 8.167V7.5a.31.31 0 0 1 .104-.227.414.414 0 0 1 .28-.106c.272 0 .536-.1.735-.285a.977.977 0 0 0 .317-.715.977.977 0 0 0-.317-.716 1.08 1.08 0 0 0-.734-.284Zm0 0V5.5v-.333Zm-.368 4.906.011-.021.009-.023a.16.16 0 0 1 .02-.037.738.738 0 0 1 .051-.06.392.392 0 0 1 .12-.074.433.433 0 0 1 .313 0l.12-.31-.12.31a.39.39 0 0 1 .126.079c.034.032.06.07.077.108.017.039.026.08.025.12v.015a.29.29 0 0 1-.02.118v.001a.264.264 0 0 1-.067.097l.227.244-.227-.244a.321.321 0 0 1-.116.068l-.01.003-.01.005a.386.386 0 0 1-.293 0l-.01-.005-.01-.003a.321.321 0 0 1-.117-.068l-.227.244.227-.244a.264.264 0 0 1-.067-.097l-.006-.015-.007-.015a.193.193 0 0 1-.022-.093v-.036a.508.508 0 0 1-.002-.057.084.084 0 0 1 .005-.01ZM3.572 2.24a7.245 7.245 0 0 1 3.813-1.073c.902 0 1.795.165 2.627.485.833.32 1.588.789 2.223 1.378a6.324 6.324 0 0 1 1.478 2.055c.342.766.518 1.587.518 2.415a6 6 0 0 1-1.147 3.51 6.759 6.759 0 0 1-3.072 2.338 7.36 7.36 0 0 1-3.967.363 7.032 7.032 0 0 1-3.51-1.741A6.2 6.2 0 0 1 .669 8.73a5.892 5.892 0 0 1 .387-3.645A6.467 6.467 0 0 1 3.572 2.24Zm.446 9.978c.998.62 2.17.949 3.367.949 1.604 0 3.147-.592 4.288-1.652 1.142-1.06 1.789-2.504 1.789-4.015a5.4 5.4 0 0 0-1.031-3.158 6.007 6.007 0 0 0-2.729-2.08 6.488 6.488 0 0 0-3.498-.32 6.226 6.226 0 0 0-3.107 1.543A5.56 5.56 0 0 0 1.426 6.39a5.314 5.314 0 0 0 .348 3.287 5.773 5.773 0 0 0 2.244 2.54Z"
                      fill="#68797E"
                      stroke="#68797E"
                      stroke-width=".667"
                    />
                  </svg>
                </div>
                <input
                  class="form__input"
                  type="text"
                  placeholder="Select the country"
                />
              </div>

              <div class="mb-4">
                <div class="flex items-center justify-between">
                  <label class="label" for=""
                    >Organisation Registration Agency
                    <span class="text-crimson-40"> *</span>
                  </label>
                  <svg
                    width="15"
                    height="15"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M7.385 5.167c-.18 0-.359.043-.518.128-.16.085-.295.209-.39.362l-.004.006-.003.007a.346.346 0 0 1-.093.105.438.438 0 0 1-.455.033.37.37 0 0 1-.113-.093.314.314 0 0 1-.06-.117.287.287 0 0 1-.005-.124l-.329-.058.329.058a.305.305 0 0 1 .05-.119l.003-.006.004-.006a1.75 1.75 0 0 1 .663-.615 1.92 1.92 0 0 1 2.092.176c.324.256.537.606.607.985.07.378-.005.77-.215 1.105-.211.337-.546.6-.952.737l-.227.076v.36a.31.31 0 0 1-.103.227.414.414 0 0 1-.281.106c-.11 0-.21-.04-.281-.106A.31.31 0 0 1 7 8.167V7.5a.31.31 0 0 1 .104-.227.414.414 0 0 1 .28-.106c.272 0 .536-.1.735-.285a.977.977 0 0 0 .317-.715.977.977 0 0 0-.317-.716 1.08 1.08 0 0 0-.734-.284Zm0 0V5.5v-.333Zm-.368 4.906.011-.021.009-.023a.16.16 0 0 1 .02-.037.738.738 0 0 1 .051-.06.392.392 0 0 1 .12-.074.433.433 0 0 1 .313 0l.12-.31-.12.31a.39.39 0 0 1 .126.079c.034.032.06.07.077.108.017.039.026.08.025.12v.015a.29.29 0 0 1-.02.118v.001a.264.264 0 0 1-.067.097l.227.244-.227-.244a.321.321 0 0 1-.116.068l-.01.003-.01.005a.386.386 0 0 1-.293 0l-.01-.005-.01-.003a.321.321 0 0 1-.117-.068l-.227.244.227-.244a.264.264 0 0 1-.067-.097l-.006-.015-.007-.015a.193.193 0 0 1-.022-.093v-.036a.508.508 0 0 1-.002-.057.084.084 0 0 1 .005-.01ZM3.572 2.24a7.245 7.245 0 0 1 3.813-1.073c.902 0 1.795.165 2.627.485.833.32 1.588.789 2.223 1.378a6.324 6.324 0 0 1 1.478 2.055c.342.766.518 1.587.518 2.415a6 6 0 0 1-1.147 3.51 6.759 6.759 0 0 1-3.072 2.338 7.36 7.36 0 0 1-3.967.363 7.032 7.032 0 0 1-3.51-1.741A6.2 6.2 0 0 1 .669 8.73a5.892 5.892 0 0 1 .387-3.645A6.467 6.467 0 0 1 3.572 2.24Zm.446 9.978c.998.62 2.17.949 3.367.949 1.604 0 3.147-.592 4.288-1.652 1.142-1.06 1.789-2.504 1.789-4.015a5.4 5.4 0 0 0-1.031-3.158 6.007 6.007 0 0 0-2.729-2.08 6.488 6.488 0 0 0-3.498-.32 6.226 6.226 0 0 0-3.107 1.543A5.56 5.56 0 0 0 1.426 6.39a5.314 5.314 0 0 0 .348 3.287 5.773 5.773 0 0 0 2.244 2.54Z"
                      fill="#68797E"
                      stroke="#68797E"
                      stroke-width=".667"
                    />
                  </svg>
                </div>
                <input
                  class="form__input"
                  type="text"
                  placeholder="Select your Organisation Registration Agency"
                />
              </div>

              <div class="mb-4">
                <div class="flex items-center justify-between">
                  <label class="label" for=""
                    >Organisation Registration Number
                    <span class="text-crimson-40"> *</span>
                  </label>
                  <svg
                    width="15"
                    height="15"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M7.385 5.167c-.18 0-.359.043-.518.128-.16.085-.295.209-.39.362l-.004.006-.003.007a.346.346 0 0 1-.093.105.438.438 0 0 1-.455.033.37.37 0 0 1-.113-.093.314.314 0 0 1-.06-.117.287.287 0 0 1-.005-.124l-.329-.058.329.058a.305.305 0 0 1 .05-.119l.003-.006.004-.006a1.75 1.75 0 0 1 .663-.615 1.92 1.92 0 0 1 2.092.176c.324.256.537.606.607.985.07.378-.005.77-.215 1.105-.211.337-.546.6-.952.737l-.227.076v.36a.31.31 0 0 1-.103.227.414.414 0 0 1-.281.106c-.11 0-.21-.04-.281-.106A.31.31 0 0 1 7 8.167V7.5a.31.31 0 0 1 .104-.227.414.414 0 0 1 .28-.106c.272 0 .536-.1.735-.285a.977.977 0 0 0 .317-.715.977.977 0 0 0-.317-.716 1.08 1.08 0 0 0-.734-.284Zm0 0V5.5v-.333Zm-.368 4.906.011-.021.009-.023a.16.16 0 0 1 .02-.037.738.738 0 0 1 .051-.06.392.392 0 0 1 .12-.074.433.433 0 0 1 .313 0l.12-.31-.12.31a.39.39 0 0 1 .126.079c.034.032.06.07.077.108.017.039.026.08.025.12v.015a.29.29 0 0 1-.02.118v.001a.264.264 0 0 1-.067.097l.227.244-.227-.244a.321.321 0 0 1-.116.068l-.01.003-.01.005a.386.386 0 0 1-.293 0l-.01-.005-.01-.003a.321.321 0 0 1-.117-.068l-.227.244.227-.244a.264.264 0 0 1-.067-.097l-.006-.015-.007-.015a.193.193 0 0 1-.022-.093v-.036a.508.508 0 0 1-.002-.057.084.084 0 0 1 .005-.01ZM3.572 2.24a7.245 7.245 0 0 1 3.813-1.073c.902 0 1.795.165 2.627.485.833.32 1.588.789 2.223 1.378a6.324 6.324 0 0 1 1.478 2.055c.342.766.518 1.587.518 2.415a6 6 0 0 1-1.147 3.51 6.759 6.759 0 0 1-3.072 2.338 7.36 7.36 0 0 1-3.967.363 7.032 7.032 0 0 1-3.51-1.741A6.2 6.2 0 0 1 .669 8.73a5.892 5.892 0 0 1 .387-3.645A6.467 6.467 0 0 1 3.572 2.24Zm.446 9.978c.998.62 2.17.949 3.367.949 1.604 0 3.147-.592 4.288-1.652 1.142-1.06 1.789-2.504 1.789-4.015a5.4 5.4 0 0 0-1.031-3.158 6.007 6.007 0 0 0-2.729-2.08 6.488 6.488 0 0 0-3.498-.32 6.226 6.226 0 0 0-3.107 1.543A5.56 5.56 0 0 0 1.426 6.39a5.314 5.314 0 0 0 .348 3.287 5.773 5.773 0 0 0 2.244 2.54Z"
                      fill="#68797E"
                      stroke="#68797E"
                      stroke-width=".667"
                    />
                  </svg>
                </div>
                <input class="form__input" type="text" placeholder="" />
              </div>

              <div class="mb-4">
                <div class="flex items-center justify-between">
                  <label class="label" for=""
                    >IATI Organisational Identifier
                    <span class="text-crimson-40"> *</span>
                  </label>
                  <svg
                    width="15"
                    height="15"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M7.385 5.167c-.18 0-.359.043-.518.128-.16.085-.295.209-.39.362l-.004.006-.003.007a.346.346 0 0 1-.093.105.438.438 0 0 1-.455.033.37.37 0 0 1-.113-.093.314.314 0 0 1-.06-.117.287.287 0 0 1-.005-.124l-.329-.058.329.058a.305.305 0 0 1 .05-.119l.003-.006.004-.006a1.75 1.75 0 0 1 .663-.615 1.92 1.92 0 0 1 2.092.176c.324.256.537.606.607.985.07.378-.005.77-.215 1.105-.211.337-.546.6-.952.737l-.227.076v.36a.31.31 0 0 1-.103.227.414.414 0 0 1-.281.106c-.11 0-.21-.04-.281-.106A.31.31 0 0 1 7 8.167V7.5a.31.31 0 0 1 .104-.227.414.414 0 0 1 .28-.106c.272 0 .536-.1.735-.285a.977.977 0 0 0 .317-.715.977.977 0 0 0-.317-.716 1.08 1.08 0 0 0-.734-.284Zm0 0V5.5v-.333Zm-.368 4.906.011-.021.009-.023a.16.16 0 0 1 .02-.037.738.738 0 0 1 .051-.06.392.392 0 0 1 .12-.074.433.433 0 0 1 .313 0l.12-.31-.12.31a.39.39 0 0 1 .126.079c.034.032.06.07.077.108.017.039.026.08.025.12v.015a.29.29 0 0 1-.02.118v.001a.264.264 0 0 1-.067.097l.227.244-.227-.244a.321.321 0 0 1-.116.068l-.01.003-.01.005a.386.386 0 0 1-.293 0l-.01-.005-.01-.003a.321.321 0 0 1-.117-.068l-.227.244.227-.244a.264.264 0 0 1-.067-.097l-.006-.015-.007-.015a.193.193 0 0 1-.022-.093v-.036a.508.508 0 0 1-.002-.057.084.084 0 0 1 .005-.01ZM3.572 2.24a7.245 7.245 0 0 1 3.813-1.073c.902 0 1.795.165 2.627.485.833.32 1.588.789 2.223 1.378a6.324 6.324 0 0 1 1.478 2.055c.342.766.518 1.587.518 2.415a6 6 0 0 1-1.147 3.51 6.759 6.759 0 0 1-3.072 2.338 7.36 7.36 0 0 1-3.967.363 7.032 7.032 0 0 1-3.51-1.741A6.2 6.2 0 0 1 .669 8.73a5.892 5.892 0 0 1 .387-3.645A6.467 6.467 0 0 1 3.572 2.24Zm.446 9.978c.998.62 2.17.949 3.367.949 1.604 0 3.147-.592 4.288-1.652 1.142-1.06 1.789-2.504 1.789-4.015a5.4 5.4 0 0 0-1.031-3.158 6.007 6.007 0 0 0-2.729-2.08 6.488 6.488 0 0 0-3.498-.32 6.226 6.226 0 0 0-3.107 1.543A5.56 5.56 0 0 0 1.426 6.39a5.314 5.314 0 0 0 .348 3.287 5.773 5.773 0 0 0 2.244 2.54Z"
                      fill="#68797E"
                      stroke="#68797E"
                      stroke-width=".667"
                    />
                  </svg>
                </div>
                <input class="form__input" type="text" placeholder="" />
                <span class="text-tiny font-normal text-n-40"
                  >This will be autogenerated.</span
                >
              </div>
            </div>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm font-normal text-n-40"
              >Already have an account?
              <a
                class="font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise"
                href="#"
                >Sign In.</a
              ></span
            >
            <button class="btn btn-primary">
              Next Step
              <svg
                width="24"
                height="24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M3 12h18M16 7l5 5-5 5"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
          </div>
          <!-- <div class="hidden">
            <button class="btn-back">
              <svg
                class="mr-3"
                width="24"
                height="24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M21 12H3M8 7l-5 5 5 5"
                  stroke="#155366"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
              Go back
            </button>
          </div> -->
        </form>
        <aside>
          <span class="text-base font-bold">Step 1 out of 3</span>
          <ul class="relative mt-6 text-sm text-n-40">
            <li class="mb-6 font-bold text-n-50">
              <span class="mr-3 ml-6">1</span> Publisher Information
              <p class="detail mt-2 font-normal xl:pr-2">
                This information will be used to create a Publisher in IATI
                Publisher.
              </p>
            </li>
            <li class="mb-6">
              <span class="mr-3 ml-6">2</span> Administrator Information
            </li>
            <li><span class="mr-3 ml-6">3</span> Email Verification</li>
          </ul>
        </aside>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import EmailVerification from './EmailVerification.vue';

export default defineComponent({
  components: {
    EmailVerification,
  },
});
</script>

<style lang="scss">
.section {
  &__container {
    max-width: 1206px;
    margin: auto;

    .feedback {
      width: 702px;
    }

    .section__wrapper {
      box-shadow: 0px 20px 40px 20px rgba(0, 0, 0, 0.05);
    }

    .section__title {
      margin-bottom: 40px;

      p {
        font-weight: normal;
        font-size: 16px;
        font-style: normal;
        @apply text-n-40;
      }
    }
    .form {
      @apply bg-white;
      padding: 40px 80px;
      border-top-left-radius: 8px;
      border-bottom-left-radius: 8px;
      width: 862px;

      &__container {
        @apply border-b-2 border-b-n-10;
        margin-bottom: 24px;

        .label {
          font-size: 14px;
          font-weight: normal;
          font-style: normal;
        }
      }
      &__input {
        @apply border border-n-30;
        width: 100%;
        padding: 13px 0 13px 16px;
        margin-top: 8px;
        outline: none;
        border-radius: 4px;
        transition: 0.3s;

        &::placeholder {
          @apply text-n-40;
          font-size: 14px;
          font-weight: normal;
          font-style: normal;
          letter-spacing: -0.02em;
        }
        &:focus {
          @apply border border-n-50 bg-n-10;
        }
        &:focus::placeholder {
          @apply text-n-50;
        }
      }
    }
    aside {
      @apply bg-eggshell;
      padding: 96px 80px 40px 32px;
      width: 344px;

      li::before {
        content: '';
        width: 4px;
        height: 175px;
        @apply bg-n-20;
        border-radius: 2px;
        position: absolute;
        left: 0px;
        top: 0px;
      }
      .detail {
        margin-left: 45px;
      }
      // li::after {
      //   position: absolute;
      //   top: 0;
      //   left: -1px;
      //   width: 6px;
      //   height: 85px;
      //   @apply bg-turquoise;
      //   content: '';
      //   border-radius: 2px;
      // }
      .list__active::after {
        position: absolute;
        bottom: 0;
        left: -1px;
        width: 6px;
        height: 85px;
        @apply bg-turquoise;
        content: '';
        border-radius: 2px;
      }
    }
  }
  @media screen and (min-width: 1024px) {
    .form__content {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
      margin-top: 24px;
    }
  }
}
</style>
