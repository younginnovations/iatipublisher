<template>
  <div
    v-for="(participating_org, key) in data"
    :key="key"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="recipient_country-code mb-2 text-sm">
      <div v-if="participating_org.country_code" class="space-x-1">
        <span>{{ types.country[participating_org.country_code] }}</span>
        <span v-if="participating_org.percentage" class="text-sm font-normal"
          >({{ roundFloat(participating_org.percentage) }}%)</span
        >
      </div>
      <span v-else class="italic">{{
        language.common_lang.missing.default
      }}</span>
    </div>

    <div
      v-for="(item, i) in participating_org.narrative"
      :key="i"
      :class="{ 'mb-4': i !== participating_org.narrative.length - 1 }"
      class="recipient_country-content text-sm"
    >
      <div v-if="item.narrative" class="flex max-w-[887px] flex-col">
        <span v-if="item.language" class="language mb-1.5">
          ({{ language.common_lang.language }}:
          {{ types.languages[item.language] }})
        </span>
        <span>{{ item.narrative }}</span>
      </div>
      <span v-else class="italic">{{
        language.common_lang.missing.element.replace(
          ':element',
          language.common_lang.narrative
        )
      }}</span>
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

    const language = window['globalLang'];
    const types = inject('types') as Types;

    function roundFloat(num: string) {
      return parseFloat(num).toFixed(2);
    }

    return { types, roundFloat, language };
  },
});
</script>
