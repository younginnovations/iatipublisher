<template>
  <div
    v-for="(error, c) in data"
    :key="c"
    class="py-6 item accordion"
    :class="{
      'border-b border-n-20': Number(c) != data.length - 1,
    }"
  >
    <div class="flex items-center accordion-title">
      <a
        :href="`/activity/${error.activity_id}`"
        class="pr-2 activity-title grow text-n-50"
      >
        {{ error.title }}
      </a>
      <div
        v-if="message"
        class="flex mr-2 cursor-pointer shrink-0"
        @click="accordionToggle"
      >
        <span class="text-xs">Show more</span>
        <span>
          <svg-vue
            class="text-xl transition-transform duration-500 text-blue-50"
            icon="arrow-down"
          ></svg-vue>
        </span>
      </div>
      <label class="checkbox shrink-0">
        <input
          v-model="selectedActivities"
          :value="error.activity_id"
          type="checkbox"
        />
        <span class="checkmark" />
      </label>
    </div>

    <div class="accordion-content">
      <div>
        <ul class="mb-2">
          <li>
            <b>{{ errorCount(error.errors) }} {{ message }}</b>
          </li>
        </ul>
        <a
          :href="`/activity/${error.activity_id}`"
          class="inline-flex items-center"
        >
          <span class="mr-1 grow">View the errors and warnings in detail</span>
          <svg-vue class="shrink-0" icon="external"></svg-vue>
        </a>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { defineProps, inject, ref } from 'vue';

defineProps({
  data: { type: Object, required: true },
  message: { type: String, default: '' },
});

const selectedActivities = inject('selectedActivities') as number[];

const toggle = ref(false);

const accordionToggle = (e: Event) => {
  const currentTarget = e.currentTarget as HTMLElement;
  const target = (
    currentTarget.closest('.accordion') as HTMLElement
  ).querySelector<HTMLElement>('.accordion-content');
  const elHeight = target?.querySelector('div')?.clientHeight;

  if (toggle.value) {
    if (target != null) {
      target.style.cssText = `height: ${elHeight}px;`;
      setTimeout(function () {
        target.style.cssText = ``;
      }, 100);
      toggle.value = false;
    }
  } else {
    if (target != null) {
      target.style.cssText = `height: ${elHeight}px;`;

      setTimeout(function () {
        target.style.cssText = `height: auto;`;
      }, 600);

      toggle.value = true;
    }
  }
};

const errorCount = (errors) => {
  let errorCount = '';
  if (errors?.warning) {
    errorCount = `${errors?.error} errors and ${errors?.warning} warnings
     were found.`;
  } else {
    errorCount = `${errors?.critical} critical errors were found.`;
  }

  return errorCount;
};
</script>

<style lang="scss" scoped>
.accordion-content {
  @apply h-0 overflow-hidden transition-all duration-500;
  div {
    @apply mt-4 border-t border-n-20 py-3;
  }
}

.activity-title {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
