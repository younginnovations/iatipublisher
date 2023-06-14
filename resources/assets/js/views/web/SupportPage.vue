<!-- eslint-disable -->
<template>
  <div class="smooth -mb-7 px-5 py-7 sm:px-10 sm:py-14 md:-mb-20">
    <div class="mx-auto max-w-[700px]">
      <section class="rounded bg-white py-4 shadow-textbox sm:py-8">
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="text-2xl font-bold text-bluecoral">
            {{ language.web_lang.support }}
          </h3>

          <p class="mt-4 text-base">
            <span v-html="language.support.support_description.one"></span>
          </p>
          <p class="mt-4 text-base">
            <span v-html="language.support.support_description.two"></span>
          </p>
        </article>
      </section>
    </div>
  </div>
</template>
<script lang="ts" setup>
const language = window['globalLang'];
</script>
