<template>
  <div class="relative flex flex-row-reverse gap-2">
    <button
      v-if="store.state.selectedActivities.length > 0"
      ref="dropdownBtn"
      class="button secondary-btn font-bold"
      @click="toggle"
    >
      <svg-vue icon="download-file" />
    </button>
    <div
      v-if="state.isVisible"
      class="button__dropdown absolute left-0 top-[calc(100%_+_8px)] z-10 w-56 bg-white p-2 text-left shadow-dropdown"
    >
      <ul>
        <li>
          <a href="#" :class="liClass" @click="downloadCsv">Download CSV</a>
        </li>
        <li>
          <a href="#" :class="liClass" @click="downloadXml">Download XML</a>
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
        The XML file is in wrong format. Would you like to download it anyway?
      </p>

      <div class="mb-4 h-40 overflow-y-auto rounded-lg bg-rose p-4 text-sm">
        <div class="mb-2 flex justify-between">
          <div class="text-xs font-bold">Error message</div>
          <a
            class="top-1 right-3 cursor-pointer text-xs font-bold"
            @click="downloadError('error', message)"
            >Download error message</a
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
          Go back
        </button>
        <button
          class="rounded bg-bluecoral px-4 py-3 font-bold text-white"
          @click="downloadErrorxml"
        >
          Download Anyway
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
  </div>
</template>

<script lang="ts">
import { useStore } from 'Store/activities/index';
import { reactive, defineComponent, ref, onMounted } from 'vue';
import CreateModal from '../CreateModal.vue';
import { useToggle } from '@vueuse/core';
import Toast from '../../../components/ToastMessage.vue';
import Modal from 'Components/PopupModal.vue';

import axios from 'axios';

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
    const downloadErrorxml = () => {
      const activities = store.state.selectedActivities.join(',');
      axios
        .get(`/activities/download-xml/true?activities=[${activities}]`)
        .then((res) => {
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
            link.download = res.headers['content-disposition'].split('=')[1];
            link.click();
          }
        });
    };
    const downloadXml = () => {
      const activities = store.state.selectedActivities.join(',');
      axios
        .get(`/activities/download-xml?activities=[${activities}]`)
        .then((res) => {
          console.log(res);
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
            link.download = res.headers['content-disposition'].split('=')[1];
            link.click();
          }
        });
    };

    const downloadCsv = () => {
      const activities = store.state.selectedActivities.join(',');
      axios
        .get(`/activities/download-csv?activities=[${activities}]`)
        .then((res) => {
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
            link.download = res.headers['content-disposition'].split('=')[1];
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
      toastMessage,
      toastmessageType,
      downloadXml,
      Modal,
      showErrorpopup,
      downloadErrorxml,
      message,
      downloadError,
    };
  },
});
</script>
