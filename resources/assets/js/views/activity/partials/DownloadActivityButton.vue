<template>
  <div class="relative flex flex-row-reverse gap-2">
    <button
      v-if="store.state.selectedActivities.length === 0"
      ref="dropdownBtn"
      class="button secondary-btn font-bold"
      @click="toggle"
    >
      <svg-vue icon="download-file" /> {{ translate.button('download_all') }}
      <svg-vue icon="dropdown-arrow" class="text-blue-coral !text-[6px]" />
    </button>
    <button
      v-if="store.state.selectedActivities.length > 0"
      ref="dropdownBtn"
      class="button secondary-btn font-bold"
      @click="toggle"
    >
      <svg-vue icon="download-file" />
      <svg-vue icon="dropdown-arrow" class="text-blue-coral !text-[6px]" />
    </button>

    <div
      v-if="state.isVisible"
      class="button__dropdown absolute left-0 top-[calc(100%_+_8px)] z-10 w-56 bg-white p-2 text-left shadow-dropdown"
    >
      <ul>
        <li>
          <a
            href="#"
            :class="liClass"
            @click="downloadCsv(store.state.selectedActivities.length)"
            >{{
              capitalize(translate.button('download_element', 'common.csv'))
            }}</a
          >
        </li>
        <li>
          <a
            href="#"
            :class="liClass"
            @click="downloadXml(store.state.selectedActivities.length)"
            >{{
              capitalize(translate.button('download_element', 'common.xml'))
            }}</a
          >
        </li>
        <li>
          <a href="#" :class="liClass" @click="checkDownload">
            {{ capitalize(translate.button('download_element', 'common.xls')) }}
          </a>
        </li>
      </ul>
    </div>
    <Modal
      :modal-active="showErrorpopup"
      width="583"
      @close="
        () => {
          showErrorpopup = false;
        }
      "
    >
      <p class="text-sm font-bold">
        {{ translate.button('download_xml_confirmation') }}
      </p>

      <div class="mb-4 h-40 overflow-y-auto rounded-lg bg-rose p-4 text-sm">
        <div class="mb-2 flex justify-between">
          <div class="text-xs font-bold">
            {{ translate.commonText('error_message') }}
          </div>
          <a
            class="top-1 right-3 cursor-pointer text-xs font-bold"
            @click="downloadError('error', message)"
            >{{
              capitalize(
                translate.button('download_element', 'common.error_message')
              )
            }}</a
          >
        </div>
        {{ message }}
      </div>

      <div class="flex justify-end space-x-4">
        <button
          class="text-xs font-bold capitalize text-bluecoral"
          @click="
            () => {
              showErrorpopup = false;
            }
          "
        >
          {{ translate.button('go_back') }}
        </button>
        <button
          class="rounded bg-bluecoral px-4 py-3 font-bold text-white"
          @click="downloadErrorxml(store.state.selectedActivities.length)"
        >
          {{
            capitalize(translate.button('download_element', 'common.anyway'))
          }}
        </button>
      </div>
    </Modal>
    <Toast
      v-if="toastVisibility"
      :type="toastmessageType"
      class="toast"
      :message="toastMessage"
    />
    <CreateModal
      :modal-active="modalValue"
      @close="modalToggle"
      @close-modal="modalToggle"
    />
    <Modal :modal-active="downloadingBackgroundMessage" width="583">
      <div class="modal-inner">
        <div class="mb-4 flex items-center space-x-1">
          <svg-vue icon="warning-fill" class="text-camel-50"></svg-vue>
          <span class="text-sm font-bold text-n-50"
            >Preparing activities for download</span
          >
        </div>
        <div class="mb-4 rounded-lg bg-eggshell p-4 text-sm text-n-50">
          <p class="mb-4">
            Please be advised that we are currently zipping your activities for
            a seamless download experience. This process will run in the
            background and may require some time to complete.
          </p>
          <p>
            To monitor the progress, kindly refer to the status bar at the
            bottom of the screen. Upon completion, a notification email will be
            sent to you, confirming that the file is ready for download.
          </p>
        </div>
        <div class="flex justify-end space-x-5">
          <button
            class="ghost-btn"
            @click="downloadingBackgroundMessage = false"
          >
            cancel download
          </button>
          <button
            class="primary-btn"
            @click="downloadXls(store.state.selectedActivities.length)"
          >
            {{ translate.button('continue') }}
          </button>
        </div>
      </div>
    </Modal>
    <Modal :modal-active="downloadingInProcess" width="583">
      <div class="modal-inner">
        <div class="mb-4 flex items-center space-x-1">
          <svg-vue icon="warning-fill" class="text-crimson-50"></svg-vue>
          <span class="text-sm font-bold text-n-50"
            >Preparation for download already in progress</span
          >
        </div>
        <div class="mb-4 rounded-lg bg-rose p-4 text-sm text-n-50">
          <p>
            We are currently preparing the activities for download. This may
            take a few minutes.
          </p>
          <p>
            If you would like to proceed with the new download, the prior
            download will be cancelled and your new download will start zipping.
          </p>
          <p>Would you like to proceed with the new download?</p>
        </div>
        <div class="flex justify-end space-x-5">
          <button class="ghost-btn" @click="downloadingInProcess = false">
            {{ translate.button('go_back') }}
          </button>
          <button class="primary-btn" @click="downloadAnyway">
            {{
              capitalize(translate.button('download_element', 'common.anyway'))
            }}
          </button>
        </div>
      </div>
    </Modal>
    <div
      v-if="isLoading"
      class="fixed left-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black opacity-40"
    >
      <div>
        <span class="spinner" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { useStore } from 'Store/activities/index';
import { reactive, defineComponent, ref, onMounted, capitalize } from 'vue';
import CreateModal from '../CreateModal.vue';
import { useToggle } from '@vueuse/core';
import Toast from '../../../components/ToastMessage.vue';
import Modal from 'Components/PopupModal.vue';

import axios from 'axios';
import { Translate } from 'Composable/translationHelper';

/**
 *  Global State
 */
const store = useStore();

export default defineComponent({
  name: 'AddActivityButton',
  components: {
    CreateModal,
    Toast,
    Modal,
  },
  setup() {
    const translate = new Translate();
    const state = reactive({
      isVisible: false,
    });

    const [modalValue, modalToggle] = useToggle();

    const modelVisible = ref(false);
    const toastVisibility = ref(false);
    const toastMessage = ref('');
    const toastmessageType = ref(false);
    const showErrorpopup = ref(false);
    const message = ref('');
    const downloadingBackgroundMessage = ref(false);
    const downloadingInProcess = ref(false);
    const isLoading = ref(false);
    const toggleModel = (value: boolean) => {
      modelVisible.value = value;
    };

    const liClass =
      'block p-2.5 text-n-40 text-tiny leading-[1.5] font-bold hover:text-n-50 hover:bg-n-10';
    const dropdownBtn = ref();
    onMounted(() => {
      window.addEventListener('click', (e) => {
        if (!dropdownBtn.value.contains(e.target)) {
          state.isVisible = false;
        }
      });
    });
    function downloadError(filename, text) {
      var element = document.createElement('a');
      element.setAttribute(
        'href',
        'data:text/plain;charset=utf-8,' + encodeURIComponent(text)
      );
      element.setAttribute('download', filename);

      element.style.display = 'none';
      document.body.appendChild(element);

      element.click();

      document.body.removeChild(element);
    }

    const toggle = () => {
      state.isVisible = !state.isVisible;
    };
    const checkDownload = () => {
      isLoading.value = true;
      axios.get('/activities/download-xls-progress-status').then((res) => {
        if (res.data.status) {
          isLoading.value = false;
          downloadingInProcess.value = true;
        } else {
          isLoading.value = false;
          downloadingBackgroundMessage.value = true;
        }
      });
    };

    const downloadAnyway = () => {
      store.dispatch('updateCancelDownload', true);
      isLoading.value = true;
      downloadingInProcess.value = false;
      store.dispatch('updateCancelDownload', true);

      store.dispatch('updateStartXlsDownload', false);

      axios.get('/activities/cancel-xls-download').then(() => {
        checkDownload();
      });
    };

    const downloadErrorxml = (countActivities) => {
      showErrorpopup.value = false;
      let queryParameters = window.location.href.split('?');
      let addQueryParams = '';

      if (queryParameters.length === 2) {
        addQueryParams = '&' + queryParameters[1];
      }

      let apiUrl =
        '/activities/download-xml/true?activities=all' + addQueryParams;

      if (countActivities > 0) {
        const activities = store.state.selectedActivities.join(',');
        apiUrl = `/activities/download-xml/true?activities=[${activities}]`;
      }

      axios.get(apiUrl).then((res) => {
        if (res.data.success == false) {
          toastVisibility.value = true;
          toastMessage.value = res.data.message;
          toastmessageType.value = res.data.success;
          setTimeout(() => (toastVisibility.value = false), 15000);
        } else {
          const response = res.data;
          let blob = new Blob([response], {
            type: 'application/xml',
          });
          let link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = res.headers['content-disposition']?.split('=')[1];
          link.click();
        }
      });
    };
    const downloadXml = (countActivities) => {
      let queryParameters = window.location.href?.split('?');
      let addQueryParams = '';

      if (queryParameters.length === 2) {
        addQueryParams = '&' + queryParameters[1];
      }

      let apiUrl = '/activities/download-xml?activities=all' + addQueryParams;

      if (countActivities > 0) {
        const activities = store.state.selectedActivities.join(',');
        apiUrl = `/activities/download-xml?activities=[${activities}]`;
      }

      axios.get(apiUrl).then((res) => {
        if (res.data.success == false) {
          if (res.data.xml_error === true) {
            showErrorpopup.value = true;
            message.value = res.data.message;
          } else {
            toastVisibility.value = true;
            toastMessage.value = res.data.message;
            toastmessageType.value = res.data.success;
            setTimeout(() => (toastVisibility.value = false), 15000);
          }
        } else {
          const response = res.data;
          let blob = new Blob([response], {
            type: 'application/xml',
          });
          let link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = res.headers['content-disposition']?.split('=')[1];
          link.click();
        }
      });
    };

    const downloadXls = (countActivities) => {
      isLoading.value = true;
      store.dispatch('updateStartXlsDownload', true);
      store.dispatch('updateCancelDownload', false);

      downloadingBackgroundMessage.value = false;
      let queryParameters = window.location.href?.split('?');
      let addQueryParams = '';

      if (queryParameters.length === 2) {
        addQueryParams = '&' + queryParameters[1];
      }

      let apiUrl = '/activities/prepare-xls?activities=all' + addQueryParams;

      if (countActivities > 0) {
        const activities = store.state.selectedActivities.join(',');
        apiUrl = `/activities/prepare-xls?activities=[${activities}]`;
      }

      axios.get(apiUrl).finally(() => (isLoading.value = false));
    };

    const downloadCsv = (countActivities) => {
      let queryParameters = window.location.href?.split('?');
      let addQueryParams = '';

      if (queryParameters.length === 2) {
        addQueryParams = '&' + queryParameters[1];
      }

      let apiUrl = '/activities/download-csv?activities=all' + addQueryParams;

      if (countActivities > 0) {
        const activities = store.state.selectedActivities.join(',');
        apiUrl = `/activities/download-csv?activities=[${activities}]`;
      }

      axios.get(apiUrl).then((res) => {
        if (res.data.success == false) {
          toastVisibility.value = true;
          toastMessage.value = res.data.message;
          toastmessageType.value = res.data.success;
          setTimeout(() => (toastVisibility.value = false), 15000);
        } else {
          const response = res.data;
          let blob = new Blob([response], {
            type: 'application/csv',
          });
          let link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = res.headers['content-disposition']?.split('=')[1];
          link.click();
        }
      });
    };

    return {
      store,
      state,
      liClass,
      modelVisible,
      modalValue,
      toggle,
      modalToggle,
      toggleModel,
      dropdownBtn,
      downloadCsv,
      toastVisibility,
      downloadingBackgroundMessage,
      toastMessage,
      toastmessageType,
      downloadXml,
      Modal,
      showErrorpopup,
      checkDownload,
      downloadErrorxml,
      message,
      downloadError,
      downloadXls,
      downloadingInProcess,
      isLoading,
      downloadAnyway,
      translate,
    };
  },
  methods: { capitalize },
});
</script>
<style scoped lang="scss">
.spinner {
  @apply inline-block  animate-spin rounded-full border-2 border-n-10 border-opacity-5;
  width: 75px;
  height: 75px;
  border-top-color: white;
}
</style>
