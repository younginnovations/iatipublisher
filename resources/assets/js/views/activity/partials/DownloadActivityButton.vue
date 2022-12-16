<template>
  <div>
    <button
        v-if="store.state.selectedActivities.length > 0"
        ref="dropdownBtn"
        class="button secondary-btn mr-3.5 font-bold"
        @click="toggle"
    >
      <svg-vue icon="download-file" />
      <div
          v-if="state.isVisible"
          class="button__dropdown absolute right-0 top-full z-10 w-56 bg-white p-2 text-left shadow-dropdown"
      >
        <ul>
          <li>
            <a href="#" :class="liClass" @click="downloadCsv"
            >Download CSV</a
            >
          </li>
          <li>
            <a href="/import" :class="liClass"
            >Download XML</a
            >
          </li>
        </ul>
      </div>
    </button>
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
import axios from "axios";

/**
 *  Global State
 */
const store = useStore();

export default defineComponent({
  name: 'AddActivityButton',
  components: {
    CreateModal,
  },
  setup() {
    const state = reactive({
      isVisible: false,
    });

    const [modalValue, modalToggle] = useToggle();

    const modelVisible = ref(false);

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

    const downloadCsv = () => {
      const activities = store.state.selectedActivities.join(',');

      axios({
        url: `activities/download-csv?activities=[${activities}]`,
        method: "GET",
        responseType: "arraybuffer",
      }).then((res) => {
        const response = res.data;

        console.log(response);
        let blob = new Blob([response.data], {
          type: "application/csv",
        });
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "csv_test.csv";
        link.click();
      });
    }

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
    };
  },
});
</script>
