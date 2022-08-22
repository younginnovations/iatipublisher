<!-- eslint-disable vue/no-v-html -->
<template>
  <BtnComponent
    class=""
    :text="btnText"
    type="primary"
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
        <template v-if="mandatoryElementStatus">
          <BtnComponent
            v-if="publishStep == 0"
            class="px-6 uppercase bg-white"
            text="Go Back"
            type=""
            @click="stepMinusOne"
          />
          <BtnComponent
            v-if="publishStep == 0"
            class="space"
            text="Continue"
            type="primary"
            @click="publishFunction"
          />
        </template>
        <template v-else>
          <BtnComponent
            v-if="publishStep == 0"
            class="px-6 uppercase bg-white"
            text="Continue"
            type=""
            @click="publishFunction"
          />
        </template>
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
import { reactive, ref, computed, inject } from 'vue';
import { useToggle } from '@vueuse/core';
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from 'Components/PopupModal.vue';
import Loader from 'Components/sections/ProgressLoader.vue';
import ToastMessageVue from 'Components/ToastMessage.vue';


// toggle state for modal popup
let [publishValue, publishToggle] = useToggle();

// state for step of the flow
const publishStep = ref(0);

// display/hide validator loader
const loader = ref(false);

// state for first step
// determine if core element completed or not
// true for completed and false for not completed

const mandatoryElementStatus = inject('mandatoryCompleted') as boolean;

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
  if (mandatoryElementStatus) {
    title = 'Mandatory Elements Complete';
    description =
      'Congratulations! All the mandatory elements are complete. Continue to Validate this activity.';
  } else {
    title = 'Mandatory Elements not complete';
    description =
      '<p>There is missing data in some of the mandatory elements. We highly recommend that you complete these data fields to help ensure your data is useful.</p>';
    icon = 'warning-fill';
  }

  switch (publishStep.value) {
    // first step
    case 0:
      publishState.title = title;
      publishState.description = description;
      publishState.icon = icon;
      publishState.alertState = mandatoryElementStatus;
      break;
    //second step
    // case 1:
    //   publishState.title = ` will be validated before publishing`;
    //   publishState.description = `This activity will be first validated before publishing the activity to the IATI Registry. `;
    //   publishState.icon = `shield`;
    //   publishState.alertState = false;
    //   break;
    // // case 2 is for success validation
    // case 2:
    //   publishState.title = `IATI Validation`;
    //   publishState.description = `<p>Congratulations! No errors were found. Publish your data now.</p><p>This data will be available on the IATI Datastore and other data portals/tools/software that use IATI data.</p>`;
    //   publishState.icon = `tick`;
    //   publishState.alertState = true;
    //   break;
    // //case 3 is for validation with critical errors
    // case 3:
    //   publishState.title = `IATI Validation Issue`;
    //   publishState.description = `<p><b></b>critical errors</b>, <b>errors</b> and <b>warnings</b> were found. View information about these errors/warnings at the top of the activity page.</p><p>As your data has at least one critical error, it will not be available on the IATI Datastore and may not be available on other data portals/tools/software that use IATI data.</p><p>We highly recommend you fix these issue(s) before publishing your activity to improve the quality and usefulness of your data.</p>`;
    //   publishState.icon = `warning-fill`;
    //   publishState.alertState = false;
    //   break;
  }

  return publishState;
});

// increment and decrement function
const stepPlusOne = () => {
  if (publishStep.value >= 0 && publishStep.value < 1) {
    publishStep.value++;
  }
};
const stepMinusOne = () => {
  if (publishStep.value > 0 && publishStep.value <= 1) {
    publishStep.value--;
  }
};

// reactive variable for errors number
// interface Err {
//   criticalNumber: number;
//   errorNumber: number;
//   warningNumber: number;
// }
// let err: Err = reactive({
//   criticalNumber: 0,
//   errorNumber: 0,
//   warningNumber: 0,
// });


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

  axios.post(`/organisation/publish`).then((res) => {
    const response = res.data;
    console.log(res.data);
    loader.value=false;
    toastMessage.message = response.success ? response.success : response.error;
    toastMessage.type = response.success;
    setTimeout(() => {
      loader.value = false;
    }, 2000);

  });
};

interface PublishStatusTypeface {
  already_published: boolean;
  linked_to_iati: boolean;
  status: string;
}

// publish-republish
const publishStatus = inject('publishStatus') as PublishStatusTypeface;

const btnText = computed(() => {
  if (publishStatus.linked_to_iati && publishStatus.status === 'draft') {
    return 'Republish';
  } else {
    return 'Publish';
  }
});
</script>
