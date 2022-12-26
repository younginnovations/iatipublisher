<!-- eslint-disable vue/no-v-html -->
<template>
  <BtnComponent
    v-if="btnText"
    :text="btnText"
    :type="type"
    icon="approved-cloud"
    @click="checkPublish"
  />
  <Modal
    :modal-active="publishValue"
    width="583"
    @close="publishToggle"
    @reset="resetPublishStep"
  >
    <div class="popup mb-4">
      <div class="title mb-6 flex items-center text-sm">
        <svg-vue
          class="mr-1 text-lg"
          :class="{
            'text-spring-50': publishStateChange.alertState,
            'text-crimson-40': !publishStateChange.alertState,
          }"
          :icon="publishStateChange.icon"
        />
        <b>{{ publishStateChange.title }}</b>
      </div>
      <div
        class="rounded-lg bg-mint p-4"
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
            class="bg-white px-6 uppercase"
            :text="language.button_lang.go_back"
            type=""
            @click="publishValue = false"
          />
          <BtnComponent
            v-if="publishStep == 0"
            class="space"
            :text="language.button_lang.continue"
            type="primary"
            @click="stepPlusOne"
          />
        </template>
        <template v-else>
          <BtnComponent
            v-if="publishStep == 0"
            class="bg-white px-6 uppercase"
            :text="language.button_lang.continue_anyway"
            type=""
            @click="stepPlusOne"
          />
          <BtnComponent
            v-if="publishStep == 0"
            class="space"
            :text="
              language.button_lang.add_element.replace(
                ':element',
                language.common_lang.missing.data
              )
            "
            type="primary"
            @click="publishValue = false"
          />
        </template>

        <BtnComponent
          v-if="publishStep === 1 || publishStep === 2"
          class="bg-white px-6 uppercase"
          :text="language.button_lang.go_back"
          type=""
          @click="stepMinusOne"
        />

        <!-- api validator button (validatorFunction) -->
        <BtnComponent
          v-if="publishStep === 1"
          class="space"
          :text="language.button_lang.continue"
          type="primary"
          @click="validatorFunction"
        />

        <!-- api publishing button (publishFunction) -->
        <BtnComponent
          v-if="publishStep === 2"
          class="space"
          :text="language.button_lang.publish"
          type="primary"
          @click="publishFunction"
        />

        <!-- api publishing button (publishFunction) -->
        <BtnComponent
          v-if="publishStep === 3 || publishStep === 4"
          class="bg-white px-6 uppercase"
          :text="language.button_lang.publish_anyway"
          type=""
          @click="publishFunction"
        />

        <BtnComponent
          v-if="publishStep === 3 || publishStep === 4"
          class="space"
          :text="language.button_lang.fix_issues"
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
import {
  defineProps,
  reactive,
  ref,
  onUpdated,
  toRefs,
  computed,
  inject,
} from 'vue';
import { useToggle } from '@vueuse/core';
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from 'Components/PopupModal.vue';
import Loader from 'Components/sections/ProgressLoader.vue';

// Vuex Store
import { detailStore } from 'Store/activities/show';

const language = window['globalLang'];
const props = defineProps({
  type: { type: String, default: 'primary' },
  linkedToIati: { type: Boolean, required: true },
  status: { type: String, required: true },
  coreCompleted: { type: Boolean, required: true },
  activityId: { type: Number, required: true },
});

const { linkedToIati, status, coreCompleted, activityId } = toRefs(props);

onUpdated(() => {
  if (loader.value) {
    store.dispatch('updateIsLoading', true);
  } else {
    store.dispatch('updateIsLoading', false);
  }
  if (loader.value) {
    publishValue.value = false;
  }
  if (publishValue.value) {
    loader.value = false;
  }
  if (publishStep.value === 1) {
    publishValue.value = false;
    setTimeout(function () {
      loader.value = true;
    }, 500);
  }
  if (
    publishStep.value === 3 ||
    publishStep.value === 2 ||
    publishStep.value === 4
  ) {
    loader.value = false;
    publishValue.value = true;
  }
});

/**
 *  Global State
 */
const store = detailStore();

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
const loaderText = ref(language.common_lang.please_wait);

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
    title = language.common_lang.core_completed_title;
    description = language.common_lang.core_completed_description;
  } else {
    title = language.common_lang.core_not_completed_title;
    description = language.common_lang.core_not_completed_description;
    icon = 'warning-fill';
  }

  //creating a shorter variable so that building error description for case 3 and 4 becomes easire
  let s = language.common_lang.sticky.common;

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
      publishState.title = language.common_lang.sticky.title_1;
      publishState.description = language.common_lang.sticky.description_1;
      publishState.icon = `shield`;
      publishState.alertState = false;
      break;
    // case 2 is for success validation
    case 2:
      publishState.title = language.common_lang.sticky.title_2;
      publishState.description = language.common_lang.sticky.description_2;
      publishState.icon = `tick`;
      publishState.alertState = true;
      break;
    //case 3 is for validation with critical errors
    case 3:
      publishState.title = language.common_lang.sticky.title_3;
      publishState.description = `<p><b>${err.criticalNumber} ${s.critical} ${s.errors}</b>, <b>${err.errorNumber} ${s.errors}</b> ${s.and} <b>${err.warningNumber} ${s.warnings}</b> ${s.warnings}. ${s.critical}</p><p>${s.has_atleast_one_critical_error}</p><p>${s.we_highly_recommend}</p>`;
      publishState.icon = `warning-fill`;
      publishState.alertState = false;
      break;
    // case 4 is for validation without critical errors
    case 4:
      publishState.title = language.common_lang.sticky.title_3;
      publishState.description = `<p><b>${err.errorNumber}  ${s.errors}</b>  ${s.and} <b>${err.warningNumber}  ${s.warnings}</b>  ${s.were_found}.  ${s.view_information}</p><p>${s.we_highly_recommend}</p>`;
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
  publishValue.value = false;

  if (!publishValue.value) {
    setTimeout(function () {
      loader.value = true;
    }, 500);
  }

  loaderText.value = `${language.common_lang.validating} ${language.common_lang.activity}`;

  axios.post(`/activity/${id}/validateActivity`).then((res) => {
    const response = res.data;
    const errors = response.errors;

    if (response.success === false) {
      location.reload();
    }

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
interface DataTypeface {
  message: string;
  type: boolean;
  visibility: boolean;
}

const errorData = inject('errorData') as DataTypeface;

/**
 * check publish status
 */
const checkPublish = () => {
  axios.get(`/activities/checks-for-activity-publish`).then((res) => {
    const response = res.data;

    if (response.success === true) {
      publishValue.value = true;
    } else {
      errorData.message = response.message;
      errorData.type = response.success;
      errorData.visibility = true;
    }
  });
};

const publishFunction = () => {
  publishValue.value = false;

  setTimeout(function () {
    loader.value = true;
  }, 500);

  loaderText.value = `${language.common_lang.publishing} ${language.common_lang.activity}`;
  resetPublishStep();
  publishStep.value = 0;

  axios.post(`/activity/${id}/publish`).then((res) => {
    const response = res.data;
    store.dispatch('updateUnPublished', response.success);
    store.dispatch('updateShowPublished', !response.success);
    setTimeout(() => {
      location.reload();
    }, 1000);
  });
};

// publish-republish

const publishStatus = reactive({
  linked_to_iati: linkedToIati.value,
  status: status.value,
});

const btnText = computed(() => {
  if (publishStatus.linked_to_iati && publishStatus.status === 'draft') {
    return language.button_lang.republish;
  } else if (
    !publishStatus.linked_to_iati &&
    publishStatus.status === 'draft'
  ) {
    return language.button_lang.publish;
  } else {
    return '';
  }
});
</script>
