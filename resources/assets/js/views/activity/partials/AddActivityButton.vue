<template>
  <button class="button primary-btn relative font-bold" @click="toggle">
    <Toast
      v-if="toastVisibility"
      :message="toastMessage"
      :type="toastType"
    ></Toast>
    <svg-vue icon="plus"></svg-vue>
    <span>Add Activity</span>
    <div
      v-if="state.isVisible"
      class="button__dropdown absolute right-0 top-full z-10 w-48 bg-white p-2 text-left shadow-dropdown"
    >
      <ul>
        <li>
          <a href="#" @click="modalValue = true" :class="liClass"
            >Add activity manually</a
          >
        </li>
        <li><a href="#" :class="liClass">Upload activities from .xml</a></li>
        <li><a href="#" :class="liClass">Upload activities from .csv</a></li>
      </ul>
    </div>
  </button>
  <CreateActivityModal
    @close="modalToggle"
    :modalActive="modalValue"
    @closeModal="modalToggle"
    @toast="toast"
  ></CreateActivityModal>
</template>

<script lang="ts">
import { reactive, defineComponent, ref } from 'vue';
import Model from '../../../components/PopupModal.vue';
import HoverText from '../../../components/HoverText.vue';
import CreateActivityModal from './CreateActivityModal.vue';
import { useToggle } from '@vueuse/core';
import Toast from '../../../components/Toast.vue';

export default defineComponent({
  name: 'add-activity-button',
  components: {
    Model,
    HoverText,
    CreateActivityModal,
    Toast,
  },
  setup() {
    const state = reactive({
      isVisible: false,
    });

    const toastVisibility = ref(false);
    const toastMessage = ref('');
    const toastType = ref(false);

    const [modalValue, modalToggle] = useToggle();

    const modelVisible = ref(false);

    const toggleModel = (value: boolean) => {
      modelVisible.value = value;
    };

    function toast(message: string, type: boolean) {
      toastVisibility.value = true;
      setTimeout(() => (toastVisibility.value = false), 5000);
      toastMessage.value = message;
      toastType.value = type;
    }

    const liClass =
      'block p-2.5 text-n-40 text-tiny leading-[1.5] font-bold hover:text-n-50 hover:bg-n-10';

    const toggle = () => {
      state.isVisible = !state.isVisible;
    };

    return {
      state,
      liClass,
      modelVisible,
      modalValue,
      toastVisibility,
      toastMessage,
      toastType,
      toast,
      toggle,
      modalToggle,
      toggleModel,
    };
  },
});
</script>
