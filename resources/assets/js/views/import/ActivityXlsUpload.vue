<template>
  <div class="listing__page bg-paper pt-4 pb-[71px]">
    <div class="page-title mb-4 w-screen px-10">
      <div class="flex items-end gap-4">
        <div class="title">
          <div class="flex items-center">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left" />
              </a>
            </div>
            <div class="flex min-h-[48px] w-full grow items-center">
              <h4 class="ellipsis__title relative mr-4 font-bold">
                <span class="ellipsis__title overflow-hidden">
                  Import Activities from .XLS
                </span>
              </h4>
            </div>
          </div>
        </div>
        <Toast
          v-if="toastVisibility"
          class="toast -bottom-24 ml-auto"
          :message="toastMessage"
          :type="toastType"
        />
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
    <XlsUploadIndicator
      v-if="xlsData"
      :total-count="totalCount"
      :processed-count="processedCount"
      :xls-failed="xlsFailed"
      :activity-name="activityName"
      :xls-data="xlsData"
    />
  </div>
  <Loader
    v-if="loader"
    :text="loaderText"
    :class="{ 'animate-loader': loader }"
  />
  <Modal :modal-active="xlsData" width="583">
    <div>
      <div class="mb-6 flex items-center space-x-1">
        <svg-vue class="text-crimson-40" icon="warning-fill" />
        <h6 class="text-sm font-bold">Upload in progess</h6>
      </div>
      <div class="rounded-sm bg-rose p-4">
        <p
          v-if="totalCount === processedCount && totalCount !== 0"
          class="text-sm text-n-50"
        >
          You have recently uploaded '{{ currentActivity }}', either proceed to
          add/update or cancel to start new import.
        </p>

        <p v-else class="text-sm text-n-50">
          We are in the process of uploading '{{ currentActivity }}' XLS file.
          We ask for your patience while we complete the upload.
        </p>
      </div>
      <div class="mt-6 flex items-center justify-end space-x-4">
        <button
          @click="cancelImport"
          class="text-xs font-bold uppercase text-n-40"
        >
          Cancel upload
        </button>

        <a
          v-if="totalCount === processedCount && totalCount !== 0"
          class="w-[158px] rounded-sm bg-bluecoral py-3 text-center text-xs font-bold uppercase text-white hover:text-white"
          href="/import/xls/list"
        >
          Proceed to Import
        </a>
        <a
          v-else
          class="rounded-sm bg-bluecoral px-10 py-3 text-xs font-bold uppercase text-white hover:text-white"
          href="/activities"
        >
          go back
        </a>
      </div>
    </div>
  </Modal>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import BtnComponent from 'Components/ButtonComponent.vue';
import HoverText from 'Components/HoverText.vue';
import Loader from 'Components/sections/ProgressLoader.vue';
import axios from 'axios';
import XlsUploadIndicator from 'Components/XlsUploadIndicator.vue';
import Modal from 'Components/PopupModal.vue';
import Toast from 'Components/ToastMessage.vue';

const uploadType = ref();
const showDownloadDropdown = ref(false);
const activityName = ref('');
const toastMessage = ref('');
const toastType = ref(false);
const xlsFailed = ref(false);
const currentActivity = ref('');
const toastVisibility = ref(false);
const xlsData = ref(false);
const totalCount = ref(0);
const processedCount = ref(0);
const file = ref(),
  error = ref(''),
  loader = ref(false),
  loaderText = ref('Please Wait');
const mapActivityName = (name) => {
  switch (name) {
    case 'activity':
      return 'Basic Activity Elements';
    case 'period':
      return 'Period';
    case 'indicator':
      return 'Indicators except Period';
    case 'result':
      return 'Result except Indicators and Period';
    default:
      return name;
  }
};
function uploadFile() {
  loader.value = true;
  loaderText.value = 'Uploading .xls file';

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
  error.value = '';

  axios
    .post('/import/xls', data, config)
    .then((res) => {
      if (file.value.files.length && res?.data?.success) {
        window.location.href = '/activities';
      } else {
        error.value = Object.values(res.data.errors).join(' ');
      }
    })
    .catch(() => {
      error.value = 'Error has occured while uploading file.';
    });
}
const cancelImport = () => {
  axios.delete(`/import/xls`).then((res) => {
    xlsData.value = false;
    const response = res.data;
    toastVisibility.value = true;
    setTimeout(() => (toastVisibility.value = false), 15000);
    toastMessage.value = response.message;
    toastType.value = response.success;
  });
};
const checkXlsstatus = () => {
  axios.get('/import/xls/progress_status').then((res) => {
    activityName.value = res?.data?.status?.template;
    currentActivity.value = mapActivityName(activityName.value);
    xlsData.value = Object.keys(res.data.status).length > 0;
    console.log(Object.keys(res.data.status).length, 'status');
    if (Object.keys(res.data.status).length > 0) {
      const checkStatus = setInterval(function () {
        axios.get('/import/xls/status').then((res) => {
          totalCount.value = res.data.data?.total_count;
          processedCount.value = res.data.data?.processed_count;
          xlsFailed.value = !res.data.data?.success;

          if (
            !res.data?.data?.success ||
            res.data?.data?.message === 'Complete'
          ) {
            clearInterval(checkStatus);
          }
        });
      }, 2500);
    }
  });
};
onMounted(() => {
  checkXlsstatus();
});
</script>

<style lang="scss"></style>
