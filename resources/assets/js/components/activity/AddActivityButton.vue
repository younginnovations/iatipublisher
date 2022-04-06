<template>
  <button class="button primary-btn relative font-bold" @click="toggle">
    <svg-vue icon="plus"></svg-vue>
    <span>Add Activity</span>
    <div
      v-if="state.isVisible"
      class="button__dropdown absolute right-0 top-full z-10 w-48 bg-white p-2 text-left shadow-dropdown"
    >
      <ul>
        <li><a href="#" :class="liClass">Add activity manually</a></li>
        <li><a href="#" :class="liClass">Upload activities from .xml</a></li>
        <li><a href="#" :class="liClass">Upload activities from .csv</a></li>
      </ul>
    </div>
  </button>
</template>

<script lang="ts">
import { reactive, defineComponent } from 'vue';

export default defineComponent({
  name: 'add-activity-button',
  components: {},
  setup() {
    const state = reactive({
      isVisible: false,
    });
    const liClass =
      'block p-2.5 text-n-40 text-tiny leading-[1.5] font-bold hover:text-n-50 hover:bg-n-10';

    const toggle = () => {
      state.isVisible = !state.isVisible;
    };

    return { state, liClass, toggle };
  },
});
</script>
