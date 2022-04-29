<template>
  <Teleport to="body">
    <Transition name="modal-animation">
      <div
        v-if="modalActive"
        class="modal fixed top-0 left-0 flex h-screen w-screen items-center justify-center p-8"
      >
        <Transition name="modal-animation-inner">
          <div class="flex h-full w-full items-center justify-center">
            <div
              class="modal-backdrop absolute left-0 top-0 h-full w-full bg-n-50 opacity-50"
              @click="close"
            ></div>
            <div
              v-if="modalActive"
              class="modal-inner relative max-h-full w-full max-w-[809px] overflow-x-hidden rounded-lg bg-white p-8"
            >
              <slot />
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'popup-modal',
  props: ['modalActive'],
  emits: ['close'],
  setup(props, { emit }) {
    const close = () => {
      emit('close');
    };
    return { close };
  },
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
  transition: all 0.5s cubic-bezier(0.52, 0.02, 0.19, 1.02);
}
.modal-animation-inner-enter-from {
  opacity: 0;
  transform: scale(0.8);
}
.modal-animation-inner-leave-to {
  transform: scale(0.8);
}
</style>
