<!-- eslint-disable vue/no-v-html -->
<template>
  <div>
    <Modal :modal-active="showExistingProcessModal" width="583">
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
          @click="startNewPublishing"
        />
        <BtnComponent
          class="bg-white px-6 uppercase"
          text="Wait for completion"
          type="primary"
          @click="showExistingProcessModal = false"
        />
      </div>
    </Modal>
    <template v-if="!store.state.isPublishedModalMinimized">
      <template v-if="!showExistingProcessModal">
        <template v-if="!showCancelConfirmationPopup">
          <Modal
            :modal-active="
              (store.state.publishAlertValue && !showExistingProcessModal) ||
              showValidationPopup ||
              (store.state.showBulkpublish &&
                pa?.publishingActivities &&
                Object.keys(pa?.publishingActivities).length > 0)
            "
            :is-minimized="store.state.isPublishedModalMinimized"
            :width="popUpWidthChange"
          >
            <template v-if="store.state.bulkPublishStep === 1">
              <div class="popup mb-4">
                <div class="title mb-6 flex items-center text-sm">
                  <svg-vue class="mr-1 text-lg text-crimson-40" icon="shield" />
                  <b>Publishing alert</b>
                </div>
                <div class="rounded-lg bg-eggshell p-4">
                  <div class="text-sm leading-normal">
                    Activities that are already published will not be published.
                    Changes made to published activities (Draft) will be
                    republished.
                  </div>
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="space"
                    text="Continue"
                    type="primary"
                    @click="
                      () => {
                        store.state.bulkPublishStep = 2;
                        verifyCoreElements();
                      }
                    "
                  />
                </div>
              </div>
            </template>
            <template v-else-if="store.state.bulkPublishStep === 2">
              <BulkPublishingModal
                :deprecation-status-map="deprecationStatusMap"
                :core-in-completed-activities="coreInCompletedActivities"
                :core-completed-activities="coreCompletedActivities"
                :core-element-loader="coreElementLoader"
                :selected-activities="store.state.selectedActivities"
                :show-validation-popup="showValidationPopup"
                :publishing-activities="pa?.publishingActivities"
                :permalink="permalink"
                @cancelValidation="() => cancelValidation()"
                @cancelBulkPublishing="() => cancelBulkPublishing()"
                @validate-activities="() => validateActivities()"
              />
            </template>
          </Modal>
        </template>
      </template>
    </template>

    <Modal :modal-active="showCancelConfirmationPopup" width="583">
      <div>
        <BulkPublishingErrorPopup />

        <div class="mt-4 flex justify-between space-x-4">
          <button
            class="rounded px-5 py-3 font-semibold uppercase text-n-40 hover:bg-bluecoral hover:text-white"
            @click="startNewPublishing"
          >
            Cancel previous bulk publish
          </button>

          <button
            class="rounded bg-bluecoral px-5 py-3 font-semibold uppercase text-white"
            @click="closeCancelConfirmationModal"
          >
            Wait for completion
          </button>
        </div>
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
/**
 * Verify core elements
 */
interface actTypeface {
  title: string;
  activity_id: number;
}

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
  defineExpose,
} from 'vue';

import { useStorage } from '@vueuse/core';
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from './components/Modal.vue';
import Loader from 'Components/sections/ProgressLoader.vue';
import PageLoader from 'Components/Loader.vue';
import BulkPublishingModal from './bulkPublishModal/BulkPublish.vue';
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

const bulkPublishStatus = reactive({});
const isLoading = ref(false);
const startPublish = ref(false);
const showExistingProcessModal = ref(false);

const published = ref(false);

// display/hide validator loader
const loader = ref(false);
const loaderText = ref('Please Wait');
const coreElementLoader = ref(false);

/*States for Bulk publish cancellation flow*/
const showCancelConfirmationPopup = ref(false);

// reset step to zero after closing modal
const cancelValidation = async () => {
  store.state.validationRunning = false;
  await axios.get(`/activities/delete-validation-status`).then(() => {
    store.dispatch('updateStartValidation', false);
    store.dispatch('updateValidatingActivities', '');
    localStorage.removeItem('validatingActivities');
    localStorage.removeItem('activityValidating');
    store.state.publishAlertValue = false;

    setTimeout(() => {
      store.state.bulkActivityPublishStatus = {
        ...store.state.bulkActivityPublishStatus,
        iatiValidatorLoader: false,
        validationStats: {
          ...store.state.bulkActivityPublishStatus.validationStats,
          complete: 0,
          total: 0,
          failed: 0,
        },
      };

      store.state.bulkPublishStep = 1;
      store.state.bulkActivityPublishStatus.completedSteps = [];
    }, 1000);
  });
};

const cancelBulkPublishing = async () => {
  store.state.bulkActivityPublishStatus.publishing = {
    ...store.state.bulkActivityPublishStatus.publishing,
    response: null,
    hasFailedActivities: {
      data: {} as any,
      ids: [],
      status: false,
    },
  };
  store.state.showBulkpublish = false;
  store.dispatch('updateBulkpublishActivities', {});
  store.dispatch('updateStartCoreValidation', false);
  cancelValidation();
  setTimeout(() => {
    store.state.bulkActivityPublishStatus.completedSteps = [];
    store.state.bulkPublishStep = 1;
    localStorage.setItem('vue-use-local-storage', 'publishingActivities:{}');
    pa.value.publishingActivities = {};
  }, 1000);
  await axios.delete(`/activities/delete-bulk-publish-status`);
};

const popUpWidthChange = computed(() => {
  let width = ref('825');
  switch (store.state.bulkPublishStep) {
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
const checkPublish = async () => {
  isLoading.value = true;
  let validatorSuccess = false;
  // store.state.bulkActivityPublishStatus.iatiValidatorLoader = false;

  await axios
    .get(`/activities/checks-for-activity-bulk-validation`)
    .then((res) => {
      const response = res.data;
      validatorSuccess = response.success;
    });

  if (!validatorSuccess) {
    showExistingProcessModal.value = true;
    isLoading.value = false;
    return;
  }

  await axios
    .get(`/activities/checks-for-activity-bulk-publish`)
    .then((res) => {
      const response = res.data;

      if (response.success === true) {
        cancelBulkPublish();
        resetStatus();
        store.state.publishAlertValue = true;
        localStorage.setItem('isPublishedModalMinimized', 'false');
        store.state.isPublishedModalMinimized = false;
        localStorage.setItem(
          'vue-use-local-storage',
          '{"publishingActivities":{}}'
        );
        pa.value.publishingActivities = {};
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

let coreCompletedActivities: Ref<actTypeface[]> = ref([]),
  coreInCompletedActivities: Ref<actTypeface[]> = ref([]),
  permalink = `/activity/`;
let deprecationStatusMap = ref();

const verifyCoreElements = () => {
  coreElementLoader.value = true;
  store.dispatch('updateCancelValidationAndPublishing', false);
  const activities = store.state.selectedActivities.join(',');
  axios
    .get(`/activities/core-elements-completed?activities=[${activities}]`)
    .then((res) => {
      const response = res.data;
      if (response.success) {
        if (
          response.data.deprecation_status_map.length == 0 &&
          response.data.core_elements_completion.incomplete.length == 0 &&
          response.data.core_elements_completion.complete.length !== 0
        ) {
          store.dispatch('updateStartValidation', true);
          coreElementLoader.value = false;
          validateActivities();
        }
        coreCompletedActivities.value =
          response.data.core_elements_completion.complete;
        coreInCompletedActivities.value =
          response.data.core_elements_completion.incomplete;

        deprecationStatusMap.value = response.data.deprecation_status_map;
      } else {
        coreElementLoader.value = false;
        cancelValidation();

        if (response?.in_progress) {
          emptybulkPublishStatus();
          Object.assign(bulkPublishStatus, response.data.activities);

          showCancelConfirmationModal();
        } else {
          displayToast(response.message, response.success);
        }
      }
      coreElementLoader.value = false;
    });
};

/**
 * Validating Activities
 */
let validationErrors = ref({});
onMounted(() => {
  axios
    .get(
      `/activities/bulk-publish-status?organization_id=${pa.value?.publishingActivities?.organization_id}&&uuid=${pa.value?.publishingActivities?.job_batch_uuid}`
    )
    .then((res) => {
      if (res.data.publishing) {
        if (pa.value?.publishingActivities && res.data?.data) {
          try {
            const data = res.data.data;
            Object.assign(pa.value.publishingActivities, data);

            if (Object.keys(data).length > 0) {
              store.state.bulkPublishStep = 2;
              if (data.status === 'completed') {
                store.state.bulkActivityPublishStatus.completedSteps = [1, 2];
              } else {
                store.state.bulkActivityPublishStatus.completedSteps = [1];
              }
            }
          } catch (error) {
            console.error('Error parsing data', error);
          }
        }
      }
    })
    .catch((error) => {
      console.error('Error fetching data', error);
    });
});

const stopValidating = async () => {
  await axios.get(`/activities/delete-validation-status`).then(() => {
    store.dispatch('updateStartValidation', false);
    store.dispatch('updateValidatingActivities', '');
    localStorage.removeItem('validatingActivities');
    localStorage.removeItem('activityValidating');
  });
};

const startValidation = async () => {
  try {
    const activities = store.state.selectedActivities.join(',');
    await stopValidating();
    store.dispatch('updateStartValidation', true);

    store.dispatch('updateValidatingActivities', activities);
    localStorage.setItem('validatingActivities', activities);
    store.dispatch('updateStartBulkPublish', false);
    await cancelBulkPublish();

    const res = await axios.post(
      `/activities/validate-activities?activities=[${activities}]`
    );
    const response = res.data;
    store.dispatch('updateValidatingActivitiesNames', response.activities);
    localStorage.setItem(
      'validatingActivitiesNames',
      response.activities.join('|')
    );
    if (response.success) {
      validationErrors.value = response.data;
    } else {
      displayToast(response.message, response.success);
    }
  } catch (error) {
    console.error('Validation error:', error);
  }
};

const validateActivities = async () => {
  store.state.bulkActivityPublishStatus.iatiValidatorLoader = true;
  let validatorSuccess = false;
  let publishingSuccess = false;

  await axios
    .get(`/activities/checks-for-activity-bulk-publish`)
    .then((res) => {
      const response = res.data;
      publishingSuccess = response.success;
    });

  await axios
    .get(`/activities/checks-for-activity-bulk-validation`)
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

// let selectedActivities: Ref<number[]> = ref([]);
provide('selectedActivities', store.state.selectedActivities);

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
  if (pa.value) {
    pa.value.publishingActivities = {};
  } else {
    console.error('pa.value is undefined');
  }
  axios
    .get(
      `/activities/start-bulk-publish?activities=[${store.state.validatingActivities}]`
    )
    .then((res) => {
      store.dispatch('updateStartBulkPublish', true);
      store.dispatch('updateValidatingActivities', '');
      startPublish.value = true;
      const response = res.data;
      if (response.success) {
        pa.value.publishingActivities = response.data;
      } else {
        loader.value = false;
        cancelValidation();
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
  () => store.state.bulkPublishStep,
  () => {
    if (store.state.bulkPublishStep === 2) {
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
      if (store.state.startBulkPublish) {
        startBulkPublish();
      }
    }
  },
  { deep: true }
);

const cancelBulkPublish = async () => {
  await axios.get('/activities/cancel-bulk-publish');
};

/*Opens modal that allows to cancel existing bulk publish*/
const showCancelConfirmationModal = () => {
  showCancelConfirmationPopup.value = true;
};

/*Closes modal that allows to cancel existing bulk publish*/
const closeCancelConfirmationModal = () => {
  showCancelConfirmationPopup.value = false;
};

const showValidationPopup = computed(() => {
  return store.state.startValidation || store.state.validationRunning;
});

const startNewPublishing = async () => {
  await cancelBulkPublish();
  cancelValidation();
  showExistingProcessModal.value = false;
  showCancelConfirmationPopup.value = false;
  store.state.bulkPublishStep = 1;
  checkPublish();
};

const resetStatus = () => {
  store.state.bulkPublishStep = 1;
  store.state.bulkActivityPublishStatus.completedSteps = [];
  store.state.bulkActivityPublishStatus = {
    ...store.state.bulkActivityPublishStatus,
    iatiValidatorLoader: false,
    validationStats: {
      ...store.state.bulkActivityPublishStatus.validationStats,
      complete: 0,
      total: 0,
      failed: 0,
    },
  };

  store.state.bulkActivityPublishStatus.publishing = {
    ...store.state.bulkActivityPublishStatus.publishing,
    response: null,
    hasFailedActivities: {
      data: {} as any,
      ids: [],
      status: false,
    },
  };
};

watch(
  () => showValidationPopup.value,
  (value) => {
    if (value) {
      store.state.bulkPublishStep = 2;
      store.state.bulkActivityPublishStatus.completedSteps = [];
    }
  }
);

watch(
  () => store.state.startCoreValidation,
  (value) => {
    if (value) {
      store.state.bulkPublishStep = 2;
      verifyCoreElements();
      store.state.publishAlertValue = true;
    }
  }
);

provide('paStorage', pa);
provide('bulkPublishStatus', bulkPublishStatus);
provide('startPublish', startPublish);
defineExpose({ checkPublish });
</script>
