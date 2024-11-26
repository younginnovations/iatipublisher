<template>
  <Transition name="fade">
    <div
      v-if="dataChanged"
      class="absolute bottom-0 left-0 z-50 h-full w-full overflow-hidden bg-black bg-opacity-20"
    >
      <Transition name="slide-in">
        <div
          v-if="showSlideIn"
          class="absolute bottom-0 left-0 w-full rounded-t-3xl bg-white p-10"
        >
          <div class="flex items-center gap-1 text-sm font-bold">
            <svg-vue class="text-xl" icon="warning-activity" />
            <p class="text-bluecoral">
              Changes have been detected in the activities, we recommend
              revalidating the activities to ensure data quality.
            </p>
          </div>
          <div class="mt-4 bg-n-10 p-4 text-sm">
            The changes will be published even if they are not revalidated. It
            is better to review the activities for optimal data quality.
          </div>
          <div class="mt-4 flex items-center justify-end">
            <ButtonComponent
              class="mx-3 bg-white px-3 uppercase"
              type=""
              text="Cancel"
              @click="emit('cancel')"
            />
            <div class="flex items-center gap-4">
              <button
                class="flex items-center gap-1.5 rounded border border-bluecoral px-2.5 py-3 text-xs font-bold uppercase text-bluecoral"
                @click="emit('continueAnyway')"
              >
                Continue to Publish
              </button>
              <ButtonComponent
                type="primary"
                text="Revalidate"
                @click="emit('reverify')"
              />
            </div>
          </div>
        </div>
      </Transition>
    </div>
  </Transition>
</template>

<script lang="ts" setup>
import { defineProps, defineEmits } from 'vue';
import ButtonComponent from './ButtonComponent.vue';

defineProps({
  dataChanged: {
    type: Boolean,
    required: true,
  },
  showSlideIn: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits(['cancel', 'continueAnyway', 'reverify']);
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.fade-enter-to,
.fade-leave-from {
  opacity: 1;
}

.slide-in-enter-from,
.slide-in-leave-to {
  transform: translateY(100%);
}

.slide-in-enter-to,
.slide-in-leave-from {
  transform: translateY(0);
}
.slide-in-enter-active,
.slide-in-leave-active {
  transition: all 0.5s ease;
}
</style>
