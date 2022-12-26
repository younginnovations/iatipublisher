<!-- eslint-disable -->
<template>
  <div
    v-if="hasErrors"
    class="relative bg-white duration-300"
    :class="{
      'mb-5': !isEmpty || !show,
      'mb-10': show,
    }"
  >
    <Loader v-if="isLoaderVisible" />
    <div
      :show="!show"
      :class="
        show
          ? 'border-l-2 border-l-salmon-50 pl-4 pt-4 pr-6 pb-2.5 text-sm leading-relaxed text-n-50 duration-300 ease-out'
          : 'alert relative border-l-2 border-l-salmon-50 duration-300 ease-out'
      "
    >
      <div class="flex items-center justify-between">
        <div class="flex h-5 items-center space-x-4">
          <div :show="show" class="flex items-center">
            <svg-vue
              icon="warning-activity"
              class="mr-2 grow-0 text-base text-salmon-50"
            ></svg-vue>
            <span class="text-sm font-bold text-n-50">
              {{ errorCount + ' ' + language.common_lang.alerts }}
            </span>
          </div>
          <div
            v-if="!errorData.account_verified"
            :class="show ? 'text-show' : 'text-hide'"
          >
            <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
            <span class="text-sm font-bold text-n-50">{{
              language.common_lang.account_not_verified
            }}</span>
          </div>
          <div
            v-if="!errorData.publisher_setting || !errorData.default_setting"
            :class="
              show &&
              (!errorData.publisher_setting || !errorData.default_setting)
                ? 'text-show'
                : 'text-hide'
            "
          >
            <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
            <span class="text-sm font-bold text-bluecoral">{{
              language.common_lang.complete_your_setup
            }}</span>
          </div>
          <div
            v-if="!errorData.publisher_active"
            :class="show ? 'text-show' : 'text-hide'"
          >
            <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
            <span class="text-sm font-bold text-n-50">{{
              language.common_lang.publisher_is_inactive
            }}</span>
          </div>
        </div>
        <div>
          <button
            class="text-sm leading-relaxed text-bluecoral"
            @click="show = !show"
          >
            {{
              show
                ? language.common_lang.show_less
                : language.common_lang.show_more
            }}
          </button>
        </div>
      </div>
    </div>

    <div
      :class="show ? 'border-show duration-300' : 'border-hide duration-300'"
    ></div>

    <div v-if="!errorData.account_verified" class="ml-4 mr-6">
      <TransitionRoot
        :show="show"
        as="template"
        enter="transition-all duration-300 ease-out"
        enter-from="-translate-y-11 opacity-0 w-[90%] mx-auto"
        enter-to="translate-y-0 opacity-100 w-full mx-auto"
        leave="transition-all duration-300 ease-out"
        leave-from="translate-y-0 opacity-100 w-full mx-auto"
        leave-to="-translate-y-11 opacity-0 w-[90%] mx-auto"
      >
        <div class="alert mb-2.5">
          <div class="alert__container">
            <div class="alert__content">
              <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
              <span>{{ language.common_lang.account_not_verified }}</span>
            </div>

            <div class="ml-5 text-left">
              <p>
                {{ language.common_lang.account_not_verified_desc_p1 }}
                <span
                  ><a
                    class="cursor-pointer border-b-2 border-b-bluecoral font-bold text-bluecoral hover:border-b-spring-50"
                    @click="resendVerificationEmail()"
                    >{{ language.common_lang.account_not_verified_desc_p2 }}</a
                  ></span
                >
                <span
                  v-html="language.common_lang.account_not_verified_desc_p3"
                />
              </p>
            </div>
          </div>
        </div>
      </TransitionRoot>
    </div>

    <div
      v-if="!errorData.publisher_setting || !errorData.default_setting"
      class="ml-4 mr-6"
    >
      <TransitionRoot
        :show="show"
        as="template"
        enter="transition-all duration-300 ease-out"
        enter-from="-translate-y-32 opacity-0 w-[65%] mx-auto"
        enter-to="translate-y-0 opacity-100 w-full mx-auto"
        leave="transition-all duration-300 ease-out"
        leave-from="translate-y-0 opacity-100 w-full mx-auto"
        leave-to="-translate-y-32 opacity-0 w-[65%] mx-auto"
      >
        <div class="alert mb-2.5">
          <div class="alert__container">
            <div class="alert__content">
              <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
              <span>{{ language.common_lang.complete_your_setup }}</span>
            </div>
            <div class="ml-5">
              <p
                v-html="language.common_lang.complete_your_setup_description"
              ></p>
              <div v-if="!errorData.publisher_setting" class="alert__message">
                <svg-vue icon="red-cross" class="text-[7px]"></svg-vue>
                <p>
                  {{ language.common_lang.update_registry_information }} -
                  {{ language.common_lang.api_key_and_publisher_id
                  }}<span v-if="!errorData.token_status"
                    >. {{ language.common_lang.enter_correct_api_token }}.</span
                  >
                </p>
              </div>
              <div v-if="!errorData.default_setting" class="alert__message">
                <svg-vue icon="red-cross" class="text-[7px]"></svg-vue>
                <p>{{ language.common_lang.update_default_values }}</p>
              </div>
            </div>
          </div>
        </div>
      </TransitionRoot>
    </div>
    <div v-if="!errorData.publisher_active" class="ml-4 mr-6">
      <TransitionRoot
        :show="show"
        as="template"
        enter="transition-all duration-300 ease-out"
        enter-from="-translate-y-11 opacity-0 w-[90%] mx-auto"
        enter-to="translate-y-0 opacity-100 w-full mx-auto"
        leave="transition-all duration-300 ease-out"
        leave-from="translate-y-0 opacity-100 w-full mx-auto"
        leave-to="-translate-y-11 opacity-0 w-[90%] mx-auto"
      >
        <div class="alert mb-2.5">
          <div class="alert__container">
            <div class="alert__content">
              <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
              <span>{{ language.common_lang.publisher_is_inactive }}</span>
            </div>

            <div class="ml-5 text-left">
              <p>{{ language.common_lang.publisher_is_not_active }}</p>
            </div>
          </div>
        </div>
      </TransitionRoot>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, ref, reactive, onMounted, inject } from 'vue';
import { TransitionRoot } from '@headlessui/vue';
import Loader from '../components/Loader.vue';
import axios from 'axios';

defineProps({
  isEmpty: {
    type: Boolean,
    required: false,
    default: true,
  },
});

const language = window['globalLang'];
const show = ref(false);
const hasErrors = ref(false);
const errorCount = ref(0);

interface ToastInterface {
  visibility: boolean;
  message: string;
  type: boolean;
}
const toastData = inject('toastData') as ToastInterface;
const errorData = reactive({
  account_verified: false,
  publisher_active: false,
  default_setting: false,
  publisher_setting: false,
  token_status: false,
});
const isLoaderVisible = ref(false);

// eslint-disable-next-line @typescript-eslint/no-unused-vars
// eslint-disable @typescript-eslint/no-unused-vars
function resendVerificationEmail() {
  isLoaderVisible.value = true;

  axios
    .post('/user/verification/email')
    .then((res) => {
      toastData.visibility = true;
      toastData.message = res.data.message;
      toastData.type = res.data.success;
      isLoaderVisible.value = false;
    })
    .catch((error) => {
      toastData.visibility = true;
      toastData.message = error.data.message;
      toastData.type = false;
      isLoaderVisible.value = false;
    });
}

onMounted(async () => {
  axios
    .all([
      axios.get('/setting/status'),
      axios.get('/user/verification/status'),
      axios.get('/organisation/status'),
    ])
    .then(
      axios.spread(function (setting_res, user_res, org_res) {
        const response = setting_res.data;
        const user_response = user_res.data;
        const org_response = org_res.data;

        errorData.default_setting = response?.data?.default_status;
        errorData.publisher_setting = response?.data?.publisher_status;
        errorData.token_status = response?.data?.token_status;
        errorData.account_verified = user_response.data.account_verified;
        errorData.publisher_active = org_response.data.publisher_active;
        let groupedError = [
          'default_setting',
          'publisher_setting',
          'token_status',
        ];

        for (const error in errorData) {
          if (!errorData[error] && groupedError.indexOf(error) === -1) {
            errorCount.value += 1;
          }
        }

        if (
          !(
            errorData.publisher_setting &&
            errorData.token_status &&
            errorData.default_setting
          )
        ) {
          errorCount.value += 1;
        }

        if (Object.values(errorData).indexOf(false) > -1) {
          hasErrors.value = true;
        }
      })
    );
});
</script>

<style lang="scss" scoped>
.alert {
  @apply rounded bg-camel-10 p-4 pr-6 text-sm leading-relaxed text-n-50;

  &__container {
    @apply flex flex-col leading-6;
  }
  &__content {
    @apply flex items-center space-x-4;

    span {
      @apply text-sm font-bold text-n-50;
    }
  }
  &__message {
    @apply flex items-center space-x-1;
  }
}
.text-show {
  @apply invisible flex items-center space-x-2 opacity-0 duration-300;
  transform: translate(-50px, 30px);
}
.text-hide {
  @apply flex -translate-y-0 items-center space-x-2 duration-300;
}
.border-hide::before {
  @apply absolute left-0 top-0 rounded bg-salmon-50 duration-300 ease-out;
  width: 2px;
  height: 100%;
  content: '';
  transform: translateY(-100%);
}
.border-show::before {
  @apply absolute left-0 top-0 rounded bg-salmon-50 duration-300 ease-out;
  width: 2px;
  height: 100%;
  content: '';
  transform: translateY(0%);
}
</style>
