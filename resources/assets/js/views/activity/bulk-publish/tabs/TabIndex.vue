<template>
  <div class="mt-3 rounded-lg border-x border-b border-n-20">
    <div class="flex">
      <div v-for="tab in tabs" :key="tab.value" class="flex-1">
        <button
          class="text-x inline-block w-full flex-1 rounded-t-lg border-b-4 px-6 py-[14px] font-bold uppercase tracking-normal text-n-50"
          :class="[
            activeTab === tab.value
              ? 'active border-bluecoral bg-[#D0DDE0]'
              : 'border-transparent bg-n-10',
          ]"
          @click="handleActiveTab(tab.value)"
        >
          {{ tab.name }}
        </button>
      </div>
    </div>
    <div class="px-6 py-4">
      <slot v-if="activeTab === 1" name="core"> </slot>
      <slot v-if="activeTab === 2" name="deprecated"> </slot>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
const tabs = [
  {
    name: 'Core Elements completeness check',
    value: 1,
  },
  {
    name: 'Deprecated Code Check',
    value: 2,
  },
];
const activeTab = ref(1);

const handleActiveTab = (value: number) => {
  activeTab.value = value;
};
</script>

<style lang="scss" scoped></style>
