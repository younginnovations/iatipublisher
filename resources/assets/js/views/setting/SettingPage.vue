<template>
  <section class="section">
    <div class="setting">
      <span class="text-xs font-bold text-n-40">Settings</span>
      <div class="mt-4 flex items-center">
        <a href="#"><svg-vue icon="left-arrow"></svg-vue></a>
        <h2 class="ml-3 text-heading-4 font-bold text-n-50">Settings</h2>
      </div>
      <div class="setting__container mb-14">
        <div class="flex">
          <button
            :class="
              tab === 'publish' ? 'tab-btn active__tab mr-2' : 'tab-btn mr-2'
            "
            @click="toggleTab"
          >
            Publishing Settings
          </button>
          <button
            :class="tab === 'default' ? 'tab-btn active__tab' : 'tab-btn'"
            @click="toggleTab"
          >
            Default Values
          </button>
        </div>
        <SettingPublishingForm v-if="tab === 'publish'"></SettingPublishingForm>
        <SettingDefaultForm
          v-else
          :currencies="currencies"
          :languages="languages"
          :humanitarian="humanitarian"
        ></SettingDefaultForm>
      </div>
    </div>
    <div class="fixed bottom-0 w-full bg-eggshell py-5 pr-40 shadow-dropdown">
      <div class="flex justify-end">
        <button class="ghost-btn mr-8">Cancel</button>
        <button class="primary-btn save-btn">
          {{
            tab === 'publish'
              ? 'Save publishing setting'
              : 'Save default values'
          }}
        </button>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, reactive } from 'vue';
import { useStore } from 'vuex';
import SettingDefaultForm from './SettingDefaultForm.vue';
import SettingPublishingForm from './SettingPublishingForm.vue';

export default defineComponent({
  components: {
    SettingDefaultForm,
    SettingPublishingForm,
  },

  props: {
    currencies: String,
    languages: String,
    humanitarian: String,
  },

  setup(props) {
    const tab = ref('publish');
    const store = useStore();

    const publishingForm = reactive({
      publisher_id: '',
      api_token: '',
    });

    const defaultForm = reactive({
      default_currency: '',
      default_language: '',
      hierarchy: '',
      linked_data_url: '',
      humanitarian: 'false',
    });

    const publishingError = reactive({
      publisher_id: '',
      api_token: '',
    });

    const defaultError = reactive({
      default_currency: '',
      default_language: '',
      hierarchy: '',
      linked_data_url: '',
      humanitarian: 'false',
    });

    function toggleTab() {
      tab.value = tab.value === 'publish' ? 'default' : 'publish';
    }

    return {
      tab,
      toggleTab,
      publishingForm,
      publishingError,
      defaultForm,
      defaultError,
      store,
      props,
    };
  },
});
</script>

<style lang="scss">
.section {
  @apply bg-paper;

  .setting {
    padding: 16px 0px 24px;
    max-width: 1000px;
    margin: auto;
    height: 90vh;
    @apply flex flex-col justify-center;

    &__container {
      @apply relative mt-6 rounded-lg bg-white px-20;
      overflow-y: auto;
      padding-top: 52px;
      padding-bottom: 52px;

      .registry__info {
        @apply mt-7 mb-4 flex justify-between border-b border-b-n-20;
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
