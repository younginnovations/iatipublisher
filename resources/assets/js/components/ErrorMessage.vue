<template>
  <div class="w-full border-l-2 border-l-salmon-50">
    <div :class="state.isErrorVisible ? 'ml-4 mr-7 pt-4' : 'ml-0 mr-0 pt-0'">
      <div
        v-show="state.isErrorVisible"
        class="flex items-center justify-between pb-2.5 text-sm leading-relaxed text-n-50"
      >
        <div class="flex items-center">
          <svg-vue
            icon="warning-activity"
            class="mr-2 grow-0 text-base text-salmon-50"
          ></svg-vue>
          <span class="text-sm font-bold text-n-50">2 Alerts</span>
        </div>
        <button
          class="text-sm leading-relaxed text-bluecoral"
          @click="state.isErrorVisible = !state.isErrorVisible"
        >
          Show less
        </button>
      </div>

      <div v-show="!state.isErrorVisible" class="alert relative mb-32">
        <div class="flex justify-between">
          <div class="flex space-x-4">
            <div class="flex items-center">
              <svg-vue
                icon="warning-activity"
                class="mr-2 grow-0 text-base text-salmon-50"
              ></svg-vue>
              <span class="text-sm font-bold text-n-50">2 Alerts</span>
            </div>
            <div class="flex items-center space-x-2">
              <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
              <span class="text-sm font-bold text-n-50"
                >Account not verified</span
              >
            </div>
            <div class="flex items-center space-x-2">
              <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
              <span class="text-sm font-bold text-bluecoral"
                >Complete your setup</span
              >
            </div>
          </div>
          <div>
            <button
              class="text-sm leading-relaxed text-bluecoral"
              @click="state.isErrorVisible = !state.isErrorVisible"
            >
              <span>Show more</span>
            </button>
          </div>
        </div>
      </div>

      <div v-if="state.isErrorVisible" class="alert mb-2.5">
        <div class="alert__container">
          <div class="alert__content">
            <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
            <span>Account not verified</span>
          </div>

          <div class="ml-5 text-left">
            <p>
              Please check for verification email sent to you and verify your
              account, click <span><a href="#">here</a></span> if you haven’t
              received your verification email. Contact
              <span
                ><a href="mailto:support@iatistandard.org"
                  >support@iatistandard.org</a
                ></span
              >
              for further assistance.
            </p>
          </div>
        </div>
      </div>

      <div v-if="state.isErrorVisible" class="alert mb-10">
        <div class="alert__container">
          <div class="alert__content">
            <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
            <span>Complete your setup</span>
          </div>
          <div class="ml-5">
            <p>
              Please
              <span><a href="/setting">complete your setup</a></span>
              in order to enable complete features of IATI publisher tool.
            </p>
            <div class="alert__message">
              <svg-vue icon="red-cross" class="text-[7px]"></svg-vue>
              <p>Update registry information - API Key & Publisher ID</p>
            </div>
            <div class="alert__message">
              <svg-vue icon="red-cross" class="text-[7px]"></svg-vue>
              <p>Update default values</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';

export default defineComponent({
  setup() {
    const state = reactive({
      isErrorVisible: false,
    });

    return { state };
  },
});
</script>

<style lang="scss" scoped>
.alert {
  @apply rounded bg-camel-10 p-4 pr-6 text-sm leading-relaxed text-n-50;

  &__container {
    @apply flex flex-col leading-6;
  }
  &__message {
    @apply flex items-center space-x-1;
  }
  &__content {
    @apply flex items-center space-x-4;

    span {
      @apply text-sm font-bold text-n-50;
    }
  }
}
</style>
