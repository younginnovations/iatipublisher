<template>
  <div class="my-4 flex flex-wrap items-center gap-2">
    <div
      v-for="(item, index) in pills"
      :key="index"
      class="tooltip-btn"
      :class="active === item.title ? 'active' : ''"
    >
      <button @click="filterBy(item.title, item.searchTerm)">
        <span>{{ item.title }} ({{ item.count ?? 0 }})</span>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
  pills: {
    type: Object,
    required: true,
  },
  reset: {
    type: Boolean,
    required: false,
    default: false,
  },
});

const emit = defineEmits(['filterBy']);

const active = ref(props.pills[0].title || '');

const filterBy = (title: string, code: string) => {
  active.value = title;
  emit('filterBy', code);
};

watch(
  () => props.reset,
  (newVal) => {
    if (newVal) {
      active.value = props.pills[0]?.title || '';
    }
  }
);
</script>
