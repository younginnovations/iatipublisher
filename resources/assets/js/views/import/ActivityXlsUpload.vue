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
      class="mx-10 flex min-h-[65vh] w-[500px] items-start justify-center rounded-lg border border-n-20 bg-white px-4 py-6 md:w-[calc(100%_-_80px)]"
    >
      <div>
        <h6 class="my-8 text-center text-2xl font-bold text-bluecoral">
          Please select one to proceed
        </h6>
        <div class="mb-12 flex flex-wrap items-center justify-center gap-6">
          <div
            :class="uploadType === 'activity' && '!bg-teal-10  '"
            class="w-[315px] rounded border-2 border-n-30 p-4 text-sm"
          >
            <label class="cursor-pointer">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center space-x-1">
                  <svg-vue icon="export" />
                  <span class="font-bold text-bluecoral"
                    >Basic Activity Elements</span
                  >
                </div>
                <input
                  v-model="uploadType"
                  :value="'activity'"
                  type="radio"
                  name="product"
                />
              </div>
              <p class="h-[120px] text-xs text-n-40">
                Download the template 'All elements except result.xls. Fill the
                data for multiple activities except for 'Result' element and
                upload the XLS file to add the activity data in the publisher.
              </p>
            </label>
          </div>
          <div
            :class="uploadType === 'result' && '!bg-teal-10  '"
            class="w-[315px] cursor-pointer rounded border-2 border-n-30 p-4 text-sm"
          >
            <label class="cursor-pointer">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center space-x-1">
                  <svg-vue icon="result-icon" />
                  <span class="font-bold text-bluecoral"
                    >Result except Indicator and Period</span
                  >
                </div>
                <input
                  v-model="uploadType"
                  :value="'result'"
                  type="radio"
                  name="product"
                />
              </div>
              <p class="h-[120px] text-xs text-n-40">
                Download the template ‘Result except indicator and period.xls'.
                Fill the data for multiple results of multiple activities except
                for the indicator and period sub-elements. Upload the XLS file
                to add result elements in specific activities already present in
                the IATI Publisher
              </p>
            </label>
          </div>
          <div
            :class="uploadType === 'indicator' && '!bg-teal-10  '"
            class="w-[315px] cursor-pointer rounded border-2 border-n-30 p-4 text-sm"
          >
            <label class="cursor-pointer">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center space-x-1">
                  <svg-vue icon="indicator-icon" />
                  <span class="font-bold text-bluecoral"
                    >Indicators except Period</span
                  >
                </div>
                <input
                  v-model="uploadType"
                  :value="'indicator'"
                  type="radio"
                  name="product"
                />
              </div>
              <p class="h-[120px] text-xs text-n-40">
                Download the template 'Indicator except period.xls'. Fill the
                data for multiple indicators of multiple results except for the
                period sub-elements. Upload the XLS file to add indicator
                elements in specific results already present in the IATI
                Publisher.
              </p>
            </label>
          </div>
          <div
            :class="uploadType === 'period' && '!bg-teal-10  '"
            class="w-[315px] cursor-pointer rounded border-2 border-n-30 p-4 text-sm"
          >
            <label class="cursor-pointer">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center space-x-1">
                  <svg-vue icon="period-icon" />
                  <span class="font-bold text-bluecoral">Period</span>
                </div>
                <input
                  v-model="uploadType"
                  :value="'period'"
                  type="radio"
                  name="product"
                />
              </div>
              <p class="h-[120px] text-xs text-n-40">
                Download the template 'Period.xls'. Fill the data for multiple
                periods of multiple indicators. Upload the XLS file to add
                period sub-elements in specific indicators already present in
                the IATI Publisher.
              </p>
            </label>
          </div>
        </div>
        <div class="flex justify-center space-x-4">
          <div class="mb-4 h-10 rounded border border-n-30 px-4 py-2">
            <input
              ref="file"
              type="file"
              class="file:-none min-w-[480px] cursor-pointer p-0 text-sm file:cursor-pointer file:rounded-full file:border file:border-solid file:border-spring-50 file:bg-white file:px-4 file:py-0.5 file:text-spring-50"
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
        <div
          class="mt-5 mb-12 flex items-center justify-center gap-4 space-x-3"
        >
          <a
            href="/files/Manuals/IATI_Publisher-User_Manual_v1.0.pdf"
            download="User Manual"
            class="flex items-center space-x-1 text-bluecoral"
          >
            <span class="mx-1.5">Read our import manual</span>
            <svg-vue class="mr-1" icon="export" />
          </a>
          <span class="text-n-20">|</span>
          <div
            class="relative z-10 flex items-center space-x-2.5"
            @click="showDownloadDropdown = !showDownloadDropdown"
          >
            <button class="relative text-sm text-bluecoral">
              <span>Download .XLS activity Template</span>
            </button>
            <HoverText
              hover-text="This template contains all the elements that you have to fill as per the IATI Standard before uploading in IATI Publisher. Please make sure that you follow the structure and format of the template."
              name=""
              class="hover-text import-activity"
              position="right"
              :show-iati-reference="true"
            />
            <svg-vue class="text-[6px] text-bluecoral" icon="dropdown-arrow" />

            <!-- dropdown -->
            <ul
              :class="
                showDownloadDropdown
                  ? 'visible translate-y-2 opacity-100'
                  : 'invisible -translate-y-2 opacity-0 '
              "
              class="absolute top-full -left-2.5 z-0 w-[110%] rounded bg-n-0 p-2 uppercase text-n-40 shadow-lg duration-75"
            >
              <li
                class="group cursor-pointer rounded-sm text-[10px] font-bold text-n-40 hover:bg-teal-10"
              >
                <a
                  href="/files/Templates/ActivityXLS.xlsx"
                  download="Activity Template"
                  class="block w-full p-2.5 text-n-40 group-hover:text-n-50"
                  >Basic Activity Elements.xls</a
                >
              </li>
              <li
                class="group cursor-pointer whitespace-nowrap rounded-sm text-[10px] font-bold text-n-40 hover:bg-teal-10"
              >
                <a
                  href="/files/Templates/ResultXLS.xlsx"
                  download="Result Template"
                  class="block w-full p-2.5 text-n-40 group-hover:text-n-50"
                  >Result except Indicator and Period.xls</a
                >
              </li>
              <li
                class="group cursor-pointer rounded-sm text-[10px] font-bold text-n-40 hover:bg-teal-10"
              >
                <a
                  href="/files/Templates/IndicatorXLS.xlsx"
                  download="Indicator Template"
                  class="block w-full p-2.5 text-n-40 group-hover:text-n-50"
                  >Indicators except Period.xls</a
                >
              </li>
              <li
                class="group cursor-pointer rounded-sm text-[10px] font-bold text-n-40 hover:bg-teal-10"
              >
                <a
                  href="/files/Templates/PeriodXLS.xlsx"
                  download="Period Template"
                  class="block w-full p-2.5 text-n-40 group-hover:text-n-50"
                  >Period.xls</a
                >
              </li>
            </ul>
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

const uploadType = ref();
const showDownloadDropdown = ref(false);

const file = ref(),
  error = ref(''),
  loader = ref(false),
  loaderText = ref('Please Wait');

function uploadFile() {
  loader.value = true;
  loaderText.value = 'Uploading .xls file';
  setTimeout(() => {
    window.location.href = '/activities';
    loader.value = false;
  }, 2000);
  let activity = file.value.files.length ? file.value.files[0] : '';
  let xlsType = uploadType;
  const config = {
    headers: {
      'content-type': 'multipart/form-data',
    },
  };
  let data = new FormData();
  data.append('activity', activity);
  data.append('xlsType', xlsType.value as any);
  console.log(data, 'data');
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
</script>

<style lang="scss"></style>
