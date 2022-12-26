<template>
  <div
    id="right"
    class="right m-auto flex basis-2/4 items-center rounded-l-lg rounded-r-lg bg-white py-5 px-5 sm:py-10 sm:px-10 md:my-0 md:rounded-l-none lg:px-14 lg:py-28 xl:px-24"
  >
    <Loader v-if="isLoaderVisible"></Loader>

    <div class="right__container flex w-full flex-col" @keyup.enter="login">
      <h2 class="mb-2 hidden sm:block">{{ language.web_lang.sign_in }}.</h2>
      <span class="text-n-40">{{
        language.home.sign_in_section.welcome_back_label
      }}</span>
      <div
        v-if="
          message !== '' &&
          !(errorData.username || errorData.password) &&
          intent === 'verify'
        "
        class="error mt-2 text-xs"
        role="alert"
      >
        {{ message }}
      </div>
      <div
        v-if="intent === 'password_changed'"
        class="w-full border-l-2 border-spring-50 bg-[#EEF9F5] px-4 py-3"
      >
        <div class="flex space-x-2">
          <svg-vue class="text-spring-50" icon="tick" />
          <span class="flex flex-col space-y-2">
            <span class="text-sm font-bold text-n-50">{{
              language.register_lang.password.updated
            }}</span>
            <span class="text-sm text-n-50"
              >{{ language.register_lang.password.use_new }}.</span
            >
          </span>
        </div>
      </div>
      <div class="relative mt-6 mb-4 flex flex-col text-sm text-bluecoral">
        <label for="Username">{{
          language.home.sign_in_section.username_label
        }}</label>
        <input
          id="username"
          v-model="formData.username"
          class="username input sm:h-16"
          :class="{
            error_input: errorData.username,
          }"
          type="text"
          :placeholder="language.web_lang.sign_in"
        />
        <svg-vue class="absolute top-12 left-5 text-xl sm:left-6" icon="user" />
        <span
          v-if="errorData.username !== ''"
          class="error text-xs"
          role="alert"
        >
          {{ errorData.username }}
        </span>
      </div>
      <div class="relative mb-4 flex flex-col text-sm text-bluecoral">
        <label for="Password">{{
          language.home.sign_in_section.password_label
        }}</label>
        <input
          id="password"
          v-model="formData.password"
          class="password input sm:h-16"
          :class="{
            error__input: errorData.password || errorData.username,
          }"
          type="password"
          :placeholder="language.home.sign_in_section.password_placeholder"
        />
        <svg-vue
          class="absolute top-12 left-5 text-xl sm:left-6"
          icon="pw-lock"
        />
        <span v-if="errorData.password" class="error" role="alert">{{
          errorData.password
        }}</span>
      </div>
      <p class="mb-6 text-sm text-n-40">
        {{ language.home.sign_in_section.forgot_password_label }}
        <span
          ><a
            class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
            href="/password/email"
            >{{ language.button_lang.reset }}.</a
          ></span
        >
      </p>
      <button id="btn" type="submit" class="btn" @click="login">
        {{ language.button_lang.sign_in }}
        <svg-vue class="" icon="right-arrow" />
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref } from 'vue';
import axios from 'axios';
import Loader from 'Components/Loader.vue';
import encrypt from 'Composable/encryption';
export default defineComponent({
  components: {
    Loader,
  },
  props: {
    message: {
      type: String,
      required: false,
      default: '',
    },
    intent: {
      type: String,
      required: false,
      default: '',
    },
  },
  setup() {
    const language = window['globalLang'];
    const formData = reactive({
      username: '',
      password: '',
    });
    const errorData = reactive({
      username: '',
      password: '',
    });
    const isLoaderVisible = ref(false);

    async function login() {
      isLoaderVisible.value = true;

      let form = {
        username: formData.username,
        password: encrypt(
          formData.password,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
      };

      axios
        .post('/login', form)
        .then((response) => {
          errorData.username = '';
          errorData.password = '';

          if (!('errors' in response)) {
            window.location.reload();
          }
        })
        .catch((error) => {
          const { errors } = error.response.data;
          errorData.username = errors.username ? errors.username[0] : '';
          errorData.password = errors.password ? errors.password[0] : '';
          isLoaderVisible.value = false;
        });
    }

    return {
      formData,
      errorData,
      isLoaderVisible,
      login,
      language,
    };
  },
});
</script>

<style lang="scss" scoped>
#btn {
  padding: 13px 0;

  svg {
    @apply absolute right-7 text-2xl;
    transition: 0.4s;
  }
}
@media screen and (min-width: 640px) {
  #btn {
    padding: 18px 0;
  }
}
.username {
  @apply mb-2;
}
.password {
  @apply mb-2;
}
label {
  @apply mb-2 font-bold;
}
</style>
