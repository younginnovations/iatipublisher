<template>
  <div class="page-title mb-6">
    <div class="pb-4 text-caption-c1 text-n-40">
      <Breadcrumb :data="breadcrumbData" />
    </div>
    <div class="flex gap-4 md:items-end">
      <div class="title max-w-[50%] xl:basis-6/12">
        <div class="inline-flex items-center">
          <div v-if="backLink" class="mr-3">
            <a :href="backLink">
              <svg-vue icon="arrow-short-left"></svg-vue>
            </a>
          </div>
          <div class="">
            <h4 class="ellipsis__title relative mr-4 text-2xl font-bold">
              <span class="ellipsis__title overflow-hidden"> {{ title }} </span>
              <span class="ellipsis__title--hover">{{ title }}</span>
            </h4>
          </div>
        </div>
      </div>
      <div class="actions flex grow flex-col items-end justify-end">
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
