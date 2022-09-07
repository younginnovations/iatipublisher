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
  <Modal :modal-active="publishValue" width="583" @close="publishToggle">
    <div class="popup mb-4">
      <div class="title mb-6 flex">
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
        <BtnComponent
          v-if="!mandatoryElementStatus"
          class="bg-white px-6 uppercase"
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

  <BtnComponent
    v-if="publishStatus.is_published"
    class="ml-4"
    text="Unpublish"
    type="secondary"
    icon="cancel-cloud"
    @click="unpublishValue = true"
  />
  <Modal :modal-active="unpublishValue" width="583" @close="unpublishToggle">
    <div class="mb-4">
      <div class="title mb-6 flex">
        <svg-vue
          class="mr-1 mt-0.5 text-lg text-crimson-40"
          icon="cancel-cloud"
        />
        <b>Unpublish organisation</b>
      </div>
      <div class="rounded-lg bg-rose p-4">
        Are you sure you want to unpublish this organisation?
      </div>
    </div>
    <div class="flex justify-end">
      <div class="inline-flex">
        <BtnComponent
          class="bg-white px-6 uppercase"
          text="Go Back"
          type=""
          @click="unpublishValue = false"
        />
        <BtnComponent
          class="space"
          text="Unpublish"
          type="primary"
          @click="unPublishFunction"
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
import { reactive, ref, computed, inject } from 'vue';
import { useToggle } from '@vueuse/core';
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from 'Components/PopupModal.vue';
import Loader from 'Components/sections/ProgressLoader.vue';

// toggle state for modal popup
let [publishValue, publishToggle] = useToggle();
let [unpublishValue, unpublishToggle] = useToggle();

// display/hide validator loader
const loader = ref(false);

// state for first step
// determine if core element completed or not
// true for completed and false for not completed

const mandatoryElementStatus = inject('mandatoryCompleted') as boolean;

// Dynamic text for loader
const loaderText = ref('Please Wait');

// computed function to change content of modal
const publishStateChange = computed(() => {
  const publishState = reactive({
    title: '',
    description: '',
    icon: '',
    alertState: mandatoryElementStatus,
  });

  // different content for step 1 based on coreElement status
  if (mandatoryElementStatus) {
    publishState.title = 'Mandatory Elements Complete';
    publishState.description =
      'Congratulations! All the mandatory elements are complete. Continue to publish this organization.';
    publishState.icon = 'tick';
  } else {
    publishState.title = 'Mandatory Elements not complete';
    publishState.description =
      '<p>There is missing data in some of the mandatory elements. We highly recommend that you complete these data fields to help ensure your data is useful.</p>';
    publishState.icon = 'warning-fill';
  }

  return publishState;
});

// call api for publishing
interface ToastDataTypeface {
  message: string;
  type: boolean;
  visibility: boolean;
}

const toastData = inject('toastData') as ToastDataTypeface;

const publishFunction = () => {
  loader.value = true;
  loaderText.value = 'Publishing';
  publishValue.value = false;

  axios.post(`/organisation/publish`).then((res) => {
    const response = res.data;
    loader.value = false;
    toastData.message = response.message;
    toastData.type = response.success;
    toastData.visibility = true;

    setTimeout(() => {
      loader.value = false;
    }, 2000);

    if (response.success) {
      publishStatus.is_published = true;
      publishStatus.status = 'published';
    }
  });
};

const unPublishFunction = () => {
  loader.value = true;
  loaderText.value = 'Unpublishing';
  unpublishValue.value = false;

  axios.post(`/organisation/unpublish`).then((res) => {
    const response = res.data;
    toastData.message = response.message;
    toastData.type = response.success;
    toastData.visibility = true;
    setTimeout(() => {
      loader.value = false;
    }, 2000);

    if (response.success) {
      publishStatus.is_published = false;
    }
  });
};

interface PublishStatusTypeface {
  is_published: boolean;
  status: string;
}

// publish-republish
const publishStatus = inject('publishStatus') as PublishStatusTypeface;

const btnText = computed(() => {
  if (publishStatus.is_published && publishStatus.status === 'draft') {
    return 'Republish';
  } else {
    return 'Publish';
  }
});
</script>
