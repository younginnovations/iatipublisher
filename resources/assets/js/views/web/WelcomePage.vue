<template>
  <section class="main mt-7 sm:mx-10 sm:mt-10 xl:mx-24 xl:px-1">
    <div class="main__container md:flex">
      <div
        class="left flex flex-col items-center justify-center bg-bluecoral px-3 pt-5 pb-72 text-white sm:rounded-r-lg sm:rounded-l-lg sm:px-5 sm:pt-10 md:basis-2/4 md:rounded-r-none md:pb-16 lg:pt-44 lg:pb-44 xl:px-24"
      >
        <div class="left__container rounded-lg p-5 sm:p-10">
          <span class="left__title font-bold">IATI Publishing Tool</span>
          <p class="pt-2 sm:pt-6 sm:pb-8">
            Welcome to IATI Publisher. Use this tool to start your IATI
            publishing journey. Enter your login information if you're already a
            user or create a new account if you're new here.
          </p>
          <span class="hidden sm:block">
            Haven't registered yet?
            <button class="text-turquoise" @click="togglePage">
              {{ page }}
            </button>
          </span>
        </div>
      </div>

      <SignIn v-if="page === 'Join Now'"></SignIn>
      <JoinNow v-else></JoinNow>
    </div>
  </section>
</template>

<script>
import { defineComponent, ref } from 'vue';
import SignIn from './partials/SignIn.vue';
import JoinNow from './partials/JoinNow.vue';

export default defineComponent({
  components: {
    JoinNow,
    SignIn,
  },
  setup() {
    const page = ref('Join Now');

    function togglePage() {
      page.value = page.value === 'Join Now' ? 'Sign In' : 'Join Now';
    }

    return {
      page,
      togglePage,
    };
  },
});
</script>
