<template>
  <div>
    <div class="fixed inset-0 z-40 bg-black/20"></div>
    <div
      class="fixed top-[50vh] left-1/2 z-50 w-[500px] max-w-[90%] -translate-y-1/2 -translate-x-1/2 rounded-lg bg-white p-6"
    >
      <h3 class="mb-4 text-lg font-medium">
        <svg-vue icon="alert" class="mr-2 inline text-crimson-40"></svg-vue
        ><span class="font-bold">{{ props.title }}</span>
      </h3>
      <ul class="list-disc rounded-md bg-salmon-10 p-3 font-medium">
        <li v-for="(item, index) in props.message" :key="index" class="my-3 ml-6">
          {{ item }}
        </li>
      </ul>
      <div class="mt-4 flex flex-row-reverse">
        <button
          class="rounded bg-bluecoral py-2 px-5 font-semibold text-white"
          @click="close"
        >
          Close
        </button>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { defineProps, PropType, defineEmits, onMounted, onUnmounted } from "vue";

const emit = defineEmits(["close-popup"]);
const props = defineProps({
  message: { required: true, type: Array as PropType<Array<string>> },
  title: { type: String, required: true },
});
const close = () => {
  emit("close-popup", "closed");
};
onMounted(() => {
  document.documentElement.style.overflow = "hidden";
});
onUnmounted(() => {
  document.documentElement.style.overflow = "auto";
});
</script>
