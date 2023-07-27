<!-- eslint-disable vue/no-v-html -->
<template>
  <div>
    <BtnComponent
      v-if="store.state.selectedActivities.length > 0"
      type="secondary"
      :text="translate.button('publish_selected')"
      icon="approved-cloud"
      @click="checkPublish"
    />
    <Modal
      :modal-active="publishAlertValue"
      :width="popUpWidthChange"
      @close="publishAlertToggle"
      @reset="resetPublishStep"
    >
      <template v-if="bulkPublishStep === 1">
        <div class="popup mb-4">
          <div class="title mb-6 flex items-center text-sm">
            <svg-vue class="mr-1 text-lg text-crimson-40" icon="shield" />
            <b>{{ translate.commonText('publishing_alert') }}</b>
          </div>
          <div class="rounded-lg bg-eggshell p-4">
            <div class="text-sm leading-normal">
              {{
                translate.commonText('activities_already_published_will_not')
              }}
              {{
                translate.commonText(
                  'changes_made_to_published_will_be_republished'
                )
              }}
            </div>
          </div>
        </div>
        <div class="flex justify-end">
          <div class="inline-flex">
            <BtnComponent
              class="bg-white px-6 uppercase"
              :text="translate.button('cancel')"
              type=""
              @click="resetPublishStep()"
            />
            <BtnComponent
              class="space"
              :text="translate.button('continue')"
              type="primary"
              @click="verifyCoreElements()"
            />
          </div>
        </div>
      </template>

      <template v-else-if="bulkPublishStep === 2">
        <div class="eligible-activities mb-6 text-sm leading-relaxed">
          <div class="title mb-6 flex">
            <svg-vue icon="tick" class="mr-1 mt-0.5 text-lg text-spring-50" />
            <b>{{ translate.commonText('core_completed_title') }}</b>
          </div>
          {{ translate.commonText('publishing_alert') }}

          <div class="rounded-lg bg-mint px-6">
            <div
              v-if="coreCompletedActivities.length > 0"
              class="coreCompleted"
            >
              <div
                v-for="(act, i) in coreCompletedActivities"
                :key="i"
                class="item py-6"
                :class="{
                  'border-b border-n-20':
                    i != coreCompletedActivities.length - 1,
                }"
              >
                <a :href="`${permalink}${act.activity_id}`" class="">
                  {{ act.title }}
                </a>
              </div>
            </div>
            <div v-else class="py-6">
              {{ translate.missingText('no_activities_found') }}
            </div>
          </div>
        </div>

        <div class="non-eligible-activities mb-6 text-sm leading-relaxed">
          <div class="title mb-6 flex">
            <svg-vue
              icon="warning-fill"
              class="mr-1 mt-0.5 text-lg text-crimson-40"
            />
            <b>{{ translate.commonText('core_completed_title') }}</b>
          </div>

          <div class="rounded-lg bg-rose px-6">
            <div
              v-if="coreInCompletedActivities.length > 0"
              class="notCompleted"
            >
              <div
                v-for="(act, i) in coreInCompletedActivities"
                :key="i"
                class="item py-6"
                :class="{
                  'border-b border-n-20':
                    i != coreInCompletedActivities.length - 1,
                }"
              >
                <a
                  :href="`${permalink}${act.activity_id}`"
                  target="_blank"
                  class=""
                >
                  {{ act.title }}
                </a>
              </div>
            </div>
            <div v-else class="py-6">
              {{ translate.missingText('no_activities_found') }}
            </div>
          </div>
        </div>
        <div class="flex justify-end">
          <div class="inline-flex">
            <BtnComponent
              v-if="
                coreCompletedActivities.length > 0 ||
                coreInCompletedActivities.length > 0
              "
              class="bg-white px-6 uppercase"
              type=""
              :text="translate.button('continue_anyway')"
              @click="validateActivities()"
            />
            <BtnComponent
              class="space"
              type="primary"
              :text="translate.button('go_back')"
              @click="resetPublishStep()"
            />
          </div>
        </div>
      </template>

      <template v-else-if="bulkPublishStep === 3">
        <ValidationErrors :data="validationErrors" />
        <div class="flex justify-end">
          <div class="inline-flex">
            <BtnComponent
              class="bg-white px-6 uppercase"
              type=""
              :text="translate.button('cancel')"
              @click="resetPublishStep()"
            />
            <BtnComponent
              class="space"
              :class="{
                'pointer-events-none': selectedActivities.length === 0,
              }"
              type="primary"
              :text="`${translate.commonText('publishing')} (${
                selectedActivities.length
              }) ${translate.commonText('activities')}`"
              @click="startBulkPublish()"
            />
          </div>
        </div>
      </template>
    </Modal>

    <Modal :modal-active="showCancelConfirmationPopup" width="583">
      <div>
        <BulkPublishingErrorPopup></BulkPublishingErrorPopup>

        <div class="mt-4 flex justify-between space-x-4">
          <button
            class="rounded py-3 px-5 font-semibold uppercase text-n-40 hover:bg-bluecoral hover:text-white"
            @click="cancelOtherBulkPublish"
          >
            Cancel previous bulk publish
          </button>

          <button
            class="rounded bg-bluecoral py-3 px-5 font-semibold uppercase text-white"
            @click="closeCancelConfirmationModal"
          >
            Wait for completion
          </button>
        </div>
      </div>
    </Modal>

    <Modal width="583" :modal-active="showCancelledPopup">
      <h3 class="mb-4 text-lg font-medium">
        <svg-vue icon="tick" class="mr-2 inline text-spring-50"></svg-vue>
        <span class="font-bold">{{
          translate.commonText('cancellation_successful')
        }}</span>
      </h3>
      <div class="fw-bold rounded-lg bg-spring-30 px-3 py-2 text-white">
        {{ messageOnCancellation }}
      </div>
      <div class="my-3 flex justify-between">
        <button
          class="rounded py-3 px-5 font-semibold uppercase text-n-40 hover:bg-bluecoral hover:text-white"
          @click="closeCancelledDetailsPopup"
        >
          {{ translate.button('continue_selecting') }}
        </button>
        <button
          class="rounded bg-bluecoral py-3 px-5 font-semibold uppercase text-white"
          @click="publishAfterCancel"
        >
          {{ translate.button('publish') }}
        </button>
      </div>
    </Modal>
    <PageLoader v-if="isLoading"></PageLoader>
    <Loader
      v-if="loader"
      :text="loaderText"
      :class="{ 'animate-loader': loader }"
    />
  </div>
</template>

<script setup lang="ts">
import {
  defineProps,
  ref,
  reactive,
  Ref,
  computed,
  onMounted,
  watch,
  provide,
  inject,
} from 'vue';
import { useToggle, useStorage } from '@vueuse/core';
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from 'Components/PopupModal.vue';
import Loader from 'Components/sections/ProgressLoader.vue';
import ValidationErrors from './ValidationErrors.vue';
import PageLoader from 'Components/Loader.vue';

// Vuex Store
import { useStore } from 'Store/activities/index';
import BulkPublishingErrorPopup from 'Components/BulkPublishingErrorPopup.vue';
import { Translate } from 'Composable/translationHelper';

defineProps({
  type: { type: String, default: 'primary' },
});

const translate = new Translate();
/**
 *  Global State
 */
const store = useStore();

// toggle state for modal popup
let [publishAlertValue, publishAlertToggle] = useToggle();

// state for step of the flow
const bulkPublishStep = ref(1);
const bulkPublishStatus = reactive({});
const isLoading = ref(false);
const startPublish = ref(false);

const published = ref(false);

// display/hide validator loader
const loader = ref(false);

// Dynamic text for loader
const loaderText = ref(translate.commonText('please_wait'));

/*States for Bulk publish cancellation flow*/
const showCancelConfirmationPopup = ref(false);
const showCancelledPopup = ref(false);
const messageOnCancellation = ref('No bulk publish were cancelled');

// reset step to zero after closing modal
const resetPublishStep = () => {
  bulkPublishStep.value = 1;
  publishAlertValue.value = false;
  selectedActivities.value = [];
};

const popUpWidthChange = computed(() => {
  let width = ref('825');
  switch (bulkPublishStep.value) {
    case 1:
      width.value = '583';
      break;
    case 2:
      width.value = '809';
      break;
    default:
  }

  return width.value;
});

// toast visibility
interface MessageTypeface {
  message: string;
  type: boolean;
  visibility: boolean;
}

const errorData = inject('errorData') as MessageTypeface;

const displayToast = (message, type) => {
  errorData.message = message;
  errorData.type = type;
  errorData.visibility = true;
};

const emptybulkPublishStatus = () => {
  for (const status in bulkPublishStatus) {
    delete bulkPublishStatus[status];
  }
};

/**
 * check publish status
 */
const checkPublish = () => {
  isLoading.value = true;
  axios
    .get(`/activities/checks-for-activity-bulk-publish`)
    .then((res) => {
      const response = res.data;

      if (response.success === true) {
        publishAlertValue.value = true;
      } else {
        if (response?.in_progress) {
          emptybulkPublishStatus();
          Object.assign(bulkPublishStatus, response.data.activities);
          showCancelConfirmationModal();
        } else {
          displayToast(response.message, response.success);
        }
      }
    })
    .finally(() => (isLoading.value = false));
};

/**
 * Verify core elements
 */
interface actTypeface {
  title: string;
  activity_id: number;
}

let coreCompletedActivities: Ref<actTypeface[]> = ref([]),
  coreInCompletedActivities: Ref<actTypeface[]> = ref([]),
  permalink = `/activity/`;

const verifyCoreElements = () => {
  loader.value = true;
  loaderText.value = translate.commonText('verifying_core_elements');
  const activities = store.state.selectedActivities.join(', ');

  axios
    .get(`/activities/core-elements-completed?activities=[${activities}]`)
    .then((res) => {
      const response = res.data;
      if (response.success) {
        coreCompletedActivities.value = response.data.complete;
        coreInCompletedActivities.value = response.data.incomplete;
        bulkPublishStep.value = 2;
      } else {
        loader.value = false;
        resetPublishStep();

        if (response?.in_progress) {
          emptybulkPublishStatus();
          Object.assign(bulkPublishStatus, response.data.activities);

          showCancelConfirmationModal();
        } else {
          displayToast(response.message, response.success);
        }
      }

      setTimeout(() => {
        loader.value = false;
      }, 2000);
    });
};

/**
 * Validating Activities
 */
let validationErrors = ref({});
onMounted(() => {
  axios
    .get(
      `activities/bulk-publish-status?organization_id=${pa.value?.publishingActivities.organization_id}&&uuid=${pa.value?.publishingActivities.job_batch_uuid}`
    )
    .then((res) => {
      Object.assign(pa.value?.publishingActivities, res.data?.data);
    });
});
const validateActivities = () => {
  loader.value = true;
  loaderText.value = translate.commonText('validating_activities');
  const activities = store.state.selectedActivities.join(', ');

  axios
    .post(`/activities/validate-activities?activities=[${activities}]`)
    .then((res) => {
      const response = res.data;

      if (response.success) {
        bulkPublishStep.value = 3;
        validationErrors.value = response.data;
      } else {
        resetPublishStep();
        displayToast(response.message, response.success);
      }

      setTimeout(() => {
        loader.value = false;
      }, 2000);
    });
};

/**
 * Bulk publishing activities
 */

let selectedActivities: Ref<number[]> = ref([]);
provide('selectedActivities', selectedActivities);

// local storage for publishing
interface paType {
  publishingActivities: {
    organization_id?: string;
    job_batch_uuid?: string;
    activities?: object;
    status?: string;
    message?: string;
  };
}
const pa: Ref<paType> = useStorage('vue-use-local-storage', {
  publishingActivities: localStorage.getItem('publishingActivities') ?? {},
});

const startBulkPublish = () => {
  store.dispatch('updateStartBulkPublish', true);

  loader.value = true;
  loaderText.value = translate.commonText('starting_to_publish');
  pa.value.publishingActivities = {};

  axios
    .get(
      `activities/start-bulk-publish?activities=[${selectedActivities.value}]`
    )
    .then((res) => {
      store.dispatch('updateStartBulkPublish', true);

      startPublish.value = true;

      const response = res.data;
      if (response.success) {
        bulkPublishStep.value = 1;
        publishAlertValue.value = false;
        pa.value.publishingActivities = response.data;
      } else {
        loader.value = false;
        resetPublishStep();

        if (response?.in_progress) {
          emptybulkPublishStatus();
          Object.assign(bulkPublishStatus, response.data.activities);
          Object.assign(
            pa.value.publishingActivities,
            response.data.activities
          );
          store.dispatch(
            'updateBulkpublishActivities',
            response.data.activities
          );

          showCancelConfirmationModal();
        } else {
          displayToast(response.message, response.success);
        }
      }

      setTimeout(() => {
        loader.value = false;
        published.value = true;
      }, 1000);
    });
};
watch(
  () => pa.value,
  () => {
    store.dispatch(
      'updateBulkPublishLength',
      pa?.value?.publishingActivities?.activities &&
        Object.keys(pa?.value?.publishingActivities?.activities as string[])
          .length
    );
    store.dispatch('updateBulkpublishActivities', pa?.value);
  },
  { deep: true }
);

/*Cancels on-going bulk publish*/
const cancelOtherBulkPublish = () => {
  loaderText.value = 'Cancelling Bulk Publish';
  loader.value = true;
  closeCancelConfirmationModal();

  axios.get('activities/cancel-bulk-publish').then((res) => {
    if (res.data.success) {
      setCancellationMessage(res.data.message);
      showCancelledDetailPopup();
    }

    setTimeout(() => {
      loader.value = false;
    }, 500);
  });
};

/*Show modal that shows number of bulk publish cancelled */
const showCancelledDetailPopup = () => {
  errorData.visibility = false;
  showCancelledPopup.value = true;
};

/*Sets message in modal triggered by showCancelledDetailPopup() */
const setCancellationMessage = (msg) => {
  errorData.visibility = false;
  messageOnCancellation.value = msg;
};

/*Closes Cancel Confirmation Popup*/
const closeCancelledDetailsPopup = () => {
  errorData.visibility = false;
  showCancelledPopup.value = false;
};

/*Opens modal that allows to cancel existing bulk publish*/
const showCancelConfirmationModal = () => {
  showCancelConfirmationPopup.value = true;
};

/*Closes modal that allows to cancel existing bulk publish*/
const closeCancelConfirmationModal = () => {
  showCancelConfirmationPopup.value = false;
};

/* Trigger the normal flow of bulk publishing activities*/
const publishAfterCancel = () => {
  showCancelledPopup.value = false;
  checkPublish();
};

provide('paStorage', pa);
provide('bulkPublishStatus', bulkPublishStatus);
provide('startPublish', startPublish);
</script>
