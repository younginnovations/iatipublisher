<template>
  <div class="py-8 px-10">
    <div class="flex flex-wrap justify-between">
      <h6 class="text-3xl font-bold text-n-50">
        Add/Update All <span class="capitalize">{{ status.template }}</span>
      </h6>
      <div class="flex flex-wrap justify-end gap-3">
        <Toast
          v-if="toastVisibility"
          class="toast -bottom-24"
          :message="toastMessage"
          :type="toastType"
        />
        <button
          class="rounded bg-n-0 px-4 py-3 text-xs font-bold uppercase text-bluecoral shadow-md"
          @click="cancelImport"
        >
          <span><svg-vue class="pt-1.5 text-2xl" icon="cross" /></span>
          <span>cancel this import</span>
        </button>
        <button
          :class="selectedActivities.length === 0 && ' cursor-not-allowed'"
          class="rounded bg-bluecoral px-4 py-3 text-xs font-bold uppercase text-n-0"
          @click="addActivities"
        >
          <svg-vue class="mr-2 text-sm" icon="up-arrow-outline" />
          <span class="mr-2">add </span> ({{ selectedActivities.length }} /
          {{ activitiesLength }})
        </button>
      </div>
    </div>
    <p class="mt-4 text-sm text-n-40">
      Select from the list below to add {{ status.template }} to the publisher.
      Make your selection and follow the on-screen prompts to successfully
      add/update your selected {{ status.template }}
      <b>
        Please note that you must re-upload any unselected
        {{ status.template }}, and if the import is canceled, you will need to
        upload them again.</b
      >
    </p>
    <div class="iati-list-table upload-list-table mt-4">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="title" class="flex items-center space-x-1" scope="col">
              <span class="cursor-pointer" @click="sort">
                <svg-vue
                  :class="sortOrder === 'descending' ? ' rotate-180' : ''"
                  icon="sort-icon"
                  class="pt-1 text-[5px]"
                />
              </span>
              <span>{{ status.template }} Title</span>
            </th>
            <th id="status" scope="col">
              <span class="block text-left">Status</span>
            </th>
            <th id="cb" scope="col">
              <span class="cursor-pointer">
                <svg-vue icon="checkbox" @click="selectAllActivities()" />
              </span>
            </th>
          </tr>
        </thead>
        <tbody>
          <template v-if="activitiesLength === 0">
            <Placeholder />
          </template>
          <tr
            v-for="(activity, index) in importData"
            v-else
            ref="tableRow"
            :key="index"
            :class="{
              'upload-error':
                activity &&
                activity['errors'] &&
                Object.keys(activity['errors']).length > 0,
            }"
          >
            <td class="title" :class="countErrors(index) > 0 && 'xls-error'">
              <XlsListError
                :width="tableWidth"
                :activity="activity"
                :index="index"
                :import-data="importData"
                :status="status"
              />
            </td>
            <td :class="countErrors(index) > 0 && ' xls-error'">
              <span class="text-sm text-n-40">{{
                activity.existing ? 'Existing' : 'New'
              }}</span>
            </td>
            <td
              :class="countErrors(index) > 0 && ' xls-error'"
              class="check-column"
              @click="(event: Event) => event.stopPropagation()"
            >
              <input
                v-if="errorLength('critical', index) === 0"
                v-model="selectedActivities"
                type="checkbox"
                :value="index"
              />
            </td>
            <!-- <td>{{ activity[index].data.title[0] }}</td> -->
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <Loader
    v-if="loader"
    :text="loaderText"
    :class="{ 'animate-loader': loader }"
  />
  <Modal :modal-active="showCriticalErrorModel" width="583">
    <div class="mb-6 flex items-center space-x-1">
      <svg-vue class="text-crimson-40" icon="warning-fill" />
      <h6 class="text-sm font-bold">Critical Errors Detected</h6>
    </div>
    <div class="mb-6 rounded-sm bg-rose p-4 text-sm text-n-50">
      Some of the {{ status.template }} contain critical errors and thus, cannot
      be uploaded to IATI Publisher. Please review the errors and follow the
      instructions provided in the user manual.
    </div>
    <button
      class="ml-auto flex w-[158px] justify-center rounded-sm bg-bluecoral py-3 text-center text-xs font-bold uppercase text-white hover:text-white"
      @click="showCriticalErrorModel = false"
    >
      <span>Review errors</span>
    </button>
  </Modal>
</template>
<script setup lang="ts">
import XlsListError from 'Components/XlsListError.vue';
import Modal from 'Components/PopupModal.vue';
import axios from 'axios';
import Toast from 'Components/ToastMessage.vue';
import {
  defineProps,
  onMounted,
  ref,
  nextTick,
  onUnmounted,
  onUpdated,
} from 'vue';
import Loader from 'Components/sections/ProgressLoader.vue';

const selectAll = ref(false);
const sortOrder = ref('asceding');

const tableRow = ref({});
const showCriticalErrorModel = ref(false);
const loader = ref(false),
  loaderText = ref('Adding activities');

const selectedCount = ref(0);
const activitiesLength = ref(0);
const selectedActivities = ref<string[]>([]);
const tableWidth = ref({});
const toastMessage = ref('');
const toastType = ref(false);
const toastVisibility = ref(false);

const props = defineProps({
  status: {
    type: Object,
    required: true,
  },
  // Number with a default value
  importData: {
    type: Object,
    required: true,
  },
});
onUpdated(() => {
  console.log(selectedActivities.value);
});
const getDimensions = async () => {
  await nextTick();
  tableWidth.value = tableRow?.value['0'].clientWidth;
};

const sort = () => {
  if (sortOrder.value === 'ascending') {
    sortOrder.value = 'descending';
  } else {
    sortOrder.value = 'ascending';
  }
  let sortedData = props.importData;
  switch (props.status['template']) {
    case 'activity':
      sortedData.sort((a, b) =>
        a.data.title &&
        a.data.title[0].narrative.toString().toLowerCase() < b.data.title &&
        b.data.title[0].narrative.toString().toLowerCase()
          ? 1
          : -1
      );
      break;

    case 'result':
      sortedData.sort((a, b) =>
        a.data.title &&
        a.data.title[0].narrative[0]['narrative'].toString().toLowerCase() <
          b.data.title &&
        b.data.title[0].narrative[0]['narrative'].toString().toLowerCase()
          ? 1
          : -1
      );

      break;
    case 'period':
      sortedData.sort((a, b) =>
        a.data.title &&
        a.data.title[0].narrative[0]['narrative'].toString().toLowerCase() <
          b.data.title &&
        b.data.title[0].narrative[0]['narrative'].toString().toLowerCase()
          ? 1
          : -1
      );

      break;
    case 'indicator':
      sortedData.sort((a, b) =>
        a.data.title &&
        a.data.title[0].narrative[0]['narrative'].toString().toLowerCase() <
          b.data.title &&
        b.data.title[0].narrative[0]['narrative'].toString().toLowerCase()
          ? 1
          : -1
      );

      break;
    default:
      break;
  }

  console.log(props.importData, 'sort', sortedData);
};

onUnmounted(() => {
  window.removeEventListener('resize', getDimensions);
});

onMounted(() => {
  getDimensions();
  window.addEventListener('resize', getDimensions);
  checkCriticalError();
  activitiesLength.value = props.importData.length;
  loaderText.value = `Adding ${props.status.template}`;
  console.log(props.importData, props.status, 'onm');
});

const cancelImport = () => {
  axios.delete(`/import/xls`).then((res) => {
    const response = res.data;
    toastVisibility.value = true;
    setTimeout(() => (toastVisibility.value = false), 15000);
    toastMessage.value = response.message;
    toastType.value = response.success;
    setTimeout(() => {
      window.location.href = '/import/xls';
    }, 2000);
  });
};

const checkCriticalError = () => {
  const criricalArray = props.importData?.map((data, index) => {
    return errorLength('critical', index);
  });
  let totalCriricalErrorCount = 0;
  for (let i = 0; i < criricalArray.length; i++) {
    totalCriricalErrorCount += criricalArray[i];
  }
  if (totalCriricalErrorCount > 0) {
    showCriticalErrorModel.value = true;
  }
};
const countErrors = (activityIndex) => {
  let count = 0;
  for (const type in props.importData[activityIndex]['errors']) {
    for (const index in props.importData[activityIndex]['errors'][type]) {
      count += Object.keys(
        props.importData[activityIndex]['errors'][type][index]
      ).length;
    }
  }

  return count;
};
const addActivities = () => {
  if (selectedActivities.value.length > 0) {
    loader.value = true;

    axios
      .post(`/import/xls/activity`, { activities: selectedActivities.value })
      .then(() => {
        window.location.href = '/activities';
      });
  }
};
const errorLength = (errorType, activityIndex) => {
  let count = 0;

  for (const index in props.importData[activityIndex]['errors'][errorType]) {
    count += Object.keys(
      props.importData[activityIndex]['errors'][errorType][index]
    ).length;
  }

  return count;
};

function selectAllActivities() {
  selectAll.value = !selectAll.value;
  selectedCount.value = 0;
  selectedActivities.value.length = 0;
  console.log(props.importData, 'from selectall');
  Object.keys(props.importData).forEach((activity_id) => {
    let index = selectedActivities.value.indexOf(activity_id);
    if (
      Object.keys(props.importData[activity_id]['errors']).indexOf(
        'critical'
      ) === -1
    ) {
      if (selectAll.value) {
        selectedActivities.value.push(activity_id);
        console.log(activity_id, 'acivity id');
        selectedCount.value = selectedCount.value + 1;
      } else {
        selectedActivities.value.splice(index, 1);
      }
    }
  });
  if (!selectAll.value) {
    selectedCount.value = 0;
  }
}
</script>
<style scoped>
.xls-error {
  background-image: linear-gradient(#fff1f0 60px, #ffffff 0%);
}
</style>
