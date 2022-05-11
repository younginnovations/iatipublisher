<template>
  <div class="mt-14">
    <Loader v-if="loaderVisibility"></Loader>
    <div class="reset reset__password">
      <h2>Reset Password</h2>
      <p>Please enter your new password</p>
      <span class="error" role="alert" v-if="errorData.email != ''">
        {{ errorData.email }}
      </span>
      <div class="reset__content mt-8">
        <label class="text-sm font-bold text-bluecoral" for="password"
          >New Password</label
        >
        <input
          id="new_password"
          :class="errorData.password != '' ? 'error__input input' : 'input'"
          type="password"
          placeholder="Enter a new password"
          v-model="formData.password"
        />
        <svg-vue class="reset__icon text-lg" icon="pw-lock"></svg-vue>
        <span class="error" role="alert" v-if="errorData.password != ''">
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
          :class="
            errorData.password_confirmation != ''
              ? 'error__input input'
              : 'input'
          "
          type="password"
          placeholder="Re-enter your password"
          v-model="formData.password_confirmation"
        />
        <svg-vue class="reset__icon text-lg" icon="pw-lock"></svg-vue>
        <span
          class="error"
          role="alert"
          v-if="errorData.password_confirmation != ''"
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

export default defineComponent({
  components: {
    Loader,
  },
  props: {
    email: {
      type: String,
      required: true,
    },
    reset_token: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    const loaderVisibility = ref(false);
    const formData = reactive({
      email: props.email,
      token: props.reset_token,
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

      axios
        .post('/api/reset', formData)
        .then((res) => {
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
