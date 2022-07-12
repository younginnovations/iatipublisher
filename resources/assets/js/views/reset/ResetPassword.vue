<template>
  <div class="mt-14">
    <Loader v-if="loaderVisibility" />
    <div class="reset reset__password" @keyup.enter="reset">
      <h2>Reset Password</h2>
      <p>Please enter your new password</p>
      <span v-if="errorData.email != ''" class="error" role="alert">
        {{ errorData.email }}
      </span>
      <div class="reset__content mt-8">
        <label class="text-sm font-bold text-bluecoral" for="password"
          >New Password</label
        >
        <input
          id="new_password"
          v-model="formData.password"
          class="input"
          :class="{
            error__input: errorData.password != '',
          }"
          type="password"
          placeholder="Enter a new password"
        />
        <svg-vue class="reset__icon text-lg" icon="pw-lock" />
        <span v-if="errorData.password != ''" class="error" role="alert">
          {{ errorData.password }}
        </span>
      </div>
      <div class="reset__content mt-4">
        <label
          class="text-sm font-bold text-bluecoral"
          for="password_confirmation"
          >Repeat Password</label
        >
        <input
          id="repeat_password"
          v-model="formData.password_confirmation"
          class="input"
          :class="{
            error__input:
              errorData.password_confirmation ||
              (errorData.password && formData.password != '') != '',
          }"
          type="password"
          placeholder="Re-enter your password"
        />
        <svg-vue class="reset__icon text-lg" icon="pw-lock" />
        <span
          v-if="errorData.password_confirmation != ''"
          class="error"
          role="alert"
        >
          {{ errorData.password_confirmation }}
        </span>
      </div>
      <button type="submit" class="btn reset-btn" @click="reset()">
        Reset Password
      </button>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent, reactive, ref } from 'vue';
import Loader from '../../components/Loader.vue';
import axios from 'axios';
import CryptoJS from 'crypto-js';

export default defineComponent({
  components: {
    Loader,
  },
  props: {
    email: {
      type: String,
      required: true,
    },
    token: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    const loaderVisibility = ref(false);
    const formData = reactive({
      email: props.email,
      token: props.token,
      password: '',
      password_confirmation: '',
    });
    const errorData = reactive({
      email: '',
      password: '',
      password_confirmation: '',
    });

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

    function reset() {
      loaderVisibility.value = true;

      let form = {
        email: formData.email,
        token: props.token,
        password_confirmation: encrypt(
          formData.password_confirmation,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
        password: encrypt(
          formData.password,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
      };

      axios
        .post('/reset', form)
        .then((res) => {
          if (res.request.responseURL.includes('activities')) {
            window.location.href = '/activities';
          }

          const response = res.data;
          const errors = 'errors' in response ? response.errors : [];
          errorData.password = errors.password ? errors.password[0] : '';
          errorData.email = errors.email ? errors.email[0] : '';
          errorData.password_confirmation = errors.password_confirmation
            ? errors.password_confirmation[0]
            : '';

          if (response.success) {
            window.location.href = '/activities';
          }

          loaderVisibility.value = false;
        })
        .catch((error) => {
          const { errors } = error.response.data;

          errorData.password = errors.password ? errors.password[0] : '';
          errorData.email = errors.email ? errors.email[0] : '';
          errorData.password_confirmation = errors.password_confirmation
            ? errors.password_confirmation[0]
            : '';

          loaderVisibility.value = false;
        });
    }

    return {
      props,
      loaderVisibility,
      formData,
      errorData,
      reset,
    };
  },
});
</script>
