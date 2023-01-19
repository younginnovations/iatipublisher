<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <div class="my-4 flex justify-between">
      <h4 class="mr-4 text-3xl font-bold xl:text-heading-4">Organisations</h4>
      <div class="inline-flex items-center">
        <Toast
          v-if="toastMessage.visibility"
          class="mr-3.5"
          :message="toastMessage.message"
          :type="toastMessage.type"
        />
      </div>
    </div>
    <div class="organization-list overflow-hidden">
      <TableList />
    </div>
    <Loader
      v-if="loader.status"
      :text="loader.text"
      :class="{ 'animate-loader': loader.status }"
    />
  </div>
</template>

<script setup lang="ts">
import { reactive, provide } from 'vue';

// Components
import Loader from 'Components/sections/ProgressLoader.vue';
import Toast from 'Components/ToastMessage.vue';

import TableList from './components/TableList.vue';

// ref
const loader = reactive({
  status: false,
  text: 'Please Wait',
});

const toastMessage = reactive({
  visibility: false,
  message: '',
  type: true,
});

// provide
provide('loader', loader);
provide('toastData', toastMessage);
</script>
