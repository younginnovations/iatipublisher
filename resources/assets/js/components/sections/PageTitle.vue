<template>
  <div class="mb-6 page-title">
    <div class="pb-4 text-caption-c1 text-n-40">
      <Breadcrumb :data="breadcrumbData" />
    </div>
    <div class="flex items-end gap-4">
      <div class="title grow-0">
        <div class="inline-flex items-center">
          <div class="mr-3">
            <a :href="backLink">
              <svg-vue icon="arrow-short-left"></svg-vue>
            </a>
          </div>
          <div class="">
            <h4 class="relative mr-4 text-2xl font-bold ellipsis__title">
              <span class="overflow-hidden ellipsis__title">
                {{ title }}
              </span>
              <span class="ellipsis__title--hover">{{ title }}</span>
            </h4>
          </div>
        </div>
      </div>
      <div class="flex flex-col items-end justify-end actions grow">
        <slot />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

// components
import Breadcrumb from 'Components/BreadCrumb.vue';

export default defineComponent({
  name: 'PageTitle',
  components: { Breadcrumb },
  props: {
    breadcrumbData: {
      type: Object,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    backLink: {
      type: String,
      required: true,
    },
  },
  setup() {
    return {};
  },
});
</script>
