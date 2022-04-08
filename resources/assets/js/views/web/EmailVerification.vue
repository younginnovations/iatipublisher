<template>
  <div class="section__wrapper flex">
    <form method="POST" action="" class="form">
      <div class="grid justify-items-center gap-6 tracking-normal xl:px-2">
        <span class="text-2xl font-bold text-n-50"
          >Please verify your account</span
        >
        <p class="text-base text-n-40">
          A verification email has been sent to
          <span class="font-bold text-n-50"
            ><a href="mailto:admin@admin.com">admin@admin.com</a></span
          >
          . Please click on the link in the email to verify and activate your
          new IATI publisher account.
        </p>
        <img src="/images/mail.png" alt="" />
        <button class="btn btn-next">
          Get started
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
    </form>
    <aside>
      <span class="text-base font-bold">Step 1 out of 3</span>
      <ul class="relative mt-6 text-sm text-n-40">
        <li class="mb-6 font-bold text-bluecoral">
          <span class="mr-3 ml-6">1</span> Publisher Information
        </li>
        <li class="mb-6 font-bold text-bluecoral">
          <span class="mr-3 ml-6">2</span> Administrator Information
        </li>
        <li class="list__active font-bold text-n-50">
          <span class="mr-3 ml-6">3</span> Email Verification
          <p class="detail mt-2 font-normal xl:pr-2">
            Please verify and activate your IATI Publisher account through your
            provided email.
          </p>
        </li>
      </ul>
    </aside>
  </div>
</template>
