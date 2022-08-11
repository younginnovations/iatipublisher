<template>
  <Teleport to="body">
    <Transition name="modal-animation">
      <div
        v-if="modalActive"
        class="fixed top-0 left-0 z-50 flex items-center justify-center w-screen h-screen p-8 modal"
      >
        <Transition name="modal-animation-inner">
          <div class="flex items-center justify-center w-full h-full">
            <div
              class="absolute top-0 left-0 w-full h-full opacity-50 modal-backdrop bg-n-50"
              @click="close"
            />
            <div
              v-if="modalActive"
              :style="`max-width:${width}px;`"
              class="relative w-full max-h-full p-8 overflow-x-hidden bg-white rounded-lg modal-inner"
            >
              <slot />
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { defineEmits, defineProps } from 'vue';

const emit = defineEmits(['close', 'reset']);

const close = () => {
  emit('close');
  emit('reset');
};

defineProps({
  modalActive: { type: Boolean, required: true },
  width: { type: String, default: '809' },
});
</script>

<style lang="scss" scoped>
.modal-animation-enter-active,
.modal-animation-leave-active {
  transition: opacity 0.5s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-animation-enter-from,
.modal-animation-leave-to {
  opacity: 0;
}

.modal-animation-inner-enter-active {
  transition: all 0.5s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
}

.modal-animation-inner-leave-active {
  transition: all 0.1s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}

.modal-animation-inner-enter-from {
  opacity: 0;
  transform: scale(0.8);
}

.modal-animation-inner-leave-to {
  transform: scale(0.8);
}
</style>
