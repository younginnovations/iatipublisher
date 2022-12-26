<template>
  <Modal modal-active="true">
    <div class="modal-inner">
      <div class="mb-4 flex items-center space-x-1">
        <svg-vue icon="alert" class="text-crimson-40"></svg-vue>
        <span class="text-sm font-bold text-n-50">{{
          language.common_lang.mandatory_field_not_filled
        }}</span>
      </div>
      <div class="mb-4 rounded-lg bg-rose p-4 text-sm text-n-50">
        <p>
          {{ language.common_lang.some_mandatory_fields_not_completed }}
          {{ language.common_lang.cannot_publish_activity_until_mandatory }}
        </p>
      </div>
      <div class="flex justify-end space-x-5">
        <button class="ghost-btn">{{ language.button_lang.go_back }}</button>
        <button class="primary-btn">
          {{ language.button_lang.continue_anyway }}
        </button>
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
    const language = window['globalLang'];
    return {
      props,
      language,
    };
  },
});
</script>

<style lang="scss" scoped>
.modal-inner {
  max-width: 505px;
}
</style>
