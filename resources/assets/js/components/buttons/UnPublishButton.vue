<template>
  <BtnComponent
    class=""
    text="Unpublish"
    :type="type"
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
        <b>Unpublish activity</b>
      </div>
      <div class="rounded-lg bg-rose p-4">
        Are you sure you want to unpublish this activity?
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
import {
  defineProps,
  reactive,
  inject,
  onMounted,
  defineEmits,
  onUpdated,
  toRefs,
} from 'vue';
import { useToggle } from '@vueuse/core';
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from 'Components/PopupModal.vue';
import Loader from 'Components/sections/ProgressLoader.vue';

// Vuex Store
import { detailStore } from 'Store/activities/show';

const props = defineProps({
  type: { type: String, default: 'primary' },
  activityId: { type: Number, required: true },
});

const { activityId } = toRefs(props);
const emit = defineEmits(['load']);

// toggle state for modal popup
let [unpublishValue, unpublishToggle] = useToggle();

//Global State
const store = detailStore();
onMounted(() => {
  emit('load');
});
//activity id
const id = activityId.value;

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
onUpdated(() => {
  if (loader.value) {
    store.dispatch('updateIsLoading', true);
  } else {
    store.dispatch('updateIsLoading', false);
  }
  if (unpublishValue.value) {
    loader.value = false;
  }
  if (loader.value) {
    unpublishValue.value = false;
  }
});

const toastMessage = inject('toastMessage') as ToastMessageTypeface;

const unPublishFunction = () => {
  unpublishValue.value = false;
  setTimeout(function () {
    loader.value = true;
  }, 500);

  loader.text = 'Unpublishing';

  axios.post(`/activity/${id}/unpublish`).then((res) => {
    const response = res.data;
    toastMessage.message = response.message;
    toastMessage.type = response.success;
    unpublishValue.value = false;

    setTimeout(() => {
      if (response.success === true) {
        store.dispatch('updateUnPublished', false);
        store.dispatch('updateShowPublished', true);
        store.dispatch('updatePublishErrors', []);
      }
      location.reload();
    }, 1000);
  });
};
</script>
