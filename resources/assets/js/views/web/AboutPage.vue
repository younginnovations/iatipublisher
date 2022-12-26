<!-- eslint-disable -->
<template>
  <div class="smooth -mb-7 px-5 py-7 sm:px-10 sm:py-14 md:-mb-20">
    <div class="mx-auto max-w-[700px]">
      <section class="rounded bg-white py-4 shadow-textbox sm:py-8">
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            {{ language.about.what_is_iati_publisher_header }}
          </h3>
          <p class="mt-4 text-base">
            {{ language.about.what_is_iati_publisher_description.one }}
          </p>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            {{ language.about.use_iati_publisher_to_header }}
          </h3>
          <ul class="mt-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span class="text-black">{{
                language.about.use_iati_publisher_to_description.one.list_items
                  .one
              }}</span>
            </li>
            <li class="text-base">
              <span class="text-black">{{
                language.about.use_iati_publisher_to_description.one.list_items
                  .two
              }}</span>
            </li>
            <li class="text-base">
              <span class="text-black">{{
                language.about.use_iati_publisher_to_description.one.list_items
                  .three
              }}</span>
            </li>
            <li class="text-base">
              <span class="text-black">{{
                language.about.use_iati_publisher_to_description.one.list_items
                  .four
              }}</span>
            </li>
            <li class="text-base">
              <span class="text-black">{{
                language.about.use_iati_publisher_to_description.one.list_items
                  .five
              }}</span>
            </li>
          </ul>
          <p class="mt-4 text-base">
            {{ language.about.use_iati_publisher_to_description.two }}
          </p>
          <p class="mt-4 text-base">
            <span
              v-html="language.about.use_iati_publisher_to_description.three"
            ></span>
          </p>
        </article>
        <article class="ounded py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            {{ language.about.development_of_iati_header }}
          </h3>
          <p class="mt-4 text-base">
            <span
              v-html="language.about.development_of_iati_description.one"
            ></span>
          </p>
        </article>
      </section>
    </div>
  </div>
</template>
<script lang="ts"></script>
<script>
import { defineComponent } from 'vue';

export default defineComponent({
  setup() {
    const language = window['globalLang'];
    return { language };
  },
});
</script>
