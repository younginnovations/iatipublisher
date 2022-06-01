<template>
  <div
    class="right join-now m-auto flex basis-2/4 items-center rounded-l-lg rounded-r-lg bg-white py-5 px-5 sm:py-10 sm:px-7 md:my-0 md:rounded-l-none lg:py-28 xl:px-14"
  >
    <div class="right__container flex flex-col">
      <h2 class="mb-2 hidden sm:block">Join Now.</h2>
      <span class="mb-8 text-n-40 xl:pr-6">
        To begin, your organisation needs to be registered as an IATI publisher.
        Select an option and we’ll guide you through this process.
      </span>
      <a href="#" class="right__content pointer-events-none mb-6">
        <div class="right__icon">
          <svg-vue class="text-6xl" icon="default-1"></svg-vue>
        </div>
        <div class="details mx-4 xl:px-1">
          <span class="text-sm font-bold text-bluecoral">I am new to IATI</span>
          <p class="text-xs leading-5 text-n-40">
            Use this option if your organization <u>has not</u> registered an
            account with IATI on the IATI Registry
          </p>
        </div>
        <div>
          <svg-vue class="right__arrow text-2xl" icon="right-arrow"></svg-vue>
        </div>
      </a>
      <a href="/register" class="right__content mb-4">
        <div class="right__icon">
          <svg-vue class="text-6xl" icon="default-2"></svg-vue>
        </div>
        <div class="details mx-4 xl:px-1">
          <span class="text-sm font-bold text-bluecoral"
            >My organisation has registered with IATI</span
          >
          <p class="text-xs leading-5 text-n-40">
            Use this option if your organisation is already registered as an
            IATI Publisher on the
            <a href="https://www.iatiregistry.org/" target="_blank"
              >IATI Registry</a
            >
          </p>
        </div>
        <div>
          <svg-vue class="right__arrow text-2xl" icon="right-arrow"></svg-vue>
        </div>
      </a>
      <span class="text-sm text-n-40"
        >Not sure which one to select?
        <a
          class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
          href="mailto:support@iatistandard.org"
          target="_blank"
          >Contact Support.</a
        ></span
      >
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  setup() {
    function goToRegisterPage() {
      window.location.href = '/register';
    }

    return {
      goToRegisterPage,
    };
  },
});
</script>
