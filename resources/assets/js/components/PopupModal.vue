<template>
  <Teleport to="body">
    <Transition name="modal-animation">
      <div
        v-if="modalActive"
        :class="{ '!p-0': noPadding }"
        class="modal fixed top-0 left-0 z-[999998] flex h-screen w-screen items-center justify-center p-4 sm:p-8"
      >
        <Transition name="modal-animation-inner">
          <div class="flex h-full w-full items-center justify-center">
            <div
              class="modal-backdrop absolute top-0 left-0 h-full w-full bg-n-50 opacity-50"
              @click="close"
            />
            <div
              v-if="modalActive"
              :style="`max-width:${width}px; `"
              :class="{ '!p-0': noPadding }"
              class="modal-inner relative max-h-full w-full overflow-x-hidden rounded-lg bg-white p-4 sm:p-8"
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
import { defineComponent, watch, onUnmounted, onMounted } from 'vue';
export default defineComponent({
  name: 'PopupModal',
  props: {
    modalActive: {
      type: Boolean,
      required: true,
    },
    noPadding: {
      type: Boolean,
      required: false,
      default: false,
    },
    width: {
      type: String,
      required: false,
      default: '809',
    },
  },
  emits: ['close', 'reset'],
  setup(props, { emit }) {
    onMounted(() => {
      if (props.modalActive) {
        const supportButton: HTMLElement = document.querySelector(
          '#launcher'
        ) as HTMLElement;

        if (supportButton !== null) {
          supportButton.style.display = 'none';
        }
      }
    });

    onUnmounted(() => {
      const supportButton: HTMLElement = document.querySelector(
        '#launcher'
      ) as HTMLElement;

      if (supportButton !== null) {
        supportButton.style.display = 'block';
      }
    });

    watch(
      () => props.modalActive,
      (modalActive) => {
        console.log(modalActive, 'watchers triggered');
        if (modalActive) {
          document.documentElement.style.overflow = 'hidden';
          const checkSupportButton = setInterval(() => {
            const supportButton: HTMLElement = document.querySelector(
              '#launcher'
            ) as HTMLElement;

            if (supportButton !== null) {
              supportButton.style.display = 'none';
              console.log('hide supp');

              clearInterval(checkSupportButton);
            }
          }, 10);
        } else {
          document.documentElement.style.overflow = 'auto';
          const checkSupportButton = setInterval(() => {
            const supportButton: HTMLElement = document.querySelector(
              '#launcher'
            ) as HTMLElement;

            if (supportButton !== null) {
              supportButton.style.display = 'block';

              clearInterval(checkSupportButton);
            }
          }, 10);
        }
      }
    );
    const close = () => {
      document.documentElement.style.overflow = 'auto';
      emit('close');
      emit('reset');
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
