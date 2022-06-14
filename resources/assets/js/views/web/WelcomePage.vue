<template>
  <section class="main mt-10 sm:mx-10 xl:mx-24 xl:px-1">
    <div class="main__container sm:mb-10 md:mb-20 md:flex">
      <div
        class="left flex flex-col items-center justify-center bg-bluecoral px-3 pt-5 pb-72 text-white sm:rounded-r-lg sm:rounded-l-lg sm:px-5 sm:pt-10 md:basis-2/4 md:rounded-r-none md:pb-16 lg:pt-44 lg:pb-44 xl:px-24"
      >
        <div class="left__container rounded-lg p-5 sm:p-10">
          <span class="left__title font-bold">IATI Publishing Tool</span>
          <p class="pt-2 sm:pt-6 sm:pb-8">
            Welcome to IATI Publisher. Publish IATI data on your organisation’s
            development and humanitarian financing and activities. Enter your
            login information if you’re already a user or create a new account
            if you’re new here.
          </p>
          <div class="hidden sm:block">
            <span class="flex flex-wrap">
              {{
                pageContent === 'Join Now'
                  ? "Haven't registered yet?"
                  : 'Already have an account?'
              }}
              <button
                class="ml-1 border-b-2 border-b-transparent text-base text-turquoise hover:border-b-2 hover:border-b-turquoise"
                @click="togglePage"
              >
                {{ pageContent }}
              </button>
            </span>
          </div>
        </div>
      </div>

      <SignIn v-if="pageContent === 'Join Now'" />
      <JoinNow v-else />
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
  props: {
    page: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    const pageContent = ref(props.page === 'signin' ? 'Join Now' : 'Sign In');

    function togglePage() {
      pageContent.value = pageContent.value === 'Join Now' ? 'Sign In' : 'Join Now';
    }

    return {
      pageContent,
      togglePage,
    };
  },
});
</script>
