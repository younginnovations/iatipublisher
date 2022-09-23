<template>
  <form method="POST" action="" class="form">
    <div class="grid justify-items-center gap-6 tracking-normal xl:px-2">
      <div class="space-y-4 sm:space-y-6">
        <p class="text-center text-xl font-bold text-n-50 sm:text-2xl">
          Please verify your account
        </p>
        <p class="text-sm text-n-40 sm:text-base">
          A verification email has been sent to
          <span class="font-bold text-n-50"> {{ props.email }}</span
          >. Please click on the link in the email to verify and activate your
          new IATI publisher account.
        </p>
      </div>
      <svg-vue class="verification" icon="ic-verification" />
      <a href="/activities" class="btn btn-next get-started-btn">
        Get started
        <svg-vue class="text-2xl" icon="right-arrow" />
      </a>
    </div>
  </form>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    email: { type: String, default: '' },
  },

  setup(props) {
    return {
      props,
    };
  },
});
</script>
