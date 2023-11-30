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
      :modal-active="showExistingProcessModal"
      width="583"
      @close="showExistingProcessModal = false"
    >
      <div class="popup mb-4">
        <div class="title mb-6 flex items-center text-sm">
          <svg-vue class="mr-1 text-lg text-spring-50" icon="warning" />
          <b>Another Activity is currently being published</b>
        </div>
        <div class="rounded-lg bg-[#FFF1F0] p-4">
          <div class="text-sm leading-normal">
            Please wait for previous bulk publish to complete or cancel previous
            bulk publish to continue this bulk publish.
          </div>
        </div>
      </div>
      <div class="flex justify-between space-x-2">
        <BtnComponent
          class="bg-white px-6 uppercase"
          text="Cancel Previous Bulk publish"
          type=""
          @click="startValidation"
        />
        <BtnComponent
          class="bg-white px-6 uppercase"
          text="Wait for completion"
          type="primary"
          @click="showExistingProcessModal = false"
        />
      </div>
    </Modal>

    <Modal
      :modal-active="publishAlertValue && !showExistingProcessModal"
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
              @click="
                () => {
                  bulkPublishStep = 3;
                }
              "
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
        <div class="title mb-6 flex items-center text-sm">
          <svg-vue class="mr-1 text-lg text-crimson-40" icon="shield" />
          <b>Activity will be validated before publishing</b>
        </div>
        <div class="mb-8 bg-rose p-4 text-sm">
          This activity will be validated before being published to the IATI
          Registry.
        </div>
        <div class="flex justify-end">
          <div class="inline-flex">
            <BtnComponent
              class="bg-white px-6 uppercase"
              type=""
              text="Go back"
              @click="resetPublishStep()"
            />
            <BtnComponent
              class="space"
              type="primary"
              text="Continue"
              @click="validateActivities()"
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
const isLoading = ref(false);
const startPublish = ref(false);
const showExistingProcessModal = ref(false);

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
  loaderText.value = 'Verifying Core Elements';
  const activities = store.state.selectedActivities.join(',');

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

const stopValidating = async () => {
  await axios.get(`activities/delete-validation-status`).then(() => {
    store.dispatch('updateStartValidation', false);
    store.dispatch('updateValidatingActivities', '');
    localStorage.removeItem('validatingActivities');
    localStorage.removeItem('activityValidating');
  });
};

const startValidation = async () => {
  await stopValidating();
  await cancelBulkPublish();
  const activities = store.state.selectedActivities.join(',');
  showExistingProcessModal.value = false;
  axios
    .post(`/activities/validate-activities?activities=[${activities}]`)
    .then((res) => {
      const response = res.data;
      store.dispatch('updateValidatingActivitiesNames', response.activities);

      localStorage.setItem(
        'validatingActivitiesNames',
        response.activities.join('|')
      );

      if (response.success) {
        validationErrors.value = response.data;
      } else {
        resetPublishStep();
        displayToast(response.message, response.success);
      }
    })
    .finally(() => {
      store.dispatch('updateStartValidation', true);
      store.dispatch('updateValidatingActivities', activities);
      localStorage.setItem('validatingActivities', activities);
      store.dispatch('updateStartBulkPublish', false);
    });
};

const validateActivities = async () => {
  resetPublishStep();
  let validatorSuccess = false;
  let publishingSuccess = false;

  await axios.get(`activities/checks-for-activity-bulk-publish`).then((res) => {
    const response = res.data;
    publishingSuccess = response.success;
  });

  await axios
    .get(`activities/checks-for-activity-bulk-validation`)
    .then((res) => {
      const response = res.data;
      validatorSuccess = response.success;
    });

  if (!validatorSuccess || !publishingSuccess) {
    showExistingProcessModal.value = true;
  } else {
    startValidation();
  }
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
  loaderText.value = 'Starting to publish';
  pa.value.publishingActivities = {};

  axios
    .get(
      `activities/start-bulk-publish?activities=[${store.state.validatingActivities}]`
    )
    .then((res) => {
      store.dispatch('updateStartBulkPublish', true);
      store.dispatch('updateValidatingActivities', '');

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

watch(
  () => bulkPublishStep.value,
  () => {
    if (bulkPublishStep.value === 2 || bulkPublishStep.value === 3) {
      const checkSupportButton = setInterval(() => {
        const supportButton: HTMLElement = document.querySelector(
          '#launcher'
        ) as HTMLElement;

        if (supportButton !== null) {
          supportButton.classList.add('!hidden');

          clearInterval(checkSupportButton);
        }
      }, 10);
    } else {
      const checkSupportButton = setInterval(() => {
        const supportButton: HTMLElement = document.querySelector(
          '#launcher'
        ) as HTMLElement;

        if (supportButton !== null) {
          supportButton.classList.remove('!hidden');

          clearInterval(checkSupportButton);
        }
      }, 10);
    }
  }
);

watch(
  () => store.state.startBulkPublish,
  (value) => {
    if (value) {
      startBulkPublish();
    }
  },
  { deep: true }
);
const cancelBulkPublish = async () => {
  await axios.get('activities/cancel-bulk-publish');
};

/*Cancels on-going bulk publish*/
const cancelOtherBulkPublish = () => {
  loaderText.value = 'Cancelling Bulk Publish';
  loader.value = true;
  closeCancelConfirmationModal();
  store.dispatch('updateStartBulkPublish', false);

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
