<template>
  <form method="POST" action="" class="form">
    <div class="grid justify-items-center gap-6 tracking-normal xl:px-2">
      <div class="space-y-4 sm:space-y-6">
        <p class="text-center text-xl font-bold text-n-50 sm:text-2xl">
          {{ translate.textFromKey('email_verification.verify_your_account') }}
        </p>
        <p class="text-sm text-n-40 sm:text-base">
          {{
            translate.textFromKey(
              'email_verification.a_verification_email_has_been_sent'
            )
          }}
          <span class="font-bold text-n-50"> {{ props.email }}</span
          >.
          {{ translate.textFromKey('email_verification.click_and_activate') }}
        </p>
      </div>
      <svg-vue class="verification" icon="ic-verification" />
      <a href="/activities" class="btn btn-next get-started-btn">
        {{ translate.button('get_started') }}
        <svg-vue class="text-2xl" icon="right-arrow" />
      </a>
    </div>
  </form>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  props: {
    email: { type: String, default: '' },
  },

  setup(props) {
    const translate = new Translate();

    return {
      props,
      translate,
    };
  },
});
</script>
