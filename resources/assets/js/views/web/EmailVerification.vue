<template>
  <div class="section__wrapper flex">
    <form method="POST" action="" class="form">
      <div class="grid justify-items-center gap-6 tracking-normal xl:px-2">
        <span class="text-2xl font-bold text-n-50"
          >Please verify your account</span
        >
        <p class="text-base text-n-40">
          A verification email has been sent to
          <span class="font-bold text-n-50"> {{ props.email }}</span>
          . Please click on the link in the email to verify and activate your
          new IATI publisher account.
        </p>
        <svg-vue class="verification" icon="ic-verification"></svg-vue>
        <a href="/activities" class="btn btn-next">
          Get started
          <svg-vue class="text-2xl" icon="right-arrow"></svg-vue>
        </a>
      </div>
    </form>
    <!-- step 3 -->
    <aside>
      <span class="text-base font-bold">Step 1 out of 3</span>
      <ul class="relative mt-6 text-sm text-n-40">
        <li class="mb-6 flex items-center font-bold text-bluecoral">
          <span class="mr-3 ml-6"
            ><svg-vue class="text-xs" icon="checked"></svg-vue
          ></span>
          Publisher Information
        </li>
        <li class="mb-6 flex items-center font-bold text-bluecoral">
          <span class="mr-3 ml-6"
            ><svg-vue class="text-xs" icon="checked"></svg-vue
          ></span>
          Administrator Information
        </li>
        <li class="relative font-bold text-n-50">
          <span class="list__active"></span>
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

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    email: String,
  },

  setup(props) {
    return {
      props,
    };
  },
});
</script>
