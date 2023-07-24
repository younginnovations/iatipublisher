<!-- eslint-disable -->
<template>
  <div class="smooth -mb-7 px-5 py-7 sm:px-10 sm:py-14 md:-mb-20">
    <div class="mx-auto max-w-[700px]">
      <section class="rounded bg-white py-4 shadow-textbox sm:py-8">
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <p class="text-base">
            {{ language.iati_standard.iati_standard_description.one }}
          </p>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            1. {{ language.iati_standard.organisation_data_header }}
          </h3>
          <p class="text-base">
            {{
              language.iati_standard.organisation_data_description.one
                .list_items.header
            }}
          </p>
          <ul class="mt-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span class="text-black">
                {{
                  language.iati_standard.organisation_data_description.one
                    .list_items.one
                }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{
                  language.iati_standard.organisation_data_description.one
                    .list_items.two
                }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{
                  language.iati_standard.organisation_data_description.one
                    .list_items.three
                }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{
                  language.iati_standard.organisation_data_description.one
                    .list_items.four
                }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{
                  language.iati_standard.organisation_data_description.one
                    .list_items.five
                }}
              </span>
            </li>
          </ul>
          <p class="mt-4 text-base">
            <a target="_blank" rel="noopener noreferrer" href="/organisation">
              {{ language.iati_standard.organisation_data_description.two }}
            </a>
          </p>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            2. {{ language.iati_standard.activity_data_header }}
          </h3>
          <p class="text-base">
            {{
              language.iati_standard.activity_data_description.one.list_items
                .header
            }}
          </p>
          <ul class="my-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span
                class="text-black"
                v-html="
                  language.iati_standard.activity_data_description.one
                    .list_items.one
                "
              >
              </span>
            </li>
            <li class="text-base">
              <span
                class="text-black"
                v-html="
                  language.iati_standard.activity_data_description.one
                    .list_items.two
                "
              >
              </span>
            </li>
            <li class="text-base">
              <span
                class="text-black"
                v-html="
                  language.iati_standard.activity_data_description.one
                    .list_items.three
                "
              >
              </span>
            </li>
            <li class="text-base">
              <span
                class="text-black"
                v-html="
                  language.iati_standard.activity_data_description.one
                    .list_items.four
                "
              >
              </span>
            </li>
            <li class="text-base">
              <span
                class="text-black"
                v-html="
                  language.iati_standard.activity_data_description.one
                    .list_items.five
                "
              >
              </span>
            </li>
            <li class="text-base">
              <span
                class="text-black"
                v-html="
                  language.iati_standard.activity_data_description.one
                    .list_items.six
                "
              >
              </span>
            </li>
            <li class="text-base">
              <span
                class="text-black"
                v-html="
                  language.iati_standard.activity_data_description.one
                    .list_items.seven
                "
              >
              </span>
            </li>
          </ul>
          <h6 class="text-lg font-bold text-bluecoral">
            {{ language.iati_standard.publishing_data_either_header }}
          </h6>

          <p class="my-4 text-base">
            {{ language.iati_standard.publishing_data_either_description.one }}
          </p>
          <p class="my-4 text-base">
            {{ language.iati_standard.publishing_data_either_description.two }}
          </p>
          <p class="my-4 text-base">
            {{
              language.iati_standard.publishing_data_either_description.three
            }}
          </p>
          <p class="my-4 text-base">
            <a target="_blank" rel="noopener noreferrer" href="/organisation">
              {{
                language.iati_standard.publishing_data_either_description.four
              }}
            </a>
          </p>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            {{ language.iati_standard.download_pdf_header }}
          </h3>
          <p class="text-base">
            {{ language.iati_standard.download_pdf_description.one }}
          </p>
          <a
            target="_blank"
            rel="noopener noreferrer"
            class="my-2 cursor-pointer"
            @click="downloadManual('organization')"
          >
            [{{ language.iati_standard.download_pdf_description.two }}]
          </a>
          <br />
          <a
            target="_blank"
            rel="noopener noreferrer"
            class="my-2 cursor-pointer"
            @click="downloadManual('activity')"
          >
            [{{ language.iati_standard.download_pdf_description.three }}]
          </a>
        </article>
        <article class="py-4 px-6 sm:py-6 sm:px-12">
          <h3 class="my-2 text-2xl font-bold text-bluecoral">
            {{ language.iati_standard.iati_standard_reference_header }}
          </h3>
          <p class="text-base">
            {{ language.iati_standard.iati_standard_reference_description.one }}
          </p>
          <a
            target="_blank"
            rel="noopener noreferrer"
            href="https://iatistandard.org/en/iati-standard/203/activity-standard/"
            class="my-2"
          >
            <u>{{
              language.iati_standard.iati_standard_reference_description.two
            }}</u>
          </a>
          <br />
          <a
            target="_blank"
            rel="noopener noreferrer"
            href="https://iatistandard.org/en/iati-standard/203/organisation-standard/"
            class="my-2"
          >
            <u>{{
              language.iati_standard.iati_standard_reference_description.three
            }}</u>
          </a>
        </article>
      </section>
    </div>
  </div>
</template>
<script lang="ts" setup>
import axios from 'axios';

const language = window['globalLang'];

function downloadManual(type: string) {
  let fileName = {
    activity: 'IATI_Publisher_Activity_Standard.pdf',
    organization: 'IATI_Publisher_Organisation_Standard.pdf',
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
