<template>
  <BtnComponent
    class=""
    text=""
    type="secondary"
    icon="delete"
    @click="deleteValue = true"
  />
  <Modal :modal-active="deleteValue" width="583" @close="deleteToggle">
    <div class="mb-4">
      <div class="flex mb-6 title">
        <svg-vue class="mr-1 mt-0.5 text-lg text-crimson-40" icon="delete" />
        <b>Delete activity</b>
      </div>
      <div class="p-4 rounded-lg bg-rose">
        Are you sure you want to delete this activity?
      </div>
    </div>
    <div class="flex justify-end">
      <div class="inline-flex">
        <BtnComponent
          class="px-6 uppercase bg-white"
          text="Go Back"
          type=""
          @click="deleteValue = false"
        />
        <BtnComponent
          class="space"
          text="Delete"
          type="primary"
          @click="deleteFunction"
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
let [deleteValue, deleteToggle] = useToggle();

//activity id
const id = inject('activityID');

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

const deleteFunction = () => {
  loader.value = true;
  loader.text = 'Deleting';

  axios.delete(`/activities/${id}`).then((res) => {
    const response = res.data;
    toastMessage.message = response.message;
    toastMessage.type = response.success;

    if (response.success) {
      window.location.replace('/activities');
    }
  });
};
</script>
