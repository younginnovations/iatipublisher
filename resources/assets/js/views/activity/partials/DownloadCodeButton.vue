<template>
  <div>
    <button
      class="button secondary-btn flex items-center space-x-1"
      @click="downloadCode"
    >
      <svg-vue icon="download-file" />
      <div class="pt-0.5 font-bold">Download code</div>
      <div class="group relative">
        <svg-vue class="text-[4px] text-n-30" icon="question-mark" />
        <div
          class="invisible absolute -left-[148px] -bottom-6 z-50 w-[352px] translate-y-full rounded bg-eggshell p-4 text-left normal-case opacity-0 duration-200 group-hover:visible group-hover:opacity-100"
        >
          <p class="mb-2 font-bold text-bluecoral">What is code?</p>
          <p class="mb-1.5 text-n-50">
            Codes are basically identifiers for activity, results, indicator and
            period which the IATI system generates automatically to map the
            respective activity.
          </p>
          <!-- <p class="text-n-40">
            To know more about how to publish data on activities according to
            the IATI read the <a class="font-bold">full guidance.</a>
          </p> -->
        </div>
      </div>
    </button>
    <Toast
      v-if="toastVisibility"
      :type="toastmessageType"
      class="toast"
      :message="toastMessage"
    />
  </div>
</template>
<script setup lang="ts">
import { useStore } from 'Store/activities/index';
import Toast from '../../../components/ToastMessage.vue';
import { ref } from 'vue';

import axios from 'axios';
const store = useStore();
const toastVisibility = ref(false);
const toastMessage = ref('');
const toastmessageType = ref(false);

const downloadCode = async () => {
  let apiUrl = '/activities/download-codes/?activities=all';

  if (store.state.selectedActivities.length > 0) {
    const activities = store.state.selectedActivities.join(',');
    apiUrl = `/activities/download-codes/?activities=[${activities}]`;
  }
  const req = await axios({
    method: 'get',
    url: apiUrl,
    responseType: 'blob',
  });
  var blob = new Blob([req.data], {
    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
  });

  // var blob = new Blob([req.data], {
  //   type: 'application/vnd.ms-excel',
  // });
  const link = document.createElement('a');
  link.href = window.URL.createObjectURL(blob);
  link.download = `codes.xlsx`;
  link.click();
};
</script>
