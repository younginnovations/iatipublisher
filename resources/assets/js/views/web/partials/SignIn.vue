<template>
  <div
    id="right"
    class="right m-auto basis-2/4 rounded-l-lg rounded-r-lg bg-white py-5 px-5 sm:py-10 sm:px-10 md:my-0 md:rounded-l-none lg:px-14 lg:py-28 xl:px-24"
  >
    <div class="right__container flex flex-col">
      <h2
        class="mb-2 hidden text-4xl font-bold text-n-50 sm:block sm:text-heading-3"
      >
        Sign In.
      </h2>
      <span class="text-n-40">Welcome back! Please enter your details.</span>
      <div
        class="relative mt-6 mb-4 flex flex-col text-sm font-bold text-bluecoral"
      >
        <label class="mb-2" for="Username">Username</label>
        <input
          class="username input"
          type="text"
          placeholder="Enter a registered username"
          v-model="formData.username"
        />
        <svg
          class="absolute top-11 left-5 sm:top-12 sm:left-6"
          width="20"
          height="22"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="m13.504 11.448-.455.358.538.214a9.667 9.667 0 0 1 6.042 7.916.667.667 0 0 1-.57.73h-.091a.667.667 0 0 1-.667-.593 8.333 8.333 0 0 0-16.562 0A.673.673 0 0 1 .4 19.926a9.667 9.667 0 0 1 6.013-7.907l.536-.214-.454-.357a5.667 5.667 0 1 1 7.008 0Zm-5.911-.845a4.334 4.334 0 1 0 4.815-7.207 4.334 4.334 0 0 0-4.815 7.207Z"
            fill="#155366"
            stroke="#155366"
            stroke-width=".667"
          />
        </svg>
        <span class="error" role="alert" v-if="errorData.username != ''">
          {{ errorData.username }}
        </span>
      </div>
      <div class="relative mb-4 flex flex-col text-sm font-bold text-bluecoral">
        <label class="mb-2" for="Password">Password</label>
        <input
          class="password input"
          type="password"
          placeholder="Enter a correct password"
          v-model="formData.password"
        />
        <svg
          class="absolute top-11 left-5 mt-1 sm:top-12 sm:left-6"
          width="16"
          height="20"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M12.667 7v.333H13A2.667 2.667 0 0 1 15.667 10v7A2.667 2.667 0 0 1 13 19.667H3A2.667 2.667 0 0 1 .333 17v-7A2.667 2.667 0 0 1 3 7.333h.333V5a4.667 4.667 0 0 1 9.334 0v2ZM11 7.333h.333V5a3.333 3.333 0 0 0-6.666 0v2.333H11Zm2.943 10.61c.25-.25.39-.59.39-.943v-7A1.333 1.333 0 0 0 13 8.667H3A1.333 1.333 0 0 0 1.667 10v7A1.333 1.333 0 0 0 3 18.333h10c.354 0 .693-.14.943-.39Z"
            fill="#155366"
            stroke="#155366"
            stroke-width=".667"
          />
        </svg>
        <span class="error" role="alert" v-if="errorData.password">{{
          errorData.password
        }}</span>
      </div>
      <p class="mb-6 text-sm text-n-40">
        Forgot your password?
        <span
          ><a
            class="font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise"
            href="#"
            >Reset.</a
          ></span
        >
      </p>
      <button
        type="submit"
        id="btn"
        class="btn group relative flex justify-center rounded-lg border-none bg-turquoise font-bold text-n-50 outline-none duration-200 hover:bg-bluecoral hover:text-white"
        @click="login"
      >
        SIGN IN
        <svg
          class="absolute right-7 duration-200 hover:fill-white group-hover:translate-x-1"
          width="24"
          height="24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M3 12h18M16 7l5 5-5 5"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
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
