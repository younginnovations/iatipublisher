<template>
  <div class="smooth -mb-7 bg-[#e5e5e5] px-5 py-7 sm:px-10 sm:py-14 md:-mb-20">
    <div class="mx-auto max-w-[700px]">
      <section class="rounded bg-white py-4 shadow-textbox sm:py-8">
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <p class="text-base">
            {{ language.web_lang.iati_standard_page.iati_standard_description.one }}
          </p>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            1. {{ language.web_lang.iati_standard_page.organisation_data_header }}
          </h3>
          <p class="text-base">
            {{ language.web_lang.iati_standard_page.organisation_data_description.one.list_items.header }}
          </p>
          <ul class="mt-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span class="text-black">
                {{ language.web_lang.iati_standard_page.organisation_data_description.one.list_items.one }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{ language.web_lang.iati_standard_page.organisation_data_description.one.list_items.two }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{ language.web_lang.iati_standard_page.organisation_data_description.one.list_items.three }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{ language.web_lang.iati_standard_page.organisation_data_description.one.list_items.four }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{ language.web_lang.iati_standard_page.organisation_data_description.one.list_items.five }}
              </span>
            </li>
          </ul>
          <p class="mt-4 text-base">
            <a target="_blank" rel="noopener noreferrer" href="/organisation">
              {{ language.web_lang.iati_standard_page.organisation_data_description.two }}
            </a>
          </p>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            2. {{ language.web_lang.iati_standard_page.activity_data_header }}
          </h3>
          <p class="text-base">
            {{ language.web_lang.iati_standard_page.organisation_data_description.one.list_items.header }}
          </p>
          <ul class="my-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span class="text-black"
                    v-html=language.web_lang.iati_standard_page.activity_data_description.one.list_items.one>
              </span>
            </li>
            <li class="text-base">
              <span class="text-black"
                    v-html=language.web_lang.iati_standard_page.activity_data_description.one.list_items.two>
              </span>
            </li>
            <li class="text-base">
              <span class="text-black"
                    v-html=language.web_lang.iati_standard_page.activity_data_description.one.list_items.three>
              </span>
            </li>
            <li class="text-base">
              <span class="text-black"
                    v-html=language.web_lang.iati_standard_page.activity_data_description.one.list_items.four>
              </span>
            </li>
            <li class="text-base">
              <span class="text-black"
                    v-html=language.web_lang.iati_standard_page.activity_data_description.one.list_items.five>
              </span>
            </li>
            <li class="text-base">
              <span class="text-black"
                    v-html=language.web_lang.iati_standard_page.activity_data_description.one.list_items.six>
              </span>
            </li>
            <li class="text-base">
              <span class="text-black"
                    v-html=language.web_lang.iati_standard_page.activity_data_description.one.list_items.seven>
              </span>
            </li>
          </ul>
          <h6 class="text-lg font-bold text-bluecoral">
            {{ language.web_lang.iati_standard_page.publishing_data_either_header }}
          </h6>

          <p class="my-4 text-base">
            {{ language.web_lang.iati_standard_page.publishing_data_either_description.one }}
          </p>
          <p class="my-4 text-base">
            {{ language.web_lang.iati_standard_page.publishing_data_either_description.two }}
          </p>
          <p class="my-4 text-base">
            {{ language.web_lang.iati_standard_page.publishing_data_either_description.three }}
          </p>
          <p class="my-4 text-base">
            <a target="_blank" rel="noopener noreferrer" href="/organisation">
              {{ language.web_lang.iati_standard_page.publishing_data_either_description.four }}
            </a>
          </p>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            {{ language.web_lang.iati_standard_page.download_pdf_header }}
          </h3>
          <p class="text-base">
            {{ language.web_lang.iati_standard_page.download_pdf_description.one }}
          </p>
          <a target="_blank" rel="noopener noreferrer" class="my-2">
            {{ language.web_lang.iati_standard_page.download_pdf_description.two }}
          </a>
          <br/>
          <a target="_blank" rel="noopener noreferrer" class="my-2">
            {{ language.web_lang.iati_standard_page.download_pdf_description.three }}
          </a>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            {{ language.web_lang.iati_standard_page.iati_standard_reference_header }}
          </h3>
          <p class="text-base">
            {{ language.web_lang.iati_standard_page.iati_standard_reference_description.one }}
          </p>
          <a
            target="_blank"
            rel="noopener noreferrer"
            href="https://iatistandard.org/en/iati-standard/203/activity-standard/"
            class="my-2"
          >
            <u>{{ language.web_lang.iati_standard_page.iati_standard_reference_description.two }}</u> </a>
          <br/>
          <a
            target="_blank"
            rel="noopener noreferrer"
            href="https://iatistandard.org/en/iati-standard/203/organisation-standard/"
            class="my-2"
          >
            <u>{{ language.web_lang.iati_standard_page.iati_standard_reference_description.three }}</u>
          </a>
        </article>
      </section>
    </div>
  </div>
</template>
<script lang="ts" setup>
const language = window["global_lang"];
</script>
