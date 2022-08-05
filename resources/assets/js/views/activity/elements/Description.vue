<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="mb-2 text-sm font-bold description-type">
      <span v-if="post.type">
        {{ types.descriptionType[post.type] }}
      </span>
      <span v-else class="italic">Type Not Available</span>
    </div>
    <div
      v-for="(item, i) in post.narrative"
      :key="i"
      :class="{ 'mb-4': i !== post.narrative.length - 1 }"
      class="text-sm description-content"
    >
      <div v-if="item.narrative" class="flex flex-col">
        <span v-if="item.language" class="language mb-1.5">
          (Language: {{ types.languages[item.language] }})
        </span>
        <span v-if="item.narrative" class="max-w-[887px]">
          {{ item.narrative }}
        </span>
      </div>
      <span v-else class="italic">Narrative Not Available</span>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';

export default defineComponent({
  name: 'ActivityDescription',
  components: {},
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface Types {
      descriptionType: [];
      languages: [];
    }
    const types = inject('types') as Types;
    return { types };
  },
});
</script>
