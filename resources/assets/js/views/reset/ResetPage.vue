<template>
  <div class="mt-14">
    <Loader v-if="loaderVisibility"></Loader>
    <div class="reset" @keyup.enter="reset">
      <h2>Password Recovery</h2>
      <p>
        Please enter your email, we will send you a link to reset your password
      </p>
      <div class="reset__content mt-8">
        <label class="text-sm font-bold text-bluecoral" for="email"
          >Email</label
        >
        <input
          id="email"
          type="email"
          placeholder="Enter your email address"
          :class="emailError != '' ? 'error__input input' : 'input'"
          v-model="formData.email"
        />
        <svg-vue class="reset__icon mail__icon" icon="mail"></svg-vue>
        <span class="error" role="alert" v-if="emailError"
          >{{ emailError }}
        </span>
      </div>
      <button type="submit" class="btn reset-btn" @click="reset()">
        Send password reset link
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, reactive } from 'vue';
import Loader from '../../components/Loader.vue';
import axios from 'axios';

export default defineComponent({
  components: {
    Loader,
  },
  setup() {
    const formData = reactive({
      email: '',
    });
    const emailError = ref('');
    const loaderVisibility = ref(false);

    function reset() {
      loaderVisibility.value = true;

      axios
        .post('/password/email', formData)
        .then((res) => {
          if (res.request.responseURL.includes('activities')) {
            window.location.href = '/activities';
          }

          const response = res.data;
          const errors =
            !response.success || 'errors' in response ? response.errors : [];

          emailError.value = errors.email ? errors.email[0] : '';

          if (response.success) {
            window.location.href = '/password/confirm';
          }

          loaderVisibility.value = false;
        })
        .catch((error) => {
          const { errors } = error.response.data;
          emailError.value = errors.email ? errors.email[0] : '';

          loaderVisibility.value = false;
        });
    }

    return {
      formData,
      loaderVisibility,
      emailError,
      reset,
    };
  },
});
</script>

<style lang="scss">
.reset {
  width: 583px;
  margin: auto;
  box-shadow: 0px 20px 40px 20px rgba(0, 0, 0, 0.05);
  @apply rounded-lg bg-white p-24;

  &__content {
    @apply relative flex flex-col;

    .input {
      @apply my-2 py-5;
    }
  }
  &__icon {
    @apply absolute left-6;
    top: 51px;
  }
  .mail__icon {
    top: 52px;
  }

  h2 {
    @apply text-heading-3 font-bold text-n-50;
  }
  p {
    @apply text-base text-n-40;
  }
  .reset-btn {
    @apply mt-3 w-full;
    padding: 16px 94px;

    @media screen and (min-width: 640px) {
      padding: 18px 94px;
    }
  }
  .verification {
    font-size: 190px;
  }
}
.reset__password {
  height: 610px;
}
</style>
