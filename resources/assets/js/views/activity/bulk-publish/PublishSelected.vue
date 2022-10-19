<!-- eslint-disable vue/no-v-html -->
<template>
  <div>
    <BtnComponent
      v-if="store.state.selectedActivities.length > 0"
      type="secondary"
      text="Publish Selected"
      icon="approved-cloud"
      @click="publishAlertValue = true"
    />
    <Modal
      :modal-active="publishAlertValue"
      :width="popUpWidthChange"
      @close="publishAlertToggle"
      @reset="resetPublishStep"
    >
      <template v-if="bulkPublishStep === 1">
        <div class="mb-4 popup">
          <div class="flex items-center mb-6 text-sm title">
            <svg-vue class="mr-1 text-lg text-crimson-40" icon="shield" />
            <b>Publishing alert</b>
          </div>
          <div class="p-4 rounded-lg bg-eggshell">
            <div class="text-sm leading-normal">
              Activities that are already published will not be published.
              Changes made to published activities (Draft) will be republished.
            </div>
          </div>
        </div>
        <div class="flex justify-end">
          <div class="inline-flex">
            <BtnComponent
              class="px-6 uppercase bg-white"
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
        <div class="mb-6 text-sm leading-relaxed eligible-activities">
          <div class="flex mb-6 title">
            <svg-vue icon="tick" class="mr-1 mt-0.5 text-lg text-spring-50" />
            <b>Core Elements Complete</b>
          </div>

          <div class="px-6 rounded-lg bg-mint">
            <div
              v-if="coreCompletedActivities.length > 0"
              class="coreCompleted"
            >
              <div
                v-for="(act, i) in coreCompletedActivities"
                :key="i"
                class="py-6 item"
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

        <div class="mb-6 text-sm leading-relaxed non-eligible-activities">
          <div class="flex mb-6 title">
            <svg-vue
              icon="warning-fill"
              class="mr-1 mt-0.5 text-lg text-crimson-40"
            />
            <b>Core Elements not Complete</b>
          </div>

          <div class="px-6 rounded-lg bg-rose">
            <div
              v-if="coreInCompletedActivities.length > 0"
              class="notCompleted"
            >
              <div
                v-for="(act, i) in coreInCompletedActivities"
                :key="i"
                class="py-6 item"
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
              class="px-6 uppercase bg-white"
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
              class="px-6 uppercase bg-white"
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

    <Loader
      v-if="loader"
      :text="loaderText"
      :class="{ 'animate-loader': loader }"
    />
    <BulkPublishing v-if="Object.keys(pa.publishingActivities).length > 0" />
  </div>
</template>

<script setup lang="ts">
import { defineProps, ref, Ref, computed, provide, inject } from 'vue';
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

// display/hide validator loader
const loader = ref(false);

// Dynamic text for loader
const loaderText = ref('Please Wait');

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
interface ToastMessageTypeface {
  message: string;
  type: boolean;
  visibility: boolean;
}
const toastData = inject('toastData') as ToastMessageTypeface;
const displayToast = (message, type) => {
  toastData.message = message;
  toastData.type = type;
  toastData.visibility = true;

  setTimeout(() => {
    toastData.visibility = false;
  }, 10000);
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
        displayToast(response.message, response.success);
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
const pa = useStorage('vue-use-local-storage', {
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
      const response = res.data;
      if (response.success) {
        bulkPublishStep.value = 1;
        publishAlertValue.value = false;
        pa.value.publishingActivities = response.data;
      }

      setTimeout(() => {
        loader.value = false;
      }, 1000);
    });
};

provide('paStorage', pa);
</script>
