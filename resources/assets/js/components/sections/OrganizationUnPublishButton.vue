<template>
  <BtnComponent
    class=""
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
    v-if="loader.value"
    :text="loader.text"
    :class="{ 'animate-loader': loader }"
  />
</template>

<script setup lang="ts">
import { reactive, inject } from 'vue';
import { useToggle } from '@vueuse/core';
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from 'Components/PopupModal.vue';
import Loader from 'Components/sections/ProgressLoader.vue';

// toggle state for modal popup
let [unpublishValue, unpublishToggle] = useToggle();

// display/hide validator loader
interface LoaderTypeface {
  value: boolean;
  text: string;
}

const loader: LoaderTypeface = reactive({
  value: false,
  text: 'Please Wait',
});

// call api for unpublishing
interface ToastMessageTypeface {
  message: string;
  type: boolean;
}

const toastMessage = inject('toastMessage') as ToastMessageTypeface;

const unPublishFunction = () => {
  loader.value = true;
  loader.text = 'Unpublishing';
  unpublishValue.value = false;

  axios.post(`/organisation/unpublish`).then((res) => {
    const response = res.data;
    toastMessage.message = response.message;
    toastMessage.type = response.success;
    setTimeout(() => {
      loader.value = false;
    }, 2000);

    // if (response.success) {
    //   publishStatus.is_published = false;
    //   publishStatus.status = 'draft';
    // }
  });

  // interface PublishStatusTypeface {
  //   is_published: boolean;
  //   status: string;
  // }

  // publish-republish
  // const publishStatus = inject('publishStatus') as PublishStatusTypeface;
  // console.log(publishStatus);
};
</script>
