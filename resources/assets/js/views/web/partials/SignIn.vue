<template>
  <div
    id="right"
    class="right m-auto basis-2/4 rounded-l-lg rounded-r-lg bg-white py-5 px-5 sm:py-10 sm:px-10 md:my-0 md:rounded-l-none lg:px-14 lg:py-28 xl:px-24"
  >
    <div class="right__container flex flex-col">
      <h2 class="mb-2 hidden sm:block">Sign In.</h2>
      <span class="text-n-40">Welcome back! Please enter your details.</span>
      <div
        class="relative mt-6 mb-4 flex flex-col text-sm font-bold text-bluecoral"
      >
        <label class="mb-2" for="Username">Username</label>
        <input
          class="username input sm:h-16"
          type="text"
          placeholder="Enter a registered username"
          v-model="formData.username"
        />
        <svg-vue
          class="absolute top-11 left-5 text-xl sm:top-12 sm:left-6"
          icon="user"
        ></svg-vue>
        <span class="error" role="alert" v-if="errorData.username != ''">
          {{ errorData.username }}
        </span>
      </div>
      <div class="relative mb-4 flex flex-col text-sm font-bold text-bluecoral">
        <label class="mb-2" for="Password">Password</label>
        <input
          class="password input sm:h-16"
          type="password"
          placeholder="Enter a correct password"
          v-model="formData.password"
        />
        <svg-vue
          class="absolute top-11 left-5 text-xl sm:top-12 sm:left-6"
          icon="pw-lock"
        ></svg-vue>
        <span class="error" role="alert" v-if="errorData.password">{{
          errorData.password
        }}</span>
      </div>
      <p class="mb-6 text-sm text-n-40">
        Forgot your password?
        <span
          ><a
            class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise"
            href="#"
            >Reset.</a
          ></span
        >
      </p>
      <button type="submit" id="btn" class="btn" @click="login">
        SIGN IN
        <svg-vue class="" icon="right-arrow"></svg-vue>
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import axios from 'axios';

export default defineComponent({
  setup() {
    const formData = reactive({
      username: '',
      password: '',
    });
    const errorData = reactive({
      username: '',
      password: '',
    });

    async function login() {
      axios
        .post('/login', formData)
        .then((response) => {
          errorData.username = '';
          errorData.password = '';
          if (response.status) window.location.href = 'admin/dashboard';
        })
        .catch((error) => {
          const { errors } = error.response.data;
          errorData.username = errors.username ? errors.username[0] : '';
          errorData.password = errors.password ? errors.password[0] : '';
        });
    }

    return {
      formData,
      errorData,
      login,
    };
  },
});
</script>
