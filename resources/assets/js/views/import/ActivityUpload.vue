<template>
  <div class="listing__page bg-paper pb-[71px] pt-4">
    <div class="page-title mb-4 w-screen px-10">
      <div class="flex items-end gap-4">
        <div class="title basis-6/12">
          <div class="inline-flex w-[500px] items-center md:w-[600px]">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left" />
              </a>
            </div>
            <div class="inline-flex min-h-[48px] grow items-center">
              <h4 class="ellipsis__title relative mr-4 font-bold">
                <span class="ellipsis__title overflow-hidden">
                  Import Activity
                </span>
              </h4>
              <div class="tooltip-btn">
                <button class="">
                  <svg-vue icon="question-mark" />
                  <span>What is an activity?</span>
                </button>
                <div class="tooltip-btn__content z-[1]">
                  <div class="content">
                    <div
                      class="mb-1.5 text-caption-c1 font-bold text-bluecoral"
                    >
                      What is an activity?
                    </div>
                    <p>
                      You need to provide data about your organisation's
                      development and humanitarian 'activities'. The unit of
                      work described by an 'activity' is determined by the
                      organisation that is publishing the data. For example, an
                      activity could be a donor government providing US$ 50
                      million to a recipient country's government to implement
                      basic education over 5 years. Or an activity could be an
                      NGO spending US$ 500,000 to deliver clean drinking water
                      to 1000 households over 6 months.
                      <br />
                      Therefore your organisation will need to determine how it
                      will divide its work internally into activities. Read the
                      <a
                        target="_blank"
                        rel="noopener noreferrer"
                        href="/publishing-checklist"
                        class="text-bluecoral"
                        ><b>Publishing Checklist</b></a
                      >
                      for more information.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="actions flex grow justify-end">
          <div class="inline-flex justify-center">
            <BtnComponent
              class="mr-3.5"
              type="primary"
              text="Import (5/10)"
              icon="download-file"
            />
          </div>
        </div> -->
      </div>
    </div>
    <div
      class="mx-10 flex min-h-[65vh] w-[500px] items-start justify-center rounded-lg border border-n-20 bg-white md:w-[calc(100%_-_80px)]"
    >
      <div class="mt-24">
        <div
          v-if="hasOngoingImportWarning"
          class="border-orangeish my-2 flex max-w-[95%] items-center space-x-2 rounded-md bg-eggshell px-4 py-6 align-middle text-xs font-normal text-n-50"
        >
          Cannot import.
          <template v-if="ongoingImportType === ''">
            {{ ongoingImportType }}
            <a href="#" class="px-1 font-bold" @click="openZendeskLauncher"
              >Contact support</a
            >
          </template>
          <template v-else>
            Another import is in progress. Please try again later or
            <a
              :href="
                ongoingImportType === 'xls'
                  ? '/import/xls/list'
                  : '/import/list'
              "
              class="px-1 font-bold"
            >
              view import list </a
            >.
          </template>
        </div>

        <div class="mt-2 max-w-[95%] rounded-lg border border-n-30">
          <p
            class="border-b border-n-30 p-4 text-sm font-bold uppercase text-n-50"
          >
            Import .CSV/.XML file
          </p>
          <div class="p-6">
            <div class="mb-4 rounded border border-n-30 px-4 py-3">
              <input
                ref="file"
                type="file"
                class="min-w-[480px] cursor-pointer p-0 text-sm file:cursor-pointer file:rounded-full file:border file:border-solid file:border-spring-50 file:bg-white file:px-4 file:py-0.5 file:text-spring-50 file:outline-none"
              />
            </div>
            <span v-if="error" class="error">{{ error }}</span>
            <div
              class="flex w-[280px] flex-col items-start gap-4 md:w-[400px] md:flex-row md:items-end lg:w-auto lg:justify-between"
            >
              <BtnComponent
                class="!border-red !border"
                type="primary"
                text="Upload file"
                icon="upload-file"
                @click="checkOngoingImports"
              />
              <div class="flex items-center space-x-2.5">
                <button class="relative text-sm text-bluecoral">
                  <svg-vue :icon="'download'" class="mr-1" />
                  <span @click="downloadExcel"
                    >Download .CSV activity Template</span
                  >
                </button>
                <HoverText
                  hover-text="This template contains all the elements that you have to fill as per the IATI Standard before uploading in IATI Publisher. Please make sure that you follow the structure and format of the template."
                  name=""
                  class="hover-text import-activity"
                  position="right"
                  :show-iati-reference="true"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Loader
    v-if="loader"
    :text="loaderText"
    :class="{ 'animate-loader': loader }"
  />
</template>

<script setup lang="ts">
import { ref } from 'vue';
import BtnComponent from 'Components/ButtonComponent.vue';
import HoverText from 'Components/HoverText.vue';
import Loader from 'Components/sections/ProgressLoader.vue';
import axios from 'axios';

const file = ref(),
  error = ref(''),
  loader = ref(false),
  loaderText = ref('Please Wait'),
  hasOngoingImportWarning = ref(false),
  ongoingImportType = ref('');

async function checkOngoingImports() {
  try {
    const response = await axios.get('/import/check-ongoing-import');

    if (hasOngoingImport(response.data.data)) {
      console.log('response data', response.data);
      showHasOngoingImportWarning(response.data.data.import_type);
    } else {
      uploadFile();
    }
  } catch (e) {
    console.log(e);
  }
}

function hasOngoingImport(responseDataWithHasImportFlag): boolean {
  return responseDataWithHasImportFlag?.has_ongoing_import ?? false;
}

function showHasOngoingImportWarning(importType: null | string) {
  hasOngoingImportWarning.value = true;
  ongoingImportType.value = importType ? importType : '';
  console.log(importType);
}

async function uploadFile() {
  loader.value = true;
  loaderText.value = 'Uploading .csv/.xml file';
  let activity = file.value.files.length ? file.value.files[0] : '';
  const config = {
    headers: {
      'content-type': 'multipart/form-data',
    },
  };
  let data = new FormData();
  data.append('activity', activity);
  error.value = '';

  try {
    const response = await axios.post('/import', data, config);

    console.log('response', response);

    if (response?.data?.success && file.value.files.length) {
      setTimeout(() => {
        window.location.href = '/import/list';
      }, 5000);
    } else {
      if (hasOngoingImport(response?.data?.errors)) {
        showHasOngoingImportWarning(response.data.errors.import_type);
      } else {
        error.value = Object.values(response.data.errors).join(' ');
      }

      loader.value = false;
    }
  } catch (err) {
    error.value = 'Error has occurred while uploading the file.';
    loader.value = false;
  }
}

function downloadExcel() {
  axios({
    url: 'import/download/csv',
    method: 'GET',
    responseType: 'arraybuffer',
  }).then((response) => {
    let blob = new Blob([response.data], {
      type: 'application/csv',
    });
    let link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'Import_Activity_CSV_Template.csv';
    link.click();
  });
}

function openZendeskLauncher() {
  if (window.zE && window.zE.activate) {
    window.zE.activate();
  }
}

declare global {
  interface Window {
    /* eslint-disable-next-line @typescript-eslint/no-explicit-any */
    zE: any;
  }
}
</script>

<style lang="scss"></style>
