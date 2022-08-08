<template>
  <div
    class="validation validation__errorHead"
    :class="{
      'invisible opacity-0': errorValue,
      'opacity-1 visible': !errorValue,
    }"
  >
    <div class="flex items-center justify-between validation__heading">
      <div class="flex items-center text-sm leading-relaxed icon grow">
        <svg-vue
          class="mr-1 text-base text-crimson-50"
          icon="warning-fill"
        ></svg-vue>
        <div class="font-bold">7 Issues found</div>
      </div>
      <button class="validation__toggle" @click="errorToggle()">Show</button>
    </div>
  </div>
  <div
    class="validation validation__errors"
    :class="{
      'opacity-1 visible': errorValue,
      'invisible opacity-0': !errorValue,
    }"
  >
    <div class="flex items-center justify-between validation__heading">
      <div class="flex items-center text-sm leading-relaxed icon grow">
        <div class="font-bold">7 Issues found in IATI Validator</div>
      </div>
      <button class="validation__toggle" @click="errorToggle()">Hide</button>
    </div>
    <div class="validation__errors-list">
      <div
        v-for="(error, e) in tempData"
        :key="e"
        :class="{ 'mb-4': Number(e) != Object.keys(tempData).length - 1 }"
      >
        <ErrorLists :type="e" :errors="error" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useToggle } from '@vueuse/core';

// components
import ErrorLists from 'Components/sections/ErrorLists.vue';

// toggle issues
const [errorValue, errorToggle] = useToggle();

const tempData = {
  errors: [
    'The activity identifier must be unique for each activity.',
    'The activity identifier must be different to the organization identifier of the reporting organization.',
    'The actual start date of the activity must be before the actual end date.',
    'The transaction value date must not be in the future.',
  ],
  warnings: [
    'The activity identifier must be unique for each activity.',
    'The activity identifier must be different to the organisation identifier of the reporting organisation.',
    'The activity identifier must be unique for each activity.',
  ],
  critical: ['The activity identifier must be unique for each activity.'],
};
</script>

<style lang="scss" scoped>
.validation {
  @apply fixed top-[60px] right-0 max-w-full rounded-tl-lg rounded-bl-lg border transition-all duration-500;
  box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.1);

  &__errorHead {
    @apply w-[212px] border-crimson-20 bg-crimson-10;
    box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.1);
  }

  &__errors {
    @apply flex w-[424px] flex-col overflow-hidden border-white bg-white;
    max-height: calc(100vh - 60px);
  }

  &__heading {
    @apply px-4 py-3;
  }

  &__errors-list {
    @apply grow overflow-y-auto px-4 py-3;
  }

  &__toggle {
    @apply text-xs uppercase leading-normal text-blue-50;
  }
}
</style>
