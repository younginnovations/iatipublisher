<template>
  <footer
    id="footer"
    class="mt-7 bg-bluecoral text-sm leading-6 text-n-20 sm:mt-10 md:mt-20"
  >
    <div class="border-b border-white border-opacity-20">
      <div class="mx-3 py-10 sm:mx-10 xl:mx-24 xl:px-1">
        <div
          class="footer__container grid grid-flow-row gap-8 sm:gap-y-10 md:grid-cols-2 lg:grid-cols-4 lg:justify-items-center"
        >
          <div>
            <a href="/">
              <svg-vue
                class="h-auto w-60 text-6xl sm:w-64"
                icon="footer-logo"
              />
            </a>
          </div>

          <div class="footer__links">
            <span class="font-bold text-n-10">{{
              language.web_lang.iati_publisher
            }}</span>
            <ul class="mt-2 flex flex-col">
              <li>
                <a :href="superAdmin ? '/list-organisations' : '/activities'">{{
                  superAdmin
                    ? language.common_lang.org_list
                    : language.activity_lang.your_activities_label
                }}</a>
              </li>
              <li>
                <a href="/about">{{ language.web_lang.about }}</a>
              </li>
              <li>
                <a
                  target="_blank"
                  rel="noopener noreferrer"
                  class="cursor-pointer"
                  @click="downloadManual('user')"
                  >{{ language.user_lang.user_manual }} V1.0</a
                >
              </li>
            </ul>
          </div>
          <div class="footer__links">
            <span class="font-bold text-n-10">{{
              language.web_lang.iati_standard
            }}</span>
            <ul class="mt-2 flex flex-col">
              <li>
                <a href="/iati-standard">{{
                  language.web_lang.iati_standard
                }}</a>
              </li>
              <li>
                <a href="/publishing-checklist">{{
                  language.web_lang.publishing_checklist
                }}</a>
              </li>
              <li>
                <a href="/support">{{ language.web_lang.support }}</a>
              </li>
            </ul>
          </div>
          <div class="footer__links lg:justify-self-end">
            <div class="text-xs leading-5">
              <p>{{ language.web_lang.footer.part_of_iati_unified_label }}</p>
              <p>{{ language.web_lang.footer.code_licensed_under_label }}</p>
              <p>
                {{
                  language.web_lang.footer.documentation_licensed_under_label
                }}
              </p>
            </div>
            <div class="my-5 flex items-center space-x-2 text-n-10">
              <svg-vue class="text-2xl" icon="headphone" />
              <span class="text-xs font-bold uppercase">{{
                language.web_lang.footer.any_questions_contact_label
              }}</span>
            </div>
            <ul>
              <li>
                <a
                  class="text-sm text-n-10"
                  href="mailto:support@iatistandard.org"
                  >support@iatistandard.org</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="mx-5 py-7 sm:mx-10 xl:mx-24 xl:px-1">
      <div class="footer__container grid gap-3 sm:grid-cols-2">
        <span class="flex items-center text-n-30">
          <svg-vue class="mr-1 text-base" icon="copyright" />
          {{ language.web_lang.footer.copyright_label }}</span
        >
        <div class="flex sm:justify-end">
          <a
            href="https://www.youtube.com/channel/UCAVH1gcgJXElsj8ENC-bDQQ"
            target="_blank"
          >
            <svg-vue class="mt-1 mr-1 text-4xl" icon="youtube" />
          </a>
          <a class="ml-4" href="https://twitter.com/IATI_aid" target="_blank">
            <svg-vue class="mt-1 mr-1 text-4xl" icon="twitter" />
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import axios from 'axios';

defineProps({
  superAdmin: { type: Boolean, required: false, default: false },
});

const language = window['globalLang'];

function downloadManual(type: string) {
  let fileName = {
    user: 'IATI_Publisher-User_Manual_v1.0.pdf',
  };
  let url = window.location.origin + `/Data/Manuals/${fileName[type]}`;

  axios({
    url: url,
    method: 'GET',
    responseType: 'arraybuffer',
  }).then((response) => {
    let blob = new Blob([response.data], {
      type: 'application/pdf',
    });
    let link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = fileName[type];
    link.click();
  });
}
</script>
