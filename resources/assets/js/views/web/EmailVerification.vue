<template>
  <form method="POST" action="" class="form">
    <div class="grid justify-items-center gap-6 tracking-normal xl:px-2">
      <div class="space-y-4 sm:space-y-6">
        <p class="text-center text-xl font-bold text-n-50 sm:text-2xl">
          {{ language.email_verification.verify_your_account }}
        </p>
        <p class="text-sm text-n-40 sm:text-base">
          A verification email has been sent to
          <span class="font-bold text-n-50"> {{ props.email }}</span
          >. {{ language.email_verification.click_and_activate }}
        </p>
      </div>
      <svg-vue class="verification" icon="ic-verification" />
      <a href="/activities" class="btn btn-next get-started-btn">
        {{ language.button_lang.get_started }}
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
    const language = window['globalLang'];

    return {
      props,
      language,
    };
  },
});
</script>
