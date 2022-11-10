<template>
  <div
    class="sidebar-help-block sticky top-5 hidden rounded-lg bg-eggshell p-4 text-xs text-n-50"
    style="box-shadow: 0px 4px 40px rgb(0 0 0 / 10%)"
  >
    <div class="sidebar-help-close absolute right-2 top-2.5 cursor-pointer">
      <svg
        width="16"
        height="16"
        viewBox="0 0 16 16"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M8.704 7.764 8.468 8l.236.236 4.2 4.193.001.001a.333.333 0 0 1 0 .473l-.002.002a.336.336 0 0 1-.365.073.334.334 0 0 1-.108-.073l-4.194-4.2L8 8.468l-.236.237-4.193 4.2H3.57a.335.335 0 0 1-.365.073.335.335 0 0 1-.108-.073l-.002-.002a.334.334 0 0 1 0-.473l4.2-4.194L7.532 8l-.237-.236-4.2-4.193a.336.336 0 0 1 .476-.475l4.193 4.2.236.236.236-.236 4.193-4.2a.336.336 0 1 1 .475.475l-4.2 4.193Z"
          fill="#68797E"
          stroke="#68797E"
          stroke-width="0.666667"
        />
      </svg>
    </div>
    <div class="sidebar-help-block-text space-y-1.5"></div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'SidebarHelpBlock',
  setup() {
    return {};
  },
});
</script>
