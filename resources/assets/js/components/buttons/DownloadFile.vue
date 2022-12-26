<template>
  <BtnComponent
    class=""
    text=""
    type="secondary"
    icon="download-file"
    @click="downloadValue = true"
  />
  <Modal :modal-active="downloadValue" width="583" @close="downloadToggle">
    <div class="mb-4">
      <div class="title mb-6 flex">
        <svg-vue
          class="mr-1 mt-0.5 text-lg text-spring-50"
          icon="download-file"
        />
        <b>{{ language.common_lang.download_file }}</b>
      </div>
      <div class="rounded-lg bg-mint p-4">
        {{ language.common_lang.click_the_download }}
      </div>
    </div>
    <div class="flex justify-end">
      <div class="inline-flex">
        <BtnComponent
          class="bg-white px-6 uppercase"
          :text="language.button_lang.go_back"
          type=""
          @click="downloadValue = false"
        />
        <BtnComponent
          class="space"
          :text="language.button_lang_lang.download"
          type="primary"
          @click="downloadFunction()"
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

const language = window['globalLang'];

// toggle state for modal popup
let [downloadValue, downloadToggle] = useToggle();

//activity id
const id = inject('activityID');

// display/hide validator loader
interface LoaderTypeface {
  value: boolean;
  text: string;
}

const loader: LoaderTypeface = reactive({
  value: false,
  text: language.common_lang.please_wait,
});

// call api for unpublishing
interface ToastMessageTypeface {
  message: string;
  type: boolean;
}

const toastMessage = inject('toastMessage') as ToastMessageTypeface;

const downloadFunction = () => {
  loader.value = true;
  loader.text = language.common_lang.downloading;

  axios.delete(`/activity/${id}`).then((res) => {
    const response = res.data;
    toastMessage.message = response.message;
    toastMessage.type = response.success;
  });
};
</script>
