<!-- eslint-disable vue/no-v-html -->
<template>
  <BtnComponent
    class=""
    text="Publish"
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
    <div class="mb-4">
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
        <div v-html="publishStateChange.description"></div>
      </div>
    </div>
    <div class="flex justify-end">
      <div class="inline-flex">
        <BtnComponent
          v-if="publishStep == 0 || publishStep == 1 || publishStep == 2"
          class="px-6 uppercase bg-white"
          text="Go Back"
          type=""
          @click="stepMinusOne"
        />
        <BtnComponent
          v-else
          class="px-6 uppercase bg-white"
          text="Publish Anyway"
          type=""
          @click="publishFunction"
        />
        <BtnComponent
          v-if="publishStep == 0"
          class="space"
          text="Continue"
          type="primary"
          @click="stepPlusOne"
        />
        <BtnComponent
          v-else-if="publishStep == 1"
          class="space"
          text="Continue"
          type="primary"
          @click="validatorFunction"
        />
        <BtnComponent
          v-else-if="publishStep == 2"
          class="space"
          text="Publish"
          type="primary"
          @click="publishFunction"
        />
        <BtnComponent
          v-else
          class="space"
          text="Fix Issues"
          type="primary"
          @click="publishValue = false"
        />
      </div>
    </div>
  </Modal>
</template>

<script setup lang="ts">
import { defineProps, reactive, ref, computed } from 'vue';
import { useToggle } from '@vueuse/core';
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from 'Components/PopupModal.vue';

const props = defineProps({
  data: { type: Object, required: true },
});

const publishStep = ref(0);

const resetPublishStep = () => {
  publishStep.value = 0;
};

// computed function to change content
const publishStateChange = computed(() => {
  const publishState = reactive({
    title: '',
    description: '',
    icon: '',
    alertState: true,
  });

  switch (publishStep.value) {
    // first step
    case 0:
      publishState.title = `Core Elements Complete`;
      publishState.description = `Congratulations! You’ve provided data for all core elements. Click continue to run checks on (validate) this activity.`;
      publishState.icon = `tick`;
      break;
    //second step
    case 1:
      publishState.title = `Activity will be validated before publishing`;
      publishState.description = `This activity will be first validated before publishing the activity to the IATI Registry. `;
      publishState.alertState = false;
      publishState.icon = `shield`;
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
      publishState.description = `<p><b>4 errors</b> and <b>2 warnings</b> were found. View information about these errors/warnings at the top of the activity page.</p><p>As your data has at least one critical error, it will not be available on the IATI Datastore and may not be available on other data portals/tools/software that use IATI data.</p><p>We highly recommend you fix these issue(s) before publishing your activity to improve the quality and usefulness of your data.</p>`;
      publishState.icon = `warning-fill`;
      publishState.alertState = true;
      break;
    // case 4 is for validation without critical errors
    case 4:
      publishState.title = `IATI Validation Issue`;
      publishState.description = `<p><b>4 errors</b> and <b>2 warnings</b> were found. View information about these errors/warnings at the top of the activity page.</p><p>We highly recommend you fix these issue(s) before publishing your activity to improve the quality and usefulness of your data.</p>`;
      publishState.icon = `warning-fill`;
      publishState.alertState = true;
      break;
  }

  return publishState;
});

// increment and decrement function
const stepPlusOne = () => {
  if (publishStep.value >= 0 && publishStep.value < 2) {
    publishStep.value++;
  }
};
const stepMinusOne = () => {
  if (publishStep.value > 0 && publishStep.value <= 2) {
    publishStep.value--;
  }
};

// call api for validation
const validatorFunction = () => {
  console.log('calling api for validation');
  axios.get(`/activities/${props.data.id}/validate`).then((res) => {
    console.log(res.data);
  });
};

// call api for validation
const publishFunction = () => {
  console.log('calling api for publishing');
  axios.get(`/activities/${props.data.id}/validate`).then((res) => {
    // const response = res.data;
    console.log(res.data);
  });
};

const [publishValue, publishToggle] = useToggle();
</script>
