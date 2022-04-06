<template>
  <section class="section">
    <div class="setting">
      <span class="text-xs font-bold text-n-40">Settings</span>
      <div class="flex items-center">
        <a href="#"><svg-vue icon="left-arrow"></svg-vue></a>
        <h2 class="ml-3 text-heading-4 font-bold text-n-50">Settings</h2>
      </div>
      <DefaultPage v-if="true"></DefaultPage>
      <div v-else class="setting__container mb-1">
        <div class="flex">
          <button class="tab-btn active__tab mr-2">Publishing Settings</button>
          <button class="tab-btn">Default Values</button>
        </div>
        <div class="registry__info">
          <div class="mb-4 text-sm font-bold text-n-50">
            Registry Information
          </div>
        </div>
        <div class="register">
          <div class="register__container">
            <div>
              <div class="relative">
                <div class="flex justify-between">
                  <label for="name">Publisher ID</label>
                  <button>
                    <svg-vue class="text-base" icon="help"></svg-vue>
                  </button>
                </div>
                <input
                  id="publisher_id"
                  class="register__input mb-2"
                  type="text"
                  placeholder="yipl"
                />
                <span class="tag">Correct</span>
              </div>
              <p class="xl:pr-2">
                You need to create user and publisher accounts on the IATI
                Registry. When creating your publisher account you will be asked
                to specify a publisher identifier (typically a unique
                abbreviation of your organisation's name). We recommend that you
                use the same identifier as you specified as your IATI account
                identifier.
              </p>
            </div>
            <div>
              <div class="relative">
                <div class="flex justify-between">
                  <label for="api_token"
                    >API Token <span class="text-crimson-50">*</span></label
                  >
                  <button>
                    <svg-vue class="text-base" icon="help"></svg-vue>
                  </button>
                </div>
                <input
                  id="api_token"
                  class="register__input mb-2"
                  type="text"
                  placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ"
                />
                <span class="tag">Correct</span>
              </div>
              <p>
                You can get your API token from the IATI Registry. Follow the
                link to learn how to retrieve your API key
                <a class="font-bold text-bluecoral" href="#">Click Here</a>
              </p>
            </div>
          </div>
          <button class="primary-btn verify-btn">Verify</button>
        </div>
      </div>
    </div>
    <div class="fixed bottom-0 w-full bg-eggshell py-5 pr-40 shadow-dropdown">
      <div class="flex justify-end">
        <button class="cancel-btn mr-8">Cancel</button>
        <button class="primary-btn save-btn">Save publishing setting</button>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import DefaultPage from './DefaultPage.vue';

export default defineComponent({
  components: {
    DefaultPage,
  },
});
</script>

<style lang="scss">
.section {
  @apply bg-paper;
  height: 90vh;

  .setting {
    padding: 16px 0px 24px;
    max-width: 1000px;
    margin: auto;

    &__container {
      @apply relative mt-6 rounded-lg bg-white px-20;
      height: 504px;
      overflow-y: scroll;
      padding-top: 52px;
      padding-bottom: 52px;

      .registry__info {
        max-width: 768px;
        @apply mt-7 mb-4 border-b border-b-n-20;
      }
      p {
        @apply text-xs leading-5 text-n-40;
      }
      .text {
        @apply mb-6 text-sm;
      }
      label {
        @apply text-xs text-n-50;
      }
    }
    .tab-btn {
      @apply border border-n-20 bg-white p-2 text-xs text-n-40;
      border-radius: 4px;

      &:focus {
        @apply border-turquoise text-bluecoral;
      }
    }
    .active__tab {
      @apply border-turquoise text-bluecoral;
    }
    .register {
      @apply rounded-lg border border-n-30 p-6;

      &__container {
        @apply grid grid-cols-2 gap-6;

        .tag {
          @apply absolute right-2 top-10 flex h-5 cursor-pointer items-center justify-center rounded bg-spring-40 text-center text-xs text-white;
          width: 54px;
        }
      }
      .verify-btn {
        margin-top: 14px;
        width: 120px;
        @apply flex h-10 justify-center;
      }
    }
    .register__input {
      @apply mt-2 w-full border border-n-30 outline-none duration-300;
      padding: 13px 0 13px 16px;
      border-radius: 4px;

      &::placeholder {
        @apply text-sm text-n-40;
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
}
.save-btn {
  @apply px-4;
}
.btn__active {
  @apply font-bold text-white;
}
</style>
