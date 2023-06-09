<template>
  <div class="relative h-[80px] rounded-t-lg bg-eggshell p-6">
    <button
      v-if="xlsDownloadStatus === 'completed'"
      class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 rounded-full bg-white p-[1px]"
      @click="cancelDownload"
    >
      <svg-vue class="text-sm" icon="cross-icon" />
    </button>
    <div
      v-if="xlsDownloadStatus != 'failed'"
      class="mb-3 flex h-1 w-full justify-start rounded-full bg-spring-10"
    >
      <div
        :style="{ width: percentageWidth + '%' }"
        class="h-full rounded-full bg-spring-50"
      ></div>
    </div>
    <div v-else class="flex justify-between space-x-4">
      <div class="flex space-x-2">
        <span class="text-sm text-n-40">Preparing activities for download</span>
        <span class="text-sm italic text-n-30">Failed</span>
      </div>
      <button
        class="text-xs font-bold uppercase text-bluecoral hover:text-bluecoral"
        @click="showRetryDownloadModel = true"
      >
        retry
      </button>
    </div>

    <div
      v-if="xlsDownloadStatus != 'failed'"
      class="flex justify-between space-x-5"
    >
      <p v-if="xlsDownloadStatus != 'completed'" class="text-sm text-n-40">
        Preparing {{ fileCount ? fileCount : 0 }}/4 files for download
      </p>
      <p v-else class="text-sm text-n-40">Zip File is Ready</p>

      <spinnerLoader v-if="xlsDownloadStatus != 'completed'" />
      <button
        v-if="xlsDownloadStatus != 'completed'"
        class="text-xs font-bold uppercase text-bluecoral hover:text-bluecoral"
        @click="cancelDownload"
      >
        cancel
      </button>
      <button
        v-else
        class="text-xs font-bold uppercase text-spring-50 hover:text-spring-50"
        @click="downloadFile"
      >
        download
      </button>
    </div>
  </div>
  <Modal :modal-active="showRetryDownloadModel" width="583">
    <p class="bg-eggshell p-4 text-n-50">Are you sure you want to retry?</p>
    <div class="flex justify-end space-x-5">
      <button class="ghost-btn" @click="showRetryDownloadModel = false">
        cancel
      </button>
      <button class="primary-btn" @click="retryDownload()">Retry</button>
    </div>
  </Modal>
</template>
<script setup lang="ts">
import { inject, computed, onMounted, ref, Ref } from 'vue';
import spinnerLoader from './spinnerLoader.vue';
import Modal from 'Components/PopupModal.vue';

import axios from 'axios';
import { useStore } from 'Store/activities/index';
const store = useStore();
const showRetryDownloadModel = ref();
const isLoading = ref();

onMounted(() => {
  const supportButton: HTMLElement = document.querySelector(
    '#launcher'
  ) as HTMLElement;

  if (supportButton !== null) {
    supportButton.style.transform = 'translatey(-50px)';
  }
});
const downloadFile = () => {
  store.dispatch('updateCompleteXlsDownload', true);
  store.dispatch('updateCancelDownload', true);
  store.dispatch('updateStartXlsDownload', false);

  const apiUrl = `${(downloadApiUrl as Ref).value.split()[0].split('/')[3]}/${
    (downloadApiUrl as Ref).value.split()[0].split('/')[4]
  }`;
  axios({
    method: 'get',
    url: apiUrl,
    responseType: 'blob',
  }).then((res) => {
    const fileName = res.headers['content-disposition'].split('filename=')[1];
    const blob = new Blob([res.data], {});
    const link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.setAttribute('download', fileName);
    document.body.appendChild(link);
    link.click();
  });
};

const retryDownload = () => {
  xlsDownloadStatus.value = '';
  isLoading.value = true;
  store.dispatch('updateStartXlsDownload', true);
  store.dispatch('updateCancelDownload', false);

  showRetryDownloadModel.value = false;

  const apiUrl = 'activities/retry-xls-download';

  axios.get(apiUrl).finally(() => (isLoading.value = false));
};
const cancelDownload = () => {
  store.dispatch('updateCancelDownload', true);

  store.dispatch('updateStartXlsDownload', false);

  axios.get('/activities/cancel-xls-download');
};

const percentageWidth = computed(() => {
  return ((fileCount as Ref).value / 4) * 100;
});

const fileCount = inject('fileCount');
const xlsDownloadStatus = inject('xlsDownloadStatus') as Ref;
const downloadApiUrl = inject('downloadApiUrl');
</script>
