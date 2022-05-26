<template>
  <div
    :class="
      show
        ? 'relative mb-10 h-full duration-300'
        : 'relative mb-32 h-full duration-300'
    "
  >
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
              {{
                errorData.account_verified ||
                (errorData.default_setting && errorData.publisher_setting)
                  ? '1 Alerts'
                  : '2 Alerts'
              }}
            </span>
          </div>
          <div
            :class="show ? 'text-show' : 'text-hide'"
            v-if="!errorData.account_verified"
          >
            <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
            <span class="text-sm font-bold text-n-50"
              >Account not verified</span
            >
          </div>
          <div
            :class="
              show &&
              (!errorData.publisher_setting || !errorData.default_setting)
                ? 'text-show'
                : 'text-hide'
            "
          >
            <svg-vue icon="red-dot" class="text-[6px]"></svg-vue>
            <span class="text-sm font-bold text-bluecoral"
              >Complete your setup</span
            >
          </div>
        </div>
        <div>
          <button
            class="text-sm leading-relaxed text-bluecoral"
            @click="show = !show"
          >
            show {{ show ? 'less' : 'more' }}
          </button>
        </div>
      </div>
    </div>

    <div
      :class="show ? 'border-show duration-300' : 'border-hide duration-300'"
    ></div>

    <div class="ml-4 mr-6" v-if="!errorData.account_verified">
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
              <span>Account not verified</span>
            </div>

            <div class="ml-5 text-left">
              <p>
                Please check for verification email sent to you and verify your
                account,
                <span
                  ><a
                    class="border-b-2 border-b-bluecoral font-bold text-bluecoral hover:border-b-spring-50"
                    @click="resendVerificationEmail()"
                    >resend verification email</a
                  ></span
                >
                if you haven’t received your verification email. Contact
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
      </TransitionRoot>
    </div>

    <div
      class="ml-4 mr-6"
      v-if="!errorData.publisher_setting || !errorData.default_setting"
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
              <span>Complete your setup</span>
            </div>
            <div class="ml-5">
              <p>
                Please
                <span
                  ><a href="/setting" target="_blank"
                    >complete your setup</a
                  ></span
                >
                in order to enable complete features of IATI publisher tool.
              </p>
              <div class="alert__message" v-if="!errorData.publisher_setting">
                <svg-vue icon="red-cross" class="text-[7px]"></svg-vue>
                <p>Update registry information - API Key & Publisher ID</p>
              </div>
              <div class="alert__message" v-if="!errorData.default_setting">
                <svg-vue icon="red-cross" class="text-[7px]"></svg-vue>
                <p>Update default values</p>
              </div>
            </div>
          </div>
        </div>
      </TransitionRoot>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, reactive, onMounted } from 'vue';
import { TransitionRoot } from '@headlessui/vue';
import axios from 'axios';

export default defineComponent({
  components: {
    TransitionRoot,
  },

  setup(props) {
    const show = ref(false);

    const errorData = reactive({
      account_verified: false,
      default_setting: false,
      publisher_setting: false,
    });

    function resendVerificationEmail() {
      axios
        .post('/user/verification/email')
        .then((res) => {
          console.log(res);
        })
        .catch((error) => {
          console.log(error);
        });
    }

    onMounted(async () => {
      axios
        .get('/setting/status')
        .then((res) => {
          const response = res.data;
          errorData.default_setting = response.data.default_status;
          errorData.publisher_setting = response.data.publisher_status;
        })
        .catch((error) => {
          console.log(error);
        });

      axios
        .get('/user/verification/status')
        .then((res) => {
          const response = res.data;
          errorData.account_verified = response.data.account_verified;
        })
        .catch((error) => {
          console.log(error);
        });
    });

    return { show, errorData, resendVerificationEmail };
  },
});
</script>

<style lang="scss" scoped>
.alert {
  @apply bg-camel-10 p-4 pr-6 text-sm leading-relaxed text-n-50;

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
  @apply absolute left-0 top-0 bg-salmon-50 duration-300 ease-out;
  width: 2px;
  height: 100%;
  content: '';
  transform: translateY(-100%);
}
.border-show::before {
  @apply absolute left-0 top-0 bg-salmon-50 duration-300 ease-out;
  width: 2px;
  height: 100%;
  content: '';
  transform: translateY(0%);
}
</style>
