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
          <a href="#" @click="downloadXml" :class="liClass">Download XML</a>
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
      <p class="font-bold">Download anyway</p>
      <p class="rounded-lg bg-rose p-4 text-sm">
        This XML is wrong format. Do you want to download anyway?
      </p>
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
      :type="toastmessageType"
      v-if="toastVisibility"
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

      // axios({
      //   url: `activities/download-csv?activities=[${activities}]`,
      //   method: 'GET',
      //   responseType: 'arraybuffer', http://127.0.0.1:8001/activities/download-xml?activities=[43
      axios
        .get(`/activities/download-xml?activities=[${activities}]`)
        .then((res) => {
          if (res.data.success == false) {
            if (res.data.xml_error === true) {
              showErrorpopup.value = true;
              console.log('heres');
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
          console.log(res);
        });
    };

    const downloadCsv = () => {
      const activities = store.state.selectedActivities.join(',');

      // axios({
      //   url: `activities/download-csv?activities=[${activities}]`,
      //   method: 'GET',
      //   responseType: 'arraybuffer',
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
    };
  },
});
</script>
