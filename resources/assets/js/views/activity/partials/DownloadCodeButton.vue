<template>
  <div>
    <button class="button secondary-btn font-bold" @click="downloadCode">
      Download code
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
