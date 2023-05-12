<template>
  <div class="h-[80px] rounded-t-lg bg-eggshell p-6">
    <div
      v-if="xlsDownloadStatus != 'failed'"
      class="mb-3 flex h-1 w-full justify-start rounded-full bg-spring-10"
    >
      <div
        :style="{ width: percentageWidth + '%' }"
        class="h-full rounded-full bg-spring-50"
      ></div>
    </div>
    <div v-else>
      <p class="text-sm font-bold text-crimson-50">
        Failed to prepare files for download
      </p>
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
        v-else
        class="text-xs font-bold uppercase text-spring-50 hover:text-spring-50"
        @click="downloadFile"
      >
        download
      </button>
    </div>
  </div>
</template>
<script setup lang="ts">
import { inject, computed, onMounted, onUnmounted, ref, Ref } from 'vue';
import spinnerLoader from './spinnerLoader.vue';
import axios from 'axios';
import { useStore } from 'Store/activities/index';
const store = useStore();
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
  let apiUrl = `${(downloadApiUrl as Ref).value.split()[0].split('/')[3]}/${
    (downloadApiUrl as Ref).value.split()[0].split('/')[4]
  }`;
  axios({
    method: 'get',
    url: apiUrl,
    responseType: 'blob',
  }).then((res) => {
    let fileName = res.headers['content-disposition'].split('filename=')[1];
    let blob = new Blob([res.data], {});
    const link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.setAttribute('download', fileName);
    document.body.appendChild(link);
    link.click();
  });
};

const percentageWidth = computed(() => {
  return ((fileCount as Ref).value / 4) * 100;
});

const fileCount = inject('fileCount');
const xlsDownloadStatus = inject('xlsDownloadStatus');
const downloadApiUrl = inject('downloadApiUrl');
</script>
