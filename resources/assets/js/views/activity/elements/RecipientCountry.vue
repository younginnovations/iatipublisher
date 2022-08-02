<template>
  <div
    v-for="(participating_org, key) in data"
    :key="key"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="mb-2 text-sm recipient_country-code">
      <div v-if="participating_org.country_code" class="space-x-1">
        <span>{{ types.country[participating_org.country_code] }}</span>
        <span v-if="participating_org.percentage" class="text-sm font-normal"
          >({{ roundFloat(participating_org.percentage) }}%)</span
        >
      </div>
      <span v-else class="italic">Not Available</span>
    </div>

    <div
      v-for="(item, i) in participating_org.narrative"
      :key="i"
      :class="{ 'mb-4': i !== participating_org.narrative.length - 1 }"
      class="text-sm recipient_country-content"
    >
      <div v-if="item.narrative" class="flex max-w-[887px] flex-col">
        <span v-if="item.language" class="language mb-1.5">
          (Language: {{ types.languages[item.language] }})
        </span>
        <span>{{ item.narrative }}</span>
      </div>
      <span v-else class="italic">Narrative Not Available</span>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';

export default defineComponent({
  name: 'ActivityRecipientCountry',
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface Types {
      country: [];
      languages: [];
    }

    const types = inject('types') as Types;

    function roundFloat(num: string) {
      return parseFloat(num).toFixed(2);
    }

    return { types, roundFloat };
  },
});
</script>
