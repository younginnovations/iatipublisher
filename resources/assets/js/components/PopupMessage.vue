<template>
  <Modal modalActive="true">
    <div class="modal-inner">
      <div class="mb-4 flex items-center space-x-1">
        <svg-vue icon="alert" class="text-crimson-40"></svg-vue>
        <span class="text-sm font-bold text-n-50"
          >Mandatory fields not completed</span
        >
      </div>
      <div class="mb-4 rounded-lg bg-rose p-4 text-sm text-n-50">
        <p>
          Some mandatory fields have not been completed. You will not be able to
          publish your activity until all the mandatory fields have been filled.
        </p>
      </div>
      <div class="flex justify-end space-x-5">
        <button class="ghost-btn">Go back</button>
        <button class="primary-btn">Continue anyway</button>
      </div>
    </div>
  </Modal>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Modal from './PopupModal.vue';

export default defineComponent({
  components: {
    Modal,
  },
  props: {
    modalValue: {
      type: Boolean,
      required: false,
    },
  },
  setup(props) {
    return {
      props,
    };
  },
});
</script>

<style lang="scss" scoped>
.modal-inner {
  max-width: 505px;
}
</style>
