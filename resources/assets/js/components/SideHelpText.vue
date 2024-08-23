<template>
  <div v-if="visible" class="fixed right-[2%] top-[22%] z-[50] max-w-[280px]">
    <div
      class="sidebar-help-block sticky top-20 rounded-lg bg-eggshell p-4 text-xs text-n-50"
    >
      <p class="pb-1.5 font-bold text-bluecoral">{{ props.title }}</p>
      <!-- eslint-disable-next-line vue/no-v-html -->
      <div class="space-y-1.5" v-html="content"></div>
    </div>
    <button class="absolute top-3 right-4" @click="closeSidebar">
      <svg-vue icon="cancel-cross" />
    </button>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  content: {
    type: String,
    required: true,
  },
  visible: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits(['close']);

const closeSidebar = () => {
  emit('close');
};
</script>
