<template>
  <div class="button primary-btn relative font-bold" @click="toggle">
    <svg-vue icon="plus"></svg-vue>
    <span>Add Activity</span>
    <div
      class="button__dropdown absolute right-0 top-full z-10 w-48 bg-white p-2 shadow-dropdown"
      v-show="visible"
    >
      <ul>
        <li><a href="#" :class="liClass">Add activity manually</a></li>
        <li><a href="#" :class="liClass">Upload activities from .xml</a></li>
        <li><a href="#" :class="liClass">Upload activities from .csv</a></li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'add-activity-button',
  data() {
    return {
      visible: false,
      liClass:
        'block p-2.5 text-n-40 text-tiny leading-[1.5] font-bold hover:text-n-50 hover:bg-n-10',
    };
  },
  methods: {
    toggle() {
      this.visible = !this.visible;
    },
  },
};
</script>
