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
              <p class="h-[120px] text-[13px] tracking-normal text-n-40">
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
              <p class="h-[120px] text-[13px] tracking-normal text-n-40">
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
              <p class="h-[120px] text-[13px] tracking-normal text-n-40">
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
              <p class="h-[120px] text-[13px] tracking-normal text-n-40">
                Download the template 'Period.xls'. Fill the data for multiple
                periods of multiple indicators. Upload the XLS file to add
                period sub-elements in specific indicators already present in
                the IATI Publisher.
              </p>
            </label>
          </div>
        </div>
        <div
          class="mx-auto mb-4 flex max-w-[900px] justify-between bg-eggshell py-2.5 px-4"
        >
          <div class="flex">
            <svg-vue class="mr-2.5 text-[20px]" icon="alert-outline" />
            <p class="max-w-[650px] text-sm text-n-40">
              Downloading identifier provides you code that uniquely identifies
              result, indicator and period on the IATI Publishers, and allows
              you to update or create new result, indicator and period based on
              them.<br />
              Please download the identifier code to determine the correct
              values.
            </p>
          </div>

          <button
            class="text-sm text-bluecoral"
            @click="showDownloadCode = true"
          >
            Download Identifier Code
          </button>
        </div>
        <div>
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
              :activity-length="activityLength"
              @click="uploadFile"
            />
          </div>
          <div v-if="error" class="error mx-auto max-w-[700px] px-6">
            {{ error }}
          </div>
        </div>
        <p class="mt-6 text-center text-n-50">
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
  <Modal :no-padding="true" :modal-active="showDownloadCode" width="1220">
    <div class="border-b border-n-20 py-5 px-6">
      <div class="flex justify-between">
        <div>
          <div class="flex items-center space-x-2">
            <h6 class="text-2xl">Activities</h6>
            <span
              class="rounded-full bg-mint px-2 py-2 text-[10px] font-bold text-spring-50"
              >{{ activities['total'] }} activities</span
            >
          </div>
          <p class="text-xs text-n-40">
            Please choose the activities for which you would like to download
            the identifier codes.
          </p>
        </div>
        <button @click="showDownloadCode = false">
          <svg-vue class="-mt-4 h-[20px] text-n-50" icon="cross"></svg-vue>
        </button>
      </div>
    </div>
    <div class="flex justify-between border-b border-n-20 py-5 px-6">
      <div class="relative">
        <svg-vue
          class="absolute left-3 top-1/2 h-[16px] -translate-y-1/2 text-base text-n-30"
          icon="search"
        ></svg-vue>

        <input
          v-model="searchValue"
          class="search__input mr-3.5 !rounded-full"
          type="text"
          placeholder="Search activity..."
          @keyup.enter="fetchActivities(1)"
        />
      </div>
      <BtnComponent
        type="primary"
        :text="
          store.state.selectedActivities.length > 0
            ? 'Download Selected'
            : 'Download All'
        "
        icon="download"
        @click="downloadCode"
      />
    </div>
    <div>
      <table class="w-full text-xs text-n-40">
        <thead>
          <tr class="border-b border-n-20 text-left">
            <th class="w-[600px] py-4 px-6">Activity Title</th>
            <th class="py-4 px-6">
              <div
                class="flex cursor-pointer text-n-50 transition duration-500 hover:text-spring-50"
                @click="sortingDirection"
              >
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="
                      direction === 'desc'
                        ? 'descending-arrow'
                        : `ascending-arrow`
                    "
                  />
                </span>
                <span>Updated On</span>
              </div>
            </th>
            <th class="py-4 px-6">Status</th>
            <th class="py-4 px-6 text-left">
              <button class="cursor-pointer" @click="selectAll">
                <svg-vue class="text-base" icon="checkbox" />
              </button>
            </th>
          </tr>
        </thead>
        <tbody
          v-if="activities['total'] > 0"
          class="[&>*:nth-child(odd)]:bg-n-10"
        >
          <tr
            v-for="activity in activities.data"
            :key="activity['id']"
            class="w-full border-b border-n-20"
          >
            <td class="py-4 px-6 text-sm text-n-50">
              <div class="ellipsis relative w-full">
                <div
                  class="w-[500px] !max-w-full overflow-hidden text-ellipsis whitespace-nowrap text-n-50"
                >
                  {{ activity['title'][0]['narrative'] }}
                </div>
                <div class="w-52">
                  <span class="ellipsis__title--hover">{{
                    activity['title'][0]['narrative']
                  }}</span>
                </div>
              </div>
            </td>
            <td class="py-4 px-6 text-xs text-n-40">
              {{ formatDate(activity['updated_at']) }}
            </td>
            <td>
              <button
                class="inline-flex items-center transition duration-500 hover:text-spring-50"
                :class="{
                  'text-n-40': activity['status'] === 'draft',
                  'text-spring-50': activity['status'] === 'published',
                }"
              >
                <span class="mr-1 text-base">
                  <svg-vue
                    :icon="
                      activity['status'] === 'draft' ? 'document-write' : 'tick'
                    "
                  />
                </span>
                <span class="text-sm leading-relaxed">{{
                  activity['status']
                }}</span>
              </button>
            </td>
            <td class="pl-6">
              <label class="checkbox">
                <input
                  v-model="store.state.selectedActivities"
                  :value="activity['id']"
                  type="checkbox"
                />
                <span class="checkmark" />
              </label>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="activities['total'] === 0" class="mx-auto h-[200px] w-full">
        <p class="my-8 text-center text-lg text-n-40">No activites found</p>
      </div>
      <div v-if="!isEmpty" class="mx-6 my-4">
        <Pagination
          v-if="activities && activities.last_page > 1"
          :data="activities"
          @fetch-activities="fetchActivities"
        />
      </div>
    </div>
  </Modal>
  <Modal :modal-active="showCancelModel" width="583">
    <div>
      <div class="mb-6 flex items-center space-x-1">
        <svg-vue class="text-crimson-40" icon="warning-fill" />
        <h6 class="text-sm font-bold">
          {{
            xlsFailed
              ? `${currentActivity} upload failed:`
              : 'Upload in progess'
          }}
        </h6>
      </div>
      <div v-if="xlsFailed" class="rounded-sm bg-rose p-4">
        <p class="text-sm text-n-50">
          {{ xlsFailedMessage }}
        </p>
      </div>
      <div v-else class="rounded-sm bg-rose p-4">
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
      <div
        v-if="!xlsFailed"
        class="mt-6 flex items-center justify-end space-x-4"
      >
        <button
          class="text-xs font-bold uppercase text-n-40"
          @click="cancelImport"
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
      <div v-else class="mt-6 flex items-center justify-end space-x-4">
        <button
          class="text-xs font-bold uppercase text-crimson-50"
          @click="retry"
        >
          Retry
        </button>
      </div>
    </div>
  </Modal>
</template>

<script setup lang="ts">
import { ref, onMounted, provide, computed, reactive, watch, Ref } from 'vue';
import BtnComponent from 'Components/ButtonComponent.vue';
import HoverText from 'Components/HoverText.vue';
import Loader from 'Components/sections/ProgressLoader.vue';
import axios from 'axios';
import XlsUploadIndicator from 'Components/XlsUploadIndicator.vue';
import Modal from 'Components/PopupModal.vue';
import Toast from 'Components/ToastMessage.vue';
import moment from 'moment';
import Pagination from 'Components/TablePagination.vue';
import { useStore } from 'Store/activities/index';

interface ActivitiesInterface {
  last_page: number;
  data: object;
}

const xlsFailedMessage = ref('');
const uploadType = ref();
const showDownloadDropdown = ref(false);
const activityName = ref('');
const toastMessage = ref('');
const toastType = ref(false);
const showDownloadCode = ref(false);
const isEmpty = ref(false);
const xlsFailed = ref(false);
const currentActivity = ref('');
const toastVisibility = ref(false);
const xlsData = ref(false);
const showCancelModel = ref(false);
const activities = reactive({}) as ActivitiesInterface;
const selectAllValue = ref(false);
const totalCount = ref(0);
const processedCount = ref(0);
const file = ref(),
  error = ref(''),
  loader = ref(false),
  loaderText = ref('Please Wait');
const store = useStore();
const searchValue: Ref<string | null> = ref('');
const direction = ref('');

const sortingDirection = () => {
  direction.value === 'asc'
    ? (direction.value = 'desc')
    : (direction.value = 'asc');
  console.log(direction.value, 'direction');
  fetchActivities(1, direction.value);
};

// const sortByDateUrl = () => {
//   if (currentURL.includes('?')) {
//     const queryString = window.location.search,
//       urlParams = new URLSearchParams(queryString);
//     query = urlParams.get('q') ?? '';
//     direction = urlParams.get('direction') === 'desc' ? 'asc' : 'desc';
//   }

//   return `?q=${query}&orderBy=updated_at&direction=${direction}`;
// };

watch(
  () => store.state.selectedActivities,
  (value) => {
    if (value.length < 6) {
      selectAllValue.value = false;
    }
  }
);

const retry = () => {
  axios.delete(`/import/xls`);
  window.location.href = '/import/xls';
};

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
const activityLength = computed(() => {
  return !uploadType?.value?.length;
});

const downloadCode = async () => {
  let apiUrl = '/activities/download-codes/?activities=all';

  if (store.state.selectedActivities.length > 0) {
    const activities = store.state.selectedActivities.join(',');
    apiUrl = `/activities/download-codes/?activities=[${activities}]`;
  }
  const req = await axios({
    method: 'get',
    url: apiUrl,
    responseType: 'blob',
  });
  var blob = new Blob([req.data], {
    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
  });

  // var blob = new Blob([req.data], {
  //   type: 'application/vnd.ms-excel',
  // });
  const link = document.createElement('a');
  link.href = window.URL.createObjectURL(blob);
  link.download = `codes.xlsx`;
  link.click();
};
watch(
  () => {
    store.state.cancelUpload;
  },
  () => {
    cancelImport();
  },
  { deep: true }
);

const selectAll = () => {
  if (!selectAllValue.value) {
    let ids = [] as number[];
    for (let i = 0; i < Object.values(activities.data).length; i++) {
      ids.push(activities.data[i]['id']);
    }

    // for (const activity in activities.data) {
    //   if (!store.state.selectedActivities.includes(activity['id'])) {
    //     ids.push(activity['id']);
    //   }
    // }
    store.dispatch('updateSelectedActivities', ids);
    selectAllValue.value = true;
  } else {
    store.dispatch('updateSelectedActivities', []);
    selectAllValue.value = false;
  }
};
function formatDate(date: Date) {
  return moment(date).fromNow();
}

function uploadFile() {
  if (xlsData.value) {
    showCancelModel.value = true;
  } else {
    loader.value = true;
    loaderText.value = 'Fetching .xls file';

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
          checkXlsstatus();
        } else {
          error.value = Object.values(res.data.errors).join(' ');
        }
      })
      .catch(() => {
        error.value = 'Error has occured while uploading file.';
      })
      .finally(() => {
        loader.value = false;
      });
  }
}

function fetchActivities(active_page: number, direction = '') {
  // tableLoader.value = true;
  let apiUrl = `/activities/page/${active_page}`;
  let params = new URLSearchParams();
  params.append('limit', '6');
  if (direction) {
    params.append('orderBy', 'updated_at');
    params.append('direction', direction);
  }
  if (searchValue.value) {
    params.append('q', searchValue.value);
  }

  axios.get(apiUrl, { params: params }).then((res) => {
    const response = res.data;
    Object.assign(activities, response.data);
    isEmpty.value = !response.data.data.length;
  });
  // tableLoader.value = false;
}

const cancelImport = () => {
  axios.delete(`/import/xls`).then((res) => {
    xlsData.value = false;
    uploadType.value = [];

    file.value.value = null;

    showCancelModel.value = false;
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

    if (Object.keys(res.data.status).length > 0) {
      const checkStatus = setInterval(function () {
        axios.get('/import/xls/status').then((res) => {
          totalCount.value = res.data.data?.total_count;
          processedCount.value = res.data.data?.processed_count;
          xlsFailed.value = !res.data.data?.success;
          xlsFailedMessage.value = res.data.data?.message;
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
  fetchActivities(1);
  checkXlsstatus();
});
provide('xlsFailedMessage', xlsFailedMessage);
provide('activityLength', activityLength);
</script>

<style lang="scss"></style>
