<template>
  <div class="mt-14">
    <Loader v-if="loaderVisibility" />
    <div class="reset reset__password" @keyup.enter="reset">
      <h2>{{ language.common_lang.reset_password }}</h2>
      <p class="mb-4">{{ language.common_lang.enter_new_password }}</p>
      <div class="text-center">
        <span v-if="errorData.email !== ''" class="error" role="alert">
          {{ errorData.email }}
        </span>
      </div>
      <div
        :class="{
          'reset__content mt-8': !errorData.email,
          'reset__content mt-3': errorData.email,
        }"
      >
        <label class="text-sm font-bold text-bluecoral" for="password">{{
          language.common_lang.new_password
        }}</label>
        <input
          id="new_password"
          v-model="formData.password"
          class="input"
          :class="{
            error__input: errorData.password !== '',
          }"
          type="password"
          :placeholder="language.common_lang.enter_new_password_placeholder"
        />
        <svg-vue class="lock-icon text-xl" icon="pw-lock" />
        <span v-if="errorData.password !== ''" class="error" role="alert">
          {{ errorData.password }}
        </span>
      </div>
      <div class="reset__content mt-4">
        <label
          class="text-sm font-bold text-bluecoral"
          for="password_confirmation"
          >{{ language.common_lang.repeat_password }}</label
        >
        <input
          id="repeat_password"
          v-model="formData.password_confirmation"
          class="input"
          :class="{
            error__input:
              errorData.password_confirmation ||
              (errorData.password && formData.password !== '') !== '',
          }"
          type="password"
          :placeholder="language.common_lang.reenter_password_placeholder"
        />
        <svg-vue class="lock-icon text-xl" icon="pw-lock" />
        <span
          v-if="errorData.password_confirmation !== ''"
          class="error"
          role="alert"
        >
          {{ errorData.password_confirmation }}
        </span>
      </div>
      <button type="submit" class="btn reset-btn" @click="reset()">
        {{ language.common_lang.reset_password }}
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
    const language = window['globalLang'];
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
      language,
    };
  },
});
</script>
