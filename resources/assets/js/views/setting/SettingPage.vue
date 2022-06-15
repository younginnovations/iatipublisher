<template>
  <section class="section">
    <Loader v-if="loaderVisibility" />
    <div class="setting input__field">
      <span class="text-xs font-bold text-n-40">Settings</span>
      <div class="flex items-center justify-between">
        <div class="mt-4 mb-6 flex items-center">
          <a href="/activities"><svg-vue icon="left-arrow" /></a>
          <h2 class="ml-3 text-heading-4 font-bold text-n-50">
            Settings
          </h2>
        </div>
        <div>
          <Toast
            v-if="toastVisibility"
            :message="toastMessage"
            :type="toastType"
          />
        </div>
      </div>
      <div class="setting__container overflow-x-hidden">
        <div class="flex">
          <button
            class="tab-btn mr-2"
            :class="{
              'active__tab' : tab==='publish'
            }
            "
            @click="toggleTab('publish')"
          >
            Publishing Settings
          </button>
          <button
            class="tab-btn"
            :class="{
              active__tab: tab === 'default',
            }"
            @click="toggleTab('default')"
          >
            Default Values
          </button>
        </div>
        <SettingPublishingForm
          v-if="tab === 'publish'"
          :organization="props.organization"
          @keyup.enter="submitForm"
          @submitPublishing="submitForm"
        />
        <SettingDefaultForm
          v-else
          :currencies="currencies"
          :languages="languages"
          :humanitarian="humanitarian"
          @keyup.enter="submitForm"
        />
      </div>
    </div>
    <div class="fixed bottom-0 w-full bg-eggshell py-5 pr-40 shadow-dropdown">
      <div class="flex items-center justify-end">
        <a
          class="ghost-btn mr-8"
          href="/activities"
        >Cancel</a>
        <button
          class="primary-btn save-btn"
          @click="submitForm('setting/store/publisher')"
        >
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
import { defineComponent, ref, computed, onMounted } from 'vue';
import { useStore } from '../../store';
import { ActionTypes } from '../../store/setting/actions';
import axios from 'axios';
import SettingDefaultForm from './SettingDefaultForm.vue';
import SettingPublishingForm from './SettingPublishingForm.vue';
import Loader from '../../components/Loader.vue';
import Toast from '../../components/Toast.vue';

export default defineComponent({
  components: {
    SettingDefaultForm,
    SettingPublishingForm,
    Loader,
    Toast,
  },

  props: {
    currencies: {
      type: [String, Object],
      required: true,
    },
    languages: {
      type: [String, Object],
      required: true,
    },
    humanitarian: {
      type: [String, Object],
      required: true,
    },
    organization: {
      type: [String, Object],
      required: true,
    },
  },

  setup(props) {
    const tab = ref('publish');
    const store = useStore();
    const loaderVisibility = ref(false);
    const toastVisibility = ref(false);
    const toastMessage = ref('');
    const toastType = ref(false);

    const publishingForm = computed(() => store.state.publishingForm);

    const publishingInfo = computed(() => store.state.publishingInfo);

    const publishingError = computed(() => store.state.publishingError);

    const defaultForm = computed(() => store.state.defaultForm);

    const defaultError = computed(() => store.state.defaultError);

    function updateStore(
      name: keyof typeof ActionTypes,
      key: string,
      value: string | boolean
    ) {
      store.dispatch(ActionTypes[name], {
        key: key,
        value: value,
      });
    }

    onMounted(async () => {
      const { data } = await axios.get('/setting/data');
      const settingData = data.data;

      if (settingData) {
        const defaultValues = settingData.default_values
          ? JSON.parse(settingData.default_values)
          : {};
        const publisherInfo = settingData.publishing_info
          ? JSON.parse(settingData.publishing_info)
          : {};
        const activityValues = settingData.activity_default_values
          ? JSON.parse(settingData.activity_default_values)
          : {};

        if (publisherInfo) {
          for (const key in publisherInfo) {
            updateStore(
              typeof publisherInfo[key] === 'string'
                ? 'UPDATE_PUBLISHING_FORM'
                : 'UPDATE_PUBLISHER_INFO',
              key,
              publisherInfo[key]
            );
          }

          if (publisherInfo.api_token) {
            updateStore(
              'UPDATE_PUBLISHER_INFO',
              'isVerificationRequested',
              true
            );
          }
        }

        if (defaultValues) {
          for (const key in defaultValues) {
            updateStore('UPDATE_DEFAULT_VALUES', key, defaultValues[key]);
          }
        }

        if (activityValues) {
          for (const key in activityValues) {
            updateStore('UPDATE_DEFAULT_VALUES', key, activityValues[key]);
          }
        }
      }
    });

    function toggleTab(page: string) {
      toastVisibility.value = false;
      tab.value = page;
    }

    function submitDefault() {
      for (const data in defaultError.value) {
        updateStore('UPDATE_DEFAULT_ERROR', data, '');
      }
      loaderVisibility.value = true;

      axios
        .post('/setting/store/default', defaultForm.value)
        .then((res) => {
          const response = res.data;
          loaderVisibility.value = false;
          toastVisibility.value = true;
          setTimeout(() => (toastVisibility.value = false), 5000);
          toastMessage.value = response.message;
          toastType.value = response.success;

          if (response.success) {
            updateStore('UPDATE_PUBLISHER_INFO', response.data.hierarchial, '');
          }

          loaderVisibility.value = false;
        })
        .catch((error) => {
          const { errors } = error.response.data;

          for (const e in errors) {
            updateStore('UPDATE_DEFAULT_ERROR', e, errors[e][0]);
          }

          loaderVisibility.value = false;
        });
    }

    function submitPublishing(url: string) {
      loaderVisibility.value = true;

      for (const data in publishingError.value) {
        updateStore('UPDATE_PUBLISHING_ERROR', data, '');
      }

      axios
        .post(url, {
          ...publishingInfo.value,
          ...publishingForm.value,
        })
        .then((res) => {
          const response = res.data;

          if (response.success) {
            updateStore(
              'UPDATE_PUBLISHER_INFO',
              'publisher_verification',
              response.data.publisher_verification
            );

            updateStore(
              'UPDATE_PUBLISHER_INFO',
              'token_verification',
              response.data.token_verification
            );

            updateStore(
              'UPDATE_PUBLISHER_INFO',
              'isVerificationRequested',
              true
            );
          }

          loaderVisibility.value = false;
          toastVisibility.value = true;
          setTimeout(() => (toastVisibility.value = false), 5000);
          toastMessage.value = response.message;
          toastType.value = response.success;
        })
        .catch((error) => {
          const { errors } = error.response.data;

          for (const e in errors) {
            updateStore('UPDATE_PUBLISHING_ERROR', e, errors[e][0]);
          }

          loaderVisibility.value = false;
        });
    }

    function submitForm(url = 'setting/verify') {
      if (tab.value === 'publish') submitPublishing(url);
      if (tab.value === 'default') submitDefault();
    }

    return {
      props,
      tab,
      defaultError,
      publishingError,
      store,
      loaderVisibility,
      toastVisibility,
      toastMessage,
      toastType,
      toggleTab,
      submitForm,
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
    height: calc(100vh - 80px);

    &__container {
      @apply relative rounded-lg bg-white py-14 px-20;
      overflow-y: auto;
      max-height: 65vh;

      .vue__select {
        margin: 8px 0px;
      }
      .registry__info {
        @apply my-4 flex justify-between border-b border-b-n-20;
      }
      p {
        @apply text-xs leading-5 text-n-40;
      }
      .text {
        @apply mb-8 text-sm;
      }
      label {
        @apply text-xs text-n-50;
      }
    }
    .register {
      @apply rounded-lg border border-n-30 p-6;

      &__container {
        @apply grid grid-cols-2 gap-6;

        .tag__correct {
          @apply absolute right-2 top-10 flex h-5 cursor-pointer items-center justify-center rounded bg-spring-40 text-center text-xs text-white;
          width: 50px;
        }

        .tag__incorrect {
          @apply absolute right-2 top-10 flex h-5 cursor-pointer items-center justify-center rounded bg-salmon-50 text-center text-xs text-white;
          width: 61px;
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
      padding: 13px 16px;
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
    .error__input {
      @apply border border-crimson-50;
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
