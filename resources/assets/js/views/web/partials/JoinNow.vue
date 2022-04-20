<template>
  <div
    class="right m-auto basis-2/4 rounded-l-lg rounded-r-lg bg-white py-5 px-5 sm:py-10 sm:px-7 md:my-0 md:rounded-l-none lg:py-28 xl:px-20"
  >
    <div class="right__container flex flex-col">
      <h2 class="mb-2 hidden sm:block">{{ props.translation.join_now }}.</h2>
      <span class="mb-8 text-n-40 xl:pr-6">
        {{ props.translation.join_now_description }}
      </span>
      <a href="#" class="right__content mb-6">
        <div class="right__icon">
          <svg-vue class="text-6xl" icon="default-1"></svg-vue>
        </div>
        <div class="details mx-4 xl:px-1">
          <span class="text-sm font-bold text-bluecoral">{{
            props.translation.unregistered_account
          }}</span>
          <p class="text-xs leading-5 text-n-40">
            {{ props.translation.unregistered_account_description }}
          </p>
        </div>
        <div>
          <svg-vue class="right__arrow text-2xl" icon="right-arrow"></svg-vue>
        </div>
      </a>
      <a href="#" class="right__content mb-4">
        <div class="right__icon">
          <svg-vue class="text-6xl" icon="default-2"></svg-vue>
        </div>
        <div class="details mx-4 xl:px-1" @click="goToRegisterPage">
          <span class="text-sm font-bold text-bluecoral">{{
            props.translation.registered_account
          }}</span>
          <p class="text-xs leading-5 text-n-40">
            {{ props.translation.registered_account_description }}
          </p>
        </div>
        <div>
          <svg-vue class="right__arrow text-2xl" icon="right-arrow"></svg-vue>
        </div>
      </a>
      <span class="text-sm text-n-40"
        >{{ props.translation.not_sure }}
        <a
          class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise"
          href="#"
          >{{ props.translation.contact_support }}.</a
        ></span
      >
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    translation: String,
  },
  setup(props) {
    function goToRegisterPage() {
      window.location.href = '/register';
    }

    return {
      goToRegisterPage,
      props,
    };
  },
});
</script>
