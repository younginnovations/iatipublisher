<!-- eslint-disable vue/no-v-html -->
<template>
  <BtnComponent
    v-if="!publishStatus.is_published || publishStatus.status === 'draft'"
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
        <div class="text-sm leading-normal" v-html="publishStateChange.description"></div>
      </div>
    </div>
    <div class="flex justify-end">
      <div class="inline-flex">
        <BtnComponent
          v-if="!mandatoryElementStatus"
          class="px-6 uppercase bg-white"
          text="Add Missing Data"
          type=""
          @click="publishValue = false"
        />
        <BtnComponent
          class="space"
          text="Continue"
          type="primary"
          @click="publishFunction"
        />
      </div>
    </div>
  </Modal>
  <Loader v-if="loader" :text="loaderText" :class="{ 'animate-loader': loader }" />
</template>

<script setup lang="ts">
import { reactive, ref, computed, inject } from "vue";
import { useToggle } from "@vueuse/core";
import axios from "axios";

//component
import BtnComponent from "Components/ButtonComponent.vue";
import Modal from "Components/PopupModal.vue";
import Loader from "Components/sections/ProgressLoader.vue";
import ToastMessageVue from "Components/ToastMessage.vue";

// toggle state for modal popup
let [publishValue, publishToggle] = useToggle();

// state for step of the flow
const publishStep = ref(0);

// display/hide validator loader
const loader = ref(false);

// state for first step
// determine if core element completed or not
// true for completed and false for not completed

const mandatoryElementStatus = inject("mandatoryCompleted") as boolean;

// Dynamic text for loader
const loaderText = ref("Please Wait");

// reset step to zero after closing modal
const resetPublishStep = () => {
  publishStep.value = 0;
  publishValue.value = false;
};

// computed function to change content of modal
const publishStateChange = computed(() => {
  const publishState = reactive({
    title: "",
    description: "",
    icon: "",
    alertState: true,
  });

  let title = "",
    description = "",
    icon = "tick";

  // different content for step 1 based on coreElement status
  if (mandatoryElementStatus) {
    title = "Mandatory Elements Complete";
    description =
      "Congratulations! All the mandatory elements are complete. Continue to publish this organization.";
  } else {
    title = "Mandatory Elements not complete";
    description =
      "<p>There is missing data in some of the mandatory elements. We highly recommend that you complete these data fields to help ensure your data is useful.</p>";
    icon = "warning-fill";
  }

  switch (publishStep.value) {
    // first step
    case 0:
      publishState.title = title;
      publishState.description = description;
      publishState.icon = icon;
      publishState.alertState = mandatoryElementStatus;
      break;
  }

  return publishState;
});

// call api for publishing
interface ToastMessageTypeface {
  message: string;
  type: boolean;
}

const toastMessage = inject("toastMessage") as ToastMessageTypeface;

const publishFunction = () => {
  loader.value = true;
  loaderText.value = "Publishing";
  resetPublishStep();

  axios.post(`/organisation/publish`).then((res) => {
    const response = res.data;
    loader.value = false;
    toastMessage.message = response.message;
    toastMessage.type = response.success;
    setTimeout(() => {
      loader.value = false;
    }, 2000);

    if(response.success) {
      publishStatus.is_published = true;
      publishStatus.status = 'published';
    }
  });
};

interface PublishStatusTypeface {
  is_published: boolean;
  status: string;
}

// publish-republish
const publishStatus = inject("publishStatus") as PublishStatusTypeface;

const btnText = computed(() => {
  if (publishStatus.is_published && publishStatus.status === "draft") {
    return "Republish";
  } else {
    return "Publish";
  }
});
</script>
