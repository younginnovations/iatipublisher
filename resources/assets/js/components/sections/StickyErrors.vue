<template>
  <div>
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
          <div class="font-bold">{{ errorData.length }} Issues found</div>
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
          <div class="font-bold">
            {{ errorData.length }} Issues found in IATI Validator
          </div>
        </div>
        <button class="validation__toggle" @click="errorToggle()">Hide</button>
      </div>
      <div class="validation__errors-list">
        <div
          v-for="(error, e) in tempData"
          :key="e"
          :class="{ 'mb-4': Number(e) != Object.keys(tempData).length - 1 }"
        >
          <ErrorLists v-if="error.length > 0" :type="e" :errors="error" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { toRefs, reactive, defineProps } from 'vue';
import { useToggle } from '@vueuse/core';

// components
import ErrorLists from 'Components/sections/ErrorLists.vue';

const props = defineProps({
  errorData: { type: Array, required: true },
});

// toggle issues
const [errorValue, errorToggle] = useToggle();

/**
 * list of errors
 **/
interface ErrorInterface {
  category: string;
  context: [];
  id: string;
  identifier: string;
  message: string;
  severity: string;
  title: string;
}
const { errorData } = toRefs(props);
const errorDataProp = errorData.value as ErrorInterface[];

interface TempData {
  errors: string[];
  critical: string[];
  warnings: string[];
}

const tempData: TempData = reactive({
  errors: [],
  critical: [],
  warnings: [],
});

for (const data of errorDataProp) {
  const severity = data.severity;

  switch (severity) {
    case 'critical':
      tempData.critical.push(data.message);
      break;
    case 'error':
      tempData.errors.push(data.message);
      break;
    case 'warning':
      tempData.warnings.push(data.message);
      break;
  }
}
</script>

<style lang="scss" scoped>
.validation {
  @apply rounded-tl-lg rounded-bl-lg border transition-all duration-500;
  box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.1);

  &__errorHead {
    @apply w-[212px] border-crimson-20 bg-crimson-10;
    box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.1);
  }

  &__errors {
    @apply absolute top-0 right-0 z-10 flex w-[424px] flex-col overflow-hidden border-white bg-white;
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
