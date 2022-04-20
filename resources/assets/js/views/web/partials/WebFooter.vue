<template>
  <footer
    class="mt-7 bg-bluecoral text-sm leading-6 text-n-20 sm:mt-10 md:mt-20"
  >
    <div class="border-b border-white border-opacity-20">
      <div class="mx-3 py-10 sm:mx-10 xl:mx-24 xl:px-1">
        <div
          class="footer__container grid grid-flow-row gap-8 sm:gap-y-10 md:grid-cols-2 lg:grid-cols-4 lg:justify-items-center"
        >
          <div>
            <a href="#">
              <svg-vue
                class="h-auto w-60 text-6xl sm:w-64"
                icon="footer-logo"
              ></svg-vue>
            </a>
          </div>
          <div class="footer__links">
            <span class="font-bold text-n-10">{{
              props.translation.iati_publisher
            }}</span>
            <ul class="mt-2 flex flex-col">
              <li>
                <a href="#">{{ props.translation.home }}</a>
              </li>
              <li>
                <a href="#">{{ props.translation.about }}</a>
              </li>
              <li>
                <a href="#">{{ props.translation.sign_in }}</a>
              </li>
              <li>
                <a href="#">{{ props.translation.join_now }}</a>
              </li>
            </ul>
          </div>
          <div class="footer__links">
            <span class="font-bold text-n-10">{{
              props.translation.iati_standard
            }}</span>
            <ul class="mt-2 flex flex-col">
              <li>
                <a href="#">{{ props.translation.about_iati_standard }}</a>
              </li>
              <li>
                <a href="#">{{ props.translation.publishing_guid }}</a>
              </li>
              <li>
                <a href="#">{{ props.translation.using_data }}</a>
              </li>
              <li>
                <a href="#">{{ props.translation.support }}</a>
              </li>
            </ul>
          </div>
          <div class="footer__links lg:justify-self-end">
            <div class="text-xs leading-5">
              <p>{{ props.translation.part_of_the_iati }}</p>
              <p>{{ props.translation.code_licensed }}</p>
              <p>{{ props.translation.documentation_licensed }}</p>
            </div>
            <div class="my-5 flex items-center space-x-2 text-n-10">
              <svg-vue class="text-2xl" icon="headphone"></svg-vue>
              <span class="text-sm font-bold uppercase">{{
                props.translation.contact_support
              }}</span>
            </div>
            <ul>
              <li>
                <a
                  class="text-sm text-n-10"
                  href="mailto:support@iatistandard.org"
                  >{{ props.translation.support_email }}</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="mx-5 py-7 sm:mx-10 xl:mx-24 xl:px-1">
      <div class="footer__container grid gap-3 sm:grid-cols-2">
        <span class="flex items-center">
          <svg-vue class="mr-1 text-base" icon="copyright"></svg-vue>
          {{ props.translation.copyright }}</span
        >
        <div class="flex sm:justify-end">
          <a href="#">
            <svg-vue class="mt-1 mr-1 text-4xl" icon="youtube"></svg-vue>
          </a>
          <a class="ml-4" href="#">
            <svg-vue class="mt-1 mr-1 text-4xl" icon="twitter"></svg-vue>
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    translation: String,
  },
  setup(props) {
    return {
      props,
    };
  },
});
</script>
