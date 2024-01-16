<template>
  <Modal modal-active="true">
    <div class="modal-inner">
      <div class="mb-4 flex items-center space-x-1">
        <svg-vue icon="alert" class="text-crimson-40"></svg-vue>
        <span class="text-sm font-bold text-n-50">{{
          translate.commonText('mandatory_field_not_filled')
        }}</span>
      </div>
      <div class="mb-4 rounded-lg bg-rose p-4 text-sm text-n-50">
        <p>
          {{ translate.commonText('some_mandatory_fields_not_completed') }}
          {{ translate.commonText('cannot_publish_activity_until_mandatory') }}
        </p>
      </div>
      <div class="flex justify-end space-x-5">
        <button class="ghost-btn">{{ translate.button('go_back') }}</button>
        <button class="primary-btn">
          {{ translate.button('continue_anyway') }}
        </button>
      </div>
    </div>
  </Modal>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Modal from './PopupModal.vue';
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    return {
      props,
      translate,
    };
  },
});
</script>

<style lang="scss" scoped>
.modal-inner {
  max-width: 505px;
}
</style>
