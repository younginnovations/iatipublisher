<!-- eslint-disable vue/no-v-html -->
<template>
  <BtnComponent
    v-if="btnText"
    :text="btnText"
    :type="type"
    icon="approved-cloud"
    @click="publishValue = true"
  />
  <Modal
    :modal-active="publishValue"
    width="583"
    @close="publishToggle"
    @reset="resetPublishStep"
  >
    <div class="mb-4 popup">
      <div class="flex mb-6 title">
        <svg-vue
          class="mr-1 mt-0.5 text-lg"
          :class="{
            'text-spring-50': publishStateChange.alertState,
            'text-crimson-40': !publishStateChange.alertState,
          }"
          :icon="publishStateChange.icon"
        />
        <b>{{ publishStateChange.title }}</b>
      </div>
      <div
        class="p-4 rounded-lg bg-mint"
        :class="{
          'bg-mint': publishStateChange.alertState,
          'bg-[#FFF1F0]': !publishStateChange.alertState,
        }"
      >
        <div
          class="text-sm leading-normal"
          v-html="publishStateChange.description"
        ></div>
      </div>
    </div>
    <div class="flex justify-end">
      <div class="inline-flex">
        <template v-if="coreElementStatus">
          <BtnComponent
            v-if="publishStep == 0"
            class="px-6 uppercase bg-white"
            text="Go Back"
            type=""
            @click="publishValue = false"
          />
          <BtnComponent
            v-if="publishStep == 0"
            class="space"
            text="Continue"
            type="primary"
            @click="stepPlusOne"
          />
        </template>
        <template v-else>
          <BtnComponent
            v-if="publishStep == 0"
            class="px-6 uppercase bg-white"
            text="Continue Anyway"
            type=""
            @click="stepPlusOne"
          />
          <BtnComponent
            v-if="publishStep == 0"
            class="space"
            text="Add Missing Data"
            type="primary"
            @click="publishValue = false"
          />
        </template>

        <BtnComponent
          v-if="publishStep === 1 || publishStep === 2"
          class="px-6 uppercase bg-white"
          text="Go Back"
          type=""
          @click="stepMinusOne"
        />

        <!-- api validator button (validatorFunction) -->
        <BtnComponent
          v-if="publishStep === 1"
          class="space"
          text="Continue"
          type="primary"
          @click="validatorFunction"
        />

        <!-- api publishing button (publishFunction) -->
        <BtnComponent
          v-if="publishStep === 2"
          class="space"
          text="Publish"
          type="primary"
          @click="publishFunction"
        />

        <!-- api publishing button (publishFunction) -->
        <BtnComponent
          v-if="publishStep === 3 || publishStep === 4"
          class="px-6 uppercase bg-white"
          text="Publish Anyway"
          type=""
          @click="publishFunction"
        />

        <BtnComponent
          v-if="publishStep === 3 || publishStep === 4"
          class="space"
          text="Fix issues"
          type="primary"
          @click="resetPublishStep"
        />
      </div>
    </div>
  </Modal>
  <Loader
    v-if="loader"
    :text="loaderText"
    :class="{ 'animate-loader': loader }"
  />
</template>

<script setup lang="ts">
import { defineProps, reactive, ref, toRefs, computed, inject } from 'vue';
import { useToggle } from '@vueuse/core';
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from 'Components/PopupModal.vue';
import Loader from 'Components/sections/ProgressLoader.vue';

// Vuex Store
import { useStore } from 'Store/activities/show';

const props = defineProps({
  type: { type: String, default: 'primary' },
  alreadyPublished: { type: Boolean, required: true },
  linkedToIati: { type: Boolean, required: true },
  status: { type: String, required: true },
  coreCompleted: { type: Boolean, required: true },
  activityId: { type: Number, required: true },
});

const { alreadyPublished, linkedToIati, status, coreCompleted, activityId } =
  toRefs(props);

/**
 *  Global State
 */
const store = useStore();

//activity id
const id = activityId.value;

// toggle state for modal popup
let [publishValue, publishToggle] = useToggle();

// state for step of the flow
const publishStep = ref(0);

// display/hide validator loader
const loader = ref(false);

// state for first step
// determine if core element completed or not
// true for completed and false for not completed

const coreElementStatus = coreCompleted.value;

// Dynamic text for loader
const loaderText = ref('Please Wait');

// reset step to zero after closing modal
const resetPublishStep = () => {
  publishStep.value = 0;
  publishValue.value = false;
};

// computed function to change content of modal
const publishStateChange = computed(() => {
  const publishState = reactive({
    title: '',
    description: '',
    icon: '',
    alertState: true,
  });

  let title = '',
    description = '',
    icon = 'tick';

  // different content for step 1 based on coreElement status
  if (coreElementStatus) {
    title = 'Core Elements Complete';
    description =
      'Congratulations! All the core elements are complete. Continue to Validate this activity.';
  } else {
    title = 'Core Elements not complete';
    description =
      '<p>There is missing data in some of the core elements. We highly recommend that you complete these data fields to help ensure your data is useful.</p><p>Do you want to continue anyway and run checks on (validate) this data.</p>';
    icon = 'warning-fill';
  }

  switch (publishStep.value) {
    // first step
    case 0:
      publishState.title = title;
      publishState.description = description;
      publishState.icon = icon;
      publishState.alertState = coreElementStatus;
      break;
    //second step
    case 1:
      publishState.title = `Activity will be validated before publishing`;
      publishState.description = `This activity will be first validated before publishing the activity to the IATI Registry. `;
      publishState.icon = `shield`;
      publishState.alertState = false;
      break;
    // case 2 is for success validation
    case 2:
      publishState.title = `IATI Validation`;
      publishState.description = `<p>Congratulations! No errors were found. Publish your data now.</p><p>This data will be available on the IATI Datastore and other data portals/tools/software that use IATI data.</p>`;
      publishState.icon = `tick`;
      publishState.alertState = true;
      break;
    //case 3 is for validation with critical errors
    case 3:
      publishState.title = `IATI Validation Issue`;
      publishState.description = `<p><b>${err.criticalNumber} critical errors</b>, <b>${err.errorNumber} errors</b> and <b>${err.warningNumber} warnings</b> were found. View information about these errors/warnings at the top of the activity page.</p><p>As your data has at least one critical error, it will not be available on the IATI Datastore and may not be available on other data portals/tools/software that use IATI data.</p><p>We highly recommend you fix these issue(s) before publishing your activity to improve the quality and usefulness of your data.</p>`;
      publishState.icon = `warning-fill`;
      publishState.alertState = false;
      break;
    // case 4 is for validation without critical errors
    case 4:
      publishState.title = `IATI Validation Issue`;
      publishState.description = `<p><b>${err.errorNumber} errors</b> and <b>${err.warningNumber} warnings</b> were found. View information about these errors/warnings at the top of the activity page.</p><p>We highly recommend you fix these issue(s) before publishing your activity to improve the quality and usefulness of your data.</p>`;
      publishState.icon = `warning-fill`;
      publishState.alertState = false;
      break;
  }

  return publishState;
});

// increment and decrement function
const stepPlusOne = () => {
  if (publishStep.value >= 0 && publishStep.value < 4) {
    publishStep.value++;
  }
};
const stepMinusOne = () => {
  if (publishStep.value > 0 && publishStep.value <= 4) {
    publishStep.value--;
  }
};

// reactive variable for errors number
interface Err {
  criticalNumber: number;
  errorNumber: number;
  warningNumber: number;
}
let err: Err = reactive({
  criticalNumber: 0,
  errorNumber: 0,
  warningNumber: 0,
});

// call api for validation

const validatorFunction = () => {
  loader.value = true;
  loaderText.value = 'Validating Activities';

  axios.post(`/activity/${id}/validateActivity`).then((res) => {
    const response = res.data;
    const errors = response.errors;

    if (errors.length > 0) {
      store.dispatch('updatePublishErrors', errors);

      //identify error types
      const crit = response.summary.critical;
      (err.criticalNumber = crit),
        (err.errorNumber = response.summary.error),
        (err.warningNumber = response.summary.warning);

      if (crit > 0) {
        publishStep.value = 3;
      } else {
        publishStep.value = 4;
      }
    } else {
      publishStep.value = 2;
    }
    setTimeout(() => {
      loader.value = false;
    }, 2000);
  });
};

// call api for publishing
interface ToastMessageTypeface {
  message: string;
  type: boolean;
}

const toastMessage = inject('toastMessage') as ToastMessageTypeface;

const publishFunction = () => {
  loader.value = true;
  loaderText.value = 'Publishing';
  resetPublishStep();

  axios.post(`/activity/${id}/publish`).then((res) => {
    const response = res.data;
    toastMessage.message = response.message;
    toastMessage.type = response.success;
    setTimeout(() => {
      store.dispatch('updateUnPublished', response.success);
      store.dispatch('updateShowPublished', !response.success);
      location.reload();
    }, 1000);
  });
};

// publish-republish

const publishStatus = reactive({
  already_published: alreadyPublished.value,
  linked_to_iati: linkedToIati.value,
  status: status.value,
});

const btnText = computed(() => {
  if (publishStatus.linked_to_iati && publishStatus.status === 'draft') {
    return 'Republish';
  } else if (
    !publishStatus.linked_to_iati &&
    publishStatus.status === 'draft'
  ) {
    return 'Publish';
  } else {
    return '';
  }
});
</script>
