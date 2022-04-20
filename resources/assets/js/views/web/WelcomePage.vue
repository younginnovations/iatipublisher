<template>
  <section class="main mt-10 sm:mx-10 xl:mx-24 xl:px-1">
    <div class="main__container sm:mb-10 md:mb-20 md:flex">
      <div
        class="left flex flex-col items-center justify-center bg-bluecoral px-3 pt-5 pb-72 text-white sm:rounded-r-lg sm:rounded-l-lg sm:px-5 sm:pt-10 md:basis-2/4 md:rounded-r-none md:pb-16 lg:pt-44 lg:pb-44 xl:px-24"
      >
        <div class="left__container rounded-lg p-5 sm:p-10">
          <span class="left__title font-bold">{{
            props.translation.iati_publishing_tool
          }}</span>
          <p class="pt-2 sm:pt-6 sm:pb-8">
            {{ props.translation.iati_publishing_tool_description }}
          </p>
          <div class="hidden sm:block">
            <span class="flex">
              {{ props.translation.registered_yet }}
              <button
                class="ml-1 border-b-2 border-b-transparent text-base text-turquoise hover:border-b-2 hover:border-b-turquoise"
                @click="togglePage"
              >
                {{ page }}
              </button>
            </span>
          </div>
        </div>
      </div>

      <SignIn
        v-if="page === props.translation.join_now"
        :translation="props.translation"
      ></SignIn>
      <JoinNow v-else :translation="props.translation"></JoinNow>
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
    translation: String,
  },
  setup(props) {
    const page = ref(props.translation.join_now);

    function togglePage() {
      page.value =
        page.value === props.translation.join_now
          ? props.translation.sign_in
          : props.translation.join_now;
    }

    return {
      page,
      togglePage,
      props,
    };
  },
});
</script>
