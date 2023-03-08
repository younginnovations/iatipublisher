<!-- eslint-disable vue/no-v-html -->
<template>
  <div>
    <BtnComponent
      v-if="store.state.selectedActivities.length > 0"
      type="secondary"
      text="Publish Selected"
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
            <b>Publishing alert</b>
          </div>
          <div class="rounded-lg bg-eggshell p-4">
            <div class="text-sm leading-normal">
              Activities that are already published will not be published.
              Changes made to published activities (Draft) will be republished.
            </div>
          </div>
        </div>
        <div class="flex justify-end">
          <div class="inline-flex">
            <BtnComponent
              class="bg-white px-6 uppercase"
              text="Cancel"
              type=""
              @click="resetPublishStep()"
            />
            <BtnComponent
              class="space"
              text="Continue"
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
            <b>Core Elements Complete</b>
          </div>
          Publishing alert

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
            <div v-else class="py-6">No activities found</div>
          </div>
        </div>

        <div class="non-eligible-activities mb-6 text-sm leading-relaxed">
          <div class="title mb-6 flex">
            <svg-vue
              icon="warning-fill"
              class="mr-1 mt-0.5 text-lg text-crimson-40"
            />
            <b>Core Elements not Complete</b>
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
            <div v-else class="py-6">No activities found</div>
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
              text="Continue Anyway"
              @click="validateActivities()"
            />
            <BtnComponent
              class="space"
              type="primary"
              text="Go Back"
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
              text="Cancel"
              @click="resetPublishStep()"
            />
            <BtnComponent
              class="space"
              :class="{
                'pointer-events-none': selectedActivities.length === 0,
              }"
              type="primary"
              :text="`Publish (${selectedActivities.length}) Activities`"
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
        <span class="font-bold">Cancellation Successful</span>
      </h3>
      <div class="fw-bold rounded-lg bg-spring-30 px-3 py-2 text-white">
        {{ messageOnCancellation }}
      </div>
      <div class="my-3 flex justify-between">
        <button
          class="rounded py-3 px-5 font-semibold uppercase text-n-40 hover:bg-bluecoral hover:text-white"
          @click="closeCancelledDetailsPopup"
        >
          Continue Selecting
        </button>
        <button
          class="rounded bg-bluecoral py-3 px-5 font-semibold uppercase text-white"
          @click="publishAfterCancel"
        >
          Publish
        </button>
      </div>
    </Modal>

    <Loader
      v-if="loader"
      :text="loaderText"
      :class="{ 'animate-loader': loader }"
    />

    <BulkPublishing
      v-if="
        showBulkpublish ||
        (pa.publishingActivities &&
          Object.keys(pa.publishingActivities).length > 0)
      "
      :published="published"
      @close="
        {
          showBulkpublish = false;
        }
      "
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
import BulkPublishing from './BulkPublishing.vue';

// Vuex Store
import { useStore } from 'Store/activities/index';
import BulkPublishingErrorPopup from 'Components/BulkPublishingErrorPopup.vue';

defineProps({
  type: { type: String, default: 'primary' },
});

/**
 *  Global State
 */
const store = useStore();

// toggle state for modal popup
let [publishAlertValue, publishAlertToggle] = useToggle();

// state for step of the flow
const bulkPublishStep = ref(1);
const bulkPublishStatus = reactive({});
const showBulkpublish = ref(false);
const startPublish = ref(false);

const published = ref(false);

// display/hide validator loader
const loader = ref(false);

// Dynamic text for loader
const loaderText = ref('Please Wait');

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
  axios.get(`/activities/checks-for-activity-bulk-publish`).then((res) => {
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
  });
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
  loaderText.value = 'Verifying Core Elements';
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
  console.log(
    showBulkpublish.value ||
      (pa.value.publishingActivities &&
        Object.keys(pa.value.publishingActivities).length > 0)
  );
  axios
    .get(
      `activities/bulk-publish-status?organization_id=${pa.value.publishingActivities.organization_id}&&uuid=${pa.value.publishingActivities.job_batch_uuid}`
    )
    .then((res) => {
      pa.value.publishingActivities.activities = res.data?.data?.activities;
      pa.value.publishingActivities.status = res?.data?.data?.status;
      pa.value.publishingActivities.message = res?.data?.data?.message;
      showBulkpublish.value = res.data.publishing;
    });
});
const validateActivities = () => {
  loader.value = true;
  loaderText.value = 'Validating Activity';
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
    organization_id?: any;
    job_batch_uuid?: any;
    activities?: any;
    status?: any;
    message?: string;
  };
}
const pa: Ref<paType> = useStorage('vue-use-local-storage', {
  publishingActivities: localStorage.getItem('publishingActivities') ?? {},
});

const startBulkPublish = () => {
  loader.value = true;
  loaderText.value = 'Starting to publish';
  pa.value.publishingActivities = {};

  axios
    .get(
      `activities/start-bulk-publish?activities=[${selectedActivities.value}]`
    )
    .then((res) => {
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
