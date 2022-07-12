<template>
  <div
    id="right"
    class="right m-auto flex basis-2/4 items-center rounded-l-lg rounded-r-lg bg-white py-5 px-5 sm:py-10 sm:px-10 md:my-0 md:rounded-l-none lg:px-14 lg:py-28 xl:px-24"
  >
    <Loader v-if="isLoaderVisible"></Loader>

    <div class="right__container flex w-full flex-col" @keyup.enter="login">
      <h2 class="mb-2 hidden sm:block">Sign In.</h2>
      <span class="text-n-40">Welcome back! Please enter your details.</span>
      <div
        class="relative mt-6 mb-4 flex flex-col text-sm font-bold text-bluecoral"
      >
        <label class="mb-2" for="Username">Username</label>
        <input
          id="username"
          v-model="formData.username"
          class="username input sm:h-16"
          :class="{
            error_input: errorData.username,
          }"
          type="text"
          placeholder="Enter a registered username"
        />
        <svg-vue class="absolute top-12 left-5 text-xl sm:left-6" icon="user" />
        <span v-if="errorData.username != ''" class="error" role="alert">
          {{ errorData.username }}
        </span>
      </div>
      <div class="relative mb-4 flex flex-col text-sm font-bold text-bluecoral">
        <label class="mb-2" for="Password">Password</label>
        <input
          id="password"
          v-model="formData.password"
          class="password input sm:h-16"
          :class="{
            error__input: errorData.password || errorData.username,
          }"
          type="password"
          placeholder="Enter a correct password"
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
        Forgot your password?
        <span
          ><a
            class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
            href="/password/email"
            >Reset.</a
          ></span
        >
      </p>
      <button id="btn" type="submit" class="btn" @click="login">
        SIGN IN
        <svg-vue class="" icon="right-arrow" />
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref } from 'vue';
import axios from 'axios';
import CryptoJS from 'crypto-js';
import Loader from '../../../components/Loader.vue';

export default defineComponent({
  components: {
    Loader,
  },
  setup() {
    const formData = reactive({
      username: '',
      password: '',
    });
    const errorData = reactive({
      username: '',
      password: '',
    });
    const isLoaderVisible = ref(false);

    function encrypt(string: string, key: string) {
      var iv = CryptoJS.lib.WordArray.random(16); // the reason to be 16, please read on `encryptMethod` property.

      var salt = CryptoJS.lib.WordArray.random(256);
      var iterations = 999;
      var encryptMethodLength = 256 / 4; // example: AES number is 256 / 4 = 64
      var hashKey = CryptoJS.PBKDF2(key, salt, {
        hasher: CryptoJS.algo.SHA512,
        keySize: encryptMethodLength / 8,
        iterations: iterations,
      });

      var encrypted = CryptoJS.AES.encrypt(string, hashKey, {
        mode: CryptoJS.mode.CBC,
        iv: iv,
      });
      var encryptedString = CryptoJS.enc.Base64.stringify(encrypted.ciphertext);

      var output = {
        ciphertext: encryptedString,
        iv: CryptoJS.enc.Hex.stringify(iv),
        salt: CryptoJS.enc.Hex.stringify(salt),
        iterations: iterations,
      };

      return CryptoJS.enc.Base64.stringify(
        CryptoJS.enc.Utf8.parse(JSON.stringify(output))
      );
    }

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
          if (response.status) window.location.href = 'activities';
        })
        .catch((error) => {
          console.log(error);
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
</style>
