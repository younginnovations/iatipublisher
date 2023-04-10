<template>
  <div class="listing__page bg-paper pt-4 pb-[71px]">
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
                  Import Activities from .XLS
                </span>
              </h4>
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
      <div>
        <h6 class="my-8 text-center text-2xl font-bold text-bluecoral">
          Please select one to proceed
        </h6>
        <div class="my-8 flex space-x-6">
          <div class="h-[175] w-[300px] rounded border-2 border-n-30 p-4">
            <label>
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center space-x-1">
                  <svg-vue icon="export" />
                  <span class="font-bold text-bluecoral"
                    >Basic Activity Elements</span
                  >
                </div>
                <input type="radio" name="product" />
              </div>
              <p class="text-xs text-n-40">
                Download the template 'All elements except result.xls. Fill the
                data for multiple activities except for 'Result' element and
                upload the XLS file to add the activity data in the publisher.
              </p>
            </label>
          </div>
          <div class="w-[300px]">
            <label>
              <input type="radio" name="product" />

              <div>
                <div class="panel-heading">Product B</div>
                <div class="panel-body">Product specific content</div>
              </div>
            </label>
          </div>
          <div class="w-[300px]">
            <label>
              <input type="radio" name="product" />

              <div>
                <div class="panel-heading">Product C</div>
                <div class="panel-body">Product specific content</div>
              </div>
            </label>
          </div>
        </div>
        <div class="flex space-x-4">
          <div class="mb-4 h-10 rounded border border-n-30 px-4 py-2">
            <input
              ref="file"
              type="file"
              class="min-w-[480px] cursor-pointer p-0 text-sm file:cursor-pointer file:rounded-full file:border file:border-solid file:border-spring-50 file:bg-white file:px-4 file:py-0.5 file:text-spring-50 file:outline-none"
            />
          </div>
          <BtnComponent
            class="!border-red h-10 !border"
            type="primary"
            text="Upload file"
            icon="upload-file"
            @click="uploadFile"
          />
        </div>
        <span v-if="error" class="error">{{ error }}</span>
        <p class="mt-10 text-center text-n-50">
          Please make sure to read the instructions before beginning this
          process.
        </p>
        <div class="mt-4 flex items-center justify-center gap-4 space-x-6">
          <div class="flex items-center space-x-1 text-bluecoral">
            <span class="mx-1.5">Read our import manual</span>
            <svg-vue class="mr-1" icon="export" />
          </div>
          <span class="text-n-20">|</span>
          <div class="flex items-center space-x-2.5">
            <button class="relative text-sm text-bluecoral">
              <span @click="downloadExcel"
                >Download .XLS activity Template</span
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
  loaderText = ref('Please Wait');

function uploadFile() {
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

  axios
    .post('/import/xls', data, config)
    .then((res) => {
      if (file.value.files.length && res?.data?.success) {
        setTimeout(() => {
          window.location.href = '/import/list';
        }, 5000);
      } else {
        error.value = Object.values(res.data.errors).join(' ');
        loader.value = false;
      }
    })
    .catch(() => {
      error.value = 'Error has occured while uploading file.';
      loader.value = false;
    });
}

function downloadExcel() {
  axios({
    url: 'import/download/xls',
    method: 'GET',
    responseType: 'arraybuffer',
  }).then((response) => {
    let blob = new Blob([response.data], {
      type: 'application/xls',
    });
    let link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'csv_test.csv';
    link.click();
  });
}
</script>

<style lang="scss"></style>
