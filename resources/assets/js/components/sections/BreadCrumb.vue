<template>
  <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
    <div class="flex">
      <a class="font-bold whitespace-nowrap" href="/activities"
        >Your Activities</a
      ><span class="mx-4 separator"> / </span>
      <div class="breadcrumb__title">
        <span class="overflow-hidden breadcrumb__title last text-n-30"
          >DGGF Track 3</span
        ><span class="ellipsis__title--hover w-[calc(100%_+_35px)]"
          >DGGF Track 3</span
        >
      </div>
    </div>
  </nav>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'BreadCrumb',
  components: {},
  props: {
    data: {
      type: String,
      required: false,
      default: 'success',
    },
  },
  setup() {
    return {};
  },
});
</script>
